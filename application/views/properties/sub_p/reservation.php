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
<form class="form ajaxsubmit reload-page" 
	  action="<?=base_url()?>sub_properties/<?=$pro_id?>/reservation/<?=$flat_id?>" 
	  method="POST" 
	  enctype="multipart/form-data" 
	  autocomplete="off" >
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
            <label for="startDate">Start Date</label>
            <input type="date" id="startDate" class="form-control" name="startDate">
        </div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
            <label for="endDate">End Date</label>
            <input type="date" id="endDate" class="form-control" name="endDate">
        </div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
           	<label for="mobile">Mobile </label>
			<input autocomplete="false" type="number" id="search-box" class="form-control" placeholder="Mobile Number" name="mobile" >
			<div id="suggesstion-box"></div>
        </div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
           	<label for="name">Name </label>
			<input type="text" class="form-control" placeholder="Name" id="cname" name="name" />
        </div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
           	<label for="dob">Date of Birth</label> 
			<input type="date" class="form-control" placeholder="Date of Birth" id="cdob" name="dob" />
        </div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
           	<label for="gender">Gender </label>
           	<select class="form-control" id="cgender" name="gender">
           		<option value="">-- Select --</option>
           		<option value="Male">Male</option>
           		<option value="Female">Female</option>
           	</select>
        </div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
           	<label for="email">Email </label>
			<input type="email" class="form-control" id="cemail" placeholder="Email" name="email" />
        </div>
	</div>
<style type="text/css">
	.inc-dec{
		width: 150px;
		text-align: center;
	}
	.input-group-text{
		cursor: pointer;
	}
</style>
	<div class="col-md-12">
		<div class="col-md-12">
			<label>Guests </label>
		</div>
		
		<div class="col-md-4">
	        <label for="of_adults">Adults <small>Ages 13 or above</small> </label>

	        <div class="input-group mb-1">
			  <div class="input-group-prepend noselect">
			    <span class="input-group-text dec" data-target="#of_adults">&#9866;</span>
			  </div>
			  <input type="number" class="form-control inc-dec" id="of_adults" value="0" name="of_adults" readonly="" min="0" max="16">
			  <div class="input-group-append noselect">
			    <span class="input-group-text inc" data-target="#of_adults">&#10010;</span>
			  </div>
			</div>
		</div>
		<div class="col-md-4">
			
	        <label for="of_children">Children <small>Ages 2-12</small> </label>

	        <div class="input-group mb-1">
			  <div class="input-group-prepend noselect">
			    <span class="input-group-text dec" data-target="#of_children">&#9866;</span>
			  </div>
			  <input type="number" class="form-control inc-dec" id="of_children" value="0" name="of_children" readonly="" min="0" max="16">
			  <div class="input-group-append noselect">
			    <span class="input-group-text inc" data-target="#of_children">&#10010;</span>
			  </div>
			</div>
		</div>
		<div class="col-md-4">
			<label for="of_infants">Infants <small>Under 2</small> </label>

	        <div class="input-group mb-1">
			  <div class="input-group-prepend noselect">
			    <span class="input-group-text dec" data-target="#of_infants">&#9866;</span>
			  </div>
			  <input type="number" class="form-control inc-dec" id="of_infants" value="0" name="of_infants" readonly="" min="0" max="5">
			  <div class="input-group-append noselect">
			    <span class="input-group-text inc " data-target="#of_infants">&#10010;</span>
			  </div>
			</div>

			
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

function selectUser(val,id) {
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
