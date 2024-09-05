<style>
     .gradient-card {
        background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(227,46,250,1) 0%, rgba(76,0,255,1) 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
        }

        /* Custom padding and margin for better appearance */
        .gradient-card-body {
            padding: 20px;
        }
        .gradient-card-footer {
            padding: 20px;
        }
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?=$title?></h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?=base_url()?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Profile
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Base style table -->
            <section id="base-style">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <?php if($user->user_role ==1){?>
                    <style type="text/css">
                        .profile-pic{
                            position: relative;
                            width: 150px;
                            height: 150px;
                            margin-bottom: 15px;
                            border-radius: 50%;
                            border: 2px solid blueviolet ;

                        }

                        .profile-pic input{
                            display: none;
                            
                        }
                        .profile-pic img{
                            position: absolute;
                            width: 100%;
                            max-width: 150px;
                            height: 100%;
                            max-height: 150px;
                            border-radius: 50%;
                            border: 2px solid blueviolet ;

                        }
                        .profile-pic label{
                                position: absolute;
                                bottom: 0;
                                margin: auto;
                                text-align: center;
                                height: 22%;
                                color: black;
                                /* background: #80808075; */
                                width: 100%;
                                cursor: pointer;
                                z-index: 0;
                        }
                    </style>
                    <div class="row">
                        <div class="col-md-3 ml-4   mt-3">
                        <form class="form ajaxsubmit reload-page" action="<?=base_url()?>admin_profile/update" method="POST" enctype="multipart/form-data">
                            <div class="profile-pic">
                                <div></div>
                                <input id="profile-pic" type="file" class="onchange-submit" accept="image/*" name="photo" >
                                <img  src="<?php echo IMGS_URL.$user->photo?>" onerror="this.src='<?=base_url()?>assets/img/noimg.png';" alt="<?=$user->name?>">
                                <label for="profile-pic">Change</label>
                            </div>

                        </form>
                       
                    </div>
                    <div class="col-md-7">
                            <div class="card-content collapse show" id="tb">
                                <div class="row justify-content-center p-1">
                                    <div class="col-md-12">
                                        <form class="form ajaxsubmit reload-page" action="<?=base_url()?>admin_profile/update" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="duration">Name <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Name" name="name" value="<?=$user->name?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="duration">Email <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Email" name="email" value="<?=$user->email?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="duration">Username <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Username" name="username" value="<?=$user->username?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="duration"><br></label>
                                                <input type="submit" class="btn btn-primary btn-sm" placeholder="Duration" name="name" value="Update">
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php }elseif($user->user_role==4){?>
                        <style type="text/css">
                        .profile-pic{
                            position: relative;
                            width: 150px;
                            height: 150px;
                            margin-bottom: 15px;
                            border-radius: 50%;
                            border: 2px solid blueviolet ;

                        }

                        .profile-pic input{
                            display: none;
                            
                        }
                        .profile-pic img{
                            position: absolute;
                            width: 100%;
                            max-width: 150px;
                            height: 100%;
                            max-height: 150px;
                            border-radius: 50%;
                            border: 2px solid blueviolet ;

                        }
                        .profile-pic label{
                                position: absolute;
                                bottom: 0;
                                margin: auto;
                                text-align: center;
                                height: 22%;
                                color: black;
                                /* background: #80808075; */
                                width: 100%;
                                cursor: pointer;
                                z-index: 0;
                        }
                    </style>
                    <div class="row">
                        <div class="col-md-3 ml-4   mt-3">
                        <form class="form ajaxsubmit reload-page" action="<?=base_url()?>admin_profile/host_update" method="POST" enctype="multipart/form-data">
                            <div class="profile-pic">
                                <div></div>
                                <input id="profile-pic" type="file" class="onchange-submit" accept="image/*" name="photo" >
                                <img  src="<?php echo IMGS_URL.$user->pic?>" onerror="this.src='<?=base_url()?>assets/img/noimg.png';" alt="<?=$user->name?>">
                                <label for="profile-pic">Change</label>
                            </div>
                            <input type="hidden" class="form-control" placeholder="Name" name="name" value="<?=$user->name?>">
                            <input type="hidden" class="form-control" placeholder="Email" name="email" value="<?=$user->email?>">
                            <input type="hidden" class="form-control" placeholder="Username" name="username" value="<?=$user->username?>">
                            <input type="hidden" class="form-control" placeholder="Mobile No" name="mobile" value="<?=$user->mobile?>">
                            <input type="hidden" class="form-control" placeholder="Aadhaar No" name="aadhaar_no" value="<?=$user->aadhaar_no?>">
                        </form>
                       
                    </div>
                    <div class="col-md-7">
                            <div class="card-content collapse show" id="tb">
                                <div class="row justify-content-center p-1">
                                    <div class="col-md-12">
                                        <form class="form ajaxsubmit reload-page" action="<?=base_url()?>admin_profile/host_update" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="duration">Name <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Name" name="name" value="<?=$user->name?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="duration">Email <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Email" name="email" value="<?=$user->email?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="duration">Username <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Username" name="username" value="<?=$user->username?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="duration">Mobile No. <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Mobile No" name="mobile" value="<?=$user->mobile?>">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="duration">Aadhaar No. <sup>*</sup></label>
                                                <input type="text" class="form-control" placeholder="Aadhaar No" name="aadhaar_no" value="<?=$user->aadhaar_no?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="duration">Aadhaar Front Photo <i class="la la-check-circle text-success d-none Front"></i> <sup>*</sup> <?php if($user->aadhaar_front !=''){?> <a href="<?=IMGS_URL.$user->aadhaar_front;?>" target="_blank"><i class="la la-info"></i></a> <?php }?></label>
                                            <div class="custom-file">
                                                <input type="file" class="form-control"  name="aadhaar_front" value="<?=$user->aadhaar_front?>" onchange="fileSelected(this)">
                                                <script>
                                                function fileSelected(input) {
                                                var iconElement = input.previousElementSibling.querySelector('.Front');
                                                var fileSize = input.files[0].size;
                                                var maxSize = 100 * 1024;

                                                if (fileSize <= maxSize) {
                                                    iconElement.classList.remove('d-none');
                                                } else {
                                                    iconElement.classList.add('d-none');
                                                    input.value = '';
                                                }
                                            }
                                            </script>
                                            </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="duration">Aadhaar Back Photo <i class="la la-check-circle text-success d-none Back"></i> <sup>*</sup> <?php if($user->aadhaar_back !=''){?> <a href="<?=IMGS_URL.$user->aadhaar_back;?>" target="_blank"><i class="la la-info"></i></a> <?php }?></label>
                                            <div class="custom-file">
                                               
                                                <input type="file" class="form-control"  name="aadhaar_back" value="<?=$user->aadhaar_back?>" onchange="fileSelected(this)">
                                            </div>
                                            </div>
                                            <div class="form-group col-md-5"></div>
                                            <div class="form-group col-md-6">
                                                <label for="duration"><br></label>
                                                <input type="submit" class="btn btn-primary btn-sm" placeholder="Duration" name="name" value="Update">
                                                <script>
                        function fileSelected(input) {
                        var iconElement = input.previousElementSibling.querySelector('.Back');
                        var fileSize = input.files[0].size;
                        var maxSize = 100 * 1024;

                        if (fileSize <= maxSize) {
                            iconElement.classList.remove('d-none');
                        } else {
                            iconElement.classList.add('d-none');
                            input.value = '';
                        }
                    }
                    </script>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                    </div>

                        <?php }?>
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Change Password" data-url="<?=$new_url?>" class="btn btn-primary btn-sm"><i class="ft-plus"></i> Edit Password</a>
                                </h4>

                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <?php if($user->user_role ==4){?>
                                <hr>
                            <!-- <div class="card-content collapse show">
                            <div class="container mt-5">
                                <div class="row">
                                <div class="card gradient-card col-md-4 col-sm-4 col-lg-4" style="margin-left: -2rem;">
                                    <div class="card-body gradient-card-body">
                                        <h2 class="card-title text-white text-center" style="font-size: 2rem;font-weight:bold"><?=$packages->name?></h2>
                                        <p class="text-center"><img src="<?=IMGS_URL.$packages->pic;?>" alt="" height="70px"></p>
                                        <h5 class="card-text text-white text-center">Valitidy : <?=$packages->no_of_days;?> Days</h5>
                                        <h3 class="card-text text-white text-center">Price : <?=setting()->currency;?><?=$packages->price;?></h3>
                                        <p class="card-text text-white text-center"><?=$packages->description;?> Days</p>
                                    </div>
                                    <div class="card-body gradient-card-footer">
                                    <center><button class="btn btn-success"><b>Already Selected</b></button></center>
                                    </div>
                                </div>
                                <?php foreach($user_packages_master as $packages):?>
                                <div class="card gradient-card col-md-4 col-sm-4 col-lg-4 ml-1">
                                    <div class="card-body gradient-card-body">
                                        <h2 class="card-title text-white text-center" style="font-size: 2rem;font-weight:bold"><?=$packages->name?></h2>
                                        <p class="text-center"><img src="<?=IMGS_URL.$packages->pic;?>" alt="" height="70px"></p>
                                        <h5 class="card-text text-white text-center">Valitidy : <?=$packages->duration_in_days;?> Days</h5>
                                        <h3 class="card-text text-white text-center">Price : <?=setting()->currency;?><?=$packages->price;?></h3>
                                        <p class="card-text text-white text-center"><?=$packages->description;?> Days</p>
                                    </div>
                                    <div class="card-body gradient-card-footer">
                                    <center><button class="btn btn-success"><b>Upgrade Plan </b></button></center>
                                    </div>
                                    <hr style="border:1px solid white;width:100%"> 
                                </div>
                                <?php endforeach;?>
                                </div>
                            </div>

                                </div> -->
                                <?php }?>
                            <div class="card-content collapse show" id="tb">
                                

                            </div>
                        </div>
                      
                    </div>
                </div>
            </section>
            <!--/ Base style table -->
        </div>
    </div>
</div>
<!-- END: Content-->

<script>
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
    $(document).on('change','.onchange-submit', function(event) {
    $(this).parents('form').submit();
})
</script>