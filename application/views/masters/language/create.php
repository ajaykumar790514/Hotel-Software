<!-- form -->
<form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group">
            <label>Language Speak</label>
            <input type="text" class="form-control" placeholder="Language" name="language" value="<?=@$row->language?>" required>
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


