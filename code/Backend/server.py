#!/usr/bin/python
# -*- coding: utf-8 -*-

import math
import numpy as np
import json
import pickle
import os.path
from os import path
import shutil
import subprocess
import pymongo

import pandas as pd
from pulp import *
import excelrd
from flask import Flask, request, jsonify
from flask_cors import CORS
import mysql.connector

app = Flask(__name__)
CORS(app)

UPLOAD_FOLDER = 'Backend'
ALLOWED_EXTENSIONS = {'xlsx', 'xls'}

app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER


def connect_to_database():
    host = 'localhost'
    user = 'root'
    password = ''
    database = 'code'
    connection = mysql.connector.connect(
        host=host, user=user, password=password, database=database
    )
    return connection


def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS


@app.route('/')
def hello():
    return 'Hi, PDS!'


@app.route('/get_users', methods=['GET'])
def get_users():
    if request.method == 'GET':
        connection = connect_to_database()
        user_list = []

        if connection.is_connected():
            cursor = connection.cursor()
            query = 'SELECT * FROM login WHERE 1'
            cursor.execute(query)
            user = cursor.fetchall()
            connection.close()

            if user:
                for row in user:
                    temp = {'username': row[0], 'password': row[1], '_id': row[2]}
                    user_list.append(temp)
                return jsonify(user_list)
            else:
                return jsonify(user_list)
        else:
            return jsonify(user_list)

@app.route('/extract_db', methods=['POST'])
def extract_db():
    if request.method == 'POST':
        connection = connect_to_database()
        warehouse_data = []
        fps_data = []
        all_data = {}

        if connection.is_connected():
            cursor = connection.cursor()
            query = 'SELECT * FROM warehouse WHERE 1'
            cursor.execute(query)
            user = cursor.fetchall()
            
            if user:
                for row in user:
                    temp = {'State Name':'','WH_District': row[0], 'WH_Name': row[1], 'WH_ID': row[2], 'Type of WH': row[3], 'WH_Lat': row[5], 'WH_Long': row[6], 'Storage_Capacity': row[7], 'Owned/Rented':'', 'Quantity of Wheat stored (Quintals)':''}
                    warehouse_data.append(temp)
                    
            cursor = connection.cursor()
            query = 'SELECT * FROM fps WHERE 1'
            cursor.execute(query)
            user = cursor.fetchall()
            connection.close()

            if user:
                for row in user:
                    temp = {'State Name':'','FPS_District': row[0], 'FPS_Name': row[1], 'FPS_ID': row[2], 'Motorable/Non-Motorable': row[3], 'FPS_Lat': row[5], 'FPS_Long': row[6], 'Allocation_Wheat': row[4], 'FPS_Tehsil':''}
                    fps_data.append(temp)
                
            all_data["warehouse"] = warehouse_data
            all_data["fps"] = fps_data
            json_file_path = 'output.json'
            with open(json_file_path, 'w') as json_file:
                json.dump(all_data, json_file, indent=2)
        else:
            json_file_path = 'output.json'
            with open(json_file_path, 'w') as json_file:
                json.dump(all_data, json_file, indent=2)
        
        json_file_path = 'output.json'
        with open(json_file_path, 'r') as json_file:
            data = json.load(json_file)

        wh = pd.DataFrame(data['warehouse'])
        fps = pd.DataFrame(data['fps'])
        wh = wh.loc[:,["State Name","WH_District",'WH_Name',"WH_ID","Type of WH",'WH_Lat',"WH_Long","Storage_Capacity","Owned/Rented","Quantity of Wheat stored (Quintals)"]]
        fps = fps.loc[:,["State Name","FPS_District",'FPS_Name',"FPS_ID","Motorable/Non-Motorable",'FPS_Lat',"FPS_Long","Allocation_Wheat","FPS_Tehsil"]]

        # Rename the columns to make them valid Python identifiers
        column_mapping = {
            'Type of WH': 'Type of WH ( SWC, CWC, FCI, CAP, other)',
            'Storage_Capacity': 'Storage_Capacity',
            'WH_District': 'WH_District',
            'WH_ID': 'WH_ID',
            'WH_Lat': 'WH_Lat',
            'WH_Long': 'WH_Long',
            'WH_Name': 'WH_Name'
        }

        wh.rename(columns=column_mapping, inplace=True)

        # Save DataFrames to Excel file
        with pd.ExcelWriter('Backend//Data_1.xlsx') as writer:
            wh.to_excel(writer, sheet_name='A.1 Warehouse', index=False)
            fps.to_excel(writer, sheet_name='A.2 FPS', index=False)


        
        
        
        return {"success":1}
    
