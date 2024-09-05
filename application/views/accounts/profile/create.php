<style>
	.toggle-password {
	position: absolute;
    right: 24px;
    top: 64px;
    transform: translateY(-50%);
    cursor: pointer;
}
/* .toggle-password2 {
	position: absolute;
    right: 24px;
    top: 64px;
    transform: translateY(-50%);
    cursor: pointer;
} */

</style>
<!-- form -->
<?php if($user->user_role==4){?>
<form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
    <input type="hidden" name="type" value="host">
        <div class="form-group">
            <label>Old Password <a href="#" class="pass-info text-danger" onclick="show_pass('1')"><i class="la la-info"></i></a> <span onclick="show_pass('0')" class="show-pass d-none text-danger"><?=$this->encryption->decrypt(@$user->password);?></span></label>
            <input type="password" class="form-control old_password" placeholder="Old Password" name="old_password" required>
			<span class="toggle-password" data-target="old_password">
				<i class="la la-eye"></i>
				</span>  
        </div>

        <div class="form-group">
            <label>New Password</label>
            <input type="password" class="form-control password" placeholder="Password" name="password" required>
			<span class="toggle-password2" style="right: 11px;
    top: -29px;
    position: relative;
    float: right;" data-target="password">
			<i class="la la-eye"></i>
			</span> 
        </div>
        
    </div>

    <div class="form-actions text-right">
        <button type="reset" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">
            <i class="ft-x"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary btn-sm mr-1">
            <i class="ft-check"></i> Save
        </button>
    </div>
</form>
<?php }elseif($user->user_role==1){?>

    <form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        <input type="hidden" name="type" value="admin">
        <div class="form-group">
            <label>Old Password</label>
            <input type="password" class="form-control old_password" placeholder="Old Password" name="old_password" required>
			<span class="toggle-password" data-target="old_password">
				<i class="la la-eye"></i>
				</span> 
        </div>

        <div class="form-group">
            <label>New Password</label>
            <input type="password" class="form-control password" placeholder="Password" name="password" required>
			<span class="toggle-password2" style="right: 11px;
    top: -29px;
    position: relative;
    float: right;" data-target="password">
			<i class="la la-eye"></i>
			</span> 
        </div>
        
    </div>

    <div class="form-actions text-right">
        <button type="reset" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">
            <i class="ft-x"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary btn-sm mr-1">
            <i class="ft-check"></i> Save
        </button>
    </div>
</form>

    <?php }?>
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
$(document).ready(function() {
    const togglePasswordElements = document.querySelectorAll('.toggle-password2');
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
    function show_pass(id) {
        if(id=='1'){
        $('.show-pass').removeClass('d-none');
        $('.pass-info').addClass('d-none');
        }else{
        $('.pass-info').removeClass('d-none');
        $('.show-pass').addClass('d-none');  
        }
        
    }
</script>
