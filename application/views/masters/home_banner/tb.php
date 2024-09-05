<div class="card-body card-dashboard">
    <p class="card-text">............</p>
    <div class="row">
        <div class="col-sm-12 col-md-6">
    
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                <label>
                    <input type="search" class="form-control form-control-sm" id="tb-search" placeholder="Search" aria-controls="DataTables_Table_0" >
                </label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered base-style" id="myTable">
            <thead>
                <tr>
                    <th>Sr. no.</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Link ID</th>
                    <th>Seq</th>
                    <th class="text-center">Active</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=$page;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><img src="<?=IMGS_URL.$row->photo?>" class="zoom-img" width="100"></td>
                    <td><?=$row->name?></td>
                    <td><?=$row->title?></td>
                    <td><?=$row->type?></td>
                    <td><?=$row->link_id?></td>
                    <td><?=$row->seq?></td>
                    <td class="text-center">
                        <span class="changeStatus" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,home_banner,id,active" ><i class="<?=($row->active==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                    </td>                    
                   
                    <td>                        
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Home Banner" data-url="<?=$update_url?><?=$row->id?>">
                            <i class="la la-pencil-square"></i>
                        </a>

                        <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete" >
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
    <div class="row">
        <div class="col-md-6 text-left">
            <span>Showing <?=$page+1?> to <?=$i?> of <?=$total_rows?> entries</span>
        </div>
        <div class="col-md-6 text-right">
            <?=$links?>
        </div>
    </div>
</div>

