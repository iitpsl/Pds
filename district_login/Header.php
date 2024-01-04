<?php		
?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>District</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-black.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar scroll">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="index.php">District Panel</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <div class="profile">
                            <div class="profile-data">
                                <div class="profile-data-name">Hi</div>
								
                                <div class="profile-data-name">
									<b>Welcome</b>
								</div>
                            </div>
                        </div>
                    </li>
					<li>
						<a href="Home.php"> <span class="xn-text">Optimized Planning</span></a>
					</li>
					<li>
						<a href="RolloutPlan.php"> <span class="xn-text">Rollout Plan</span></a>
					</li>
					<li>
						<a href="api/Logout.php"> <span class="xn-text">Logout</span></a>
					</li>
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->

            <!-- PAGE CONTENT -->
            <div class="page-content">

			<!-- START X-NAVIGATION VERTICAL -->
			<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
				<!-- TOGGLE NAVIGATION -->
				<li class="xn-icon-button">
					<a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
				</li>
				<!-- END TOGGLE NAVIGATION -->
			</ul>
			<!-- END X-NAVIGATION VERTICAL -->
			
			 <style>
				/* Styles for the popup */
				.popup {
					display: none;
					position: fixed;
					top: 50%;
					left: 50%;
					transform: translate(-50%, -50%);
					padding: 20px;
					background-color: #fff;
					box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
					z-index: 1000;
				}
			</style>