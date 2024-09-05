<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Main.php');
class Checkout extends Main
{

	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function index($booking_id)
	{ 
		// echo $booking_id;
		$data['user'] = $user  = $this->checkLogin();
		if (@$_POST['booking_id']) {
			$return['res'] = 'error';
			$return['msg'] = 'Not Saved!';
			$booking = $this->model->getRow('booking_new',['id'=>$booking_id]);
			$property = $this->model->getRow('propmaster',['id'=>$booking->property_id]);
			$property_doc = $this->model->getRow('propmaster_document',['prop_m_id'=>$property->id]);
			// check user property assign or not
		$existprop  = $this->validate_user_property($user->id,$booking->property_id);
		if($existprop==0)
		{
		$return['res'] 		  	 = 'error';
		$return['msg'] 		  	 = 'Please select valid property !';
		echo json_encode($return);
		die();
		}
			// total qty of rooms checkin
			$booking_items = $this->model->getData('checkin',['booking_id'=>$booking_id]);
			$Tqty = 0;
			foreach($booking_items as $items)
			{
               $Tqty = $Tqty+1;
			}
           
			
			$post = $this->input->post();
			
			$time = time();
			$checkOutArray = array(
				'booking_id' => $post['booking_id'],
				'guest_name' => $post['guest_name'],
				'contact_no' => $post['contact_no'],
				'email' => $post['email'],
				'company_name' => $post['company_name'],
				'address' => $post['address'],
				'gst_no' => $post['gst_no'],
				'check_in_ids' => json_encode($post['check_in_id']),
				'food_amount' => $post['food_amount'],
				'other_amount' => $post['other_amount'],
				'grand_total' => $post['grand_total'],
				'lump_sum_discount' => $post['lump_sum_discount'],
				'check_out_date_time' => time(),
				'property_name' =>$property->propname,
				'property_gst' =>(@$property_doc->gst_no) ? $property_doc->gst_no : '' ,
				'property_contact' =>$property->contact_preson_mobile,
				'property_email' =>$property->email,
				'total_checkin'=>count($post['check_in_id']),
				'received_amount'=>(@$post['paidable_amount']) ? $post['paidable_amount'] : 0,
				'is_igst'=>(@$post['is_igst']) ? $post['is_igst'] : 0,
				'bill_to_company'=>(@$post['bill_to_company']) ? $post['bill_to_company'] : 0,
				'short_amount'=>(@$post['paidable_short_amount']) ? $post['paidable_short_amount'] : 0,
				'payment_status'=>$post['payment_mode'],
				'reference_id'=>$post['reference_id'],
				'round_off'=>$post['rounded_balance'],
			);
			
		
			        // count stored qty of checkout roooms
			        $checkout = $this->model->getData('checkout_new',['booking_id'=>$booking_id]);
			        $Tchechoutqty = 0;
					foreach($checkout as $c)
					{
						
					$Tchechoutqty = $Tchechoutqty+$c->total_checkin;
					}
					$totalqty =  count($post['check_in_id']);

			   if ($check_out = $this->model->Save('checkout_new', $checkOutArray)) {
				logs($user->id,$check_out,'ADD','Add Booking Checkout');
				if (!empty($property->bill_format)) {
					$prefix = str_pad($property->bill_format, 6, '0', STR_PAD_LEFT);    
				} else {
					$prefix = '000000';    
				}
				
				$formatted_id = sprintf('%06d', $check_out);
				$propcode = $prefix . $formatted_id;
				$propcode = substr($propcode, -12);
				
				$this->model->Update('checkout_new', ['bill_no' => $propcode], ['id' => $check_out]);
				
				logs($user->id,$check_out,'EDIT','Edit Booking bill no');
				foreach ($post['check_in_id'] as $key => $check_in_id) {

					$update['is_checked_out'] = 1;
					$update['checkout_id'] = $check_out;
					$update['check_out_date_time'] = $time;

					$this->model->Update('checkin', $update, ['id' => $check_in_id]);
					logs($user->id,$check_in_id,'EDIT','Edit Booking Checkin');
					// check condition if all rooms checkout than booking status will be 5
					if($Tqty==($Tchechoutqty+$totalqty)){
					$this->model->Update('booking_new',['status'=>'5','checkout_time1'=>time()], ['id' => $post['booking_id']]);
					logs($user->id,$post['booking_id'],'CHANGE_STATUS','Change Status Booking Checkout 5');
					}elseif($Tqty == $totalqty){
						$this->model->Update('booking_new',['status'=>'5','checkout_time1'=>time()], ['id' => $post['booking_id']]);
						logs($user->id,$post['booking_id'],'CHANGE_STATUS','Change Status Booking Checkout 5');
					}

					$this->model->Update('room_allotment', ['is_checkout' => $check_out],['booking_id' =>$booking_id,'property_id'=>$booking->property_id,'checkin_id'=>$check_in_id]);
				}
				// Save checkout amount in transaction table
				$transaction=$this->model->Save('transaction', ['booking_id'=>$booking_id,'checkout_id'=>$check_out,'tr_date'=>date('Y-m-d'),'type'=>$post['payment_mode'],'credit'=>(@$post['paidable_amount']) ? $post['paidable_amount'] : 0,'remark'=>'Checkout','action'=>'checkout','active'=>'1','reference_no'=>$post['reference_id']]);
				logs($user->id,$transaction,'ADD','Add Booking Transaction');
			}

			if (@$check_out) {
				$return['res'] = 'success';
				$return['msg'] = 'Saved.';
			}

			echo json_encode($return);
		} else {


			$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
			$data['checklist'] = $this->model->getData('checklist', ['process' => 'checkout']);
			// $data['items']	= $this->model->booking_new_items($booking_id);
			$checkin_rooms	= $this->model->checkin_rooms($booking_id);
			 $COUNT = count($checkin_rooms);
			
			if (!empty($checkin_rooms)) {
			$booking_items_qty =0;
			$processed_room_types = [];
				foreach ($checkin_rooms as $cr_key => $cr_value) {
					$cr_value->start_date= $data['booking']->start_date;
					$cr_value->end_date= $data['booking']->end_date;
					  if (!in_array($cr_value->room_type, $processed_room_types)) {
						$data['booking_items']  = $this->model->getRow('booking_new_items', ['booking_id' => $booking_id,'room_type'=>$cr_value->room_type]);
						$booking_items_qty +=$data['booking_items']->qty;
						$processed_room_types[] = $cr_value->room_type; 
					}
					$no_of_nights = $this->between_dates($cr_value->start_date, $cr_value->end_date);
					$cr_value->no_of_nights =  ((@$no_of_nights) ? count($no_of_nights) : 1);
					$cr_value->totals = round_price(($cr_value->price - (int) $cr_value->discount) * $cr_value->no_of_nights);
					$cr_value->taxAmount =$cr_value->tax_value/$data['booking_items']->qty;
					$cr_value->total = round_price(((($cr_value->extra_bed_price+$cr_value->price)*$cr_value->no_of_nights) - (int) $cr_value->discount)+$cr_value->taxAmount);
					
					$cr_value->total_new = round_price((($cr_value->extra_bed_price+$cr_value->price) - (int) $cr_value->discount)+$cr_value->taxAmount);
					

                   // Sample usage
				   $end_date = $cr_value->end_date;
				   $extra_nights_count = $this->calculate_extra_nights($end_date);
				   $cr_value->no_of_extra_nights = $extra_nights_count;
				   

				}
				 $data['booking_items_qty']=$booking_items_qty;
			}
			$checkout = $this->model->getData('checkout_new',['booking_id'=>$booking_id]);
			$Tchechoutqty = 0;
			foreach($checkout as $c)
			{
				
			$Tchechoutqty = $Tchechoutqty+$c->total_checkin;
			}
			$data['Tchechoutqty'] = $Tchechoutqty;
			$data['checkout']   = $this->model->getData('checkout_new', ['booking_id' =>$booking_id]);
			$data['payment_mode']   = $this->model->getData('payment_mode', ['status' => 1], 'asc', 'mode');
			$data['checkin_rooms'] = $checkin_rooms;
			$data['propmaster'] = $this->propmaster_detailes($booking->property_id);
			$data['transaction'] = $this->model->getData('transaction', ['booking_id' =>$booking_id, 'is_deleted' => 'NOT_DELETED']);
           // $data['items']	= $this->model->booking_new_items($booking_id);
			if ($booking->checkout_time1 == '00:00:00' or $booking->checkout_time1 == '') {
				$booking->checkout_time1 = null;
			}

			if ($booking->status == 5 or $booking->checkout_time1 != null) {
				echo "<div class='text-danger text-center'>Already Completed!</div>";
				echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">';
			}
			// elseif ($booking->status==3) {
			// 	echo "<div class='text-danger text-center'>Booking Not Conformed!";
			// 	echo '<input type="reset" class="btn btn-danger btn-sm mr-1 checkout-close" value="Back">';
			// 	echo '</div>';
			// }
			else {
				echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">';
				$data['contant']  		  = 'reservations/checkout';
				load_view($data['contant'], $data);
			}
		}
		// $this->pr($data);
	}

