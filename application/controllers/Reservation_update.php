<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
// require('PropCalendar.php');
class Reservation_update extends Main {


	public function extend($booking_id)
	{
		$data['row'] = $row = $this->booking_detailes($booking_id);
		

		// $this->pr($extended);
		// if ($this->model->getRow('booking',['ref_booking_id'=>$booking_id])) {
		// 	echo "<body style='display: table;'>";
		// 	echo "<h1 style='display: table-cell;
		// 				    vertical-align: middle;
		// 				    width: 100vw;
		// 				    height: 100vh;
		// 				    text-align: center;
		// 				    color: darkred;'>
		// 			Booking Already Extended!<h1>";
		// 	echo '<script type="text/javascript">
		// 			setTimeout(function() {
		// 				window.close();
		// 			}, 1500);
		// 		</script>';
		// 	echo "</body>";
		// 	die();
		// }
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$return['res'] 		  = 'error';
			$return['msg'] 		  = 'Someting Worng!';

			$booking   = $this->booking_detailes($booking_id);
			
			unset($booking->id);

			// from date - to date
			if (@$_POST['newStartDate'] && @$_POST['newEndDate']) {
				$dateArray = $this->between_dates($_POST['newStartDate'],$_POST['newEndDate']);

			} else {
				$return['msg'] 		  = 'Date not selected!';
				echo json_encode($return);
				die();
			}	
			// from date - to date

			if ($this->date_availability($dateArray,$booking->flat_id)==false) {
				$return['msg'] 		  = 'gggg!';$return['msg'] = 'Selected Dates Not Available!';
				
				echo json_encode($return);
				die();
			}

			$price  = $this->get_price($dateArray,$booking->flat_id);

			// echo $_POST['discount_remark'];

			$extend['booking_from'] 		= $booking->booking_from;
			$extend['guest_id'] 			= $booking->guest_id;
			$extend['confirmation_code'] 	= $confirmation_code = rand( 10000 , 99999 );
			$extend['status'] 				= 2;
			$extend['extended'] 			= 1;
			$extend['extended_remark'] 		= $_POST['extend_remark'];
			$extend['gender'] 				= $booking->gender;
			$extend['email'] 				= $booking->email;
			$extend['contact'] 				= $booking->contact;
			$extend['of_adults'] 			= $booking->of_adults;
			$extend['of_children'] 			= $booking->of_children;
			$extend['of_infants'] 			= $booking->of_infants;
			$extend['start_date'] 			= $_POST['newStartDate'];
			$extend['end_date'] 			= $_POST['newEndDate'];
			$extend['booking_type'] 		= $booking->booking_type;
			$extend['of_nights'] 			= $booking->of_nights;
			$extend['earnings'] 			= $booking->earnings;
			$extend['flat_id'] 				= $booking->flat_id;
			$extend['notes'] 				= $booking->notes;
			$extend['purpose_of_trip'] 		= $booking->purpose_of_trip;
			$extend['vehcleno'] 			= $booking->vehcleno;
			$extend['price'] 				= (int)$price - (int)$_POST['discount_amount'];
			$extend['ref_booking_id'] 		= $booking_id;
			$extend['user_id'] 				= $booking->user_id;
			$extend['is_foreigner'] 		= $booking->is_foreigner;
			$extend['booking_remark'] 		= $booking->booking_remark;
			$extend['order_id'] 			= '';
			$extend['booking_id'] 			= '';
			$extend['rzp_payment_id'] 		= '';
			$extend['price_currency'] 		= '';
			$extend['rzp_capture_response'] = '';
			$extend['booking_date'] 		= date("Y-m-d");
			$extend['rzp_refund_response'] 	= '';
			$extend['discount_amount'] 		= $_POST['discount_amount'];
			$extend['discount_remark'] 		= $_POST['discount_remark'];
			$extend['service_charges']		= $this->service_charges;
			$extend['payment_mode']			= '';
			$extend['payment_status']		= 1;
			$extend['reference_id']			= NULL;

			// $this->pr($extend); die();

			if ($booked = $this->model->Save('booking',$extend)) {
				$return['res'] 		  = 'success';
				$return['msg'] 		  = 'Reservation Successful.';
				// $this->model->Delete('property_inventory',['property_id'=>$booking->flat_id]);
			}

			if ($booked) {   // update Calendar
				$this->send_email($booked,'extend');
				$this->update_inventory($dateArray,$booking->flat_id,3,$booked);
				$this->save_booking_row_items($booked,$booking->flat_id,$extra_bedding=0);
			}
			$return['receipt_url'] = base_url().'receipt/'.$booked;
			echo json_encode($return);
			// echo "string";
			// echo $booking_id;
			// $this->pr($booking);
			// $this->pr($_POST);
		}
		else {
			$data['user']    = $user  = $this->checkLogin();
			$data['title']   = 'Reservations Extend';
			$data['contant'] = 'reservations/reservation_extend';
			$data['flat_id'] = $row->flat_id;
			$data['month']   = $month = date('m',strtotime($row->start_date));
			$data['year']    = $year  = date('Y',strtotime($row->start_date));
			$data['property']   = $property  = $this->property_detailes($row->flat_id);
			$data['propmaster'] = $this->propmaster_detailes($property->propid);
			$uri                = $row->id.'?m='.$month.'&y='.$year;
			$data['tb_url']     = base_url().'property-calendar-extend/'.$uri;
			$data['cal_url']    = base_url().'property-calendar-extend/'.$row->id.'?';
			// $data['pro_calendar'] = $this->s_property_calendar($row->flat_id,$month,$year);

			// $this->pr($data);
			$this->template($data);
			// echo $booking_id;
		}
	}

	public function change_flat($booking_id)
	{
		$data['row'] = $row = $this->booking_detailes($booking_id);
		// $this->pr($row);
		
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$return['res'] 		  = 'error';
			$return['msg'] 		  = 'Someting Worng!';

			$booking   = $row;
			$oldFlatId = $booking->flat_id;
			// $this->pr($_POST);
			unset($booking->id);

			$booking->start_date = $_POST['startDate'];
			$booking->flat_id    = $_POST['flat_id'];


			// from date - to date
			if (@$booking->start_date && @$booking->end_date) {
				$dateArray = $this->between_dates($booking->start_date,$booking->end_date);
			}
			else{
				$return['msg'] 		  = 'Date not selected!';
				echo json_encode($return);
				die();
			}	
			// from date - to date

			if ($this->date_availability($dateArray,$booking->flat_id)==false) {
				$return['msg'] = 'Selected Dates Not Available!';
				echo json_encode($return);
				die();
			}
			$price = $this->get_price($dateArray,$booking->flat_id);
			
			$booking->status 		     = 2;
			$booking->flat_changed 	     = 1;
			$booking->change_flat_remark = $_POST['change_flat_remark'];
			$booking->price 		     = (int)$price - (int)$_POST['wave_off_amount'];
			$booking->ref_booking_id  	 = $booking_id;
			$booking->wave_off_amount  	 = $_POST['wave_off_amount'];
			$booking->wave_off_remark  	 = $_POST['wave_off_remark'];
			$booking->booking_date     	 = date("Y-m-d");

			if ($booked = $this->model->Save('booking',$booking)) {
				$return['res'] 		  = 'success';
				$return['msg'] 		  = 'Reservation Successful.';
				// $this->model->Delete('property_inventory',['property_id'=>$booking->flat_id]);
				$old_booking['status'] 		 = 5;
				$this->model->Update('booking',$old_booking,['id'=>$booking_id]);
			}

			if ($booked) {    			// update Calendar
				$this->update_inventory($dateArray,$oldFlatId,1);
				$this->update_inventory($dateArray,$booking->flat_id,3,$booked);
				$this->save_booking_row_items($booked,$booking->flat_id,$extra_bedding=0);
			}
			$return['receipt_url'] = base_url().'receipt/'.$booked;
			echo json_encode($return);
			// echo "string";
			// echo $booking_id;
			// $this->pr($booking);
			// $this->pr($_POST);
		}
		else {
			$data['user']    = $user  = $this->checkLogin();
			$data['title']   = 'Change Room - Reservations';
			$data['contant'] = 'reservations/reservation_change_flat';
			$data['flat_id'] = $row->flat_id;
			$data['month']   = $month = date('m',strtotime($row->start_date));
			$data['year']    = $year  = date('Y',strtotime($row->start_date));
			$data['property']   = $property  = $this->property_detailes($row->flat_id);
			$data['propmaster'] = $this->propmaster_detailes($property->propid);
			$data['properties'] = $this->properties_by_propmaster($property->propid);
			$uri                = $row->id.'?m='.$month.'&y='.$year;
			$data['tb_url']     = base_url().'property-calendar-change-flat/'.$uri;
			$data['cal_url']    = base_url().'property-calendar-change-flat/'.$row->id.'?';
			// $data['pro_calendar'] = $this->s_property_calendar($row->flat_id,$month,$year);

			// $this->pr($data);
			$this->template($data);
			// echo $booking_id;
		}
	}

	public function pre_check_out($booking_id,$backBtn='no')
	{
		$data['row'] = $row = $this->booking_detailes($booking_id);
		$data['booking_item'] = $this->model->getRow('booking_new_items', ['booking_id' => $booking_id]);
		if ($row->checkout_time1=='00:00:00' or $row->checkout_time1=='') {
			$row->checkout_time1 = null;
		}

		if ($row->status==5 or $row->checkout_time1!=null) {
			echo "<body style='display: table;'>";
			if ($backBtn=='yes') {
			echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">';
			}
			echo "<h1 style='display: table-cell;
						    vertical-align: middle;
						    width: 100vw;
						    height: 100%;
						    text-align: center;
						    color: darkred;'>
						Already Completed!<h1>";
			echo '<script type="text/javascript">
					setTimeout(function() {
						window.close();
					}, 1500);
				  </script>';
			echo "</body>";
			die();
		}

		if ($this->input->server('REQUEST_METHOD')=='POST' && $backBtn!='yes') {
			$insertArry = array();
			$updateArray = array();
			$return['res'] = 'error';
			$return['msg'] = 'Not Saved!';
			$Saved = 0;

			$_POST['checkout_time1'] = date('h:i:s',strtotime($_POST['checkout_time']));
			$_POST['checkout_date'] = date('Y-m-d',strtotime($_POST['checkout_time']));

			if (@$_POST['checklist']) {
				foreach ($_POST['checklist'] as $checklist) {
					$insertArryTmp['booking_id']   = $booking_id;
					$insertArryTmp['checklist_id'] = $checklist;
					//-- -- -- -- -- -- -- ;
					$insertArry[] = $insertArryTmp;
					unset($insertArryTmp);
				}
			}

			$updateBooking['checkout_time1']  = $_POST['checkout_time1'];
			$updateBooking['checkout_date']   = $_POST['checkout_date'];
			$updateBooking['status'] 		  = 5;
			$updateBooking['pre_checkout'] 	  = 1;
			$updateBooking['price']		      = (int)$row->price - (int)$_POST['wave_off_amount'];
			$updateBooking['checkout_remark'] = $_POST['checkout_remark'];
			$updateBooking['wave_off_amount'] = $_POST['wave_off_amount'];
			$updateBooking['wave_off_remark'] = $_POST['wave_off_remark'];
			if ($this->model->Update('booking',$updateBooking,['id'=>$booking_id])) {
				foreach ($insertArry as $irow) {
					if($this->model->Save('checkout',$irow)){
						$dateArray = $this->between_dates($_POST['checkout_date'],$row->end_date);
						$this->update_inventory($dateArray,$row->flat_id,1);
					}
				}
				$Saved = 1;
			}
			

			if ($Saved == 1) {
				$return['res'] = 'success';
				$return['msg'] = 'Saved.';
				$return['receipt_url'] = base_url().'receipt/'.$booking_id;
			}
			// echo "<pre>";
			// print_r($insertArry);
			// print_r($updateBooking);
			// echo "</pre>";

			echo json_encode($return);
			

			// $this->pr($_POST);
		}
		else {
			$data['checklist'] = $this->model->getData('checklist',['process'=>'checkout']);
			$data['contant']   = 'reservations/pre_checkout'; 
			if ($backBtn=='yes') {
				echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">';
			}
			load_view($data['contant'],$data);
			// $this->pr($data);
		}
	}

	public function reschedule_booking($booking_id)
	{
		$data['row'] = $row = $this->booking_detailes($booking_id);
		$data['extended'] = $extended = $this->extended_bookings($booking_id);

		if ($row->checkout_time1=='00:00:00' or $row->checkout_time1=='') {
			$row->checkout_time1 = null;
		}
			// $this->pr($row);

		if ($row->status==5 or $row->checkout_time1!=null) {
			echo "<body style='display: table;'>";
			echo "<h1 style='display: table-cell;
						    vertical-align: middle;
						    width: 100vw;
						    height: 100%;
						    text-align: center;
						    color: darkred;'>
						Already Completed!<h1>";
			echo '<script type="text/javascript">
					setTimeout(function() {
						window.close();
					}, 1500);
				  </script>';
			echo "</body>";
			die();
		}

		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$insertArry = array();
			$updateArray = array();
			$return['res'] = 'error';
			$return['msg'] = 'Not Saved!';
			$Saved = 0;
			// echo "string";
			// $this->pr($_POST);

			// from date - to date
			if (@$_POST['newStartDate'] && @$_POST['newEndDate']) {
				$newDateArray = $this->between_dates($_POST['newStartDate'],$_POST['newEndDate']);
			}
			else {
				$return['msg'] 		  = 'Date not selected!';
				echo json_encode($return);
				die();
			}	
			// from date - to date


			if ($this->date_availability($newDateArray,$row->flat_id,$booking_id)==false) {
				$return['msg'] = 'Selected Dates Not Available!';
				echo json_encode($return);
				die();
			}
			
			$updateBooking['start_date'] 		= $_POST['newStartDate'];
			$updateBooking['end_date'] 		  	= $_POST['newEndDate'];
			$updateBooking['status'] 		  	= 2;
			$updateBooking['rescheduled'] 	  	= 1;
			$updateBooking['price']		      	= (int)$row->price - (int)$_POST['reschedule_wave_off_amount'];
			$updateBooking['reschedule_remark'] 		 = $_POST['reschedule_remark'];
			$updateBooking['reschedule_wave_off_amount'] = $_POST['reschedule_wave_off_amount'];
			$updateBooking['reschedule_wave_off_remark'] = $_POST['reschedule_wave_off_remark'];
			// $this->pr($updateBooking);
			if ($this->model->Update('booking',$updateBooking,['id'=>$booking_id])) {
				$Saved = 1;
			}

			if ($Saved == 1) {
				$oldDateArray = $this->between_dates($row->start_date,$row->end_date);
				$this->update_inventory($oldDateArray,$row->flat_id,1);
				$this->update_inventory($newDateArray,$row->flat_id,3,$booking_id);
				$this->model->Delete('booking_row_items',array('fk_booking_id' => $booking_id));
				$this->save_booking_row_items($booking_id,$row->flat_id,$extra_bedding=0);

				// cancle all extend bookings
				if (@$extended) {
					foreach ($extended as $extrow) {
						$date_array = $this->between_dates($extrow->start_date,$extrow->end_date);
						$this->update_inventory($date_array,$extrow->flat_id,1);
						$this->model->Delete('booking_row_items',array('fk_booking_id' => $extrow->id));
						$this->model->Update('booking',['status'=>5],['id'=>$extrow->id]);
					}
				}
				// cancle all extend bookings

				$return['res'] = 'success';
				$return['msg'] = 'Saved.';
				$return['receipt_url'] = base_url().'receipt/'.$booking_id;
			}
			
			echo json_encode($return);
		}
		else {
			$data['flat_id']   = $row->flat_id;
			$data['checklist'] = $this->model->getData('checklist',['process'=>'checkout']);
			// $data['contant']   = 'reservations/reschedule_booking'; 
			$data['contant']   = 'reservations/reschedule_booking_new'; 

			$data['month']   = $month = date('m',strtotime($row->start_date));
			$data['year']    = $year  = date('Y',strtotime($row->start_date));
			$data['property']   = $property  = $this->property_detailes($row->flat_id);
			$data['propmaster'] = $this->propmaster_detailes($property->propid);
			$uri                = $row->id.'?m='.$month.'&y='.$year;
			$data['tb_url']     = base_url().'property-calendar-reschedule/'.$uri;
			$data['cal_url']    = base_url().'property-calendar-reschedule/'.$row->id.'?';
			
			$this->template($data);


			// load_view($data['contant'],$data);

		}
	}

}


