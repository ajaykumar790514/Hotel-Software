<style type="text/css">
.frmSearch {border: 1px solid #a8d4b1;background-color: #c6f7d0;margin: 2px 0px;padding:40px;border-radius:4px;}
#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;z-index: 999999;max-height: 180px;overflow-y: scroll;}
#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid; }
#country-list li:hover{background:#ece3d2;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}

.reservation__new .form-group {
    margin-bottom: 0.5rem!important;
}
</style>
<!-- <form class="form ajaxsubmit reload-page append" 
	  append-data="#seleted_dates"
	  action="<?=base_url()?>sub_properties/<?=$pro_id?>/reservation/<?=$flat_id?>" 
	  method="POST" 
	  enctype="multipart/form-data" 
	  autocomplete="off" > -->
<div class="row">
	<div class="col-sm-12 text-center ">
		<h3><?=$property->flat_code_name?></h3>
	</div>
</div>
<form  class="form ajaxsubmit load-cal load-receipt reservation__new" 
	  action="<?=base_url()?>reservations/reservation/<?=$pro_id?>/<?=$flat_id?>" 
	  method="POST" 
	  enctype="multipart/form-data" 
	 >
<div class="row">
	<div class="col-md-3">
		<div class="form-group select-date">
            <label for="startDate">Start Date<sup>*</sup></label>
            <input autocomplete="random-value"  type="date" id="startDate" class="form-control start-date" name="startDate" min='<?=date("Y-m-d")?>' f="<?=$flat_id?>" value="<?=$clicked_date?>">
        </div>
	</div>
	<div class="col-md-3">
		<div class="form-group select-date">

            <label for="endDate">End Date<sup>*</sup> </label>
            <input autocomplete="random-value"  type="date" id="endDate" class="form-control end-date" name="endDate" min='<?=date("Y-m-d",strtotime("+ 1 day"))?>' f="<?=$flat_id?>" value="<?=$clicked_date2?>">
        </div>
	</div>

	<div class="col-md-3">
		<div class="form-group select-date">
            <label for="price">Price</label>
            <input autocomplete="random-value"  type="number" id="price" class="form-control" name="price" value="<?=$tmpPrice?>" >
        </div>
	</div>

	<div class="col-md-3">
		<div class="form-group select-date">
            <label  for="price">Total (Service Charges - <?=$service_charges?>)</label>
            <input autocomplete="random-value"  type="number" class="form-control" name="total-price" readonly="" value="<?=$tmpPriceT?>" >
        </div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
           	<label for="mobile">Mobile<sup>*</sup> </label>
			<input   type="number" id="search-box" class="form-control" placeholder="Mobile Number" name="mobile" autocomplete="random-value" disabled >
			<div id="suggesstion-box"></div>
        </div>
	</div>

	

	<div class="col-md-3 float-left">
		<div class="form-group">
           	<label for="booking_type">Room Plan</label>
           	<select autocomplete="random-value"   class="form-control" id="booking_type" name="booking_type">
           		<?php 
				echo optionStatus('','-- Select --',1);
				foreach ($booking_type as $row) {
					echo optionStatus($row->id,$row->type,1);
				}
				?>
           		<!-- <option value="">-- Select --</option>
           		<option value="source 1">Source 1</option>
           		<option value="source 2">Source 2</option> -->
           	</select>
        </div>

		<!-- <div class="form-group mt-2 ">
           	<a class="btn btn-primary send-verification-code" href="">
				<small>Send Verification Code</small>
			</a>
           	<label class="cursor-pointer">
           		<input type="checkbox"  name="skip_verification" checked > Skip Verification
           	</label>
			
        </div> -->
	</div>

	<div class="col-md-4" id="agent-box">
		
	</div>

	<!-- <div class="col-md-3"> -->
		<!-- <div class="form-group">
           	<label for="mobile">Verification Code </label>
			<input autocomplete="random-value"  type="number" id="verification_code" class="form-control" placeholder="Verification Code" name="verification_code" >
        </div> -->
	<!-- </div> -->
	<!-- <div class="col-md-3"></div> -->
	

	<div class="col-md-3">
		<div class="form-group">
           	<label for="name">Name </label>
			<input autocomplete="random-value"  type="text" class="form-control" placeholder="Name" id="cname" name="name" />
        </div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
           	<label for="dob">Date of Birth</label> 
			<input autocomplete="random-value"  type="date" class="form-control" placeholder="Date of Birth" id="cdob" name="dob" max="<?=date('Y-m-d')?>" />
        </div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
           	<label for="gender">Gender </label>
           	<select autocomplete="random-value"  class="form-control" id="cgender" name="gender">
           		<option value="">-- Select --</option>
           		<option value="Male">Male</option>
           		<option value="Female">Female</option>
           	</select>
        </div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
           	<label for="email">Email </label>
			<input autocomplete="random-value"  type="email" class="form-control" id="cemail" placeholder="Email" name="email" />
        </div>
	</div>
<style type="text/css">
	.inc-dec{
		width: 150px;
		text-align: center;
	}
	.input-group-text{
		cursor: pointer;
	}
</style>
	<div class="col-md-12 pl-0 pr-0">
		<div class="col-md-12">
			<label>Guests </label>
		</div>
		
		<div class="col-md-3">
	        <label for="of_adults">Adults <small>Ages 13 or above</small> </label>

	        <div class="input-group mb-1">
			  <div class="input-group-prepend noselect">
			    <span class="input-group-text dec" data-target="#of_adults">&#9866;</span>
			  </div>
			  <input autocomplete="random-value"  type="number" class="form-control inc-dec" id="of_adults" value="1" name="of_adults" readonly="" min="1" max="16">
			  <div class="input-group-append noselect">
			    <span class="input-group-text inc" data-target="#of_adults">&#10010;</span>
			  </div>
			</div>
		</div>
		<div class="col-md-3">
			
	        <label for="of_children">Children <small>Ages 6-12</small> </label>

	        <div class="input-group mb-1">
			  <div class="input-group-prepend noselect">
			    <span class="input-group-text dec" data-target="#of_children">&#9866;</span>
			  </div>
			  <input autocomplete="random-value"  type="number" class="form-control inc-dec" id="of_children" value="0" name="of_children" readonly="" min="0" max="16">
			  <div class="input-group-append noselect">
			    <span class="input-group-text inc" data-target="#of_children">&#10010;</span>
			  </div>
			</div>
		</div>
		<div class="col-md-3">
			<label for="of_infants">Children <small>Under 6 years</small> </label>

	        <div class="input-group mb-1">
			  <div class="input-group-prepend noselect">
			    <span class="input-group-text dec" data-target="#of_infants">&#9866;</span>
			  </div>
			  <input autocomplete="random-value"  type="number" class="form-control inc-dec" id="of_infants" value="0" name="of_infants" readonly="" min="0" max="5">
			  <div class="input-group-append noselect">
			    <span class="input-group-text inc " data-target="#of_infants">&#10010;</span>
			  </div>
			</div>

			
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="is_foreigner">Is Foreigner </label>
	           	<select autocomplete="random-value"  class="form-control" id="is_foreigner" name="is_foreigner">
	           		<option value="0">No</option>
	           		<option value="1">Yes</option>
	           	</select>
	        </div>
		</div>

		

	</div>



	
	<div class="col-md-2">
		<div class="form-group">
			<label for="discount_amount">Discount ₹</label>
           	<input autocomplete="random-value"  type="number" name="discount_amount" id="discount_amount" class="form-control new" placeholder="Discount Amount">
        </div>

	</div>

	<div class="col-md-3">
		<div class="form-group">
			<label for="discount_remark">Discount Remark</label>
           	<input autocomplete="random-value"  type="text" class="form-control" id="discount_remark" placeholder="Discount Remark" name="discount_remark">
        </div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
			<label for="discount_remark">Advanced</label>
           	<input type="number" class="form-control" placeholder="Advanced" name="advanced" oninput="validateInputs()">
        </div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label for="booking_remark">Booking Remark</label>
           	<input autocomplete="random-value"  type="text" class="form-control" id="booking_remark" placeholder="Booking Remark" name="booking_remark">
        </div>
	</div>
	<!-- <div class="col-md-3"></div> -->

	

	<div class="col-md-3">
		<div class="form-group">
			<label for="discount_amount">Payment Mode <sup>*</sup></label>
			<select autocomplete="random-value"  name="payment_mode" id="payment_mode" class="form-control payment_mode">
				<?php 
				echo optionStatus('','-- Select --',1);
				foreach ($payment_mode as $row) {
					echo optionStatus($row->id,$row->mode,1);
				}
				?>
			</select>
        </div>

	</div>

	

	<div class="col-md-4 reference_id d-none">
		<div class="form-group">
			<label for="reference_id">Reference Id</label>
           	<input autocomplete="random-value"  type="text" class="form-control" id="reference_id" placeholder="Reference Id" name="reference_id">
        </div>
	</div>


	
	
    
	<div class="col-md-12">
		<div class="form-actions d-flex justify-content-end">
			<button autocomplete="random-value"  type="submit" class="btn btn-primary btn-sm mr-1">
                <i class="ft-check"></i> Save
            </button>
            
            <button type="reset" data-dismiss="modal" class="btn btn-danger btn-sm mr-1">
                <i class="ft-x"></i> Cancel
            </button>
            
        </div>
	</div>

	
	
</div>
</form>

<style type="text/css">
	#usersList{
		max-height: 130px;
	    overflow-y: scroll;
	    width: max-content;
	    padding: 6px;
	}
	.select2-container{
		width: 100% !important;
	}
