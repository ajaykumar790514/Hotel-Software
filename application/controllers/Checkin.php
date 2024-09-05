<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Main.php');
class Checkin extends Main
{

	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function index($booking_id)
	{
		$data['user'] = $user  = $this->checkLogin();
		// echo $booking_id;
		
		if (@$_POST['room_no']) {
			$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
			// check user property assign or not
            $existprop  = $this->validate_user_property($user->id,$booking->property_id);
			if($existprop==0)
			{
			$return['res'] 		  	 = 'error';
		    $return['msg'] 		  	 = 'Please select valid property !';
			echo json_encode($return);
			die();
			}
			//  prx($_POST);die();
			if(empty($post['payment_mode']))
			{
			$return['res'] 		  	 = 'error';
		    $return['msg'] 		  	 = 'Please select payment mode !';
			echo json_encode($return);
			die();
			}
			$insertCheckin = array();

			$_POST['intime'] = date('Y-m-d H:i:s', strtotime($_POST['intime']));
			$_POST['check_time'] = date('h:i:s', strtotime($_POST['intime']));

			if (!@$_POST['room_no']) {
				$return['res'] = 'error';
				$return['msg'] = 'No room selected!';
				echo json_encode($return);
				die();
			}
			$ra_value = explode('-', $_POST['room_no']);

			$room_type = $ra_value[0];
			$flat_id = $ra_value[1];
			$room_no = $ra_value[2];
			$bi_cond = ['booking_id' => $booking_id, 'room_type' => $room_type];

			$data['booking_items'] = $booking_items = $this->model->getRow('booking_new_items', $bi_cond);
			$property_data = $this->model->getRow('propmaster',['id'=>$booking->property_id]);
			$post = $this->input->post();
			if ($booking->start_date && $booking->end_date) {
				$date = $this->between_dates($booking->start_date, $booking->end_date);
				$nights = ((@$date) ? count($date) : 1);
			}
			$insertCheckin['visitors_type'] 	= '';
			$insertCheckin['booking_id'] 		= $booking->id;
			$insertCheckin['guest_id'] 			= $booking->guest_id;
			$insertCheckin['guest_name'] 		= $booking->guest_name;
			$insertCheckin['pic'] 				= 'null';
			$insertCheckin['contact'] 			= $booking->contact;
			$insertCheckin['address'] 			= 'null';
			$insertCheckin['of_adults'] 		= $post['adults'];
			$insertCheckin['of_children'] 		= $post['children'];
			$insertCheckin['of_infant'] 		= $post['infants'];
			$insertCheckin['start_date'] 		= $booking->start_date;
			$insertCheckin['end_date'] 			= $booking->end_date;
			$insertCheckin['check_time'] 		= $post['check_time'];
			$insertCheckin['extra_bedding'] 	= $post['extra_bedding'];
			$insertCheckin['extra_bedding_price'] 	= $post['extra_bedding_price']*$post['extra_bedding'];
			$insertCheckin['booking_date'] 		= $booking->booking_date;
			$insertCheckin['flat_id'] 			= $flat_id;
			$insertCheckin['room_no'] 			= $room_no;
			$insertCheckin['room_type'] 		= $room_type;
			$insertCheckin['discount'] 			= $booking_items->discount*$nights;
			$insertCheckin['price'] 			= $booking_items->price;
			$insertCheckin['pre_checkin_amount'] = (@$post['pre_checkin_amount']) ? $post['pre_checkin_amount'] : 0;
			$insertCheckin['user_id'] 			= $booking->user_id;
			$insertCheckin['notes'] 			= @$booking->notes;
			$insertCheckin['purpose_of_trip'] 	= @$booking->purpose_of_trip;
			$insertCheckin['nationality'] 		= null;
			$insertCheckin['vehcleno'] 			= null;
			$insertCheckin['intime'] 			= $post['intime'];
			$insertCheckin['isactive'] 			= 1;
			$insertCheckin['uptime'] 			= $post['intime'];
			$insertCheckin['deviceid'] 			= null;
			$insertCheckin['os'] 				= null;
			$insertCheckin['sdkv'] 				= null;
			$insertCheckin['firebaseid'] 		= null;
			//update conditions
			//$count = $this->model->Counter('checkin', array('booking_id' => $booking->id,'booking_item_id'=>$post['booking_item']));
    
			
			$selectdatetime = $post['intime'];
			$StartDateTime = $booking->start_date . ' ' . $property_data->checkintime;
			$EndDateTime = $booking->end_date . ' ' . $property_data->checkouttime;
			
			$selectDateTimeObj = new DateTime($selectdatetime);
			$startDateTimeObj = new DateTime($StartDateTime);
			$endDateTimeObj = new DateTime($EndDateTime);
			
			if ($selectDateTimeObj < $startDateTimeObj || $selectDateTimeObj > $endDateTimeObj) {
				$return['res'] = 'error';
				$return['msg'] = 'Selected time must be within the booking start and end times.';
				echo json_encode($return);
				die();
			}

            //  check condition Total  > Remaining
			 $precheckinamount = (@$post['pre_checkin_amount']) ? $post['pre_checkin_amount'] : 0;
			 if( $precheckinamount > $post['total_remaining'])
			 {
				$return['res'] = 'error';
				$return['msg'] = '"Sorry pre checkin amount value not greater than total remaining amount.';
				echo json_encode($return);
				die();
			 }

			 $transaction1 = $this->model->getData('transaction',['is_deleted'=>'NOT_DELETED','booking_id'=>$booking->id]); 
				$transaction_total1=0;
				foreach($transaction1 as $tr1)
				{
				$transaction_total1 = $transaction_total1+$tr1->credit;
				}
				if(($transaction_total1+$precheckinamount) <= $booking->total)
				{

                }else{
					$return['res'] = 'error';
					$return['msg'] = 'Transaction amount exceeds the booking total.';
					echo json_encode($return);
				    die();
				}
			
		   		
			

			$count=0;
			// check record already exist
			 $update_check_in_id = $post['check_in_id'];
			if($update_check_in_id==''){
			if ($checkin_id = $this->model->Save('checkin', $insertCheckin)) {
				logs($user->id,$checkin_id,'ADD','Add Booking Checkin');
				$return['res'] = 'success';
				$return['msg'] = 'Saved.';


				$bookingDateArray = $this->between_dates($booking->start_date, $booking->end_date);
				foreach ($bookingDateArray as $d_key => $d_value) {
					$room_allotment['booking_id'] = $booking->id;
					$room_allotment['checkin_id'] = $checkin_id;
					$room_allotment['property_id'] = $booking->property_id;
					$room_allotment['room_type'] = $room_type;
					$room_allotment['flat_id'] = $flat_id;
					$room_allotment['flat_no'] = $room_no;
					$room_allotment['date'] = $d_value;
					$room_id=$this->model->Save('room_allotment', $room_allotment);
					logs($user->id,$room_id,'ADD','Add Booking Checkin Room Allotment');
		
				}
			// change status bookings
			$this->model->Update('booking_new',['checkin_status'=>'1'],['id'=>$booking->id]);
			logs($user->id,$booking->id,'CHANGE_STATUS','Change Booking Status 1');
			// Save pre checkin amount in transaction table
			if($precheckinamount > 0){
			$transaction=$this->model->Save('transaction', ['booking_id'=>$booking->id,'tr_date'=>date('Y-m-d'),'type'=>(@$post['payment_mode']) ? $post['payment_mode'] : 0,'reference_no'=>(@$post['reference_id']) ? $post['reference_id'] : 0,'credit'=>(@$post['pre_checkin_amount']) ? $post['pre_checkin_amount'] : 0,'remark'=>'Pre Checkin Amount','active'=>'1','action'=>'checkin','checkin_id'=>$checkin_id]);
			logs($user->id,$transaction,'ADD','Add Booking Transaction');
			}
			    }
	      	}else
 			{    
				//  get row checkin 
  				$rs = $this->model->getRow('checkin',['id' =>$update_check_in_id]);
				$checked_id = $rs->id;
				$transaction1 = $this->model->getData('transaction',['is_deleted'=>'NOT_DELETED','booking_id'=>$booking->id]); 
				$transaction_total1=0;
				foreach($transaction1 as $tr1)
				{
				$transaction_total1 = $transaction_total1+$tr1->credit;
				}
				if(($transaction_total1+$precheckinamount) <= $booking->total)
				{

                }else{
					$return['res'] = 'error';
					$return['msg'] = 'Transaction amount exceeds the booking total.';
					echo json_encode($return);
				    die();
				}
			
				if ($this->model->Update('checkin', $insertCheckin,['id'=>$update_check_in_id])) {
					logs($user->id,$update_check_in_id,'EDIT','Edit Booking Checkin');
					$return['res'] = 'success';
					$return['msg'] = 'Saved.';
	
	
					$bookingDateArray = $this->between_dates($booking->start_date, $booking->end_date);
					foreach ($bookingDateArray as $d_key => $d_value) {
						$room_allotment['booking_id'] = $booking->id;
						$room_allotment['checkin_id'] = $checked_id;
						$room_allotment['property_id'] = $booking->property_id;
						$room_allotment['room_type'] = $room_type;
						$room_allotment['flat_id'] = $flat_id;
						$room_allotment['flat_no'] = $room_no;
						$room_allotment['date'] = $d_value;
						$this->model->Update('room_allotment', $room_allotment,['checkin_id'=>$update_check_in_id,'booking_id'=>$booking->id]);
						logs($user->id,$update_check_in_id,'EDIT','Edit Booking Checkin Room Allotment By Checkin Id');
			
					}
								// change status bookings
								$this->model->Update('booking_new',['checkin_status'=>'1'],['id'=>$booking->id]);
								logs($user->id,$booking->id,'CHANGE_STATUS','Change Status Booking 1');
								// Save pre checkin amount in transaction table
								// if($precheckinamount > 0){
								$this->model->Update('transaction', ['booking_id'=>$booking->id,'tr_date'=>date('Y-m-d'),'type'=>(@$post['payment_mode']) ? $post['payment_mode'] : 0,'reference_no'=>(@$post['reference_id']) ? $post['reference_id'] : 0,'credit'=>(@$post['pre_checkin_amount']) ? $post['pre_checkin_amount'] : 0,'remark'=>'Pre Checkin Amount','active'=>'1','action'=>'checkin'],['checkin_id'=>$update_check_in_id]);
								logs($user->id,$booking->id,'EDIT','Edit Transaction by Booking ID');
								// }
					}
			}
			echo json_encode($return);
		} else {


			$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
			$data['booking_id'] = $booking_id;
			if($booking->status ==4){
				echo "<div class='text-danger text-center'>Booking Cancelled";
				echo '<input type="reset" class="btn btn-danger btn-sm mr-1 checkout-close checkin-close float-right" value="Back">';
				echo '</div>';
			}
			elseif ($booking->status ==1) {
				echo "<div class='text-danger text-center'>Booking Not Conformed!";
				echo '<input type="reset" class="btn btn-danger btn-sm mr-1 checkout-close checkin-close float-right" value="Back">';
				echo '</div>';
				// $booking->checkin_status != 0 already checkin condition
			}elseif ($booking->checkin_status = 0) {
				echo "<div class='text-danger text-center'>Already Checked In!</div>";
				echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkin-close" value="Back">';
			} else {
				$data['booking_items'] = $booking_items = $this->model->getData('booking_new_items', ['booking_id' => $booking_id,'property_id'=>$booking->property_id]);
				$bookingDateArray = $this->between_dates($booking->start_date, $booking->end_date);
				$roomTypeIds = array_map(function ($data) { 
					return $data->room_type;
				}, $booking_items);
				$roomTypeIds = array_unique($roomTypeIds);

				$roomTypes = $this->db->where_in('spt_id', $roomTypeIds)->get('sub_property_types')->result();
				// foreach($booking_items as $r){
				
				// }
				foreach ($roomTypes as $key => $value) {
					$where['propid'] = $booking->property_id;
					$where['s_p_type_id'] = $value->spt_id;
					$availability = $this->model->getRow('propmaster_s_p_availability', $where);
					// $value->capacity = $property->capacity;
					// $value->capacity = $property->capacity;

					// $where['propid'] = $booking->property_id;
					// $where['sub_property_type_id'] = $value->spt_id;
					// $where['flat_code_name !='] = NULL;

					$this->db->select('flat_id,flat_name,flat_code_name,flat_no');
					$this->db->where('mtb.propid', $booking->property_id);
					$this->db->where('mtb.sub_property_type_id', $value->spt_id);
					$this->db->where('mtb.flat_no !=', NULL);
					$this->db->order_by('mtb.flat_no','ASC');
					$this->db->from('property mtb');
					$total_rooms = $this->db->get()->result();

					foreach ($total_rooms as $rkey => $rvalue) {
						$this->db->select('id');
						$this->db->where('flat_id', $rvalue->flat_id);
						$this->db->where('is_checkout','0');
						// $this->db->where_in('date', $bookingDateArray);
						
						$rvalue->allotment_id = $this->db->get('room_allotment')->row();
					}

					$where_allotment['property_id'] = $booking->property_id;
					$where_allotment['room_type'] = $value->spt_id;
					$where_allotment['property_id'] = $booking->property_id;
					$this->db->select('COUNT(id) as room_alloted');
					$this->db->from('room_allotment');
					$this->db->where($where_allotment);
					// $this->db->where_in('date', $bookingDateArray);
					$room_alloted = $this->db->get()->row();

					$value->total = $availability->available;
					$value->available = (int)$availability->available - (int)$room_alloted->room_alloted;
					$value->booking = @array_map(function ($data) use ($value) {
						if ($value->spt_id == $data->room_type) {
							return $data->qty;
						}
					}, $booking_items)[0];
					$value->rooms = $total_rooms;
				}
				// prx(['roomTypes' => $roomTypes]);
				// prx(['roomTypes' => $roomTypes]);
				//prx(['checkedInRooms' => $checkedInRooms]);
				// prx($roomTypeIds);
				// prx($bookingDateArray);
				// $this->pr($data['booking_items']);transaction
				$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
				$data['checkin'] = $checkin = $this->model->getRow('checkin', ['booking_id' => $booking_id]);
				$data['transaction'] = $this->model->getData('transaction', ['is_deleted'=>'NOT_DELETED','booking_id'=>$booking_id]);
				$totalprice=0;
				foreach($data['transaction'] as $t)
				{
                     $totalprice = $totalprice+$t->credit;
				}
				$data['checkout_new'] = $this->model->getData('checkout_new', ['booking_id'=>$booking_id]);
				$Tfood_amount = $Tother_amount = $Tlump_sum_discount =0;
				foreach($data['checkout_new'] as $check)
				{
                     $Tfood_amount = $Tfood_amount+$check->food_amount;
					 $Tother_amount = $Tother_amount+$check->other_amount;
					 $Tlump_sum_discount = $Tlump_sum_discount+$check->lump_sum_discount;
				}
				$data['othercharges'] = ($Tfood_amount+$Tother_amount) -$Tlump_sum_discount;
				$data['totalpayout'] = $booking->total;
				// $data['totalreceived'] = $totalprice+$this->FindPreCheckin($booking_id);
				$data['totalreceived'] = $totalprice;
				$data['items']	= $this->model->getRow('booking_new_items', ['booking_id' => $booking_id]);
				$data['guest_count'] 	= @$booking->of_adults;
				
				$data['roomTypes']  		= $roomTypes;
				// $data['checkedInRooms']  		= (@$checkedInRooms) ? $checkedInRooms : [];
				$data['payment_mode'] = $this->model->getData('payment_mode', ['status' => 1]);
				$data['content']  		= 'reservations/checkin';
				load_view($data['content'], $data);
			}
		}
		// $this->pr($data);
	}


