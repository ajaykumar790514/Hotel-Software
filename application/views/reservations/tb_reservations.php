<div class="card-body card-dashboard p-1">
    <p class="card-text">............</p>

    <style type="text/css">
        .flat_no {
            /*display: inline-block!important;*/
        }

        .res-tb thead>tr>th,
        .res-tb tbody>tr>td {
            padding: 12px 8px;
            vertical-align: baseline;
        }
    </style>
    <!-- <div class="table-responsive"> -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered  res-tb" id="myTable">
            <thead>
                <tr>
                    <!-- <th class="flat_no">Room No</th> -->
                    <th>Arrival - Departure</th>
                    <th>Guest</th>
                    <th>Booked From</th>
                    <th>Room Plan</th>
                    <th>Booked On</th>
                    <th>Status</th>
                    <th>Total payout</th>
                    <th>Payment</th>
                    <?php if (@$_POST['checked_in'] == 'on') { ?>
                        <th>Check Out</th>
                    <?php } ?>
                    <!-- <th>Check List</th> -->
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($rows)){
                 $i = $page;
                foreach ($rows as $row) {
                    ++$i;
                    $flat_no   = '';
                    $propid    = '';
                    $propname  = title('propmaster', 'propid', 'id', 'propname'); ?>
                    <tr>
                        <!-- <td class="flat_no"><?= $flat_no ?></td> -->
                        <td>
                            <?= _date($row->start_date) ?> <strong>&nbsp;-&nbsp;</strong> <?= _date($row->end_date) ?>
                        </td>
                        <td>
                            <?= $row->guest_name ?> <span class="text-info"><?= $row->contact ?></span>
                        </td>
                        <td><?= title('booking_type', $row->booking_from, 'id', 'type') ?></td>
                        <td><?= title('booking_type_master', $row->booking_type, 'id', 'name') ?></td>
                        <td><?= date_time($row->booking_date) ?></td>
                        <td>
                            <?= (@$row->rescheduled == 1) ? '<strong>Rescheduled </strong>' : '' ?>
                            <?= (@$row->flat_changed == 1) ? '<strong>Room Changed </strong>' : '' ?>
                            <?= (@$row->extended == 1) ? '<strong>Extended</strong>' : '' ?>
                            <?= title('booking_status', $row->status, 'id', 'status') ?>

                            <?php
                            if ($row->status != 5) {
                                if ($row->status != 4) { ?>
                                    &nbsp;<a data-toggle="modal" data-target="#showModal" data-whatever="Update Status" data-url="<?= $status_url ?><?= $row->id ?>" href=""><i class="ft-edit"></i></a>
                            <?php }
                            } ?>

                            <?php
                            if ($row->status == 4) {
                                // echo " ( ".title('cancellation_reason_master',$row->cancellation_reason_id,'id','title')." )";
                            } ?>

                        </td>
                        <td><?php echo setting()->currency.''.$row->total ?></td>
                        <td><?= title('payment_status', $row->payment_status, 'id', 'status') ?></td>
                        <?php if (@$_POST['checked_in'] == 'on') { ?>
                            <td center>
                                <?php if ($row->checkout_time1 == null) { ?>
                                    <a href="#" class="text-info" data-toggle="modal" data-target="#showModal-xl" data-whatever="Check Out" data-url="<?= $checkout_url ?><?= $row->id ?>" title="Check Out Details">
                                        Check Out
                                    </a>
                                <?php } else { ?>
                                    Checked Out
                                <?php } ?>

                            </td>
                        <?php } ?>
                        <!-- <td>
                            <?php //if (@$row->check_out_list) { ?>
                                <a href="#" class="text-info" data-toggle="modal" data-target="#showModal-xl" data-whatever="Check Out List" data-url="<?= $check_out_list_url ?><?= $row->id ?>" title="Check Out List">
                                Check Out List
                            </a>
                            <?php //} ?>
                        </td> -->
                        <td class="text-center">
                        <a href="#" class="text-info" data-toggle="modal" data-target="#showModal-xl" data-whatever="Booking Details" data-url="<?= $detail_url ?><?= $row->id ?>" title="Booking Details">
                                <i class="la la-info" style="font-size:2rem"></i>
                            </a>
                            <?php  $count = $this->model->Counter('checkin', array('booking_id' => $row->id));
                                 if($count==0  && $row->status !=4){?>
                                <a href="#" class="text-info" data-toggle="modal" data-target="#showModal-xl" data-whatever=" Edit Booking Details ( <?= $row->guest_name ?> )" data-url="<?=$update_url ?><?= $row->id ?>" title=" Edit Booking Details">
                                <i class="la la-pencil-square" style="font-size:2rem"></i>
                            </a>
                            <?php }?>
                            <a href="#" class="text-info" data-toggle="modal" data-target="#showModal-xl" data-whatever="Transaction Details" data-url="<?= $tr_url ?><?= $row->id ?>" title="Transaction Details">
                                <i class="la la-money" style="font-size:2rem"></i>
                            </a>

                          
                            <!-- <a href="<?= $receipt_url ?><?= $row->id ?>"  class="text-success" target="_blank" title="Receipt">
                                <i class=" la la-file-text"></i>
                            </a> -->
                            <?php if ($row->payment_status != 2 && $row->status != 4) { ?>
                                <!-- <a href="<?= $payment_link ?><?= $row->id ?>" class="text-primary payment-link" title="Send Payment Link" >
                            <i class="la la-link"></i>
                        </a> -->
                                <!-- <a href="#" data-url="<?= $paynow_url ?><?= $row->id ?>" data-toggle="modal" data-target="#showModal" data-whatever="Pay Now" class="text-info" title="Pay Now" >
                            <i class="la la-inr"></i>
                        </a> -->
                            <?php } ?>

                          

                            <?php
                            if ($row->status != 5) {
                                if ($row->status != 4) { ?>
                                    <a href="#" data-url="<?= $cancel_booking_url ?><?= $row->id ?>" data-toggle="modal" data-target="#showModal-sm" data-whatever="Cancel Booking" class="text-danger" title="Cancel Booking"><i class="la la-times" style="font-size:2rem"></i></a>
                                <?php }
                                if ($row->status != 4) { ?>
                                    <!-- <a href="<?= $extend_url ?><?= $row->id ?>" class="text-success" target="_blank" title="Extend" ><i class="la la-angle-double-right"></i></a> -->
                                <?php }
                                if ($row->status != 4) { ?>
                                    <!-- <a href="<?= $change_flat_url ?><?= $row->id ?>" class="text-warning" target="_blank" title="Change Room" > <i class="la la-retweet"></i> </a> -->
                                <?php }
                                if ($row->status != 4) { ?>
                                    <!-- <a data-toggle="modal" data-target="#showModal" data-whatever="Pre Check Out" data-url="<?= $pre_check_out_url ?><?= $row->id ?>" href="#" class="text-primary" title="Pre Check Out"> <i class="la la-minus-circle"></i> </a> -->
                                <?php }
                                if ($row->status != 4) { ?>
                                    <!-- <a target="_blank" href="<?= $reschedule_booking_url ?><?= $row->id ?>" class="text-primary" title="Reschedule Booking" ><i class="la la-calendar-o"></i> </a> -->

                            <?php }
                            } ?>
                            <a data-url="<?= $receipt_url ?><?= $row->id ?>" class="text-success" data-toggle="modal" data-target="#showModal-xl" data-whatever="Bills (  <?= $row->guest_name ?> ,  <?= $row->contact ?> )" title="Bills">
                                <i class=" la la-file-text" style="font-size:2rem"></i>
                            </a>
							<a data-url="<?= $send_mail_url ?><?= $row->id ?>" class="text-success" data-toggle="modal" data-target="#showModal" data-whatever="Send Bills to Mail (  <?= $row->guest_name ?> ,  <?= $row->contact ?> )" title="Send Bills to Mail ">
							<i class="la la-envelope" style="font-size:2rem"></i>
                            </a>
                        </td>


                    </tr>


                <?php
                } }
                ?>


            </tbody>

        </table>

    </div>
    <div class="row">
        <div class="col-md-6 text-left">
            <span>Showing <?= $page + 1 ?> to <?= @$i ?> of <?= $total_rows ?> entries</span>
        </div>
        <div class="col-md-6 text-right">
            <?= $links ?>
        </div>
    </div>
</div>

