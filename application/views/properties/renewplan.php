<style>
     .gradient-card {
        background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(227,46,250,1) 0%, rgba(76,0,255,1) 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
        }

        /* Custom padding and margin for better appearance */
        .gradient-card-body {
            padding: 10px;
        }
        .gradient-card-footer {
            padding: 10px;
        }
</style> 
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?=$title?></h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?=base_url()?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Property List
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
                                <!-- <h5><a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->propname?>" data-url="<?=base_url()?>properties/plan-details/<?=$row->id?>" title="Details">
                              Current Plan Details
                              </a></h5> -->
                              <h5>All Plan Details</h5>
                            <?php if($isValid==0){
                                     echo '<h4 id="expirationMsg" class="text-danger">Sorry, your plan has been expired. Please renew or upgrade your plan.</h4>';
                                     echo '<script>
                                             setTimeout(function() {
                                                 document.getElementById("expirationMsg").innerHTML = "";
                                             }, 5000); // Hide the message after 5 seconds (adjust as needed)
                                           </script>';
                                }?>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                            <div class="card-content collapse show">
                            <div class="container-fluid ml-5">
                                <div class="row">
                                <?php foreach($user_packages_master as $packages):?>
                                <div class="card gradient-card col-md-3 col-sm-3 col-lg-3 ml-5">
                                    <div class="card-body gradient-card-body">
                                        <h2 class="card-title text-white text-center" style="font-size: 2rem;font-weight:bold"><?=$packages->name?><?php if(@$assign->package_id==$packages->id){?> <i class="la la-check-circle ml-1 " style="color:white;font-size:1.2rem">Current Plan</i> <?php }?></h2>
                                        <p class="text-center"><img src="<?=IMGS_URL.$packages->pic;?>" alt="" height="70px"></p>
                                        <h5 class="card-text text-white text-center">Valitidy : <?=$packages->duration_in_days;?> Days</h5>
                                        <h3 class="card-text text-white text-center">Price : <?=setting()->currency;?><?=$packages->price;?></h3>
                                        <p class="card-text text-white text-center"><?=$packages->description;?> Days</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-3"></div>
                                        <div class="col-6">
                                        <input type="number" placeholder="Enter Rooms" name="room[]" class="form-control">
                                        </div>
                                        <div class="col-3"></div>
                                    </div>
                                   
                                    <input type="hidden" name="" id="enterroom" class="enterroom">
                                    <div class="card-body gradient-card-footer">
                                    <?php if(@$assign->package_id==$packages->id){?>
                                    <center><button id="upgradeplan_<?=$packages->id;?>" onclick="upgradeplan(<?=$packages->id;?>,<?=$packages->max_room;?>)" class="btn btn-success"><b>Renew Plan </b></button></center>
                                    <?php }else{?>
                                        <center><button id="upgradeplan_<?=$packages->id;?>" onclick="upgradeplan(<?=$packages->id;?>,<?=$packages->max_room;?>)" class="btn btn-success"><b>Upgrade</b></button></center>
                                    <?php }?>
                                    </div>
                                     <hr style="border:1px solid white;width:100%">
                                  </div>
                                <?php   endforeach;?>
                                </div>
                               </div>
                            </div> 
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

