<script type="text/javascript">
    $(document).ready(function() {
    $(".validate-form").validate({
        rules: {
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
<form class="form ajaxsubmit reload-calendar validate-form" action="<?=base_url()?>inventory/set_inventory_pricing/<?=$pro_id?>/<?=$flat_id?>/<?=$date;?>" method="POST" enctype="multipart/form-data">
<div class="row">
	<input type="hidden" name="property_id" value="<?=$pro_id?>">
	<input type="hidden" name="date" value="<?=$date;?>">
	<div class="col-sm-3">
		<div class="form-group">
            <label for="epPrice" class="required">EP Price</label>
            <input type="number" id="epPrice" class="form-control" name="epPrice" value="<?=@$inventory->ep_price;?>">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="cpPrice" class="required">CP Price</label>
            <input type="number" id="cpPrice" class="form-control" name="cpPrice" value="<?=@$inventory->cp_price;?>">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="mapPrice" class="required">MAP Price</label>
            <input type="number" id="mapPrice" class="form-control" name="mapPrice" value="<?=@$inventory->map_price;?>">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="apPrice" class="required">AP Price</label>
            <input type="number" id="apPrice" class="form-control" name="apPrice" value="<?=@$inventory->ap_price;?>">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="epextraBeddingPrice" class="required">EP Extra Bed Price</label>
            <input type="number" id="epextraBeddingPrice" class="form-control" name="epextraBeddingPrice" value="<?=@$inventory->ep_extra_bedding_price;?>">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="cpextraBeddingPrice" class="required">CP Extra Bed Price</label>
            <input type="number" id="cpextraBeddingPrice" class="form-control" name="cpextraBeddingPrice" value="<?=@$inventory->cp_extra_bedding_price;?>">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="mapextraBeddingPrice" class="required">MAP Extra Bed Price</label>
            <input type="number" id="mapextraBeddingPrice" class="form-control" name="mapextraBeddingPrice" value="<?=@$inventory->map_extra_bedding_price;?>">
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="apextraBeddingPrice" class="required">AP Extra Bed Price</label>
            <input type="number" id="apextraBeddingPrice" class="form-control" name="apextraBeddingPrice" value="<?=@$inventory->ap_extra_bedding_price;?>">
        </div>
	</div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="required">Status</label>
            <select name="status" class="form-control">
                <option value="">-- Select --</option>
                <option value="1" <?php if(@$inventory->status=='1'){ echo "selected";} ;?> >Available</option>
                <option value="2" <?php if(@$inventory->status=='2'){ echo "selected";} ;?>>Blocked</option>
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
