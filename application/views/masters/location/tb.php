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
                    <th>Name</th>
                    <!-- <th>Country</th> -->
                    <th>State</th>
                    <th>City</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Visible in website</th>
                    <th class="text-center">Route</th>
                    <th class="text-center">Order</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=$page;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><?=$row->name?></td>
                    <!-- <td><?=$row->country?></td> -->
                    <td><?=$row->state?></td>
                    <td><?=$row->city?></td>
                    <td class="text-center">
                        <span class="changeStatus" onclick='changeStatus(this)' value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->id?>,location"><i class="<?=($row->status==1) ? 'la la-check-circle' : 'icon-close'?>"></i></span>
                    </td>

                    <td class="text-center">
                        <span class="changeStatus" data-toggle="change-status" value="<?=($row->visible_in_website==1) ? 0 : 1?>" data="<?=$row->id?>,location,id,visible_in_website"><i class="<?=($row->visible_in_website==1) ? 'la la-check-circle' : 'icon-close'?>"></i></span>
                    </td>

                    <td class="text-center">
                        <input type="number" value="<?=$row->indexing?>" data="<?=$row->id?>,location,id,indexing" class="change-indexing" min="0">
                    </td>
                    <td class="text-center">
                        <input type="checkbox" name="is_route" <?=($row->is_route==1) ? 'checked' : '' ?> data-id="<?=$row->id?>" cy="<?=$row->cityid?>" class="switchery" data-size="sm"> 
                    </td>
                   
                    <td>
                        <a href="<?=$update_url?><?=$row->id?>" >
                            <i class="la la-pencil-square"></i>
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
