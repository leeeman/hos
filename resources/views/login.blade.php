<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Hotel Ordering System</title>
	<!-- <link rel="stylesheet" href="css/metro.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="css/metro-bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/metro-bootstrap-responsive.css">
	<link rel="stylesheet" type="text/css" href="css/iconFont.min.css">
	<link rel="stylesheet" type="text/css" href="css/application.css"> -->
<script type="text/javascript" src="js/jquery.min.js"></script>
	<link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">

   
    <script src="js/metro.js"></script>
    <script type="text/javascript" src="js/notify.js"></script>
	
	
    <style>
        .login-form {
            width: 25rem;
            height: 20.75rem;
            position: fixed;
            top: 50%;
            margin-top: -9.375rem;
            left: 50%;
            margin-left: -12.5rem;
            background-color: #ffffff;
            opacity: 0;
            -webkit-transform: scale(.8);
            transform: scale(.8);
        }
    </style>
</head>
<body class="bg-darkTeal" cz-shortcut-listen="true">
    <div class="login-form padding20 block-shadow" style="opacity: 1; transform: scale(1); transition: 0.5s;">
        <form id='LoginForm'>
            <h1 class="text-light">Login to HoS</h1>
            <hr class="thin">
            <!-- <br>
                 <div class="input-control select">
                    <label>Login Type</label>
                     <select name="login_type">
                     <option value="admin">Admin</option>
                     <option value="emp">Employe</option>
                     </select>    
                </div>
            <br> -->
            <div class="input-control modern text iconic">
				    <input type="text" name="user_login" id="user_login">
				    <span class="label">You login</span>
				    <span class="informer">Please enter your username</span>
				    <span class="placeholder">Input login</span>
				    <span class="icon mif-user"></span>
			</div>
            <br>
            <br>
            <div class="input-control modern password iconic" data-role="input">
				    <input type="password" name="user_password" id="user_password">
				    <span class="label">You password</span>
				    <span class="informer">Please enter your password</span>
				    <span class="placeholder">Input password</span>
				    <span class="icon mif-lock"></span>
				    <button class="button helper-button reveal"><span class="mif-looks"></span></button>
			</div>
            <br>
            <br>
            <div class="form-actions">
                <button type="button" class="button primary" onclick="Login.submit();" id="btnLogin">Login to...</button>
                <button type="button" class="button link">Cancel</button>
            </div>
        </form>
    </div>

 </body> 
<script type='text/javascript' src="js/login.js"></script>
</html>

