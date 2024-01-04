<?php
require('util/Connection.php');
require('util/SessionCheck.php');
require('Header.php');

$query = "SELECT from_district FROM optimiseddata WHERE 1";
$result = mysqli_query($con,$query);
$totalids = mysqli_num_rows($result);

$query = "SELECT reviewed FROM optimiseddata WHERE 1 AND reviewed='yes'";
$result = mysqli_query($con,$query);
$totalidsreviewed = mysqli_num_rows($result);

$query = "SELECT new_id FROM optimiseddata WHERE new_id<>''";
$result = mysqli_query($con,$query);
$totalidsrequested = mysqli_num_rows($result);

$query = "SELECT approve FROM optimiseddata WHERE approve='yes'";
$result = mysqli_query($con,$query);
$totalidsapproved = mysqli_num_rows($result);
?>
<style>
        body {
            font-size: 15px; /* Set the base font size for the entire page */
        }

        /* Apply increased font size to specific elements */
        h3 {
            font-size: 24px; /* Increase font size for heading elements */
        }

        /* You can add similar styles for other elements as needed */
        /* For example: */
        th
        td {
            font-size: 18px; /* Increase font size for table headers and data cells */
        }

        .btn {
            font-size: 16px; /* Increase font size for buttons */
        }

        /* Add more styles for different elements as needed */
		/* Custom CSS to override Bootstrap styles for table header background */
/* Override background color for thead only */
.table thead tr th {
    background-color: #95b75d !important;
    /* border: 2px solid #777; */
    color: black;
    /* Optional: Font size for table header */
}

th,
td {
    border: 2px solid black;
    padding: 25px;
    text-align: center;
	color: black;
	border-color: black !important;
	
}

tr {
    border: 2px solid black; /* Set border for table rows */
}
.table > tfoot > tr > td {
    border-color: black !important;
    border-width: 2px !important;
}


