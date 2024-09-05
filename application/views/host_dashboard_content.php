<style>
	.card .card-title {
    font-weight: 500 !important;
}
</style>
<!-- <div style="width: 180px;"></div> -->
<div class="content-wrapper">
        <!-- <div class="content-wrapper-before"></div> -->
        <div class="content-header row">
        </div>
        <div class="content-body">
            
            <!-- eCommerce statistic -->
           <?php /* <div class="row justify-content-center pt-1 pb-1">
            <div class="col-sm-10 text-center float-right"></div>
                <div class="col-sm-2 text-center float-right">
                    <img class="brand-logo img-fluid" alt="Chameleon admin logo" src="<?=$logo?>">
                </div>

                <!-- <div class="col-md-10 mt-1"> -->
                    <!-- <div class="form-group">
                        <label for="propmaster">Property</label>                        
                        <select id="propmaster" name="propmaster" class="form-control propmaster">
                        <?php
                            /*echo optionStatus('','-- Select --');
                            foreach ($rows as $row) {
                                $title = $row->propname .'( '.$row->propcodename.' ) - '.title('cities',$row->city,'id','name');
                                $select = (@$_COOKIE['property_id'] == $row->id) ? 'selected' : '';
                                echo optionStatus($row->id,$title,$row->status,$select);
                             }
                        ?>
                        </select>
                    </div>
                <!-- </div> -->
            </div>  */?>
            <div class="row justify-content-between mt-2">
<?php
if (empty(@$_COOKIE['property_id'])) {
    echo "<script> alert_toastr('error','Please select property first than any operation ');</script>";
	die();
}
?>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <h3><?=title('propmaster',get_cookie('property_id'),'id','propname');?></h3>
                </div>
				<div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card ">
                        <div class="card-header bg-hexagons">
                            <h4 class="card-title ">Today's ARR </h4>
                            <div class="heading-elements">
                                <ul class="list-inline d-block mb-0">
                                    <li>
                                        <a class="btn btn-sm btn-danger danger box-shadow-3 round btn-min-width pull-right" href="#">
                                            <span class="white">Average For <?=date('d-F-Y',strtotime($date))?></span>
                                            <i class="ft-bar-chart pl-1 white"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show bg-hexagons">
                            <div class="card-body pt-0 pb-1">
                                <div class="media d-flex">
                                    <div class="align-self-center width-100">
                                        
                                    </div>
                                    <div class="media-body text-right mt-2">
                                        <h3 class=" font-large-1 blue-grey lighten-1 ">₹<?=$TAverage?>
                                        </h3>
                                        <h6 class="mt-1">
										   <span class="text-muted mr-2">Total Sales :
                                                <a href="#" class="darken-2">₹<?=$TSale?></a>
                                            </span>
                                            <span class="text-muted">Occupied Rooms :
                                                <a href="#" class="darken-2"><?=$Troom?></a>
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card ">
                        <div class="card-header bg-hexagons">
                            <h4 class="card-title ">Statistics</h4>
                            <div class="heading-elements">
                                <ul class="list-inline d-block mb-0">
                                    <li>
                                        <a class="btn btn-sm btn-danger danger box-shadow-3 round btn-min-width pull-right" href="#">
                                            <span class="white">Earnings For <?=$_month?></span>
                                            <i class="ft-bar-chart pl-1 white"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show bg-hexagons">
                            <div class="card-body pt-0 pb-1">
                                <div class="media d-flex">
                                    <div class="align-self-center width-100">
                                        
                                    </div>
                                    <div class="media-body text-right mt-2">
                                        <h3 class=" font-large-1 blue-grey lighten-1 ">₹<?=$Tearning?>
                                        </h3>
                                        <h6 class="mt-1">
                                            <span class="text-muted">Bookings :
                                                <a href="#" class="darken-2"><?=$TBoooking?></a>
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12 col-lg-12">
                    <h5 class="card-title text-bold-700 my-2">
                        <?=$monthDateStr?>
                        <a href="#" style="color: white;" onclick="page_content()"><i class="ft-rotate-cw"></i></a>
                        <a class="btn btn-primary btn-sm mr-1" href="<?=base_url('dashboard')?>?content=today">Today</a>
                        <a class="btn btn-primary btn-sm mr-1" href="<?=base_url('dashboard')?>?content=tomorrow">Tomorrow</a>
                        <a class="btn btn-primary btn-sm mr-1" href="<?=base_url('reservations')?>">All Bookings</a>
                    </h5>

                    
                </div>



                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="card pull-up border-top-info border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="Check In Remaining" data-url="<?=base_url()?>reservations/check_in_remaining?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title">TODAYS ARRIVALS</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large text-bold-400"><?=count($check_in_remaining)?><i class="ft-users float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="card pull-up border-top-info border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="Checked In" data-url="<?=base_url()?>reservations/checked_in?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title">INHOUSE GUEST</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large text-bold-400"><?=count($checked_in)?><i class="ft-users float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="card pull-up border-top-info border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="Check Out Remaining" data-url="<?=base_url()?>reservations/check_out_remaining?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title">DEPARTURE</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large text-bold-400"><?=count($check_out_remaining)?><i class="ft-users float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-4 col-lg-3">
                <div class="card pull-up border-top-info border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="Total Bookings" data-url="<?=base_url()?>reservations/total_reservation?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title">BOOKINGS TOTAL</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large text-bold-400 text-primary"><?=count($reservations_total)?><i class="la la-building float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <!-- <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card pull-up border-top-info border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="Checked Out" data-url="<?=base_url()?>checked_out?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title">Checked Out</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large-1 text-bold-400"><?=count($checked_out)?><i class="ft-users float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card pull-up border-top-info border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="Staying" data-url="<?=base_url()?>staying?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title">Staying</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large-1 text-bold-400"><?=count($staying)?><i class="ft-users float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card pull-up border-top-info border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="Upcoming Booking" data-url="<?=base_url()?>upcoming_booking?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title">Upcoming Booking</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large-1 text-bold-400"><?=count($upcoming_booking)?><i class="ft-users float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div> -->

            </div>

            <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="card pull-up border-top-info border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="Cancelled Bookings" data-url="<?=base_url()?>reservations/cancelled_reservation?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title">CANCELLED BOOKINGS</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large text-bold-400"><?=count($cancelled_reservation)?><i class="ft-users float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="card pull-up border-top-danger border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="OCCUPIED" data-url="<?=base_url()?>occupied-property-host?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title text-danger">OCCUPIED ROOMS</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large text-danger text-bold-400"><?=count($occupied)?><i class="la la-building float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="card pull-up border-top-primary border-top-3 rounded-1 cursor-pointer" data-toggle="modal" data-target="#showModal-xl" data-whatever="AVAILABlLE" data-url="<?=base_url()?>availabile-property-host?date=<?=$date?>">
                        <div class="card-header">
                            <h4 class="card-title text-primary">AVAILABlLE ROOMS</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large text-bold-400 text-primary"><?=count($available)?><i class="la la-building float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div>
