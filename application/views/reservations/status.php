<style type="text/css">
.frmSearch {border: 1px solid #a8d4b1;background-color: #c6f7d0;margin: 2px 0px;padding:40px;border-radius:4px;}
#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;z-index: 999999;max-height: 180px;overflow-y: scroll;}
#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid; }
#country-list li:hover{background:#ece3d2;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>
<!-- <form class="form ajaxsubmit reload-page append" 
	  append-data="#seleted_dates"
	  action="<?=base_url()?>sub_properties/<?=$pro_id?>/reservation/<?=$flat_id?>" 
	  method="POST" 
	  enctype="multipart/form-data" 
	  autocomplete="off" > -->
<form class="form ajaxsubmit reload-tb-filter" 
	  action="<?=$action_url?>" 
	  method="POST" 
	  enctype="multipart/form-data" 
	  >
	<div class="row">

		<div class="col-md-6">
			<div class="form-group">
	           	<label for="status">Status</label>
	           	<select class="form-control" id="status" name="status">
	           		<?php 
	           		echo optionStatus('','-- Select --',1);
                    foreach ($b_status as $brow) {
                    	if ($brow->id!=4) {
                    		$selected = '';
	                        if ($brow->id == $row->status) {
	                            $selected = 'selected';
	                        }
	                        echo optionStatus($brow->id,$brow->status,$brow->active,$selected);
                    	}
                    }
                    ?>
	           	</select>
	        </div>
		</div>
	    
		<div class="col-sm-12">
			<div class="form-actions text-center">
	            <button type="reset" data-dismiss="modal" class="btn btn-danger btn-sm mr-1">
	                <i class="ft-x"></i> Cancel
	            </button>
	            <button type="submit" class="btn btn-primary btn-sm mr-1">
	                <i class="ft-check"></i> Save
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
</style>
<script type="text/javascript">
	$(document).on('click','.inc',function(event) {
		var t = $(this);
		var target = t.attr('data-target');
		var max    = parseInt($(target).attr('max'));
		var value = parseInt($(target).val())+1;
		if (value>max) {
			var value = max;
		}
		$(target).val(value);
	})

	$(document).on('click','.dec',function(event) {
		var t = $(this);
		var target = t.attr('data-target');
		var min    = parseInt($(target).attr('min'));
		var value = parseInt($(target).val())-1;

		if (value<min) {
			var value = min;
		}
		$(target).val(value);
	})

	$(document).ready(function(){
	$("#search-box").keyup(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>appUser/search",
			data:'keyword='+$(this).val(),
			beforeSend: function(){
				$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
				$("#suggesstion-box").show();
				$("#suggesstion-box").html(data);
				$("#search-box").css("background","#FFF");
			}
		});
	});
});

function selectCountry(val,id) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
	userDeatils(id);
}


function userDeatils(id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url()?>appUser/detailes",
		data:'id='+id,
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			console.log(data);
			var data = JSON.parse(data);
			$('#cname').val(data.name);
			$('#cdob').val(data.dob);
			$('#cgender').val(data.gender);
			$('#cemail').val(data.email);
			console.log(data);
		}
	});
}

</script>
