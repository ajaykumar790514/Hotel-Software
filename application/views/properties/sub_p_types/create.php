
<div class="card-content collapse show">
    <div class="card-body">
                                    
        <form class="form ajaxsubmit validate-form submit reload-tb reload-page" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
        <?php if($total_data==0){?>
            <div class="form-body w-100">
                <div class="col-12 p-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group col-md-12">
                            <label class="control-label">Room Category Name:</label>
                            <input type="text" class="form-control" placeholder="Enter sub property types name" name="name" required >                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-right">
            <button type="reset" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
               <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Add</button>
            </div>
            <?php }else{?>
                <div class="form-body w-100">
                <div class="col-12 p-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group col-md-12">
                            <label class="control-label">Room Category Name:</label>
                            <input type="text" class="form-control" value="<?=$value->name;?>" name="name" required>                        
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-actions text-right">
            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Update</button>
            </div>
                <?php }?>
        </form>
        <!-- End: form -->

    </div>
</div>


