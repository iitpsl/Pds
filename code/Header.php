<?php		
?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>PDS Admin</title>
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
                    <a href="index.php"></i> Admin Panel</a>
                    <a href="#" class="x-navigation-control"></a>
                </li>
                <li class="xn-profile">
                    <div class="profile">
                        <div class="profile-data">
                            <div class="profile-data-name">
                                <!-- <b>Namaste</b> -->
                                <b>
            <img src="img/PngItem_1109026.png" alt="Logo" style="vertical-align: middle; height: 60px; width: 60px;" /> Namaste
        </b>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="Home.php"><i class="fas fa-home"></i> <span class="xn-text">Home</span></a>
                </li>
                
                <li>
                    <a href="OptimisedData.php"><i class="fas fa-tasks"></i> <span class="xn-text">Optimised Planning</span></a>
                </li>
                <li>
                    <a href="RolloutPlan.php"><i class="fas fa-tasks"></i> <span class="xn-text">Rollout Plan</span></a>
                </li>
                <li><a href="SendEmail.php"><i class="fas fa-envelope"></i> <span class="xn-text">Issue Alert</span></a></li>
                <li>
                    <a href="api/Logout.php"><i class="fas fa-tasks"></i> <span class="xn-text">Logout</span></a>
                </li>
                
                
				<li class="red-bg-gap">
                    <a href=""><i class=""></i> <span class=""></span></a>
                </li>
				
                <li class="xn-openable">
                    <a href="#"><i class="fas fa-edit"></i> <span class="xn-text">Edit Details</span></a>
                    <ul>
                        <li><a href="District.php"><i class="fas fa-map-marker"></i> <span class="xn-text">Edit Districts</span></a></li>
                        <li><a href="Warehouse.php"><i class="fas fa-map-marker"></i> <span class="xn-text">Edit Warehouse</span></a></li>

                        <li><a href="FPS.php"><i class="fas fa-archive"></i> <span class="xn-text">Edit FPS</span></a></li>
                        <li><a href="Userdata.php"><i class="fas fa-users"></i> <span class="xn-text">User Data</span></a></li>
                        
                        <li><a href="Timer.php"><i class="fas fa-envelope"></i> <span class="xn-text">Edit Deadline</span></a></li>
                    </ul>
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
                    <a href="#" class="x-navigation-minimize"><i class="fas fa-bars"></i></a>
                </li>
				<!-- END TOGGLE NAVIGATION -->
			</ul>
			<!-- END X-NAVIGATION VERTICAL -->
			
			 <style>
				/* Styles for the popup */
				/* .popup {
					display: none;
					position: fixed;
					top: 50%;
					left: 50%;
					transform: translate(-50%, -50%);
					padding: 20px;
					background-color: #fff;
					box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
					z-index: 1000;
				} */
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
            font-family: sans-serif;
        }

        .page-sidebar.scroll * {
            font-family: sans-serif;
            font-weight: italic;
            font-size: 18px;
        }

        .x-navigation li a:hover,
        .page-sidebar.scroll a:hover {
            background-color: #1CAF9A;
            color: #fff;
            /* Define other hover properties as needed */
        }
		.x-navigation .xn-openable > a {
            background-color: #FF5733; Red background on Edit Details hover
            color: #fff;
        }

        .x-navigation .xn-openable ul li a:hover {
            background-color: #9240FF; Red background on submenu item hover
            color: #fff;
            padding-left: 20px; /* Modify padding on hover */
        }

        /* Gap between menu items */
        .x-navigation .xn-openable ul li {
            padding-bottom: 5px; /* Add some bottom padding to create a gap */
        }
		.red-bg-gap {
            background-color: red;
            padding: 10px; /* Adjust the padding as needed */
            margin-bottom: 10px; /* Create a gap below the list item */
        }
        

</style>

