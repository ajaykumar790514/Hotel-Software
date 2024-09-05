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
                                <?=$title?> List
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
                                    <form class="form ajaxsubmit reload-tb" action="<?=base_url()?>reviews_source/save" method="POST" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <h4 class="form-section">
                                                <i class="la la-building"></i><?=$title?>
                                            </h4>
                                            <div class="row">
                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Country</label>
                                                        <select id="country" name="country" class="form-control">
                                                            <?php
                                                                echo optionStatus('','-- Select --');
                                                            foreach ($countries as $row) {
                                                                echo optionStatus($row->id,$row->name);
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div> -->

                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="state">State</label>
                                                        <select id="state" name="state" class="form-control">
                                                            <option value="" >-- Select --</option>
                                                        </select>
                                                    </div>
                                                </div> -->

                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="city">City</label>
                                                        <select id="city" name="city" class="form-control">
                                                            <option value="" >-- Select --</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="location_id">Location</label>
                                                        <select id="location_id" name="location_id" class="form-control">
                                                             <?php
                                                            //     echo optionStatus('','-- Select --');
                                                            // foreach ($locations as $row) {
                                                            //     echo optionStatus($row->id,$row->name);
                                                            // }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div> -->
                                            
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="propmaster">Property</label>
                                                        <select id="propmaster" name="propmaster" class="form-control" onchange="sub_property(this.value)">
                                                            <?php
                                                            echo optionStatus('','-- Select --');
                                                            foreach ($propmaster as $row) {
                                                                echo optionStatus($row->id,$row->propname);
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="sub_property">Sub Property</label>
                                                        <select id="sub_property" name="sub_property" class="form-control">
                                                            <option value="">-- Select --</option>
                                                            <!-- <option value="307">Hotel Sunrise -901</option>
                                                            <option value="308">Hotel Sunrise -902</option>
                                                            <option value="309">Hotel Sunrise 903</option>
                                                            <option value="310">Hotel Sunrise 904</option>
                                                            <option value="311">Hotel Sunrise 905</option>
                                                            <option value="312">Hotel Sunrise 906</option>
                                                            <option value="313">Hotel Sunrise 907</option>
                                                            <option value="314">Hotel Sunrise 908</option>
                                                            <option value="315">Hotel Sunrise 908</option>
                                                            <option value="316">Hotel Sunrise 908</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
                                    <!-- End: form -->
                                    <hr>
                                </div>
                            </div>
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
    $(document).ready(function () {
    $('#country').change(function () {
        var id = $(this).val();
        $('#state').load('<?=base_url()?>getStates/' + id);
    });

    $('#state').change(function () {
        var id = $(this).val();
        $('#city').load('<?=base_url()?>getCities/' + id);
        load_location();
    });

    $('#city').change(function () {
        load_location();
    });

    function load_location() {
        $('#location_id').html('<option value="">-- Select --</option>');
        var state = $('#state').val();
        var city = $('#city').val();
        $.post('<?=base_url()?>load_locations', { state: state, city: city })
            .done(function (data) {
                data = JSON.parse(data);
                $('#location_id').html(data.content);
            })
            .fail(function () {
                alert("error");
            });
    }

    $('#location_id').change(function () {
        $('#propmaster').load('<?=base_url()?>propmasterByLocation/' + $(this).val());
    });

    // Ensure the sub_property function is defined before it's used
    function sub_property(id) {
        $('#sub_property').load('<?=base_url()?>subProperty/' + id);
    }

    $('#propmaster').change(function () {
        sub_property($(this).val());
    });

    $('#sub_property').change(function () {
        var subPropertyId = $(this).val();
        var url = '<?=base_url()?>property_reviews/reviews/null/' + subPropertyId;
        $('#tb').load(url);
        $('[name="tb"]').val(url);
    });
});

</script>
