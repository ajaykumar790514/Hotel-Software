<?php
echo "<pre>";
// print_r($propmaster);
echo "</pre>";
?>

<div class="row">
	<form class="form dynamic-tb-search col-md-12 p-0" action="<?=$tb_filter_url?>" method="POST" enctype="multipart/form-data" tagret-tb="#propaccess">
		<div class="col-md-3 float-left mb-1">
			<div class="form-group">
				<label>Country</label>
				<select name="country" class="form-control sumbit-change" tagret-form=".dynamic-tb-search" id="country" >
					<?=$countries?>
				</select>
			</div>
		</div>
		<div class="col-md-3 float-left mb-1">
			<div class="form-group">
				<label>State</label>
				<select name="state" class="form-control sumbit-change" tagret-form=".dynamic-tb-search" id="state" >
					<option value=""> -- Select -- </option>
				</select>
			</div>
		</div>
		<div class="col-md-3 float-left mb-1">
			<div class="form-group">
				<label>City</label>
				<select name="city" class="form-control sumbit-change" tagret-form=".dynamic-tb-search" id="city" >
					<option value=""> -- Select -- </option>
				</select>
			</div>
		</div>
		<div class="col-md-3 float-left mb-1">
			<div class="form-group">
				<label>Search In Table</label>
				<input name="search" class="form-control sumbit-input" tagret-form=".dynamic-tb-search" type="text"  placeholder="Property Name" >
				
				<!-- <input class="form-control static-tb-search mb-1 float-right" type="text" placeholder="Search Property...." tbtarget="#propaccess"> -->
			</div>
		</div>
	</form>
	<div class="col-md-12 table-responsive" >
		
		
		
		<table class="table table-striped table-bordered base-styl propaccess">
			<thead>
				<tr>
					<!-- <th>Select</th> -->
					<th>Name ( Code )</th>
					<th>City, State, Country</th>
					<th>Address</th>
					<th>Approval Status</th>
                    <th>Action</th>
				</tr>
			</thead>
			<tbody id="propaccess">
			<?php foreach ($propmaster as $row) { ?>
				<tr>
					<!-- <td>
						<input type="checkbox" class="switchery" data-size="sm" name="" id="apropnaster" value="<?=$row->id?>" <?=$row->checked?> >
					</td> -->
					<td><?=$row->propname?> <br> ( <?=$row->propcode?> )</td>
					<td>
						<?=title('cities', $row->city,'id','name')?>,<br>
						<?=title('states', $row->state,'id','name')?>,<br>
						<?=title('countries', $row->country,'id','name')?>
					</td>
					<td><?=$row->address?></td>
					<td>
                        <?php
                            if ($row->approval_status == 'Pending') {
                                $class = "warning";
                            }elseif($row->approval_status == 'Approved'){
                                $class = "success";
                            }else{
                                $class = "danger";
                            }

                            if ($user->user_role == 1) {
                        ?>

                        <div class="btn-group mr-1 mb-1">
                            <button type="button" class="btn btn-outline-<?=$class?> btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$row->approval_status?></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="approval_status_change(this,'Pending',<?=$row->id?>)">Pending</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="approval_status_change(this,'Approved',<?=$row->id?>)">Approved</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="approval_status_change(this,'Rejected',<?=$row->id?>)">Rejected</a>
                                <?php //if (@$row->remark) { ?>
                                <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->propname?> - Remark" data-url="<?=base_url()?>host_m/remark/<?=$row->id?>"  class="dropdown-item remark"></a> -->
                                <?php //} ?>
								<!-- <button onclick="createTextarea(<?=$row->id;?>)">Create Textarea</button> -->
                                
                            </div>
                        </div>
						
                    <?php }else{ ?>
                        <button type="button" class="btn mr-1 mb-1 btn-outline-<?=$class?> btn-sm"><?=$row->approval_status?></button>
                        <div class="clearfix"></div>
                        <!-- <p><?//=$row->remark?></p> -->
                    <?php } ?>
					
                    </td>
					<td>
					<a href="<?=base_url('host/details/')?><?=$row->id?>" target="_blank" style="font-size:large">
                           <i class="la la-info"  style="font-size:2rem"></i>
                       </a>
					</td>
					
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-12" id="remarks" style="display: none;">
    <form action="" >
   <input type="hidden" id="row_id" class="row_id">		
	<div class="col-12">
		<label for="Enter Remark">Enter Rejection Remark</label>
     <textarea name="remark" id="rejectionremark" class="form-control"></textarea>
	</div>
	<div class="col-10" style="float:left"></div>
	<div class="col-2" style="float:right">
		<button type="button" class="btn btn-primary mt-2" onclick="submit_remark()">Submit</button>
	</div>
	</form>
	</div>
</div>
<style></style>
<script type="text/javascript">
	function submit_remark()
	{
		var row_id =$("#row_id").val();
		var rejectionremark = $("#rejectionremark").val();
		$.ajax({
			url:"<?=base_url();?>host/approval__remark",
			type:"POST",
			data:{  where:'id',id:row_id,remark:rejectionremark},
			success:function(data)
			{
				if(data=='success')
				{
				
				$("#remarks").hide();
		        $(".table-responsive").show();
				}else
				{
				$("#remarks").show();
		        $(".table-responsive").hide();
				}
			}
		})
	}
	$('.propaccess #apropnaster').change(function(event){
		$this = $(this);
		var id = $this.val();
		if (event.currentTarget.checked) {
			var type = 'set';  
	   }
	   else{
	   	var type = 'remove';
	   }
	   $.post('<?=base_url()?>host/propaccess/<?=$host_id?>',{p_id:id,type:type})
		.done(function(data){
			// console.log(data);
			data = JSON.parse(data);
			alert_toastr(data.res,data.msg);
			if (data.res=='success') {
				loadtb();
			}
		})
  })

	$('#country').change(function() {
        var id = $(this).val();
        $('#state').load('<?=base_url()?>getStates/'+id);
    })

    $('#state').change(function() {
        var id = $(this).val();
        $('#city').load('<?=base_url()?>getCities/'+id);
    })
	function approval_status_change(btn, status, id){
        if (status == 'Rejected') {
            $(btn).siblings('.remark').click();
           $("#remarks").show();
		   $('.row_id').val(id);
		   $(".table-responsive").hide();
        }
        $(btn).parent('div').prev('button').text(status);
        $.ajax({
            url:'<?=base_url()?>host/approval_status_change',
            method:'POST',
            data:{
                status:status,
                id:id,
                where:'id',
                table:'propmaster',
            },
            success:function(data){
                //console.log(data);
                if (data == 'Approved') {
                    $(btn).parent('div').prev('button').removeClass('btn-outline-warning');
                    $(btn).parent('div').prev('button').removeClass('btn-outline-danger');
                    $(btn).parent('div').prev('button').addClass('btn-outline-success');
                }else if (data == 'Rejected') {
                    $(btn).parent('div').prev('button').removeClass('btn-outline-warning');
                    $(btn).parent('div').prev('button').removeClass('btn-outline-success');
                    $(btn).parent('div').prev('button').addClass('btn-outline-danger');
                }else{
                    $(btn).parent('div').prev('button').removeClass('btn-outline-danger');
                    $(btn).parent('div').prev('button').removeClass('btn-outline-success');
                    $(btn).parent('div').prev('button').addClass('btn-outline-warning');
                }
            }
        });
    }
</script>
