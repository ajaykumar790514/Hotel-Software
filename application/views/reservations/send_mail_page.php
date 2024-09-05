
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .booking-details {
            margin-bottom: 20px;
        }
        .send-mail-btn {
            display: block;
            width: 95%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            margin-bottom: 10px;
        }
		 .select-bill-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            margin-bottom: 10px;
        }
        .send-mail-btn:hover, .select-bill-btn:hover {
            background-color:red;
        }
        .bill-list {
            display: none;
            margin-bottom: 20px;
        }
		.bill-checkbox
		{
		height: 20px;
		width: 20px;
		margin-top: 10px;
		margin-bottom: 10px;
		}
     .bill_no{
		position: relative;
    top: -4px;
	 }
	 .form-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-primary-new {
            top: -5px;
			display: inline-block;
			text-decoration: none;
			padding: 6px;
			background-color: #007bff;
			color: white;
			border-radius: 5px;
			text-align: center;
			position: relative;
			left: -10px;
        }
        .btn-primary-new:hover {
            background-color: #0056b3;
        }
        .btn-icon {
            font-size: 2rem !important;
            margin-left: 4px;
        }
		.btn-icon-new {
    font-size: 1.5rem !important;
    margin-left: -2px;
    position: relative;
    top: 2px;
}
    </style>
      <div class="container">
        <h2>Booking Details</h2>
        <div class="booking-details">
            <p><strong>Booking ID:</strong> <?= $booking->id; ?></p>
            <p><strong>Guest Name:</strong> <?= $booking->guest_name; ?> <span class="text-info"><?= $booking->contact ?></span></p>
            <p><strong>Arrival:</strong> <?= _date($booking->start_date) ?> </p>
            <p><strong>Departure:</strong> <?= _date($booking->end_date) ?></p>
            <!-- Add more booking details as needed -->
        </div>
        <?php if($booking->status == '5'){ ?>
        <button id="selectBillButton" class="select-bill-btn">Send Bill to Mail</button>
        <div id="billList" class="bill-list">
            <form id="sendBillForm" class="form ajaxsubmit reload-page" action="<?= base_url('reservations/send_mail_post'); ?>" method="post">
                <input type="hidden" name="id" value="<?= $booking->id; ?>">
                <input type="hidden" name="type" value="bill">
                <?php foreach ($checkout as $bill) { ?>
                    <div>
                        <input type="checkbox" class="bill-checkbox" name="bills[]" value="<?= $bill->id; ?>"> <span class="bill_no"><?= $bill->bill_no; ?> 
						<a href="<?=base_url('reservations/view_booking_bill/'.$bill->bill_no);?>"  target="_blank" title="Receipt">
						<i class="la la-eye  btn-icon-new"></i>
					</a></span>
                    </div>
                <?php } ?>
                <button type="submit" class="send-mail-btn btn btn-primary" style="display:none;">Send Selected Bill(s) to Mail</button>
            </form>
        </div>
        <?php } ?>
		<div class="form-group">
            <form class="form ajaxsubmit reload-page" action="<?= base_url('reservations/send_mail_post'); ?>" method="post" style="flex: 1;">
                <input type="hidden" name="id" value="<?= $booking->id; ?>">
                <input type="hidden" name="type" value="receipt">
                <button type="submit" class="send-mail-btn" id="selectBillButtonNew">Send Receipt to Mail</button>
            </form>
            <a href="<?=base_url('reservations/view_booking_receipt/'.$booking->id);?>" class="btn btn-primary btn-primary-new" target="_blank" title="Receipt">
                <i class="la la-eye text-white btn-icon"></i>
            </a>
        </div>
    </div>
	<script>
        $(document).ready(function(){
            $('#selectBillButton').click(function(){
                $('#billList').toggle();
            });
			$('#selectBillButtonNew').click(function(){
                $('#billList').hide();
            });
            $('.bill-checkbox').change(function(){
                if ($('.bill-checkbox:checked').length > 0) {
                    $('#sendBillForm button[type="submit"]').show();
                } else {
                    $('#sendBillForm button[type="submit"]').hide();
                }
            });
        });
    </script>
