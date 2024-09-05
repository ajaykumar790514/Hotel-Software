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
                    <th>Company Logo</th>
                    <th>Company Name</th>
                    <th>GST</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th class="text-center">Status</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=$page;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><img src="<?=IMGS_URL.$row->logo;?>" alt="" height="50px" width="50px" data-toggle="modal" data-target="#exampleModal<?=$i;?>"></td>
                    <td><?=$row->company_name?></td>
                    <td><?=$row->gst?></td>
                    <td><?=$row->contact?></td>
                    <td><?=$row->email?></td>
                    <td><?=$row->address?></td>
                    <td class="text-center">
                        <span class="changeStatus" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,company_billing_info,id,active" ><i class="<?=($row->active==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                    </td>                    
                   
                    <td>                        
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Company Details  (  <?=$row->company_name?> ) " data-url="<?=$update_url?><?=$row->id?>">
                            <i class="la la-pencil-square"></i>
                        </a>

                        <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete Company Details" >
                           <i class="la la-trash"></i>
                       </a>
                    </td>
                </tr> 

                <!--Package Image Modal -->
                <div class="modal fade" id="exampleModal<?=$i;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Company Logo ( <?=$row->company_name?>  )</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <img src="<?=IMGS_URL.$row->logo;?>" alt=""  style="height:auto;width:100%" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>
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

