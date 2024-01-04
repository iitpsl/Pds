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

$query = "SELECT new_id FROM optimiseddata WHERE new_id<>''";
$result = mysqli_query($con,$query);
$totalidsrequested = mysqli_num_rows($result);

$query = "SELECT approve FROM optimiseddata WHERE approve='yes'";
$result = mysqli_query($con,$query);
$totalidsapproved = mysqli_num_rows($result);
							
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
							<a href="api/DownloadOptimalData.php"><button class="btn btn-success pull-right" style="margin-bottom:20px" type="button">Download Data</button></a>
							<!-- END SIMPLE DATATABLE -->
                                    <table id="export_table" class="table">
                                        <thead>
                                            <tr>
												<th>From District</th>
												<th>From WH ID</th>
												<th>From Name</th>
												<th>To District</th>
												<th>To FPS ID</th>
												<th>To Name</th>
                                            </tr>
                                        </thead>
										 <tbody id="table_body">
										<?php
										$query = "SELECT * FROM optimiseddata WHERE from_district='$district'";
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
										</tbody>
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

    </script>
    </body>
</html>