	function detailes($id)
	{
		$data['row'] = $row = $this->booking_detailes($id);
		$data['property']   = $property  = $this->property_detailes(@$row->flat_id);
		$data['propmaster'] = $this->propmaster_detailes($row->property_id);
		$data['agent'] = $this->model->getRow('agent', ['id' => $row->agent]);
		//$data['document'] = $this->model->getData('checkindoc', ['booking_id' => $row->id]);
		$data['document'] = $this->model->getData('check_in_guests', ['booking_id' => $row->id]);
		$data['items']	= $this->model->booking_new_items($id);
		$data['transaction'] = $this->model->getData('transaction', ['booking_id' => 13, 'is_deleted' => 'NOT_DELETED']);
		$data['content'] 	= 'reservations/detailes';
		echo '<div class="col-md-12 mb-1"><input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back"></div>';
		$data['check_out_url'] = base_url() . 'checkout/';
		$data['check_pre_out_url'] = base_url() . 'pre-check-out/';
		load_view($data['content'], $data);
	}

	function list($booking_id)
	{
		$rows = $this->model->getData('checkout_new', ['booking_id' => $booking_id]);
		foreach ($rows as $key => $value) {
			$check_in_ids = json_decode($value->check_in_ids);
			$room_no = array_map(function ($check_in) {
				return $this->model->getRow('checkin', $check_in)->room_no;
			}, $check_in_ids);
			$value->room_no = implode(', ', $room_no);
		}

		// die();
		$data['content']  		  = 'reservations/checkout_list';
		$data['receipt_url']	  = base_url('checkout/checkout_receipt/');
		$data['rows'] 			  = $rows;
		load_view($data['content'], $data);
		// prx($data);
	}

