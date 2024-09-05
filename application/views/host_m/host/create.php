<div class="card-content collapse show">
    <div class="card-body">
                                    

    <!-- form -->
    <form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
        <div class="form-body">
            
            <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" class="form-control" placeholder="Name" name="name" value="<?=(@$row->name) ? $row->name : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="Username" name="username" value="<?=(@$row->username) ? $row->username : '' ?>" required >            
            </div>

            <div class="form-group">
                <label for="password">Password
                    <?=(@$row) ? '<span class="text-white bg-danger"> If you want to change host password then enter a new password otherwise left it blank</span>' : '' ?>
                </label>
                <input type="password" class="form-control" placeholder="Password" name="password"  <?=(@$row) ? '' : 'required' ?> >            
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" placeholder="Email" name="email" value="<?=(@$row->email) ? $row->email : '' ?>" >  
                <?php if (@$row_extended->email_verified == 0) { ?> 
                    <button type="button" name="email_otp" class="btn btn-primary mt-2">Email Verify</button>  
                <?php } ?>       
            </div>

            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" placeholder="Mobile" name="mobile" value="<?=(@$row->mobile) ? $row->mobile : '' ?>" required>
                <?php if (@$row_extended->mobile_verified != 1) { ?>                    
                    <button type="button" name="mobile_otp" class="btn btn-primary mt-2">Mobile Verify</button>  
                <?php } ?>     
            </div>            

            <!-- <div class="form-group">
                <label for="about">About</label>
                <textarea type="text" class="form-control" placeholder="about" name="about"><?=(@$row_extended->about) ? $row_extended->about : '' ?></textarea>          
            </div> -->

            <!-- <div class="form-group">
                <label for="about">Language Speaks</label><br>
                <?php 
                //  foreach ($language as $lrow) {
                //     $checked = '';
                //     if (@$row_extended->language_speaks) {
                //         $language_speaks = explode(',',$row_extended->language_speaks);
                //         foreach ($language_speaks as $language_speak) {
                //             if ($language_speak == $lrow->lsm_id) {
                //                 $checked = 'checked';
                //             }
                //         }
                //     }
                    ?>
                    <label for="language<?=$lrow->lsm_id?>">
                        <input type="checkbox" class="switchery" data-size="sm" name="language_speaks[]" value="<?=$lrow->lsm_id?>" <?=$checked?> > <?=$lrow->language?>
                    </label>
                <?php // } ?>
            </div> -->
            <div class="row">
               <div class="col-md-6">
            <div class="form-group">
                <label for="pic">Photo<?php if (@$row->pic) { ?><a href="<?=IMGS_URL.$row->pic?>" target="_blank"> <i class="la la-info"></i></a> <?php } ?> <span class="text-danger">Maximum  file size 100 kb.</span></label>
                <input type="file" class="form-control" name="pic">  
                <input type="hidden" name="old_pic" value="<?=@$row->pic;?>">        
            </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Aadhar No.</label>
                    <input type="text" class="form-control" name="aadhar_no" value="<?=(@$row->aadhaar_no) ? $row->aadhaar_no : '' ?>" >  
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Aadhar Card Front<?php if (@$row->aadhaar_front) { ?><a href="<?=IMGS_URL.$row->aadhaar_front?>" target="_blank"> <i class="la la-info"></i></a> <?php } ?> <span class="text-danger">Maximum  file size 100 kb.</span></label>
                    <input type="file" class="form-control" name="aadhar_front">  
                    <input type="hidden" name="old_aadhar_front" value="<?=@$row->aadhaar_front;?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Aadhar Card Back <?php if (@$row->aadhaar_back) { ?><a href="<?=IMGS_URL.$row->aadhaar_back?>" target="_blank"> <i class="la la-info"></i></a> <?php } ?> <span class="text-danger">Maximum  file size 100 kb.</span></label>
                    <input type="file" class="form-control" name="aadhar_back" >  
                    <input type="hidden" name="old_aadhar_back" value="<?=@$row->aadhaar_back;?>">
                </div>
            </div>
            </div>

           
            <div class="col-md-8"></div>
            <!-- <div class="form-group"> -->
                <!-- <label for="work">Work</label>
                <select class="form-control" name="work">
                <?php 
                // echo optionStatus('','-- Select --',1);
                // foreach ($work as $wrow) { 
                //     $selected = '';
                //     if (@$row_extended->work == $wrow->wm_id) {
                //         $selected = 'selected';
                //     }
                //     echo optionStatus($wrow->wm_id,$wrow->work,$wrow->active,$selected);
                //} ?>
                </select> -->
            <!-- </div> --> 
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select id="country" name="country" class="form-control" required>
                            <?=$countries?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="state">State</label>
                        <select id="state" name="state" class="form-control" required>
                            <?=(@$states) ? $states : '<option value="" >-- Select --</option>' ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="city">City</label>
                        <select id="city" name="city" class="form-control" required>
                            <?=(@$cities) ? $cities : '<option value="" >-- Select --</option>' ?>

                        </select>
                    </div>
                </div>

            <!-- <div class="form-group">
                <label for="work">Identity Verified</label>
                <select class="form-control" name="identity" required>
                    <option value="">Select---</option>
                    <option value="1">Personal</option>
                    <option value="2">Company</option>
                </select>
            </div> -->

            <!-- <div class="row personal">
                <div class="col-md-12 personal-head">
                    <label></label>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pan Card</label>
                        <input type="file" class="form-control" name="pan_card">  
                        <?php if (@$document->pan_card) { ?>
                            <img src="<?=IMGS_URL.$document->pan_card?>" class="img-sm zoom-img">
                        <?php } ?> 
                        <input type="hidden" name="old_pan_card" value="<?=@$document->pan_card;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pan No.</label>
                        <input type="text" class="form-control" name="pan_no" value="<?=(@$document->pan_no) ? $document->pan_no : '' ?>" required>  
                    </div>
                </div>
            </div> -->

            <!-- <div class="row company" style="display:<?=(@$document->company_doc) ? 'flex' : 'none' ?>;">                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company Document</label>
                        <input type="file" class="form-control" name="company_doc">  
                        <?php if (@$document->company_doc) { ?>
                            <img src="<?=IMGS_URL.$document->company_doc?>" class="img-sm zoom-img">
                        <?php } ?> 
                        <input type="hidden" name="old_company_doc" value="<?=@$document->company_doc;?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Document No.</label>
                        <input type="text" class="form-control" name="company_doc_no" value="<?=(@$document->company_doc_no) ? $document->company_doc_no : '' ?>" >  
                    </div>
                </div>
            </div>  -->           

            <div class="row " style="display:<?=(@$row_extended->ume_id) ? 'block' : 'none' ?>;">
                <div class="form-group text-center" style="width:100%">
                    <?php
                    (@$row_extended->identity_verified==1) ? $iv_selected = 'checked' : $iv_selected = '';

                    // (@$row_extended->mobile_verified==1) ? $mv_selected = 'checked' : $mv_selected = ''; 

                    // (@$row_extended->email_verified==1) ? $ev_selected = 'checked' : $ev_selected = ''; 
                    ?>
                    <label for="identity_verified" class="m-2">
                        <input type="checkbox" class="switchery" data-size="sm" name="identity_verified" id="identity_verified" value="1" <?=$iv_selected?> > Identity Verified
                    </label>

                    <!-- <label for="mobile_verified" class="m-2">
                        <input type="checkbox" class="switchery" data-size="sm" name="mobile_verified" id="mobile_verified" value="1" <?=$mv_selected?> > Mobile Verified
                    </label> -->

                    <!-- <label for="email_verified" class="m-2">
                        <input type="checkbox" class="switchery" data-size="sm"  name="email_verified" id="email_verified" value="1" <?=$ev_selected?> > Email Verified
                    </label> -->
                </div>
            </div> 

            <input type="hidden" name="ume_id" value="<?=(@$row_extended->ume_id) ? $row_extended->ume_id : '0' ?>">
            <input type="hidden" name="email_verified" value="<?=(@$row_extended->email_verified) ? $row_extended->email_verified : '0' ?>">
            <input type="hidden" name="mobile_verified" value="<?=(@$row_extended->mobile_verified) ? $row_extended->mobile_verified : '0' ?>">
            
        </div>

        <div class="form-actions text-right">
            <button type="reset" data-dismiss="modal" class="btn btn-danger mr-1">
                <i class="ft-x"></i> Cancel
            </button>
            <button type="submit" class="btn btn-primary mr-1"  >
                <i class="ft-check"></i> Save
            </button>
        </div>
    </form>
    <!-- End: form -->

                                </div>
                            </div>

