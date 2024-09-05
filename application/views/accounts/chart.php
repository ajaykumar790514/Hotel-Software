<h4 class="card-title mb-0">Income &nbsp; - <?=setting()->currency;?> <?=$totalIncome?></h4>
<h4 class="card-title">Expense - <?=setting()->currency;?> <?=$totalExpense?> </h4>
<canvas id="myCharttt" style="display: block; box-sizing: border-box;height: 320px; width:100%;" ></canvas>
        <section id="tabs-with-icons">
            <div class="row match-height">
                <!-- <div class="col-xl-12 col-lg-12"> -->
                    <!-- <div class="card"> -->
                        <!-- <div class="card-content"> -->
                            <div class="card-body">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="income-tab" data-toggle="tab" aria-controls="income" href="#income" aria-expanded="true"><i class="ft-arrow-down text-success"></i> Income</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " id="expense-tab" data-toggle="tab" aria-controls="expense" href="#expense" aria-expanded="false"><i class="ft-arrow-up text-danger"></i> Expense</a>
                                    </li>
                                    
                                </ul>
<div class="tab-content p-0 pt-1">
    <div role="tabpanel" class="tab-pane active" id="income" aria-expanded="true" aria-labelledby="income-tab">
      <div class="table-responsive">
        <table class="table table-striped table-bordered  res-tb" id="myTable">
          <thead>
            <tr>    
              <th class="flat_no">Room No</th>
              <th>Arrival - Departure</th>
              <th>Guest</th>
              <th>Booked From</th>
              <th>Booked On</th>
              <th>Total payout</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 0;
            foreach ($all_bookings as $row) { ++$i;
							$rooms = $this->model->getData('room_allotment',['booking_id'=>$row->id]);
							$flat_id   = 0;$flat_no=array();
							foreach($rooms as $r):
								$flat_id = $r->flat_id;
								$flat_no[]   = title('property',$flat_id,'flat_id','flat_no');
								$propid    = title('property',$flat_id,'flat_id','propid');
								$propname  = title('propmaster','propid','id','propname'); 
								endforeach;
								$flat_no_str = implode(' , ', $flat_no);
             ?>
              <tr>
                <td class="flat_no"><?=$flat_no_str?></td>
                <td>
                  <?=date('d M Y',strtotime($row->start_date))?> <strong>&nbsp;-&nbsp;</strong>  <?=date('d M Y',strtotime($row->end_date))?> 
                </td>
                <td>
                  <?=$row->guest_name?> <span class="text-info"><?=$row->contact?></span>
                </td>
                <td><?=title('booking_type',$row->booking_type,'id','type') ?></td>
                <td> <?=date('d M Y H:i A',strtotime($row->booking_date))?> </td>
                <td><?=$row->total?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="tab-pane " id="expense" aria-labelledby="expense-tab">
      <div class="table-responsive">
        <table class="table table-striped table-bordered base-style" id="myTable">
          <thead>
            <tr>
              <th>Sr. no.</th>
              <th>Type</th>
              <th>Amount</th>
              <th>Property</th>
              <th>Date Time</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=0;
            foreach ($all_expense as $row) { ?>
              <tr>
                <td><?=++$i?></td>
                <td><?=title('expense_master',$row->expense_master_id,'id','name')?></td>
                <td><?=$row->amount?></td>
                <td><?=title('propmaster',$row->prop_master_id,'id','propname')?></td>
                <td><?=date('d-M-Y h:m A',strtotime($row->date_time))?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
</div>
                            </div>
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </section>

<script type="text/javascript">
 var labels = <?=json_encode($label)?>;

  var data = {
    labels: labels,
    datasets: [{
      label: 'Income ',
      backgroundColor: 'transparent',
      borderColor: 'green',
      data: <?=json_encode($incomeArray)?>,
    },{
      label: 'Expense ',
      backgroundColor: 'transparent',
      borderColor: 'red',
      data: <?=json_encode($expenseArray)?>,
    }]

    
  };

  var config = {
    type: 'line',
    data: data,
    options: {}
  };
</script>
<script>
  var myChart = new Chart(
    document.getElementById('myCharttt'),
    config
  );
</script>
