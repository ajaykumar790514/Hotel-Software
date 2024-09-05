
<div class="card-body card-dashboard">
    <p class="card-text">
        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="New Property Review" data-url="<?=base_url()?>property_reviews/new/<?=$pro_id?>/<?=$property->flat_id?>" class="btn btn-primary btn-sm"><i class="ft-plus"></i> Add New Review</a>
    </p>
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

    <div class="table-responsive pt-1">
        <table class="table table-striped table-bordered base-style" id="myTable">
            <thead>
                <tr>
                    <th>Sr. no.</th>
                    <th>Review From</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Review</th>
                    <th class="text-center">Display</th>
                    <th>Rating</th>
                    <th>Date</th>
                    <th>Reply</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
               <tbody>
                <?php $i=$page;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><?=$row->reviewfrom?></td>
                    <!-- <td><?=title('reviews_source_master',$row->reviewfrom)?></td> -->
                    <td><?=$row->guest_name?></td>
                    <td>
                        <img src="<?=$row->guest_image?>" style="width: 150px;max-height: 150px;">        
                    </td>
                    <td><?=$row->title?></td>
                    <td><?=$row->review?></td>
                    <td class="text-center">

                        <span class="changeStatusDispaly" value="<?=($row->display==1) ? 0 : 1?>" data="<?=$row->id?>,propertyreview"><i class="<?=($row->display==1) ? 'la la-check-circle' : 'icon-close'?>"></i></span>
                    </td>
                    <td >
                        <div style="width: 120px">
                            <span class="la la-star<?=($row->rating>=1)? '' : '-o'?>"></span>
                            <span class="la la-star<?=($row->rating>=2)? '' : '-o'?>"></span>
                            <span class="la la-star<?=($row->rating>=3)? '' : '-o'?>"></span>
                            <span class="la la-star<?=($row->rating>=4)? '' : '-o'?>"></span>
                            <span class="la la-star<?=($row->rating>=5)? '' : '-o'?>"></span>
                        </div>
                        
                    </td>
                    <td>
                        <div style="width: 90px">
                        <?=date_format(date_create($row->created_on),"d-M-Y h:i:s a")?>
                        </div>  
                    </td>
                    
                    <td>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Property Review" data-url="<?=base_url()?>property_reviews/reply/<?=$row->property_id?>/<?=$row->flat_id?>/<?=$row->id?>">
                           <i class="la la-comments"></i>
                        </a>
                    </td>
                    <td>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Property Review" data-url="<?=base_url()?>property_reviews/update/<?=$row->property_id?>/<?=$row->flat_id?>/<?=$row->id?>">
                           <i class="la la-pencil-square"></i>
                       </a>
                       
                        
                        <a href="javascript:void(0)" url="<?=base_url()?>property_reviews/delete/<?=$row->property_id?>/<?=$row->flat_id?>/<?=$row->id?>" onclick="_delete(this)">
                            <i class="la la-trash"></i>
                        </a>
                    </td>
                </tr> 
                <?php
                }
                ?>
                
            <?php if (!$rows) { ?>  
                <tr>
                    <td colspan="10">
                        <span class="text-danger">Data Not Found!</span>
                    </td>
                </tr>
            <?php } ?>  
            </tbody>
                
                
            </tbody>
        </table>
    </div>
    <?php if ($rows) { ?>
    <div class="row mt-1">
        <div class="col-md-6 text-left">
            <span>Showing <?=$page+1?> to <?=$i?> of <?=$total_rows?> entries</span>
        </div>
        <div class="col-md-6 text-right">
            <?=$links?>
        </div>
    </div>
    <?php } ?>

</div>
<style type="text/css">
    .la-star{
        color:var(--warning)!important;
    }
</style>
<script type="text/javascript">
    if ('<?=$search?>'!='') {
        $('#tb-search').val('<?=$search?>').focus();
    }
</script>