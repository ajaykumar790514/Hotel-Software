<!DOCTYPE html>
<html>
<head>
<title><?=$booking->guest_name?> <?=date('D, M d ,Y',strtotime($booking->start_date))?> - <?=date('D, M d ,Y',strtotime($booking->end_date))?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>static/app-assets/images/ico/favicon.ico">
	<style type="text/css">
		@page {
		  size: A portrait;
		}

		@page :first {
			margin-top: 35pt;
		}
		@page :left {
			margin-right: 30pt;
		}
		@page :right {
			margin-left: 30pt;
		}
		@media print {
			footer {
				display: none;
				position: fixed;
				bottom: 0;
			}
			header {
				display: none;
				position: fixed;
				top: 0;
			}
            .fa-download{
                display: none;
            }
		}
		table, figure {
			page-break-inside: avoid;
		}
		
		* { 
			margin: 0;
			padding: 0;
		}
		body {
			width: 100%;
			display: block;
		}
		#page-wrap { 
			width: 955px;
			margin: 0 auto;
			page-break-before: always;
            border: 1px solid;
		}
		#header { 
			height: 15px;
			width: 100%;
			margin: 4px 0;
			background: #3b3b3e;
			text-align: center;
			color: white;
			font: bold 15px Helvetica, Sans-Serif;
			text-transform: uppercase;
			letter-spacing: 20px;
			padding: 8px 0px;
			page-break-before: always;
            border: none !important;
		}
		#company-logo {
			margin: 2px;
			max-width:100%;
			max-height: auto;
            text-align: left;
		}
		


		#items {
			clear: both;
			width: 100%;
			margin: 30px 0 0 0;
			border: 1px solid black;
            text-align:center;
		}
		#items th {
			background: #eee;
		}
		
		#items th#cost { 
			width: 90px;
		}
		#items th#discount { 
			width: 120px;
		}
		#items th#qty { 
			width: 90px;
		}
		#items th#tax { 
			width: 90px;
		}
		#items th#price { 
			width: 90px;
		}
		#items tr#item-row td {
			border: 0;
			vertical-align: top;
		}

		p { border: 0; font: 14px, Serif; overflow: hidden; resize: none; }
		table { border-collapse: collapse; }
		table td, table th { border: 1px solid black; padding: 5px; }

		#items p { width: 80px; height: 50px; }
		
		
		#items th.description p, #items td.item-name p { width: 100%; }
		#items td.total-line { border-right: 0; text-align: right; }
		
		#items td.total-value { border-left: 0; padding: 10px; }
		
		#items td.total-value p { height: 20px; background: none; }
		#items td.balance { background: #eee; }
		#items td.blank { border: 0; }

		#total-amount { margin: 20px 0 0 5px; }

		#shop-details{
            text-align : center;
        }
       
	</style>
