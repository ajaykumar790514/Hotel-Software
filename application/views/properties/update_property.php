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
                                <a href="<?=base_url()?>properties">Property List</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <?=$title?>
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
                                <h4 class="card-title"><a href="<?=base_url()?>properties" class="btn btn-primary btn-sm"><i class="ft-list"></i>  Properties</a></h4>
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
<style type="text/css">
    .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: -170px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        height: 30px;
            z-index: 1!important;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }
</style>

    <!-- form -->
    <form class="form ajaxsubmit  reload-page update-form" action="<?=base_url()?>properties/save/<?=$row->id?>" method="POST" enctype="multipart/form-data">
        <div class="form-body">
            <h4 class="form-section">
                <i class="la la-building"></i> Property Details</h4>
            <div class="form-group">
                <label for="propname">Property Name*</label>
                <input type="text" id="propname" class="form-control" placeholder="Pproperty Name" name="propname" value="<?=$row->propname?>" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="propcode">Property Code</label>
                        <input type="text" id="propcode" class="form-control" placeholder="Property Code" name="propcode" value="<?=$row->propcode?>" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="propcodename">Property Code Name</label>
                        <input type="text" id="propcodename" class="form-control" placeholder="Property Code Name" name="propcodename" value="<?=$row->propcodename?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contact_preson">Contact Preson</label>
                        <input type="text" id="contact_preson" class="form-control" placeholder="Contact Preson" name="contact_preson" value="<?=$row->contact_preson?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contact_preson_mobile">Contact Preson Mobile</label>
                        <input type="text" id="contact_preson_mobile" class="form-control" placeholder="Contact Preson Mobile" name="contact_preson_mobile" value="<?=$row->contact_preson_mobile?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email_address">Email Address</label>
                        <input type="email" id="email" class="form-control" placeholder="Enter Email Address" name="email" value="<?=$row->email?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="country">Country*</label>
                        <select id="country" name="country" class="form-control" required>
                            <?php
                                echo optionStatus('','-- Select --');
                            foreach ($countries as $crow) {
                                $selected = '';
                                if ($crow->id == $row->country) {
                                    $selected = 'selected';
                                }
                                echo optionStatus($crow->id,$crow->name,1,$selected);
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="state">State*</label>
                        <select id="state" name="state" class="form-control" required>
                            <?=$states?>
                        </select>
                    </div>
                </div>

                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="district">District</label>
                        <select id="district" name="district" class="form-control" required>
                            <?=$district?>
                        </select>
                    </div>
                </div> -->

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="city">City*</label>
                        <select id="city" name="city" class="form-control" required>
                            <?=$cities?>
                        </select>
                    </div>
                </div>
            </div> 

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location_id">Location*</label>
                                <select id="location_id" name="location_id" class="form-control" required>
                                    <?=$locations?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="propcodename">Pincode*</label>
                                <input type="text" class="form-control" placeholder="Pincode" name="pincode" value="<?=$row->pincode?>" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="property_type_id">Property Type*</label>
                                <select id="property_type_id" name="property_type_id" class="form-control" required>
                                    <?php
                                    echo optionStatus('','-- Select --',1);
                                    foreach ($type as $trow) {
                                        $selected = '';
                                        if ($trow->pt_id == $row->property_type_id) {
                                            $selected = 'selected';
                                        }
                                        echo optionStatus($trow->pt_id,$trow->name,$trow->active,$selected);
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">Address*</label>
                        <textarea id="address" rows="6" class="form-control" name="address" placeholder="address" required><?=$row->address?></textarea>
                        
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Document Type</label>
                        <select name="doc_type_id" class="form-control">
                            <?php
                            echo optionStatus('','-- Select --',1);
                            foreach ($document_type as $drow) {
                                $selected = '';
                                if ($drow->id == $row->doc_type_id) {
                                    $selected = 'selected';
                                }
                                echo optionStatus($drow->id,$drow->name,$drow->active,$selected);
                            }
                            ?>
                        </select>
                        
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Document <i class="la la-check-circle text-success d-none document"></i> <?php if($row->document !=''){ ?><a href="<?php echo IMGS_URL.$row->document;?>" target="_blank"><i class="la la-info"></i></a> <?php }?> &nbsp;&nbsp; <span class="text-danger"> ( Maximum file size 100 kb.)</span></label>
                        <input type="file" class="form-control" name="document"  onchange="fileSelected(this)">                        
                        <input type="hidden" class="form-control" name="old_document" value="<?=$row->document?>">
                        <script>
                        function fileSelected(input) {
                        var iconElement = input.previousElementSibling.querySelector('.document');
                        var fileSize = input.files[0].size;
                        var maxSize = 100 * 1024;

                        if (fileSize <= maxSize) {
                            iconElement.classList.remove('d-none');
                        } else {
                            iconElement.classList.add('d-none');
                            input.value = '';
                        }
                    }
                    </script>
                        
                    </div>
                </div>
                
            </div> 
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="checkintime">Check In Time</label>
                        <input type="time" id="checkintime" class="form-control" value="<?=$row->checkintime?>" name="checkintime">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="checkinupto">Check In Upto</label>
                        <input type="time" id="checkinupto" class="form-control" value="<?=$row->checkinupto?>" name="checkinupto">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="checkouttime">Check Out Time</label>
                        <input type="time" id="checkouttime" class="form-control" value="<?=$row->checkouttime?>"  name="checkouttime">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="checkoutupto">Check Out Upto</label>
                        <input type="time" id="checkoutupto" class="form-control" value="<?=$row->checkoutupto?>" name="checkoutupto">
                    </div>
                </div>
            </div>


            <!-- <div class="form-group">
                
                <label for="">Select Location</label>
                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                <div id="map" style="width: auto; height: 400px;"></div>  
            </div> -->

            <div class="row">
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" id="longitude" class="form-control" placeholder="longitude" name="longitude" value="<?=$row->longitude?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" id="latitude" class="form-control" placeholder="latitude" name="latitude" value="<?=$row->latitude?>">
                    </div>
                </div> -->

                <div class="col-md-12">
                    <h3>For Invoice / Bill</h3>
                    <hr>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="latitude">Company Name</label>
                        <input type="text" class="form-control" name="company_name" value="<?=$row->company_name?>" placeholder="Enter Company Name"> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="latitude">Logo <i class="la la-check-circle text-success d-none logo"></i> <?php if($row->logo !=''){?><a href="<?php echo IMGS_URL.$row->logo;?>" target="_blank"><i class="la la-info"></i></a> <?php }?>   &nbsp;&nbsp; <span class="text-danger"> ( Maximum file size 100 kb.)</span></label>
                        <input type="file" class="form-control" name="logo" onchange="fileSelected(this)">
                        <!-- <input type="hidden" class="form-control" name="old_logo" value="<?=$row->logo?>"> -->
                        <script>
                        function fileSelected(input) {
                        var iconElement = input.previousElementSibling.querySelector('.logo');
                        var fileSize = input.files[0].size;
                        var maxSize = 100 * 1024;

                        if (fileSize <= maxSize) {
                            iconElement.classList.remove('d-none');
                        } else {
                            iconElement.classList.add('d-none');
                            input.value = '';
                        }
                    }
                    </script>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="latitude">Bill Start Format</label>
						<input type="text" class="form-control" maxlength="6" name="bill_format" value="<?=$row->bill_format?>" placeholder="Enter Bill Start Format" oninput="validateLength(this)" />

                    </div>
                </div>
                <!-- <div class="col-md-12">
                    <h3>For Business PAN Details</h3>
                    <hr>
                </div> -->

                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label>Type of Ownership</label>
                        <select name="ownership_type" class="form-control">
                            <?php
                            echo optionStatus('','-- Select --',1);
                            foreach ($ownership_type as $ow_row) {
                                $selected = '';
                                if ($ow_row->id == $prop_doc->ownership_type) {
                                    $selected = 'selected';
                                }
                                echo optionStatus($ow_row->id,$ow_row->name,$ow_row->active,$selected);
                            }
                            ?>
                        </select>
                        
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Certificate <i class="la la-check-circle text-success d-none Certificate"></i>  <?php if($prop_doc->certificate !=''){?><a href="<?php echo IMGS_URL.$prop_doc->certificate;?>" target="_blank"><i class="la la-info"></i></a><?php }?>   &nbsp;&nbsp; <span class="text-danger"> ( Maximum file size 100 kb.)</span></label>
                        <input type="file" class="form-control" name="certificate" onchange="fileSelected(this)"> 
                        <input type="hidden" class="form-control" name="old_certificate" value="<?=$prop_doc->certificate?>">
                        <script>
                        function fileSelected(input) {
                        var iconElement = input.previousElementSibling.querySelector('.Certificate');
                        var fileSize = input.files[0].size;
                        var maxSize = 100 * 1024;

                        if (fileSize <= maxSize) {
                            iconElement.classList.remove('d-none');
                        } else {
                            iconElement.classList.add('d-none');
                            input.value = '';
                        }
                    }
                    </script>
                    </div>
                </div> -->

                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label>Enter Name on PAN Card</label>
                        <input type="text" class="form-control" placeholder="Enter Name on PAN Card" name="pan_name" value="<?=$prop_doc->pan_name?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Enter PAN No.</label>
                        <input type="text" class="form-control" placeholder="Enter PAN No." name="pan_no" value="<?=$prop_doc->pan_no?>">
                    </div>
                </div> -->

                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label>Upload PAN Card Image <i class="la la-check-circle text-success d-none PAN"></i> <?php if($prop_doc->pan_card !=''){?><a href="<?php echo IMGS_URL.$prop_doc->pan_card;?>" target="_blank"><i class="la la-info"></i></a><?php }?>   &nbsp;&nbsp; <span class="text-danger"> ( Maximum file size 100 kb.)</span></label>
                        <input type="file" class="form-control" name="pan_photo" onchange="fileSelected(this)">  
                        <input type="hidden" class="form-control" name="old_pan_photo" value="<?=$prop_doc->pan_card?>">
                        <script>
                        function fileSelected(input) {
                        var iconElement = input.previousElementSibling.querySelector('.PAN');
                        var fileSize = input.files[0].size;
                        var maxSize = 100 * 1024;

                        if (fileSize <= maxSize) {
                            iconElement.classList.remove('d-none');
                        } else {
                            iconElement.classList.add('d-none');
                            input.value = '';
                        }
                    }
                    </script>
                    </div>
                </div> -->

                <div class="col-md-12">
                    <h3>For GST & Business Details</h3>
                    <hr>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>GST</label>
                        <select name="is_gst" class="form-control" >
                            <option value="">Select GST</option>
                            <option value="YES" <?=$row->is_gst == 'YES'?'selected':'';?>>YES</option>
                            <option value="NO" <?=$row->is_gst == 'NO'?'selected':'';?>>NO</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 gst-box" style="display:none;">
                    <div class="form-group">
                        <label>GST No.</label>
                        <input type="text" class="form-control" placeholder="Enter GST No." name="gst_no" value="<?=$prop_doc->gst_no?>">
                    </div>
                </div>

                <div class="col-md-4 gst-box" style="display:none;">
                    <div class="form-group">
                        <label>GST Certificate <i class="la la-check-circle text-success d-none GST"></i> <?php if($prop_doc->gst_certificate !=''){?><a href="<?php echo IMGS_URL.$prop_doc->gst_certificate;?>" target="_blank"><i class="la la-info"></i></a><?php }?>   &nbsp;&nbsp; <span class="text-danger"> ( Maximum file size 100 kb.)</span></label>
                        <input type="file" class="form-control" name="gst_certificate" onchange="fileSelected(this)"> 
                        <input type="hidden" class="form-control" name="old_gst_certificate" value="<?=$prop_doc->gst_certificate?>">
                        <script>
                        function fileSelected(input) {
                        var iconElement = input.previousElementSibling.querySelector('.GST');
                        var fileSize = input.files[0].size;
                        var maxSize = 100 * 1024;

                        if (fileSize <= maxSize) {
                            iconElement.classList.remove('d-none');
                        } else {
                            iconElement.classList.add('d-none');
                            input.value = '';
                        }
                    }
                    </script>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-actions text-right">
            <a href="<?=base_url()?>properties" type="reset" class="btn btn-danger mr-1">
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
<!-- END: Content -->




<script type="text/javascript">
    
	function validateLength(input) {
    if (input.value.length > 6) {
        input.value = input.value.slice(0, 6);
    }
}

    $('input[type="file"]').bind('change', function() {
        var fileSizeInBytes=(this.files[0].size);
        //alert(a);
        var fileSizeInKB = fileSizeInBytes / 1024; // Convert bytes to KB
        if(fileSizeInKB > 100) {
            alert_toastr('error','Maximum file size should be 100 KB.');
            $('button[type=submit]').prop('disabled', true);
        }else{
            $('button[type=submit]').prop('disabled', false);
        }
    });
    $('#country').change(function() {
        var id = $(this).val();
        $('#state').load('<?=base_url()?>getStates/'+id);
    })

    $('#state').change(function() {
        var id = $(this).val();
        $('#city').load('<?=base_url()?>getCities/'+id);
        //$('#district').load('<?=base_url()?>getDistrict/'+id);
        load_location();
    })

    $('#city').change(function() {
        load_location();
    })

    function load_location(){
        $('#location_id').html('<option value="" >-- Select --</option>');
        var state =  $('#state').val();
        var city  =  $('#city').val();
        $.post('<?=base_url()?>load_locations',{state:state,city:city})
        .done(function(data){
            
            data = JSON.parse(data);
            console.log(data);
            $('#location_id').html(data.content);
        })
        .fail(function() {
            alert( "error" );
          })

    }

    $(document).ready(function(){
        let value = $('[name=is_gst]').val();
        if (value == 'YES') {
            $('.gst-box').show();
        }else{
            $('.gst-box').hide();
        }
    });

    $(document).on('change', '[name=is_gst]', function(){
        let value = $(this).val();
        if (value == 'YES') {
            $('.gst-box').show();
            $('.gst-box input').prop('required', true);
        }else{
            $('.gst-box').hide();
            // $('.gst-box input').prop('required', false);
        }
    });
    
</script>
<script type="text/javascript">
 var markers = [];

function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 13,
      mapTypeId: 'roadmap'
    });

    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(171, 171),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            var  markers = new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location,
              draggable:true,
             title:"Drag me!"
            });

            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);

            google.maps.event.addListener(markers, 'dragend', function(event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
                $('#latitude').val(lat);
                $('#longitude').val(lng);
            });

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
      map.fitBounds(bounds);
    });
}

$(document).on("keydown", ":input:not(textarea):not(:submit)", function(event) {
    if(event.keyCode == 13) {
      event.preventDefault();
      // alert();
      return false;
    }
});
</script>       
<script src="http://maps.google.com/maps/api/js?key=AIzaSyDIHyFm0c8apzuuVZE4zsFXbGDfXRyPsv4&libraries=places&callback=initAutocomplete"
async defer
></script>
