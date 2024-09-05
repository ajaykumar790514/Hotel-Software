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
                   <th>Guest Name</th>
                   <th>Address</th>
				   <th>Booking Date.</th>
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
                   <td><?= title('booking_new', $row->booking_id, 'id', 'guest_name');?> ( <span class="text-primary"><?= title('booking_new', $row->booking_id, 'id', 'contact');?> </span>)</td>
                   <td><?=title('propmaster',$row->propid,'id','address')?></td>
				   <td>
					<?php 
					$booking_date = title('booking_new', $row->booking_id, 'id', 'booking_date');
					$formatted_date = date('h:i A d F Y', strtotime($booking_date));
					echo $formatted_date;
					?>
				</td>

                   <!-- <td><?=title('location',$row->location_id)?></td> -->
               </tr> 
               <?php
               }
               ?> 
           </tbody>
       </table>
   </div>
</div>
