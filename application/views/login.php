<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Chameleon Admin is a modern Bootstrap 4 webapp &amp; admin dashboard html template with a large number of components, elegant design, clean and organized code.">
    <meta name="keywords" content="admin template, Chameleon admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>Login </title>
    <link rel="apple-touch-icon" href="<?=base_url()?>static/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>static/app-assets/images/ico/favicon.ico">
    <!-- <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet"> -->

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/pages/login-register.css">
   
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/assets/css/style.css">
    <!-- END: Custom CSS-->
	<style>
.form-group {
    position: relative; /* Make sure the parent is positioned */
}

.toggle-password {
	position: absolute;
    right: 10px;
    top: 23px;
    transform: translateY(-50%);
    cursor: pointer;
}

.text-danger {
    margin-top: 5px; /* Add some space above the error message */
    position: relative; /* Keeps the error message in normal flow */
    z-index: 1; /* Ensure it doesn't overlap the input */
}

        #step_3{
            display:none;
            margin-bottom:50rem !important;
        }
        @media only screen and (max-width: 600px) {
            #step_3{
            display:none;
            margin-bottom:150rem !important;
        
        }
        }
	#otpdiv{

		display: none;
	}
    #otpdivforgot{

display: none;
}
	#verifyotp{

		display: none;
	}
    #verifyotpforgot{
        display: none;
    }
    #resend_otp_forgot{
        display: none;
    }
    #admin_resend_otp_forgot{
        display: none;
    }
	#resend_otp{
		display: none;
	}
    #resend_otp1{
		display: none;
	}
	.countdown{
		display: table;
		width: 100%;
		text-align: left;
		font-size: 15px;
        margin-top: -1rem;
	}
    .countdown1{
		display: table;
		width: 100%;
		text-align: left;
		font-size: 15px;
        margin-top: -1rem;
	}
    #resend_otp_forgot:hover{
        text-decoration:underline;  
    }
    #admin_resend_otp_forgot:hover{
        text-decoration:underline;  
    }
	#resend_otp:hover{

		text-decoration:underline;
		

	}
    #resend_otp1:hover{

text-decoration:underline;


}
    #newheading
    {
        display: none;
    }
    #newheadingforgot
    {
        display: none;
    }
    #spinner-div1 {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
