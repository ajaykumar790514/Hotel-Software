<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?= $title ?></h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url() ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <?= $title ?> List
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Base style table -->
            <section id="base-style">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">

                                </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content" id="addNew">
                                <div class="card-body">
                                    <!-- form -->
                                    <!-- <form class="form ajaxsubmit reload-tb" action="<?= base_url() ?>reviews_source/save" method="POST" enctype="multipart/form-data"> -->
                                    <div class="form-body">
                                        <h4 class="form-section">
                                            <i class="la la-building"></i><?= $title ?>
                                        </h4>
                                        <div class="row">

                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="propmaster">Property</label>
                                                    <select id="propmaster" name="propmaster" class="form-control propmaster">
                                                        <?php
                                                        echo optionStatus('', '-- Select --');
                                                        foreach ($rows as $row) {
                                                            $title = $row->propname . '( ' . $row->propcodename . ' ) - ' . title('cities', $row->city, 'id', 'name');
                                                            echo optionStatus($row->id, $title);
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 text-center">
                                                <div class="form-group">
                                                    <label><br></label><br>
                                                    <button type="button" data-toggle="modal" data-target="#showModal-xl" data-whatever="Booking" data-url="<?= base_url('reservation_new_form') ?>" class="btn btn-primary prop_reservation">
                                                       New Booking
                                                    </button>
                                                </div>


                                            </div>

                                            <!-- <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="sub_property_types">Room Type</label>
                                                        <select id="sub_property_types" name="sub_property_types" class="form-control sub_property_types">
                                                        <?php
                                                        echo optionStatus('', '-- Select --');
                                                        foreach ($sub_property_types as $row) {
                                                            echo optionStatus($row->spt_id, $row->name, $row->active);
                                                        }
                                                        ?>
                                                        </select>
                                                    </div>
                                                </div> -->

                                        </div>
                                    </div>
                                    <!-- </form> -->
                                    <!-- End: form -->
                                    <hr>
                                </div>
                            </div>
                            <style type="text/css">
                                td {
                                    vertical-align: middle !important;
                                }
                            </style>
                            <div class="card-content collapse show" id="tb">


                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Base style table -->
        </div>
    </div>
</div>
<!-- END: Content-->
<script type="text/javascript">
    $(document).ready(function(){
        if('<?=$cookie_property_id?>'){
            $('.propmaster').val(<?=$cookie_property_id?>).change();
        }
    })

    $(document).on('change', '.propmaster', function(event) {
        var value = $(this).val();
        $('.prop_reservation').data('url', '<?= base_url() ?>reservations/reservation_new_form/' + value)
        $('#tb').load('<?= base_url() ?>propCalendar/calendar/' + value);
    })


    $('body').on('change | keyup ', `[name="startDate"]`, function(e) {
        let _this = $(this);
        let _form = _this.parents('form');
        _form.find(`[name="endDate"]`).attr('min', _this.val())
        count_nights(_this);
    });
    $('body').on('change | keyup', `[name="endDate"]`, function(e) {
        let _this = $(this);
        let _form = _this.parents('form');
        let startDate = _form.find(`[name="startDate"]`).val();
        // _form.find(`[name="endDate"]`).attr('min', _this.val())
        if (!startDate) {
            alert_toastr('error', 'Select start date!');
            _this.val('');
        }
        count_nights(_this);
    });

    function count_nights(_this) {
        let _form = _this.parents('form');
        let startDate = _form.find(`[name="startDate"]`).val();
        let endDate = _form.find(`[name="endDate"]`).val();
        if (startDate && endDate) {
            $.ajax({
                url: `${BASE_URL}reservations/count_nights`,
                data: {
                    startDate,
                    endDate
                },
                type: 'POST',
                success: function(data) {
                    _form.find(`[name="nights"]`).val(data);
                    calculate_amount();
                }

            })
        } else {
            alert_toastr('error', 'Select start date and end date!');
            // _this.val('');
        }

    }
	

    $(document).on('change', '#booking_from', function() {
        let value = $(this).val();
        if (value == 4) {
            $("#agent-box").load(`${BASE_URL}reservations/load_agent`, function() {
                setTimeout(() => {
                    $('#agent').select2();
                }, 1000)
            });
        } else {
            $("#agent-box").html('');
        }
    })

    $('body').on('click', '.add-room', function(e) {
        $('.rooms_tb>tbody').append(`<tr>${rooms_row}</tr>`);
    })

    $('body').on('click', '.remove-room', function(e) {
        $(this).parents('tr').remove();
        calculate_amount();
    })

    $('body').on('keyup', `[name="discount_amount"]`, function(e) {
        calculate_amount();
    })

    $('body').on('change | keyup', `[name="room_type[]"] , [name="quantity[]"]`, function(e) {
        let _this = $(this);
        let _row = _this.parents('tr');
        let _form = _this.parents('form');
        let room_type = _row.find(`[name="room_type[]"]`).val();
        let pro_id = _form.find(`[name="propmaster"]`).val();
        let qty = _row.find(`[name="quantity[]"]`).val();
        let startDate = _form.find(`[name="startDate"]`).val();
        let endDate = _form.find(`[name="endDate"]`).val();
        let currency = "<?=setting()->currency;?>";
        var check = 1;
        let booking_type = $("#booking_type").val();
        if (!startDate || !endDate) {
            alert_toastr('error', 'Select start date and end date!');
            _row.find(`[name="room_type[]"]`).val('');
            return false;
        }

        if (_this.attr('name') == "room_type[]") {
            $.each(_form.find(`[name="room_type[]"]`).not(_this), function() {
                if ($(this).val() == room_type) {
                    check = 0;
                }
            })
        }


        setTimeout(() => {

            if (check == 1) {
                $.ajax({
                    url: `${BASE_URL}reservations/check_availability`,
                    data: {
                        room_type,
                        pro_id,
                        startDate,
                        endDate,
                    },
                    type: 'POST',
                    success: function(data) {
                       // alert(data);
                        // console.log({data,qty});
                        if (data && (data - qty) >= 0) {
                            _row.find('.available_rooms').text(data);
                            $.ajax({
                                url: `${BASE_URL}reservations/get_price`,
                                data: {
                                    room_type,
                                    pro_id,
                                    qty,
                                    startDate,
                                     endDate,
                                     booking_type:booking_type
                                },
                                type: 'POST',
                                'dataType':'JSON',
                                success: function(data) {
                                    console.log(data);
                                    if (data) {
                                        extra_bedding_price = (data.extra_bedding_price ? data.extra_bedding_price : 'N/A') ;
                                       // alert(qty);
                                        // if(!qty){
                                            // _row.find(`[name="quantity[]"]`).val(1);
                                            _row.find(`[name="quantity[]"]`).val(data.qty);
                                        // }
                                        _form.find(`[name="startDate"]`).attr('readonly');
                                        _form.find(`[name="endDate"]`).attr('readonly');
                                        _row.find('.room_price').text(data.daily_price);
                                        _row.find('.extra_bedding_price').text(extra_bedding_price);
                                        _row.find('.capacity').text(data.capacity);
                                        _row.find(`[name="amount[]"]`).val(data.daily_price);
                                        _row.find(`[name="taxAmount[]"]`).val(data.taxAmount*data.qty);
										_row.find(`[name="taxRate[]"]`).val(data.taxRate);
                                        _row.find(`[name="totalAmount[]"]`).val(data.totalAmount);
										if(data.inventory_yes=='YES'){
										$("#inventory_label").html('<label class="text-danger">( Property Inventory Price Included )</label>');
										}
                                        calculate_amount();
                                    } else {
                                        alert_toastr('error', 'Price not available!');
                                        reset_room_row(_row);
                                        calculate_amount();
                                        return false;
                                    }
                                }
                            })
                        } else {
                            _row.find('.available_rooms').text('');
                            alert_toastr('error', 'Room Not available!');
                            // _row.find('[name="quantity[]"]').val(data).change();
                            reset_room_row(_row);
                            calculate_amount();
                            return false;
                        }
                    }

                })


            } else {
                alert_toastr('error', 'Room type already selected!');
                _row.find(`[name="room_type[]"]`).val('');
                reset_room_row(_row);
            }

        }, 1000);
    })

    $('body').on('keyup','[name="extra_bedding[]"]',function(e){
        let _this = $(this);
        let _row = _this.parents('tr');
        let _form = _this.parents('form');
        if(_this.val() > 10){ _this.val(10) }
        calculate_amount();
    })

    $('body').on('keyup','[name="discount[]"]',function(e){
        let _this = $(this);
        let discount = _this.val();
        let _row = _this.parents('tr');
        let _form = _this.parents('form');
        let price = parseInt(_row.find('.room_price').text());
        if(_this.val() >price ){ _this.val(price) }
        calculate_amount();
    })


    function room_duplicate_type() {
        return 'test';
    }
	function calculate_amount() {
    let rooms = $(`[name="room_type[]"]`);
    let nights = parseInt($(`[name="nights"]`).val());
    let totalAmount = 0;
    let finalDiscount = 0;
    let totalTax = 0;
	let extra_bedding_amt=0;
	let ExtraAmt=0;

    $.each(rooms, function() {
        var _this = $(this);
        let _row = _this.parents('tr');
        if (_this.val()) {
            let price = parseInt(_row.find('.room_price').text());
            let extra_bedding_price = parseInt(_row.find('.extra_bedding_price').text());
            let qty = _row.find(`[name="quantity[]"]`).val();
            let extra_bedding = _row.find(`[name="extra_bedding[]"]`).val();
            let discount = parseInt(_row.find(`[name="discount[]"]`).val());
            var taxable_price = price-discount;
			var total_discount = 0;
                if(discount){
                    total_discount = discount * qty * nights;
                }
                _row.find(`[name="total_discount[]"]`).val(total_discount);
                let total = price * qty;
                if(extra_bedding_price && extra_bedding>0){
                    extra_bedding_amt = (extra_bedding_price * extra_bedding) * nights;
					ExtraAmt = (extra_bedding_amt * 12)/100;
                }
				var FlatTotal = total * nights;
                if(discount){
                    finalDiscount = parseInt(finalDiscount) + total_discount;
					console.log(total_discount);
                    FlatTotal = FlatTotal - total_discount;
                }

                find_taxRate(taxable_price).then(taxRate => {
                let tax_Amount = (FlatTotal * taxRate) / 100;
				tax_Amount = tax_Amount+ExtraAmt;
				_row.find(`[name="taxRate[]"]`).val(taxRate);
                _row.find(`[name="amount[]"]`).val(FlatTotal+extra_bedding_amt);
                _row.find(`[name="totalAmount[]"]`).val((FlatTotal+extra_bedding_amt + tax_Amount));
                _row.find(`[name="taxAmount[]"]`).val(tax_Amount);

                totalAmount += parseInt(_row.find(`[name="amount[]"]`).val());
                totalTax += parseInt(_row.find(`[name="taxAmount[]"]`).val());

                updateTotals(totalAmount, totalTax, finalDiscount);
            });
        }
    });
	setTimeout(() => {
            let discount = $(`[name="discount_amount"]`).val(finalDiscount);
        }, 1000)
}

function reset_room_row(_row) {
    _row.find('input').val('');
    _row.find('.room_txt').text('');
}

function find_taxRate(amount) {
    return new Promise((resolve, reject) => {
        if (amount) {
            $.ajax({
                url: `${BASE_URL}reservations/find_taxRate`,
                data: { amount },
                type: 'POST',
                success: function(data) {
                    // console.log(amount + '-' + data);
                    resolve(parseFloat(data)); // Return the parsed tax rate
                },
                error: function() {
                    reject('Error fetching tax rate');
                }
            });
        } else {
            reject('Invalid amount');
        }
    });
}

function updateTotals(totalAmount, totalTax, finalDiscount) {
	let Ttotal = totalAmount ;
    $('.total_amount').text(Ttotal || 0);
    $('.tax_amount').text(totalTax || 0);
    $('.sub_total_amount').text((Ttotal + totalTax) || 0);
    $('.sub_total_amount_val').val((Ttotal + totalTax) || 0);
    $("#total_amount").val(Ttotal);
}


    // function calculate_amount() {
    //     let rooms = $(`[name="room_type[]"]`);
    //     let nights = parseInt($(`[name="nights`).val());
    //     let advanced = $(`[name="room_type"]`);
    //     let currency = "<?=setting()->currency;?>";
    //     let totalAmount = 0;
    //     let finalDiscount = 0;
    //     let totalTax = 0;
    //     $.each(rooms, function() {
    //         var _this = $(this);
    //         let _row = _this.parents('tr');
    //         if (_this.val()) {
	// 			var taxRate = parseInt(_row.find(`[name="taxRate[]"]`).val());
    //             var amount = parseInt(_row.find(`[name="amount[]"]`).val());
    //             var price = parseInt(_row.find('.room_price').text());
    //             var extra_bedding_price = parseInt(_row.find('.extra_bedding_price').text());
    //             var qty = _row.find(`[name="quantity[]"]`).val();
    //             var extra_bedding = _row.find(`[name="extra_bedding[]"]`).val();
    //             var discount = parseInt(_row.find(`[name="discount[]"]`).val());
    //             // var tax_Amount = parseInt(_row.find(`[name="taxAmount[]"]`).val());
    //             var total_discount = 0;
    //             if(discount){
    //                 total_discount = discount * qty;
    //             }
    //             _row.find(`[name="total_discount[]"]`).val(total_discount);
    //             let total = price * qty;
    //             if(extra_bedding_price && qty){
    //                 total = total + (extra_bedding_price * extra_bedding);
    //             }
    //             if(discount){
    //                 finalDiscount = parseInt(finalDiscount) + total_discount;
    //                 total = total - total_discount;
    //             }
	// 			var TxnAmount = find_taxRate(total * nights);
	// 			if(TxnAmount){
	// 			taxRate = TxnAmount;
	// 			}
	// 			var tax_Amount = (total * taxRate)/100;
	// 			console.log(tax_Amount);
	// 			_row.find(`[name="amount[]"]`).val(total * nights);
    //             _row.find(`[name="totalAmount[]"]`).val((total+tax_Amount) * nights);
	// 			_row.find(`[name="taxAmount[]"]`).val(tax_Amount * nights);
    //             console.log({
    //                 price,
    //                 qty
    //             });
    //             totalAmount = parseInt(totalAmount) + parseInt(_row.find(`[name="amount[]"]`).val());
    //             totalTax = parseInt(totalTax) + parseInt(_row.find(`[name="taxAmount[]"]`).val());
    //         }
    //     })

      
    //     setTimeout(() => {
    //         let discount = $(`[name="discount_amount"]`).val(finalDiscount);
    //         let inventory_price = $('.inventory').val();
    //           Ttotal = totalAmount * nights+Number(inventory_price);
	// 		$('.total_amount').text(Ttotal || 0);
    //         $('.tax_amount').text(totalTax  || 0);
    //         $('.sub_total_amount').text((Ttotal+totalTax)  || 0);
	// 		$('.sub_total_amount_val').val((Ttotal+totalTax) || 0);
    //     }, 1000)
    //     let inventory_price = $('.inventory').val();
    //     $("#total_amount").val((totalAmount * nights)+Number(inventory_price));
    // }

    // function reset_room_row(_row) {
    //     _row.find('input').val('');
    //     _row.find('.room_txt').text('');
    // }
	// function find_taxRate(amount) {
    //     if (amount) {
    //         $.ajax({
    //             url: `${BASE_URL}reservation/find_taxRate`,
    //             data: {
    //                 amount,
    //             },
    //             type: 'POST',
    //             success: function(data) {
	// 				console.log(amount+'-'+data);
	// 				return data;
    //             }

    //         })
    //     } else {
    //         alert_toastr('error', 'Select start date and end date!');
    //         // _this.val('');
    //     }

    // }
    // $(document).ready(function() {

    // });
</script>
<script>
    function validateInputs() {
      var firstInputValue = $('.sub_total_amount_val').val();
      var secondInputValue = $("#advanced").val();
      // Perform the validation
      if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
        $("#advanced").val(firstInputValue),
       alert_toastr("error","Sorry advance value not greater than total")
      } else {
        
      }
    }
  </script>
  <script type="text/javascript">
	$(document).on('click','.checkout-open',function(event) {
		// $('.checkin').toggle();
		$('.reservation-checked-in-list').hide();
	})
	$(document).on('click','.checkout-close',function(event) {
		$('.checkout').html('');
		$('.reservation-checked-in-list').show();
	})
</script>
