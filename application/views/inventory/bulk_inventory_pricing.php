<script type="text/javascript">
    $(document).ready(function() {
    $(".validate-form").validate({
        rules: {
            startDate:"required",
			endDate:"required",
			epPrice:"required",
			cpPrice:"required",
			mapPrice:"required",
			apPrice:"required",
			epextraBeddingPrice:"required",
			cpextraBeddingPrice:"required",
			mapextraBeddingPrice:"required",
			apextraBeddingPrice:"required",
			status:"required"
        },
        messages: {
            startDate: "Please Select Arrival.",
			endDate:"Please Select Departure.",
			epPrice:"Please Enter EP Price",
			cpPrice:"Please Enter CP Price",
			mapPrice:"Please Enter MAP Price",
			apPrice:"Please Enter AP Price",
			epextraBeddingPrice:"Please Enter EP Extra Bedding Price",
			cpextraBeddingPrice:"Please Enter CP Extra Bedding Price",
			mapextraBeddingPrice:"Please Enter MAP Extra Bedding Price",
			apextraBeddingPrice:"Please Enter AP Extra Bedding Price",
			status:"Please Select Status"
        }
    }); 
});
</script>
<form class="form ajaxsubmit reload-calendar validate-form" action="<?=base_url()?>inventory/bulk_inventory_pricing/<?=$pro_id?>/<?=$flat_id?>" method="POST" enctype="multipart/form-data">
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
            <label for="startDate" class="required">Arrival</label>
            <input type="date" id="startDate" class="form-control" name="startDate">
        </div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
            <label for="endDate" class="required">Departure</label>
            <input type="date" id="endDate" class="form-control" name="endDate">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="epPrice" class="required">EP Price</label>
            <input type="number" id="epPrice" class="form-control" name="epPrice">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="cpPrice" class="required">CP Price</label>
            <input type="number" id="cpPrice" class="form-control" name="cpPrice">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="mapPrice" class="required">MAP Price</label>
            <input type="number" id="mapPrice" class="form-control" name="mapPrice">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="apPrice" class="required">AP Price</label>
            <input type="number" id="apPrice" class="form-control" name="apPrice">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="epextraBeddingPrice" class="required">EP Extra Bed Price</label>
            <input type="number" id="epextraBeddingPrice" class="form-control" name="epextraBeddingPrice">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="cpextraBeddingPrice" class="required">CP Extra Bed Price</label>
            <input type="number" id="cpextraBeddingPrice" class="form-control" name="cpextraBeddingPrice">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="mapextraBeddingPrice" class="required">MAP Extra Bed Price</label>
            <input type="number" id="mapextraBeddingPrice" class="form-control" name="mapextraBeddingPrice">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="apextraBeddingPrice" class="required">AP Extra Bed Price</label>
            <input type="number" id="apextraBeddingPrice" class="form-control" name="apextraBeddingPrice">
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
            <label class="required">Status</label>
            <select name="status" class="form-control">
                <option value="">-- Select --</option>
                <option value="1">Available</option>
                <option value="2">Blocked</option>
            </select>
        </div>
        
    </div>
	<div class="col-sm-12">
		<div class="form-actions text-center float-right">
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
