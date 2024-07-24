<!DOCTYPE html>
<html lang="en">
<head>
	<title>Career Advice Consultation</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "shortcut icon" href = "../../login-ui/images/UCS-removebg-preview.png">

	<!-- <link rel="icon" type="login-ui/image/png" href="images/icons/favicon.ico"/> -->
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="login-ui/css/util.css">
	<link rel="stylesheet" type="text/css" href="login-ui/css/main.css">
	<style>
			.loader-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.9); /* Adding a background color */
            z-index: 9999;
        }

        .loader {
            width: 70px;
            height: 70px;
            position: relative;
        }

        .loader:before {
            content: "";
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 6px solid #EF6262;
            position: absolute;
            top: 0;
            left: 0;
            animation: pulse 3s ease-in-out infinite;
        }

        .loader:after {
            content: "";
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 6px solid transparent;
            border-top-color: #EF6262;
            position: absolute;
            top: 0;
            left: 0;
            animation: spin 3s linear infinite;
        }

        .loader-text {
            font-size: 26px;
            margin-top: 20px;
            color: #EF6262;
            font-family: Arial, sans-serif;
            text-align: center;
            text-transform: uppercase;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.6);
                opacity: 1;
            }
            50% {
                transform: scale(1.2);
                opacity: 0;
            }
            100% {
                transform: scale(0.6);
                opacity: 1;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .content {
            display: none;
        }

        .loaded .loader-container {
            display: none;
        }

        .loaded .content {
            display: block;
        }

	</style>
</head>
<body>

<div class="loader-container" id="page-loader">
        <div class="loader"></div>
        <div class="loader-text">Loading...</div>
    </div>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url(login-ui/images/ucs1.jpg); background-repeat: no-repeat; background-position: center; background-size: cover;">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(login-ui/images/UCS-removebg-preview.png); background-size: 180px 180px; background-position: left;">
				<span class="login100-form-title-1">
					Career Advice Consultation
					</span>
					<span class="login100-form-title-1">
						Log In as Admin
					</span>
				</div>

				<form method="post" id="adminLoginFrm" class="login100-form validate-form">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" placeholder="Enter username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="pass" placeholder="Enter password">
						<span class="focus-input100"></span>
					</div>


					<div class="container-login100-form-btn" align="center">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="login-ui/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="login-ui/vendor/animsition/js/animsition.min.js"></script>
	<script src="login-ui/vendor/bootstrap/js/popper.js"></script>
	<script src="login-ui/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="login-ui/vendor/select2/select2.min.js"></script>
	<script src="login-ui/vendor/daterangepicker/moment.min.js"></script>
	<script src="login-ui/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="login-ui/vendor/countdowntime/countdowntime.js"></script>
	<script src="login-ui/js/main.js"></script>

	<script type="text/javascript">
        $(document).ready(function() {
            function disableBack() { window.history.forward(); }

            window.onload = disableBack();
            window.onpageshow = function(evt) { if (evt.persisted) disableBack(); }

            // Hide loader after 1 minute (60000 milliseconds)
            setTimeout(function() {
                $('#page-loader').fadeOut('slow', function() {
                    $('body').addClass('loaded');
                });
            }, 000); // 1 minute in milliseconds

            // Also hide loader once the page is fully loaded
            $(window).on('load', function() {
                $('#page-loader').fadeOut('slow', function() {
                    $('body').addClass('loaded');
                });
            });
        });
    </script>

</body>
</html>