	public function checkin_new($booking_id)
	{
		$data['user'] = $user  = $this->checkLogin();
		// echo $booking_id;
		
		if (@$_POST['room_no']) {
			$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
			// check user property assign or not
            $existprop  = $this->validate_user_property($user->id,$booking->property_id);
			if($existprop==0)
			{
			$return['res'] 		  	 = 'error';
		    $return['msg'] 		  	 = 'Please select valid property !';
			echo json_encode($return);
			die();
			}
			// prx($_POST);die();

			if(empty($_POST['payment_mode']))
			{
			$return['res'] 		  	 = 'error';
		    $return['msg'] 		  	 = 'Please select payment mode !';
			echo json_encode($return);
			die();
			}
			
			$insertCheckin = array();

			$_POST['intime'] = date('Y-m-d H:i:s', strtotime($_POST['intime']));
			$_POST['check_time'] = date('h:i:s', strtotime($_POST['intime']));

			if (!@$_POST['room_no']) {
				$return['res'] = 'error';
				$return['msg'] = 'No room selected!';
				echo json_encode($return);
				die();
			}
			$ra_value = explode('-', $_POST['room_no']);

			$room_type = $ra_value[0];
			$flat_id = $ra_value[1];
			$room_no = $ra_value[2];
			$bi_cond = ['booking_id' => $booking_id, 'room_type' => $room_type];

			$data['booking_items'] = $booking_items = $this->model->getRow('booking_new_items', $bi_cond);
			$property_data = $this->model->getRow('propmaster',['id'=>$booking->property_id]);
			$post = $this->input->post();
			if ($booking->start_date && $booking->end_date) {
				$date = $this->between_dates($booking->start_date, $booking->end_date);
				$nights = ((@$date) ? count($date) : 1);
			}
			$insertCheckin['visitors_type'] 	= '';
			$insertCheckin['booking_id'] 		= $booking->id;
			$insertCheckin['guest_id'] 			= $booking->guest_id;
			$insertCheckin['guest_name'] 		= $booking->guest_name;
			$insertCheckin['pic'] 				= 'null';
			$insertCheckin['contact'] 			= $booking->contact;
			$insertCheckin['address'] 			= 'null';
			$insertCheckin['of_adults'] 		= $post['adults'];
			$insertCheckin['of_children'] 		= $post['children'];
			$insertCheckin['of_infant'] 		= $post['infants'];
			$insertCheckin['start_date'] 		= $booking->start_date;
			$insertCheckin['end_date'] 			= $booking->end_date;
			$insertCheckin['check_time'] 		= $post['check_time'];
			$insertCheckin['extra_bedding'] 	= $post['extra_bedding'];
			$insertCheckin['extra_bedding_price'] 	= $post['extra_bedding_price']*$post['extra_bedding'];
			$insertCheckin['booking_date'] 		= $booking->booking_date;
			$insertCheckin['flat_id'] 			= $flat_id;
			$insertCheckin['room_no'] 			= $room_no;
			$insertCheckin['room_type'] 		= $room_type;
			$insertCheckin['discount'] 			= $booking_items->discount*$nights;
			$insertCheckin['price'] 			= $booking_items->price;
			$insertCheckin['pre_checkin_amount'] = (@$post['pre_checkin_amount']) ? $post['pre_checkin_amount'] : 0;
			$insertCheckin['user_id'] 			= $booking->user_id;
			$insertCheckin['notes'] 			= @$booking->notes;
			$insertCheckin['purpose_of_trip'] 	= @$booking->purpose_of_trip;
			$insertCheckin['nationality'] 		= null;
			$insertCheckin['vehcleno'] 			= null;
			$insertCheckin['intime'] 			= $post['intime'];
			$insertCheckin['isactive'] 			= 1;
			$insertCheckin['uptime'] 			= $post['intime'];
			$insertCheckin['deviceid'] 			= null;
			$insertCheckin['os'] 				= null;
			$insertCheckin['sdkv'] 				= null;
			$insertCheckin['firebaseid'] 		= null;
			//update conditions
			
			$selectdatetime = $post['intime'];
			$StartDateTime = $booking->start_date . ' ' . $property_data->checkintime;
			$EndDateTime = $booking->end_date . ' ' . $property_data->checkouttime;
			
			$selectDateTimeObj = new DateTime($selectdatetime);
			$startDateTimeObj = new DateTime($StartDateTime);
			$endDateTimeObj = new DateTime($EndDateTime);
			
			if ($selectDateTimeObj < $startDateTimeObj || $selectDateTimeObj > $endDateTimeObj) {
				$return['res'] = 'error';
				$return['msg'] = 'Selected time must be within the booking start and end times.';
				echo json_encode($return);
				die();
			}

            //  check condition Total  > Remaining
			 $precheckinamount = (@$post['pre_checkin_amount']) ? $post['pre_checkin_amount'] : 0;
			 if( $precheckinamount > $post['total_remaining'])
			 {
				$return['res'] = 'error';
				$return['msg'] = '"Sorry pre checkin amount value not greater than total remaining amount.';
				echo json_encode($return);
				die();
			 }

			 $transaction1 = $this->model->getData('transaction',['is_deleted'=>'NOT_DELETED','booking_id'=>$booking->id]); 
				$transaction_total1=0;
				foreach($transaction1 as $tr1)
				{
				$transaction_total1 = $transaction_total1+$tr1->credit;
				}
				if(($transaction_total1+$precheckinamount) <= $booking->total)
				{

                }else{
					$return['res'] = 'error';
					$return['msg'] = 'Transaction amount exceeds the booking total.';
					echo json_encode($return);
				    die();
				}
			
		   		
			

			$count=0;
			// check record already exist
			 $update_check_in_id = $post['check_in_id'];
			if($update_check_in_id===''){
			if ($checkin_id = $this->model->Save('checkin', $insertCheckin)) {
				logs($user->id,$checkin_id,'ADD','Add Booking Checkin');


				$bookingDateArray = $this->between_dates($booking->start_date, $booking->end_date);
				foreach ($bookingDateArray as $d_key => $d_value) {
					$room_allotment['booking_id'] = $booking->id;
					$room_allotment['checkin_id'] = $checkin_id;
					$room_allotment['property_id'] = $booking->property_id;
					$room_allotment['room_type'] = $room_type;
					$room_allotment['flat_id'] = $flat_id;
					$room_allotment['flat_no'] = $room_no;
					$room_allotment['date'] = $d_value;
					$room_id=$this->model->Save('room_allotment', $room_allotment);
					logs($user->id,$room_id,'ADD','Add Booking Checkin Room Allotment');
		
				}
							// change status bookings
							$this->model->Update('booking_new',['checkin_status'=>'1'],['id'=>$booking->id]);
							logs($user->id,$booking->id,'CHANGE_STATUS','Change Booking Status 1');
							if($precheckinamount > 0){
							 $transaction=$this->model->Save('transaction', ['booking_id'=>$booking->id,'tr_date'=>date('Y-m-d'),'type'=>(@$post['payment_mode']) ? $post['payment_mode'] : 0,'reference_no'=>(@$post['reference_id']) ? $post['reference_id'] : 0,'credit'=>(@$post['pre_checkin_amount']) ? $post['pre_checkin_amount'] : 0,'remark'=>'Pre Checkin Amount','active'=>'1','action'=>'checkin','checkin_id'=>$checkin_id]);
							 logs($user->id,$transaction,'ADD','Add Booking Transaction');
							}


                  // Insert Guest Details
				  // check user property assign or not
				  $data['checkin'] = $checkin = $this->model->getRow('checkin', $checkin_id);
					$existprop  = $this->validate_user_property($user->id,$booking->property_id);
					if($existprop==0)
					{
					$return['res'] 		  	 = 'error';
					$return['msg'] 		  	 = 'Please select valid property !';
					echo json_encode($return);
					die();
					}
					if (@$_POST['total_person']) {
						// check already submit guest details
						$insertArray = [];
						$files = $_FILES;
						$directory = UPLOAD_PATH . 'reservations/';
						foreach ($_POST['total_person'] as $key => $value) {
							if (@$value) {
								$insertArrayTmp['booking_id'] = $checkin->booking_id;
								$insertArrayTmp['checkin_id'] = $checkin_id;
								$insertArrayTmp['name'] = $_POST['name'][$key];
								$insertArrayTmp['type'] = $_POST['type'][$key];
								$insertArrayTmp['nationality'] = $_POST['nationality'][$key];
								$insertArrayTmp['id_proof_type'] = $_POST['id_proof_type'][$key];
								$insertArrayTmp['id_proof_no'] = $_POST['id_proof_no'][$key];
								$insertArrayTmp['contact'] = $_POST['contact'][$key];
								$insertArrayTmp['email'] = $_POST['email'][$key];
								$insertArrayTmp['address'] = $_POST['address'][$key];
								$insertArrayTmp['coming'] = $_POST['coming'][$key];
								$insertArrayTmp['going'] = $_POST['going'][$key];
								$insertArrayTmp['guest_row_count'] = $_POST['guest_row_count'][$key];
								$insertArrayTmp['id']    = $_POST['id'][$key];
								if(!empty($_POST['id'][$key]))
								{
									$guest_id  = $_POST['id'][$key];
								//  get images check_in_guest
								$images = $this->model->getRow('check_in_guests',['id'=>$guest_id,'booking_id'=> $checkin->booking_id,'checkin_id'=> $checkin_id]);
								}else
								{
									$guest_id='';
								}
								
							
								
								$id_proof_pic_front = 'reservations/default_thumb.webp';
								if (@$_FILES['id_proof_pic_front']['name'][$key]) {
									$_FILES['userfile']['name']     = $files['id_proof_pic_front']['name'][$key];
									$_FILES['userfile']['type']     = $files['id_proof_pic_front']['type'][$key];
									$_FILES['userfile']['tmp_name'] = $files['id_proof_pic_front']['tmp_name'][$key];
									$_FILES['userfile']['error']    = $files['id_proof_pic_front']['error'][$key];
									$_FILES['userfile']['size']     = $files['id_proof_pic_front']['size'][$key];
									$config['upload_path'] 			= $directory;
									$config['allowed_types'] 		= '*';
									$config['remove_spaces']        = TRUE;
									$config['encrypt_name']         = TRUE;
									$config['max_filename']         = 20;
									$config['max_size']    			= '100';
									$this->load->library('upload', $config);
									if ($this->upload->do_upload('userfile')) {
										$upload_data = $this->upload->data();
										$id_proof_pic_front = 'reservations/' . $upload_data['file_name'];
									}
									else{
										$error = $this->upload->display_errors();
									$return['res'] = 'error';
									$return['msg'] = $error;
									}
								}
								if(!empty($id_proof_pic_front))
								{
									$insertArrayTmp['id_proof_pic_front'] = $id_proof_pic_front;
								}else
								{
									$insertArrayTmp['id_proof_pic_front'] = @$images->id_proof_pic_front ?@$images->id_proof_pic_front : 'reservations/default_thumb.webp';
								}
								
								
								$id_proof_pic_back = 'reservations/default_thumb.webp';
								if (@$_FILES['id_proof_pic_back']['name'][$key]) {
									$_FILES['userfile']['name']     = $files['id_proof_pic_back']['name'][$key];
									$_FILES['userfile']['type']     = $files['id_proof_pic_back']['type'][$key];
									$_FILES['userfile']['tmp_name'] = $files['id_proof_pic_back']['tmp_name'][$key];
									$_FILES['userfile']['error']    = $files['id_proof_pic_back']['error'][$key];
									$_FILES['userfile']['size']     = $files['id_proof_pic_back']['size'][$key];
									$config['upload_path'] 			= $directory;
									$config['allowed_types'] 		= '*';
									$config['remove_spaces']        = TRUE;
									$config['encrypt_name']         = TRUE;
									$config['max_filename']         = 20;
									$config['max_size']    			= '100';
									$this->load->library('upload', $config);
									if ($this->upload->do_upload('userfile')) {
										$upload_data = $this->upload->data();
										$id_proof_pic_back = 'reservations/' . $upload_data['file_name'];
									}
									else{
										$error = $this->upload->display_errors();
									$return['res'] = 'error';
									$return['msg'] = $error;
									}
								}
								if(!empty($id_proof_pic_back))
								{
									$insertArrayTmp['id_proof_pic_back'] = $id_proof_pic_back;
								}else
								{
									$insertArrayTmp['id_proof_pic_back'] = @$images->id_proof_pic_back ?@$images->id_proof_pic_back : 'reservations/default_thumb.webp';
								}

								$agrement_doc = 'reservations/default_thumb.webp';
								if (@$_FILES['agrement_doc']['name'][$key]) {
									$_FILES['userfile']['name']     = $files['agrement_doc']['name'][$key];
									$_FILES['userfile']['type']     = $files['agrement_doc']['type'][$key];
									$_FILES['userfile']['tmp_name'] = $files['agrement_doc']['tmp_name'][$key];
									$_FILES['userfile']['error']    = $files['agrement_doc']['error'][$key];
									$_FILES['userfile']['size']     = $files['agrement_doc']['size'][$key];
									$config['upload_path'] 			= $directory;
									$config['allowed_types'] 		= '*';
									$config['remove_spaces']        = TRUE;
									$config['encrypt_name']         = TRUE;
									$config['max_filename']         = 20;
									$config['max_size']    			= '100';
									$this->load->library('upload', $config);
									if ($this->upload->do_upload('userfile')) {
										$upload_data = $this->upload->data();
										$agrement_doc = 'reservations/' . $upload_data['file_name'];
									}
									else{
										$error = $this->upload->display_errors();
									$return['res'] = 'error';
									$return['msg'] = $error;
									}
								}
								if(!empty($agrement_doc))
								{
									$insertArrayTmp['agreement_doc'] = $agrement_doc;
								}else
								{
									$insertArrayTmp['agreement_doc'] = @$images->agreement_doc ?@$images->agreement_doc : 'reservations/default_thumb.webp';
								}

								$guest_photo = '';
								if (@$_FILES['guest_photo']['name'][$key]) {
									$_FILES['userfile']['name']     = $files['guest_photo']['name'][$key];
									$_FILES['userfile']['type']     = $files['guest_photo']['type'][$key];
									$_FILES['userfile']['tmp_name'] = $files['guest_photo']['tmp_name'][$key];
									$_FILES['userfile']['error']    = $files['guest_photo']['error'][$key];
									$_FILES['userfile']['size']     = $files['guest_photo']['size'][$key];
									$config['upload_path'] 			= $directory;
									$config['allowed_types'] 		= '*';
									$config['remove_spaces']        = TRUE;
									$config['encrypt_name']         = TRUE;
									$config['max_filename']         = 20;
									$config['max_size']    			= '100';
									$this->load->library('upload', $config);
									if ($this->upload->do_upload('userfile')) {
										$upload_data = $this->upload->data();
										$guest_photo = 'reservations/' . $upload_data['file_name'];
									}
									else{
										$error = $this->upload->display_errors();
									$return['res'] = 'error';
									$return['msg'] = $error;
									}
								}
								if(!empty($guest_photo))
								{
									$insertArrayTmp['guest_photo'] = $guest_photo;
								}else
								{
									$insertArrayTmp['guest_photo'] = @$images->guest_photo ?@$images->guest_photo : 'reservations/default_thumb.webp';
								}

								$insertArray[] = $insertArrayTmp;
							}

						}
						// end foreach
						$guest_count_row  = array( 'id'=>$guest_id,'booking_id'=>$checkin->booking_id,'checkin_id'=>$checkin->id,);
						$count = $this->model->find_guest_count($guest_count_row);
						if($count==0){
						if (@$insertArray) {
							foreach ($insertArray as $data) {
								$this->db->insert('check_in_guests', $data);
								$insertedId = $this->db->insert_id();
								logs($user->id,$insertedId,'ADD','Add Checkin Guest');
							}
						//   $this->db->insert_batch('check_in_guests', $insertArray);
						
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
						}
						}else
						{
						if (@$insertArray) {
						//   $this->db->where(['guest_row_count'=>$guest_count,'checkin_id'=>$checkin->id,'booking_id'=>$checkin->booking_id]);
						$this->db->update_batch('check_in_guests', $insertArray,'id');
						$updatedIds = array_column($insertArray, 'id');
						foreach($updatedIds as $updatedID )
						{
							logs($user->id,$updatedID,'EDIT','Edit Checkin Guest');
						}
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
						}
					}
						

						// echo json_encode($return);
					} 
			    }
	      	}else
 			{    
				//  get row checkin 
  				$rs = $this->model->getRow('checkin',['id' =>$update_check_in_id]);
				$checked_id = $rs->id;
				$transaction1 = $this->model->getData('transaction',['is_deleted'=>'NOT_DELETED','booking_id'=>$booking->id]); 
				$transaction_total1=0;
				foreach($transaction1 as $tr1)
				{
				$transaction_total1 = $transaction_total1+$tr1->credit;
				}
				if(($transaction_total1+$precheckinamount) <= $booking->total)
				{

                }else{
					$return['res'] = 'error';
					$return['msg'] = 'Transaction amount exceeds the booking total.';
					echo json_encode($return);
				    die();
				}
			
				if ($this->model->Update('checkin', $insertCheckin,['id'=>$update_check_in_id])) {
					logs($user->id,$update_check_in_id,'EDIT','Edit Booking Checkin');
					$return['res'] = 'success';
					$return['msg'] = 'Saved.';
	
	
					$bookingDateArray = $this->between_dates($booking->start_date, $booking->end_date);
					foreach ($bookingDateArray as $d_key => $d_value) {
						$room_allotment['booking_id'] = $booking->id;
						$room_allotment['checkin_id'] = $checked_id;
						$room_allotment['property_id'] = $booking->property_id;
						$room_allotment['room_type'] = $room_type;
						$room_allotment['flat_id'] = $flat_id;
						$room_allotment['flat_no'] = $room_no;
						$room_allotment['date'] = $d_value;
						$this->model->Update('room_allotment', $room_allotment,['checkin_id'=>$update_check_in_id,'booking_id'=>$booking->id]);
						logs($user->id,$update_check_in_id,'EDIT','Edit Booking Checkin Room Allotment By Checkin Id');
			
					}
								// change status bookings
								$this->model->Update('booking_new',['checkin_status'=>'1'],['id'=>$booking->id]);
								logs($user->id,$booking->id,'CHANGE_STATUS','Change Status Booking 1');
								// Save pre checkin amount in transaction table
								if($precheckinamount > 0){
								$this->model->Update('transaction', ['booking_id'=>$booking->id,'tr_date'=>date('Y-m-d'),'type'=>(@$post['payment_mode']) ? $post['payment_mode'] : 0,'reference_no'=>(@$post['reference_id']) ? $post['reference_id'] : 0,'credit'=>(@$post['pre_checkin_amount']) ? $post['pre_checkin_amount'] : 0,'remark'=>'Pre Checkin Amount','active'=>'1','action'=>'checkin'],['action'=>'checkin','checkin_id'=>$update_check_in_id]);
								logs($user->id,$booking->id,'EDIT','Edit Transaction by Booking ID');
								}
					}
			}
			echo json_encode($return);
		} else {


			$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
			$data['booking_id'] = $booking_id;
			if($booking->status ==4){
				echo "<div class='text-danger text-center'>Booking Cancelled";
				echo '<input type="reset" class="btn btn-danger btn-sm mr-1 checkout-close checkin-close float-right" value="Back">';
				echo '</div>';
			}
			elseif ($booking->status ==1) {
				echo "<div class='text-danger text-center'>Booking Not Conformed!";
				echo '<input type="reset" class="btn btn-danger btn-sm mr-1 checkout-close checkin-close float-right" value="Back">';
				echo '</div>';
				// $booking->checkin_status != 0 already checkin condition
			}elseif ($booking->checkin_status = 0) {
				echo "<div class='text-danger text-center'>Already Checked In!</div>";
				echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkin-close" value="Back">';
			} else {
				$data['booking_items'] = $booking_items = $this->model->getData('booking_new_items', ['booking_id' => $booking_id,'property_id'=>$booking->property_id]);
				$bookingDateArray = $this->between_dates($booking->start_date, $booking->end_date);
				$roomTypeIds = array_map(function ($data) { 
					return $data->room_type;
				}, $booking_items);
				$roomTypeIds = array_unique($roomTypeIds);

				$roomTypes = $this->db->where_in('spt_id', $roomTypeIds)->get('sub_property_types')->result();
				// foreach($booking_items as $r){
				
				// }
				foreach ($roomTypes as $key => $value) {
					$where['propid'] = $booking->property_id;
					$where['s_p_type_id'] = $value->spt_id;
					$availability = $this->model->getRow('propmaster_s_p_availability', $where);
					// $value->capacity = $property->capacity;
					// $value->capacity = $property->capacity;

					// $where['propid'] = $booking->property_id;
					// $where['sub_property_type_id'] = $value->spt_id;
					// $where['flat_code_name !='] = NULL;

					$this->db->select('flat_id,flat_name,flat_code_name,flat_no');
					$this->db->where('mtb.propid', $booking->property_id);
					$this->db->where('mtb.sub_property_type_id', $value->spt_id);
					$this->db->where('mtb.flat_no !=', NULL);
					$this->db->order_by('mtb.flat_no','ASC');
					$this->db->from('property mtb');
					$total_rooms = $this->db->get()->result();

					foreach ($total_rooms as $rkey => $rvalue) {
						$this->db->select('id');
						$this->db->where('flat_id', $rvalue->flat_id);
						$this->db->where_in('date', $bookingDateArray);
						$rvalue->allotment_id = $this->db->get('room_allotment')->row();
					}

					$where_allotment['property_id'] = $booking->property_id;
					$where_allotment['room_type'] = $value->spt_id;
					$where_allotment['property_id'] = $booking->property_id;
					$this->db->select('COUNT(id) as room_alloted');
					$this->db->from('room_allotment');
					$this->db->where($where_allotment);
					$this->db->where_in('date', $bookingDateArray);
					$room_alloted = $this->db->get()->row();

					$value->total = $availability->available;
					$value->available = (int)$availability->available - (int)$room_alloted->room_alloted;
					$value->booking = @array_map(function ($data) use ($value) {
						if ($value->spt_id == $data->room_type) {
							return $data->qty;
						}
					}, $booking_items)[0];
					$value->rooms = $total_rooms;
				}
				$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
				$data['checkin'] = $checkin = $this->model->getRow('checkin', ['booking_id' => $booking_id]);
				$data['transaction'] = $this->model->getData('transaction', ['is_deleted'=>'NOT_DELETED','booking_id'=>$booking_id]);
				$totalprice=0;
				foreach($data['transaction'] as $t)
				{
                     $totalprice = $totalprice+$t->credit;
				}
				$data['checkout_new'] = $this->model->getData('checkout_new', ['booking_id'=>$booking_id]);
				$Tfood_amount = $Tother_amount = $Tlump_sum_discount =0;
				foreach($data['checkout_new'] as $check)
				{
                     $Tfood_amount = $Tfood_amount+$check->food_amount;
					 $Tother_amount = $Tother_amount+$check->other_amount;
					 $Tlump_sum_discount = $Tlump_sum_discount+$check->lump_sum_discount;
				}
				$data['othercharges'] = ($Tfood_amount+$Tother_amount) -$Tlump_sum_discount;
				$data['totalpayout'] = $booking->total;
				// $data['totalreceived'] = $totalprice+$this->FindPreCheckin($booking_id);
				$data['totalreceived'] = $totalprice;
				$data['items']	= $this->model->getRow('booking_new_items', ['booking_id' => $booking_id]);
				$data['guest_count'] 	= @$booking->of_adults;
				$data['roomTypes']  		= $roomTypes;
				// $data['checkedInRooms']  		= (@$checkedInRooms) ? $checkedInRooms : [];
				$data['payment_mode'] = $this->model->getData('payment_mode', ['status' => 1]);
				$data['content']  		= 'reservations/checkin';
				load_view($data['content'], $data);
			}
		}
		// $this->pr($data);
	}

