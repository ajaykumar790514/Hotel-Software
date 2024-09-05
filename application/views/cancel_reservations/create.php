<!-- form -->
<form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body row">
        <div class="col-6 form-group">
        <label for="">Select Property:</label>
        <select name="property_id" id="" class="form-control" required>
            <option value="">--Select--</option>
            <?php foreach($property as $pro):?>
            <option value="<?=$pro->id;?>" <?php if(@$row->property_id==$pro->id){echo "selected";} ;?> ><?=$pro->propname;?></option>
            <?php endforeach;?>    
        </select>
        </div>
        <div class="col-6 form-group">
            <label>Cancellation Type</label>
            <select name="discount_type" id="" class="form-control" required>
                <option value="">--Select--</option>
                <option value="1" <?php if(@$row->discount_type==1){echo "selected";} ;?> >Percentage</option>
                <option value="0"  <?php if(@$row->discount_type==0){echo "selected";} ;?>  >Fixed</option>
            </select>
        </div>        
        <div class="col-6 form-group">
            <label for="">Enter Cancellation Charge</label>
            <input type="number" name="cancellation_charge" value="<?=@$row->cancellation_charge;?>" class="form-control" placeholder="Enter Cancellation Charge" required>
        </div>
        <div class="col-6 form-group">
            <label for="">Before Days</label>
            <input type="number" name="before_days" value="<?=@$row->before_days;?>" class="form-control" placeholder="Enter Before Days" required>
        </div>
      </div>
      <input type="hidden" value="<?=$user->id;?>" name="user_id">
    <div class="form-actions text-right">
        <button type="reset" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">
            <i class="ft-x"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary btn-sm mr-1">
            <i class="ft-check"></i> Save
        </button>
    </div>
</form>
<!-- End: form -->


