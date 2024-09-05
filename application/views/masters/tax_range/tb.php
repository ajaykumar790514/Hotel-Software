<div class="card-body card-dashboard">
    <p class="card-text">............</p>


    <div class="table-responsive">
        <table class="table table-striped table-bordered base-style" id="myTable">
            <thead>
                <tr>
                    <th>Sr. no.</th>
                    <th>From - To</th>
                    <th>Tax Rate</th>
                    <th class="text-center">Status</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><?=$row->from?> - <?=$row->to?></td>
                    <td><?=$row->tax_rate?> %</td>
                    <td class="text-center">
                        <span class="changeStatus" onclick='changeStatus(this)' value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->id?>,tax_range"><i class="<?=($row->status==1) ? 'la la-check-circle' : 'icon-close'?>"></i></span>
                    </td>
                   
                    <td>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Tax Range" data-url="<?=$update_url?><?=$row->id?>">
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
</div>
