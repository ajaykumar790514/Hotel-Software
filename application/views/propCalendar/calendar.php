<style type="text/css">
	.myCal{
        color: #6b6f80;
        border: 1px solid #7c7ad4;
        width: 100%;
        /*height: 700px;*/
        border-collapse: collapse;
    }

    /*.myCal th, .myCal td {
        border: 1px solid #231fe6;
        padding: 0;
        vertical-align: top;
    }*/
    .myCal th, .myCal td{
        text-align: center!important;
        border: 1px solid #231fe6;
        height: 35px;
        font-size: 17px;
        vertical-align: middle;
    }
    .la{
        font-weight: bolder!important;
    }





   

   
    /*.p-cal li{
        transition: .4s;
    }
    .p-cal li:hover{
        transform: scale(1.3);
        border: 1px solid var(--cal_border);
        border-radius: 10px;
        background: #fff;
    }*/

</style>
<section>
	<div class="row">
		<div class="col-md-12">
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
            </div>
		</div>

		<!-- <div class="col-md-12" id="cal-remove" >
			
		</div> -->
	</div>
</section>
<section id="cal">
    
</section>

<script type="text/javascript">
    function load_cal() {
	    var month = $('#month').val();
	    var year = $('#year').val();
	    $.post('<?=base_url()?>propCalendar/pro-calendar/<?=$pro_id?>',{month:month,year:year})
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

    $(document).on('click','.la-check-circle-o',function(event) {
        return false;
    })

    $(document).on('click','.la-ban',function(event) {
        return false;
    })

    $(document).on('change','#sub_property_types',function(e){
        $(`[room-type]`).show();
        let id = $(this).val();
        if(id){
            $(`[room-type]`).hide();
            $(`[room-type="${id}"]`).show();
        } 
    })
</script>