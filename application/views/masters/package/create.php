<!-- form -->
<form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        <div class="row">
       
        <div class="form-group col-12">
            <label>Name </label>
            <input type="text" class="form-control" placeholder="Enter Package Name" name="name" value="<?=@$row->name;?>" required>
        </div>
        <div class="form-group col-6">
            <label>Gst in ( % )</label>
            <input type="number" class="form-control" placeholder="Enter Gst Ex. 18" name="gst" value="<?=@$row->gst;?>" required>
        </div>
        <div class="form-group col-6">
            <label>Sequence </label>
            <input type="number" class="form-control" placeholder="Enter Package Sequence" name="seq" value="<?=@$row->seq;?>" required>
        </div>
        <div class="form-group col-6">
            <label> Package Photo <span class="text-danger">Maximum file size 100 kb.</span></label>
            <input type="file" class="form-control" name="doc"  >
        </div>
        <div class="form-group col-6">
            <label>Duration in Days </label>
            <input type="number" class="form-control" placeholder="Enter duration days" name="duration_in_days" value="<?=@$row->duration_in_days;?>" required>
        </div>
        <div class="form-group col-6">
            <label>Price</label>
            <input type="number" class="form-control" placeholder="Enter price" name="price" value="<?=@$row->price;?>" required>
        </div>
        <div class="form-group col-6">
            <label>NO.of Properties </label>
            <input type="number" class="form-control" placeholder="Enter no of properties" name="no_of_properties" value="<?=@$row->no_of_properties;?>" required>
        </div>
        <div class="form-group col-6">
            <label>Minimum No.of Rooms </label>
            <input type="number" class="form-control" placeholder="Enter Minimum No of Rooms" name="min_room" value="<?=@$row->min_room;?>" required>
        </div>
        <div class="form-group col-6">
            <label>Maximum No.of Rooms </label>
            <input type="number" class="form-control" placeholder="Enter Maximum No of Rooms" name="max_room" value="<?=@$row->max_room;?>" required>
        </div>
        <div class="form-group col-12">
            <label>Description</label>
            <textarea class="form-control" placeholder="Enter no of properties" name="description"  required><?=@$row->description;?></textarea>
        </div>
        <div class="form-group col-2">
            <label>Is Promotion</label>
            <input type="checkbox" style="height: 30px;width:30px" value="1" name="is_promotion"  <?php if(@$row->is_promotion=='1'){echo "checked";} ;?> >
        </div>
        </div>
              
        
    </div>

    <div class="form-actions text-right float-right">
        <button type="reset" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">
            <i class="ft-x"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary btn-sm mr-1">
            <i class="ft-check"></i> Save
        </button>
    </div>
</form>
<!-- End: form -->
<script>
      $('input[type="file"]').bind('change', function() {
        var fileSizeInBytes=(this.files[0].size);
        //alert(a);
        var fileSizeInKB = fileSizeInBytes / 1024; // Convert bytes to KB
        if(fileSizeInKB > 100) {
            alert_toastr('error','Maximum file size should be 100 KB.');
            $('button[type=submit]').prop('disabled', true);
            $('#profile-pic').removeClass('onchange-submit');
        }else{
            $('button[type=submit]').prop('disabled', false);
           // $('#profile-pic').removeClass('onchange-submit');
        }
    });
</script>