<script>
      $('body').on('keyup','[name="room[]"]',function(e){
        let _this = $(this);
        _this.each(function(index, element) {
        var secondInputValue = $(element).val();
        $("#enterroom").val(secondInputValue);
    });
    })
 function upgradeplan(plan,max_room){
    var room = $("#enterroom").val();
    let btn = $('#upgradeplan_'+plan);
    let btn_text = btn.text();
    if(room > max_room)
      {
        alert_toastr("error", "Sorry Please enter correct number of rooms");
      }else{
    $.ajax({
    url: '<?=base_url('renew_yoru_plan/'.$row->id)?>',
    type:'POST',
    data:{plan:plan,room:room},
    dataType:"JSON",
    beforeSend: function() {
    btn.attr('disabled', true);
    },
    success:function(res)
    {
        btn.attr('disabled', false);
        if (res.flag === 'package') {
            alert_toastr("error", "You are already one plan extended!");
    }else
     if (res.flag === 'success') {
     alert_toastr("success", "Please wait redirecting to payment gateway.");          
     var obj = JSON.parse(res.data);
     var options = {
     "key": obj.secret_key, 
     "amount": parseFloat(obj.total)*100,
     "currency": "INR",
     "name": "HotelReception",
     "description": "HotelReception online payments",
     //"image": "<?//= IMGS_URL.$shop_detail->logo ?>",
     "account_id": null,
     "order_id": obj.order_id_razor,
     "handler": function (response){
     $.ajax({
     url: "<?=base_url();?>update_payment_status/upgrade_verify_payment",
     method: "POST",
     dataType:"JSON",
     data: {
     razorpay_payment_id : response.razorpay_payment_id,
     razorpay_order_id : response.razorpay_order_id,
     razorpay_signature : response.razorpay_signature,
     order_idrazor : obj.order_id_razor,
     },
     success: function(data)
         {
           if(data == 'true' || data == true)
            {
                $.ajax({
                url: "<?=base_url();?>update_payment_status/upgrade_update_order_status",
                method: "POST",
                data: {
               payment_gateway : 'Razorpay',
               order_id : res.order_id,
               payment_id : response.razorpay_payment_id,
               signature : response.razorpay_signature,
               razorpay_ord_id : response.razorpay_order_id,
			   property_id : res.property_id,
               total : parseFloat(obj.total),
                },
                  success: function(data)
                    {
                      if(data == 'success')
                        {
                          window.location = "<?=base_url();?>thanks";
                           }else{
                            alert_toastr("error", "Status Not Updated");
                            }
                                    },
                                });
                            }else{
                                $.ajax({
                                    url: "<?=base_url();?>update_payment_status/update_order_status_failed",
                                    method: "POST",
                                    data: {
                                          payment_gateway : 'Razorpay',
                                        order_id : res.order_id,
                                        payment_id : response.razorpay_payment_id,
                                        signature : response.razorpay_signature,
                                        razorpay_ord_id : response.razorpay_order_id,
										property_id : res.property_id,
                                        total : parseFloat(obj.total),
                                    },
                                    success: function(data)
                                    {
                                        if(data == 'success')
                                        {
                                            alert_toastr("error", "Payment failed");
                                        }else{
                                            alert('Status Not Updated');
                                        }
                                    },
                                });
                                
                            }
                        },
                    });
                },
                "modal": {
                    "ondismiss": function(){
                        $.ajax({
                                    url: "<?=base_url();?>update_payment_status/update_failed_payment",
                                    method: "POST",
                                    data: {
                                         payment_gateway : 'Razorpay',
                                        order_id : res.order_id,
                                        total : parseFloat(obj.total),
										property_id : res.property_id,
                                    },
                                    success: function(data)
                                    {
                                        if(data == 'success')
                                        {
                                            window.location = "<?=base_url('dashboard');?>";
                                        }else{
                                            alert('Status Not Updated');
                                        }
                                    },
                                });
                    }
                },
                "prefill": {
                    "name": res.user_name,
                    "email": res.user_email,
                    "contact": res.user_mobile
                },
                "notes": {
                    "address": "Razorpay Corporate Office"
                },
                "theme": {
                    "color": "#3399cc"
                }
                    	            };
                    	            var rzp1 = new Razorpay(options);
                    	            rzp1.on('payment.failed', function (response){
                                         toastr.error(response.error.description);
                                          $.ajax({
                                    url: "<?=base_url();?>update_payment_status/update_order_status_failure",
                                    method: "POST",
                                    data: {
                                        payment_gateway : 'Razorpay',
                                        order_id : res.order_id,
                                        payment_id :response.error.metadata.payment_id,
                                        signature : response.error.metadata.signature,
                                        razorpay_ord_id : response.error.metadata.order_id,
										property_id : res.property_id,
                                        total : parseFloat(obj.total),
                                    },
                                    success: function(data)
                                    {
                                        if(data == 'success')
                                        {
                                            window.location = "";
                                        }else{
                                             toastr.error('Status Not Updated');
                                        }
                                    },
                                });
                    // alert(response.error.code);
                    // alert(response.error.description);
                    // alert(response.error.source);
                    // alert(response.error.step);
                    // alert(response.error.reason);
                    // alert(response.error.metadata.order_id);
                    // alert(response.error.metadata.payment_id);
                    	            });
                    	            rzp1.open();
            } else {
                alert_toastr("error",res.msg);
            }
              },
              error: function (response) {
              alert_toastr("error", "Something went wrong. Please try again!");
              btn.attr('disabled', false).text(btn_text);
              }
})
}
return false;
}
</script>
