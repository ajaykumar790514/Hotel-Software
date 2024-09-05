<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-striped table-bordered base-style" id="mytable">
           <thead>
               <tr>
                   <th>Sr. no.</th>
                   <th>Property</th>
				   <th>Room Category</th>
                   <th>Room Name</th>
                   <th>Room No.</th>
                   <th>Code Name</th>
                   <th>Address</th>
               </tr>
           </thead>
           <tbody>
               <?php $i=0;
               foreach ($rows as $row) { ;?>
               <tr>
                   <td><?=++$i?></td>
                   <td><?=title('propmaster',$row->propid,'id','propname')?> ( <span class="text-primary"><?= title('propmaster', $row->propid, 'id', 'propcode');?> </span>)</td>
				   <td><?=title('sub_property_types',$row->sub_property_type_id,'spt_id','name')?></td>
                   <td><?=$row->flat_name?></td>
                   <td><?=$row->flat_no?></td>
                   <td><?=$row->flat_code_name?></td>
                   <td><?=title('propmaster',$row->propid,'id','address')?></td>
				  

                   <!-- <td><?=title('location',$row->location_id)?></td> -->
               </tr> 
               <?php
               }
               ?> 
           </tbody>
       </table>
   </div>
</div>
