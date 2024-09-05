
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
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="<?=base_url()?>properties">Properties</a>
                            </li>
                            <li class="breadcrumb-item"><a href="<?=base_url()?>sub_properties/<?=$pmrow->id?>"><?=$pmrow->propname?></a>
                            </li>
                            <li class="breadcrumb-item active">
                                <?=$prow->flat_name?> 
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
           
        </div>
        <div class="content-body">
            <!-- Full calendar basic example section start -->
            <section id="basic-examples">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a href="<?=base_url()?>sub_properties/<?=$pmrow->id?>" class="btn btn-primary btn-sm"><i class="ft-list"></i> <?=$pmrow->propname?> ( <?=$prow->flat_name?> ) </a> 
                                    <span class="btn btn-primary btn-sm ml-1">Capacity - <?=$prow->capacity?></span>
                                </h4>


                                
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li id="msg">
                                        </li>
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <p class="card-text">
                                        ............
                                    </p>

                                    <div class="row">
                                        <div class="col-md-6 mb-2 text-center">

                                            <button class="btn btn-primary btn-sm text-center mr-1" data-toggle="modal" data-target="#showModal" data-whatever="Bulk Inventory Pricing" data-url="<?=base_url()?>sub_properties/<?=$pro_id?>/bulk_inventory_pricing/<?=$flat_id?>">
                                               <i class="ft-sliders"></i> Set Bulk Inventory Pricing
                                            </button>

                                            <!-- <button class="btn btn-primary btn-sm text-center" data-toggle="modal" data-target="#showModal" data-whatever="Reservation" data-url="<?=base_url()?>sub_properties/<?=$pro_id?>/reservation/<?=$flat_id?>">
                                               <i class="ft-bookmark"></i> Reservation
                                            </button> -->
                                            <input type="hidden" id="seleted_dates">
                                        </div>
                                        <div class="col-md-6 mb-2 ">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-primary btn-sm">Daily Price</button>
                                                <button type="button" class="btn btn-info btn-sm">Extra Bedding Price</button>
                                                <button type="button" class="btn btn-dark btn-sm">Status</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row-reverse">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="year">Year</label>
                                                <select id="year" name="year" class="form-control input-sm" >
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>
                                                </select>
                                            </div>
                                            
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="month">Month</label>
                                                <select id="month" name="month" class="form-control input-sm">
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                   
                                                </select>
                                            </div>
                                        </div>

                                        
                                        
                                        <!-- <div class="col-md-3">
                                            <input class="form-control bg-info" value="Extra Bedding Price" readonly="" >
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control bg-primary" value="Daily Price"  readonly=""> 
                                            
                                        </div> -->

                                        
                                    </div>
                                    <div id='cal' class="table-responsive">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Full calendar basic example section end -->
        </div>
    </div>
</div>
<!-- END: Content-->
<script type="text/javascript">

    function load_cal() {

        var month = $('#month').val();
        var year = $('#year').val();
        var flat_id = '<?=$flat_id?>';
        $.post('<?=base_url()?>inventory_cal/',{month:month,year:year,flat_id:flat_id})
        .done(function(data){
            $('#cal').html(data);
        })
    }
    
    $('#month').val('<?=$month?>');
    $('#year').val('<?=$year?>');
    load_cal();

    $('#month').change(function(){
        load_cal();
    })
     $('#year').change(function(){
        load_cal();
    })

    function save_inventory(e){
        var price = $(e).val();
        var type = $(e).attr('p-type');
        var date = $(e).attr('p-date');
        var f_id = $(e).attr('f-id');
        $('#msg').html('<span class="text-warning">Saving....</span>');
        $.post('<?=base_url()?>save_inventory',{price:price,type:type,date:date,property_id:f_id})
        .done(function(data){
            $('#msg').html(data);
            console.log(data);
        })
        // console.log(price+' - '+type+' - '+date+' - '+f_id);
    }

    $(document).on('change','.select-date',function(event) {



        // return false;


        var values = new Array();
        $.each($("input[name='select_date[]']:checked"), function() {
          values.push($(this).val());
        });
        $('#seleted_dates').val(values);
        // console.log(values);

    })
</script>