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
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/vendors/css/extensions/toastr.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/app-assets/css/pages/login-register.css">
   
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

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
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-6 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                                <div class="card-header border-0">
                                    <div class="text-center mb-1">
                                        <img src="<?=base_url()?>static/app-assets/images/logo/logo.png" alt="branding logo" style="width:100px;">
                                    </div>                                    
                                </div>
                                <div class="card-content">
                                    <div class="card-body pt-0 collapse show" id="host-login">
                                        <form class="form-horizontal" id="register-mobile" action="" novalidate method="POST">
                                            <div class="font-large-1  text-center">Forget Password</div>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control round" name="username" placeholder="Your Username"  required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>                                            
                                            
                                            <div class="form-group text-center">
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" onclick="get_otp(this)">Get OTP</button>                                                
                                            </div>
                                        </form>

                                        <form class="form-horizontal" id="register-otp" style="display:none;" action="" novalidate method="POST">
                                            <div class="font-large-1  text-center">Forget Password</div>
                                            <label class="error otp-msg"></label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control round" name="otp" placeholder="Enter OTP"  required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>                                            
                                            
                                            <div class="form-group text-center">
                                                <input type="hidden" name="mobile_2">

                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" onclick="verify_otp(this)">Submit OTP</button>                                                
                                            </div>
                                        </form>

                                        <form action="<?=base_url('register/update_password')?>" method="POST" enctype="multipart/form-data" id="register-details-form" style="display: none;">
                                          <div class="row y-gap-20">
                                            <div class="col-12">
                                                <div class="font-large-1 text-center">Set New Password</div>
                                            </div>                                            

                                            <div class="col-12">
                                              <div class="form-input ">
                                                <label class="lh-1 text-14 text-light-1">New Password<span class="text-red-1">*</span></label>
                                                <input type="password" name="password" class="form-control round" required>
                                                
                                              </div>
                                            </div>                                            

                                            <div class="col-12">
                                                <input type="hidden" name="username" class="form-control round">

                                              <button type="submit" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1">
                                                Submit <div class="icon-arrow-top-right ml-15"></div>
                                              </button>

                                            </div>
                                          </div>
                                        </form>




                                        <form id="success-form" style="display: none;">
                                          <div class="row y-gap-20">
                                            <div class="col-12">
                                                <div class="font-large-1 text-center">Your password has been change successfully.</div>
                                            </div>                                            

                                                                             

                                            <div class="col-12">

                                              <a href="<?=base_url()?>login" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1">
                                                Login <div class="icon-arrow-top-right ml-15"></div>
                                              </a>

                                            </div>
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


    <!-- BEGIN: Vendor JS-->
    <script src="<?=base_url()?>static/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?=base_url()?>static/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?=base_url()?>static/app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?=base_url()?>static/app-assets/js/core/app.js" type="text/javascript"></script>

    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?=base_url()?>static/app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>

    <script src="<?=base_url()?>static/app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>static/app-assets/js/scripts/extensions/toastr.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.validate.min.js') ?>"></script>

    <script type="text/javascript">
        $(document).on('click','[data-toggle="collapse-login"]',function(){
            var data_target_show = $(this).attr('data-target-show');
            var data_target_hide = $(this).attr('data-target-hide');

            $(data_target_show).removeClass('show');
            $(data_target_show).addClass('show');
            $(data_target_hide).removeClass('show');
            

            return false;
        })


        $("#register-mobile").validate({
            rules : {
                mobile :{
                    minlength: 10,
                    maxlength: 11
                }
            },
            messages : {
                mobile:{
                    minlength: 'Number should be 10 digit.',
                    maxlength: 'Number should be 11 digit.'
                }
            }
        });

        function get_otp(btn) {
            if( $('#register-mobile').valid()){
                dataString = $("#register-mobile").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>register/get_otp",
                    data: dataString,
                    dataType: "JSON",
                    beforeSend: function() {
                        $(btn).attr("disabled", true);
                        $(btn).text("Process...");
                    },
                    success: function(data){ 
                    console.log(data);             

                      if (data.status == 'success') {
                        $('[name=mobile_2]').val(data.mobile);
                        $('[name=username]').val(data.user);
                        $("#register-mobile").hide();
                        $("#register-otp").show();
                        $('.otp-msg').html('OTP sent to your mobile no. +91(******)'+data.mobile.slice(-4));
                      }else{
                        alert_toastr('error','username not valid');
                        $(btn).attr("disabled", false);
                        $(btn).text("Get OTP");
                      }
                    }
                });
            }
            return false;  //stop the actual form post !important!
        }

        function verify_otp(btn) {
            if( $('#register-otp').valid()){
                dataString = $("#register-otp").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>register/verify_otp",
                    data: dataString,
                    dataType: "JSON",
                    beforeSend: function() {
                        $(btn).attr("disabled", true);
                        $(btn).text("Process...");
                    },
                    success: function(data){ 
                    console.log(data);             

                      if (data.status == 'success') {
                        $("#register-otp").hide();
                        $("#register-details-form").show();
                      }

                      if(data.status == 'fail'){
                        $('[name=otp]').after('<span id="otp-error" class="is-invalid text-error-2">OTP is invalid.</span>');
                        $(btn).removeAttr("disabled");
                        $(btn).text("Submit");
                      }
                    }
                });
            }
            return false;  //stop the actual form post !important!
        }

        $("#register-details-form").validate({
            rules : {
                mob :{
                    minlength: 10,
                    maxlength: 11
                }
            },
            messages : {
                mobile:{
                    minlength: 'Number should be 10 digit.',
                    maxlength: 'Number should be 11 digit.'
                }
            }
        });

        $(document).on("submit", '#register-details-form', function(event) { 
            event.preventDefault();        
            if( $('#register-details-form').valid()){
                $this = $(this);
                $.ajax({
                  url: $this.attr("action"),
                  type: $this.attr("method"),
                  data:  new FormData(this),
                  cache: false,
                  contentType: false,
                  processData: false,
                  success: function(data){
                    console.log(data);
                    // return false;
                    data = JSON.parse(data);
                    
                    if (data.status == 'success') {
                        $("#register-details-form").hide();
                        $("#success-form").show();
                    }
                  }
                })
            }
            return false;
        });   

     
    </script>

    <!-- END: Page JS-->
</body>
<!-- END: Body-->

</html>