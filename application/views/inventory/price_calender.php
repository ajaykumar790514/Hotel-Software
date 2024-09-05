<style type="text/css">
    .myCal{
        color: #6b6f80;
        border: 1px solid #7c7ad4;
        width: 100%;
        /*height: 700px;*/
        border-collapse: collapse;
    }

    .myCal th, .myCal td {
        border: 1px solid #231fe6;
        padding: 0;
        vertical-align: top;
    }
    .myCal th{
        text-align: center;
        height: 35px;
        font-size: 17px;
        vertical-align: middle;
    }
    .myCal td input ,.myCal td select{
        width: 96%;
        margin: 2%;
        height: 25px;
        color: #fff;
    }

    .myCal td label{
        width: 100%;
        text-align: center;
        margin-bottom:1px;
    }
    .myCal .day{
        /*float: right;*/
    padding: 3px 7px;
    font-size: 20px;
    }
    .form-control.bg-dark:focus{
        color: white;
    }
    .select-date{
        width: 16px!important;
        height: 16px!important;
        cursor: pointer;
        display: none;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <span class="btn btn-primary btn-sm">Capacity - <?=@$prow->capacity?></span>
                </h4>


                
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2 text-center">

                            <button class="btn btn-primary btn-sm text-center mr-1" data-toggle="modal" data-target="#showModal" data-whatever="Bulk Inventory Pricing" data-url="<?=base_url()?>inventory/bulk_inventory_pricing/<?=$pro_id?>/<?=$flat_id?>">
                               <i class="ft-sliders"></i> Set Bulk Inventory Pricing
                            </button>

                         <!--    <button class="btn btn-primary btn-sm text-center" data-toggle="modal" data-target="#showModal" data-whatever="Reservation" data-url="<?=base_url()?>sub_properties/<?=$pro_id?>/reservation/<?=$flat_id?>">
                               <i class="ft-bookmark"></i> Reservation
                            </button> -->
                            <input type="hidden" id="seleted_dates">
                        </div>
                        <div class="col-md-6 mb-2 ">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <!-- <button type="button" class="btn btn-primary btn-sm">Daily Price</button>
                                <button type="button" class="btn btn-info btn-sm">Extra Bedding Price</button>
                                <button type="button" class="btn btn-dark btn-sm">Status</button> -->
								<button type="button" class="btn btn-primary btn-sm">Set Price & Status</button>
                                <button type="button" class="btn btn-danger btn-sm"><i class="la la-eye" style="position: relative;bottom: -2px;"></i> Show Details</button>
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
<!-- Modal -->
<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="inventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="inventoryModalLabel">Set Pricing of <span id="modalDateTitle"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="inventoryForm">
					<div class="row">
                    <input type="hidden" id="modalDate" name="date">
                    <input type="hidden" id="modalFlatId" name="flat_id">
					<div class="col-md-3">
                    <div class="form-group">
                        <label for="epPrice" class="required">EP Price</label>
                        <input type="number" class="form-control" id="epPrice" name="epPrice">
                    </div>
					</div>
					<div class="col-md-3">
                    <div class="form-group">
                        <label for="cpPrice" class="required">CP Price</label>
                        <input type="number" class="form-control" id="cpPrice" name="cpPrice">
                    </div>
					</div>
					<div class="col-md-3">
                    <div class="form-group">
                        <label for="mapPrice" class="required">MAP Price</label>
                        <input type="number" class="form-control" id="mapPrice" name="mapPrice">
                    </div>
					</div>
					<div class="col-md-3">
                    <div class="form-group">
                        <label for="apPrice" class="required">AP Price</label>
                        <input type="number" class="form-control" id="apPrice" name="apPrice">
                    </div>
					</div>
					<div class="col-sm-3">
					<div class="form-group">
						<label for="epextraBeddingPrice" class="required">EP Extra Bed Price</label>
						<input type="number" id="epextraBeddingPrice" class="form-control" name="epextraBeddingPrice">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="cpextraBeddingPrice" class="required">CP Extra Bed Price</label>
						<input type="number" id="cpextraBeddingPrice" class="form-control" name="cpextraBeddingPrice">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="mapextraBeddingPrice" class="required">MAP Extra Bed Price</label>
						<input type="number" id="mapextraBeddingPrice" class="form-control" name="mapextraBeddingPrice">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="apextraBeddingPrice" class="required">AP Extra Bed Price</label>
						<input type="number" id="apextraBeddingPrice" class="form-control" name="apextraBeddingPrice">
					</div>
				</div>
					<div class="col-md-9"></div>
					<div class="col-md-3">
					<button type="submit" class="float-left btn btn-danger btn-sm" class="close" data-dismiss="modal" aria-label="Close">Close</button>
					<button type="submit" class="float-right btn btn-primary btn-sm">Save</button>
					</div>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function load_cal() {

        var month = $('#month').val();
        var year = $('#year').val();
        var flat_id = '<?=$flat_id?>';
        $.post('<?=base_url()?>inventory/inventory_cal/',{month:month,year:year,flat_id:flat_id,prop_id:<?=$pro_id?>})
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
        if (type!='status') {
            // if (confirm('Are you sure? You want change price all types of room.')) {
              
            // }
            $('#msg').html('<span class="text-warning">Saving....</span>');
                $.post('<?=base_url()?>inventory/save_inventory',{price:price,type:type,date:date,property_id:f_id})
                .done(function(data){
                    $('#msg').html(data);
                    console.log(data);
                })
        }else{
            $('#msg').html('<span class="text-warning">Saving....</span>');
            $.post('<?=base_url()?>inventory/save_inventory',{price:price,type:type,date:date,property_id:f_id})
            .done(function(data){
                $('#msg').html(data);
                console.log(data);
            })
        }
        
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
