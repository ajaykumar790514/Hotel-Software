<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Room No</th>
                        <th>Guest Name</th>
                        <th>Contact No.</th>
                        <th>Company Name</th>
                        <th>Grand Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $key => $row) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $row->room_no ?></td>
                            <td><?= $row->guest_name ?></td>
                            <td><?= $row->contact_no ?></td>
                            <td><?= $row->company_name ?></td>
                            <td><?= $row->grand_total ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" target="_blank" href="<?= $receipt_url ?><?= $row->id ?>">
                                    Receipt
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>