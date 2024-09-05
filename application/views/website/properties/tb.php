<div class="card-body card-dashboard">
   <p class="card-text">............</p>
   <!-- <div class="row"> -->
   <div class="table-responsive pt-1">
       <table class="table table-striped table-bordered base-style" id="mytable">
           <thead>
               <tr>
                   <th>Sr. no.</th>
                   <th>Heading</th>
                   <th>Sub. Heading</th>
                   <th>Property</th>
                   <th class="text-center">Status</th>
                   <th class="text-center">Order</th>
                   <th style="width: 180px;">Action</th>
               </tr>
           </thead>
           <tbody>
               <?php $i=0;
               foreach ($rows as $row) { ?>
               <tr>
                   <td><?=++$i?></td>
                   <td><?=$row->heading?></td>
                   <td><?=$row->subHeading?></td>
                   <td>
                    <ol>
                      
                    
                    <?php
                    $flat_ids = explode(',', $row->property_id);
                    foreach ($row->flat_name as $frow) {
                      echo "<li>";
                      echo $frow;
                      echo "</li>";
                    }
                    ?>
                    </ol>
                      
                    </td>
                   <td class="text-center">
                       <span class="changeStatus" onclick='changeStatus(this)' value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->id?>,website_properties" ><i class="<?=($row->status==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                   </td>

                   <td class="text-center">
                        <input type="number" value="<?=$row->indexing?>" data="<?=$row->id?>,website_properties,id,indexing" class="change-indexing" min="0">
                    </td>
                  
                   <td>
                       <a href="<?=$update_url?><?=$row->id?>" title="Update">
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
 
<!-- </div> -->
