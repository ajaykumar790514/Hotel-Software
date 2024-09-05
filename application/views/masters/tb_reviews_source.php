<div class="card-body card-dashboard">
    <p class="card-text">............</p>


    <div class="table-responsive">
        <table class="table table-striped table-bordered base-style" id="myTable">
            <thead>
                <tr>
                    <th>Sr. no.</th>
                    <th style="width: 50%;">Name</th>
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
                        <div class="collapse show show-<?=$row->id?>"><?=$row->name?></div>
                        <div class="collapse hide-<?=$row->id?>">
                            <form class="form ajaxsubmit reload-tb" action="<?=base_url()?>reviews_source/save/<?=$row->id?>" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" id="name" class="form-control input-sm" placeholder="Reviews Source Name" name="name" value="<?=$row->name?>">
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
                        <span class="changeStatus" onclick='changeStatus(this)' value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->id?>,reviews_source_master"><i class="<?=($row->status==1) ? 'la la-check-circle' : 'icon-close'?>"></i></span>
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
