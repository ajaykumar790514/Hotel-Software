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
                            <li class="breadcrumb-item">
                                <a href="<?=base_url()?>sub_properties/<?=$propertyrow->id?>"> <?=$propertyrow->propname?></a>
                            </li>
                            <li class="breadcrumb-item active">
                                New Rooms
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><a href="<?=base_url()?>sub_properties/<?=$propertyrow->id?>" class="btn btn-primary btn-sm"><i class="ft-list"></i>  Rooms ( <?=$propertyrow->propname?> )</a></h4>
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse">
                                                <i class="ft-minus"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-action="reload">
                                                <i class="ft-rotate-cw"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-action="expand">
                                                <i class="ft-maximize"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-action="close">
                                                <i class="ft-x"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="card-text">
                                        <p>...........</p>
                                    </div>
    <!-- form -->
    <form class="form ajaxsubmit reload-page" action="<?=base_url()?>sub_properties/<?=$propertyrow->id?>/save" method="POST" enctype="multipart/form-data">
        <div class="form-body">
            <h4 class="form-section">
                <i class="la la-building"></i> Rooms Details</h4>
            <div class="row">
            <div class="col-md-6">
            <div class="form-group">
                <label for="flat_name">Sub Property / Room Name*</label>
                <input type="text" id="flat_name" class="form-control" placeholder="Room Name" name="flat_name" required>
            </div>
            </div>
             <div class="col-md-6">
                    <div class="form-group">
                        <label for="units">Units (No of same sub properties)*</label>
                        <input type="number" id="units" class="form-control" placeholder="units" name="units" required>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                    <div class="form-group">
                        <label for="flat_no">Sub Property / Room No.</label>
                        <input type="text" id="flat_no" class="form-control" placeholder="Room No." name="flat_no">
                    </div>
                </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="sub_property_type_id">Room Category *</label>
                        <select id="sub_property_type_id" name="sub_property_type_id" class="form-control" required>
                            <?php
                            echo optionStatus('','-- Select --',1);
                            foreach ($type as $row) {
                                echo optionStatus($row->spt_id,$row->name,$row->active);
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button class="btn btn-primary mt-2" type="button" data-toggle="modal" data-target="#exampleModal"> Add  Room Category</button>
                    </div>
                </div>
           
               
            </div>

<!--
            <div class="row">
                 <div class="col-md-4">
                    <div class="form-group">
                        <label for="units">Units (No of same sub properties)</label>
                        <input type="number" id="units" class="form-control" placeholder="units" name="units" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sharing">Sharing</label>
                        <select id="sharing" class="form-control" name="sharing"> 
                            <?php
                            echo optionStatus('','-- Select --');
                            echo optionStatus('0','0',1);
                            echo optionStatus('1','1',1);
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="display">Display</label>
                        <select id="display" class="form-control" name="display"> 
                            <?php
                            echo optionStatus('','-- Select --');
                            echo optionStatus('0','0',1);
                            echo optionStatus('1','1',1);
                            ?>
                        </select>  
                    </div>
                </div>
            </div>
-->

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_preson">Contact Preson</label>
                        <input type="text" id="contact_preson" class="form-control" placeholder="Contact Preson" name="contact_preson" value="<?=$propertyrow->contact_preson?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_preson_mobile">Contact Preson Mobile</label>
                        <input type="text" id="contact_preson_mobile" class="form-control" placeholder="Contact Preson Mobile" name="contact_preson_mobile" value="<?=$propertyrow->contact_preson_mobile?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="managername">Manager Name</label>
                        <input type="text" id="managername" class="form-control" placeholder="Manager Name" name="managername">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="manager_mobile">Manager Mobile</label>
                        <input type="number" id="manager_mobile" class="form-control" placeholder="Manager Mobile" name="manager_mobile">
                    </div>
                </div>
            </div>

<!--
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hostname">Host Name</label>
                        <input type="text" id="hostname" class="form-control" placeholder="Host Name" name="hostname">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hostmobile">Host Mobile</label>
                        <input type="text" id="hostmobile" class="form-control" placeholder="Host Mobile" name="hostmobile">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hostemail">Host Email</label>
                        <input type="text" id="hostemail" class="form-control" placeholder="Host Email" name="hostemail">
                    </div>
                </div>
            </div>
-->

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="daily_price">EP Price*</label>
                        <input type="number" id="daily_price" class="form-control" placeholder="EP Price" name="daily_price" required>
                    </div>
                </div>
				
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cp_price">CP Price</label>
                        <input type="number" id="cp_price" class="form-control" placeholder="CP Price" name="cp_price">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="map_price">MAP Price</label>
                        <input type="number" id="map_price" class="form-control" placeholder="MAP Price" name="map_price">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="ap_price">AP Price</label>
                        <input type="number" id="ap_price" class="form-control" placeholder="AP Price" name="ap_price">
                    </div>
                </div>

                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="weekly_price">Weekly Price</label>
                        <input type="number" id="weekly_price" class="form-control" placeholder="Weekly Price" name="weekly_price">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="monthly_price">Monthly Price</label>
                        <input type="number" id="monthly_price" class="form-control" placeholder="Monthly Price" name="monthly_price">
                    </div>
                </div> -->

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="ep_extra_bedding_price">EP Extra Bedding Price</label>
                        <input type="number" id="ep_extra_bedding_price" class="form-control" placeholder="Extra Bedding Price" name="ep_extra_bedding_price">
                    </div>
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label for="cp_extra_bedding_price">CP Extra Bedding Price</label>
                        <input type="number" id="cp_extra_bedding_price" class="form-control" placeholder="Extra Bedding Price" name="cp_extra_bedding_price">
                    </div>
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label for="map_extra_bedding_price">MAP Extra Bedding Price</label>
                        <input type="number" id="map_extra_bedding_price" class="form-control" placeholder="Extra Bedding Price" name="map_extra_bedding_price">
                    </div>
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label for="ap_extra_bedding_price">AP Extra Bedding Price</label>
                        <input type="number" id="ap_extra_bedding_price" class="form-control" placeholder="Extra Bedding Price" name="ap_extra_bedding_price">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="Property Description">Property Description</label>
                        <textarea id="property_description" rows="5" class="form-control" name="Property Description" placeholder="Property Description"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="wifi">Wifi</label>
                        <input type="text" id="wifi" class="form-control" placeholder="Wifi" name="wifi">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" id="password" class="form-control" placeholder="Password" name="password">
                    </div>
                </div>
            </div>


            <!-- <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="checkintime">Check In Time</label>
                        <input type="time" id="checkintime" class="form-control" placeholder="Check In Time" name="checkintime">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="checkinupto">Check In Upto</label>
                        <input type="time" id="checkinupto" class="form-control" placeholder="Check In Upto" name="checkinupto">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="checkouttime">Check Out Time</label>
                        <input type="time" id="checkouttime" class="form-control" placeholder="Check Out Time" name="checkouttime">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="checkoutupto">Check Out Upto</label>
                        <input type="time" id="checkoutupto" class="form-control" placeholder="Check Out Upto" name="checkoutupto">
                    </div>
                </div>
            </div> -->

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="capacity">Capacity* (In Numbers)</label>
                        <input type="number" id="capacity" class="form-control" placeholder="Capacity" name="capacity" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="max_guest">Max Guest (In Numbers)</label>
                        <input type="number" id="max_guest" class="form-control" placeholder="Max Guest" name="max_guest">
                    </div>
                </div>

<!--
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lockinperiod">Lock In Period</label>
                        <input type="text" id="lockinperiod" class="form-control" placeholder="Lock In Period" name="lockinperiod">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="noticeperiod">Notice Period</label>
                        <input type="text" id="noticeperiod" class="form-control" placeholder="Notice Period" name="noticeperiod">
                    </div>
                </div>
-->
            </div>

<!--
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="deposit">Deposit</label>
                        <input type="number" id="deposit" name="Deposit" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sub_property_type_id">Property Type</label>
                        <select id="sub_property_type_id" name="sub_property_type_id" class="form-control" required>
                            <?php
                            echo optionStatus('','-- Select --',1);
                            foreach ($type as $row) {
                                echo optionStatus($row->spt_id,$row->name,$row->active);
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div> 
-->

<!--
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sub_property_config">Property Config</label>
                        <textarea id="sub_property_config" rows="6" class="form-control" name="sub_property_config" placeholder="Property Config"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sub_property_config_details">Property Config Details</label>
                        <textarea id="sub_property_config_details" rows="6" class="form-control" name="sub_property_config_details" placeholder="Property Config Details"></textarea>
                    </div>
                </div>
            </div>
-->

<!--
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="guest_access">Guest Access</label>
                        <textarea id="guest_access" rows="6" class="form-control" name="guest_access" placeholder="Guest Access"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="other_things_to_note">Other Things To Note</label>
                        <textarea id="other_things_to_note" rows="6" class="form-control" name="other_things_to_note" placeholder="Other Things To Note"></textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="how_to_reach">How To Reach</label>
                        <textarea id="how_to_reach" rows="6" class="form-control" name="how_to_reach" placeholder="How To Reach"></textarea>
                    </div>
                </div>
            </div> 
-->

          


        </div>

        <div class="form-actions text-right">
            <a href="<?=base_url();?>sub_properties/<?=$propertyrow->id?>" type="reset" class="btn btn-danger mr-1">
                <i class="ft-x"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary mr-1">
                <i class="ft-check"></i> Save
            </button>
        </div>
    </form>
    <!-- End: form -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Basic form layout section end -->
        </div>

    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h5>Add Room Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <div class="form-body">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group col-md-12">
                            <label class="control-label">Room Category Name:</label>
                            <input type="text" class="subname form-control" id="subname" placeholder="Enter room category name"  required >                        
                            </div>
                        </div>
                    </div>
                </div>
               </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="add_subPro_type()">Add</button>
                    </div>
                    </div>
                </div>
                </div>
<!-- END: Content -->
<script>
       $("#agent-box").load(`${BASE_URL}reservations/load_agent`, function() {
                setTimeout(() => {
                    $('#agent').select2();
                }, 1000)
            });
    function add_subPro_type()
    {
       var name  = $("#subname").val();
       
       $.ajax({
                url:"<?=base_url()?>sub_properties_types/<?=$propertyrow->id?>/save",
                type:"POST",
                data:{name:name},
                success: function(data) {
                    console.log(data);
                    data = JSON.parse(data);

                    if (data.res == 'success') {
                        window.location.reload();
                    }
                    alert_toastr(data.res, data.msg);
                }
            })
    }
</script>
          