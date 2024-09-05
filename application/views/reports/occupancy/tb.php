<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
            <?php $i=1;$TRooms=$TRoomAvailable=$Tadult=$Tinfant=$Tchildren=0;
            foreach ($rows as $row):
               $Tadult = $Tadult+$row->adult;
               $Tinfant = $Tinfant+$row->infant;
               $Tchildren = $Tchildren+$row->children;
               $TRoomAvailable =  $row->available;
               $TRooms = $TRooms + $row->no_of_rooms;
           $i++; endforeach; ?>
            <tr>
                <th><h4><b>Booked Rooms :</b></h4></th>
                <th colspan="2"><h4><b><?=$TRooms;?> out of  <?=$TRoomAvailable;?></b></h4></th>
                <th><h4><b>Total Adults :</b></h4></th>
                <th colspan="2"><h4><b><?=$Tadult;?></b></h4></th>
                <th><h4><b>Total Children :</b></h4></th>
                <th colspan="2"><h4><b><?=$Tchildren;?></b></h4></th>
                <th><h4><b>Total Infants :</b></h4></th>
                <th colspan="2"><h4><b><?=$Tinfant;?></b></h4></th>
            </tr>
               <tr>
                    <th>Sr.No.</th>
                    <th>Property</th>
                    <th>Room Plan</th>
                    <th>Room No</th>
                    <th>Room Type</th>
                    <th style="width: 200px;">Guest Name</th>
                    <th>Infants</th>
                    <th>Children</th>
                    <th>Adults</th>
                    <th>No of nights</th>
                    <th>Arrival - Departure</th>
               </tr>
               </thead>
                <tbody>
                    <?php $i=1;
                    foreach ($rows as $row):  
                    ?>
                    <tr>
                     <td><?=$i;?></td>
                    <td><?= title('propmaster', $row->property_id, 'id', 'propname') ?>  <span class="text-info"><?= title('propmaster', $row->property_id, 'id', 'propcode') ?> </span> </td>
                    <td><?= title('booking_type_master', $row->booking_type, 'id', 'name') ?></td> 
                    <td><?=$row->rooms;?></td>
                    <td><?=$row->room_type;?></td>
                    <td style="width: 200px;">
                    <?=$row->guest?>(<span class="text-info"><?=$row->guest_contact;?></span>)
                    </td>
                    <td><?=$row->infant;?></td>
                    <td><?=$row->children;?></td>
                    <td><?=$row->adult;?></td>
                    <td><?=(_days_diff($row->start_date,$row->end_date));?> days</td>
                    <td>
                     <?= _date($row->start_date) ?> <strong>&nbsp;-&nbsp;</strong> <?= _date($row->end_date) ?>
                    </td>
                       
                    </tr>
                    <?php $i++;endforeach;?>
                </tbody>
            </table>
        </div>

 
<!-- </div> -->
