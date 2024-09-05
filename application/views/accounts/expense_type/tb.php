<div class="card-body card-dashboard">
    <p class="card-text">............</p>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <!-- <div class="dataTables_length" id="DataTables_Table_0_length">
                <label>
                    Show 
                    <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control form-control-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> 
                    entries
                </label>
            </div> -->
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                <label>
                    <input type="search" class="form-control form-control-sm static-tb-search" tbtarget="#myTable" placeholder="Search" aria-controls="DataTables_Table_0" >
                </label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered base-style" id="myTable">
            <thead>
                <tr>
                    <th>Sr. no.</th>
                    <th>Property Type</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><?=$row->propname;?></td>
                    <td><?=$row->name?></td>
                    <td class="text-center">
                       <span class="changeStatus" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,expense_master,id,active" ><i class="<?=($row->active==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                   </td>
                    <td>
                        <a href="#" title="Update" class="update-expense-type" data-name="<?=$row->name?>" data-id="<?=$row->id?>">
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
   
 </div>

