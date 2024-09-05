<div class="card-body card-dashboard">
    <p class="card-text">............</p>


    <div class="table-responsive">
        <table class="table table-striped table-bordered base-style" id="myTable">
            <thead>
                <tr>
                    <th>Sr. no.</th>
                    <th style="width: 50%;">Title</th>
                    <th class="text-center">Status</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td >
                        <div class="collapse show show-<?=$row->id?>"><?=$row->title?></div>
                        <div class="collapse hide-<?=$row->id?>">
                            <form class="form ajaxsubmit reload-tb" action="<?=$update_url?><?=$row->id?>" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" id="title" class="form-control input-sm" placeholder="Sleeping Arrangements Title" name="title" value="<?=$row->title?>">
                                    </div>
                                    <div class="col-md-6">
                                        <button type="reset" class="btn btn-danger btn-sm mr-1" data-toggle="show-hide" data-target="<?=$row->id?>">
                                            <i class="ft-x"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-sm mr-1">
                                            <i class="ft-check"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                        
                            
                    </td>
                    
                    <td class="text-center">
                        <span class="changeStatus" onclick='changeStatus(this)' value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->id?>,sleeping_master"><i class="<?=($row->status==1) ? 'la la-check-circle' : 'icon-close'?>"></i></span>
                    </td>
                   
                    <td>
                        <a  href="javascript:void(0)" data-toggle="show-hide" data-target="<?=$row->id?>">
                            <i class="la la-pencil-square"></i>
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
