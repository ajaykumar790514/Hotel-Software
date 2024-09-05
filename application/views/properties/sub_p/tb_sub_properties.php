<style type="text/css">

</style>
<div class="card-body card-dashboard">
   <p class="card-text">............</p>
   <!-- <div class="row"> -->
   <div class="table-responsive pt-1">
       <table class="table table-striped table-bordered base-style" id="mytable">
           <thead>
               <tr>
                   <th>Sr. no.</th>
                   <th>Room Name</th>
                   <th>Room No.</th>
                   <!-- <th>Code Name</th> -->
                   <th class="text-center">Status</th>
<!--                   <th class="text-center">Visible In Website</th>-->
                   <th>Approval Status</th>
                   <th >------</th>
                   <th style="width: 180px;">Action</th>
               </tr>
           </thead>
           <tbody>
               <?php $i=0;
               foreach ($rows as $row) { ?>
               <tr>
                   <td><?=++$i?></td>
                   <td><?=$row->flat_name?></td>
                   <td>
                    <?php   $count = $this->model->get_room_allot($row->flat_id);?>
                   <input type="number" value="<?=$row->flat_no?>" data="<?=$row->flat_id?>,property,flat_id,flat_no,<?=$row->propid;?>" class="new-change-indexing form-control" min="0" placeholder="Enter room number" style="width:200px" <?php if($count >=1){echo "readonly";};?>></td>
                   <!-- <td><?=$row->flat_code_name?></td> -->
                   <!-- <td><?=title('location',$row->location_id)?></td> -->
                   <td class="text-center">
                       <span class="changeStatus" onclick='changeStatus(this)' value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->flat_id?>,property" column="flat_id"><i class="<?=($row->status==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                   </td>
<!--
                   <td class="text-center">
                       <span class="changeStatusDispaly" value="<?=($row->display==1) ? 0 : 1?>" data="<?=$row->flat_id?>,property,flat_id" ><i class="<?=($row->display==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
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

                            if ($user_role == 1) {
                        ?>

                        <div class="btn-group mr-1 mb-1">
                            <button type="button" class="btn btn-outline-<?=$class?> btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$row->approval_status?></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="approval_status_change(this,'Pending',<?=$row->flat_id?>)">Pending</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="approval_status_change(this,'Approved',<?=$row->flat_id?>)">Approved</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="approval_status_change(this,'Rejected',<?=$row->flat_id?>)">Rejected</a>
                                <?php //if (@$row->remark) { ?>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->flat_name?> - Remark" data-url="<?=base_url()?>sub_properties/<?=$property->id?>/remark/<?=$row->flat_id?>"  class="dropdown-item remark">Remark</a>
                                <?php //} ?>
                            </div>
                        </div>
                        <?php }else{ ?>
                            <button type="button" class="btn mr-1 mb-1 btn-outline-<?=$class?> btn-sm"><?=$row->approval_status?></button>
                            <div class="clearfix"></div>
                            <p><?=@$row->remark?></p>
                        <?php } ?>
                        
                    </td>
                   <td class="btns">
                      <a href="javascript:void(0)" class="extraActionBtns" data-toggle="extra-action-btns" data-target="#s<?=$row->flat_id?>"><i class="la la-gear"></i></a>
                      <div class="extra-action-btns collapse" id="s<?=$row->flat_id?>" >
                       <!-- <a href="<?=base_url()?>sub_properties/<?=$property->id?>/inventory/<?=$row->flat_id?>" class="btn btn-primary btn-sm m-sm">Inventory</a> -->
                      
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->flat_name?> - Policy" data-url="<?=base_url()?>sub_properties/<?=$property->id?>/policy/<?=$row->flat_id?>"  class="btn btn-primary btn-sm m-sm">Policy</a>

                       <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->flat_name?> - Amenities" data-url="<?=base_url()?>sub_properties/<?=$property->id?>/amenities/<?=$row->flat_id?>"  class="btn btn-primary btn-sm m-sm">Amenities</a> -->

                       <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->flat_name?> - Activity" data-url="<?=base_url()?>sub_properties/<?=$property->id?>/activity/<?=$row->flat_id?>"  class="btn btn-primary btn-sm m-sm">Activity</a> -->

                       <a href="<?=base_url()?>sleeping_arr/<?=$property->id?>/index/<?=$row->flat_id?>" class="btn btn-primary btn-sm m-sm">Sleeping Arrangements</a>

                      <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Kitchen - <?=$row->flat_name?>" data-url="<?=base_url()?>sub_properties/<?=$property->id?>/kitchen/<?=$row->flat_id?>" title="Kitchen" class="btn btn-primary btn-sm m-sm" >
                           Kitchen
                       </a>

                       <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="BroadBand - <?=$row->flat_name?>" data-url="<?=base_url()?>sub_properties/<?=$property->id?>/broadBand/<?=$row->flat_id?>" title="Kitchen" class="btn btn-primary btn-sm m-sm" >
                           BroadBand
                       </a> -->

                       <a href="javascript:void(0)" data-toggle="copy" data-target="https://www.myrentalstay.com/hdp/<?=$row->propid?>?flat_id=<?=$row->flat_id?>" title="Copy Url" class="btn btn-primary btn-sm m-sm" >
                           Copy Url
                       </a>
                      </div>
                   </td>
                   
                   <td>
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$row->flat_name?>" data-url="<?=base_url()?>sub_properties/<?=$property->id?>/info/<?=$row->flat_id?>" title="View more">
                           <i class="la la-info"></i>
                       </a>
                       <a href="<?=base_url()?>sub_properties/<?=$property->id?>/update/<?=$row->flat_id?>" title="Update">
                           <i class="la la-pencil-square"></i>
                       </a>
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Images - <?=$row->flat_name?>" data-url="<?=base_url()?>sub_properties/<?=$property->id?>/images/<?=$row->flat_id?>" title="Images" >
                           <i class="la la-image"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_duplicate(this)" url="<?=base_url()?>sub_properties/<?=$property->id?>/duplicate/<?=$row->flat_id?>" title="Duplicate" >
                           <i class="la la-copy"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=base_url()?>sub_properties/<?=$property->id?>/delete/<?=$row->flat_id?>" title="Delete" >
                           <i class="la la-trash"></i>
                       </a>
                       
                       <!-- <a href="">
                           <i class="la la-trash"></i>
                       </a> -->
                   </td>
               </tr> 
               <?php
               }
               ?>
               
               
           </tbody>
           
       </table>

   </div>
 
<!-- </div> -->
<script type="text/javascript">
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
                where:'flat_id',
                table:'property',
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

  // $(document).mouseup(function(e) {
  //     var container1 = $(".extraActionBtns");
  //     var container2 = $(".extra-action-btns");

  //     if (!container1.is(e.target) || !container2.is(e.target)) {
  //         $('.btns .collapse').removeClass('show');
  //     }
  // });
</script>