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
                                <a href="<?=$back_url?>">Location Master</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Create / Update
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
                                <h4 class="card-title"><a href="<?=$back_url?>" class="btn btn-primary btn-sm"><i class="ft-list"></i> Locations</a></h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                
                            </div>
                           
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
<!-- form -->
<form class="form ajaxsubmit <?=$form_class?>" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group">
            <label for="longitude">State</label>
            <select class="form-control" name="state_id" id="state">
                <?=(@$states) ? $states : '' ?>
            </select>
            
        </div>

        <div class="form-group">
            <label for="longitude">City</label>
            <select class="form-control" name="cityid" id="city">
                <?=(@$cities) ? $cities : '' ?>
            </select>
            
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" class="form-control" placeholder="Name" name="name" value="<?=(@$row->name) ? $row->name : '' ?>">
        </div>

        <div class="form-group">
            <label for="loc_name">Location name</label>
            <input type="text" id="loc_name" class="form-control" placeholder="Location name" name="loc_name" value="<?=(@$row->loc_name) ? $row->loc_name : '' ?>">
        </div>

        <div class="form-group">
            <label for="desc">Description</label>
            <textarea id="desc" class="form-control" placeholder="Description" name="desc" ><?=(@$row->desc) ? $row->desc : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" id="code" class="form-control" placeholder="Code" name="code" value="<?=(@$row->code) ? $row->code : '' ?>">
        </div>

        <div class="form-group">
            <label for="">Search Location ( for longitude & latitude)</label>
            <input id="pac-input" class="controls" type="text" placeholder="Search Location">
            <div id="map" style="width: auto; height: 400px;"></div>  
        </div>

        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" id="longitude" class="form-control" placeholder="Longitude" name="longitude" value="<?=(@$row->longitude) ? $row->longitude : '' ?>" readonly>
        </div>

        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" id="latitude" class="form-control" placeholder="Latitude" name="latitude" value="<?=(@$row->latitude) ? $row->latitude : '' ?>" readonly>
        </div>

        <div class="form-group">
            <label for="image">Image url</label>
            <input type="file" id="image" class="form-control" placeholder="Image url" name="image" >

            <?php if (@$row->image) { ?>
            <label>Image</label><br>
            <img src="<?=IMGS_URL.$row->image?>" class="img-md">
            <?php } ?>
        </div>
        
    </div>

    <div class="form-actions text-right">
        <button type="reset" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">
            <i class="ft-x"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary btn-sm mr-1">
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
            <!--/ Base style table -->
        </div>
    </div>
</div>
<!-- END: Content-->

<script type="text/javascript">
    $(document).on('change','#state',function (argument) {
        var id = $(this).val();
        $('#city').load('<?=base_url()?>getCities/'+id);
    })
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



</script>       
<script src="http://maps.google.com/maps/api/js?key=AIzaSyDIHyFm0c8apzuuVZE4zsFXbGDfXRyPsv4&libraries=places&callback=initAutocomplete"
async defer
></script>

