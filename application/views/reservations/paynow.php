
<!-- <form class="form ajaxsubmit reload-page append" 
	  append-data="#seleted_dates"
	  action="<?=base_url()?>sub_properties/<?=$pro_id?>/reservation/<?=$flat_id?>" 
	  method="POST" 
	  enctype="multipart/form-data" 
	  autocomplete="off" > -->
<form class="form ajaxsubmit reload-tb" 
	  action="<?=$paynow_url?>" 
	  method="POST" 
	  enctype="multipart/form-data" 
	  autocomplete="off" >
<div class="row">
	<div class="col-md-12">

		<div class="col-md-4">
			<div class="form-group">
				<label for="discount_amount">Payment Mode</label>
				<select name="payment_mode" id="payment_mode" class="form-control payment_mode">
					<?php 
					echo optionStatus('','-- Select --',1);
					foreach ($payment_mode as $row) {
						echo optionStatus($row->id,$row->mode,1);
					}
					?>
				</select>
	        </div>

		</div>

		<div class="col-md-8 reference_id d-none">
			<div class="form-group">
				<label for="reference_id">Reference Id</label>
	           	<input type="text" class="form-control" id="reference_id" placeholder="Reference Id" name="reference_id">
	        </div>
		</div>

	</div>
	
	
    
	<div class="col-sm-12">
		<div class="form-actions text-center">
            <button type="reset" data-dismiss="modal" class="btn btn-danger btn-sm mr-1">
                <i class="ft-x"></i> Cancel
            </button>
            <button type="submit" class="btn btn-primary btn-sm mr-1">
                <i class="ft-check"></i> Save
            </button>
        </div>
	</div>

	
	
</div>
</form>


