<div class="row">
    <div class="col-md-12">
        <form class="form ajaxsubmit reload-tb" action="<?=base_url()?>property_reviews/save_reply/<?=$pro_id?>/<?=$flat_id?>/<?=$id?>" method="POST" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="reply" class="form-control input-sm" placeholder="Reply" name="reply">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-actions border-none m-0 p-0 text-right">
                            <button type="reset" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">
                                <i class="ft-x"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm mr-1">
                                <i class="ft-check"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive p-1">
        <table class="table table-striped table-bordered base-style" id="myTable">
            <thead>
                <tr>
                    <th>Sr. no.</th>
                    <th>Reply</th>
                    <th class="text-center">Display</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><?=$row->reply?></td>
                    <td class="text-center">
                        <span class="changeStatusDispaly" value="<?=($row->display==1) ? 0 : 1?>" data="<?=$row->id?>,property_reviews_reply"><i class="<?=($row->display==1) ? 'la la-check-circle' : 'icon-close'?>"></i></span>
                    </td>
                    
                    <td>
                        <a href="javascript:void(0)" url="<?=base_url()?>property_reviews/delete_reply/<?=$pro_id?>/<?=$flat_id?>/<?=$row->id?>" onclick="_delete(this)">
                            <i class="la la-trash"></i>
                        </a>
                    </td>
                </tr> 
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>