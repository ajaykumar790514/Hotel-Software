<div class="card-body card-dashboard">
   <p class="card-text">............</p>
   <div class="row">
   <div class="table-responsive">
       <table class="table table-striped table-bordered base-style">
           <thead>
               <tr>
                   <th>Sr. no.</th>
                   <th>Title</th>
                   <th>Description</th>
                   <th>Icon</th>
                   <th class="text-center">Status</th>
   
                   <th style="width: 180px;">Action</th>
               </tr>
           </thead>
           <tbody>
               <?php $i=0;
               foreach ($rows as $row) { ?>
               <tr>
                   <td><?=++$i?></td>
                   <td><?=$row->title?></td>
                   <td><?=$row->description?></td>
                   <td>
                     
                       <img src="<?=IMGS_URL?><?=$row->icon?>" style="width: 60px; max-height: 60px;">
                    
                   </td>
                   <td class="text-center">
                       <span class="changeStatus" onclick='changeStatus(this)' value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->sa_id?>,property_sleeping_arrangements" column="sa_id"><i class="<?=($row->status==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                   </td>
                  
                   
                   <td>
                       
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Sleeping Arrangements" data-url="<?=base_url()?>sleeping_arr/<?=$pro_id?>/update/<?=$flat_id?>/<?=$row->sa_id?>" title="Update">
                           <i class="la la-pencil-square"></i>
                       </a>
                       

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=base_url()?>sleeping_arr/<?=$pro_id?>/delete/<?=$flat_id?>/<?=$row->sa_id?>" title="Delete" >
                           <i class="la la-trash"></i>
                       </a> 
                       
                       <!-- <a href="">
                           <i class="la la-trash"></i>
                       </a> -->
                   </td>
               </tr> 
               <?php
               }
               ?>
               
               
           </tbody>
           
       </table>

   </div>
 
</div>