</head>
<body onload="window.print()">
	 <!-- onload="window.print()" -->
	<div id="page-wrap">
		
		<div id="company-details">
			<div id="company-logo">
                <table style="width: 100%;">
                   
                    <thead>
					<tr>
						<th colspan="12" center> <p id="header" ><?=$propmaster->propname;?></p></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2">GUEST NAME</td>
						<td colspan="4">
                        <?=$receipt->guest_name;?>
                        </td>
						<td colspan="6" rowspan="3" center>
                            <p style="width:180px;float:left"><strong style="text-align:center;font-size:1.4rem"><?=$propmaster->propname;?></strong>
                            <br><?= $propmaster->address ?></p>
                            <p style="float:right;"> <img src="<?=IMGS_URL.$propmaster->logo?>" height="70px"></p>
                        </td>
					</tr>

					<tr>
						<td colspan="2">CONTACT NO.</td>
						<td colspan="4">
                            <?=$receipt->contact_no;?>
						</td>
					</tr>

					<tr>
						<td colspan="2">EMAIL</td>
						<td colspan="4">
                        <?=$receipt->email;?>
						</td>
					</tr>

					<tr>
						<td colspan="2">COMPANY NAME</td>
						<td colspan="4">
                        <?=$receipt->company_name;?>
						</td>
						<td colspan="2">BILL NO.</td>
						<td colspan="4"> <?=$receipt->bill_no;?></td>
					</tr>

					<tr>
						<td colspan="2">ADDRESS</td>
						<td colspan="4">
                        <?=$receipt->address;?>
						</td>
						<td colspan="2">COMPANY NAME</td>
						<td colspan="4"><?= $propmaster->company_name ?></td>
					</tr>

					<tr>
						<td colspan="2">GST NO.</td>
						<td colspan="4">
                        <?=$receipt->gst_no;?>
						</td>
						<?php if($propmaster->is_gst=='YES'):?>
						<td colspan="2"> GST NO.</td>
						<td colspan="4"> <?=$receipt->property_gst;?></td>
						<?php endif;?>
						</tr>
						<tr>
						<td colspan="2"></td>
						<td colspan="4">
						</td>
						<td colspan="2">BOOKING ID.</td>
						<td colspan="4"> <?=$receipt->booking_id;?></td>
					</tr>
                    <tr style="background:#eee">
						<th>ROOMS.</th>
						<th>ARRIVAL</th>
						<th>DEPARTURE</th>
						<th int>DAYS</th>
						<th int>EXTRA DAYS</th>
						<th int>ROOM RENT</th>
						<th int>EXTRA BEDDING</th>
						<th int class="tb-width-fit-content">DISCOUNT</th>
						<?php if($propmaster->is_gst=='YES'):?>
						<th int class="tb-width-fit-content">GST</th>
						<?php endif;?>
						<th int class="tb-width-fit-content">CHECKIN AMOUNT</th>
						<th int class="tb-width-fit-content">EXTRA DAYS AMT</th>
						<th int class="tb-width-fit-content">TOTAL AMOUNT</th>
					</tr>
                   <?php 
				    $COUNT = count($totalcheckin);  $Ttax=$RoundedAmount=$ExtraTotal=$Paid=$Ttotal=0;foreach($checkinarray as $value)
	            	{
			        $checkin = $this->model->getRow('checkin',['id'=>$value]);
					$checkin->start_date= $booking->start_date;
					$checkin->end_date= $booking->end_date;
					$booking_new_items =$this->model->getRow('booking_new_items',['room_type'=>$checkin->room_type, 'booking_id'=>$checkin->booking_id]);
                    $no_of_nights =between_dates($checkin->start_date, $checkin->end_date);
					$checkin->no_of_nights =  ((@$no_of_nights) ? count($no_of_nights) : 1);
                    $checkin->totals = round_price(($checkin->price - (int) $checkin->discount) * $checkin->no_of_nights);
					$end_date = $checkin->end_date;
					$extra_nights_count = calculate_extra_nights($end_date);
					$checkin->no_of_extra_nights = $extra_nights_count;
					$Ttax +=$checkin->taxAmount = $booking_new_items->tax_value/$booking_new_items->qty;
					$checkin->total = round_price((($checkin->extra_bedding_price+$checkin->price)*$checkin->no_of_nights) - (int) $checkin->discount)+$checkin->taxAmount;
					$checkin->total_new = round_price(($checkin->extra_bedding_price+$checkin->price) - (int) $checkin->discount)+$checkin->taxAmount;
					$extra_amt=_number_format((+$checkin->total_new)*$checkin->no_of_extra_nights);
                    $Ttotal = $Ttotal+$checkin->total;
					$ExtraTotal = ($ExtraTotal)+$extra_amt;
                    $booking_items = $this->model->getRow('booking_new_items', ['booking_id' => $checkin->booking_id,'room_type'=>$checkin->room_type]);
					$BookingItem = $this->model->getDataBookingItem($checkin->booking_id,$checkin->room_type);
                    $tr = $this->model->getData('transaction', ['booking_id' => $checkin->booking_id,'action'=>'booking']);
					$Tcredit = 0;
					foreach($tr as $t)
					{
                     $Tcredit = $Tcredit +$t->credit;
					}
					 $roomqty =  $BookingItem->TotalQty;
				     $Tprice = $booking_items->total-$booking_items->total_discount;
					  $TAdvance = $Tcredit;
					  $PerRoomDiscount = $TAdvance / $roomqty;
                     $Paid += ($PerRoomDiscount + $checkin->pre_checkin_amount);
                    ?>
                    <tr>
					<td  style="width:7% !important"><?=$checkin->room_no;?></td>
                    <td  style="width:13% !important"><?= _date($checkin->start_date) ?></td>
					<td style="width:13% !important"> <?= _date($checkin->end_date) ?></td>
					<td style="width:10% !important"><?=$checkin->no_of_nights;?></td>
					<td><?=$checkin->no_of_extra_nights;?></td>
                    <td int><?=setting()->currency; ?> <?=bcdiv($checkin->price, 1, 2);?></td>
					<td int><?=setting()->currency; ?> <?=bcdiv($checkin->extra_bedding_price, 1, 2);?></td>
					<td int class="tb-width-fit-content"><?=setting()->currency; ?> <?=bcdiv($checkin->discount, 1, 2);?></td>
					<?php if($propmaster->is_gst=='YES'):?>
					<td int class="tb-width-fit-content" style="width:10% !important"><?=setting()->currency; ?> <?=bcdiv(@$checkin->taxAmount, 1, 2);?></td>
					<?php endif;?>
					<td int class="tb-width-fit-content"><?=setting()->currency; ?> <?=bcdiv($checkin->pre_checkin_amount , 1, 2);?></td>
					<td int class="tb-width-fit-content"><?=setting()->currency; ?> <?php echo $extra_amt?></td>
					<td int class="tb-width-fit-content"  style="width:12% !important"><?=setting()->currency; ?> <?=bcdiv((@$checkin->total)+$extra_amt, 1, 2);?></td>
					</tr>
                   <?php }?>
                </table>
                <table id="items">
			 <?php 
			 // $TOTALBOOKING  $booking->total-$booking->discount_amount;
               $receivedamount = ($receipt->received_amount-$receipt->food_amount)-$receipt->other_amount;
			  $IGST_RATE=0.00;
			  $CGST_RATE=0.00;
			  $SGST_RATE=0.00;
			  $IgstSubTaxAmount=0.00;
			  $CgstSubTaxAmount=0.00;
				$SGSTSubTaxAmount=0.00;
			   if($receipt->is_igst==1)
			   {
				$CgstSubTaxAmount=0.00;
				$SGSTSubTaxAmount=0.00;
			     $IGST_RATE  = tax_rate($receivedamount);
				 $SubTaxRate = get_tax_amount($receivedamount)['taxRate'];
                //  $IgstSubTaxAmount = get_tax_amount($receivedamount)['taxAmount'];
				$IgstSubTaxAmount=$Ttax;
				 $SubAmount = get_tax_amount($receivedamount)['Amount'];
				 $SubTotalAmount = get_tax_amount($receivedamount)['TotalAmount'];
			   }else
			   {
				$TaxRate  = tax_rate($receivedamount);
				$CGST_RATE=$TaxRate/2;
			    $SGST_RATE=$TaxRate/2;
				$IGST_RATE = 0.00;
				$IgstSubTaxAmount=0.00;
				$SubTaxRate = get_tax_amount($receivedamount)['taxRate'];
				$SubTaxAmount = get_tax_amount($receivedamount)['taxAmount'];
				$SubAmount = get_tax_amount($receivedamount)['Amount'];
				$SubTotalAmount = get_tax_amount($receivedamount)['TotalAmount'];
				$CgstSubTaxAmount=$Ttax/2;
				$SGSTSubTaxAmount=$Ttax/2;
			   }

    
                 ?>
			<tr>
				<th id="item-name" style="width: 50%;text-align:right">SUB TOTAL : </th>
                <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv(($ExtraTotal+$Ttotal)-$Ttax, 1, 2);?></td>
			</tr>
			<?php if($propmaster->is_gst=='YES'):?>
			<tr>
				<th id="item-name" style="width: 50%;text-align:right">ROOM CGST  : </th>
                <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($CgstSubTaxAmount, 1, 2);?></td>
			</tr>
			<tr>
				<th id="item-name" style="width: 50%;text-align:right">ROOM SGST  : </th>
                <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($SGSTSubTaxAmount, 1, 2);?></td>
			</tr>
			<tr>
				<th id="item-name" style="width: 50%;text-align:right">ROOM IGST  : </th>
                <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($IgstSubTaxAmount, 1, 2);?></td>
			</tr>
			<?php endif;?>
				<tr>
				<th id="item-name" style="width: 50%;text-align:right"> ADD FOOD AMOUNT : </th>
                <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($receipt->food_amount, 1, 2);?></td>
			</tr>
			<tr>
				<th id="item-name" style="width: 50%;text-align:right">ADD OTHER AMOUNT : </th>
                <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($receipt->other_amount, 1, 2);?></td>
			</tr>
         
            <tr>
				<th id="item-name" style="width: 50%;text-align:right">ADVANCE PAID : </th>
                <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($Paid, 1, 2);?></td>
			</tr>
          
			<tr>
				<th id="item-name" style="width: 50%;text-align:right"> GRAND TOTAL : </th>
                <th style="width: 50%;text-align:right"><?=setting()->currency; ?>  <?=bcdiv($receipt->grand_total, 1, 2);?></th>
			</tr>
			<tr>
				<th id="item-name" style="width: 50%;text-align:right">DISCOUNT : </th>
                <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($receipt->lump_sum_discount, 1, 2);?></td>
			</tr>
			<tr>
				<th id="item-name" style="width: 50%;text-align:right">BALANCE : </th>
                <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($receipt->grand_total-$Paid, 1, 2);?></td>
			</tr>
           
		
			<tr>
				<th id="item-name" style="width: 50%;text-align:right">ROUNDED AMOUNT : </th>
				 <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($receipt->round_off, 1, 2);?></td>
                <!-- <td style="width: 50%;text-align:right"><?=setting()->currency; ?> <?=bcdiv($SubAmount, 1, 2);?></td> -->
			</tr>
            <tr>
				<th id="item-name" style="width: 50%;text-align:right">TOTAL PAYABLE AMOUNT: </th>
                <th style="width: 50%;text-align:right;margin-right:2rem !important"><?=setting()->currency; ?> <?=bcdiv(($SubTotalAmount+$receipt->food_amount)+$receipt->other_amount, 1, 2);?></th>
			</tr>
            <tr>
			<th colspan="9" center>THE HOTEL RECEPTION .COM</th>
					</tr>
		</table>
            </div>
		</div>
      
	
	</div>
</body>
</html>
