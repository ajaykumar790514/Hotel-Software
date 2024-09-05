<div class="card-body card-dashboard">
    <p class="card-text">............</p>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <!-- <div class="dataTables_length" id="DataTables_Table_0_length">
                <label>
                    Show 
                    <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control form-control-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> 
                    entries
                </label>
            </div> -->
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                <label>
                    <input type="search" class="form-control form-control-sm" id="tb-search" placeholder="Search" aria-controls="DataTables_Table_0" >
                </label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered base-style" id="myTable">
            <thead>
                <tr>
                    <th>Sr. no.</th>
                    <th>Property Name</th>
                    <th>Property Code</th>
                    <th>Location</th>
                    <th class="text-center">Status</th>
<!--                    <th class="text-center">Visible in Website</th>-->
                    <th>Approval Status</th>
                    <th>-----</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=$page;
                foreach ($rows as $row) { ?>
                <tr align="center">
                    <td><?=++$i?></td>
                    <td><?=$row->propname?></td>
                    <td><?=$row->propcode?></td>
                    <td><?=title('location',$row->location_id)?></td>
                    <td class="text-center">
                        <span class="changeStatus" onclick='changeStatus(this)' value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->id?>,propmaster"><i class="<?=($row->status==1) ? 'la la-check-circle' : 'icon-close'?>"></i></span>
                    </td>
<!--
                    <td class="text-center">
                        <span class="changeStatus" onclick='changeStatus(this)' value="<?=($row->display==1) ? 0 : 1?>" data="<?=$row->id?>,propmaster"><i class="<?=($row->display==1) ? 'la la-check-circle' : 'icon-close'?>"></i></span>
                    </td>
-->
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
                       <center>
                        <div class="btn-group mr-1 mb-1 text-center">
                            <button type="button" class="btn btn-outline-<?=$class?> btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$row->approval_status?></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="approval_status_change(this,'Pending',<?=$row->id?>)">Pending</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="approval_status_change(this,'Approved',<?=$row->id?>)">Approved</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="approval_status_change(this,'Rejected',<?=$row->id?>)">Rejected</a>
                                <?php //if (@$row->remark) { ?>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->propname?> - Remark" data-url="<?=base_url()?>properties/remark/<?=$row->id?>"  class="dropdown-item remark">Remark</a>
                                <?php //} ?>
                            </div>
                        </div>
						</center>
                    <?php }else{ ?>
                        <button type="button" class="btn mr-1 mb-1 btn-outline-<?=$class?> btn-sm"><?=$row->approval_status?></button>
                        <div class="clearfix"></div>
                        <!-- <p><?//=$row->remark?></p> -->
                    <?php } ?>
                        
                    </td>
                    <!-- <td>
                        <a href="<?=base_url()?>sub_properties/<?=$row->id?>" class="btn btn-primary btn-sm">Sub Pro.</a>
                    </td> -->
                    <td class="btns">
                      <?php if($row->approval_status == 'Approved'){;?>   
                      <a href="javascript:void(0)" class="extraActionBtns" data-toggle="extra-action-btns" data-target="#s<?=$row->id?>"><i class="la la-gear"></i></a>
                     <?php } ;?>
                      <div class="extra-action-btns collapse" id="s<?=$row->id?>" >                       
                      
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->propname?> - Policy" data-url="<?=base_url()?>properties/policy/<?=$row->id?>"  class="btn btn-primary btn-sm m-sm">Policy</a>

                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->propname?> - Amenities" data-url="<?=base_url()?>properties/amenities/<?=$row->id?>"  class="btn btn-primary btn-sm m-sm">Amenities</a>

                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->propname?> - Activity" data-url="<?=base_url()?>properties/activity/<?=$row->id?>"  class="btn btn-primary btn-sm m-sm">Activity</a>

                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="BroadBand - <?=$row->propname?>" data-url="<?=base_url()?>properties/broadBand/<?=$row->id?>" title="Kitchen" class="btn btn-primary btn-sm m-sm" >
                           BroadBand
                       </a>
                       
                      </div>
                   </td>
                    <td align="center">
					<?php if($user->user_role =='4'):?>
                    <a href="<?=base_url()?>properties/update/<?=$row->id?>" title="Update">
                            <i class="la la-pencil-square"></i>
                        </a>
						<?php endif;?>
                        <?php if($row->approval_status == 'Approved'){;?>   

                        <a href="javascript:void(0)" data-toggle="copy" data-target="https://www.myrentalstay.com/hdp/<?=$row->id?>" title="Copy Url"  ><i class="la la-link"></i>
                       </a>

                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->propname?>" data-url="<?=base_url()?>properties/info/<?=$row->id?>" title="Details">
                           <i class="la la-info"></i>
                       </a>
                       
                       

                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Images - <?=$row->propname?>" data-url="<?=base_url()?>properties/images/<?=$row->id?>" title="Images" >
                           <i class="la la-image"></i>
                        </a>
						<?php if($user->user_role =='4'):?>
                        <a href="#" url="<?=base_url()?>properties/delete/<?=$row->id?>" onclick="_delete(this)" title="Delete">
                            <i class="la la-trash"></i>
                        </a>
                        <?php endif?>
                        <a href="<?=IMGS_URL.$row->document?>" title="View / Download" target="_blank"><i class="la la-file"></i> </a>
                        
                        <a  class="btn btn-primary btn-sm m-sm mt-2" href="<?=base_url()?>sub_properties/<?=$row->id?>" title="Rooms">Rooms</a>
                        <a  class="btn btn-primary btn-sm m-sm" href="<?=base_url()?>sub_properties_types/<?=$row->id?>" title="Room Category">Rooms Category</a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->propname?>" data-url="<?=base_url()?>properties/plan-details/<?=$row->id?>" title="Details">
                           <i class="la la-info"></i>
                       </a>
                       <a  class="btn btn-primary text-center btn-sm m-sm" href="<?=base_url()?>checkSubProperty/<?=$row->id?>" title="Upgrade Plan">Upgrade Plan</a>

                       <?php }else{echo '<br><p class="text-danger">'.$row->remark.'</p>';}?>
                    </td>
                </tr> 
                <?php
                }
                ?>
                
                
            </tbody>
            
        </table>

    </div>
    <div class="row">
        <div class="col-md-6 text-left">
            <span>Showing <?=$page+1?> to <?=$i?> of <?=$total_rows?> entries</span>
        </div>
        <div class="col-md-6 text-right">
            <?=$links?>
        </div>
    </div>
 </div>
<script type="text/javascript">
    if ('<?=$search?>'!='') {
        $('#tb-search').val('<?=$search?>').focus();
    }

    function approval_status_change(btn, status, id){
        if (status == 'Rejected') {
            $(btn).siblings('.remark').click();
            //return false;
        }
        $(btn).parent('div').prev('button').text(status);
        $.ajax({
            url:'<?=base_url()?>properties-status',
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
