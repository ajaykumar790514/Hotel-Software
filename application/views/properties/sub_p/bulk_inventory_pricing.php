<form class="form ajaxsubmit reload-page" action="<?=base_url()?>sub_properties/<?=$pro_id?>/bulk_inventory_pricing/<?=$flat_id?>" method="POST" enctype="multipart/form-data">
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
            <label for="startDate">Start Date</label>
            <input type="date" id="startDate" class="form-control" name="startDate">
        </div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
            <label for="endDate">End Date</label>
            <input type="date" id="endDate" class="form-control" name="endDate">
        </div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
            <label for="dailyPrice">Daily Price</label>
            <input type="number" id="dailyPrice" class="form-control" name="dailyPrice">
        </div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
            <label for="extraBeddingPrice">Extra Bedding Price</label>
            <input type="number" id="extraBeddingPrice" class="form-control" name="extraBeddingPrice">
        </div>
	</div>
	<div class="col-sm-12">
		<div class="form-group text-center">
            <label for="mon" class="mr-1">
            	<input type="checkbox" class="switchery inline-block" data-size="sm" name="days[]" value="Monday" id="mon"> Monday
            </label>
            <label for="tue" class="mr-1">
            	<input type="checkbox" class="switchery inline-block" data-size="sm" name="days[]" value="Tuesday" id="tue"> Tuesday
            </label>
            <label for="wed" class="mr-1">
            	<input type="checkbox" class="switchery inline-block" data-size="sm" name="days[]" value="Wednesday" id="wed"> Wednesday
            </label>
            <label for="thu" class="mr-1">
            	<input type="checkbox" class="switchery inline-block" data-size="sm" name="days[]" value="Thursday" id="thu"> Thursday
            </label>
            <label for="fri" class="mr-1">
            	<input type="checkbox" class="switchery inline-block" data-size="sm" name="days[]" value="Friday" id="fri"> Friday
            </label>
            <label for="sat" class="mr-1">
            	<input type="checkbox" class="switchery inline-block" data-size="sm" name="days[]" value="Saturday" id="sat"> Saturday
            </label>
             <label for="sun" class="mr-1">
            	<input type="checkbox" class="switchery inline-block" data-size="sm" name="days[]" value="Sunday" id="sun"> Sunday
            </label>
        </div>
	</div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">-- Select --</option>
                <option value="1">Available</option>
                <option value="2">Blocked</option>
            </select>
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