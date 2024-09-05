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
                                New Property
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
    <form class="form ajaxsubmit reload-page" action="<?=base_url()?>properties/save" method="POST" enctype="multipart/form-data">
        <div class="form-body">
            <h4 class="form-section">
                <i class="la la-building"></i> Property Details</h4>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="propname">Property Name*</label>
                        <input type="text" id="propname" class="form-control" placeholder="Pproperty Name" name="propname" required>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="propcode">Property Code</label>
                        <input type="text" id="propcode" class="form-control" placeholder="Property Code" name="propcode">
                    </div>
                </div> -->

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="propcodename">Property Code Name</label>
                        <input type="text" id="propcodename" class="form-control" placeholder="Property Code Name" name="propcodename">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contact_preson">Contact Person</label>
                        <input type="text" id="contact_preson" class="form-control" placeholder="Contact Person" name="contact_preson">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contact_preson_mobile">Contact Person Mobile</label>
                        <input type="text" id="contact_preson_mobile" class="form-control" placeholder="Contact Person Mobile" name="contact_preson_mobile">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email_address">Email Address</label>
                        <input type="email" id="email_address" class="form-control" placeholder="Enter Email Address" name="email">
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
                            foreach ($countries as $row) {
                                echo optionStatus($row->id,$row->name);
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="state">State*</label>
                        <select id="state" name="state" class="form-control" required>
                            <option value="" >-- Select --</option>
                        </select>
                    </div>
                </div>

<!--
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="district">District</label>
                        <select id="district" name="district" class="form-control" required>
                            <option value="" >-- Select --</option>
                        </select>
                    </div>
                </div>
-->

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="city">City*</label>
                        <select id="city" name="city" class="form-control" required>
                            <option value="" >-- Select --</option>
                            <option value="bangalore">bangalore</option>
                            <option value="Noida">Noida</option>
                            <option value="kanpur">kanpur</option>
                            <option value="Delhli">Delhli</option>
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
                                    <option value="" >-- Select --</option>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="propcodename">Pincode*</label>
                                <input type="text" class="form-control" placeholder="Pincode" name="pincode" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="property_type_id">Property Type*</label>
                                <select id="property_type_id" name="property_type_id" class="form-control" required>
                                    <?php
                                    echo optionStatus('','-- Select --',1);
                                    foreach ($type as $row) {
                                        echo optionStatus($row->pt_id,$row->name,$row->active);
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
                        <textarea id="address" rows="6" class="form-control" name="address" placeholder="address" required></textarea>
                        
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Attach Address Proof Document Type</label>
                        <select name="doc_type_id" class="form-control">
                            <?php
                            echo optionStatus('','-- Select --',1);
                            foreach ($document_type as $row) {
                                echo optionStatus($row->id,$row->name,$row->active);
                            }
                            ?>
                        </select>
                        
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address Proof Document (Image/PDF)</label>
                        <input type="file" class="form-control" name="document">                        
                    </div>
                </div>
                            
            </div> 
                  <div class="row">
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
                        <input type="text" id="longitude" class="form-control" placeholder="longitude" name="longitude">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" id="latitude" class="form-control" placeholder="latitude" name="latitude">
                    </div>
                </div> -->

                <div class="col-md-12">
                    <h3>For Invoice / Bill</h3>
                    <hr>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="latitude">Company Name</label>
                        <input type="text" class="form-control" name="company_name" placeholder="Enter Company Name"> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="latitude">Logo</label>
                        <input type="file" class="form-control" name="logo"> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="latitude">Bill Start Format</label>
                        <input type="text" class="form-control"  maxlength="6"  oninput="validateLength(this)" name="bill_format" placeholder="Enter Bill Start Format"> 
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
                            foreach ($ownership_type as $row) {
                                echo optionStatus($row->id,$row->name,$row->active);
                            }
                            ?>
                        </select>
                        
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>OwnerShip Certificate (Image/PDF)</label>
                        <input type="file" class="form-control" name="certificate"> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Enter Name on PAN Card</label>
                        <input type="text" class="form-control" placeholder="Enter Name on PAN Card" name="pan_name">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Enter PAN No.</label>
                        <input type="text" class="form-control" placeholder="Enter PAN No." name="pan_no">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Upload PAN Card (Image/PDF)</label>
                        <input type="file" class="form-control" name="pan_photo"> 
                    </div>
                </div> -->

                <div class="col-md-12">
                    <h3>For GST & Business Details</h3>
                    <hr>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>GST</label>
                        <select name="is_gst" class="form-control" required>
                            <option value="">Select GST</option>
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                        
                    </div>
                </div>

                <div class="col-md-4 gst-box" style="display:none;">
                    <div class="form-group">
                        <label>GST No.</label>
                        <input type="text" class="form-control" placeholder="Enter GST No." name="gst_no">
                    </div>
                </div>

                <div class="col-md-4 gst-box" style="display:none;">
                    <div class="form-group">
                        <label>GST Certificate (Image/PDF)</label>
                        <input type="file" class="form-control" name="gst_certificate"> 
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
    $('#address').keyup(function(){
        var search = $(this).val();
        $('#pac-input').val(search);
    })

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
        $.post('<?=base_url()?>getLocations',{state:state,city:city})
        .done(function(data){
            
            data = JSON.parse(data);
            console.log(data);
            $('#location_id').html(data.content);
        })
        .fail(function() {
            alert( "error" );
          })

    }    

    $(document).on('change', '[name=is_gst]', function(){
        let value = $(this).val();
        if (value == 'YES') {
            $('.gst-box').show();
            $('.gst-box input').prop('required', true);
        }else{
            $('.gst-box').hide();
            $('.gst-box input').prop('required', false);
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


    // $('#propname').keyup(function(){
    //     var title = $(this).val();
    //     // $.ajax({
    //     //     url: '<?=base_url()?>propcode',
    //     //     data:{title:title},
    //     //     type:'POST',
    //     //     success:function(data){
    //     //         console.log(data);
    //     //     }
    //     // })
    //     $.post('<?=base_url()?>propcode',{title:title})
    //     .done(function(data){
    //         $('#propcode').val(data);
    //     })
    // })


</script>       
<script src="http://maps.google.com/maps/api/js?key=<?=setting()->google_map_key;?>&libraries=places&callback=initAutocomplete"
async defer
></script>