/* Apply background color to even rows */
#export_table tbody tr:nth-child(even) {
    background-color: #FCAC9E;
}


    </style>
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Punjab Intra Route Optimization For PDS</li>
                </ul>
                <!-- END BREADCRUMB -->

                <div class="page-content-wrap">

                    <div class="row">
                        <div class="col-md-12">

                            <!-- START SIMPLE DATATABLE -->
                            <div class="panel panel-default">
								<div class="panel-heading">
                                    <h3 class="panel-title">Punjab Intra Route Optimization For PDS District</b></h3>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-3 mb-4">
									<div class="card h-100"
										style="background-color:#56A5FF; color:white; padding:20px; font-weight: bold;">
										<div style="font-size:25px"><?php echo $totalids; ?></div>
										<div style="font-size:15px">TOTAL TAGS</div>
									</div>
								</div>
								<div class="col-md-3 mb-4">
									<div class="card h-100"
										style="background-color:#3FDBBC; color:white; padding:20px; font-weight: bold;">
										<div style="font-size:25px"><?php echo $totalidsreviewed; ?></div>
										<div style="font-size:15px">TOTAL REVIEWED BY DISTRCTS</div>
									</div>
								</div>
								<div class="col-md-3 mb-4">
									<div class="card h-100"
										style="background-color:#FFC167; color:white; padding:20px; font-weight: bold;">
										<div style="font-size:25px"><?php echo $totalidsrequested; ?></div>
										<div style="font-size:15px">TOTAL TAGS CHANGE REQUESTED</div>
									</div>
								</div>
								<div class="col-md-3 mb-4">
									<div class="card h-100"
										style="background-color:#F96981; color:white; padding:20px; font-weight: bold;">
										<div style="font-size:25px"><?php echo $totalidsapproved; ?></div>
										<div style="font-size:15px">TOTAL TAGS APPROVED</div>
									</div>
								</div>
							</div>
							</br></br></br>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label">Reviewed by District</label>
										<div class="col-md-9">  
											<div class="input-group">
											<span class="input-group-addon"><span class="fa fa-certificate"></span></span>						
											<select class="form-control select" onClick="fetchDataFromServer()" id="reviewed" name="reviewed" style="z-index:9999">
												<option value=''>Select</option>
												<option value='reviewed'>Reviewed</option>
												<option value='notreviewed'>Not Reviewed</option>
											</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label">Approved</label>
										<div class="col-md-9">  
											<div class="input-group">
											<span class="input-group-addon"><span class="fa fa-certificate"></span></span>						
											<select class="form-control select" onClick="fetchDataFromServer()" id="approved" name="approved" style="z-index:9999">
												<option value=''>Select</option>
												<option value='approved'>Admin Approved</option>
												<option value='notapproved'>Admin not Approved</option>
											</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							</br></br></br>
                            <!-- END SIMPLE DATATABLE -->
							<table id="export_table" class="table">
								
							<thead>
                                            <tr>
											<th class="green" style="font-size:15px">From District</th>
            <th class="green" style="font-size:15px">From ID</th>
            <th class="green" style="font-size:15px">From Name</th>
            <th class="red" style="font-size:15px">To District</th>
            <th class="red" style="font-size:15px">To ID</th>
            <th class="red" style="font-size:15px">To Name</th>
												<th style="font-size:15px">District Verification</th>
												<th style="font-size:15px">District Suggest Warehouse</th>
                                                <th style="font-size:15px">Approve/Not Approve</th>
                                            </tr>
                                        </thead>
										<tbody id="table_body">
										
										</tbody>
										<input type="hidden" id="district" name="district" value="<?php echo $district ?>" />
										<button class="btn btn-primary pull-right"  style="margin: 10px;" onClick="sendData()" type="button">Save</button>
                                        </tbody>
									<div id="popup" class="popup" style="display:none">
										<a class="close" onclick="hidePopup()" style="font-size:25px">×</a>
										</br></br>
										
										<div class="col-md-6">
										
											<div class="form-group">
                                                <label class="col-md-3 control-label">Username*</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-info"></span></span>
                                                        <input type="text" class="form-control" id="username" name="username" required />
                                                    </div>
                                                    <span class="help-block">Username</span>
                                                </div>
                                            </div>
											 <input type="hidden" class="form-control" id="deleteid" name="deleteid"  />
											
                                        </div>
                                        <div class="col-md-6">
										
										
											<div class="form-group">
                                                <label class="col-md-3 control-label">Password*</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-info"></span></span>
                                                        <input type="password" class="form-control" id="password" name="password" required />
                                                    </div>
                                                    <span class="help-block">Password</span>
                                                </div>
                                            </div>
											
											
                                        </div>
										
										<center><button class="btn btn-primary" type="button" onClick="VerifyAndDelete()">Verify</button></center>
									</div>
                                    </table>

                        </div>
                    </div>

                </div>
                <!-- PAGE CONTENT WRAPPER -->
            </div>
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->



    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/tableExport.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/jquery.base64.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/html2canvas.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/jspdf/jspdf.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/base64.js"></script>
        <!-- END PAGE PLUGINS -->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>
        <!-- END TEMPLATE -->

		<script>
		var modifiedData = {};
		
		function post(params,file) {

			method = "post";
			path = file;

			var form = document.createElement("form");
			form.setAttribute("method", method);
			form.setAttribute("action", path);

			for(var key in params) {
				if(params.hasOwnProperty(key)) {
					var hiddenField = document.createElement("input");
					hiddenField.setAttribute("type", "hidden");
					hiddenField.setAttribute("name", key);
					hiddenField.setAttribute("value", params[key]);
					form.appendChild(hiddenField);
				 }
			}

			document.body.appendChild(form);
			form.submit();
		}

		function edit_entry(temp_id){
			post({uid: temp_id} ,"FPSEdit.php");
		}
		
		function approvalFunction(selectedId){
			newvalue = document.getElementById(selectedId).value;
			if(newvalue=="yes"){
				modifiedData[selectedId] = "yes";
			}
			else if(newvalue=="no"){
				modifiedData[selectedId] = "no";
			}
			else{
				if(modifiedData.hasOwnProperty(selectedId)){
					delete modifiedData[selectedId];
				}
			}
		}
		
		
		function sendData(){
			post(modifiedData ,"api/saveData.php");
		}
		
		
		function fetchDataFromServer(){
			var approved = document.getElementById("approved").value;
			var reviewed = document.getElementById("reviewed").value;
			var dataString = 'approved='+ approved + '&reviewed='+ reviewed;
			if(dataString=='')
			{
				alert("Please Fill All Fields");
			}
			else
			{
				$("#filter_button").attr("disabled",true);
				$.ajax({
					type: "POST",
					url: "api/FetchDbData.php",
					data: dataString,
					cache: false,
					error: function(){
						alert("timeout");
						$("#filter_button").attr("disabled",false);
					},
					timeout: 59000,
					success: function(result){
						$('#table_body').empty();
						try{
							var resultarray = JSON.parse(result);
							var warehousearray = resultarray["warehouse"];
							
							var warehousepart = "";
							for(var ids in warehousearray){
								var warehouse_id = warehousearray[ids]["id"];
								warehousepart = warehousepart + "<option value=" + warehouse_id + ">" + warehouse_id + "</option>";
							}
							
							var obj = resultarray["data"];
							for (var bookings in obj) 
							{
								var uniqueid = obj[bookings]["from_id"] + "_" + obj[bookings]["to_id"];
								var approved = obj[bookings]["approve"];
								var newid = obj[bookings]["new_id"];
								
								if(approved=="yes"){
									var approvepart = "<td><button class='btn btn-success'>Approved</button></td>";
								}
								else if(approved=="no"){
									var approvepart = "<td><button class='btn btn-danger'>Not Approved</button></td>";
								}
								else if(approved=="" && (obj[bookings]["new_id"].length>0)){
									var approvepart = "<td><button class='btn btn-warning'>Pending</button></td>";
								}
								else{
									var approvepart = "<td></td>";
								}
								
								if(newid.length>0){
									var newidpart = "<td><select class='form-control' onchange='approvalFunction(\"" + uniqueid + "\")' id='" + uniqueid + "' name='" + uniqueid + "'><option value=''>Select Option</option><option value='no'>Not Approve</option><option value='yes'>Approve</option></select></td>";
								}
								else{
									var newidpart = "<td></td>";
								}
								
								
								$('#table_body').append("<tr><td>" + obj[bookings]["from_district"] + "</td><td>" + obj[bookings]["from_id"] + "</td><td>" + obj[bookings]["from_name"] + "</td><td>" + obj[bookings]["to_district"] + "</td><td>" + obj[bookings]["to_id"] + "</td><td>" + obj[bookings]["to_name"] + "</td>" + approvepart + "<td>" + obj[bookings]["new_id"] + "</td>" + newidpart + "</tr>");
							}
						}
						catch (error) {
						}
					}
				});
			}
		}
		fetchDataFromServer();
		
    </script>
    </body>
</html>
