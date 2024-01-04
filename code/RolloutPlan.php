<?php
require('util/Connection.php');
require('util/SessionCheck.php');
require('Header.php');
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
            font-size: 12px; /* Increase font size for buttons */
        }

        /* Add more styles for different elements as needed */
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
                            <!-- END SIMPLE DATATABLE -->
                                    <table id="export_table" class="table">
                                        <thead>
                                            <tr>
												<th style="font-size:16px">From District</th>
												<th style="font-size:16px">From ID</th>
												<th style="font-size:16px">From Name</th>
												<th style="font-size:16px">To District</th>
												<th style="font-size:16px">To ID</th>
												<th style="font-size:16px">To Name</th>
                                            </tr>
                                        </thead>
										 <tbody>
										<?php
										
										$query = "SELECT * FROM optimiseddata WHERE 1";
										$result = mysqli_query($con,$query);
										$numrows = mysqli_num_rows($result);
										while($row = mysqli_fetch_array($result))
										{
											$new_id = $row['new_id'];
											$approve = $row['approve'];
											$subpart1 = "<tr><td>{$row['from_district']}</td>";
											if(strlen($new_id)>0 and $approve=="yes"){
												$subpart1 = $subpart1."<td>{$row['new_id']}</td>";
											}
											else{
												$subpart1 = $subpart1."<td>{$row['from_id']}</td>";
											}
											$subpart1 = $subpart1."<td>{$row['from_name']}</td>".
											"<td>{$row['to_district']}</td>".
											"<td>{$row['to_id']}</td>".
											"<td>{$row['to_name']}</td>";
											echo $subpart1;
											$subpart1 = "";
										}
										
										?>
										<input type="hidden" id="district" name="district" value="<?php echo $district ?>" />
										<a id="downloadLink" href="api/DownloadOptimalData.php">
										<div style="margin-left: 1290px;">
    <a id="downloadLink" href="api/DownloadOptimalData.php">

	<button id="downloadCSV" class="btn btn-success" style="margin-bottom: 10px;" type="button">Download CSV</button>
    <button id="downloadXLSX" class="btn btn-success" style="margin-bottom: 10px;" type="button">Download XLSX</button>
    <button id="downloadPDF" class="btn btn-success" style="margin-bottom: 10px;" type="button">Download PDF</button>
    </a>
  
</div>


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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>

<script src="your_script.js"></script>
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
			else{
				if(modifiedData.hasOwnProperty(selectedId)){
					delete modifiedData[selectedId];
				}
			}
		}
		
		
		function sendData(){
			post(modifiedData ,"api/SaveData.php");
		}
		// Event listener for downloading CSV
document.getElementById('downloadCSV').addEventListener('click', async function() {
    try {
        const csvResponse = await fetch('api/DownloadOptimalData.php?format=csv');
        const csvBlob = await csvResponse.blob();
        downloadFile(csvBlob, 'Downloaded_CSV.csv');
    } catch (error) {
        console.error('Error downloading CSV file:', error);
    }
});

// Event listener for downloading XLSX
document.getElementById('downloadXLSX').addEventListener('click', async function() {
    try {
        const excelResponse = await fetch('api/DownloadOptimalData.php?format=xlsx');
        const excelBlob = await excelResponse.blob();
        downloadFile(excelBlob, 'Downloaded_Excel.xlsx');
    } catch (error) {
        console.error('Error downloading XLSX file:', error);
    }
});

// Event listener for downloading PDF
document.getElementById('downloadPDF').addEventListener('click', async function() {
    try {
        const pdfResponse = await fetch('api/DownloadOptimalData.php?format=pdf');
        const pdfBlob = await pdfResponse.blob();

        const url = window.URL.createObjectURL(pdfBlob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'Downloaded_PDF.pdf';
        link.click();
        window.URL.revokeObjectURL(url);
    } catch (error) {
        console.error('Error downloading PDF file:', error);
    }
});



// Functions for file download and PDF generation (similar to previous code)
function downloadFile(blob, fileName) {
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = fileName;
    link.click();
    window.URL.revokeObjectURL(url);
}

async function downloadPDF(blob, fileName) {
    try {
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = fileName;
        link.click();
        window.URL.revokeObjectURL(url);
    } catch (error) {
        console.error('Error downloading PDF:', error);
    }
}

document.getElementById('downloadPDF').addEventListener('click', async function() {
    try {
        const pdfResponse = await fetch('api/DownloadOptimalData.php?format=pdf');
        const pdfBlob = await pdfResponse.blob();
        downloadPDF(pdfBlob, 'Downloaded_PDF.pdf');
    } catch (error) {
        console.error('Error fetching PDF file:', error);
    }
});


    </script>
    </body>
</html>
