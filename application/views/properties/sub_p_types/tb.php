<div class="card-body card-dashboard">
   <div class="row">
        <div class="col-sm-12 col-md-6">
        </div>
        <div class="col-sm-12 col-md-6">
        </div>
    </div>
   <!-- <div class="row"> -->
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
           <tr>
          <th>S.No.</th>
          <th>Property Name</th>
          <th>Sub Property Type Name</th>
          <th>Status</th>
          <th>Action</th>
           </tr>
           </thead>
           <tbody class="text-nowrap">
                <?php $i=$page;
                   foreach ($rows as $row) {
                ?>
               <tr>
                    <td class="sr_no"><?=++$i?></td>
                    <td><?=$row->propname;?></td>
                    <td><?=$row->name;?></td>
                    <td class="text-center">
                       <span class="changeStatus" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->spt_id?>,sub_property_types,spt_id,active" ><i class="<?=($row->active==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                   </td>

                    <td> 
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Room Category  (<?=$row->name?>)" data-url="<?=$update_url?><?=$row->spt_id?>" title="Update">
                           <i class="la la-pencil-square"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?>/<?=$row->spt_id?>" title="Delete" >
                           <i class="la la-trash"></i>
                       </a>
                    </td>
               </tr> 
               <?php  }?>               
               
           </tbody>
           
       </table>

   </div>

   <div class="row">
        <div class="col-md-6 text-left">
            <span>Showing <?= (@$rows) ? $page+1 : 0 ?> to <?=$i?> of <?=$total_rows?> entries</span>
        </div>
        <div class="col-md-6 text-right">
            <?=$links?>
        </div>
    </div>
