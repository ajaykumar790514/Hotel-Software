<div class="card-body card-dashboard">
    <p class="card-text">............</p>

    <p id="msg"></p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered base-style" id="myTable">
            <thead>
                <tr>
                    <th>Sr. no.</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;
                foreach ($rows as $row) { ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><?=$row->name;?></td>
                    <td><?=$row->mobile;?></td>
                    <td><?=$row->email;?></td>
                    <td><?=$row->subject;?></td>
                    <td><?=$row->message;?></td>
                    <td><?=_date($row->added);?></td>
                    <td>
                        <select name="status" id="status" p-type="status" class="form-control" oninput="change_status_en(<?=$row->id;?>)">
                            <option>--Select--</option>
                            <option value="Pending"  <?php if($row->status=='Pending'){echo "selected";}  ;?>  >Pending</option>
                            <option value="Replied"  <?php if($row->status=='Replied'){echo "selected";}  ;?>  >Replied</option>
                        </select>
                    </td>
                </tr> 
                <?php
                }
                ?>
            </tbody>
            
        </table>

    </div>
</div>
