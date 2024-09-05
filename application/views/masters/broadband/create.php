<!-- form -->
<form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" class="form-control" placeholder="Name" name="name" value="<?=(@$row->name) ? $row->name : '' ?>">
  
        <div class="form-group">
            <label for="speed">Speed</label>
            <input type="text" id="speed" class="form-control" placeholder="Speed" name="speed" value="<?=(@$row->speed) ? $row->speed : '' ?>">
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
<!-- End: form -->


