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
                                            <div class="font-large-1  text-center">Signup</div>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control round" name="mobile" placeholder="Your Mobile No."  required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>                                            
                                            
                                            <div class="form-group text-center">
                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" onclick="host_register(this)">Get OTP</button>                                                
                                            </div>
                                        </form>

                                        <form class="form-horizontal" id="register-otp" style="display:none;" action="" novalidate method="POST">
                                            <div class="font-large-1  text-center">Signup</div>
                                            <label class="error otp-msg"></label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control round" name="otp" placeholder="Enter OTP"  required>
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>                                            
                                            
                                            <div class="form-group text-center">
                                                <input type="hidden" name="mobile_2">

                                                <button type="button" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1" onclick="register_otp(this)">Signin</button>                                                
                                            </div>
                                        </form>

                                        <form action="<?=base_url('register/save_host')?>" method="POST" enctype="multipart/form-data" id="register-details-form" style="overflow: scroll;height: 700px;display:none;">
                                          <div class="row y-gap-20">
                                            <div class="col-12">
                                                <div class="font-large-1 text-center">Owner Details</div>
                                            </div>

                                            <div class="col-12">
                                              <div class="form-input ">
                                                <label>Name<span>*</span></label>
                                                <input type="text" name="name" class="form-control round" required>
                                              </div>
                                            </div>

                                            <div class="col-6">
                                              <div class="form-input ">
                                                <label>Username<span>*</span></label>
                                                <input type="text" name="username" class="form-control round" required>
                                              </div>
                                            </div>

                                            <div class="col-6">
                                              <div class="form-input ">
                                                <label>Password<span>*</span></label>
                                                <input type="password" name="password" class="form-control round" required>
                                              </div>
                                            </div>

                                            <div class="col-6">
                                              <div class="form-input ">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control round">
                                              </div>
                                            </div>                

                                            <div class="col-6">
                                              <div class="form-input ">
                                                <label>Mobile<span>*</span></label>
                                                <input type="tel" name="mob" class="form-control round" readonly>
                                              </div>
                                            </div>

                                            <div class="col-12">
                                              <div class="form-input ">
                                                <label>About</label>
                                                <textarea name="about" class="form-control round"></textarea>
                                              </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                
                                                    <label>Language Speaks</label><br>
                                                    <?php foreach($language as $row): ?>
                                                        <label>
                                                            <input type="checkbox" name="language_speaks[]" data-size="sm" class="switchery" value="<?=$row->lsm_id?>">
                                                            <?=$row->language?>
                                                        </label>
                                                    
                                                    <?php endforeach; ?>

                                                </div>                  
                                            </div>

                                            <div class="col-12">
                                                <label>Profile Photo<span class="text-red-1">*</span></label>
                                                <div class="form-input">                    
                                                    <input type="file" class="form-control" name="pic">                        
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <label>Aadhar Card Front<span class="text-red-1">*</span></label>
                                                <div class="form-input">                    
                                                    <input type="file" class="form-control" name="aadhar_front" required>                        
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <label>Aadhar Card Back<span class="text-red-1">*</span></label>
                                                <div class="form-input">                    
                                                    <input type="file" class="form-control" name="aadhar_back" required>                        
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <label>Aadhar No.<span class="text-red-1">*</span></label>
                                                <div class="form-input">                    
                                                    <input type="number" class="form-control" name="aadhar_no" required>  
                                                </div>
                                            </div>

                                            <div class="col-12">
                                              <div class="form-input">
                                                <label>Work</label>
                                                <select name="work" class="form-control form-select">
                                                    <option value=""></option>
                                                    <?php foreach($work as $row): ?>
                                                        <option value="<?=$row->wm_id?>"><?=$row->work?></option>
                                                    <?php endforeach; ?>
                                                </select>                                                
                                              </div>
                                            </div>

                                            <div class="col-4">
                                              <div class="form-input">
                                                <label>Country<span>*</span></label>
                                                <select name="country" class="form-control form-select" required>
                                                    <option value=""></option>
                                                    <?php foreach($countries as $row): ?>
                                                        <option value="<?=$row->id?>"><?=$row->name?></option>
                                                    <?php endforeach; ?>
                                                </select>                                                
                                              </div>
                                            </div>

                                            <div class="col-4">
                                              <div class="form-input">
                                                <label>State<span>*</span></label>
                                                <select name="state" class="form-control form-select" required>
                                                    <option value=""></option>                        
                                                </select>                                                
                                              </div>
                                            </div>

                                            <div class="col-4">
                                              <div class="form-input">
                                                <label>City<span>*</span></label>
                                                <select name="city" class="form-control form-select" required>
                                                    <option value=""></option>                        
                                                </select>                                                
                                              </div>
                                            </div>

                                            <!-- <div class="col-12">
                                              <div class="form-input">
                                                <select name="identity" class="form-control form-select" required>
                                                    <option value=""></option>   
                                                    <option value="1">Personal</option>
                                                    <option value="2">Company</option>                     
                                                </select>
                                                <label class="lh-1 text-14 text-light-1">Personal Details<span class="text-red-1">*</span></label>
                                              </div>
                                            </div>                    

                                            <h5 class="fw-500 personal-head"></h5> -->

                                            <!-- <div class="col-6">
                                                <label>PAN Card<span class="text-red-1">*</span></label>
                                                <div class="form-input">                    
                                                    <input type="file" class="form-control" name="pan_card" required>                        
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <label>PAN No.<span class="text-red-1">*</span></label>
                                                <div class="form-input">                    
                                                    <input type="text" class="form-control" name="pan_no" required>  
                                                    <label class="lh-1 text-14 text-light-1">PAN Card Number</label>                      
                                                </div>
                                            </div> -->

                                            <!-- <div class="col-12">
                                                <div class="row company" style="display:none;">
                                                    <div class="col-6">
                                                        <label>Company Document<span class="text-red-1">*</span></label>
                                                        <div class="form-input">                    
                                                            <input type="file" class="form-control" name="company_doc">                        
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label>Company Document No.<span class="text-red-1">*</span></label>
                                                        <div class="form-input">                    
                                                            <input type="text" class="form-control" name="company_doc_no">  
                                                            <label class="lh-1 text-14 text-light-1">Document Number</label>                      
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            

                                            <input type="hidden" name="email_verified" value="0">
                                            <input type="hidden" name="mobile_verified" value="0">
                                            

                                            <div class="col-12 mt-3">

                                              <button type="submit" class="btn round btn-block btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1">
                                                Sign In <div class="icon-arrow-top-right ml-15"></div>
                                              </button>

                                            </div>
                                          </div>
                                        </form>



                                        <form action="<?=base_url()?>register/save_property" method="POST" enctype="multipart/form-data" id="property-form" style="overflow: scroll;height: 700px;display: none;">
                                            <div class="form-body">
                                                
                                                <div class="row y-gap-20">
                                                    <div class="col-12">
                                                        <div class="font-large-1 text-center">Property Details</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-input"> 
                                                            <label for="propname">Property Name<span>*</span></label>                                   
                                                            <input type="text" id="propname" class="form-control" placeholder="Property Name" name="propname" required>                                                            
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-6">
                                                        <div class="form-input">
                                                            <label for="propcode">Property Code</label>
                                                            <input type="text" id="propcode" class="form-control" placeholder="Property Code" name="propcode">
                                                        </div>
                                                    </div> -->

                                                    <div class="col-6">
                                                        <div class="form-input">    
                                                            <label for="propcodename">Property Code Name</label>                                
                                                            <input type="text" id="propcodename" class="form-control" placeholder="Property Code Name" name="propcodename">                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row y-gap-20">
                                                    <div class="col-6">
                                                        <div class="form-input"> 
                                                            <label for="contact_preson">Contact Preson</label>                                   
                                                            <input type="text" id="contact_preson" class="form-control" placeholder="Contact Preson" name="contact_preson">                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="form-input"> 
                                                            <label for="contact_preson_mobile">Contact Preson Mobile</label>
                                                            <input type="text" id="contact_preson_mobile" class="form-control" placeholder="Contact Preson Mobile" name="contact_preson_mobile">                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row y-gap-20">
                                                    <div class="col-md-6">
                                                        <div class="form-input"> 
                                                            <label for="country">Country<span>*</span></label>                                   
                                                            <select id="country" name="country" class="form-control" required>
                                                                <?php
                                                                    echo optionStatus('','-- Select --');
                                                                foreach ($countries as $row) {
                                                                    echo optionStatus($row->id,$row->name);
                                                                }
                                                                ?>
                                                            </select>                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-input">  
                                                            <label for="state">State<span>*</span></label>                                 
                                                            <select id="state" name="state" class="form-control" required>
                                                                <option value="" >-- Select --</option>
                                                            </select>                                                            
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-md-6">
                                                        <div class="form-input">                                    
                                                            <select id="district" name="district" class="form-control" required>
                                                                <option value="" >-- Select --</option>
                                                            </select>
                                                            <label for="district">District</label>
                                                        </div>
                                                    </div> -->

                                                    <div class="col-md-6">
                                                        <div class="form-input">   
                                                            <label for="city">City<span>*</span></label>                                 
                                                            <select id="city" name="city" class="form-control" required>
                                                                
                                                            </select>                                                            
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="row y-gap-20">
                                                    <div class="col-md-12">
                                                        <div class="row y-gap-20">
                                                            <div class="col-md-6">
                                                                <div class="form-input">  
                                                                    <label for="location_id">Location<span>*</span></label>
                                                                    <select id="location_id" name="location_id" class="form-control" required>
                                                                        <option value="" >-- Select --</option>
                                                                        
                                                                    </select>                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-input">  
                                                                    <label for="propcodename">Pincode<span>*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Pincode" name="pincode" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-input">  
                                                                    <label for="property_type_id">Property Type<span>*</span></label>
                                                                    <select id="property_type_id" name="property_type_id" class="form-control" required>
                                                                        <?php
                                                                        echo optionStatus('','-- Select --',1);
                                                                        foreach ($type as $row) {
                                                                            echo optionStatus($row->pt_id,$row->name,$row->active);
                                                                        }
                                                                        ?>
                                                                    </select>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-input">  
                                                            <label for="address">Address<span>*</span></label>                                  
                                                            <textarea id="address" rows="6" class="form-control" name="address" placeholder="address" required></textarea>                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-input">
                                                            <label>Attach Address Proof Document Type</label>
                                                            <select name="doc_type_id" class="form-control">
                                                                <?php
                                                                echo optionStatus('','-- Select --',1);
                                                                foreach ($document_type as $row) {
                                                                    echo optionStatus($row->id,$row->name,$row->active);
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-input">
                                                            <label>Address Proof Document (Image/PDF)</label>
                                                            <input type="file" class="form-control" name="document">
                                                        </div>
                                                    </div>
                                                    
                                                </div> 


                                                <div class="form-input mt-20 mb-20">                            
                                                    <label for="">Select Location</label>
                                                    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                                                    <div id="map" style="width: auto; height: 300px;"></div>  
                                                </div>

                                                <div class="row y-gap-20">
                                                    <div class="col-md-6">
                                                        <div class="form-input">  
                                                            <label for="longitude">Longitude</label>                                  
                                                            <input type="text" id="longitude" class="form-control" placeholder="longitude" name="longitude">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-input">  
                                                            <label for="latitude">Latitude</label>                                  
                                                            <input type="text" id="latitude" class="form-control" placeholder="latitude" name="latitude">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                        <div class="font-medium-1 text-center">For Invoice / Bill</div>
                                                        <hr>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="latitude">Logo</label>
                                                            <input type="file" class="form-control" name="logo"> 
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="font-medium-1 text-center">For Business PAN Details</div>
                                                        <hr>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Type of Ownership</label>
                                                            <select name="ownership_type" class="form-control">
                                                                <?php
                                                                echo optionStatus('','-- Select --',1);
                                                                foreach ($ownership_type as $row) {
                                                                    echo optionStatus($row->id,$row->name,$row->active);
                                                                }
                                                                ?>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>OwnerShip Certificate (Image/PDF)</label>
                                                            <input type="file" class="form-control" name="certificate"> 
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Enter Name on PAN Card</label>
                                                            <input type="text" class="form-control" placeholder="Enter Name on PAN Card" name="pan_name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Enter PAN No.</label>
                                                            <input type="text" class="form-control" placeholder="Enter PAN No." name="pan_no">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Upload PAN Card (Image/PDF)</label>
                                                            <input type="file" class="form-control" name="pan_photo"> 
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="font-medium-1 text-center">For GST & Business Details</div>
                                                        <hr>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>GST</label>
                                                            <select name="is_gst" class="form-control" required>
                                                                <option value="">Select GST</option>
                                                                <option value="YES">YES</option>
                                                                <option value="NO">NO</option>
                                                            </select>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 gst-box" style="display:none;">
                                                        <div class="form-group">
                                                            <label>GST No.</label>
                                                            <input type="text" class="form-control" placeholder="Enter GST No." name="gst_no">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5 gst-box" style="display:none;">
                                                        <div class="form-group">
                                                            <label>GST Certificate (Image/PDF)</label>
                                                            <input type="file" class="form-control" name="gst_certificate"> 
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="form-actions mt-20">
                                                <a href="http://localhost/hotel_management/admin-panel/login" type="reset" class="btn round btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1">
                                                    <i class="ft-x"></i> Skip
                                                </a>
                                                <button type="submit" class="btn round btn-glow btn-bg-gradient-x-purple-blue col-12 mr-1 mb-1">
                                                    <i class="ft-check"></i> Save
                                                </button>
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

        function host_register(btn) {
            if( $('#register-mobile').valid()){
                dataString = $("#register-mobile").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>register/generate_otp",
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
                        $("#register-mobile").hide();
                        $("#register-otp").show();
                        $('.otp-msg').html('OTP sent to your mobile no. +91(******)'+data.mobile.slice(-4));
                      }
                    }
                });
            }
            return false;  //stop the actual form post !important!
        }

        function register_otp(btn) {
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
                        //$("#register-details").prev('div').hide();
                        $("#register-details-form").show();
                        $('[name=mob]').val(data.mobile);

                        // $('.step-1').removeClass('bg-blue-1-05 text-blue-1 fw-500');                    
                        // $('.step-1').addClass('bg-blue-1');              
                        // $('.step-1').html('<i class="icon-check text-16 text-white"></i>');              
                      }

                      if(data.status == 'fail'){
                        $('[name=otp]').after('<span id="otp-error" class="is-invalid text-error-2">OTP is invalid.</span>');
                        $(btn).removeAttr("disabled");
                        $(btn).text("Signin");
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
                        //$("#register-otp").hide();
                        //$("#register-details").prev('div').hide();
                        $("#register-details-form").hide();
                        $("#property-form").show();
                        //$('[name=mob]').val(data.mobile);   

                        // $('.step-2').removeClass('bg-blue-1-05 text-blue-1 fw-500');                    
                        // $('.step-2').addClass('bg-blue-1');              
                        // $('.step-2').html('<i class="icon-check text-16 text-white"></i>');                   
                    }
                  }
                })
            }
            return false;
        });    

        $(document).on('keyup','[name=username]',function(){
            var $this = $(this);

            $.ajax({
                url: "<?php echo base_url('register/host_remote'); ?>",
                method: "POST",
                data: {
                    username:$this.val(),
                    table_name:'usermaster',
                },
                success: function(data){
                    //console.log(data);
                    if (data == 'duplicate') {
                        $('[name=username]').next('span').remove();
                        $('[name=username]').after('<span class="text-red-1">Already Exist.</span>');
                        $('button[type="submit"]').prop('disabled', true);
                    }else{
                        $('[name=username]').next('span').remove();
                        $('button[type="submit"]').prop('disabled', false);
                    }
                },
            });        
        });

        // $(document).on('change','[name=identity]',function(){
        //     var $this = $(this);
        //     if ($this.val() == '2') {
        //         $('.company').show();
        //         $('.company input').prop('required', true);
        //         $('.personal-head').html('Company Details<hr>');
        //     }else{
        //         $('.company').hide();
        //         $('.company input').prop('required', false);
        //         $('.personal-head').html('Personal Details<hr>');
        //     }               
        // });

        $('[name=country]').change(function() {
            var id = $(this).val();
            $('[name=state]').load('<?=base_url()?>getStates/'+id);
        })

        $('[name=state]').change(function() {
            var id = $(this).val();
            $('[name=city]').load('<?=base_url()?>getCities/'+id);
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
            $.post('<?=base_url()?>load_locations',{state:state,city:city})
            .done(function(data){
                
                data = JSON.parse(data);
                console.log(data);
                $('#location_id').html(data.content);
            })
            .fail(function() {
                alert( "error" );
              })

        }

        $("#property-form").validate({
            rules : {
                propname :{
                    required:true
                }
            }
            
        });

        $(document).on("submit", '#property-form', function(event) { 
            event.preventDefault();        
            if( $('#property-form').valid()){
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
                        //$("#register-otp").hide();
                        //$("#register-details").prev('div').hide();
                        //$("#register-details-form").hide();
                        $("#property-form").hide();
                        window.location.href = 'http://localhost/hotel_management/admin-panel/login';                  
                    }
                  }
                })
            }
            return false;
        });

     var markers = [];

    function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                  console.log("Returned place contains no geometry");
                  return;
                }
                var icon = {
                  url: place.icon,
                  size: new google.maps.Size(171, 171),
                  origin: new google.maps.Point(0, 0),
                  anchor: new google.maps.Point(17, 34),
                  scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                var  markers = new google.maps.Marker({
                  map: map,
                  icon: icon,
                  title: place.name,
                  position: place.geometry.location,
                  draggable:true,
                 title:"Drag me!"
                });

                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);

                google.maps.event.addListener(markers, 'dragend', function(event) {
                    var lat = event.latLng.lat();
                    var lng = event.latLng.lng();
                    $('#latitude').val(lat);
                    $('#longitude').val(lng);
                });

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
          map.fitBounds(bounds);
        });
    }

    $(document).on('change', '[name=is_gst]', function(){
        let value = $(this).val();
        if (value == 'YES') {
            $('.gst-box').show();
            $('.gst-box input').prop('required', true);
        }else{
            $('.gst-box').hide();
            $('.gst-box input').prop('required', false);
        }
    });
    </script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyDIHyFm0c8apzuuVZE4zsFXbGDfXRyPsv4&libraries=places&callback=initAutocomplete" async defer></script>

    <!-- END: Page JS-->
</body>
<!-- END: Body-->

</html>