<?php
require('util/Connection.php');
require('util/SessionCheck.php');
require('Header.php');
$district = $_SESSION['district_district'];


$query = "SELECT from_district FROM optimiseddata WHERE from_district='$district'";
$result = mysqli_query($con,$query);
$totalids = mysqli_num_rows($result);

$query = "SELECT reviewed FROM optimiseddata WHERE from_district='$district' AND reviewed='yes'";
$result = mysqli_query($con,$query);
$totalidsreviewed = mysqli_num_rows($result);

$query = "SELECT new_id FROM optimiseddata WHERE from_district='$district' AND new_id<>''";
$result = mysqli_query($con,$query);
$totalidsrequested = mysqli_num_rows($result);

$query = "SELECT approve FROM optimiseddata WHERE from_district='$district' AND approve='yes'";
$result = mysqli_query($con,$query);
$totalidsapproved = mysqli_num_rows($result);

//code to check the time expiry

$query = "SELECT * FROM timer WHERE 1";
$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result)){
	$date = $row['deadline_date'];
	$time = $row['deadline_time'];
}
$targetDateTime = $date." ".$time;
$targetTimestamp = strtotime($targetDateTime);
$currentTimestamp = time();
$expired = 0; 

if($currentTimestamp >= $targetTimestamp) {
    $expired = 1;
}


?>

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Punjab Intra Route Optimization For PDS</li>
                </ul>
                <!-- END BREADCRUMB -->


				<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="row">
                        <div class="col-md-12">

                            <!-- START SIMPLE DATATABLE -->
                            <div class="panel panel-default">
								<div class="panel-heading">
                                    <h3 class="panel-title">Punjab Intra Route Optimization For PDS District - <b><?php echo $district; ?></b></h3>
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
										<div style="font-size:15px">TOTAL REVIEWED</div>
									</div>
								</div>
								<div class="col-md-3 mb-4">
									<div class="card h-100"
										style="background-color:#FFC167; color:white; padding:20px; font-weight: bold;">
										<div style="font-size:25px"><?php echo $totalidsrequested; ?></div>
										<div style="font-size:15px">TOTAl TAGS CHANGED</div>
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
										<label class="col-md-3 control-label">Reviewed</label>
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
										<label class="col-md-3 control-label">Admin Approval</label>
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
												<th>From District</th>
												<th>From WH ID</th>
												<th>From Name</th>
												<th>To FPS ID</th>
												<th>To Name</th>
                                                <th>Acceptance</th>
                                                <th>Select WH ID</th>
												<th>Verified WH ID</th>
												<th>State Approval</th>
												<th>Reviewed</th>
                                            </tr>
                                        </thead>
										<tbody id="table_body">
										
										</tbody>
										<input type="hidden" id="district" name="district" value="<?php echo $district ?>" />
										<?php
										if($expired==0){
											echo "<button class='btn btn-primary pull-right' onClick='sendData()' type='button'>Save</button>";
										}else{
											echo "<button class='btn btn-primary pull-right' type='button'>Time Expired</button>";
										}
										?>
                                        &nbsp </br>
									<div id="popup" class="popup">
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
		
		function enableDisable(selectedId){
			console.log(selectedId);
			newvalue = document.getElementById(selectedId+"_bool").value;
			if(newvalue=="yes"){
				document.getElementById(selectedId).disabled = true;
				modifiedData[selectedId] = "yes";
			}
			else if(newvalue=="no"){
				modifiedData[selectedId] = "no";
				document.getElementById(selectedId).value = '';
				document.getElementById(selectedId).disabled = false;
			}
			else{
				document.getElementById(selectedId).value = '';
				document.getElementById(selectedId).disabled = false;
			}
			console.log(modifiedData);
		}
		
		function handleNewIdChange(selectedId){
			newvalue = document.getElementById(selectedId).value;
			modifiedData[selectedId] = newvalue;
			if(newvalue==''){
				delete modifiedData[selectedId];
			}
		}
		
		function sendData(){
			post(modifiedData ,"api/SaveData.php");
		}
		
		function fetchDataFromServer(){
			var approved = document.getElementById("approved").value;
			var reviewed = document.getElementById("reviewed").value;
			var district = '<?php echo $district ?>';
			var dataString = 'approved='+ approved + '&reviewed='+ reviewed + '&district='+ district;
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
								var warehouse_name = warehousearray[ids]["name"];
								warehousepart = warehousepart + "<option value=" + warehouse_id + ">" + warehouse_id.toString() + "_" + warehouse_name.toString() + "</option>";
							}
							
							var obj = resultarray["data"];
							for (var bookings in obj) 
							{
								var uniqueid = obj[bookings]["from_id"] + "_" + obj[bookings]["to_id"];
								var uniqueid_bool = uniqueid + "_bool";
								var approved = obj[bookings]["approve"];
								var reviewed = obj[bookings]["reviewed"];
								
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
								if(reviewed=="yes"){
									var reviewpart = "<td><button class='btn btn-success'>Already Reviewed</button></td>";
								}
								else{
									var reviewpart = "<td></td>";
								}
								
								$('#table_body').append("<tr><td>" + obj[bookings]["from_district"] + "</td><td>" + obj[bookings]["from_id"] + "</td><td>" + obj[bookings]["from_name"] + "</td><td>" + obj[bookings]["to_id"] + "</td><td>" + obj[bookings]["to_name"] + "</td><td><select class='form-control' onchange='enableDisable(\"" + uniqueid + "\")' id='" + uniqueid_bool + "' name='" + uniqueid_bool + "'><option value=''>Select</option><option value='yes'>Agree</option><option value='no'>Change ID</option></select></td><td><select class='form-control' onchange='handleNewIdChange(\"" + uniqueid + "\")' id='" + uniqueid + "' name='" + uniqueid + "' disabled><option value=''>Select Id</option>" + warehousepart + "</select></td><td>" + obj[bookings]["new_id"] + "</td>" + approvepart + reviewpart + "</tr>");
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
