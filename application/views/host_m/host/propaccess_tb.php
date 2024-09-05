<?php $i=1;foreach ($propmaster as $row) {
	$package = $this->model->get_host_package_row_new($host_id,$row->id); ?>
	<tr class="<?=$row->checked?>">
		<td>
			<span style="position: relative;margin-right: 10px !important;"><?=$i++?></span><input type="checkbox" class="switchery" data-size="sm" name="" id="apropnaster" value="<?=$row->id?>" <?=$row->checked?> >
		</td>
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
													</div>
												</div>
												
											<?php }else{ ?>
												<button type="button" class="btn mr-1 mb-1 btn-outline-<?=$class?> btn-sm"><?=$row->approval_status?></button>
												<div class="clearfix"></div>
											<?php } ?>
											
											</td>
											<td>
											<a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Package Details - <?=@$package->name;?>" data-url="<?=base_url()?>host/package/<?=@$package->id?>"><b><?=@$package->name;?></b></a>
											</td>
											<td align="center">
												<?php 
												if(!empty($package))
												{
													if(@$package->status=='2')
													{
														echo "<h4 class='text-success'>Success</h4>";
													}elseif(@$package->status=='3'){
														echo "<h4 class='text-danger'>Pending</h4>";
													
													}elseif(@$package->status=='4'){
														echo "<h4 class='text-danger'>Failed</h4>";
													}elseif(@$package->status=='1'){
														echo "<h4 class='text-danger'>Free Plan</h4>";
													}else{echo "<h4 class='text-danger'>Not Any Select Plan</h4>";}
												}else{
													echo "<h4 class='text-danger'>Plan Not Active</h4>";
												} ;?>
											</td>
											<td>
											<a title="View Property Details" href="<?=base_url('host/details/')?><?=$row->id?>" target="_blank" style="font-size:large">
												<i class="la la-info"  style="font-size:2rem"></i>
											</a>
											</td>
		
		
	</tr>
<?php } ?>