@app.route('/uploadConfigExcel', methods=['POST'])
def upload_config_excel():
    data = {}
    try:
        file = request.files['uploadFile']
        if file and allowed_file(file.filename):
            file_path = os.path.join(app.config['UPLOAD_FOLDER'], 'Data_1.xlsx')
            os.makedirs(app.config['UPLOAD_FOLDER'], exist_ok=True)
            file.save(file_path)
            data['status'] = 1
            df = pd.read_excel(file_path)
        else:
            data['status'] = 0
            data['message'] = 'Invalid file. Only .xlsx or .xls files are allowed.'
    except Exception as e:
        data['status'] = 0
        data['message'] = 'Error uploading file'
        
        
    input=pd.ExcelFile('Backend//Data_1.xlsx')
    node1=pd.read_excel(input,sheet_name="A.1 Warehouse")
    node2=pd.read_excel(input,sheet_name="A.2 FPS")
    dist=[[0 for a in range(len(node2["FPS_ID"]))] for b in range(len(node1["WH_ID"]))]
    phi_1=[]
    phi_2=[]
    delta_phi=[]
    delta_lambda=[]
    R = 6371 

    for i in node1.index:
        for j in node2.index:
            phi_1=math.radians(node1["WH_Lat"][i])
            phi_2=math.radians(node2["FPS_Lat"][j])
            delta_phi=math.radians(node2["FPS_Lat"][j]-node1["WH_Lat"][i])
            delta_lambda=math.radians(node2["FPS_Long"][j]-node1["WH_Long"][i])
            x=math.sin(delta_phi / 2.0) ** 2 + math.cos(phi_1) * math.cos(phi_2) * math.sin(delta_lambda / 2.0) ** 2
            y=2 * math.atan2(math.sqrt(x), math.sqrt(1 - x))
            dist[i][j]=R*y
            
    dist=np.transpose(dist)
    #print("shallu")
    df3 = pd.DataFrame(data = dist, index = node2['FPS_ID'], columns = node1['WH_ID'])
    #print("shallu1")
    df3.to_excel('Backend//Distance_Matrix.xlsx', index=True)
    #print("shallu2")
    return jsonify(data)
    
    



@app.route('/getfcidata', methods=['POST'])
def fci_data():
    try:
        usn = pd.ExcelFile('Backend//Data_1.xlsx')
        fci = pd.read_excel(usn, sheet_name='A.1 Warehouse', index_col=None)
        fps = pd.read_excel(usn, sheet_name='A.2 FPS', index_col=None)

        warehouse_no = fci['WH_ID'].nunique()
        fps_no = fps['FPS_ID'].nunique()
        total_demand = int(fps['Allocation_Wheat'].sum())
        total_supply = int(fci['Storage_Capacity'].sum())

        result = {'Warehouse_No': warehouse_no, 'FPS_No': fps_no, 'Total_Demand': total_demand, 'Total_Supply': total_supply}
        return jsonify(result)
    except Exception as e:
        return jsonify({'status': 0, 'message': str(e)})


@app.route('/getGraphData', methods=['POST'])
def graph_data():
    try:
        usn = pd.ExcelFile('Backend//Data_1.xlsx')
        FCI = pd.read_excel(usn, sheet_name='A.1 Warehouse', index_col=None)
        FPS = pd.read_excel(usn, sheet_name='A.2 FPS', index_col=None)

        
        District_Capacity = {}
        for i in range(len(FCI["WH_District"])):
            District_Name = FCI["WH_District"][i]
            if District_Name not in District_Capacity:
                District_Capacity[District_Name] = int(FCI["Storage_Capacity"][i])
            else:
                District_Capacity[District_Name] += int(FCI["Storage_Capacity"][i])
        #print(District_Capacity)
         
        
            
        District_Demand = {}
        for i in range(len(FPS["FPS_District"])):
            District_Name_FPS = FPS["FPS_District"][i]
            if District_Name_FPS not in District_Demand:
                District_Demand[District_Name_FPS] = int(FPS["Allocation_Wheat"][i])
            else:
                District_Demand[District_Name_FPS] += int(FPS["Allocation_Wheat"][i])
        #print(District_Demand)      
          
        # District_Demand = {k: int(v) for k, v in District_Demand.items()}

        #print(District_Demand)
        #print(District_Capacity)
        #print(District_Name_1)    

        District_Name_1 = {}
        District_Name = []
        District_Name2=[]
        for i in District_Demand:
            if i in District_Capacity and District_Demand[i] >= District_Capacity[i]:
                District_Name.append(i)
            #print(District_Name)     
        
        #print(District_Demand)
        #print(District_Capacity)       
        for i in District_Demand:
            #print(i)
            if i not in District_Capacity:
                District_Name2.append(i)
                #print(i)
                District_Name.append(District_Name2)
            District_Name_1['District_Name'] = District_Name
            
        #print("Here")
        
        combined_data = {'District_Demand': District_Demand, 'District_Capacity': District_Capacity, 'District_Name_1': District_Name_1}
        #print(District_Demand)
        #print(District_Capacity)
        #print(District_Name_1)
        
        return jsonify(combined_data)
    except Exception as e:
        return jsonify({'status': 0, 'message': str(e)})