	function detailes($id)
	{

		// $data['row'] = $row = $this->model->getRow('booking', ['id' => $id]);
		// $data['property']   = $property  = $this->model->getRow('property', ['flat_id' => $row->flat_id]);
		// $data['property']   = $property  = $this->model->getRow('property', ['flat_id' => $row->flat_id]);
		// $data['propmaster'] = $this->model->getRow('propmaster', ['id' => $property->propid]);
		// $data['agent'] = $this->model->getRow('agent', ['id' => $row->agent_id]);
		// $data['document'] = $this->model->getData('checkindoc', ['booking_id' => $row->id]);
		// $data['contant'] 	= 'reservations/detailes';

		$data['row'] = $row = $this->booking_detailes($id);
		$data['property']   = $property  = $this->property_detailes(@$row->flat_id);
		$data['propmaster'] = $this->propmaster_detailes($row->property_id);
		$data['agent'] = $this->model->getRow('agent', ['id' => $row->agent]);
		//$data['document'] = $this->model->getData('checkindoc', ['booking_id' => $row->id]);
		$data['document'] = $this->model->getData('check_in_guests', ['booking_id' => $row->id]);
		$data['items']	= $this->model->booking_new_items($id);
		$data['content'] 	= 'reservations/detailes';

		// $this->pr($data);
		// echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkin-close" value="Back">';
		$data['check_out_url'] = base_url() . 'checkout/';
		$data['check_pre_out_url'] = base_url() . 'pre-check-out/';
		load_view($data['content'], $data);
	}

