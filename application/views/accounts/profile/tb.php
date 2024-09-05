<div class="card-body card-dashboard">
    <p class="card-text">............</p>
    <div class="row">
        <div class="col-sm-12 col-md-6">
    
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
                    <th>Name</th>
                    <th>ROT Code</th>
                    <th>State</th>
                    <th class="text-center">Active</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=$page;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><?=$row->name?></td>
                    <td><?=$row->rot_code?></td>
                    <td><?php $state = getState_by_id(101,$row->state_id,true); echo $state; ?></td>
                    <td class="text-center">
                        <span class="changeStatus" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,district_master,id,active" ><i class="<?=($row->active==1) ? 'la la-check-circle' : 'icon-close'?>" title="Click for chenage status"></i></span>
                    </td>                    
                   
                    <td>
                        <a href="<?=$update_url?><?=$row->id?>" >
                            <i class="la la-pencil-square"></i>
                        </a>

                        <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete" >
                           <i class="la la-trash"></i>
                       </a>
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

    $(document).on('change','[name="is_route"]',function function_name(event) {

    $this = $(this);
    id = $this.attr('data-id');
    cy = $this.attr('cy');
    if (event.currentTarget.checked) {
        $('[cy="'+cy+'"]').prop('checked', false);
        $this.prop('checked', true);
       var type = 'set';  
    }
    else{
        var type = 'remove';
    }
    // console.log(id);
    $.post('<?=$route_url?>'+id,{type:type})
    .done(function(data){
        // console.log(data);
        data = JSON.parse(data);
        alert_toastr(data.res,data.msg);
    })
  })
</script>