<!--                    
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <div class="card pull-up border-top-primary border-top-3 rounded-1 cursor-pointer">
                        <div class="card-header">
                            <h4 class="card-title text-primary">BOOKINGS</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body p-1">
                                <h4 class="font-large-1 text-bold-400 text-primary"><?=$todayBookings?><i class="la la-building float-right"></i></h4>
                            </div>
                        </div>
                    </div>
                </div> -->

                
            </div>
            <!--/ eCommerce statistic -->
        </div>






    </div>

<script type="text/javascript">
	
    setTimeout(function() {
        if (!$('body').hasClass('menu-collapsed')) {
            sidebar_hide();
        }
    }, 1000);

    function setCookie(cname, cvalue, exdays) {
      const d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      let expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
      let name = cname + "=";
      let ca = document.cookie.split(';');
      for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    $(document).on('change','.propmaster',function(event) {
       var value = $(this).val();
       setCookie('property_id', value, 365);
       window.location.reload();
       //$('#tb').load('<?=base_url()?>propCalendar/calendar/'+value);
       // $.post('<?=base_url()?>propCalendar/calendar/'+value)
   })
</script>
<script>
	$(document).on('change | keyup',
		`[name="check_in_id[]"], [name="food_amount"], [name="other_amount"], [name="lump_sum_discount"]`,
		function() {
			let _form = $(this).parents('form');
			calculate_grand_total(_form);
		})

        function calculate_grand_total(_form) {
		let room_no = _form.find(`[name="check_in_id[]"]`);
        let pre_checkin_amount=0;
		let grand_total = 0;
        let room_qty =0; 
		$.each(room_no, function() {
			let _this = $(this);
			if (_this.is(':checked')) {
				let _tr = _this.parents('tr');
                let per_room_discount = $(".per_room_discount").val();
				let total_room = parseFloat(_tr.find('.total-room').text());
				grand_total += total_room;
                let pre_checkin_total = parseFloat(_tr.find('.pre_checkin_total').text());
                pre_checkin_amount += pre_checkin_total;
                
                room_qty +=1;
                total_paid = (room_qty*per_room_discount)+pre_checkin_amount;
                
				// console.log(_this.val());
			} else {
				// console.log('not');
			}

		})
       

		setTimeout(() => {
           
			let food_amount = _form.find(`[name="food_amount"]`).val();
			let other_amount = _form.find(`[name="other_amount"]`).val();
			let lump_sum_discount = _form.find(`[name="lump_sum_discount"]`).val();
           
			// let discount = $(`[name="discount_amount"]`).val(finalDiscount);
			food_amount = (food_amount) ? parseInt(food_amount) : 0;
			other_amount = (other_amount) ? parseInt(other_amount) : 0;
			lump_sum_discount = (lump_sum_discount) ? parseInt(lump_sum_discount) : 0;



			grand_total += food_amount;
			grand_total += other_amount;
			grand_total -= lump_sum_discount;

			_form.find(`[name="grand_total"]`).val((grand_total))
            _form.find(`[name="paid_total"]`).val((total_paid))
            _form.find(`[name="balance_total"]`).val((grand_total-total_paid))
			console.log(grand_total);
		}, 1000)
	}
    function validate_lumsum() {
      var firstInputValue = $('.balance_total').val();
      var secondInputValue = $(".lump_sum_discount").val();
      // Perform the validation
      //alert(firstInputValue);
      if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
        $(".lump_sum_discount").val(firstInputValue),
       alert_toastr("error","Sorry lum sum discount amount not greater than balance")
      } else {
        
      }
    }
</script>
