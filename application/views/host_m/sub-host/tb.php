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
                    <input type="search" class="form-control form-control-sm" id="tb-search" placeholder="Search" aria-controls="DataTables_Table_0" >
                </label>
            </div>
        </div>
    </div>
   <!-- <div class="row"> -->
   <div class="table-responsive pt-1">
       <table class="table table-striped table-bordered base-style" id="mytable">
           <thead>
               <tr>
                   <th>Sr. no.</th>
                   <th>Name</th>
                   <th>Role</th>
                   <th>Propeties</th>
                   <th>username</th>
                   <th>mobile</th>
                   <th class="text-center">Status</th>
                   <th style="width: 180px;">Action</th>
               </tr>
           </thead>
           <tbody>
               <?php $i=$page;
               foreach ($rows as $row) { ?>
               <tr>
                   <td><?=++$i?></td>
                   <td><?=$row->name?></td>
                   <td>
                    <?=($row->user_role==5) ? 'Manager' : '' ?>
                    <?=($row->user_role==6) ? 'Care Taker' : '' ?>
                   </td>
                   <td>
                    <ol>
                       <?php foreach ($row->propnames as $propnames) {
                          echo "<li>";
                          echo $propnames;
                          echo "</li>";
                        }
                        ?>
                    </ol>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Property Access - <?=$row->name?>" data-url="<?=base_url()?>sub-host/propaccess/<?=$row->id?>" class="btn btn-primary btn-sm">Manage Property</a>
                   </td>
                   <td><?=$row->username?></td>
                   <td><?=$row->mobile?></td>

                   
                   <td class="text-center">
                       <span class="changeStatus" data-toggle="change-status" value="<?=($row->isactive==1) ? 0 : 1?>" data="<?=$row->id?>,usermaster,id,isactive" ><i class="<?=($row->isactive==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                   </td>

                   
                  
                   <td>
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Host - <?=$row->name?>" data-url="<?=$update_url?><?=$row->id?>" title="Update">
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
 
<!-- </div> -->

<script type="text/javascript">
    if ('<?=$search?>'!='') {
        $('#tb-search').val('<?=$search?>').focus();
    }
</script>