
<div class="row">
	<input type="hidden" name="property_id" value="<?=$pro_id?>">
	<input type="hidden" name="date" value="<?=$date;?>">
	<div class="col-sm-3">
		<div class="form-group">
            <label for="epPrice">EP Price</label>
            <input type="number" id="epPrice" class="form-control" name="epPrice" value="<?=@$inventory->ep_price;?>" readonly>
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="cpPrice">CP Price</label>
            <input type="number" id="cpPrice" class="form-control" name="cpPrice" value="<?=@$inventory->cp_price;?>" readonly>
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="mapPrice">MAP Price</label>
            <input type="number" id="mapPrice" class="form-control" name="mapPrice" value="<?=@$inventory->map_price;?>" readonly>
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="apPrice">AP Price</label>
            <input type="number" id="apPrice" class="form-control" name="apPrice" value="<?=@$inventory->ap_price;?>" readonly>
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="epextraBeddingPrice">EP Extra Bed Price</label>
            <input type="number" id="epextraBeddingPrice" class="form-control" name="epextraBeddingPrice" value="<?=@$inventory->ep_extra_bedding_price;?>" readonly>
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="cpextraBeddingPrice">CP Extra Bed Price</label>
            <input type="number" id="cpextraBeddingPrice" class="form-control" name="cpextraBeddingPrice" value="<?=@$inventory->cp_extra_bedding_price;?>" readonly>
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="mapextraBeddingPrice">MAP Extra Bed Price</label>
            <input type="number" id="mapextraBeddingPrice" class="form-control" name="mapextraBeddingPrice" value="<?=@$inventory->map_extra_bedding_price;?>" readonly>
        </div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
            <label for="apextraBeddingPrice">AP Extra Bed Price</label>
            <input type="number" id="apextraBeddingPrice" class="form-control" name="apextraBeddingPrice" value="<?=@$inventory->ap_extra_bedding_price;?>" readonly>
        </div>
	</div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" disabled>
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
        </div>
	</div>
	
</div>