#spinner-div2 {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
#spinner-div3 {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
#spinner-div4 {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
#spinner-div5 {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
#spinner-div6 {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
#spinner-div7 {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
#spinner-div10 {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
#spinner-div11 {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
.success {
      opacity: 1;
      transition: opacity 4s ease-out;
    }
    .error {
    -moz-animation: cssAnimation 0s ease-in 5s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 5s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 5s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 5s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
    #spinner-div {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
}
</style>
</head>
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column  bg-full-screen-image blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-color="bg-gradient-x-purple-red" data-col="1-column">
    <style type="text/css">
        form .error{
            width: 100%;
            text-align: center;
            color: red;
        }
        form .success{
            width: 100%;
            text-align: center;
        }
    </style>
    <!-- BEGIN: Content-->

    <div class="app-content content">
        <div class="content-wrapper">
          
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container" id="oldDiv">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-6 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                                <div class="card-header border-0">
                                    <div class="text-center mb-1">
                                        <!-- <img src="<?=base_url()?>static/app-assets/images/logo/logo.png" alt="branding logo" style="width: 80%;"> -->
                                        <img  alt="branding  logo" src="<?=$admin_logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';"style="width: 100%;height:150px"> 
                                    </div>
                                    <div class="font-large-1  text-center">
                                        <?php if(@$type=='admin') : ?>
                                            
                                            <span id="oldadmin">Admin Login</span>
                                            <span id="newadmin" style="display: none;">Forgot Password</span>
                                        <?php else : ?>
                                            <span id="oldheading">Property Owner Login</span>
                                            <span id="newheading">Create New Account</span>
                                            <span id="newheadingforgot">Forgot Password</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <?php if(@$type=='admin') : ?>
                                  
                                    <div class="card-body pt-0 collapse show" id="admin-login">
                                        <form class="form-horizontal" id="login" action="<?=base_url()?>login"  method="POST">
                                            <label class="error" id="error_id"></label> 
                                            <label class="success" id="success_id"></label> 
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control round" id="username" name="username" placeholder="Your Username"  required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control round passwordAdmin" id="password" name="password" placeholder="Enter Password"  required>
                                                <div class="form-control-position">
                                                    <i class="ft-lock"></i>
                                                </div>
												<span class="toggle-password" data-target="passwordAdmin">
													<i class="la la-eye"></i>
												</span>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-sm-left">

                                                </div>

                                            </div>
                                            <div class="form-group text-center">
                                                <input type="hidden" name="type" value="admin">
                                                <button type="submit" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1">Login</button>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12  col-lg-12 ">
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-sm-12 mr-1 mb-1 " id="adminforgotbtn" >Forgot Password?</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="card-body pt-0 collapse show" id="check-admin-email" style="display: none;">
                                        <form class="form-horizontal"  >
                                        <div id="spinner-div10" class="pt-5">
                                            <div class="spinner-border text-primary" role="status">
                                            </div>
                                        </div>
                                       
                                            <div class="otp_msg"></div><br><br>
                                            <div class="otp_msg1"></div>
                                            <div class="form-group" id="adminemailforgot">
                                            <fieldset class="form-group position-relative has-icon-left ">
                                                <input type="email" class="form-control round" id="adminemail" name="adminemail" placeholder="Enter email address" onkeyup="ValidateEmail();"  required>
                                                <span id="lblError" style="color: red"></span>
                                            </fieldset>
                                            </div>
                                            <div class="form-group" id="adminotpforgot">
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control round" id="emailforgot" name="emailforgot" placeholder="Enter Your OTP "  required>
                                            </fieldset>
                                           
                                                <div class="countdown"></div>
                                                <a href="#" id="admin_resend_otp_forgot" type="button">Resend</a>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-sm-left">

                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" id="adminsendotpforgot">Next</button>
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" id="adminverifyotpforgot">Next</button>
                                                <a id="AdminForgotEmailPage" ><i class="la la-arrow-circle-left mt-2" style="color: blue;font-size:2rem"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body pt-0 collapse show" id="admin_forgot_pass" style="display: none;">
                                    <form class="form-horizontal"  >
                                        <div id="spinner-div11" class="pt-5">
                                            <div class="spinner-border text-primary" role="status">
                                            </div>
                                        </div>
                                            <div class="otp_msg"></div><br><br>
                                            <div class="otp_msg1"></div>
                                            <div class="form-group">
                                            <fieldset class="form-group position-relative has-icon-left ">
                                                <input type="password" class="form-control round password11" id="adminnewpass" placeholder="Enter New Password"   minlength="8" onkeyup="validateAdminPassword()" required>
												<span class="toggle-password" data-target="password11">
													<i class="la la-eye"></i>
												</span>
                                                <p class="text-danger" id="error-message5"></p>
                                            </fieldset>
                                            </div>
                                            <div class="form-group">
                                            <fieldset class="form-group position-relative has-icon-left ">
                                                <input type="password" class="form-control round adminnewcpass" id="adminnewcpass" placeholder="Enter Confirm Passwod"   minlength="8" onkeyup="validateAdminCPassword()" required>
												<span class="toggle-password" data-target="adminnewcpass">
													<i class="la la-eye"></i>
												</span>
                                                <p class="text-danger" id="error-message6"></p>
                                            </fieldset>
                                            <input type="hidden" id="adminemailgive" class="adminemailgive">
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-sm-left">

                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" id="adminforgotpassbtn">Submit</button>
                                                <a id="ForgotPasswordPage" ><i class="la la-arrow-circle-left mt-2" style="color: blue;font-size:2rem"></i></a>
                                            </div>
                                        </form>  
                                    </div>
                                    
                                    <?php else : ?>
                                    <div class="card-body pt-0 collapse show" id="host-login">
                                        <form class="form-horizontal" id="login2" action="<?=base_url()?>login"  method="POST">
                                        <label class="error" id="error_id"></label> 
                                            <label class="success" id="success_id"></label> 
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control round" id="username" name="username" placeholder="Your Username"  required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control round passs" id="password" name="password" placeholder="Enter Password"  required>
                                                <div class="form-control-position">
                                                    <i class="ft-lock"></i>
                                                </div>
												<span class="toggle-password" data-target="passs">
													<i class="la la-eye"></i>
												</span>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-sm-left">

                                                </div>
                                                <!-- <div class="col-md-6 col-12 float-sm-left text-center text-sm-right"><a href="recover-password.html" class="card-link">Forgot Password?</a></div> -->

                                            </div>
                                            <div class="form-group text-center">
                                                <input type="hidden" name="type" value="host">

                                                <button type="submit" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1">Login</button>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12  col-lg-12 ">
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-sm-12 mr-1 mb-1 " id="forgotbtn" >Forgot Password?</button>
                                                </div>
                                                <div class="col-sm-12  col-lg-12 ">
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-sm-12 mr-1 " id="createbtn">Create New Account</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="card-body pt-0 collapse show" id="verify-mobile-forgot" style="display: none;">
                                        <form class="form-horizontal"  >
                                        <div id="spinner-div1" class="pt-5">
                                            <div class="spinner-border text-primary" role="status">
                                            </div>
                                        </div>
                                       
                                            <div class="otp_msg"></div><br><br>
                                            <div class="otp_msg1"></div>
                                            <div class="form-group" id="mobiledivforgot">
                                            <fieldset class="form-group position-relative has-icon-left ">
                                                <input type="number" class="form-control round" id="mobforgot" name="mobforgot" placeholder="Your Mobile Number"  required>
                                            </fieldset>
                                            </div>
                                            <div class="form-group" id="otpdivforgot">
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control round" id="otpforgot" name="otpforgot" placeholder="Enter Your OTP "  required>
                                            </fieldset>
                                           
                                                <div class="countdown"></div>
                                                <a href="#" id="resend_otp_forgot" type="button">Resend</a>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-sm-left">

                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" id="sendotpforgot">Next</button>
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" id="verifyotpforgot">Next</button>
                                                <a id="ForgotMobilePage" ><i class="la la-arrow-circle-left mt-2" style="color: blue;font-size:2rem"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body pt-0 collapse show" id="newpassword" style="display: none;">
                                        <form class="form-horizontal"  >
                                        <div id="spinner-div2" class="pt-5">
                                            <div class="spinner-border text-primary" role="status">
                                            </div>
                                        </div>
                                            <div class="otp_msg"></div><br><br>
                                            <div class="otp_msg1"></div>
                                            <div class="form-group">
                                            <fieldset class="form-group position-relative has-icon-left ">
                                                <input type="password" class="form-control round newpass1" id="newpass1" placeholder="Enter New Password" minlength="8" onkeyup="validateHostPassword()" on required>
												<span class="toggle-password" data-target="newpass1">
													<i class="la la-eye"></i>
												</span>
                                                <p class="text-danger" id="error-message3"></p>
                                            </fieldset>
                                            </div>
                                            <div class="form-group">
                                            <fieldset class="form-group position-relative has-icon-left ">
                                                <input type="password" class="form-control round newcpass1" id="newcpass1" placeholder="Enter Confirm Passwod" minlength="8" onkeyup="validateHostCPassword()"  required>
												<span class="toggle-password" data-target="newcpass1">
													<i class="la la-eye"></i>
												</span>
                                                <p class="text-danger" id="error-message4"></p>
                                            </fieldset>
                                            <input type="hidden" id="usermobileforgot" class="usermobileforgot">
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-sm-left">

                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" id="newpasswordbtn">Submit</button>
                                                <a id="ForgotPasswordPage" ><i class="la la-arrow-circle-left mt-2" style="color: blue;font-size:2rem"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <div class="card-body pt-0 collapse show" id="verify-mobile" style="display: none;">
                                        <form class="form-horizontal"  >
                                        <div id="spinner-div3" class="pt-5">
                                            <div class="spinner-border text-primary" role="status">
                                            </div>
                                        </div>
                                            <div class="otp_msg"></div><br><br>
                                            <div class="otp_msg1"></div>
                                            <div class="form-group" id="mobilediv">
                                            <fieldset class="form-group position-relative has-icon-left ">
                                                <input type="number" class="form-control round" id="mob" name="mob" placeholder="Your Mobile Number"  required>
                                            </fieldset>
                                            <div class="form-group checkbox-option">
                                                <p> <input type="checkbox" id="myCheckbox"  required>
                                                Accept <a target="_blank" href="<?=base_url('terms-condition');?>">Terms & Conditions</a> And <a target="_blank" href="<?=base_url();?>privacy-policy">Privacy Policy.</a>
                                                </p>
                                                </div>
                                            </div>
                                            <div class="form-group" id="otpdiv">
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control round" id="otp" name="otp" placeholder="Enter Your OTP "  required>
                                            </fieldset>
                                                <div class="countdown"></div>
                                                <a href="#" id="resend_otp" type="button">Resend</a>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12 col-12 text-center text-sm-left">
                                               
                                                </div>
                                            </div>
                                            
                                            <div class="form-group text-center">
                                          
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" id="sendotp">Next</button>
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" id="verifyotp">Next</button>
                                                <a id="AccountFirstStep" ><i class="la la-arrow-circle-left mt-2" style="color: blue;font-size:2rem"></i></a>
                                                
                                            </div>
                                        </form>
                                    </div>

                                    <?php endif; ?>

                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section class="flexbox-container registerhere" id="registerhere" style="display:none;margin-bottom:24rem !important">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-10 col-md-10 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                            <div class="card-header border-0">
                                    <div class="text-center mb-1">
                                    <img  alt="branding  logo" src="<?=$admin_logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';"style="width: 40%;" height="150px"> 
                                        <!-- <img src="<?=base_url()?>static/app-assets/images/logo/logo.png" alt="branding logo" style="width:40%;" height="150px" > -->
                                    </div>
                                    <div class="font-large-1  text-center">
                                            <span id="newheading">Create New Account</span>
                                    </div>
                                </div>
                                <div class="card-content otp form" >
                                <div class="otp_msg2"></div>
                                <div id="spinner-div4" class="pt-5">
                                            <div class="spinner-border text-primary" role="status">
                                            </div>
                                        </div>
                                <form class=" submit form form-horizontal  reload-page ajaxsubmit validate-new-form"  method="POST" action="<?=base_url();?>new-account/new_account_step" enctype="multipart/form-data">
                                            <label class="error2 text-danger"></label> 
                                            <label class="error5 text-danger"></label> 
                                            <label class="success2 text-success"></label> 
                                            <input type="hidden" class="email_verification" name="email_verification" value="0" id="email_verification">
                                            <input type="hidden" class="usermobile" name="mobile" id="usermobile">
                                            <input type="hidden" id="userid" class="userid">
                                   <div class="row">
                                    <div class="col-md-4 form-group form-group1">
                                        <label for="">Contact Person Name<span class="text-danger">*</span></label>
                                    <fieldset class="form-group  form-group1 position-relative has-icon-left ">
                                      <input type="text"  class="form-control round name"   name="name" placeholder="Enter Name">
                                      </fieldset>
                                    </div>
                                    <div class="col-md-4  form-group form-group1">
                                    <label for="">Profile Picture <span id="pic"></span> <span class="text-danger">Maximum file size 100 kb.</span></label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                      <input type="file"  class="form-control round "   name="pic"   >
                                      </fieldset>
                                      
                                    </div>
                                    <div class="col-md-4  form-group form-group1">
                                        <label class="">Email</b></label><span><img src="<?=base_url('assets/icons/img.png');?>" alt="" height="20px" width="20px" id="email_validate_icon" style="display: none;margin-left: 3rem !important;margin-top: -1.8rem;padding-bottom: -21rem;" class="iconimg"></span>
                                    <fieldset class="form-group  form-group1 position-relative has-icon-left ">
                                      <input type="text"  class="form-control round email"   name="email" placeholder="Enter email address" id="email">
									  <div class="error-email "></div>
                                      <input type="button"  class="btn btn-sm btn-danger mt-1" id="email-verifiy" value="Email Verify" style="float:right">
                                      </fieldset>
									 

                                    </div>
                                    <div class="col-md-4  form-group form-group1">
                                    <label for="">Aadhaar Front Photo  <span id="pic2"></span> <span class="text-danger">Maximum file size 100 kb.</span></label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                      <input type="file"  class="form-control round"   name="pic1"   >
                                      </fieldset>
                                    </div>
                                    <div class="col-md-4  form-group form-group1">
                                    <label for="">Aadhaar Back Photo  <span id="pic3"></span> <span class="text-danger">Maximum file size 100 kb.</span></label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                      <input type="file"  class="form-control round"   name="pic2"   >
                                      </fieldset>
                                    </div>
                                   
                                    <div class="col-md-4  form-group form-group1">
                                    <label for="">Aadhaar Number</label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                      <input type="number" id="aadhaarNumber"  class="form-control round aadhaar"  name="aadhaar" placeholder="Enter Your Aadhaar Number" oninput="validateAadhaarInput(this.value)" maxlength="12"   onkeypress="validateAadhaarKeyPress()">
                                     <p class="error-message text-danger" id="aadhaarErrorMessage"></p>
                                      </fieldset>
                                    </div>
                                    <div class="col-md-4  form-group form-group1">
                                    <label for="">Enter Username<span class="text-danger">*</span></label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                      <input type="text"  class="form-control round username" name="username" placeholder="Enter Your Username"  >
                                      </fieldset>
                                    </div>              
                                    <div class="col-md-4  form-group form-group1">
		
                                    <label for="">Password<span class="text-danger">*</span></label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                      <input type="password" minlength="8" onkeyup="validatePassword()" id="step_3_password"  class="form-control round password step_3_password"  name="password" placeholder="Enter Your Password"  >
									  <span class="toggle-password" data-target="step_3_password">
										<i class="la la-eye"></i>
										</span>
                                      <p class="text-danger" id="error-message1"></p>
                                      </fieldset>
                                    </div>
                                    <div class="col-md-4  form-group form-group1">
                                    <label for="">Confirm Password<span class="text-danger">*</span></label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                      <input type="password"  class="form-control round password step_3_cpassword" minlength="8" onkeyup="validateCPassword()" id="step_3_cpassword"   name="cpassword" placeholder="Enter Your Confirm Password"  >
									  <span class="toggle-password" data-target="step_3_cpassword">
									  <i class="la la-eye"></i>
									 </span>
                                      <p class="text-danger" id="error-message2"></p>
                                      </fieldset>
                                    </div>
                                    <!-- <div class="col-4 form-group form-group1" id="pic" style="display: none;">
                                    <label for="">Profile Pic<span class="text-danger"></span></label>
                                    <div class="pic"></div>
                                    </div>
                                    <div class="col-4 form-group form-group1" id="pic1" style="display: none;">
                                    <label for="">Aadhaar Back Photo<span class="text-danger"></span></label>
                                    <div class="pic1"></div>
                                    </div>
                                    <div class="col-4 form-group form-group1" id="pic2" style="display: none;">
                                    <label for="">Aadhaar Front Photo<span class="text-danger"></span></label>
                                    <div class="pic2"></div>
                                    </div> -->
                                    <div class="col-md-4 form-group form-group1"></div>
                                     <div class="form-group  form-group1 text-center col-md-4">
                                       <button type="submit" id="btnsubmit_step2" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue  mr-1 mb-1 mt-3">Next</button>
                                       <a id="AccountSecondStep" ><i class="la la-arrow-circle-left mt-2" style="color: blue;font-size:2rem"></i></a>
                                            </div>
                                            <div class="col-md-4 form-group form-group1"></div>
                                            </div>
                                        </form>
                                </div>

                            </div></div></div>
                            <!-- email otp verify modal -->
                            <div class="modal" id="exampleModal" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="otp_msg3"></div>
                                <div id="spinner-div5" class="pt-5">
                                            <div class="spinner-border text-primary" role="status">
                                            </div>
                                        </div>
                        <form  class=" submit form form-horizontal  reload-page chechmailotp"  method="POST" action="<?=base_url();?>new-account/checkmailotp" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Email OTP Verification</h5>
                                    <button type="button" id="closemodal" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <div class="col-12 form-group form-group1" >
                                    <label for="">Enter Email OTP </label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                      <input type="number"  class="form-control round"   name="email-otp" placeholder="Enter OTP"  >
                                      <div class="countdown1 mt-1"></div>
                                                <a href="#" id="resend_otp1" type="button">Resend</a>
                                                
                                      </fieldset>
                                      <button type="submit" id="email-otp-verifiy-div" class="btn btn-primary btn-sm  text-center mb-3  mt-1" style="float: right;">Submit OTP</button>
                                      
                                      </div>
                                    </div>
                            </form>
                                </div>
                                </div>
                            </div>
                            </div>
                </section>

                <section class="flexbox-container step_3" id="step_3" >
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-10 col-md-10 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                            <div class="card-header border-0">
                                    <div class="text-center mb-1">
                                    <img  alt="branding  logo" src="<?=$admin_logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';"style="width: 40%;" height="150px"> 
                                        <!-- <img src="<?=base_url()?>static/app-assets/images/logo/logo.png" alt="branding logo" style="width:40%;" height="150px" > -->
                                    </div>
                                    <div class="font-large-1  text-center">
                                            <span id="newheading">Create New Account</span>
                                    </div>
                                </div>
                                <div class="card-content otp form" >
                                    <span> Property Details</span>
                                    <hr>
                                <div class="otp_msg2"></div>
                                <div id="spinner-div6" class="pt-5">
                                            <div class="spinner-border text-primary" role="status">
                                            </div>
                                        </div>
                                <form class="validate-new-form-step-3 submit form form-horizontal  reload-page ajaxsubmit_accout_step_3"  method="POST" action="<?=base_url();?>new-account/accout_step_3" enctype="multipart/form-data">
                                            <label class="error2 text-danger"></label> 
                                            <label class="error5 text-danger"></label> 
                                            <label class="success2 text-success"></label> 
                                            <input type="hidden" name="mobile" id="usermobile1">
                                   <div class="row">
                                    <div class="col-md-6 form-group form-group1">
                                        <label for="">Property Name<span class="text-danger">*</span></label>
                                    <fieldset class="form-group  form-group1 position-relative has-icon-left ">
                                      <input type="text"  class="form-control propname "   name="propname" placeholder="Enter Property Name" required>
                                      </fieldset>
                                    </div>
                                    <div class="col-md-6 form-group form-group1">
                                    <label for="">Property Code Name</label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                    <input type="text"  class="form-control propcodename"   name="propcodename" placeholder="Enter Property Code Name">
                                      </fieldset>
                                    </div>
                                    <div class="col-md-4 form-group form-group1">
                                    <label for="">Contact Person</label>
                                    <fieldset class="form-group form-group1 position-relative has-icon-left">
                                      <input type="text"  class="form-control contact_preson"  name="contact_preson" placeholder="Enter Contact Person"  >
                                      </fieldset>
                                    </div>
                                    <div class="col-md-4 form-group form-group1">
                                    <label for="">Contact Person Mobile</label>
                                      <input type="tel"  class="form-control contact_preson_mobile" name="contact_preson_mobile" placeholder="Enter Contact Person Mobile"  >
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email_address">Email Address</label>
                                            <input type="email" id="email_address" class="form-control email_address" placeholder="Enter Email Address" name="email_address">
                                        </div>
                                    </div>
                                    </div>  
                                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country">Country*</label>
                                            <select id="country" name="country" class="form-control country" required>
                                                <?php
                                                    echo optionStatus('','-- Select --');
                                                foreach ($countries as $row) {
                                                    echo optionStatus($row->id,$row->name);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state">State*</label>
                                            <select id="state" name="state" class="form-control state" required>
                                               
                                                <option value="" >-- Select --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city">City*</label>
                                            <select id="city" name="city" class="form-control city" required>
                                                <option value="" >-- Select --</option>
                                                <option value="bangalore">bangalore</option>
                                                <option value="Noida">Noida</option>
                                                <option value="kanpur">kanpur</option>
                                                <option value="Delhli">Delhli</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="location_id">Location*</label>
                                                    <select id="location_id" name="location_id" class="form-control location_id" >
                                                        <option value="" >-- Select --</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="propcodename">Pincode*</label>
                                                    <input type="text" class="form-control Pincode" placeholder="Pincode" name="pincode" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="property_type_id">Property Type*</label>
                                                    <select id="property_type_id" name="property_type_id" class="form-control property_type_id" required>
                                                        <?php
                                                        echo optionStatus('','-- Select --',1);
                                                        foreach ($type1 as $row) {
                                                            echo optionStatus($row->pt_id,$row->name,$row->active);
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address*</label>
                                            <textarea id="address" rows="6" class="form-control address" name="address" placeholder="address" required></textarea>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Attach Address Proof Document Type</label>
                                            <select name="doc_type_id" class="form-control doc_type_id" >
                                                <?php
                                                echo optionStatus('','-- Select --',1);
                                                foreach ($document_type as $row) {
                                                    echo optionStatus($row->id,$row->name,$row->active);
                                                }
                                                ?>
                                            </select>
                                            
                                        </div>
                                    </div>
                                        <div class="form-group col-md-6">
                                            <label>Address Proof Document (Image/PDF) <i class="la la-check-circle text-success d-none icon-element" id="documentInput-icon"></i> <span id="pic4"></span> <span class="text-danger">Maximum file size 100 kb.</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="form-control address-doc" name="document" id="documentInput">
                                                <script>
												function fileSelected(input) {
													// Find the parent element of the input
													var parent = input.parentElement;

													// Find the sibling of the parent element with the class '.Document'
													var iconElement = document.getElementById('documentInput-icon');
													
													// Check if iconElement is null or undefined
													if (!iconElement) {
														console.error("Document icon element not found.");
														return;
													}
													
													// Check if input.files is undefined or empty, if so, return
													if (!input.files || !input.files[0]) return;

													var fileSize = input.files[0].size;
													var maxSize = 100 * 1024;

													if (fileSize <= maxSize) {
														iconElement.classList.remove('d-none');
													} else {
														iconElement.classList.add('d-none');
														input.value = '';
													}
												}

												// Attach the onchange event handler using JavaScript
												document.getElementById('documentInput').addEventListener('change', function() {
													fileSelected(this);
												});
											</script>

                                                <!-- <label class="custom-file-label" for="customFile"><span id="picchoose">Choose File</span></label> -->
                                            </div>
                                        </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address Proof Document (Image/PDF)<span id="pic4"></span></label>
                                            <input type="file" class="form-control" name="document">                        
                                        </div>
                                    </div> -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="checkintime">Check In Time</label>
                                        <input type="time" id="checkintime" class="form-control checkintime" placeholder="Check In Time" name="checkintime" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="checkinupto">Check In Upto</label>
                                        <input type="time" id="checkinupto" class="form-control checkinupto " placeholder="Check In Upto" name="checkinupto" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="checkouttime">Check Out Time</label>
                                        <input type="time" id="checkouttime" class="form-control checkouttime" placeholder="Check Out Time" name="checkouttime" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="checkoutupto">Check Out Upto</label>
                                        <input type="time" id="checkoutupto" class="form-control checkoutupto" placeholder="Check Out Upto" name="checkoutupto" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                <div class="form-group">
                                    <label for="latitude">Company Name</label>
                                    <input type="text" class="form-control company_name" name="company_name" placeholder="Enter Company Name"> 
                                </div>
                            </div>
							<div class="col-md-4">
							<div class="form-group">
								<label for="latitude">Logo <i class="la la-check-circle text-success d-none icon-element" id="documentInput-icon-logo"></i> <span id="pic6"></span> <span class="text-danger">Maximum file size 100 kb.</span></label>
								<input type="file" class="form-control" name="logo" id="conpany_logo"> 
								<script>
												function fileSelected3(input) {
													// Find the parent element of the input
													var parent = input.parentElement;

													// Find the sibling of the parent element with the class '.Document'
													var iconElement = document.getElementById('documentInput-icon-logo');
													
													// Check if iconElement is null or undefined
													if (!iconElement) {
														console.error("Document icon element not found.");
														return;
													}
													
													// Check if input.files is undefined or empty, if so, return
													if (!input.files || !input.files[0]) return;

													var fileSize = input.files[0].size;
													var maxSize = 100 * 1024;

													if (fileSize <= maxSize) {
														iconElement.classList.remove('d-none');
													} else {
														iconElement.classList.add('d-none');
														input.value = '';
													}
												}

												// Attach the onchange event handler using JavaScript
												document.getElementById('conpany_logo').addEventListener('change', function() {
													fileSelected3(this);
												});
											</script>
							</div>
						</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="latitude">Bill Start Format</label>
                                    <input type="text" class="form-control bill_no" name="bill_no" placeholder="Enter Bill Start Format"  maxlength="6"  oninput="validateLength(this)" > 
                                </div>
                            </div>
                            
                                    <div class="col-md-12">
                                        <span>For GST & Business Details</span>
                                        <hr>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>GST </label>
                                            <select name="is_gst" class="form-control is_gst" >
                                                <option value="">Select GST</option>
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-3 gst-box" style="display:none;">
                                        <div class="form-group">
                                            <label>GST No.</label>
                                            <input type="text" class="form-control gst_no_input" placeholder="Enter GST No." name="gst_no">
                                        </div>
                                    </div>
                                    <div  class="col-md-5 gst-box" style="display:none;">
                                    <label>GST Certificate (Image/PDF) <i class="la la-check-circle text-success d-none icon-element" id="documentInput-icon2"></i>  <span id="pic5"></span> <span class="text-danger">Maximum file size 100 kb.</span></label>
                                      <div class="custom-file">
                                      <input type="file" class="form-control gst_certificate" name="gst_certificate" id="documentInput2"> 
                                     <input type="hidden" class="form-control old_gst_certificate" name="old_gst_certificate"> 
                                     <script>
    function fileSelected2(input) {
        // Find the parent element of the input
        var parent = input.parentElement;

        // Find the sibling of the parent element with the class '.Document'
        var iconElement = document.getElementById('documentInput-icon2');
        
        // Check if iconElement is null or undefined
        if (!iconElement) {
            console.error("Document icon element not found.");
            return;
        }
        
        // Check if input.files is undefined or empty, if so, return
        if (!input.files || !input.files[0]) return;

        var fileSize = input.files[0].size;
        var maxSize = 100 * 1024;

        if (fileSize <= maxSize) {
            iconElement.classList.remove('d-none');
        } else {
            iconElement.classList.add('d-none');
            input.value = '';
        }
    }

    // Attach the onchange event handler using JavaScript
    document.getElementById('documentInput2').addEventListener('change', function() {
        fileSelected2(this);
    });
</script>
                                            </div>
                                            </div>
                                    <!-- <div class="col-4 form-group form-group1" id="pic3" style="display: none;">
                                    <label for="">Address Proof Document (Image/PDF)<span class="text-danger"></span></label>
                                    <div class="pic3"></div>
                                    </div>
                                    <div class="col-4 form-group form-group1" id="pic4" style="display: none;">
                                    <label for="">GST Certificate (Image/PDF)<span class="text-danger"></span></label>
                                    <div class="pic4"></div>
                                    </div> -->
                                </div>
                
                                    <div class="row mt-3">
                                    <div class="col-md-4 form-group form-group1"></div>
                                     <div class="form-group  form-group1 text-center col-md-4">
                                       <button type="submit" id="btnsubmit" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue  mr-1 mb-1">Next</button>
                                       <a id="AccountThirdStep" ><i class="la la-arrow-circle-left mt-2" style="color: blue;font-size:2rem"></i></a>
                                            </div>
                                            <div class="col-md-4 form-group form-group1"></div>
                                            </div>
                                        </form>
                                </div>

                            </div></div></div>
                            </div>
                </section>
                <section class="flexbox-container step_4" id="step_4" style="display:none;margin-bottom:25rem !important">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-10 col-md-10 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                            <a id="AccountFourthStep" ><i class="la la-arrow-circle-left mt-2" style="color: blue;font-size:2rem"></i></a>
                            <div class="card-header border-0">
                                    <div class="text-center mb-1">
                                        <!-- <img src="<?=base_url()?>static/app-assets/images/logo/logo.png" alt="branding logo" style="width:40%;" height="150px" > -->
                                        <img  alt="branding  logo" src="<?=$admin_logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';"style="width: 40%;" height="150px"> 
                                    </div>
                                    <div class="font-large-1  text-center">
                                            <span id="newheading">Create New Account</span>
                                    </div>
                                    <div id="spinner-div7">
                                    <div class="spinner-border text-primary" role="status">
                                    </div>
                                </div>
                                </div>
                                <div class="card-content otp form" >
                                    <span><b>Choose Packages</b></span>
                                    <hr>
                                <div class="otp_msg2"></div>
                                <form>
                               <input type="hidden" name="mobile" id="usermobile2" class="usermobile2">
                                   <div class="row">
                                   <?php foreach($user_packages_master as $packages):?>

                                    <div class="col-sm-3 h-100">
                                      <div class="card bg-info">
                                        <div class="list-group-item bg-info">
                                            <p class="text-center text-white" style="font-size: 2rem;"><strong><?=$packages->name;?></strong></p>
                                            <p class="text-center"><img src="<?=IMGS_URL.$packages->pic;?>" alt="" height="70px"></p>
                                        </div>
                                        <div class="card-body ">
                                           <p style="font-size: 1.2rem;color:black;" class="text-center text-white">Duration : <?=$packages->duration_in_days;?> Days</p>
                                           <p style="font-size: 2rem;color:black;" class="text-center text-white">Price : <?=setting()->currency;?> <?=$packages->price;?><sub></sub> </p>
                                           <?php if($packages->is_promotion==1){?>
                                            <h6 style="font-size: 1rem;color:black;text-align:center" class="text-center text-white"> UNITS <?=$packages->min_room;?> - <?=$packages->max_room;?> NOS </h6>
                                            <?php };?>
                                            <h6 style="font-size: 1rem;color:black;text-align:center" class="text-center text-white"> <?=$packages->description;?> </h6>
                                        </div>
                                        <input type="hidden" name="package_id" id="" value="<?=$packages->id;?> ">
                                        <input type="hidden" name="price" id="" value="<?=$packages->price;?> ">
                                        <input type="hidden" name="no_of_days" id="" value="<?=$packages->duration_in_days;?> ">
                                        <input type="hidden" name="max_room" id="max_room" value="<?=$packages->max_room;?> ">
                                        <input type="hidden" name="enterroom" id="enterroom" >
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="number" name="room[]" id="room" class="form-control" min="<?=$packages->min_room;?>" max="<?=$packages->max_room;?>" placeholder="Enter Room">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <center>
                                                <button type="button" onclick="step_4('<?=$packages->name;?>',<?=$packages->id;?>,<?=$packages->max_room;?>)" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue  mr-1 mb-1 disablebtn" >Continue</button>
                                               
                                            </center>
                                        </div>
                                      </div>
                                    </div>
                                    <?php endforeach;?>
                                    </div>  
                                        </form>
                                </div>

                            </div>
                        </div>
                      </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?=base_url()?>static/app-assets/js/scripts/jquery.validate.js"></script> -->
      <!-- BEGIN: Vendor JS-->
      <script src="<?=base_url()?>static/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- <script src="<?=base_url()?>static/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script> -->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?=base_url()?>static/app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?=base_url()?>static/app-assets/js/core/app.js" type="text/javascript"></script>

    <!-- END: Theme JS-->
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <!-- BEGIN: Page JS-->
    <script src="<?=base_url()?>static/app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
    <!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->
    <!-- <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script> -->
      
      <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
        
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
      <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
      
      <script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePasswordElements = document.querySelectorAll('.toggle-password');

    togglePasswordElements.forEach(togglePassword => {
        togglePassword.addEventListener('click', function() {
            // Get all password fields with the specified class
            const passwordFields = document.querySelectorAll('.' + this.getAttribute('data-target'));
            
            passwordFields.forEach(passwordField => {
                // Toggle password visibility
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
            });

            // Toggle eye icon
            this.querySelector('i').classList.toggle('la-eye');
            this.querySelector('i').classList.toggle('la-eye-slash');
        });
    });
});





				function validateLength(input) {
    if (input.value.length > 6) {
        input.value = input.value.slice(0, 6);
    }
}
          function validateHostPassword() {
            var passwordInput = document.getElementById('newpass1');
            var errorMessage = document.getElementById('error-message3');
            var submitButton = document.getElementById('newpasswordbtn');
            var lowercaseRegex = /[a-z]/;
            var uppercaseRegex = /[A-Z]/;
            var digitRegex = /[0-9]/;
            var specialRegex = /[$#@!%&]/;

            var hasLowercase = lowercaseRegex.test(passwordInput.value);
            var hasUppercase = uppercaseRegex.test(passwordInput.value);
            var hasDigit = digitRegex.test(passwordInput.value);
            var hasSpecial = specialRegex.test(passwordInput.value);
            var isLengthValid = passwordInput.value.length >= 8;

            if (!(hasLowercase && hasUppercase && hasDigit && hasSpecial && isLengthValid)) {
                errorMessage.textContent = 'Password length should be minimum 8 characters and contain at least one lowercase letter, one uppercase letter, one digit, and one special character ($#@!%&).';
                submitButton.disabled = true;
            } else {
                errorMessage.textContent = '';
                submitButton.disabled = false;
            }
        }


        function validateHostCPassword() {
            var passwordInput = document.getElementById('newcpass1');
            var errorMessage = document.getElementById('error-message4');
            var submitButton = document.getElementById('newpasswordbtn');
            var lowercaseRegex = /[a-z]/;
            var uppercaseRegex = /[A-Z]/;
            var digitRegex = /[0-9]/;
            var specialRegex = /[$#@!%&]/;

            var hasLowercase = lowercaseRegex.test(passwordInput.value);
            var hasUppercase = uppercaseRegex.test(passwordInput.value);
            var hasDigit = digitRegex.test(passwordInput.value);
            var hasSpecial = specialRegex.test(passwordInput.value);
            var isLengthValid = passwordInput.value.length >= 8;

            if (!(hasLowercase && hasUppercase && hasDigit && hasSpecial && isLengthValid)) {
                errorMessage.textContent = 'Password length should be minimum 8 characters and contain at least one lowercase letter, one uppercase letter, one digit, and one special character ($#@!%&).';
                submitButton.disabled = true;
            } else {
                errorMessage.textContent = '';
                submitButton.disabled = false;
            }
        }

            function validateAdminPassword() {
            var passwordInput = document.getElementById('adminnewpass');
            var errorMessage = document.getElementById('error-message5');
            var submitButton = document.getElementById('adminforgotpassbtn');
            var lowercaseRegex = /[a-z]/;
            var uppercaseRegex = /[A-Z]/;
            var digitRegex = /[0-9]/;
            var specialRegex = /[$#@!%&]/;

            var hasLowercase = lowercaseRegex.test(passwordInput.value);
            var hasUppercase = uppercaseRegex.test(passwordInput.value);
            var hasDigit = digitRegex.test(passwordInput.value);
            var hasSpecial = specialRegex.test(passwordInput.value);
            var isLengthValid = passwordInput.value.length >= 8;

            if (!(hasLowercase && hasUppercase && hasDigit && hasSpecial && isLengthValid)) {
                errorMessage.textContent = 'Password length should be minimum 8 characters and contain at least one lowercase letter, one uppercase letter, one digit, and one special character ($#@!%&).';
                submitButton.disabled = true;
            } else {
                errorMessage.textContent = '';
                submitButton.disabled = false;
            }
        }


        function validateAdminCPassword() {
            var passwordInput = document.getElementById('adminnewcpass');
            var errorMessage = document.getElementById('error-message6');
            var submitButton = document.getElementById('adminforgotpassbtn');
            var lowercaseRegex = /[a-z]/;
            var uppercaseRegex = /[A-Z]/;
            var digitRegex = /[0-9]/;
            var specialRegex = /[$#@!%&]/;

            var hasLowercase = lowercaseRegex.test(passwordInput.value);
            var hasUppercase = uppercaseRegex.test(passwordInput.value);
            var hasDigit = digitRegex.test(passwordInput.value);
            var hasSpecial = specialRegex.test(passwordInput.value);
            var isLengthValid = passwordInput.value.length >= 8;

            if (!(hasLowercase && hasUppercase && hasDigit && hasSpecial && isLengthValid)) {
                errorMessage.textContent = 'Password length should be minimum 8 characters and contain at least one lowercase letter, one uppercase letter, one digit, and one special character ($#@!%&).';
                submitButton.disabled = true;
            } else {
                errorMessage.textContent = '';
                submitButton.disabled = false;
            }
        }


        
        
                                      
      $('input[type="file"]').bind('change', function() {
        var fileSizeInBytes=(this.files[0].size);
        //alert(a);
        var fileSizeInKB = fileSizeInBytes / 1024; // Convert bytes to KB
        if(fileSizeInKB > 100) {
            alert_toastr('error','Maximum file size should be 100 KB.');
            $('button[type=submit]').prop('disabled', true);
            $('#profile-pic').removeClass('onchange-submit');
        }else{
            $('button[type=submit]').prop('disabled', false);
           // $('#profile-pic').removeClass('onchange-submit');
        }
    });
</script>

<script>
        function alert_toastr(type, message) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr[type](message);
        }

    </script>
<script>
 $(document).on("submit", '.ajaxsubmit-enquiry', function(event) {
event.preventDefault();
$this = $(this);

if ($this.hasClass("append")) {
    var append_data = $($this.attr('append-data')).val();
    $(this).append('<input type="hidden" name="append" value="' + append_data + '" /> ');
}
$.ajax({
    url: $this.attr("action"),
    type: $this.attr("method"),
    data: new FormData(this),
    cache: false,
    contentType: false,
    processData: false,
    success: function(data) {
        console.log(data);
        // return false;
        data = JSON.parse(data);

        if (data.res == 'success') {
            alert(data.msg);
            window.location.href='<?=base_url('login');?>';

            
        }
        alert_toastr(data.res, data.msg);
    }
})
return false;
})
</script>

      <script type="text/javascript">
    function ValidateEmail() {
        var email = document.getElementById("adminemail").value;
        var lblError = document.getElementById("lblError");
        lblError.innerHTML = "";
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!expr.test(email)) {
            lblError.innerHTML = "Invalid email address.";
        }
    }
</script>
    <script type="text/javascript">
        
      $(document).ready(function(){
        $("#adminforgotbtn").click(function(){
          $("#admin-login").hide();
          $("#check-admin-email").show();
          $("#newadmin").show();
          $("#oldadmin").css("display","none");
          $("#adminotpforgot").css('display','none')
          $("#adminverifyotpforgot").css('display','none')
          
        });
        $("#AdminForgotEmailPage").click(function(){
          $("#admin-login").show();
          $("#check-admin-email").hide();
          $("#newadmin").hide();
          $("#oldadmin").css("display","block");
          $("#adminotpforgot").css('display','block')
          $("#adminverifyotpforgot").css('display','block')
          
        });
        
        $("#ForgotMobilePage").click(function(){
          $("#verify-mobile-forgot").hide();
          $("#host-login").show();
          $("#oldheading").show();
          $("#newheadingforgot").hide();
        });
        $("#ForgotPasswordPage").click(function(){
          $("#newpassword").hide();
          $("#host-login").show();
          $("#oldheading").show();
          $("#newheadingforgot").hide();
        });
        $("#AccountFirstStep").click(function(){
          $("#verify-mobile").hide();
          $("#host-login").show();
          $("#oldheading").show();
          $("#newheading").hide();
        });
        $("#AccountSecondStep").click(function(){
          $("#registerhere").hide();
          $("#oldDiv").show();
          $("#oldheading").show();
          $("#newheading").hide();
        });
        $("#AccountThirdStep").click(function(){
          $("#step_3").hide();
          $("#registerhere").show();
          $("#oldheading").show();
          $("#newheading").hide();
        });
        $("#AccountFourthStep").click(function(){
          $("#step_4").hide();
          $("#step_3").show();
          $("#oldheading").show();
          $("#newheading").hide();
        });
      });
        $(document).on('click','[data-toggle="collapse-login"]',function(){
            var data_target_show = $(this).attr('data-target-show');
            var data_target_hide = $(this).attr('data-target-hide');

            $(data_target_show).removeClass('show');
            $(data_target_show).addClass('show');
            $(data_target_hide).removeClass('show');
            

            return false;
        })

    function validatePassword() {
            var passwordInput = document.getElementById('step_3_password');
            var errorMessage = document.getElementById('error-message1');
            var submitButton = document.getElementById('btnsubmit_step2');
            var lowercaseRegex = /[a-z]/;
            var uppercaseRegex = /[A-Z]/;
            var digitRegex = /[0-9]/;
            var specialRegex = /[$#@!%&]/;

            var hasLowercase = lowercaseRegex.test(passwordInput.value);
            var hasUppercase = uppercaseRegex.test(passwordInput.value);
            var hasDigit = digitRegex.test(passwordInput.value);
            var hasSpecial = specialRegex.test(passwordInput.value);
            var isLengthValid = passwordInput.value.length >= 8;

            if (!(hasLowercase && hasUppercase && hasDigit && hasSpecial && isLengthValid)) {
                errorMessage.textContent = 'Password length should be minimum 8 characters and contain at least one lowercase letter, one uppercase letter, one digit, and one special character ($#@!%&).';
                submitButton.disabled = true;
            } else {
                errorMessage.textContent = '';
                submitButton.disabled = false;
            }
        }


        function validateCPassword() {
            var passwordInput = document.getElementById('step_3_cpassword');
            var errorMessage = document.getElementById('error-message2');
            var submitButton = document.getElementById('btnsubmit_step2');
            var lowercaseRegex = /[a-z]/;
            var uppercaseRegex = /[A-Z]/;
            var digitRegex = /[0-9]/;
            var specialRegex = /[$#@!%&]/;

            var hasLowercase = lowercaseRegex.test(passwordInput.value);
            var hasUppercase = uppercaseRegex.test(passwordInput.value);
            var hasDigit = digitRegex.test(passwordInput.value);
            var hasSpecial = specialRegex.test(passwordInput.value);
            var isLengthValid = passwordInput.value.length >= 8;

            if (!(hasLowercase && hasUppercase && hasDigit && hasSpecial && isLengthValid)) {
                errorMessage.textContent = 'Password length should be minimum 8 characters and contain at least one lowercase letter, one uppercase letter, one digit, and one special character ($#@!%&).';
                submitButton.disabled = true;
            } else {
                errorMessage.textContent = '';
                submitButton.disabled = false;
            }
        }
        function validateAadhaarInput(input) {
      // Convert the input to a string to count its length
      const inputLength = input.toString().length;

      // Check if the input length exceeds 12 digits
      if (inputLength > 12) {
        // Trim the input to the first 12 digits
        const truncatedInput = input.slice(0, 12);

        // Update the input value
        document.getElementById('aadhaarNumber').value = truncatedInput;
      }
    }
        function validateAadhaarKeyPress() {
            var aadhaarInput = document.getElementById('aadhaarNumber');
            var errorMessage = document.getElementById('aadhaarErrorMessage');
            
            // Check if the length is 12 after keypress
            if (aadhaarInput.value.length === 12) {
                errorMessage.textContent = ''; // Clear error message
            } else {
                errorMessage.textContent = 'Aadhaar number must be 12 digits.';
            }
        }
function get_step_2_data(mobile)
 {
        $.ajax({
            url: '<?= base_url('Login/getuserdatabyid') ?>',
            type: 'POST',
            data: {mobile: mobile},
            dataType: 'json',
            success: function(data) {
                // Update the result div with the retrieved data
                if(data.error=='true'){  }else{
                if(data.data.email !='')
                {
                     $('#email_validate_icon').css("display","block");
                     $('#email-verifiy').css('display','none');
                }    
                $(".userid").val(data.id);
                $('.email_verification').val(data.data.email);
                $('.name').val(data.data.name);
                $('.email').val(data.data.email);
                $('.aadhaar').val(data.data.aadhaar_no);
                $('.username').val(data.data.username);
                if(data.data.pic !=''){
                $('#pic').html(' <a href="<?php echo IMGS_URL ;?>' + data.data.pic + '" target="_blank"  ><i class="la la-info"></i></a>');
                }
                if(data.data.aadhaar_front !=''){
                $('#pic2').html(' <a href="<?php echo IMGS_URL ;?>' + data.data.aadhaar_front + '" target="_blank"  ><i class="la la-info"></i></a>');
                }
                if(data.data.aadhaar_back !=''){
                $('#pic3').html(' <a href="<?php echo IMGS_URL ;?>' + data.data.aadhaar_back + '" target="_blank"  ><i class="la la-info"></i></a>');
                }
               
                // $('#country').html('<option value=""  selected>'+ data.name+'</option>');
                }
            },
            error: function(error) {
                console.error('There was a problem with the AJAX request:', error);
            }
        });
    };
function get_step_3_data(mobile)
 {
   
        $.ajax({
            url: '<?= base_url('Login/getuserdatabymobile') ?>',
            type: 'POST',
            data: {mobile: mobile},
            dataType: 'json',
            success: function(data) {
                if(data.error=='true'){
                    
                }else{
                // Update the result div with the retrieved data
                 var gst = (data.data.is_gst);
                 if (gst == 'YES') {
            $('.gst-box').show();
            $('.gst-box input').prop('', true);
              }else{
            $('.gst-box').hide();
            $('.gst-box input').prop('', false);
            }
                $("#useralready").val(data.data.username);
                $('.propname').val(data.data.propname);
                $('.propcodename').val(data.data.propcodename);
                $('.contact_preson').val(data.data.contact_preson);
                $('.contact_preson_mobile').val(data.data.contact_preson_mobile);
                $('.Pincode').val(data.data.pincode);
                $('.address').val(data.data.address);
                $('.email_address').val(data.data.proemail);
                $('.checkintime').val(data.data.checkintime);
                $('.checkinupto').val(data.data.checkinupto);
                $('.checkoutupto').val(data.data.checkoutupto);
                $('.checkouttime').val(data.data.checkouttime);
                $('.bill_no').val(data.data.bill_format);
                $('.company_name').val(data.data.company_name);
                $(".country").val(data.data.country );
                $(".property_type_id").val(data.data.property_type_id );
                $(".doc_type_id").val(data.data.doc_type_id );
                $(".is_gst").val(data.data.is_gst );
                if(data.data.document !=''){
                $('#pic4').html(' <a href="<?php echo IMGS_URL ;?>' + data.data.document + '" target="_blank"  ><i class="la la-info"></i></a>');
                }
				if(data.data.logo !=''){
                $('#pic6').html(' <a href="<?php echo IMGS_URL ;?>' + data.data.logo + '" target="_blank"  ><i class="la la-info"></i></a>');
                }
                if(data.data.document !=''){
                $("#picchoose").text(data.data.document);
                }else
                {
                    $("#picchoose").text("Choose File");   
                }
                if(data.data.gst_certificate !=''){
                $('#pic5').html(' <a href="<?php echo IMGS_URL ;?>' + data.data.gst_certificate + '" target="_blank"  ><i class="la la-info"></i></a>');
                }
                if(data.data.gst_certificate !=''){
                $("#pic5choose").text(data.data.gst_certificate);
                }else
                {
                    $("#pic5choose").text("Choose File");   
                }
                   
                $('.old_gst_certificate').val(data.data.gst_certificate);
                $(".gst_no_input").val(data.data.gst_no);
                $('#state').load('<?=base_url()?>getStates/'+data.data.country+'/'+data.data.state);
                $('#city').load('<?=base_url()?>getCities/'+data.data.state+'/'+data.data.city);
                $('#location_id').html('<option value="" >-- Select --</option>');
                $.post('<?=base_url()?>load_locations_new',{state:data.data.state,city:data.data.city,id:data.data.location_id})
                .done(function(data1){
                    data1 = JSON.parse(data1);
                    $('#location_id').html(data1.content);
                })
                .fail(function() {
                    alert( "error" );
                })
            }
            },
            error: function(error) {
                console.error('There was a problem with the AJAX request:', error);
            }
        });
    };
    </script>
    <script type="text/javascript">
    $('#address').keyup(function(){
        var search = $(this).val();
        $('#pac-input').val(search);
    })

    $('#country').change(function() {
        var id = $(this).val();
        $('#state').load('<?=base_url()?>getStates/'+id);
    })

    $('#state').change(function() {
        var id = $(this).val();
        $('#city').load('<?=base_url()?>getCities/'+id);
        //$('#district').load('<?=base_url()?>getDistrict/'+id);
        load_location();
    })

    $('#city').change(function() {
        load_location();
    })

    function load_location(){
        $('#location_id').html('<option value="" >-- Select --</option>');
        var state =  $('#state').val();
        var city  =  $('#city').val();
        $.post('<?=base_url()?>load_locations_new',{state:state,city:city})
        .done(function(data){
            
            data = JSON.parse(data);
            console.log(data);
            $('#location_id').html(data.content);
        })
        .fail(function() {
            alert( "error" );
          })

    }    

    $(document).on('change', '[name=is_gst]', function(){
        let value = $(this).val();
        if (value == 'YES') {
            $('.gst-box').show();
            $('.gst-box input').prop('', true);
        }else{
            $('.gst-box').hide();
            $('.gst-box input').prop('', false);
        }
    });
    
</script>
    <!-- END: Page JS-->
    <?php if ($flag == 1) { ?>
    <script>
        // Check if jQuery is loaded
        if (typeof jQuery !== 'undefined') {
            console.log('jQuery is loaded!');
            $(document).ready(function () {
                console.log('Document is ready!');
                    console.log('Button clicked!');
                    $("#host-login").hide();
                    $("#verify-mobile").show();
                    $("#oldheading").hide();
                    $("#newheading").show();
            });
        } else {
            console.log('jQuery is NOT loaded!');
        }
    </script>
<?php } ?>

<script>
    
     $(document).ready(function(){
        $("#createbtn").click(function(){
          $("#host-login").hide();
          $("#verify-mobile").show();
          $("#oldheading").hide();
          $("#newheading").show();
        });
        $("#forgotbtn").click(function(){
          $("#host-login").hide();
          $("#verify-mobile-forgot").show();
          $("#oldheading").hide();
          $("#newheadingforgot").show();
        });
        $("#closemodal").click(function(){
          $("#exampleModal").hide();
		  $('#email-verifiy').css("display","block");
        });
        
      });
  
</script>
<script type="text/javascript">
$(document).ready(function() {
        $(".validate-new-form").validate({
       
       rules: {
           name:"required",
           password:"required",
           cpassword:"required",
           username:{
               required:true,
               remote:"<?=$remote?>"
           }
       },
       messages: {
           name:"Please Enter   Name",
           password:"Please Enter Password",
           cpassword:"Please Enter Confirm Password",
           username: {
               required : "Please Enter Unique Username.",
              remote : "This Username Already Exist!"
           }
       },
       submitHandler: function(form, event) { 
    event.preventDefault();
   // alert("Do some stuff...");
    //submit via ajax
  }
   
   });  

   $(".validate-new-form-step-3").validate({
       
       rules: {
           propname:"required",
           country:"required",
           state:"required",
           city:"required",
           pincode:"required",
           property_type_id:"required",
           address:"required",
           checkintime:"required",
           checkinupto:"required",
           checkouttime:"required",
           checkoutupto:"required",
       },
       messages: {
           propname:"Please enter property name",
           country:"Please select country",
           state:"Please select state",
           city:"Please select city",
           pincode:"Please enter pincode",
           property_type_id:"Please select property types",
           address:"Please select address ",
           checkintime:"Please select checkin time",
           checkinupto:"Please select checkin upto",
           checkouttime:"Please select checkout time",
           checkoutupto:"Please select checkout upto",
       },
       submitHandler: function(form, event) { 
    event.preventDefault();
   // alert("Do some stuff...");
    //submit via ajax
  }
   
   }); 

});
</script>
<script type="text/javascript">
			$(document).ready(function(){
				function validate_mobile(mob){

					var pattern =  /^[6-9]\d{9}$/;

					if (mob == '') {

						return false;
					}else if (!pattern.test(mob)) {

						return false;
					}else{

						return true;
					}
				}


				//send otp function
				function send_otp(mob){
                    $('#spinner-div3').show();
						var ch = "send_otp";
							$.ajax({

							url: "<?=base_url('new-account/checkmobile');?>",
							method: "post",
							data: {mob:mob,ch:ch},
							dataType: "text",
							success: function(data){

								if (data == 'Otp Send Your Mobile Number') {

									$('#mobilediv').css("display","none");
									$('#sendotp').css("display","none");
                                    $('#otpdiv').css("display","block");
									$('#verifyotp').css("display","block");
									$("#host-login").css("display","none");
                                    $('#usermobile').val(mob);
                                    $('#usermobile1').val(mob);
                                    $('#usermobile2').val(mob);
									timer();
									$('.otp_msg1').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">Otp Send Your Mobile Number</div>').fadeIn();
								    get_step_2_data(mob);
                                    get_step_3_data(mob);		
									window.setTimeout(function(){
										$('.otp_msg1').fadeOut();
									},2000)
                                    $('#spinner-div3').hide();

								}else{
									$('.otp_msg1').html('<div class="alert text-danger">' + data + '</div>').fadeIn();
										
										window.setTimeout(function(){
										$('.otp_msg1').fadeOut();
									},2000)
                                    $('#spinner-div3').hide();
								
								}
							}

						});
				}
				//end of send otp function
                	//send otp function
function send_otpforgot(mob){
    $('#spinner-div1').show();
var ch = "send_otp";
    
    $.ajax({

    url: "<?=base_url('forgot-password/checkmobile');?>",
    method: "post",
    data: {mob:mob,ch:ch},
    dataType: "text",
    success: function(data){

        if (data == 'Otp Send Your Mobile Number') {

            $('#mobiledivforgot').css("display","none");
            $('#sendotpforgot').css("display","none");
            $('#otpdivforgot').css("display","block");
            $('#verifyotpforgot').css("display","block");
            $("#host-login").css("display","none");
            $('#usermobileforgot').val(mob);
            timerforgot();
            $('.otp_msg1').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">Otp Send Your Mobile Number</div>').fadeIn();
            get_step_2_data(mob);
            get_step_3_data(mob);		
                window.setTimeout(function(){
                $('.otp_msg1').fadeOut();
            },2000)
            $('#spinner-div1').hide();

        }else{
            $('.otp_msg1').html('<div class="alert text-danger">' + data + '</div>').fadeIn();
                
                window.setTimeout(function(){
                $('.otp_msg1').fadeOut();
            },2000)
            $('#spinner-div1').hide();
        
        }
    }

});
}
                	//send otp function

				$('#sendotp').click(function(){
                    var checkbox = document.getElementById("myCheckbox");
                   var value = checkbox.checked ? 1 : 0;
                   var mob = $('#mob').val();
                  
                   if(mob !=''){
                    if(validate_mobile(mob)== true){
                   if(value==1){
                    if (validate_mobile(mob) == false) $('.otp_msg').html('<div class="alert text-danger" style="position:absolute">Enter Valid mobile number</div>').fadeIn(); else 	send_otp(mob);
                   window.setTimeout(function(){
                   $('.otp_msg').fadeOut();
                    },2000)
                     }else
                     {
                        $('.otp_msg').html('<div class="alert text-danger" style="position:absolute">Please check terms conditions & privacy policy</div>').fadeIn();
                        window.setTimeout(function(){
                         $('.otp_msg').fadeOut();
                         },2000)
                     }
                    }else
                    {
                        $('.otp_msg').html('<div class="alert text-danger" style="position:absolute">Please enter a valid number</div>').fadeIn();
                        window.setTimeout(function(){
                         $('.otp_msg').fadeOut();
                         },2000)
                    }
                    }else
                    {
                        $('.otp_msg').html('<div class="alert text-danger" style="position:absolute">Please Enter Mobile Number</div>').fadeIn();
                        window.setTimeout(function(){
                         $('.otp_msg').fadeOut();
                         },2000)
                    }
                 });
$('#adminsendotpforgot').click(function(){
           var email = $('#adminemail').val();
           admin_send_otpforgot(email);
});
function admin_send_otpforgot(email){
    $('#spinner-div10').show();
var ch = "send_otp";
    
    $.ajax({

    url: "<?=base_url('forgot-password/checkemail_admin');?>",
    method: "post",
    data: {email:email},
    dataType: "text",
    success: function(data){

        if (data == 'Otp Send Your Email Address') {
          $("#admin-login").hide();
          $("#check-admin-email").show();
          $("#newadmin").show();
          $("#oldadmin").css("display","none");
          $("#adminotpforgot").css('display','block')
          $("#adminemailforgot").css('display','none')
          $("#adminsendotpforgot").css('display','none')
          
          $("#adminverifyotpforgot").css('display','block')
          $("#adminemailgive").val(email);
            admintimerforgot();
            $('.otp_msg1').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">Otp Send Your Email Address</div>').fadeIn();	
                window.setTimeout(function(){
                $('.otp_msg1').fadeOut();
            },2000)
            $('#spinner-div10').hide();

        }else{
            $('.otp_msg1').html('<div class="alert text-danger">' + data + '</div>').fadeIn();
                
                window.setTimeout(function(){
                $('.otp_msg1').fadeOut();
            },2000)
            $('#spinner-div10').hide();
        
        }
    }

});
}
//end of send otp function


//resend otp function
$('#resend_otp').click(function(){
var mob = $('#mob').val();
send_otp(mob);
    $(this).hide();
});
$('#resend_otp_forgot').click(function(){
var mob = $('#mobforgot').val();
send_otpforgot(mob);
    $(this).hide();
});

$('#sendotpforgot').click(function(){
           var mob = $('#mobforgot').val();
    if (validate_mobile(mob) == false) $('.otp_msg').html('<div class="alert text-danger" style="position:absolute">Enter Valid mobile number</div>').fadeIn(); else 	send_otpforgot(mob);

    window.setTimeout(function(){
        $('.otp_msg').fadeOut();
    },2000)
});

$('#admin_resend_otp_forgot').click(function(){
var email = $('#adminemail').val();
admin_send_otpforgot(email);
    $(this).hide();
});
//end of resend otp function


//verify otp function starts

$('#verifyotp').click(function(){
    
    var ch = "verify_otp";
    var otp = $('#otp').val();
    $.ajax({

        url: "<?=base_url();?>new-account/checkotp",
        method: "post",
        data: {otp:otp,ch:ch},
        dataType: "text",
        success: function(data){

                if (data == "OTP Correct") {
                    
                    $('#registerhere').css("display","block");
					$("#oldDiv").css("display","none");
                    $('.otp_msg1').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">' + data + '</div>').show().fadeOut(4000);                
                }else{

                    $('.otp_msg1').html('<div class="alert text-danger">' + data + '</div>').show().fadeOut(4000);
                }
        }
    });
            

});
$('#verifyotpforgot').click(function(){

var ch = "verify_otp";
var otp = $('#otpforgot').val();
$.ajax({

    url: "<?=base_url();?>forgot-password/checkotp",
    method: "post",
    data: {otp:otp,ch:ch},
    dataType: "text",
    success: function(data){

            if (data == "OTP Correct") {
                
                $('#newpassword').css("display","block");
                $("#oldDiv").css("display","block");
                $("#verify-mobile-forgot").css("display","none");
                $('.otp_msg1').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">' + data + '</div>').show().fadeOut(4000);
            }else{

                $('.otp_msg1').html('<div class="alert text-danger">' + data + '</div>').show().fadeOut(4000);
            }
    }
});
        

});
$('#adminverifyotpforgot').click(function(){

var ch = "verify_otp";
var otp = $('#emailforgot').val();
$.ajax({

    url: "<?=base_url();?>forgot-password/adminverifyotpforgot",
    method: "post",
    data: {otp:otp,ch:ch},
    dataType: "text",
    success: function(data){

            if (data == "OTP Correct") {
                $("#admin-login").hide();
               $("#check-admin-email").hide();
                $("#admin_forgot_pass").css("display","block");
                $('.otp_msg1').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">' + data + '</div>').show().fadeOut(4000);
            }else{

                $('.otp_msg1').html('<div class="alert text-danger">' + data + '</div>').show().fadeOut(4000);
            }
    }
});
        

});
$('#adminforgotpassbtn').click(function(){

$('#spinner-div11').show();
var ch = "verify_otp";
var email = $('.adminemailgive').val();
var  password = $('#adminnewpass').val();
var  cpassword = $('#adminnewcpass').val();
if(password  == cpassword)
{
$.ajax({

url: "<?=base_url();?>forgot-password/admin_submit_password",
method: "post",
data: {email:email,password:password,cpassword:cpassword},
dataType: "text",
success: function(data){

        if (data == "success") {
            
            window.setTimeout(function(){
                        location.reload();
                      },2000)
            $('.otp_msg1').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">Password Reset Successfully!</div>').show().fadeOut(4000);
            $('#spinner-div11').hide();                                 
        }else{

            $('.otp_msg1').html('<div class="alert text-danger">Failed</div>').show().fadeOut(4000);
            $('#spinner-div11').hide();
        }
}
});
}else
{
$('.otp_msg1').html('<div class="alert text-danger">Password & Confirm Password  does not match!.</div>').show().fadeOut(4000);
$('#spinner-div').hide();
}   

});

$('#newpasswordbtn').click(function(){

    $('#spinner-div2').show();
var ch = "verify_otp";
var mobile = $('.usermobileforgot').val();
var  password = $('#newpass1').val();
var  cpassword = $('#newcpass1').val();
if(password  == cpassword)
{
$.ajax({

    url: "<?=base_url();?>forgot-password/submit_password",
    method: "post",
    data: {mobile:mobile,password:password,cpassword:cpassword},
    dataType: "text",
    success: function(data){

            if (data == "success") {
                
                window.setTimeout(function(){
                            location.reload();
                          },2000)
                $('.otp_msg1').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">Password Reset Successfully!</div>').show().fadeOut(4000);
                $('#spinner-div2').hide();                                 
            }else{

                $('.otp_msg1').html('<div class="alert text-danger">Failed</div>').show().fadeOut(4000);
                $('#spinner-div2').hide();
            }
    }
});
}else
{
    $('.otp_msg1').html('<div class="alert text-danger">Password & Confirm Password  does not match!.</div>').show().fadeOut(4000);
    $('#spinner-div').hide();
}   

});
function admintimerforgot(){

var timer2 = "00:31";
var interval = setInterval(function() {


  var timer = timer2.split(':');
  //by parsing integer, I avoid all extra string processing
  var minutes = parseInt(timer[0], 10);
  var seconds = parseInt(timer[1], 10);
  --seconds;
  minutes = (seconds < 0) ? --minutes : minutes;
  
  seconds = (seconds < 0) ? 59 : seconds;
  seconds = (seconds < 10) ? '0' + seconds : seconds;
  //minutes = (minutes < 10) ?  minutes : minutes;
  $('.countdown').html("Resend otp in:  <b class='text-primary'>"+ minutes + ':' + seconds + " seconds </b>");
  //if (minutes < 0) clearInterval(interval);
  if ((seconds <= 0) && (minutes <= 0)){
      clearInterval(interval);
      $('.countdown').html('');
      $('#admin_resend_otp_forgot').css("display","block");
  } 
  timer2 = minutes + ':' + seconds;
}, 1000);

}
function timerforgot(){

var timer2 = "00:31";
var interval = setInterval(function() {


  var timer = timer2.split(':');
  //by parsing integer, I avoid all extra string processing
  var minutes = parseInt(timer[0], 10);
  var seconds = parseInt(timer[1], 10);
  --seconds;
  minutes = (seconds < 0) ? --minutes : minutes;
  
  seconds = (seconds < 0) ? 59 : seconds;
  seconds = (seconds < 10) ? '0' + seconds : seconds;
  //minutes = (minutes < 10) ?  minutes : minutes;
  $('.countdown').html("Resend otp in:  <b class='text-primary'>"+ minutes + ':' + seconds + " seconds </b>");
  //if (minutes < 0) clearInterval(interval);
  if ((seconds <= 0) && (minutes <= 0)){
      clearInterval(interval);
      $('.countdown').html('');
      $('#resend_otp_forgot').css("display","block");
  } 
  timer2 = minutes + ':' + seconds;
}, 1000);

}

//end of verify otp function


//start of timer function

function timer(){

var timer2 = "00:31";
var interval = setInterval(function() {


  var timer = timer2.split(':');
  //by parsing integer, I avoid all extra string processing
  var minutes = parseInt(timer[0], 10);
  var seconds = parseInt(timer[1], 10);
  --seconds;
  minutes = (seconds < 0) ? --minutes : minutes;
  
  seconds = (seconds < 0) ? 59 : seconds;
  seconds = (seconds < 10) ? '0' + seconds : seconds;
  //minutes = (minutes < 10) ?  minutes : minutes;
  $('.countdown').html("Resend otp in:  <b class='text-primary'>"+ minutes + ':' + seconds + " seconds </b>");
  //if (minutes < 0) clearInterval(interval);
  if ((seconds <= 0) && (minutes <= 0)){
      clearInterval(interval);
      $('.countdown').html('');
      $('#resend_otp').css("display","block");
  } 
  timer2 = minutes + ':' + seconds;
}, 1000);

}
function timer1(){

var timer2 = "00:31";
var interval = setInterval(function() {


  var timer = timer2.split(':');
  //by parsing integer, I avoid all extra string processing
  var minutes = parseInt(timer[0], 10);
  var seconds = parseInt(timer[1], 10);
  --seconds;
  minutes = (seconds < 0) ? --minutes : minutes;
  
  seconds = (seconds < 0) ? 59 : seconds;
  seconds = (seconds < 10) ? '0' + seconds : seconds;
  //minutes = (minutes < 10) ?  minutes : minutes;
  $('.countdown1').html("Resend otp in:  <b class='text-primary'>"+ minutes + ':' + seconds + " seconds </b>");
  //if (minutes < 0) clearInterval(interval);
  if ((seconds <= 0) && (minutes <= 0)){
      clearInterval(interval);
      $('.countdown1').html('');
      $('#resend_otp1').css("display","block");
  } 
  timer2 = minutes + ':' + seconds;
}, 1000);

}
// var userEmail = "example@example.com";
// if (validateEmail(userEmail)) {
//   console.log("Email is valid");
// } else {
//   console.log("Email is not valid");
// }
//end of timer
$('#email-verifiy').click(function(){
    $('#btnsubmit_step2').prop('disabled', true);
     var email = $('#email').val();
	 if(email !=''){
    if (email == '') $('.otp_msg2').html('<div class="alert text-danger" style="position:absolute">Enter Valid Email Address</div>').fadeIn(); else 	send_mail_otp(email);

    window.setTimeout(function(){
        $('.otp_msg2').fadeOut();
    },2000)
 }else{
	$('.error-email').html('<div class="alert text-danger" style="position:absolute">Please enter email address</div>').fadeIn();
 } 
  
});
$('#btnsubmit_step2').click(function() {
    if ($(this).prop('disabled')) {
        alert('Please validate email then fill the next step.');
    }
});
function send_mail_otp(email){
    $('#spinner-div').show();
	$('.error-email').html('<div class="alert text-success" style="position:absolute">Loading....</div>').fadeIn();
   var ch = "send_otp";
    
    $.ajax({

    url: "<?=base_url('new-account/checkmail');?>",
    method: "post",
    data: {email:email,ch:ch},
    dataType: "text",
    success: function(data){

        if (data == 'Otp Send Your Email Address') {

            $('#mobilediv').css("display","none");
            $('#email-verifiy').css("display","none");
            $("#host-login").css("display","none");
            $('#email-otp-div').css("display","block")
            $('#exampleModal').show();
			$('.error-email').html('<div class="alert text-success" style="position:absolute">Loading....</div>').fadeOut();
            timer1();
            $('.otp_msg3').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">' + data + '</div>').fadeIn();
                
                window.setTimeout(function(){
                $('.otp_msg3').fadeOut();
            },2000)
                
            $('#spinner-div').hide();
        }else{
            $('.otp_msg3').html('<div class="alert text-danger">' + data + '</div>').fadeIn();
                
                window.setTimeout(function(){
                $('.otp_msg3').fadeOut();
            },2000)
            $('#spinner-div').hide();
        
        }
    }

});
}

//resend otp function
$('#resend_otp1').click(function(){
var email = $('#email').val();
send_mail_otp(email);
    $(this).hide();
});
//end of resend otp function


});

$(document).on("submit", '.chechmailotp', function(event) {
    //alert("Hello");
    $('#spinner-div').show();
    event.preventDefault(); 
    $this = $(this);
    if ($this.hasClass("append")) {
        var append_data = $($this.attr('append-data')).val();
        $(this).append('<input type="hidden" name="append" value="'+append_data+'" /> ');

    }
    var form_data = new FormData(this);
    form_valid = true;

    setTimeout(function() {
        if (form_valid == true) {
            $.ajax({
                url: $this.attr("action"),
                type: $this.attr("method"),
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.res=='success') {
                        $('#mobilediv').css("display","none");
                        $('#email-verifiy').css("display","none");
                        $("#host-login").css("display","none");
                        $('#email-otp-div').css("display","none")
                        $('#email_validate_icon').css("display","block");
                        $('#exampleModal').hide();
                        $('#email_verification').val(data.email)
                        $('.otp_msg3').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">Email Validate Successfull.</div>').fadeIn();
                        $('#btnsubmit_step2').prop('disabled', false);
                window.setTimeout(function(){
                $('.otp_msg2').fadeOut();
                      },2000)
                      $('#spinner-div').hide();
                    }else
                    {
                        $('.otp_msg3').html('<div class="alert text-danger">' + data.msg + '</div>').fadeIn();
                
                window.setTimeout(function(){
                $('.otp_msg3').fadeOut();
            },2000)
            $('#spinner-div').hide();
                    }
                    if (data.errors) {
                        $.each(data.errors,function(key,value){
                            $this.find(`[name="${key}"]`).parents(`.form-group`).find(`.error`).text(value);
                        })
                        $('#spinner-div').hide();
                    }
                   // alert_toastr(data.res,data.msg);
                    ///loadtb();
                 
                }
                
            })
        }
    }, 100);

    return false;
})
$(document).on("submit", '.ajaxsubmit', function(event) {
    $('#spinner-div4').show();
    event.preventDefault(); 
    $this = $(this);
    if ($this.hasClass("append")) {
        var append_data = $($this.attr('append-data')).val();
        $(this).append('<input type="hidden" name="append" value="'+append_data+'" /> ');

    }
    var form_data = new FormData(this);
    form_valid = true;

    if ($this.hasClass("validate-new-form")) {
        if ($this.valid()) {
            form_valid = true;
        }
        else{
            form_valid = true;
        }
    }

    setTimeout(function() {
        if (form_valid == true) {
            $.ajax({
                url: $this.attr("action"),
                type: $this.attr("method"),
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.res=='success') {
                        
                        $('#registerhere').css("display","none")
                        $('#step_3').css("display","block");
                        $('.otp_msg2').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">' + data.msg + '</div>').fadeIn();
                        window.setTimeout(function(){
                $('.otp_msg2').fadeOut();
            },2000)
            $('#spinner-div4').hide();
                      
                    }else{
                    if (data.errors) {
                        $.each(data.errors,function(key,value){
                            $this.find(`[name="${key}"]`).parents(`.form-group`).find(`.error`).text(value);
                        })
                        $('#spinner-div4').hide();
                    }
                    $('.otp_msg2').html('<div class="alert text-danger" >' + data.msg + '</div>').fadeIn();
                    window.setTimeout(function(){
                $('.otp_msg2').fadeOut();
            },2000)
            $('#spinner-div4').hide();
        }
                }
                
            })
        }
    }, 100);

    return false;
})
$(document).on("submit", '.ajaxsubmit_accout_step_3', function(event) {
    //alert("Hello");
    $('#spinner-div6').show();
    event.preventDefault(); 
    $this = $(this);
    if ($this.hasClass("append")) {
        var append_data = $($this.attr('append-data')).val();
        $(this).append('<input type="hidden" name="append" value="'+append_data+'" /> ');

    }
    var form_data = new FormData(this);
    form_valid = true;
    if ($this.hasClass("validate-new-form-step-3")) {
        if ($this.valid()) {
            form_valid = true;
        }
        else{
            form_valid = true;
        }
    }
    setTimeout(function() {
        if (form_valid == true) {
            $.ajax({
                url: $this.attr("action"),
                type: $this.attr("method"),
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.res=='success') {
                        $('#step_3').css("display","none")
                        $('#step_4').css("display","block");
                        $('.otp_msg2').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">Property  selected successfully.</div>').fadeIn();
                        window.setTimeout(function(){
                $('.otp_msg2').fadeOut();
            },2000)
            $('#spinner-div6').hide();
                    }else
                    {
                        $('.otp_msg2').html('<div class="alert text-danger">' + data.msg + '</div>').fadeIn();
                
                window.setTimeout(function(){
                $('.otp_msg2').fadeOut();
            },2000)
            $('#spinner-div6').hide();
                    }
                    if (data.errors) {
                        $.each(data.errors,function(key,value){
                            $this.find(`[name="${key}"]`).parents(`.form-group`).find(`.error`).text(value);
                        })
                        $('#spinner-div6').hide();
                    }
                   // alert_toastr(data.res,data.msg);
                    ///loadtb();
                 
                }
                
            })
        }
    }, 100);

    return false;
})
 
    $('body').on('keyup','[name="room[]"]',function(e){
        let _this = $(this);
        _this.each(function(index, element) {
        var secondInputValue = $(element).val();
        $("#enterroom").val(secondInputValue);
    });
    })
     function step_4(name,id,max_room)
        {
            let btn = $('#disablebtn');
            let btn_text = btn.text();
            var mobile = $(".usermobile2").val();
            var room = $("#enterroom").val();
            if(room > max_room && name !=='Custom Plan')
            {
             $('#spinner-div7').hide();
             $('.otp_msg2').html('<div class="alert text-danger">Sorry Please enter correct number of rooms.</div>').fadeIn();
              window.setTimeout(function(){
              $('.otp_msg2').fadeOut();
            },2000)
            alert("Sorry Please enter correct number of rooms.");
            }else{
            $('#spinner-div7').show();
            $.ajax({
              url:"<?=base_url();?>new-account/accout_step_4",
              type:"POST",
              data:{name:name,mobile:mobile,package_id:id,room:room},
              dataType:"JSON",
              beforeSend: function() {
              btn.attr('disabled', true).text('Please Wait').css('padding','6px 8px');
              },
              success:function(res)
              {
                $('#spinner-div7').hide();
                if (res.flag === 'notpaymentresponse') {
                    alert_toastr('success','Your registration has been successful with My Hotel Reception. Your account will be activated within 24 hours after document verification.');
                    $('.otp_msg2').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">Your registration has been successful with My Hotel Reception. Your account will be activated within 24 hours after document verification.</div>').fadeIn(); 
                    window.setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else
            if (res.flag === 'success') {
                $('.otp_msg2').html('<div class="alert text-success" style="color:#006400;font-size:1.5rem">Please wait redirecting payment gateway.</div>').fadeIn();            
                var obj = JSON.parse(res.data);
                var options = {
                "key": obj.secret_key, 
                "amount": parseFloat(obj.total)*100,
                "currency": "INR",
                "name": "HotelReception",
                "description": "HotelReception online payments",
                //"image": "<?//= IMGS_URL.$shop_detail->logo ?>",
                "account_id": null,
                "order_id": obj.order_id_razor,
                "handler": function (response){
                    $.ajax({
                        url: "<?=base_url();?>new-account/verify_payment",
                        method: "POST",
                        dataType:"JSON",
                        data: {
                            razorpay_payment_id : response.razorpay_payment_id,
                            razorpay_order_id : response.razorpay_order_id,
                            razorpay_signature : response.razorpay_signature,
                            order_idrazor : obj.order_id_razor,
                        },
                        success: function(data)
                        {
                            if(data == 'true' || data == true)
                            {
                                $.ajax({
                                    url: "<?=base_url();?>new-account/update_order_status",
                                    method: "POST",
                                    data: {
                                        payment_gateway : 'Razorpay',
                                        order_id : res.order_id,
                                        payment_id : response.razorpay_payment_id,
                                        signature : response.razorpay_signature,
                                        razorpay_ord_id : response.razorpay_order_id,
                                        total : parseFloat(obj.total),
                                    },
                                    success: function(data)
                                    {
                                        if(data == 'success')
                                        {
                                            window.location = "thanks";
                                        }else{
                                             toastr.error('Status Not Updated');
                                        }
                                    },
                                });
                            }else{
                                $.ajax({
                                    url: "<?=base_url();?>new-account/update_order_status_failed",
                                    method: "POST",
                                    data: {
                                        payment_gateway : 'Razorpay',
                                        order_id : res.order_id,
                                        payment_id : response.razorpay_payment_id,
                                        signature : response.razorpay_signature,
                                        razorpay_ord_id : response.razorpay_order_id,
                                        total : parseFloat(obj.total),
                                    },
                                    success: function(data)
                                    {
                                        if(data == 'success')
                                        {
                                            window.location = "";
                                        }else{
                                             toastr.error('Status Not Updated');
                                        }
                                    },
                                });
                                 toastr.error('Payment failed');
                            }
                        },
                    });
                },
                "modal": {
                    "ondismiss": function(){
                        $.ajax({
                                    url: "<?=base_url();?>new-account/update_failed_payment",
                                    method: "POST",
                                    data: {
                                        payment_gateway : 'Razorpay',
                                        order_id : res.order_id,
                                        total : parseFloat(obj.total)
                                    },
                                    success: function(data)
                                    {
                                        if(data == 'success')
                                        {
                                            window.location = "";
                                        }else{
                                             toastr.error('Status Not Updated');
                                        }
                                    },
                                });
                       

                    }
                },
                "prefill": {
                    "name": res.user_name,
                    "email": res.user_email,
                    "contact": res.user_mobile
                },
                "notes": {
                    "address": "Razorpay Corporate Office"
                },
                "theme": {
                    "color": "#3399cc"
                }
                    	            };
                    	            var rzp1 = new Razorpay(options);
                    	            rzp1.on('payment.failed', function (response){
                    // alert(response.error.code);
                     toastr.error(response.error.description);
                    // alert(response.error.source);
                    // alert(response.error.step);
                    // alert(response.error.reason);
                    // alert(response.error.metadata.order_id);
                    // alert(response.error.metadata.payment_id);
                       $.ajax({
                                    url: "<?=base_url();?>new-account/update_order_status_failure",
                                    method: "POST",
                                    data: {
                                        payment_gateway : 'Razorpay',
                                        order_id : res.order_id,
                                        payment_id :response.error.metadata.payment_id,
                                        signature : response.error.metadata.signature,
                                        razorpay_ord_id : response.error.metadata.order_id,
                                        total : parseFloat(obj.total),
                                    },
                                    success: function(data)
                                    {
                                        if(data == 'success')
                                        {
                                            window.location = "";
                                        }else{
                                             toastr.error('Status Not Updated');
                                        }
                                    },
                                });
                    	            });
                    	            rzp1.open();
            } else {
                $('.otp_msg2').html('<div class="alert text-danger">Sorry, please try again later.</div>').fadeIn();

                window.setTimeout(function () {
                    $('.otp_msg2').fadeOut();
                }, 2000);
            }
              },
              error: function (response) {
              toastr.error('Something went wrong. Please try again!');
              btn.attr('disabled', false).text(btn_text);
              }
            });
        }

        }


     
</script>

  
</body>
<!-- END: Body-->

</html>
