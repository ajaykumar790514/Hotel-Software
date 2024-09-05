<!-- form -->
<form class="form ajaxsubmit reload-tb" action="<?=base_url()?>property_reviews/save/<?=$pro_id?>/<?=$flat_id?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="guest_name">Guest Name</label>
                    <input type="text" id="guest_name" class="form-control" placeholder="Guest Name" name="guest_name">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="guest_image">Guest Image Url</label>
                    <input type="text" id="guest_image" class="form-control" placeholder="Guest Image Url" name="guest_image">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" class="form-control" placeholder="Title" name="title">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="propname">Review Source</label>
                    <select id="reviewfrom" name="reviewfrom" class="form-control">
                         <?php
                            echo optionStatus('','-- Select --');
                            foreach ($r_source as $row) {
                                echo optionStatus($row->name,$row->name);
                            }
                        ?>
                    </select>
                </div>

                

                <div class="form-group">
                    <label for="rating">Rating</label>
                    <div class="rating">    
                     <input type="radio" name="rating" value="5" id="5">
                       <label for="5">☆</label> 
                       <input type="radio" name="rating" value="4" id="4">
                       <label for="4">☆</label> 
                       <input type="radio" name="rating" value="3" id="3">
                       <label for="3">☆</label> 
                       <input type="radio" name="rating" value="2" id="2">
                       <label for="2">☆</label> 
                       <input type="radio" name="rating" value="1" id="1">
                       <label for="1">☆</label>
                    </div>  

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="review">Review</label>
                    <textarea class="form-control" placeholder="Review" id="review" rows="5" name="review"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="review">Date Time</label>
                    <input type="datetime-local"  class="form-control" placeholder="created_on" id="created_on"  name="created_on" value="<?=$current_d?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="verified">Verified</label>
                    <select id="verified" name="verified" class="form-control">
                        <?php
                        echo optionStatus('','-- Select --',1);
                        echo optionStatus('1','Yes',1);
                        echo optionStatus('0','No',1);
                        ?>
                    </select>
                    
                </div>
            </div>
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