	function checkin_guests_details($checkin_id)
	{
		$data['user'] = $user  = $this->checkLogin();
		$data['checkin'] = $checkin = $this->model->getRow('checkin', $checkin_id);
		$data['booking'] = $booking = $this->model->getRow('booking_new', $checkin->booking_id);
		// check user property assign or not
		$existprop  = $this->validate_user_property($user->id,$booking->property_id);
		if($existprop==0)
		{
		$return['res'] 		  	 = 'error';
		$return['msg'] 		  	 = 'Please select valid property !';
		echo json_encode($return);
		die();
		}
		if (@$_POST['total_person']) {
			// check already submit guest details
			$insertArray = [];
			$files = $_FILES;
			$directory = UPLOAD_PATH . 'reservations/';
			foreach ($_POST['total_person'] as $key => $value) {
				if (@$value) {
					$insertArrayTmp['booking_id'] = $checkin->booking_id;
					$insertArrayTmp['checkin_id'] = $checkin_id;
					$insertArrayTmp['name'] = $_POST['name'][$key];
					$insertArrayTmp['type'] = $_POST['type'][$key];
					$insertArrayTmp['nationality'] = $_POST['nationality'][$key];
					$insertArrayTmp['id_proof_type'] = $_POST['id_proof_type'][$key];
					$insertArrayTmp['id_proof_no'] = $_POST['id_proof_no'][$key];
					$insertArrayTmp['contact'] = $_POST['contact'][$key];
					$insertArrayTmp['email'] = $_POST['email'][$key];
					$insertArrayTmp['address'] = $_POST['address'][$key];
					$insertArrayTmp['coming'] = $_POST['coming'][$key];
					$insertArrayTmp['going'] = $_POST['going'][$key];
					$insertArrayTmp['guest_row_count'] = $_POST['guest_row_count'][$key];
					$insertArrayTmp['id']    = $_POST['id'][$key];
					 if(!empty($_POST['id'][$key]))
					 {
						$guest_id  = $_POST['id'][$key];
					//  get images check_in_guest
					$images = $this->model->getRow('check_in_guests',['id'=>$guest_id,'booking_id'=> $checkin->booking_id,'checkin_id'=> $checkin_id]);
					 }else
					 {
						$guest_id='';
					 }
					 
				
                    
					$id_proof_pic_front = '';
					if (@$_FILES['id_proof_pic_front']['name'][$key]) {
						$_FILES['userfile']['name']     = $files['id_proof_pic_front']['name'][$key];
						$_FILES['userfile']['type']     = $files['id_proof_pic_front']['type'][$key];
						$_FILES['userfile']['tmp_name'] = $files['id_proof_pic_front']['tmp_name'][$key];
						$_FILES['userfile']['error']    = $files['id_proof_pic_front']['error'][$key];
						$_FILES['userfile']['size']     = $files['id_proof_pic_front']['size'][$key];
						$config['upload_path'] 			= $directory;
						$config['allowed_types'] 		= '*';
						$config['remove_spaces']        = TRUE;
						$config['encrypt_name']         = TRUE;
						$config['max_filename']         = 20;
						$config['max_size']    			= '100';
						$this->load->library('upload', $config);
						if ($this->upload->do_upload('userfile')) {
							$upload_data = $this->upload->data();
							$id_proof_pic_front = 'reservations/' . $upload_data['file_name'];
						}
						else{
							$error = $this->upload->display_errors();
						   $return['res'] = 'error';
						   $return['msg'] = $error;
						}
					}
					if(!empty($id_proof_pic_front))
					{
						$insertArrayTmp['id_proof_pic_front'] = $id_proof_pic_front;
					}else
					{
						$insertArrayTmp['id_proof_pic_front'] = @$images->id_proof_pic_front;
					}
					
					
					$id_proof_pic_back = '';
					if (@$_FILES['id_proof_pic_back']['name'][$key]) {
						$_FILES['userfile']['name']     = $files['id_proof_pic_back']['name'][$key];
						$_FILES['userfile']['type']     = $files['id_proof_pic_back']['type'][$key];
						$_FILES['userfile']['tmp_name'] = $files['id_proof_pic_back']['tmp_name'][$key];
						$_FILES['userfile']['error']    = $files['id_proof_pic_back']['error'][$key];
						$_FILES['userfile']['size']     = $files['id_proof_pic_back']['size'][$key];
						$config['upload_path'] 			= $directory;
						$config['allowed_types'] 		= '*';
						$config['remove_spaces']        = TRUE;
						$config['encrypt_name']         = TRUE;
						$config['max_filename']         = 20;
						$config['max_size']    			= '100';
						$this->load->library('upload', $config);
						if ($this->upload->do_upload('userfile')) {
							$upload_data = $this->upload->data();
							$id_proof_pic_back = 'reservations/' . $upload_data['file_name'];
						}
						else{
							$error = $this->upload->display_errors();
						   $return['res'] = 'error';
						   $return['msg'] = $error;
						}
					}
					if(!empty($id_proof_pic_back))
					{
						$insertArrayTmp['id_proof_pic_back'] = $id_proof_pic_back;
					}else
					{
						$insertArrayTmp['id_proof_pic_back'] = @$images->id_proof_pic_back;
					}

					$agrement_doc = '';
					if (@$_FILES['agrement_doc']['name'][$key]) {
						$_FILES['userfile']['name']     = $files['agrement_doc']['name'][$key];
						$_FILES['userfile']['type']     = $files['agrement_doc']['type'][$key];
						$_FILES['userfile']['tmp_name'] = $files['agrement_doc']['tmp_name'][$key];
						$_FILES['userfile']['error']    = $files['agrement_doc']['error'][$key];
						$_FILES['userfile']['size']     = $files['agrement_doc']['size'][$key];
						$config['upload_path'] 			= $directory;
						$config['allowed_types'] 		= '*';
						$config['remove_spaces']        = TRUE;
						$config['encrypt_name']         = TRUE;
						$config['max_filename']         = 20;
						$config['max_size']    			= '100';
						$this->load->library('upload', $config);
						if ($this->upload->do_upload('userfile')) {
							$upload_data = $this->upload->data();
							$agrement_doc = 'reservations/' . $upload_data['file_name'];
						}
						else{
							$error = $this->upload->display_errors();
						   $return['res'] = 'error';
						   $return['msg'] = $error;
						}
					}
					if(!empty($agrement_doc))
					{
						$insertArrayTmp['agreement_doc'] = $agrement_doc;
					}else
					{
						$insertArrayTmp['agreement_doc'] = @$images->agreement_doc;
					}

					$guest_photo = '';
					if (@$_FILES['guest_photo']['name'][$key]) {
						$_FILES['userfile']['name']     = $files['guest_photo']['name'][$key];
						$_FILES['userfile']['type']     = $files['guest_photo']['type'][$key];
						$_FILES['userfile']['tmp_name'] = $files['guest_photo']['tmp_name'][$key];
						$_FILES['userfile']['error']    = $files['guest_photo']['error'][$key];
						$_FILES['userfile']['size']     = $files['guest_photo']['size'][$key];
						$config['upload_path'] 			= $directory;
						$config['allowed_types'] 		= '*';
						$config['remove_spaces']        = TRUE;
						$config['encrypt_name']         = TRUE;
						$config['max_filename']         = 20;
						$config['max_size']    			= '100';
						$this->load->library('upload', $config);
						if ($this->upload->do_upload('userfile')) {
							$upload_data = $this->upload->data();
							$guest_photo = 'reservations/' . $upload_data['file_name'];
						}
						else{
							$error = $this->upload->display_errors();
						   $return['res'] = 'error';
						   $return['msg'] = $error;
						}
					}
					if(!empty($guest_photo))
					{
						$insertArrayTmp['guest_photo'] = $guest_photo;
					}else
					{
						$insertArrayTmp['guest_photo'] = @$images->guest_photo;
					}

					$insertArray[] = $insertArrayTmp;
				}

			}
			// end foreach
			$guest_count_row  = array( 'id'=>$guest_id,'booking_id'=>$checkin->booking_id,'checkin_id'=>$checkin->id,);
			$count = $this->model->find_guest_count($guest_count_row);
			if($count==0){
			if (@$insertArray) {
				foreach ($insertArray as $data) {
					$this->db->insert('check_in_guests', $data);
					$insertedId = $this->db->insert_id();
					logs($user->id,$insertedId,'ADD','Add Checkin Guest');
				}
			//   $this->db->insert_batch('check_in_guests', $insertArray);
			 
			  $return['res'] = 'success';
			  $return['msg'] = 'Saved.';
			  }
			}else
			{
			if (@$insertArray) {
			//   $this->db->where(['guest_row_count'=>$guest_count,'checkin_id'=>$checkin->id,'booking_id'=>$checkin->booking_id]);
			  $this->db->update_batch('check_in_guests', $insertArray,'id');
			  $updatedIds = array_column($insertArray, 'id');
			  foreach($updatedIds as $updatedID )
			  {
				logs($user->id,$updatedID,'EDIT','Edit Checkin Guest');
			  }
			  $return['res'] = 'success';
			  $return['msg'] = 'Saved.';
			 }
		  }
			

			echo json_encode($return);
		} else {
			// echo $checkin_id;
			$data['title'] = 'Guests';

			$data['action_url'] = base_url('checkin-guests-details/' . $checkin_id);
			$booking_id = $checkin->booking_id;
			$data['booking_id'] = $booking_id;
			$data['checkin_id'] = $checkin_id;
			$data['total_persons'] = $checkin->of_adults+$checkin->of_children+$checkin->of_infant;
			// prx($checkin);
			$data['content'] 	= 'reservations/checkin_guests_details';
			$this->template($data);
		}
	}

}
