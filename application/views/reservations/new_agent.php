
<form class="ajaxsubmit-agent" 
	  action="<?=base_url()?>reservations/save_agent/<?=$user_id?>" method="POST" enctype="multipart/form-data">
<div class="row">
	<div class="col-md-6">
		<div class="form-group select-date">
            <label>Agent Name<sup>*</sup></label>
            <input type="text" class="form-control" placeholder="Enter Agent Name" name="name" required>
        </div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
           	<label>Mobile<sup>*</sup> </label>
			<input type="number" class="form-control" placeholder="Mobile Number" name="mobile" required>
        </div>
	</div>	
    <div class="col-md-12">
		<div class="form-group">
           	<label>Company Name<sup>*</sup> </label>
			<input type="text" class="form-control" placeholder="Entar Company Name" name="company" required>
        </div>
	</div>
	<div class="col-md-12">
		<div class="form-actions d-flex justify-content-end">
			<button type="submit" class="btn btn-primary btn-sm mr-1">
                <i class="ft-check"></i> Save
            </button>
            
            <button type="reset" data-dismiss="modal" class="btn btn-danger btn-sm mr-1 close-btn">
                <i class="ft-x"></i> Cancel
            </button>
            
        </div>
	</div>	
	
</div>
</form>



