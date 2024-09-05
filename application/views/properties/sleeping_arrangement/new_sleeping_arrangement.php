<form class="form ajaxsubmit reload-tb" action="<?=base_url()?>sleeping_arr/<?=$pro_id?>/save/<?=$flat_id?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
     
        <div class="form-group">
            <label for="title">Title</label>
            <select id="title" class="form-control" name="title">
            <?php
                echo optionStatus('','-- Select --');
                foreach ($titles as $row) {
                    echo optionStatus($row->title,$row->title,$row->status);
                }
            ?>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <select id="description" class="form-control" name="description">
            <?php
                echo optionStatus('','-- Select --');
                foreach ($desc as $row) {
                    echo optionStatus($row->title,$row->title,$row->status);
                }
            ?>
            </select>
        </div>

        <!-- <div class="form-group">
            <label for="title">Icon</label>
            <input type="text" id="icon" class="form-control" placeholder="Icon Url" name="icon">
        </div> -->

        <div class="form-group">
            <label >Icon</label><br>
            <?php foreach ($icons as $irow) { ?>
                <label> 
                  <input type="radio" class="icons" name="icon" value="<?=$irow->icon_path?>" >
                  <img src="<?=IMGS_URL?><?=$irow->icon_path?>">
                </label>
            <?php } ?>
        </div>
    </div>

    <div class="form-actions text-right">
        <button type="submit" class="btn btn-primary btn-sm mr-1 float-right">
            <i class="ft-check"></i> Save
        </button>
        <button type="reset" class="btn btn-danger btn-sm mr-1 float-right" data-dismiss="modal">
            <i class="ft-x"></i> Cancel
        </button>
        
    </div>
</form> 