<script type="text/javascript">
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
    $(document).on('keyup','[name=username]',function(){
        var $this = $(this);

        $.ajax({
            url: "<?php echo base_url('host/remote'); ?>",
            method: "POST",
            data: {
                username:$this.val(),
                table_name:'usermaster',
            },
            success: function(data){
                //console.log(data);
                if (data == 'duplicate') {
                    $('[name=username]').next('span').remove();
                    $('[name=username]').after('<span class="text-danger">Already Exist.</span>');
                    $('button[type="submit"]').prop('disabled', true);
                }else{
                    $('[name=username]').next('span').remove();
                    $('button[type="submit"]').prop('disabled', false);
                }
            },
        });        
    });

    // $(document).on('change','[name=email]',function(){
    //     var $this = $(this);
    //     if ($this.val() !='') {
    //         $('[name=email]').after('<button type="button" name="email_otp" class="btn btn-primary mt-2">Email Verify</button>');
    //     }else{
    //         $('[name=email]').next('button').remove();
    //     }                       
    // });

    $('[name=email_otp]').click(function(){
        $.ajax({
            url: "<?php echo base_url('Host_m/email_otp'); ?>",
            method: "POST",
            data: {
                email:$('[name=email]').val(),
            },
            success: function(data){
                $('[name=email]').next('button').remove();
                toastr.success("Check your email");
                $('[name=email]').after('<div class="row mt-2"><div class="col-4"><input type="text" class="form-control" placeholder="Code" name="email_code"></div><div class="col-4"><button type="button" name="email_verify" class="btn btn-primary">Email Verify</button></div></div>');

                $('[name=email_verify]').click(function(){
                    $.ajax({
                        url: "<?php echo base_url('Host_m/email_verify'); ?>",
                        method: "POST",
                        data: {
                            email:$('[name=email]').val(),
                            otp_code:$('[name=email_code]').val(),
                            ume_id:$('[name=ume_id]').val(),
                        },
                        success: function(data){
                            if (data == 'success') {
                              $('[name=email_verified]').val('1');
                              $('[name=email]').next('.row').remove();
                              toastr.success("Verify successfully");                                                        
                            }else{
                                toastr.success("OTP wrong");
                            }                               
                        },
                    });
                });
            },
        });
    }); 

    // $(document).on('change','[name=mobile]',function(){
    //     var $this = $(this);
    //     if ($this.val() !='') {
    //         $('[name=mobile]').after('<button type="button" name="mobile_otp" class="btn btn-primary mt-2">Mobile Verify</button>');
    //     }else{
    //         $('[name=mobile]').next('button').remove();
    //     }                        
    // });

    $('[name=mobile_otp]').click(function(){
        $.ajax({
            url: "<?php echo base_url('Host_m/mobile_otp'); ?>",
            method: "POST",
            data: {
                mobile:$('[name=mobile]').val(),
            },
            success: function(data){
                $('[name=mobile]').next('button').remove();
                toastr.success("Check your Mobile");
                $('[name=mobile]').after('<div class="row mt-2"><div class="col-4"><input type="text" class="form-control" placeholder="Code" name="mobile_code"></div><div class="col-4"><button type="button" name="mobile_verify" class="btn btn-primary">Mobile Verify</button></div></div>');

                $('[name=mobile_verify]').click(function(){
                    $.ajax({
                        url: "<?php echo base_url('Host_m/mobile_verify'); ?>",
                        method: "POST",
                        data: {
                            mobile:$('[name=mobile]').val(),
                            otp_code:$('[name=mobile_code]').val(),
                            ume_id:$('[name=ume_id]').val(),
                        },
                        success: function(data){
                            if (data == 'success') {
                              $('[name=mobile_verified]').val('1');
                              $('[name=mobile]').next('.row').remove();
                              toastr.success("Verify successfully");
                            }else{
                                toastr.success("OTP wrong");
                            }                               
                        },
                    });
                });
            },
        });
    });

    // $(document).on('change','[name=identity]',function(){
    //     var $this = $(this);
    //     if ($this.val() == '1') {
    //         //$('.personal').show();
    //         $('.company').hide();

    //         $('.personal input').prop('required', true);
    //         $('.company input').prop('required', false);
    //         $('.personal-head label').html('Personal Details');
    //     }else{
    //         //$('.personal').hide();
    //         $('.company').show();

    //         $('.personal input').prop('required', true);
    //         $('.company input').prop('required', true);
    //         $('.personal-head label').html('Company Details');
    //     }               
    // });

$('#country').change(function() {
    var id = $(this).val();
    $('#state').load('<?=base_url()?>getStates/'+id);
})

$('#state').change(function() {
    var id = $(this).val();
    $('#city').load('<?=base_url()?>getCities/'+id);
})
</script>
