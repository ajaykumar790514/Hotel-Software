<!-- form -->
<form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body row">
        <div class="form-group col-6">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="Name" name="name" value="<?=@$row->name?>" required>
        </div>  

        <div class="form-group col-6">
            <label>Title</label>
            <input type="text" class="form-control" placeholder="Title" name="title" value="<?=@$row->title?>">
        </div>

        <div class="form-group col-6">
            <label>Type</label>
            <select class="form-control" name="type" required>
                <option value="">Select..</option>
                <option value="location" <?=@$row->type == 'location' ? 'selected':''; ?>>Location</option>
                <option value="property" <?=@$row->type == 'property' ? 'selected':''; ?>>Property</option>
                <option value="top_banner" <?=@$row->type == 'top_banner' ? 'selected':''; ?>>Top Banner</option>
            </select>
        </div>

        <div class="form-group col-6">
            <label>Link</label>
            <select class="form-control" name="link">
                <option value="">Select..</option>
            </select>
        </div>

        <div class="form-group col-6">
            <label>Sequence</label>
            <input type="number" class="form-control" placeholder="Sequence" name="seq" value="<?=@$row->seq?>">
        </div>

        <div class="form-group col-6">
            <label>Photo</label>
            <input type="file" class="form-control" name="photo" <?=@$row->photo ? '':'required'; ?>>
            <input type="hidden" name="old_photo" value="<?=@$row->photo?>">
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

<script>
    <?php if (@$row->type) { ?>
        $(document).ready( function(){
            let value = '<?=$row->type?>';
            let id = '<?=$row->link_id?>';
            if (value !='top_banner') {
                $('[name=link]').load('<?=base_url()?>home_banner/'+value+'/'+id);   
            }     
        });
    <?php } ?>
    $(document).on('change', '[name=type]', function(){
        let value = $(this).val();
        if (value !='top_banner') {
            $('[name=link]').load('<?=base_url()?>home_banner/'+value);   
        }     
    });
</script>


