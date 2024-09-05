<script>
  $(document).ready(function() {
    $.validator.addMethod("exactlength", function(value, element, param) {
      return this.optional(element) || value.length == param;
    }, "Please enter exactly {0} digits.");

    $(".needs-validation").validate({
      rules: {
        company_name:"required",
		address:"required",
		email:"required",
		contact:"required",
		gst:"required",
      },
      messages: {
		company_name:"Please Enter Company Name.",
		address:"Please Enter Address",
		email:"Please Enter Email Address",
		contact:"Please Enter Contact Number",
		gst:"Please Enter GST Number",
      },
    });
  });
</script>
<form class="ajaxsubmit needs-validation reload-page reload-tb" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body pt-1 pb-1">
<div class="row">
     <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
			<label class="form-check-label  ">Company Logo <span class="text-danger">Maximum file size 100 kb.</span></label>
            <input type="file" class="form-control" name="logo"  >
			<?php if(!empty($row->logo)){?>
			 <img src="<?=IMGS_URL.$row->logo;?>" height="50px" alt="">
			<?php }?>
            </div>
        </div>
		<div class="col-lg-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-check-label  required">Company Name :</label>
				<input type="text" class="form-control form-control" value="<?=$row->company_name;?>" name="company_name" placeholder="Enter  Company Name">
            </div>
        </div>
		<div class="col-lg-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-check-label  required">Company GST :</label>
				<input type="text" class="form-control form-control" value="<?=$row->gst;?>" name="gst" placeholder="Enter Company GST">
            </div>
        </div>
		<div class="col-lg-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-check-label  required">Email Address :</label>
				<input type="email" class="form-control form-control" name="email" value="<?=$row->email;?>" placeholder="Enter Email Address">
            </div>
        </div>
		<div class="col-lg-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-check-label  required">Contact Number :</label>
				<input type="number" class="form-control form-control" name="contact" placeholder="Enter Contact Number" value="<?=$row->contact;?>">
            </div>
        </div>
		<div class="col-lg-12 col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-check-label  required">Address :</label>
				<textarea class="form-control form-control" name="address" placeholder="Enter Address........."><?=$row->address;?></textarea>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" class="close" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>

<script>
      $('input[type="file"]').bind('change', function() {
        var fileSizeInBytes=(this.files[0].size);
        var fileSizeInKB = fileSizeInBytes / 1024;
        if(fileSizeInKB > 100) {
            alert_toastr('error','Maximum file size should be 100 KB.');
            $('button[type=submit]').prop('disabled', true);	
        }else{
            $('button[type=submit]').prop('disabled', false);
        }
    });
</script>