#@app.route('/saveToDatabase', methods=['POST'])
def save_to_database():
    connection = connect_to_database()
    if connection.is_connected():
        cursor = connection.cursor()
        excel_file_path = 'Backend//Result_Sheet.xlsx'
        columns_to_fetch = ['From_District', 'From_ID', 'From_Name', 'To_District', 'To_ID', 'To_Name']
        df = pd.read_excel(excel_file_path)
        selected_data = df[columns_to_fetch]
        sql = 'DELETE FROM optimiseddata';
        cursor.execute(sql)
        for (index, row) in selected_data.iterrows():
            sql = 'INSERT INTO optimiseddata (from_district, from_id, from_name, to_district, to_id, to_name) VALUES (%s, %s, %s, %s, %s, %s)'
            
            values = tuple(row)
            cursor.execute(sql, values)
        connection.commit()

    if connection.is_connected():
        cursor.close()
        connection.close()
    return jsonify({'status': 1})


@app.route('/processFile', methods=['POST'])
def processFile():
    message = 'DataFile file is incorrect'
    try:
        USN = pd.ExcelFile('Backend//Data_1.xlsx')
        
    except Exception as e:
        data = {}
        data['status'] = 0
        data['message'] = message
        json_data = json.dumps(data)
        json_object = json.loads(json_data)
        return json.dumps(json_object, indent=1)
    
    
    input=pd.ExcelFile('Backend//Data_1.xlsx')
    node1=pd.read_excel(input,sheet_name="A.1 Warehouse")
    node2=pd.read_excel(input,sheet_name="A.2 FPS")

    node1=pd.read_excel(input,sheet_name="A.1 Warehouse")
    node2=pd.read_excel(input,sheet_name="A.2 FPS")
    dist=[[0 for a in range(len(node2["FPS_ID"]))] for b in range(len(node1["WH_ID"]))]
    phi_1=[]
    phi_2=[]
    delta_phi=[]
    delta_lambda=[]
    R = 6371 

    for i in node1.index:
        for j in node2.index:
            phi_1=math.radians(node1["WH_Lat"][i])
            phi_2=math.radians(node2["FPS_Lat"][j])
            delta_phi=math.radians(node2["FPS_Lat"][j]-node1["WH_Lat"][i])
            delta_lambda=math.radians(node2["FPS_Long"][j]-node1["WH_Long"][i])
            x=math.sin(delta_phi / 2.0) ** 2 + math.cos(phi_1) * math.cos(phi_2) * math.sin(delta_lambda / 2.0) ** 2
            y=2 * math.atan2(math.sqrt(x), math.sqrt(1 - x))
            dist[i][j]=R*y
            
    dist=np.transpose(dist)
    #print("shallu")
    df3 = pd.DataFrame(data = dist, index = node2['FPS_ID'], columns = node1['WH_ID'])
    #print("shallu1")
    df3.to_excel('Backend//Distance_Matrix.xlsx', index=True)

    WKB = excelrd.open_workbook('Backend//Distance_Matrix.xlsx')
    Sheet1 = WKB.sheet_by_index(0)
    FCI = pd.read_excel(USN, sheet_name='A.1 Warehouse', index_col=None)
    FPS = pd.read_excel(USN, sheet_name='A.2 FPS', index_col=None)

    FCI['WH_District'] = FCI['WH_District'].apply(lambda x: x.replace(' ', ''))
    FPS['FPS_District'] = FPS['FPS_District'].apply(lambda x: x.replace(' ', ''))

    Warehouse_No = []
    FPS_No = []
    Warehouse_No = FCI['WH_ID'].nunique()
    FPS_No = FPS['FPS_ID'].nunique()
    Warehouse_Count = {}

    FPS_Count = {}
    Warehouse_Count['Warehouse_Count'] = Warehouse_No
    FPS_Count['FPS_Count'] = FPS_No  # No of FPS

    Total_Supply = []
    Total_Supply_Warehouse = {}
    Total_Supply = FCI['Storage_Capacity'].sum()
    Total_Supply_Warehouse['Total_Supply_Warehouse'] = Total_Supply  # Total SUPPLY

    Total_Demand = []
    Total_Demand_FPS = {}
    Total_Demand = FPS['Allocation_Wheat'].sum()
    Total_Demand_FPS['Total_Demand_Warehouse'] = Total_Demand  # Total demand

    FCI_district = []
    FCI_Data = {}
    Disrticts_FCI = {}

    for (i, j) in zip(FCI['WH_District'], FCI['WH_ID']):
        i = i.lower()
        if i not in FCI_district:
            FCI_district.append(i)
            globals()['FCI_' + str(i)] = []
        globals()['FCI_' + str(i)].append(j)
    for i in FCI_district:
        FCI_Data[i] = globals()['FCI_' + str(i)]
    Disrticts_FCI['Disrticts_FCI'] = FCI_district

    District_Capacity = {}
    for i in range(len(FCI['WH_District'])):
        District_Name = FCI['WH_District'][i]
        if District_Name not in District_Capacity:
            District_Capacity[District_Name] = FCI['Storage_Capacity'][i]
        else:
            District_Capacity[District_Name] = FCI['Storage_Capacity'][i] + District_Capacity[District_Name]

    FPS_district = []
    FPS_Data = {}
    Districts_FPS = {}
    for (i, j) in zip(FPS['FPS_District'], FPS['FPS_Tehsil']):
        i = i.lower()
        if i not in FPS_district:
            FPS_district.append(i)
            globals()['FPS_' + str(i)] = []
        if j not in globals()['FPS_' + str(i)]:
            globals()['FPS_' + str(i)].append(j)
    for i in FPS_district:
        FPS_Data[i] = globals()['FPS_' + str(i)]
        Districts_FPS['Districts_FPS'] = FPS_district

    District_Demand = {}
    for i in range(len(FPS['FPS_District'])):
        District_Name_FPS = FPS['FPS_District'][i]
        if District_Name_FPS not in District_Demand:
            District_Demand[District_Name_FPS] = FPS['Allocation_Wheat'][i]
        else:
            District_Demand[District_Name_FPS] = FPS['Allocation_Wheat'][i] + District_Demand[District_Name_FPS]

    FCI_district = []
    FCI_Data = {}
    Disrticts_FCI = {}
    Data_state_wise = {}
    Data_statewise = {}

    for (i, j) in zip(FCI['WH_District'], FCI['WH_ID']):
        i = i.lower()
        if i not in FCI_district:
            FCI_district.append(i)
            globals()['FCI_' + str(i)] = []
        globals()['FCI_' + str(i)].append(j)
    for i in FCI_district:
        FCI_Data[i] = globals()['FCI_' + str(i)]
    Disrticts_FCI['Disrticts_FCI'] = FCI_district

    FPS_district = []
    FPS_Data = {}
    Districts_FPS = {}
    for (i, j) in zip(FPS['FPS_District'], FPS['FPS_Tehsil']):
        i = i.lower()
        if i not in FPS_district:
            FPS_district.append(i)
            globals()['FPS_' + str(i)] = []
        if j not in globals()['FPS_' + str(i)]:
            globals()['FPS_' + str(i)].append(j)
    for i in FPS_district:
        FPS_Data[i] = globals()['FPS_' + str(i)]
    Districts_FPS['Districts_FPS'] = FPS_district

    model = LpProblem('Supply-Demand-Problem', LpMinimize)

    Variable1 = []
    Variable2 = []
    for i in range(len(FCI['WH_ID'])):
        for j in range(len(FPS['FPS_ID'])):
            Variable1.append(str(FCI['WH_ID'][i]) + '_'
                             + str(FCI['WH_District'][i]) + '_'
                             + str(FPS['FPS_ID'][j]) + '_'
                             + str(FPS['FPS_District'][j]) + '_Wheat')

    # Variables for Wheat from lEVEL2 TO FPS

    DV_Variables1 = LpVariable.matrix('X', Variable1, cat='float',
            lowBound=0)
    Allocation1 = np.array(DV_Variables1).reshape(len(FCI['WH_ID']),
            len(FPS['FPS_ID']))

    Variable1I = []
    Allocation1I = []
    for i in range(len(FCI['WH_ID'])):
        for j in range(len(FPS['FPS_ID'])):
            Variable1I.append(str(FCI['WH_ID'][i]) + '_'
                              + str(FCI['WH_District'][i]) + '_'
                              + str(FPS['FPS_ID'][j]) + '_'
                              + str(FPS['FPS_District'][j]) + '_Wheat1')