</style>
<script type="text/javascript">
	$(document).on('submit','.discount',function(event) {
		alert($('.select-date .start-date').val());
	})

	setTimeout(function() {
		$('[disabled]').prop('disabled',false);
	}, 100);

	$(document).on('input','#search-box',function(){
		// alert($(this).val().length);
		var t = $(this);
		if (t.val().length == 5) {

			var orgVal = t.val();
			t.val(orgVal + ' ' + orgVal);
			setTimeout(function() {
				t.val(orgVal);
			}, 10);
			
		}
	})

	$(document).on('change','#booking_type',function() {
		let value = $(this).val();
		if (value == 4) {
			$("#agent-box").load('<?=base_url()?>reservations/load_agent');
		}else{
			$("#agent-box").html('');
		}
		//alert($(this).val());
	})

	$(document).ready(function() {
	    $('#agent').select2();
	});

	$(document).on('keyup', '[name=price]', function(){
		$('[name=total-price]').val($(this).val());
		$('[name=discount_amount]').val('');
	});
</script>

<!-- <script type="text/javascript">
	$(document).on('change','.select-date .start-date,.select-date .end-date',function(event) {
		var url = '<?=base_url()?>check-availability-price/<?=$flat_id?>';
		var start_date = $('.select-date .start-date').val();
		var end_date   = $('.select-date .end-date').val();
		var data = {start_date:start_date,end_date:end_date};
		$.post(url,data,function(resData) {
			var resData = JSON.parse(resData);
			if (resData.res=='success') {
				$('input[name="price"]').val(resData.price);
			}
			else{
				$('input[name="price"]').val('');
				alert_toastr(resData.res,resData.msg);
			}
		})
		// alert();
		// get_price();
	})
</script> -->

