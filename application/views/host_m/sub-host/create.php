<style>
	.toggle-password {
	position: absolute;
    right: 24px;
    top: 49px;
    transform: translateY(-50%);
    cursor: pointer;
}

</style>
<script>
  $(document).ready(function() {
        // Initialize form validation
        $(".needs-validation").validate({
            rules: {
                username: {
                    required: true,
                    remote: "<?=$remote;?>null/username/"
                },
            },
            messages: {
                username: {
                    required: "Please enter UserName",
                    remote: "UserName already exists!"
                },
            },
            errorElement: "span",
            errorClass: "error",
            highlight: function(element) {
                $(element).addClass("error");
            },
            unhighlight: function(element) {
                $(element).removeClass("error");
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
});
</script>
    <form class="form ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
        <div class="form-body">
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                <label for="Name">Name</label>
                <input type="text" class="form-control" placeholder="Name" name="name" value="<?=(@$row->name) ? $row->name : '' ?>" >
               </div>
                </div>
           
            <div class="col-md-6">
            <div class="form-group">
                <label for="Name" class="required">Role <span class="text-danger">*</span></label>
                <select class="form-control " name="user_role" required>
                    <option value="">-- Select --</option>
					<?php foreach($rows as $r):?>
                    <option value="<?=$r->id;?>" <?=(@$row->user_role==$r->id) ? 'selected' : '' ?> ><?=$r->name;?></option>
					<?php endforeach;?>
                </select>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="username">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Username" name="username" value="<?=(@$row->username) ? $row->username : '' ?>" required>            
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="pic">Photo   <span class="text-danger">Maximum file size 100 kb.</label></label>
                <input type="file" class="form-control" placeholder="pic" name="photo" value="<?=(@$row->pic) ? $row->pic : '' ?>" >  
                <?php if (@$row->pic) { ?>
                    <img src="<?=$row->pic?>">
                <?php } ?>          
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span>
              
                </label>
                <input type="password" class="form-control password" placeholder="Password" name="password"  <?=(@$row) ? '' : 'required' ?> >  
				<span class="toggle-password" data-target="password">
				<i class="la la-eye"></i>
				</span>          
				<?=(@$row) ? '<span class="mt-1 text-white bg-danger"> If you want to change host password then enter a new password otherwise left it blank</span>' : '' ?>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="password">Confirm Password <span class="text-danger">*</span>
               
                </label>
                <input type="password" class="form-control cpassword" placeholder="Confirm Password" name="cpassword"  <?=(@$row) ? '' : 'required' ?> > 
				<span class="toggle-password" data-target="cpassword">
				<i class="la la-eye"></i>
				</span>    
				<?=(@$row) ? '<span class="mt-1 text-white bg-danger"> If you want to change host password then enter a new password otherwise left it blank</span>' : '' ?>        
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" placeholder="Email" name="email" value="<?=(@$row->email) ? $row->email : '' ?>" >            
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" placeholder="Mobile" name="mobile" value="<?=(@$row->mobile) ? $row->mobile : '' ?>" >            
            </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
                <label for="about">About</label>
                <textarea type="text" class="form-control" placeholder="about" name="about" ><?=(@$row->about) ? $row->about : '' ?></textarea>          
            </div>
            </div>
         
            </div>

            <!-- <div class="form-group">
                <label for="about">Language Speaks</label><br>
                <?php foreach ($language as $lrow) {
                    $checked = '';
                    if (@$row_extended->language_speaks) {
                        $language_speaks = explode(',',$row_extended->language_speaks);
                        foreach ($language_speaks as $language_speak) {
                            if ($language_speak == $lrow->lsm_id) {
                                $checked = 'checked';
                            }
                        }
                    }
                    ?>
                    <label for="language<?=$lrow->lsm_id?>">
                        <input type="checkbox" class="switchery" data-size="sm" name="language_speaks[]" value="<?=$lrow->lsm_id?>" <?=$checked?> > <?=$lrow->language?>
                    </label>
                <?php } ?>
            </div> -->

            <!-- <div class="form-group">
                <label for="work">Work</label>
                <select class="form-control" name="work">
                <?php 
                echo optionStatus('','-- Select --',1);
                foreach ($work as $wrow) { 
                    $selected = '';
                    if (@$row_extended->work == $wrow->wm_id) {
                        $selected = 'selected';
                    }
                    echo optionStatus($wrow->wm_id,$wrow->work,$wrow->active,$selected);
                } ?>
                </select>
            </div> -->

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select id="country" name="country" class="form-control">
                            <?=$countries?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="state">State</label>
                        <select id="state" name="state" class="form-control">
                            <?=(@$states) ? $states : '<option value="" >-- Select --</option>' ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="city">City</label>
                        <select id="city" name="city" class="form-control">
                            <?=(@$cities) ? $cities : '<option value="" >-- Select --</option>' ?>

                        </select>
                    </div>
                </div>
            </div> 

            <div class="row ">
                <div class="form-group text-center" style="width:100%">
                    <?php
                    (@$row_extended->identity_verified==1) ? $iv_selected = 'checked' : $iv_selected = '';

                    (@$row_extended->mobile_verified==1) ? $mv_selected = 'checked' : $mv_selected = ''; 

                    (@$row_extended->email_verified==1) ? $ev_selected = 'checked' : $ev_selected = ''; 
                    ?>
                    <label for="identity_verified" class="m-2">
                        <input type="checkbox" class="switchery" data-size="sm" name="identity_verified" id="identity_verified" value="1" <?=$iv_selected?> > Identity Verified
                    </label>

                    <label for="mobile_verified" class="m-2">
                        <input type="checkbox" class="switchery" data-size="sm" name="mobile_verified" id="mobile_verified" value="1" <?=$mv_selected?> > Mobile Verified
                    </label>

                    <label for="email_verified" class="m-2">
                        <input type="checkbox" class="switchery" data-size="sm"  name="email_verified" id="email_verified" value="1" <?=$ev_selected?> > Email Verified
                    </label>
                </div>
            </div> 


           
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
    <script type="text/javascript">
	$(document).ready(function() {
    const togglePasswordElements = document.querySelectorAll('.toggle-password');
    togglePasswordElements.forEach(togglePassword => {
        togglePassword.addEventListener('click', function() {
            const passwordFields = document.querySelectorAll('.' + this.getAttribute('data-target'));
            passwordFields.forEach(passwordField => {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
            });
            this.querySelector('i').classList.toggle('la-eye');
            this.querySelector('i').classList.toggle('la-eye-slash');
        });
    });
});
       $('input[type="file"]').bind('change', function() {
        var fileSizeInBytes=(this.files[0].size);
        //alert(a);
        var fileSizeInKB = fileSizeInBytes / 1024; // Convert bytes to KB
        if(fileSizeInKB > 100) {
            alert_toastr('error','Maximum file size should be 100 KB.');
            $('button[type=submit]').prop('disabled', true);
        }else{
            $('button[type=submit]').prop('disabled', false);
        }
    });
$('#country').change(function() {
    var id = $(this).val();
    $('#state').load('<?=base_url()?>getStates/'+id);
})

$('#state').change(function() {
    var id = $(this).val();
    $('#city').load('<?=base_url()?>getCities/'+id);
})
</script>