	function checkout_receipt($checkout_id)
	{
		$row = $this->model->getRow('checkout_new', $checkout_id);
		$booking_id = $row->booking_id;
		$check_in_ids = json_decode($row->check_in_ids);
		// $row->rooms = array_map(function ($check_in) {
		// 	return $this->model->getRow('checkin', $check_in);
		// }, $check_in_ids);
		$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
		$checkout_rooms	= $this->model->checkout_rooms($checkout_id);
			if (!empty($checkout_rooms)) {
				foreach ($checkout_rooms as $cr_key => $cr_value) {
					$cr_value->start_date= $data['booking']->start_date;
					$cr_value->end_date= $data['booking']->end_date;
					$no_of_nights = $this->between_dates($cr_value->start_date, $cr_value->end_date);
					$cr_value->no_of_nights =  ((@$no_of_nights) ? count($no_of_nights) : 1);
					$cr_value->total = _number_format(($cr_value->price - (int) $cr_value->discount) * $cr_value->no_of_nights);
					$cr_value->taxAmount = _number_format(get_tax_amount($cr_value->total)['taxAmount']);
				}
			}

		$data['checkout_rooms'] = $checkout_rooms;
		$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $row->booking_id]);
		$data['propmaster'] = $this->propmaster_detailes($booking->property_id);

		$data['content']  		  = 'reservations/checkout_receipt';
		$data['row'] 			  = $row;
		load_view($data['content'], $data);
		// prx($data);
	}

	

	public function edit_checkout($checkout_id)
	{
		// echo $booking_id;
		$data['user'] = $user  = $this->checkLogin();
		if (@$_POST['checkout_id']) {
			$data['checkout_new'] = $checkout_new = $this->model->getRow('checkout_new', ['id' => $checkout_id]);
			$booking_id =  $checkout_new->booking_id;
			$return['res'] = 'error';
			$return['msg'] = 'Not Saved!';
			$booking = $this->model->getRow('booking_new',['id'=>$booking_id]);
			// check user property assign or not
			$existprop  = $this->validate_user_property($user->id,$booking->property_id);
			if($existprop==0)
			{
			$return['res'] 		  	 = 'error';
			$return['msg'] 		  	 = 'Please select valid property !';
			echo json_encode($return);
			die();
			}
			//$property = $this->model->getRow('propmaster',['id'=>$booking->property_id]);
			//$property_doc = $this->model->getRow('propmaster_document',['prop_m_id'=>$property->id]);
			// total qty of rooms checkin
			$booking_items = $this->model->getData('checkin',['booking_id'=>$booking_id]);
			$Tqty = 0;
			foreach($booking_items as $items)
			{
               $Tqty = $Tqty+1;
			}
            // if(!empty($property->bill_format))
			// {
			// 	$rto_code = '0000'.$property->bill_format;	
			// }else
			// {
			// 	$rto_code = '0000';
			// }
			
			// $last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('checkout_new')->row();
			// if (@$last_row->bill_no) {
			// 	$propcode ='0000'.$last_row->bill_no+1;
			// }else{
			// 	$propcode = $rto_code;
			// }
			$post = $this->input->post();
			$time = time();
			$checkOutArray = array(
				'guest_name' => $post['guest_name'],
				'contact_no' => $post['contact_no'],
				'email' => $post['email'],
				'company_name' => $post['company_name'],
				'address' => $post['address'],
				'gst_no' => $post['gst_no'],
				'check_in_ids' => json_encode($post['check_in_id']),
				'food_amount' => $post['food_amount'],
				'other_amount' => $post['other_amount'],
				'grand_total' => $post['grand_total'],
				'lump_sum_discount' => $post['lump_sum_discount'],
				'check_out_date_time' => time(),
				// 'bill_no' =>$propcode,
				// 'property_name' =>$property->propname,
				// 'property_gst' => $property_doc->gst_no,
				// 'property_contact' =>$property->contact_preson_mobile,
				// 'property_email' =>$property->email,
				'total_checkin'=>count($post['check_in_id']),
				'received_amount'=>(@$post['paidable_amount']) ? $post['paidable_amount'] : 0,
				'is_igst'=>(@$post['is_igst']) ? $post['is_igst'] : 0,
				'round_off'=>$post['rounded_balance'],
			);
			        // count stored qty of checkout roooms
			        $checkout = $this->model->getData('checkout_new',['booking_id'=>$booking_id]);
			        $Tchechoutqty = 0;
					foreach($checkout as $c)
					{
						
					$Tchechoutqty = $Tchechoutqty+$c->total_checkin;
					}
					$totalqty =  count($post['check_in_id']);

			   if ($check_out = $this->model->Update('checkout_new', $checkOutArray,['id'=>$checkout_id])) {
				logs($user->id,$checkout_id,'EDIT','Edit Booking Checkout');
				foreach ($post['check_in_id'] as $key => $check_in_id) {

					// $update['is_checked_out'] = 1;
					// $update['checkout_id'] = $check_out;
					// $update['check_out_date_time'] = $time;

					// $this->model->Update('checkin', $update, ['id' => $check_in_id]);
					
					// check condition if all rooms checkout than booking status will be 5
					if($Tqty==($Tchechoutqty+$totalqty)){
					$this->model->Update('booking_new',['status'=>'5','checkout_time1'=>time()], ['id' => $post['booking_id']]);
					logs($user->id,$post['booking_id'],'CHANGE_STATUS','Change Status for Booking 5');
					}elseif($Tqty == $totalqty){
						$this->model->Update('booking_new',['status'=>'5','checkout_time1'=>time()], ['id' => $post['booking_id']]);
						logs($user->id,$post['booking_id'],'CHANGE_STATUS','Change Status for Booking 5');
					}
				}
				// Save checkout amount in transaction table
				$this->model->Update('transaction', ['booking_id'=>$booking_id,'tr_date'=>date('Y-m-d'),'type'=>$post['payment_mode'],'credit'=>(@$post['paidable_amount']) ? $post['paidable_amount'] : 0,'remark'=>'Checkout','action'=>'checkout','active'=>'1','reference_no'=>$post['reference_id']] ,['booking_id'=>$booking_id,'checkout_id'=>$checkout_id]);
				logs($user->id,$booking_id,'EDIT','Edit Booking Transaction');
			}

			if (@$check_out) {
				$return['res'] = 'success';
				$return['msg'] = 'Update Successfully.';
			}

			echo json_encode($return);
		} else {
			$data['checkout_new'] = $checkout_new = $this->model->getRow('checkout_new', ['id' => $checkout_id]);
			$booking_id =  $checkout_new->booking_id;
			$data['booking'] = $booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
			$data['checklist'] = $this->model->getData('checklist', ['process' => 'checkout']);
			// $data['items']	= $this->model->booking_new_items($booking_id);
			$checkin_rooms	= $this->model->checkout_rooms($checkout_id);
		
			if (!empty($checkin_rooms)) {
				$booking_items_qty =0;
				$processed_room_types = [];
				foreach ($checkin_rooms as $cr_key => $cr_value) {
					$cr_value->start_date= $data['booking']->start_date;
					$cr_value->end_date= $data['booking']->end_date;
					if (!in_array($cr_value->room_type, $processed_room_types)) {
						$data['booking_items']  = $this->model->getRow('booking_new_items', ['booking_id' => $booking_id,'room_type'=>$cr_value->room_type]);
						$booking_items_qty +=$data['booking_items']->qty;
						$processed_room_types[] = $cr_value->room_type; 
					}
					$no_of_nights = $this->between_dates($cr_value->start_date, $cr_value->end_date);
					$cr_value->no_of_nights =  ((@$no_of_nights) ? count($no_of_nights) : 1);
					$cr_value->totals = round_price(($cr_value->price - (int) $cr_value->discount) * $cr_value->no_of_nights);
					$cr_value->taxAmount =$cr_value->tax_value/$data['booking_items']->qty;
					$cr_value->total = round_price(((($cr_value->extra_bed_price+$cr_value->price)*$cr_value->no_of_nights) - (int) $cr_value->discount)+$cr_value->taxAmount);
					$cr_value->total_new = round_price((($cr_value->extra_bed_price+$cr_value->price) - (int) $cr_value->discount)+$cr_value->taxAmount);
					
					   // Sample usage
					   $end_date = $cr_value->end_date;
					   $extra_nights_count = $this->calculate_extra_nights($end_date);
					   $cr_value->no_of_extra_nights = $extra_nights_count;
					
				}
				$data['booking_items_qty']=$booking_items_qty;
			}

			$data['checkin_rooms'] = $checkin_rooms;
			$data['payment_mode']   = $this->model->getData('payment_mode', ['status' => 1], 'asc', 'mode');
			$data['propmaster'] = $this->propmaster_detailes($booking->property_id);
			$data['transaction'] = $this->model->getData('transaction', ['booking_id' =>$booking_id, 'is_deleted' => 'NOT_DELETED']);
           // $data['items']	= $this->model->booking_new_items($booking_id);
			// if ($booking->checkout_time1 == '00:00:00' or $booking->checkout_time1 == '') {
			// 	$booking->checkout_time1 = null;
			// }

			// if ($booking->status == 5 or $booking->checkout_time1 != null) {
			// 	echo "<div class='text-danger text-center'>Already Completed!</div>";
			// 	echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">';
			// }
			// elseif ($booking->status==3) {
			// 	echo "<div class='text-danger text-center'>Booking Not Conformed!";
			// 	echo '<input type="reset" class="btn btn-danger btn-sm mr-1 checkout-close" value="Back">';
			// 	echo '</div>';
			// }
			// else {
				echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">';
				$data['contant']  		  = 'reservations/edit_checkout';
				load_view($data['contant'], $data);
			// }
		}
		// $this->pr($data);
	}

}
