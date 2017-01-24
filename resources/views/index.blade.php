<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Hotel Ordering System</title>
	<!-- <link rel="stylesheet" href="css/metro.min.css"> -->

	<link rel="stylesheet" type="text/css" href="css/metro-bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/metro-bootstrap-responsive.css">
	<link rel="stylesheet" type="text/css" href="css/iconFont.min.css">
	<link rel="stylesheet" type="text/css" href="css/application.css">
	<!-- AutoCompleteMaster -->
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<!-- Animate -->
	<link rel="stylesheet" type="text/css" href="plugins/animate/animate.css">
	
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.widget.min.js"></script>
	<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="js/metro.min.js"></script>
    <script type="text/javascript" src="js/metro-global.js"></script>
	<script type="text/javascript" src="js/metro-locale.js"></script>
	<script type="text/javascript" src="js/metro-calendar.js"></script>
    <link rel="stylesheet" type="text/css" href="plugins/datatables/dataTable.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="plugins/PNotify/pnotify.brighttheme.css">
    <link rel="stylesheet" type="text/css" href="plugins/PNotify/pnotify.custom.min.css">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
</head>
<body class="metro">
	<div id="overlay">
		<table width="100%" height="100%">
			<tr>
				<td valign="middle">
					<img src="images/preloader.gif" />
					<p style="font-weight: 600; font-family: monospace; font-size: 20px; color: #777">Processing</p>
				</td>
			</tr>
		</table>
	</div>

	<nav class="navigation-bar dark">
	    <div class="navigation-bar-content">
	        <a href="#" class="element" onclick="location.reload();"><span class="icon-grid-view"></span> Dashboard</a>
	        <span class="element-divider"></span>

	        <a class="pull-menu" href="#"></a>
	        <ul class="element-menu">
	            <li>
	                <a class="dropdown-toggle" href="#">Menu</a>
	                <ul class="dropdown-menu dark" data-role="dropdown">
	                    <li><a href="#" class="nav" data-link="stock/manage-stock">Menu Register</a></li>
	                    <li><a href="#" class="nav" data-link="stock/new-stock">Add New Menu</a></li>
	                    
	                </ul>
	            </li>
	            <li>
	                <a class="dropdown-toggle" href="#">Employes</a>
	                <ul class="dropdown-menu dark" data-role="dropdown">
	                    <li><a href="#" class="nav" data-link="employe/employees-main">Manage Employes</a></li>
	                    <li><a href="#" class="nav" data-link="employe/new-employe">Add New Employe</a></li>
	                    
	                </ul>
	            </li>
	            

	            

	            

	            <li>
	                <a class="dropdown-toggle" href="#">Orders</a>
	                <ul class="dropdown-menu dark" data-role="dropdown">
	                    <li><a href="#" class="nav" data-link="so/so-main">Pending</a></li>
	                    <li><a href="#" class="nav" data-link="so/new-so">Approved</a></li>
	                    <li><a href="#" class="nav" data-link="order/issue-products">Cancelled</a></li>
	                </ul>
	            </li>

	           

	            <li>
	                <a class="dropdown-toggle" href="#">Reports</a>
	            </li>
	        </ul>

	        <div class="no-tablet-portrait">
	            <div class="element place-right">
	                <a class="dropdown-toggle" href="#" style="padding-left: 10px">
	                    <span class="icon-cog"></span>
	                </a>
	                <ul class="dropdown-menu dark place-right" data-role="dropdown">
	                   
	                    <li><a href="#" class="nav" data-link="stock/stock-category-main">Stock Categories</a></li>
	                   
	                    <li><a href="logout">Logout</a></li>
	                </ul>
	            </div>
	            <button class="element image-button image-left place-right">
	            	User: {{session('username')}}
	            </button>
	        </div>
	    </div>
	</nav>
	
	<div class="container">
		<div id="dashboard_content">
		@include('dasboard')
		<div class="calendar"></div>
		</div>
	</div>
</body>

	<script type="text/javascript" src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="plugins/PNotify/pnotify.custom.min.js"></script>
	<!-- AutoCompleteMaster -->
	<script src="js/jquery-ui.min.js"></script>
	<script type='text/javascript' src="js/application.js"></script>
	
	<!-- <script type="text/javascript" src="js/metro-global.js"></script>
	<script type="text/javascript" src="js/metro-locale.js"></script> -->
	<script type="text/javascript" src="js/metro-calendar.js"></script>
	<script type="text/javascript" src="js/metro-datepicker.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>
</html>