#    Variables for Wheat from IG TO FPS

    DV_Variables1I = LpVariable.matrix('X', Variable1I, cat='Binary',lowBound=0)
    Allocation1I = np.array(DV_Variables1I).reshape(len(FCI['WH_ID']),len(FPS['FPS_ID']))

    for i in range(len(FPS['FPS_ID'])):
         model += lpSum(Allocation1I[k][i] for k in range(len(FCI['WH_ID']))) <= 1

    for i in range(len(FCI['WH_ID'])):
         for j in range(len(FPS['FPS_ID'])):
            model += Allocation1[i][j] <= 1000000 * Allocation1I[i][j]
    
    District_More_Demand={}
    District_Name_Demand=[]
    for i in District_Demand:
        if i not in District_Capacity:
            print("Not exist")
        else:
            if District_Capacity[i]<=District_Demand[i]:
                District_Name_Demand.append(i)
        District_More_Demand["District_Name"] =District_Name_Demand   


    District_More_Capacity={}
    District_Name_Capacity=[]
    for i in District_Demand:
        if i not in District_Capacity:
            print("Not exist")
        else:
            if District_Capacity[i]>=District_Demand[i]:
                District_Name_Capacity.append(i)
            District_More_Capacity["District_Name"] =District_Name_Capacity
            
                
    
    
   

    Tehsil = {}
    UniqueId = 0
    Tehsil_temp = []
    Tehsil_rev = {}

    for i in FPS['FPS_Tehsil']:
        Tehsil_temp.append(i)
        if i not in Tehsil:
            Tehsil[i] = UniqueId
            Tehsil_rev[UniqueId] = i
            UniqueId = UniqueId + 1

    Tehsil_FPS = []
    for i in range(len(FPS['FPS_ID'])):
        Tehsil_FPS.append(Tehsil[Tehsil_temp[i]])

    PC_Mill = []
    for col in range(Sheet1.nrows):
        if col==0:
            continue
        temp = []
        for row in range (Sheet1.ncols):
            if row==0:
                continue
            temp.append(Sheet1.cell_value(col,row))
        PC_Mill.append(temp)

    FCI_FPS = [[ PC_Mill[j][i] for j in range(len( PC_Mill))] for i in range(len( PC_Mill[0]))]

    allCombination1 = []

    for i in range(len(FCI_FPS)):
        for j in range(len(FPS['FPS_ID'])):
            allCombination1.append(Allocation1[i][j] * FCI_FPS[i][j])

    model += lpSum(allCombination1)

    # Demand Constraints for Wheat

    for i in range(len(FPS['FPS_ID'])):
        model += lpSum(Allocation1[j][i] for j in range(len(FCI['WH_ID'
                       ]))) >= FPS['Allocation_Wheat'][i]

    # Supply Constraints for Warehouses

    for i in range(len(FCI['WH_ID'])):
        model += lpSum(Allocation1[i][j] for j in range(len(FPS['FPS_ID'
                       ]))) <= FCI['Storage_Capacity'][i]

   # Calling CBC_CMB Solver

    #model.solve(CPLEX_CMD(options=['set mip tolerances mipgap 0.01']))
    #model.prob.solve(CPLEX_CMD(options=[“set mip tolerances mipgap 0.03”,“set emphasis memory y”]))
    model.solve(CPLEX_CMD(options=['set mip tolerances mipgap 0.03',"set emphasis memory y"]))
    Status = LpStatus[model.status]

    Original_Cost = 100000000
    total = Original_Cost

    data = {}
    #data['status'] = 1
    #data['modelStatus'] = Status
    #data['totalCost'] = float(round(model.objective.value(),1))
    #data['original'] = float(round(total, 2))
    #data['percentageReduction'] = float(round((total
            #- model.objective.value()) / total, 4) * 100)
    #data['Average_Distance'] = float(round(model.objective.value(), 2)) / Total_Demand
    #data['Demand'] = int(FPS['Allocation_Wheat'].sum())

    BGW = {}
    BGR = {}
    IGW = {}
    IGR = {}
    FCIW = {}

    BGCapacity = {}

    temp = {}
    for i in range(len(FCI['WH_ID'])):
        temp[str(FCI['WH_ID'][i])] = str(FCI['Storage_Capacity'])
    BGCapacity = temp

    temp1 = {}
    BG_FPS = [[] for i in range(len(Tehsil))]
    for i in range(len(FCI['WH_ID'])):
        for j in range(len(FPS['FPS_ID'])):
            BG_FPS[Tehsil_FPS[j]].append(Allocation1[i][j].value())
        temp1[str(FCI['WH_ID'][i])] = \
            str(lpSum(Allocation1[i][j].value() for j in
                range(len(FPS['FPS_ID']))))
        BGCapacity[str(FCI['WH_ID'][i])] = str(FCI['Storage_Capacity'
                ][i])
    BGW['FPS'] = temp1

    BG_FPS_Wheat = {}
    for i in range(len(Tehsil)):
        BG_FPS_Wheat[str(Tehsil_rev[i])] = str(lpSum(BG_FPS[i]))

    BG_FPS_Rice = {}
    for i in range(len(Tehsil)):
        BG_FPS_Rice[str(Tehsil_rev[i])] = str(lpSum(BG_FPS[i]))

    data['BGW'] = BGW
    data['BGR'] = BGR
    data['FPSW'] = BG_FPS_Wheat
    data['FPSR'] = BG_FPS_Rice
    data['BGCapacity'] = BGCapacity

    wheat_total_dict = data['BGW']['FPS']

    wheat_total = 0
    for value in wheat_total_dict:
        if float(wheat_total_dict[value]):
            wheat_total = int(wheat_total + float(wheat_total_dict[value]))

    total_commodity = int(wheat_total)

    Output_File = open('Backend//Inter_District1.csv', 'w')
    for v in model.variables():
        if v.value() > 0:
            Output_File.write(v.name + '\t' + str(v.value()) + '\n')

    Output_File = open('Backend//Inter_District1.csv', 'w')
    for v in model.variables():
        if v.value() > 0:
            Output_File.write(v.name + '\t' + str(v.value()) + '\n')

    df9 = pd.read_csv('Backend//Inter_District1.csv')
    df9.columns = ['Tagging']
    df9[[
        'Var',
        'WH_ID',
        'W_D',
        'FPS_ID',
        'FPS_D',
        'Commodity_Value',
        ]] = df9[df9.columns[0]].str.split('_', n=6, expand=True)
    del df9[df9.columns[0]]
    df9[['Commodity', 'Values']] = df9['Commodity_Value'
            ].str.split('\\t', n=1, expand=True)
    del df9['Commodity_Value']
    df9 = df9.drop(np.where(df9['Commodity'] == 'Wheat1')[0])
    df9.to_excel('Backend//Tagging_Sheet_Pre.xlsx', sheet_name='BG_FPS')
    df3 = pd.read_excel('Backend//Tagging_Sheet_Pre.xlsx')
    df4 = pd.merge(df3, FCI, on='WH_ID', how='inner')
    df4 = df4[[
        'WH_ID',
        'WH_Name',
        'WH_District',
        'WH_Lat',
        'WH_Long',
        'FPS_ID',
        'Values',
        ]]
    df4 = pd.merge(df4, FPS, on='FPS_ID', how='inner')
    df5 = df4[[
        'WH_ID',
        'WH_Name',
        'WH_District',
        'WH_Lat',
        'WH_Long',
        'FPS_ID',
        'FPS_Name',
        'FPS_District',
        'FPS_Lat',
        'FPS_Long',
        'Values',
        ]]
    df5.insert(0, 'Scenario', 'Optimized')
    df5.insert(1, 'From', 'Depot')
    df5.insert(2, 'From_State', 'Punjab')
    df5.insert(7, 'To', 'FPS')
    df5.insert(8, 'To_State', 'Punjab')
    df5.insert(9, 'Commodity', 'Wheat')
    df5.rename(columns={
        'WH_ID': 'From_ID',
        'WH_Name': 'From_Name',
        'WH_Lat': 'From_Lat',
        'WH_Long': 'From_Long',
        }, inplace=True)
    df5.rename(columns={
        'FPS_ID': 'To_ID',
        'FPS_Name': 'To_Name',
        'FPS_Lat': 'To_Lat',
        'FPS_Long': 'To_Long',
        }, inplace=True)
    df5.rename(columns={'WH_District': 'From_District',
               'FPS_District': 'To_District'}, inplace=True)
    df5 = df5.loc[:, [
        'Scenario',
        'From',
        'From_State',
        'From_District',
        'From_ID',
        'From_Name',
        'From_Lat',
        'From_Long',
        'To',
        'To_ID',
        'To_Name',
        'To_State',
        'To_District',
        'To_Lat',
        'To_Long',
        'Commodity',
        'Values',
        ]]
    #df5['From_ID'] = df5['From_ID'].astype(int)
    #df5['To_ID'] = df5['To_ID'].astype(float).round()
    #print(df5["To_ID"])
    #df5['To_ID'] = pd.to_numeric(df5['To_ID'], errors='coerce').astype("Int64")
    #print(df5)
    df5.to_excel('Backend//Result_Sheet.xlsx',
                 sheet_name='Warehouse_FPS')
    
    data["Scenario"]="Intra"
    #print(data["Scenario"])
    data["WH_Used"]=df5['From_ID'].nunique()
    data["FPS_Used"]=df5['To_ID'].nunique()
    #data[""]=df5['Values'].sum()
    data['Total_QKM'] = float(round(model.objective.value(), 2))
    #data['original'] = float(round(total, 2))
    #data['percentageReduction'] = float(round((total- model.objective.value()) / total, 4) * 100)
    data['Average_Distance'] = float(round(model.objective.value(), 2)) / Total_Demand
    data['Demand'] = int(FPS['Allocation_Wheat'].sum())
                 
    save_to_database()

    file_open = open('Level5.txt', 'w')
    file_open.write('scale 600 width\n')
    file_open.write('scale 400 height\n')
    file_open.write('skinparam sequenceMessageAlign center\n')
    file_open.write('skinparam sequenceArrowThickness 3\n')
    file_open.write('skinparam backgroundColor #FFFFFF\n')
    file_open.write('hide footbox\n')
    file_open.write('title <font color=#000000 size=20> Allocation Movement \n'
                    )
    file_open.write('skinparam sequence{\n')
    file_open.write('ParticipantBorderColor none\n')
    file_open.write('ParticipantBackgroundColor #004699\n')
    file_open.write('ParticipantFontName calibri\n')
    file_open.write('ParticipantFontSize 15\n')
    file_open.write('ParticipantFontColor #ffffff\n')
    file_open.write('}\n')

    file_open.write('participant "FCI\\n<size:40><&globe>" as FCI order  1 \n'
                    )
    file_open.write('participant "FPS\\n<size:40><&vertical-align-top>" as FPS order 2 \n'
                    )

    file_open.write('participant "FCI\\n<size:40><&globe>" as FCI order  1 \n'
                    )
    file_open.write('participant "FPS\\n<size:40><&vertical-align-top>" as FPS order 2 \n'
                    )
    file_open.write('FCI -[#32a8a0]> FPS: <font color=#0915ed> '
                    + str(total_commodity) + ' \n')
    file_open.write('hnote over FCI, FPS #ffffff: ' + str(wheat_total)
                    + ',' + ' Qtl Wheat \n')
    file_open.close()
    command = 'python -m plantuml Level5.txt'
    subprocess.run(command, shell=True)

    json_data = json.dumps(data)
    json_object = json.loads(json_data)

    if os.path.exists('ouputPickle.pkl'):
        os.remove('ouputPickle.pkl')

    # open pickle file
    dbfile1 = open('ouputPickle.pkl', 'ab')

    # save pickle data
    pickle.dump(json_object, dbfile1)
    dbfile1.close()
    data['status'] = 1
    json_data = json.dumps(data)
    json_object = json.loads(json_data)
    return json.dumps(json_object, indent=1)

if __name__ == '__main__':
    app.run(debug=True)
