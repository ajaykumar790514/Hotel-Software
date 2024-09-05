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
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Property</th>
                    <th>Date Time</th>
                    <th>Entry By</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><?=title('expense_master',$row->expense_master_id,'id','name')?></td>
                    <td><?=$row->amount?></td>
                    <td><?=title('propmaster',$row->prop_master_id,'id','propname')?></td>
                    
                    <td><?=date('d-M-Y h:m A',strtotime($row->date_time))?></td>
                    <td><?=title('usermaster',$row->user_id,'id','name').$row->user_id?></td>
                    <td>
                        <?php if(@$row->photo):  ?>
                            <!-- <a href="#" title="Receipt" class="zoom-img" data-toggle="modal" data-target="#showModal" data-whatever="Receipt" data-url="<?=$row->photo?>"> -->
                            <a href="#" title="Receipt" class="zoom-img" src="<?=$row->photo?>">
                            <i class="la la-image"></i>
                        </a>
                        <?php endif;  ?>
                        <a href="#" title="Update" class="update-expenses" 
                        data-expense_master_id="<?=$row->expense_master_id?>" 
                        data-amount="<?=$row->amount?>"
                        data-date_time="<?=$row->date_time?>"
                        data-prop_master_id="<?=$row->prop_master_id?>"
                        data-old_receipt="<?=$row->photo?>"
                        data-id="<?=$row->id?>">
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

