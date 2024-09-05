<div class="card-content collapse show">
    <div class="card-body">
        <form class="form ajaxsubmit reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Remark</label>
                            <textarea rows="6" class="form-control" name="remark" placeholder="Remark"><?=$reamrk->remark?></textarea>                        
                        </div>
                    </div>                
                </div>
            </div>

            <div class="form-actions text-right">
                <a href="<?=base_url()?>properties" type="reset" class="btn btn-danger mr-1">
                    <i class="ft-x"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary mr-1">
                    <i class="ft-check"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>