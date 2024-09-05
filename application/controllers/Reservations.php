<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Main.php');
require_once(APPPATH . 'third_party/tcpdf/TCPDF/tcpdf.php');
class Reservations extends Main
{

	public function __construct() {
        parent::__construct();
		$this->checkPlan(@$_COOKIE['property_id']);
			$this->check_role_menu();
		}


	public function index($action = null, $id = null)
	{
		$data['user'] = $user  = $this->checkLogin();
		// echo $user->id;
		// echo prx($data);
		// die();
		
		switch ($action) {
			case null:
				$append_tb_url = '';
				if (@$_GET['s']) {
					$append_tb_url = '?s=' . $_GET['s'];
				}
				$data['title'] 			= 'Bookings';
				$data['contant'] 		= 'reservations/reservations';
				$data['tb_url']	  		= base_url() . 'reservations/tb' . $append_tb_url;
				$data['tb_url_all']	  	= base_url() . 'reservations/tb';
				$data['pAssets'] 		= ['daterangepicker'];
				$function = 'propmaster';

				if ($user->type == 'host') {
					$function 				= 'host_propmaster';
					$data['tb_url']	  		= base_url() . 'reservations/tb' . $append_tb_url;
					$data['tb_url_all']	  	= base_url() . 'reservations/tb';

					// $data['tb_url']	  =  base_url().'reservations/tb_host_pro'.$append_tb_url;
				}
				$data['propmaster']  = $this->model->$function();
				$data['b_status']    =  $this->model->getData('booking_status', 0, 'desc', 'status');
				$data['p_status']    =  $this->model->getData('payment_status', 0, 'desc', 'status');
				$data['cookie_property_id'] = @$_COOKIE['property_id'];
				$this->template($data);
				break;

			case 'tb':
				$append_tb_url = '';
				// if (@$_GET['s']) {
				// 	$append_tb_url = '?s='.$_GET['s'];
				// }

				if (!@$_POST['daterange']) {
					$_POST['b_from'] = date("Y-m-d", strtotime(date('Y-m-d') . '- 2 day '));
					$_POST['b_to']   = date('Y-m-d');
				}

				if (@$_POST['daterange']) {
					$date = explode(',', $_POST['daterange']);
					$_POST['b_from'] 	= trim($date[0]);
					$_POST['b_to'] 	= trim($date[1]);
				}

				$function = 'bookings_new';
				$pro_id = @$_COOKIE['property_id'];
				if ($user->type == 'host') {
					$function = 'host_bookings_new';
					$pro_id = '';
				}


				if ($this->input->server('REQUEST_METHOD') == 'POST') {

					if (!$this->model->$function($pro_id)) {
						echo "<center class='text-danger'>data not fount.</center>";
						// $this->pr($rows);
						die();
					}
				}




				$this->load->library('pagination');
				$config = array();
				$config["base_url"] = base_url() . "reservations/tb" . $append_tb_url;

				$data['search'] = '';
				if (@$_POST['search']) {
					$data['search'] = $_POST['search'];
				}

				$config["total_rows"]  = count($this->model->$function($pro_id) ? : []);
				$data['total_rows']    = $config["total_rows"];
				$config["per_page"]    = 10;
				$config["uri_segment"] = 3;
				$config['attributes']  = array('class' => 'pag-link');
				$this->pagination->initialize($config);
				$data["links"]   = $this->pagination->create_links();
				$data["links"]   = '';
				$data['page']    = $page = ($id != null) ? $id : 0;
				$rows    		 = $this->model->$function($pro_id,$config["per_page"], $page);
				$data['rows'] 	 = $rows;
				// echo prx($rows);die();
				$data['content'] 	  			= 'reservations/tb_reservations';
				$data['tr_url']	  				= base_url() . 'reservations/transaction/';
				$data['update_url']	  			= base_url() . 'reservations/update/';
				$data['status_url']	  			= base_url() . 'reservations/status/';
				$data['detail_url']	  			= base_url() . 'reservations/detailes/';
				$data['cancel_booking_url']		= base_url() . 'cancel-booking/';
				$data['extend_url']				= base_url() . 'extend/';
				$data['change_flat_url']		= base_url() . 'change-flat/';
				$data['pre_check_out_url']		= base_url() . 'pre-check-out/';
				$data['reschedule_booking_url']	= base_url() . 'reschedule-booking/';
				$data['receipt_url']			= base_url() . 'reservations/view_receipt/';
				$data['send_mail_url']			= base_url() . 'reservations/send_mail_url/';
				
				$data['payment_link']			= base_url() . 'send-payment-link/';
				$data['paynow_url']				= base_url() . 'paynow/';
				$data['check_out_list_url']		= base_url() . 'checkout/list/';
				$data['checkout_url']			= base_url() . 'checkout/';
				$data['update_url']			= base_url() . 'reservations/create/';

				// $this->pr($rows);
				load_view($data['content'], $data);
				break;
				case 'view_receipt':
				$data['checkout'] = $this->model->getData('checkout_new',['booking_id'=>$id]);	
				$data['checkouts'] = $this->model->getRow('checkout_new',['booking_id'=>$id]);
				$data['booking'] = $this->model->getRow('booking_new',['id'=>$id]);	
				$data['receipt_url']			= base_url() . 'receipt/';
				$data['cancel_receipt_url']     = base_url() . 'cancel_receipt_url/';
				$data['edit_checkout_url']			= base_url() . 'checkout/edit_checkout/';
				
				$data['content'] 	  			= 'reservations/view_receipt';
				$data['form_id']= uniqid();
				load_view($data['content'],$data);
				break;	
				case 'send_mail_url':
					$data['checkout'] = $this->model->getData('checkout_new',['booking_id'=>$id]);	
				    $data['checkouts'] = $this->model->getRow('checkout_new',['booking_id'=>$id]);
					$data['booking'] = $this->model->getRow('booking_new',['id'=>$id]);	
					$data['content'] 	  			= 'reservations/send_mail_page';
					$data['form_id']= uniqid();
					load_view($data['content'],$data);
				break;	
				case 'send_mail_post':
					$return['res'] = 'error';
					$return['msg'] = 'Something went wrong!';
					$post = $this->input->post();
					
					if ($this->input->server('REQUEST_METHOD') == 'POST') {
						$id = $post['id'];
						$type = $post['type'];
						$bills = isset($post['bills']) ? $post['bills'] : [];
						$data['booking'] = $this->model->getRow('booking_new', ['id' => $id]);
						
						if ($type == 'bill' && !empty($bills)) {
							if ($this->sendBillEmail($id, $bills)) {
								$return['res'] = 'success';
								$return['msg'] = 'Bill(s) sent successfully!';
							} else {
								$return['res'] = 'error';
								$return['msg'] = 'Failed to send bill(s).';
							}
						} elseif ($type == 'receipt') {
							if ($this->SendMailReceipt($id)) {
								$return['res'] = 'success';
								$return['msg'] = 'Receipt sent successfully!';
							} else {
								$return['res'] = 'error';
								$return['msg'] = 'Failed to send receipt.';
							}
						}
					}
					echo json_encode($return);
					break;
				
				case 'create':
				
				$data['content'] 	  			= 'reservations/update_booking';
				if ($id!=null) {
				$data['action_url']     = base_url().'reservations/update_booking/'.$id;
				$data['value'] = $this->model->getData('booking_new', ['id' => $id]);
				foreach($data['value']  as $v)
				{
					$pro_id=$v->property_id;
					$startDate = $v->start_date;
					$endDate = $v->end_date;
					$booking_id=$v->id;
				}
				$data['property'] = $this->model->getRow('propmaster',['id'=>$pro_id]);
				$data['startDate'] 	 = $startDate;
				$data['endDate'] 	 = $endDate;
				$data['booking_type'] = $this->model->getData('booking_type', ['status' => 1], 'asc', 'type');
				$data['booking_type_master'] = $this->model->getData('booking_type_master', ['active' => 1], 'asc', 'name');
				$data['payment_mode']   = $this->model->getData('payment_mode', ['status' => 1], 'asc', 'mode');
				$data['rows'] = ($user->type == 'host') ? $this->model->host_propmaster() : $this->model->propmaster();
	           	$data['sub_property_types'] = $this->model->getSubPropertyTypeOfProperty($pro_id);
			    $data['booking_new_items'] = $this->model->getData('booking_new_items', ['booking_id' => $booking_id]);
				$data['rowss'] = $row = $this->booking_detailes($booking_id);
				$data['agent'] = $this->model->getRow('agent', ['id' => $row->agent]);
				}
				$data['form_id']= uniqid();
				load_view($data['content'],$data);
				break;
				case 'reservation_new_form':
					$pro_id = $id;
					$data['user'] = $user = $this->checkLogin();
					$data['rows'] = ($user->type == 'host') ? $this->model->host_propmaster() : $this->model->propmaster();
					$data['sub_property_types'] = $this->model->getSubPropertyTypeOfProperty($pro_id);
					$data['pro_id'] = $pro_id;
					$data['property'] = $this->model->getRow('propmaster',['id'=>$pro_id]);
					$data['startDate'] 	 = date('Y-m-d');
					$data['endDate'] 	 = date("Y-m-d", strtotime('+ 1 day '));
					$data['booking_type'] = $this->model->getData('booking_type', ['status' => 1], 'asc', 'type');
					$data['booking_type_master'] = $this->model->getData('booking_type_master', ['active' => 1], 'asc', 'name');
					$data['payment_mode']   = $this->model->getData('payment_mode', ['status' => 1], 'asc', 'mode');
					$data['action_url'] = base_url('reservations/reservation_new');
					$data['contant']    = 'propCalendar/reservation';
					load_view($data['contant'], $data);
				break;
             case 'update_booking':					
				$return['res'] 		  	 = 'error';
				$return['msg'] 		  	 = 'Someting Worng!';
				$post = $this->input->post();
				if ($this->input->server('REQUEST_METHOD') == 'POST') {
				
					// $property = $this->model->getRow('property', ['flat_id' => $flat_id]);
				// check user property assign or not
				
				$existprop  = $this->validate_user_property($user->id,$post['propmaster']);
				if($existprop==0)
				{
				$return['res'] 		  	 = 'error';
				$return['msg'] 		  	 = 'Please select valid property !';
				echo json_encode($return);
				die();
				}
					$this->db->delete('booking_new_inventory', array('booking_id' => $id));
					$this->db->delete('booking_new_items', array('booking_id' => $id));
					//$this->db->delete('transaction', array('booking_id' => $id));
					// from date - to date
					// if (@$post['startDate'] && @$post['endDate']) {
					// 	$dateArray = $this->between_dates($post['startDate'], $post['endDate']);
					// } else {
					// 	$return['msg'] 		  = 'Date not selected!';
					// 	echo json_encode($return);
					// 	die();
					// }
					// // from date - to date
					   // Validate dates
					   if (@$post['startDate'] && @$post['endDate']) {
						$startDate = $post['startDate'];
						$endDate = $post['endDate'];
			
						// Calculate the minimum allowed date (15 days before today)
						$minDate = date('Y-m-d', strtotime('-15 days'));
			
						// Check if startDate is earlier than the minimum allowed date
						if ($startDate < $minDate) {
							$return['msg'] = 'Arrival cannot be earlier than ' . $minDate . '!';
							echo json_encode($return);
							die();
						}
			
						$dateArray = $this->between_dates($startDate, $endDate);
					} else {
						$return['msg'] = 'Date not selected!';
						echo json_encode($return);
						die();
					}
			
					// Validate mobile number
					if ($post['mobile'] == '') {
						$return['msg'] = 'Enter Guest Mobile Number.';
						echo json_encode($return);
						die();
					}
		
					// validation
					if ($post['mobile'] == '') {
						$return['msg'] = 'Enter Guest Mobile Number.';
						echo json_encode($return);
						die();
					}
		
					if (!validate_mobile($post['mobile'])) {
						$return['msg'] = 'Invalid Mobile Number!';
						echo json_encode($return);
						die();
					}
		
					if ($post['name'] == '') {
						$return['msg'] = 'Enter Guest Name!';
						echo json_encode($return);
						die();
					}
					   // Check if room types are selected and validate guest capacity
				   // Check if room types are selected and validate guest capacity
				   if (!empty($post['room_type'])) {
					$room_capacity=$extra_bedd=0;
					foreach ($post['room_type'] as $key => $value) {
						$property = $this->model->getRow('property', ['flat_id' => $value]);
						$room_capacity += $property->capacity*$post['quantity'][$key];
						$extra_bedd += $post['extra_bedding'][$key];
					}
				} else {
					$return['msg'] = 'Room type not selected!';
					echo json_encode($return);
					die();
				}
				$of_adults = $post['of_adults'];
				$of_children = $post['of_children'];
				$selectCapacity = $of_adults + $of_children;
				if (($room_capacity+$extra_bedd) < $selectCapacity) {
					$return['msg'] = 'Guest capacity is ' .($room_capacity+$extra_bedd). ', please adjust room selection.';
					echo json_encode($return);
					die();
				}
		
					// if (@$post['payment_mode'] == '') {
					// 	$return['msg'] = 'Select payment mode!';
					// 	echo json_encode($return);
					// 	die();
					// }
		
					$rooms = [];
					$total = 0;
					$tax = 0;
					$withouttax = 0;
					if (@$post['room_type']) {
					foreach ($post['room_type'] as $key => $value) {
						if (@$post['quantity'][$key] && @$value) {
							$price = $this->get_price_new(['pro_id' => $post['propmaster'], 'room_type' => $value ,'booking_type'=>$post['booking_type'] ], 'return');
							$daily_price =$TaxAbleAmt= ($price['daily_price']* $post['quantity'][$key])-@$post['discount'][$key];
							$extra_bedding_price = $price['extra_bedding_price'];
							$extra_bedding_total=0;
							if($extra_bedding_price && $post['extra_bedding'][$key])
							{
								$extra_bedding_price = $price['extra_bedding_price']*$post['extra_bedding'][$key];
								$extra_bedding_total = $price['extra_bedding_price']*$post['extra_bedding'][$key]*$post['nights'];
								$TaxAbleAmt =$daily_price +$extra_bedding_price;
							}
							$TAMOUNT = getTaxAmount($TaxAbleAmt);
							// $taxRate = $TAMOUNT['taxRate'];
							$taxAmount = $TAMOUNT['taxAmount'];
							$totalAmount = $TAMOUNT['TotalAmount'];
							$taxRate = $post['taxRate'][$key];
							
							$room_total = ($price['daily_price']*  $post['nights']) * $post['quantity'][$key];
							$room_totalAmount = $post['totalAmount'][$key];
							$room_taxAmount = $post['taxAmount'][$key];
							$room_total = $post['amount'][$key];
							$rooms[] = array(
								'property_id' => $post['propmaster'],
								'room_type' => $value,
								'qty' => $post['quantity'][$key],
								'extra_bedding' => $post['extra_bedding'][$key],
								'price' => $price['daily_price'],
								'extra_bedding_price' =>  $price['extra_bedding_price'],
								'extra_bedding_total' => $extra_bedding_total,
								'discount' => $post['discount'][$key],
								'total_discount' => (@$post['discount'][$key]) ? $post['discount'][$key] *  $post['quantity'][$key]*$post['nights'] : 0,
								'total'=>$room_totalAmount,
								'tax_value'=>$room_taxAmount,
								'total_withouttax'=>$room_total,
								'tax_per'=>$taxRate,
							);
							$total += $room_totalAmount;
							$tax += $room_taxAmount;
							$withouttax += $room_total;
						}
				}
			}
			// echo $tax;die();
		
		
		
					if (!@$rooms) {
						$return['msg'] = 'Room type not selected!';
						echo json_encode($return);
						die();
					}
					//validation
		
					if ($appuser = $this->model->getRow('appuser', ['mobile' => $post['mobile']])) {
						$guest_id = $appuser->id;
						$post['mobile'] = $appuser->mobile;
					} else {
						$saveappuser['mobile'] 	= $post['mobile'];
						$saveappuser['name'] 	= $post['name'];
						$saveappuser['dob'] 	= $post['dob'];
						$saveappuser['gender'] 	= $post['gender'];
						$saveappuser['email'] 	= $post['email'];
						$saveappuser['property_id'] 	=$post['propmaster'];
						if ($guest_id = $this->model->Save('appuser', $saveappuser)) {
							logs($user->id,$guest_id,'ADD','Add App Users');
						} else {
							$guest_id = false;
						}
					}
		
					if ($guest_id) {
		
						$total = $total;
						if ($total == $post['advanced']) {
							$payment_status = 2;
						}elseif($total - $post['advanced'] !=0)
						{
							$payment_status = 1;
						}else if($post['advanced']=='')
						{
							$payment_status = 5;
						}else
						{
							$payment_status = 5;
						}
						// $payment_status = 1;
						// if ($post['payment_mode'] == '') {
						// 	$payment_status = 3;
						// }
						// if (@$post['advanced']) {
						// 	$payment_status = 1;
						// }
						// if ($total == $post['advanced']) {
						// 	$payment_status = 2;
						// }
						$booking = (object)[];
						$booking->property_id = $post['propmaster'];
						$booking->booking_type = @$post['booking_type'];
						$booking->booking_from = $post['booking_from'];
						$booking->agent = @$post['agent'];
						$booking->guest_id = $guest_id;
						$booking->guest_name =  @$post['name'];
						$booking->gender = @$post['gender'];
						$booking->email = @$post['email'];
						$booking->contact = $post['mobile'];
						$booking->of_adults = $post['of_adults'];
						$booking->of_children = $post['of_children'];
						$booking->of_infants = $post['of_infants'];
						$booking->start_date = $post['startDate'];
						$booking->end_date = $post['endDate'];
						$booking->dob = $post['dob'];
						$booking->total = $total;
						$booking->tax_value = $tax;
						$booking->tax_per=$taxRate;
						$booking->total_withouttax = $withouttax;
						$booking->booking_remark = $post['booking_remark'];
						$booking->discount_amount = $post['discount_amount'];
						$booking->discount_remark = $post['discount_remark'];
						$booking->payment_status = $payment_status;
						$booking->booking_date = date('Y-m-d H:i:s');
		
						$transaction_Array['tr_date']				= date('Y-m-d');
						$transaction_Array['type']					= $_POST['payment_mode'];
						$transaction_Array['credit']				= $_POST['advanced'];
						$transaction_Array['reference_no']			= $_POST['reference_id'];
						$transaction_Array['remark']				= "Advance payment.";
						$transaction_Array['action']				= "booking";
						// 	prx($booking);
						//  prx($rooms);
						// die();
		
						if ($booked = $this->model->Update('booking_new', $booking,['id'=>$id])) {
							logs($user->id,$id,'EDIT','Edit Bookings');
							$transaction_Array['booking_id'] = $id;
							$this->model->Update('transaction', $transaction_Array,['booking_id'=>$id,'action'=>'booking']);
							logs($user->id,$id,'EDIT','Edit Bookings Transaction  by Booking Id');
							$total_amount = 0;
							foreach ($rooms as $key => $value) {
								$value['booking_id'] = $id;
								$item_id=$this->model->Save('booking_new_items', $value);
								logs($user->id,$item_id,'ADD','Add Bookings New Items');
								$this->booking_new_inventory($dateArray, $value);
							}
							$return['res'] 		  = 'success';
							$return['msg'] 		  = 'Bookings Successful.';
							$return['receipt_url'] = base_url() . 'receipt/' . $booked;
						}
					} else {
						$return['msg'] 		  = 'Guest Not selected!';
					}
				}
				echo json_encode($return);

				break;

			case 'status':
				if ($this->input->server('REQUEST_METHOD') == 'POST') {
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!';
					if ($id != null) {
						if ($this->model->Update('booking_new', $_POST, ['id' => $id])) {
							logs($user->id,$id,'CHANGE_STATUS','Change Booking Status - '.$_POST['status']);
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
							if ($_POST['status'] == 4) {
								logs($user->id,$id,'CHANGE_STATUS','Booking Cancel');
								$this->cancel_booking($id, 'no');
							}
						}
					} else {
						if ($this->model->Save('booking_new', $_POST)) {
							logs($user->id,$id,'CHANGE_STATUS','Change Booking Status - '.$_POST['status']);
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					echo json_encode($return);
				} else {
					$data['row']    	 = $this->booking_detailes($id);
					$data['b_status']    = $this->model->getData('booking_status', 0, 'desc', 'status');
					$data['action_url']  = 'reservations/status/' . $id;
					$data['contant'] 	 = 'reservations/status';
					// $this->pr($data);
					load_view($data['contant'], $data);
				}
				break;

			    case 'detailes':
				$data['row'] = $row = $this->booking_detailes($id);
				$data['property']   = $property  = $this->property_detailes(@$row->flat_id);
				$data['propmaster'] = $this->propmaster_detailes($row->property_id);
				$data['agent'] = $this->model->getRow('agent', ['id' => $row->agent]);
				//$data['document'] = $this->model->getData('checkindoc', ['booking_id' => $row->id]);
				$data['document'] = $this->model->getData('check_in_guests', ['booking_id' => $row->id]);
				$data['items']	= $this->model->booking_new_items($id);
				$data['transaction'] = $this->model->getData('transaction', ['booking_id' => 13, 'is_deleted' => 'NOT_DELETED']);
				$data['contant'] 	= 'reservations/detailes';
				$data['check_out_url'] = base_url() . 'checkout/';
				$data['check_pre_out_url'] = base_url() . 'pre-check-out/';
				// $this->pr($data['items']);
				load_view($data['contant'], $data);
				break;

				/// agent
			    case 'add_agent':
				$user_id = value_encryption(get_cookie('6050c764989e5'), 'decrypt');
				$data['user_id'] = $user_id;
				$data['contant'] 	= 'reservations/new_agent';

				// $this->pr($data);
				load_view($data['contant'], $data);
				break;

			case 'load_agent':
				$data['agent'] = $this->model->getData('agent', ['owner_id' => $user->id]);
				$data['new_url_agent'] = base_url() . 'reservations/add_agent/';

				$this->load->view('reservations/agent_option', $data);
				break;

			case 'save_agent':
				if ($this->input->server('REQUEST_METHOD') == 'POST') {
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!';

					$data = array(
						'name' => $_POST['name'],
						'mobile' => $_POST['mobile'],
						'company_name' => $_POST['company'],
						'owner_id' => $id,
					);
					if ($save_id=$this->model->Save('agent', $data)) {
						logs($user->id,$save_id,'ADD','Add Agent');
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}

					echo json_encode($return);
				}
				break;

			case 'transaction':
				// $data['row'] = $row = $this->booking_detailes($id);
				// $data['property']   = $property  = $this->property_detailes($row->flat_id);
				$data['action_url'] = base_url() . 'reservations/transaction_save/' . $id;
				$data['delete_url'] = base_url() . 'reservations/transaction_delete';
				$data['tr_receipt_url'] = base_url() . 'reservations/tr_receipt/';
				$data['mode'] = $this->model->getData('payment_mode', ['status' => 1]);
				$data['booking'] =$this->model->getRow('booking_new', ['id' => $id]);
				$data['transaction'] = $this->model->getData('transaction', ['booking_id' => $id, 'is_deleted' => 'NOT_DELETED']);
				$data['booking_id']=$id;
				$data['contant'] 	= 'reservations/transaction';

				// $this->pr($data);
				load_view($data['contant'], $data);
				break;

			case 'transaction_save':
				if ($this->input->server('REQUEST_METHOD') == 'POST') {
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!';

					$credit = '0';
					$debit = '0';

					if ($_POST['debit_type'] == 1) {
						$credit = $_POST['amount'];
					} else {
						$debit = $_POST['amount'];
					}

					$data = array(
						'booking_id' => $id,
						'tr_date' => date('Y-m-d'),
						'type' => $_POST['type'],
						'credit' => $credit,
						'debit' => $debit,
						'reference_no' => $_POST['reference_no'],
						'action' => 'booking',
						'remark' => 'Transaction',
					);
					$transaction1 = $this->model->getData('transaction',['is_deleted'=>'NOT_DELETED','booking_id'=>$id]); 
						$transaction_total1=0;
						foreach($transaction1 as $tr1)
						{
							$transaction_total1 = $transaction_total1+$tr1->credit;
						}
						$booking_new1 = $this->model->getRow('booking_new',['id'=>$id]);
						if(($transaction_total1+$credit) <= $booking_new1->total)
						{
					if ($save_id=$this->model->Save('transaction', $data)) {
						logs($user->id,$save_id,'ADD','Add Transaction');
						$transaction = $this->model->getData('transaction',['is_deleted'=>'NOT_DELETED','booking_id'=>$id]); 
						$transaction_total=0;
						foreach($transaction as $tr)
						{
							$transaction_total = $transaction_total+$tr->credit;
						}
						$booking_new = $this->model->getRow('booking_new',['id'=>$id]);
						if($transaction_total==$booking_new->total)
						{
						  $this->model->Update('booking_new',['payment_status'=>'2'],['id'=>$id]);	
						}
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
				}else{
					$return['res'] = 'error';
					$return['msg'] = 'Transaction amount exceeds the booking total.';
				}

					echo json_encode($return);
				}
				break;

			case 'transaction_delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id != null) {
					if ($this->model->_delete('transaction', ['id' => $id])) {
						logs($user->id,$id,'DELETE','Delete Transaction');
						$transaction_id = $this->model->getRow('transaction',['id'=>$id]);
						$transaction = $this->model->getData('transaction',['is_deleted'=>'NOT_DELETED','booking_id'=>$transaction_id->booking_id]); 
						$transaction_total=0;
						foreach($transaction as $tr)
						{
							$transaction_total = $transaction_total+$tr->credit;
						}
						$booking_new = $this->model->getRow('booking_new',['id'=>$transaction_id->booking_id]);
						if($transaction_total<=$booking_new->total)
						{
						  $this->model->Update('booking_new',['payment_status'=>'1'],['id'=>$transaction_id->booking_id]);	
						  logs($user->id,$transaction_id->booking_id,'CHANGE_STATUS','Booking Payment Status change');
						}
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
					}
				}
				echo json_encode($return);
				break;

				case 'tr_receipt':
					$data['transaction']  =$transaction= $this->model->getRow('transaction', ['id' => $id]);
					
					$data['booking']  =$booking = $this->model->getRow('booking_new',['id'=>$transaction->booking_id]);
					$data['room_allotment'] =$flats = $this->model->getRow('room_allotment',['booking_id'=>$transaction->booking_id]);
					$data['flat'] = $flat = $this->model->getRow('property',['flat_id'=>$flats->flat_id]);
					$data['propmaster'] = $propmaster = $this->model->getRow('propmaster',['id'=>$flat->propid]);
					$admin_logo = $this->model->getRow('tb_admin',['id'=>'1']);
					if(!empty($admin_logo))
					{
					 $data['logo'] = IMGS_URL.$admin_logo->photo;
						
					}else
					{
						$data['logo'] = base_url().'static/app-assets/images/logo/logo.png';
					}
					$data['content'] = 'receipt';
					load_view($data['content'],$data);
			  break;	
				case 'check_in_remaining':
				$data["user"]    = $user = $this->checkLogin();

				$function = 'bookings_new';
				if ($user->type == "host") {
					$function = 'host_bookings_new';
				}
				$month = date('m');
				$year  = date('Y');
				if (@$_GET['m']) {
					$month = $_GET['m'];
				}
				if (@$_GET['Y']) {
					$year  = $_GET['Y'];
				}

				$current_Month 	= $month;
				$year 			= $year;
				$FristDateOfMonth = $year . '-' . $month . '-01';
				$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
				$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

				if (@$_GET['date']) {
					$data["date"] = $date = $_GET['date'];
				} else {
					$data["date"]  = $date  = date('Y-m-d');
				}

				$data["month"] = $month;
				$data["year"]  = $year;
				$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

				if (@$_COOKIE['property_id']) {
					$_POST['propmaster'] = $_COOKIE['property_id'];
				}

				$bookings = $this->model->$function();
				if(!empty($bookings))
				{
				$booking = $bookings;
				}else
				{
				$booking=[];
				}
				// $this->pr($bookings);
				// prx($bookings);

				$rows = array();
				foreach ($booking as $brow) {
					if ($brow->start_date == $date && $brow->status == 2 && $brow->checkin_status == 0) {
						$rows[] = $brow;
					}
				}
				$data['rows'] = $rows;

				// $this->pr($data);
				$data['check_out_url'] = base_url() . 'checkout/';
				$data['check_pre_out_url'] = base_url() . 'pre-check-out/';
				$data['contant']  = 'reservations/report_list_check_in_remaining';
				$data['detail_url']	  =  base_url() . 'checkin/detailes/';
				$data['check_in_url'] = base_url() . 'checkin/';
				
				load_view($data['contant'], $data);

				// echo date('Y-m-d');
			break;	
			case 'checked_in':
					$data["user"]    = $user = $this->checkLogin();

					$function = 'bookings_new';
					if ($user->type == "host") {
						$function = 'host_bookings_new';
					}
					$month = date('m');
					$year  = date('Y');
					if (@$_GET['m']) {
						$month = $_GET['m'];
					}
					if (@$_GET['Y']) {
						$year  = $_GET['Y'];
					}

					$current_Month 	= $month;
					$year 			= $year;
					$FristDateOfMonth = $year . '-' . $month . '-01';
					$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
					$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

					if (@$_GET['date']) {
						$data["date"] = $date = $_GET['date'];
					} else {
						$data["date"]  = $date  = date('Y-m-d');
					}

					$data["month"] = $month;
					$data["year"]  = $year;
					$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

					$bookings = $this->model->$function();
					if(!empty($bookings))
					{
					$booking = $bookings;
					}else
					{
					$booking=[];
					}
					$rows = array();
					foreach ($booking as $brow) {
						// $brow->start_date == $date && 
						if ($brow->status == 2 && $brow->checkin_status == 1) {
							$rows[] = $brow;
						}
					}
					$data['rows'] = $rows;

					// $this->pr($data);

					$data['contant']  = 'reservations/report_list_checked_in';
					$data['detail_url']	  =  base_url() . 'checkout/detailes/';
					$data['check_out_url'] = base_url() . 'checkout/';
					$data['check_pre_out_url'] = base_url() . 'pre-check-out/';
					load_view($data['contant'], $data);

					// echo date('Y-m-d');
			break;

			case 'check_out_remaining':
					$data["user"]    = $user = $this->checkLogin();

					$function = 'bookings_new';
							if ($user->type == 'host') {
								$function = 'host_bookings_new';
							}
					$month = date('m');
					$year  = date('Y');
					if (@$_GET['m']) {
						$month = $_GET['m'];
					}
					if (@$_GET['Y']) {
						$year  = $_GET['Y'];
					}

					$current_Month 	= $month;
					$year 			= $year;
					$FristDateOfMonth = $year . '-' . $month . '-01';
					$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
					$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

					if (@$_GET['date']) {
						$data["date"] = $date = $_GET['date'];
					} else {
						$data["date"]  = $date  = date('Y-m-d');
					}

					$data["month"] = $month;
					$data["year"]  = $year;
					$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

					$bookings = $this->model->$function();
					if(!empty($bookings))
					{
					$booking = $bookings;
					}else
					{
					$booking=[];
					}
					$rows = array();
					foreach ($booking as $brow) {
						// $brow->end_date == $date &&
						if ($brow->end_date == $date &&  $brow->status == 2 && $brow->checkout_time1 == null) {
							$rows[] = $brow;
						}
					}
					$data['rows'] = $rows;

				//$this->pr($rows);

					$data['contant']       = 'reservations/report_list_check_out_remaining';
					$data['detail_url']	  =  base_url() . 'checkout/detailes/';
					$data['check_out_url'] = base_url() . 'checkout/';
					load_view($data['contant'], $data);

					// echo date('Y-m-d');
			break;

				case 'checked_out':
					$data["user"]    = $user = $this->checkLogin();

					$function = 'bookings_new';
					if ($user->type == 'host') {
						$function = 'host_bookings_new';
					}
					$month = date('m');
					$year  = date('Y');
					if (@$_GET['m']) {
						$month = $_GET['m'];
					}
					if (@$_GET['Y']) {
						$year  = $_GET['Y'];
					}

					$current_Month 	= $month;
					$year 			= $year;
					$FristDateOfMonth = $year . '-' . $month . '-01';
					$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
					$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

					if (@$_GET['date']) {
						$data["date"] = $date = $_GET['date'];
					} else {
						$data["date"]  = $date  = date('Y-m-d');
					}
					$data["month"] = $month;
					$data["year"]  = $year;
					$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

					$bookings = $this->model->$function();
					$rows = array();
					foreach ($bookings as $brow) {
						if ($brow->end_date == $date && $brow->status == 5 && $brow->checkout_time1 != null) {
							$rows[] = $brow;
						}
					}
					$data['rows'] = $rows;

					// $this->pr($data);

					$data['contant']  = 'reservations/report_list';
					$data['detail_url']	  =  base_url() . 'reservations/detailes/';
					load_view($data['contant'], $data);

					// echo date('Y-m-d');
			break;
			 case	'cancelled_reservation':
				$data["user"]    = $user = $this->checkLogin();
		
				$function = 'bookings_new';
						if ($user->type == 'host') {
							$function = 'host_bookings_new';
						}
				$month = date('m');
				$year  = date('Y');
				if (@$_GET['m']) {
					$month = $_GET['m'];
				}
				if (@$_GET['Y']) {
					$year  = $_GET['Y'];
				}
		
				$current_Month 	= $month;
				$year 			= $year;
				$FristDateOfMonth = $year . '-' . $month . '-01';
				$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
				$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));
		
				if (@$_GET['date']) {
					$data["date"] = $date = $_GET['date'];
				} else {
					$data["date"]  = $date  = date('Y-m-d');
				}
		
				$data["month"] = $month;
				$data["year"]  = $year;
				$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));
		
				$bookings = $this->model->$function();
				if(!empty($bookings))
				{
				 $booking = $bookings;
				}else
				{
				 $booking=[];
				}
				$rows = array();
				foreach ($booking as $brow) {
					if ($brow->start_date == $date && $brow->status == 4 && $brow->checkout_time1 == null) {
						$rows[] = $brow;
					}
				}
				$data['rows'] = $rows;
		
			   //$this->pr($rows);
		
				$data['contant']       = 'reservations/report_list_cancelled_reservation';
				$data['detail_url']	  =  base_url() . 'checkout/detailes/';
				$data['check_out_url'] = base_url() . 'checkout/';
				load_view($data['contant'], $data);
		
				// echo date('Y-m-d');
			break;
		  case	'total_reservation':
				$data["user"]    = $user = $this->checkLogin();
		
				$function = 'bookings_new';
						if ($user->type == 'host') {
							$function = 'host_bookings_new';
						}
				$month = date('m');
				$year  = date('Y');
				if (@$_GET['m']) {
					$month = $_GET['m'];
				}
				if (@$_GET['Y']) {
					$year  = $_GET['Y'];
				}
		
				$current_Month 	= $month;
				$year 			= $year;
				$FristDateOfMonth = $year . '-' . $month . '-01';
				$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
				$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));
		
				if (@$_GET['date']) {
					$data["date"] = $date = $_GET['date'];
				} else {
					$data["date"]  = $date  = date('Y-m-d');
				}
		
				$data["month"] = $month;
				$data["year"]  = $year;
				$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));
		
				$bookings = $this->model->$function();
				if(!empty($bookings))
				{
				 $booking = $bookings;
				}else
				{
				 $booking=[];
				}
				$rows = array();
				foreach ($booking as $brow) {
					if ($brow->start_date == $date) {
						$rows[] = $brow;
					}
				}
				$data['rows'] = $rows;
		
			   //$this->pr($rows);
		
				$data['contant']       = 'reservations/report_list_total_reservation';
				$data['detail_url']	  =  base_url() . 'checkout/detailes/';
				$data['check_out_url'] = base_url() . 'checkout/';
				load_view($data['contant'], $data);
		
				// echo date('Y-m-d');
			break;
			case'printInvoice':
			$data['row'] = $row = $this->booking_detailes($id);
			$data['property']   = $property  = $this->property_detailes(@$row->flat_id);
			$data['propmaster'] = $this->propmaster_detailes($row->property_id);
			$data['agent'] = $this->model->getRow('agent', ['id' => $row->agent]);
			$data['document'] = $this->model->getData('check_in_guests', ['booking_id' => $row->id]);
			$data['items']	= $this->model->booking_new_items($id);
			$data['transaction'] = $this->model->getData('transaction', ['booking_id' => 13, 'is_deleted' => 'NOT_DELETED']);
			$data['contant']       = 'bill_invoice_for_mail';
		    load_view($data['contant'], $data);
			break;
			case 'reservation_new_test':
				$this->SendMailReceipt(10);
			break;	
			case 'view_booking_receipt':
				$data['row'] = $row = $this->booking_detailes($id);
				$data['property']   = $property  = $this->property_detailes(@$row->flat_id);
				$data['propmaster'] = $this->propmaster_detailes($row->property_id);
				$data['agent'] = $this->model->getRow('agent', ['id' => $row->agent]);
				$data['document'] = $this->model->getData('check_in_guests', ['booking_id' => $row->id]);
				$data['items']	= $this->model->booking_new_items($id);
				$data['transaction'] = $this->model->getData('transaction', ['booking_id' => 13, 'is_deleted' => 'NOT_DELETED']);
				$data['contant']       = 'bill_invoice_for_mail';
				load_view($data['contant'], $data);
			break;	
			case 'view_booking_bill':
				$bill_no=$id;
				$data['receipt']  =$receipt = $this->model->getRow('checkout_new',['bill_no'=>$bill_no]);
				$data['logo'] = base_url().'static/app-assets/images/logo/logo.png';
				$data['booking']  =$booking = $this->model->getRow('booking_new',['id'=>$receipt->booking_id]);
				$data['extended'] = $this->model->getData('booking_new',['id'=>$receipt->booking_id]);
				$data['totalcheckin'] = $this->model->getData('checkin',['booking_id'=>$receipt->booking_id]);
				$data['room_allotment'] =$flats = $this->model->getRow('room_allotment',['booking_id'=>$receipt->booking_id]);
				$data['flat'] = $flat = $this->model->getRow('property',['flat_id'=>$flats->flat_id]);
				$data['propmaster'] = $propmaster = $this->model->getRow('propmaster',['id'=>$flat->propid]);
				$data['checkinarray'] =  json_decode($receipt->check_in_ids);
				$checkgst = $this->model->CheckGST($booking->property_id);
				$data['contant']       = 'receipt2';
				load_view($data['contant'], $data);
		    break;		
		}
	}

	public function fetchTableData() {
        $booking_id = $this->input->get('booking_id'); 
		$transactions = $this->model->getData('transaction', ['booking_id' => $booking_id, 'is_deleted' => 'NOT_DELETED']);
		$modes = $this->model->getData('payment_mode', ['status' => 1]);
		$booking =$this->model->getRow('booking_new', ['id' => $booking_id]);

        $total_credit = 0;
        $total_debit = 0;
        $tableData = '';

        foreach ($transactions as $row) {
            $tableData .= '<tr>';
            $tableData .= '<th>' . $row->tr_date . '</th>';
            $tableData .= '<td>';
            foreach ($modes as $m_row) {
                if ($row->type == $m_row->id) {
                    $tableData .= $m_row->mode;
                }
            }
            $tableData .= '</td>';
            $tableData .= '<td>' . $row->credit . '</td>';
            $tableData .= '<td>' . $row->debit . '</td>';
            $tableData .= '<td>' . $row->reference_no . '</td>';
            $tableData .= '<td>';
            if ($booking->status != 5) {
                $tableData .= '<a href="javascript:void(0)"  onclick="_deleteloadTrTable(this)" url="' . base_url('reservations/transaction_delete/' . $row->id) . '" title="Delete">';
                $tableData .= '<i class="fas fa-trash"></i></a>';
            }
            $tableData .= '<a href="' . base_url('reservations/tr_receipt/' . $row->id) . '" class="text-success" target="_blank" title="Receipt">';
            $tableData .= '<i class="fas fa-print" style="font-size:2rem"></i></a>';
            $tableData .= '</td>';
            $tableData .= '</tr>';
            $total_credit += $row->credit;
            $total_debit += $row->debit;
        }

        $tableData .= '<tr>';
        $tableData .= '<td colspan="2"><strong>Total</strong></td>';
        $tableData .= '<td>' . number_format($total_credit, 2) . '</td>';
        $tableData .= '<td>' . number_format($total_debit, 2) . '</td>';
        $tableData .= '<td></td>';
        $tableData .= '<td></td>';
        $tableData .= '</tr>';

        echo $tableData;
    }
	public function reservation_new_form($pro_id = '')
	{
		$data['user'] = $user = $this->checkLogin();
		$data['rows'] = ($user->type == 'host') ? $this->model->host_propmaster() : $this->model->propmaster();
		$data['sub_property_types'] = $this->model->getSubPropertyTypeOfProperty($pro_id);
		$data['pro_id'] = $pro_id;
		$data['property'] = $this->model->getRow('propmaster',['id'=>$pro_id]);
		$data['startDate'] 	 = date('Y-m-d');
		$data['endDate'] 	 = date("Y-m-d", strtotime('+ 1 day '));
		$data['booking_type'] = $this->model->getData('booking_type', ['status' => 1], 'asc', 'type');
		$data['booking_type_master'] = $this->model->getData('booking_type_master', ['active' => 1], 'asc', 'name');
		$data['payment_mode']   = $this->model->getData('payment_mode', ['status' => 1], 'asc', 'mode');
		$data['action_url'] = base_url('reservation_new');
		$data['contant']    = 'propCalendar/reservation';
		load_view($data['contant'], $data);
	}

	public function reservation_new($pro_id = '')
	{
		$data['user'] = $user = $this->checkLogin();
		$return['res'] 		  	 = 'error';
		$return['msg'] 		  	 = 'Someting Worng!';
		$post = $this->input->post();

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			// $property = $this->model->getRow('property', ['id' =>$post['propmaster']]);
           
			// check user property assign or not
            $existprop  = $this->validate_user_property($user->id,$post['propmaster']);
			if($existprop==0)
			{
			$return['res'] 		  	 = 'error';
		    $return['msg'] 		  	 = 'Please select valid property !';
			echo json_encode($return);
			die();
			}

			// // from date - to date
			// if (@$post['startDate'] && @$post['endDate']) {
			// 	$dateArray = $this->between_dates($post['startDate'], $post['endDate']);
			// } else {
			// 	$return['msg'] 		  = 'Date not selected!';
			// 	echo json_encode($return);
			// 	die();
			// }
			// // from date - to date
			   // Validate dates
			   if (@$post['startDate'] && @$post['endDate']) {
				$startDate = $post['startDate'];
				$endDate = $post['endDate'];
	
				// Calculate the minimum allowed date (15 days before today)
				$minDate = date('Y-m-d', strtotime('-15 days'));
	
				// Check if startDate is earlier than the minimum allowed date
				if ($startDate < $minDate) {
					$return['msg'] = 'Arrival cannot be earlier than ' . $minDate . '!';
					echo json_encode($return);
					die();
				}
	
				$dateArray = $this->between_dates($startDate, $endDate);
			} else {
				$return['msg'] = 'Date not selected!';
				echo json_encode($return);
				die();
			}
	
			// Validate mobile number
			if ($post['mobile'] == '') {
				$return['msg'] = 'Enter Guest Mobile Number.';
				echo json_encode($return);
				die();
			}

			// validation
			if ($post['mobile'] == '') {
				$return['msg'] = 'Enter Guest Mobile Number.';
				echo json_encode($return);
				die();
			}

			if (!validate_mobile($post['mobile'])) {
				$return['msg'] = 'Invalid Mobile Number!';
				echo json_encode($return);
				die();
			}

			if ($post['name'] == '') {
				$return['msg'] = 'Enter Guest Name!';
				echo json_encode($return);
				die();
			}
			   // Check if room types are selected and validate guest capacity
			   if (!empty($post['room_type'])) {
				$room_capacity=$extra_bedd=0;
				foreach ($post['room_type'] as $key => $value) {
					$property = $this->model->getRow('property', ['flat_id' => $value]);
					$room_capacity += $property->capacity*$post['quantity'][$key];
					$extra_bedd += $post['extra_bedding'][$key];
				}
			} else {
				$return['msg'] = 'Room type not selected!';
				echo json_encode($return);
				die();
			}
			$of_adults = $post['of_adults'];
			$of_children = $post['of_children'];
			$selectCapacity = $of_adults + $of_children;
			if (($room_capacity+$extra_bedd) < $selectCapacity) {
				$return['msg'] = 'Guest capacity is ' .($room_capacity+$extra_bedd). ', please adjust room selection.';
				echo json_encode($return);
				die();
			}
			
			$rooms = [];
			$total = 0;
			$tax = 0;
			$withouttax = 0;
			if (@$post['room_type']) {
				foreach ($post['room_type'] as $key => $value) {
					if (@$post['quantity'][$key] && @$value) {
						$price = $this->get_price_new(['pro_id' => $post['propmaster'], 'room_type' => $value ,'booking_type'=>$post['booking_type'] ], 'return');
						$daily_price =$TaxAbleAmt= ($price['daily_price']* $post['quantity'][$key])-@$post['discount'][$key];
					    $extra_bedding_price = $price['extra_bedding_price'];
						$extra_bedding_total=0;
						if($extra_bedding_price && $post['extra_bedding'][$key])
						{
							$extra_bedding_price = $price['extra_bedding_price']*$post['extra_bedding'][$key];
							$extra_bedding_total = $price['extra_bedding_price']*$post['extra_bedding'][$key]*$post['nights'];
							$TaxAbleAmt =$daily_price +$extra_bedding_price;
						}
						$TAMOUNT = getTaxAmount($TaxAbleAmt);
						// $taxRate = $TAMOUNT['taxRate'];
						$taxAmount = $TAMOUNT['taxAmount'];
						$totalAmount = $TAMOUNT['TotalAmount'];
						$taxRate = $post['taxRate'][$key];
						
						$room_total = ($price['daily_price']*  $post['nights']) * $post['quantity'][$key];
						$room_totalAmount = $post['totalAmount'][$key];
						$room_taxAmount = $post['taxAmount'][$key];
						$room_total = $post['amount'][$key];
						$rooms[] = array(
							'property_id' => $post['propmaster'],
							'room_type' => $value,
							'qty' => $post['quantity'][$key],
							'extra_bedding' => $post['extra_bedding'][$key],
							'price' => $price['daily_price'],
							'extra_bedding_price' =>  $price['extra_bedding_price'],
							'extra_bedding_total' => $extra_bedding_total,
							'discount' => $post['discount'][$key],
							'total_discount' => (@$post['discount'][$key]) ? $post['discount'][$key] *  $post['quantity'][$key]*$post['nights'] : 0,
							'total'=>$room_totalAmount,
							'tax_value'=>$room_taxAmount,
							'total_withouttax'=>$room_total,
							'tax_per'=>$post['taxRate'][$key],
						);
						$total += $room_totalAmount;
						$tax += $room_taxAmount;
						$withouttax += $room_total;
					}
					
				}
			}
		
		//   echo $withouttax;
		//  die();


			if (!@$rooms) {
				$return['msg'] = 'Room type not selected!';
				echo json_encode($return);
				die();
			}
			//validation

			if ($appuser = $this->model->getRow('appuser', ['mobile' => $post['mobile']])) {
				$guest_id = $appuser->id;
				$post['mobile'] = $appuser->mobile;
			} else {
				$saveappuser['mobile'] 	= $post['mobile'];
				$saveappuser['name'] 	= $post['name'];
				$saveappuser['dob'] 	= $post['dob'];
				$saveappuser['gender'] 	= $post['gender'];
				$saveappuser['email'] 	= $post['email'];
				$saveappuser['property_id']= $post['propmaster'];
				if ($guest_id = $this->model->Save('appuser', $saveappuser)) {
					logs($user->id,$guest_id,'ADD','Add App Users');
				} else {
					$guest_id = false;
				}
			}

			if ($guest_id) {

				$total = $total;

				
				// if ($post['payment_mode'] == '') {
				// 	$payment_status = 3;
				// }
				// if (@$post['advanced']) {
				// 	$payment_status = 5;
				// }
				if(!empty($post['advanced']))
				{
					$advance = $post['advanced'];
				}else
				{
					$advance = 0;
				}
				if ($total == $advance) {
					$payment_status = 2;
				}elseif($total - $advance !=0)
				{
					$payment_status = 1;
				}else if($advance=='')
				{
					$payment_status = 5;
				}else
				{
					$payment_status = 5;
				}
				$booking = (object)[];
				$booking->property_id = $post['propmaster'];
				$booking->booking_type = @$post['booking_type'];
				$booking->booking_from = $post['booking_from'];
				$booking->agent = @$post['agent'];
				$booking->guest_id = $guest_id;
				$booking->guest_name =  @$post['name'];
				$booking->gender = @$post['gender'];
				$booking->email = @$post['email'];
				$booking->contact = $post['mobile'];
				$booking->of_adults = $post['of_adults'];
				$booking->of_children = $post['of_children'];
				$booking->of_infants = $post['of_infants'];
				$booking->start_date = $post['startDate'];
				$booking->end_date = $post['endDate'];
				$booking->dob = $post['dob'];
				$booking->total = $total;
				$booking->tax_per=$taxRate;
				$booking->tax_value = $tax;
				$booking->total_withouttax = $withouttax;
				$booking->booking_remark = $post['booking_remark'];
				$booking->discount_amount = $post['discount_amount'];
				$booking->discount_remark = $post['discount_remark'];
				$booking->payment_status = $payment_status;
				$booking->booking_date = date('Y-m-d H:i:s');
				$booking->status =2;

				$transaction_Array['tr_date']				= date('Y-m-d');
				$transaction_Array['type']					= $_POST['payment_mode'];
				$transaction_Array['credit']				= $_POST['advanced'];
				$transaction_Array['reference_no']			= $_POST['reference_id'];
				$transaction_Array['remark']				= "Advance payment.";
				$transaction_Array['action']				= "booking";

				// 	prx($booking);
				//  prx($rooms);
				// die();
				
				if (!@$rooms) {
					$return['msg'] = 'Room type not selected!';
					echo json_encode($return);
					die();
				}
				

				if ($booked = $this->model->Save('booking_new', $booking)) {
					logs($user->id,$booked,'ADD','Add New Booking');
					$transaction_Array['booking_id'] = $booked;
					$this->model->Save('transaction', $transaction_Array);
					if($post['mail']=='1')
					{
						$this->SendMailReceipt($booked);
					}
					$total_amount = 0;
					foreach ($rooms as $key => $value) {
						$value['booking_id'] = $booked;
						$booked_item=$this->model->Save('booking_new_items', $value);
						logs($user->id,$booked_item,'ADD','Add New Booking Items');
						$this->booking_new_inventory($dateArray, $value);
					}
					$return['res'] 		  = 'success';
					$return['msg'] 		  = 'Bookings Successful.';
					$return['receipt_url'] = base_url() . 'receipt/' . $booked;
				}
			} else {
				$return['msg'] 		  = 'Guest Not selected!';
			}
		}
		echo json_encode($return);
	}

	public function SendMailReceipt($booking_id)
	{
		$booking = $this->model->getRow('booking_new', ['id' => $booking_id]);
		$property = $this->model->getRow('propmaster', ['id' => $booking->property_id]);
		
		$usermail = $booking->email;
		$phoneNumber = '+919377303613';
		$message2 = 'Hello there!';
		$whatsappLink = "https://wa.me/" . $phoneNumber . "?text=" . urlencode($message2);
		$subject = "Booking Confirmation " . $property->propname;
		$message = "Thank you for booking with " . $property->propname . ". For more details on your booking and invoice, please visit the profile section of your account.<br><br>Call Us: <a href='" . $whatsappLink . "' target='_blank'>+447414110414</a><br>Email Us: support@thehotelreception.com";
		
		// $html = file_get_contents('http://localhost/Hotel_Reception/reservations/printInvoice/' . $booking_id);
	
		// // Create a new PDF document
		// $pdf = new TCPDF();
		// $pdf->AddPage();
		// $pdf->writeHTML($html);
	
		// // Save the PDF to a file system path
		// $directory = FCPATH . 'assets/photo/attachments/';
		// $filePath = $directory . 'INVOICE_' . $booking_id . '.pdf';
	
		// // Create the directory if it doesn't exist
		// if (!is_dir($directory)) {
		// 	mkdir($directory, 0755, true);
		// }
	
		// $pdf->Output($filePath, 'F');
	
		// if (!file_exists($filePath)) {
		// 	log_message('error', 'Failed to create PDF file: ' . $filePath);
		// 	return;
		// }
	
		// // $billPath = IMGS_URL_ROOT . 'attachments/INVOICE_' . $booking_id . '.pdf';
		// // $fileName = 'INVOICE_' . $booking_id . '.pdf';
		
		// $billPath = IMGS_URL_ROOT . 'attachments/INVOICE_58.pdf';
		// $fileName = 'INVOICE_58.pdf';
		// sendMailReceipt($message, $usermail, $subject, $billPath, $fileName);
		//mail and attatchment code
		// $html=file_get_contents('https://www.30minutesvape.co.uk/bill-invoice-open/'.$this->input->post('cartId'));
              
		// $pdf = new TCPDF();
		// $pdf->AddPage();
		// $pdf->writeHTML($html);
		// $pdf->Output('/home/rootvape/public_html/30minutesvape.co.uk/portal/portal/assets/attatchments/INVOICE_'.$this->input->post('cartId').'.pdf', 'F');
		$billPath=IMGS_URL_ROOT.'attachments/test.pdf';
		$fileName='test.pdf';
		sendMailReceipt($message,$usermail,$subject,$billPath,$fileName); 
	}

	public function sendBillEmail($booking_id,$bills)
	{

	}
	
	
	function get_price_new($data = [], $return = "echo")
	{
		
		$post = $this->input->post();
		$pro_id = @$data['pro_id'] ?: $post['pro_id'];
		$room_type = @$data['room_type'] ?: $post['room_type'];
		$qty = (@$data['qty']) ? $data['qty'] : (@$post['qty'] ?: 1);
        $start_date = $post['startDate'];
		$end_date = $post['endDate'];
		$booking_type=$post['booking_type'];
		$dateArray = $this->between_dates($start_date, $end_date);
		if ($post['startDate'] && $post['endDate']) {
			$date = $this->between_dates($post['startDate'], $post['endDate']);
			$nights = ((@$date) ? count($date) : 1);
		}
		foreach ($dateArray as $drow) {
		    $check['date'] 		  = $drow;
			$check['property_id'] = $pro_id;
			$check['sub_pro_type_id'] = $room_type;
			if ($pi = $this->model->getRow('property_inventory', $check)) {
				$where['propid'] = $pro_id;
				$where['sub_property_type_id'] = $room_type;
				$row = $this->model->getRow('property', $where);
				if($booking_type==1){
					$PRICE =  $pi->ep_price;
					$ExtraBedPrice = $pi->ep_extra_bedding_price;
					}elseif($booking_type==2)
					{
					$PRICE =  $pi->cp_price;
					$ExtraBedPrice = $pi->cp_extra_bedding_price;
					}elseif($booking_type==3)
					{
					$PRICE =  $pi->map_price;
					$ExtraBedPrice = $pi->map_extra_bedding_price;
					}elseif($booking_type==4)
					{
					$PRICE =  $pi->ap_price;
					$ExtraBedPrice = $pi->ap_extra_bedding_price;
					}else{
					$PRICE =  $pi->daily_price;
					$ExtraBedPrice = $pi->ep_extra_bedding_price;
					}
					$TAMOUNT = (getTaxAmount(($PRICE)));
				$return_ = [];
				$return_['daily_price'] =  @$PRICE ?: false;
				$return_['extra_bedding_price'] =  @$ExtraBedPrice ?: false;
				$return_['capacity'] =  ((@$row->capacity) ?  (int)$row->capacity * (int)$qty : false);
				$return_['amount'] =  (((@$PRICE) ?  (int)$PRICE * (int)$qty : false));
				$return_['qty'] = $qty;
				$return_['taxRate'] = $TAMOUNT['taxRateNew'];
				$return_['taxAmount'] = $TAMOUNT['taxAmount'];
				$return_['totalAmount'] = $TAMOUNT['TotalAmount'];
				$return_['inventory_yes'] ="YES";
				
			}else{	
		$where['propid'] = $pro_id;
		$where['sub_property_type_id'] = $room_type;

		$row = $this->model->getRow('property', $where);
		if($booking_type==1){
		$PRICE =  $row->daily_price;
		$ExtraBedPrice = $row->ep_extra_bedding_price;
		}elseif($booking_type==2)
		{
		$PRICE =  $row->cp_price;
		$ExtraBedPrice = $row->cp_extra_bedding_price;
		}elseif($booking_type==3)
		{
		$PRICE =  $row->map_price;
		$ExtraBedPrice = $row->map_extra_bedding_price;
		}elseif($booking_type==4)
		{
		$PRICE =  $row->ap_price;
		$ExtraBedPrice = $row->ap_extra_bedding_price;
		}else{
		$PRICE =  $row->daily_price;
		$ExtraBedPrice = $row->ep_extra_bedding_price;
		}
		$TAMOUNT = (getTaxAmount(($PRICE)));
		$return_ = [];
		$return_['inventory_yes'] ="NO";
		$return_['daily_price'] =  @$PRICE ?: false;
		$return_['extra_bedding_price'] =  @$ExtraBedPrice ?: false;
		$return_['capacity'] =  ((@$row->capacity) ?  (int)$row->capacity * (int)$qty : false);
		$return_['amount'] =  ((@$PRICE) ?  ((int)$PRICE * (int)$qty) : false);
		$return_['qty'] = $qty;
		$return_['taxRate'] = $TAMOUNT['taxRateNew'];
		$return_['taxAmount'] = $TAMOUNT['taxAmount'];
		$return_['totalAmount'] = $TAMOUNT['TotalAmount'];
		}
	   }
		if ($this->input->is_ajax_request() && $return == "echo") {

			echo json_encode($return_);
		} else {
			return $return_;
		}
	}


	function get_price_update_new($data = [], $return = "echo")
	{
		$post = $this->input->post();
		$pro_id = @$data['pro_id'] ?: $post['pro_id'];
		$room_type = @$data['room_type'] ?: $post['room_type'];
		$qty = (@$data['qty']) ? $data['qty'] : (@$post['qty'] ?: 1);
		$booking_type=$post['booking_type'];
		$start_date = $post['startDate'];
		$end_date = $post['endDate'];
		$dateArray = $this->between_dates($start_date, $end_date);
		if ($post['startDate'] && $post['endDate']) {
			$date = $this->between_dates($post['startDate'], $post['endDate']);
			$nights = ((@$date) ? count($date) : 1);
		}
		foreach ($dateArray as $drow) {
		    $check['date'] 		  = $drow;
			$check['property_id'] = $pro_id;
			$check['sub_pro_type_id'] = $room_type;
			if ($pi = $this->model->getRow('property_inventory', $check)) {
				$where['propid'] = $pro_id;
				$where['sub_property_type_id'] = $room_type;
				$row = $this->model->getRow('property', $where);
				if($booking_type==1){
					$PRICE =  $pi->ep_price;
					$ExtraBedPrice = $pi->ep_extra_bedding_price;
					}elseif($booking_type==2)
					{
					$PRICE =  $pi->cp_price;
					$ExtraBedPrice = $pi->cp_extra_bedding_price;
					}elseif($booking_type==3)
					{
					$PRICE =  $pi->map_price;
					$ExtraBedPrice = $pi->map_extra_bedding_price;
					}elseif($booking_type==4)
					{
					$PRICE =  $pi->ap_price;
					$ExtraBedPrice = $pi->ap_extra_bedding_price;
					}else{
					$PRICE =  $pi->daily_price;
					$ExtraBedPrice = $pi->ep_extra_bedding_price;
					}
					$TAMOUNT = (getTaxAmount(($PRICE)));
				$return_ = [];
				$return_['daily_price'] =  @$PRICE ?: false;
				$return_['extra_bedding_price'] =  @$ExtraBedPrice ?: false;
				$return_['capacity'] =  ((@$row->capacity) ?  (int)$row->capacity * (int)$qty : false);
				$return_['amount'] =  (((@$PRICE) ?  (int)$PRICE * (int)$qty : false));
				$return_['qty'] = $qty;
				$return_['taxRate'] = $TAMOUNT['taxRateNew'];
				$return_['taxAmount'] = $TAMOUNT['taxAmount'];
				$return_['totalAmount'] = $TAMOUNT['TotalAmount'];
				$return_['inventory_yes'] ="YES";
				
			}else{
		$where['propid'] = $pro_id;
		$where['sub_property_type_id'] = $room_type;
		$row = $this->model->getRow('property', $where);
		if($booking_type==1){
			$PRICE =  $row->daily_price;
			$ExtraBedPrice = $row->ep_extra_bedding_price;
			}elseif($booking_type==2)
			{
			$PRICE =  $row->cp_price;
			$ExtraBedPrice = $row->cp_extra_bedding_price;
			}elseif($booking_type==3)
			{
			$PRICE =  $row->map_price;
			$ExtraBedPrice = $row->map_extra_bedding_price;
			}elseif($booking_type==4)
			{
			$PRICE =  $row->ap_price;
			$ExtraBedPrice = $row->ap_extra_bedding_price;
			}else{
			$PRICE =  $row->daily_price;
			$ExtraBedPrice = $row->ep_extra_bedding_price;
			}
			$TAMOUNT = (getTaxAmount($PRICE));
		$return_ = [];
		$return_['inventory_yes'] ="NO";
		$return_['daily_price'] =  @$PRICE ?: false;
		$return_['extra_bedding_price'] =  @$ExtraBedPrice ?: false;
		$return_['capacity'] =  ((@$row->capacity) ?  (int)$row->capacity * (int)$qty : false);
		$return_['amount'] =  ((@$PRICE) ?  (int)$PRICE * (int)$qty : false);
		$return_['qty'] = $qty;
		$return_['taxRate'] = $TAMOUNT['taxRateNew'];
		$return_['taxAmount'] = $TAMOUNT['taxAmount'];
		$return_['totalAmount'] = $TAMOUNT['TotalAmount'];
		}
	    }
		if ($this->input->is_ajax_request() && $return == "echo") {

			echo json_encode($return_);
		} else {
			return $return_;
		
	}
}
// 	function check_availability_update($data = [], $return = "echo")
// 	{
// 		$mybooked=0;
// 		$post = $this->input->post();
// 		$booking_id = @$data['booking_id'] ?: $post['booking_id'];
// 		$pro_id = @$data['pro_id'] ?: $post['pro_id'];
// 		$room_type = @$data['room_type'] ?: $post['room_type'];
// 		$startDate = @$data['startDate'] ?: $post['startDate'];
// 		$endDate = @$data['endDate'] ?: $post['endDate'];

// 		if (@$pro_id && @$room_type && @$startDate && @$endDate) {
// 			$dateArray = $this->between_dates($startDate, $endDate);
// 			$where['propid'] = $pro_id;
// 			$where['s_p_type_id'] = $room_type;
// 			$row = $this->model->getRow('propmaster_s_p_availability', $where);
       
// //  check already my room
//            // $this->db->select('SUM(no_of_rooms) as booked');
//             $this->db->select('booking_new_inventory.no_of_rooms as booked');
// 			$this->db->from('booking_new_inventory');
// 			$this->db->join('booking_new','booking_new.id=booking_new_inventory.booking_id');
// 			$this->db->where(['booking_new_inventory.property_id' => $pro_id, 'booking_new_inventory.booking_type_id' => $room_type,'booking_new.id'=>$booking_id,'booking_new.cancellation'=>'NO']);
// 			$this->db->where_in('date', $dateArray);
// 			$mybooked = $this->db->get()->row();

// 			// $this->db->select('SUM(no_of_rooms) as booked');
// 			$this->db->select('booking_new_inventory.no_of_rooms as booked');
// 			$this->db->from('booking_new_inventory');
// 			$this->db->join('booking_new','booking_new.id=booking_new_inventory.booking_id');
// 			$this->db->where(['booking_new_inventory.property_id' => $pro_id, 'booking_new_inventory.booking_type_id' => $room_type,'booking_new.cancellation'=>'NO']);
// 			$this->db->where_in('date', $dateArray);
// 			$booked = $this->db->get()->row();
// 			if (@$booked) {
// 				$available =$mybooked->booked + $row->available - $booked->booked;
// 			} else {
// 				$available = $row->available;
// 			}
// 		}

// 		if ($this->input->is_ajax_request() && $return == "echo") {
// 			echo @$available ?: false;
// 			// echo 5;
// 		} else {
// 			return @$available ?: false;
// 		}
// 	}
function check_availability_update($data = [], $return = "echo")
{
    $mybooked = 0;
	$RoomBooked=0;
    $post = $this->input->post();
    $booking_id = @$data['booking_id'] ?: $post['booking_id'];
    $pro_id = @$data['pro_id'] ?: $post['pro_id'];
    $room_type = @$data['room_type'] ?: $post['room_type'];
    $startDate = @$data['startDate'] ?: $post['startDate'];
    $endDate = @$data['endDate'] ?: $post['endDate'];

    if (@$pro_id && @$room_type && @$startDate && @$endDate) {
        $dateArray = $this->between_dates($startDate, $endDate);
        $where['propid'] = $pro_id;
        $where['s_p_type_id'] = $room_type;
        $row = $this->model->getRow('propmaster_s_p_availability', $where);

        // Check already my room
        $this->db->select('SUM(booking_new_inventory.no_of_rooms) as booked');
        $this->db->from('booking_new_inventory');
        $this->db->join('booking_new', 'booking_new.id = booking_new_inventory.booking_id');
        $this->db->where([
            'booking_new_inventory.property_id' => $pro_id,
            'booking_new_inventory.booking_type_id' => $room_type,
            'booking_new.id' => $booking_id,
            'booking_new.cancellation' => 'NO'
        ]);
        $this->db->where_in('date', $dateArray);
        $mybooked = $this->db->get()->row();

        // Check total booked rooms
        $this->db->select('SUM(booking_new_inventory.no_of_rooms) as booked');
        $this->db->from('booking_new_inventory');
        $this->db->join('booking_new', 'booking_new.id = booking_new_inventory.booking_id');
        $this->db->where([
            'booking_new_inventory.property_id' => $pro_id,
            'booking_new_inventory.booking_type_id' => $room_type,
            'booking_new.cancellation' => 'NO',
			'booking_new.status !=' => '5',
        ]);
        $this->db->where_in('date', $dateArray);
        $booked = $this->db->get()->row();
		// Join with room alloted and check status
		$this->db->select('*');
		$this->db->from('room_allotment');
		$this->db->where([
			'property_id' => $pro_id,
			'room_type' => $room_type,
			'is_checkout'=>'0'
		]);
		$Rooms = $this->db->get()->result();
		$RoomBooked= count($Rooms);
        // Join with property_inventory and check status
        $this->db->select('status');
        $this->db->from('property_inventory');
        $this->db->where([
            'property_id' => $pro_id,
            'sub_pro_type_id' => $room_type
        ]);
        $inventory_status = $this->db->get()->row();

        if (@$inventory_status && $inventory_status->status == 2) {
            // All rooms are blocked
            $available = 0;
        } else {
            // Calculate available rooms
            if (@$booked) {
                $available = ($mybooked->booked + $row->available - $booked->booked);
            } else {
                $available = $row->available-$RoomBooked;
            }
        }
    }

    if ($this->input->is_ajax_request() && $return == "echo") {
        echo @$available ?: false;
    } else {
        return @$available ?: false;
    }
}

function check_availability($data = [], $return = "echo")
{
    $post = $this->input->post();
	$RoomBooked=0;
    $pro_id = @$data['pro_id'] ?: $post['pro_id'];
    $room_type = @$data['room_type'] ?: $post['room_type'];
    $startDate = @$data['startDate'] ?: $post['startDate'];
    $endDate = @$data['endDate'] ?: $post['endDate'];

    if (@$pro_id && @$room_type && @$startDate && @$endDate) {
        $dateArray = $this->between_dates($startDate, $endDate);
        $where['propid'] = $pro_id;
        $where['s_p_type_id'] = $room_type;
        $row = $this->model->getRow('propmaster_s_p_availability', $where);

        // Check available rooms
        $this->db->select('booking_new_inventory.no_of_rooms as booked');
        $this->db->from('booking_new_inventory');
        $this->db->join('booking_new', 'booking_new.id = booking_new_inventory.booking_id');
        $this->db->where([
            'booking_new_inventory.property_id' => $pro_id,
            'booking_new_inventory.booking_type_id' => $room_type,
            'booking_new.cancellation' => 'NO',
			'booking_new.status !=' => '5',
        ]);
        $this->db->where_in('booking_new_inventory.date', $dateArray);
        $booked = $this->db->get()->row();


		 // Join with room alloted and check status
		 $this->db->select('*');
		 $this->db->from('room_allotment');
		 $this->db->where([
			 'property_id' => $pro_id,
			 'room_type' => $room_type,
			 'is_checkout'=>'0'
		 ]);
		 $Rooms = $this->db->get()->result();
         $RoomBooked= count($Rooms);
        // Join with property_inventory and check status
        $this->db->select('status');
        $this->db->from('property_inventory');
        $this->db->where([
            'property_id' => $pro_id,
            'sub_pro_type_id' => $room_type
        ]);
        $inventory_status = $this->db->get()->row();

        if (@$inventory_status && $inventory_status->status == 2) {
            // All rooms are blocked
            $available = 0;
        } else {
            // Calculate available rooms
            if (@$booked) {
                $available = ($row->available - $booked->booked);
            } else {
                $available = $row->available-$RoomBooked;
            }
        }
    }

    if ($this->input->is_ajax_request() && $return == "echo") {
        echo @$available ?: false;
    } else {
        return @$available ?: false;
    }
}

	// function check_availability($data = [], $return = "echo")
	// {
	// 	$post = $this->input->post();
	// 	$pro_id = @$data['pro_id'] ?: $post['pro_id'];
	// 	$room_type = @$data['room_type'] ?: $post['room_type'];
	// 	$startDate = @$data['startDate'] ?: $post['startDate'];
	// 	$endDate = @$data['endDate'] ?: $post['endDate'];

	// 	if (@$pro_id && @$room_type && @$startDate && @$endDate) {
	// 		$dateArray = $this->between_dates($startDate, $endDate);
	// 		$where['propid'] = $pro_id;
	// 		$where['s_p_type_id'] = $room_type;
	// 		$row = $this->model->getRow('propmaster_s_p_availability', $where);
    // //    check available room 
	// 		// $this->db->select('SUM(no_of_rooms) as booked');
	// 		$this->db->select('booking_new_inventory.no_of_rooms as booked');
	// 		$this->db->from('booking_new_inventory');
	// 		$this->db->join('booking_new','booking_new.id=booking_new_inventory.booking_id');
	// 		$this->db->where(['booking_new_inventory.property_id' => $pro_id, 'booking_new_inventory.booking_type_id' => $room_type,'booking_new.cancellation'=>'NO']);
	// 		$this->db->where_in('booking_new_inventory.date', $dateArray);
	// 		$booked = $this->db->get()->row();
	// 		if (@$booked) {
	// 			$available =$row->available - $booked->booked;
	// 		} else {
	// 			$available = $row->available;
	// 		}
	// 	}

	// 	if ($this->input->is_ajax_request() && $return == "echo") {
	// 		echo @$available ?: false;
	// 		// echo 5;
	// 	} else {
	// 		return @$available ?: false;
	// 	}
	// }
	function count_nights()
	{
		$post = $this->input->post();
		if ($post['startDate'] && $post['endDate']) {
			$date = $this->between_dates($post['startDate'], $post['endDate']);
			echo ((@$date) ? count($date) : 1);
		}
	}
	function find_taxRate()
	{
		$post = $this->input->post();
		if ($post['amount']) {
			$TAMOUNT = getTaxAmount($post['amount']);
			$taxRate = isset($TAMOUNT['taxRate']) ? (float)str_replace('%', '', $TAMOUNT['taxRate']) : 12;
			echo $taxRate;
		}
	}
	
	

	function count_nights_update()
	{
		$post = $this->input->post();
		if ($post['startDate'] && $post['endDate']) {
			$date = $this->between_dates($post['startDate'], $post['endDate']);
			echo ((@$date) ? count($date) : 1);
		}
	}
	






	public function reservation($pro_id, $flat_id, $clicked_date = null)
	{
		$data['user'] = $user  = $this->checkLogin();

		if ($clicked_date == null) {
			$clicked_date = date('Y-m-d');
		}

		$clicked_date2 			 = date("Y-m-d", strtotime($clicked_date . '+ 1 day '));
		$data['clicked_date2'] 	 = $clicked_date2;
		$data['clicked_date'] 	 = $clicked_date;
		$tmpDateArray 			 = $this->between_dates($clicked_date, $clicked_date2);
		$data['tmpPrice']  		 = $this->get_price($tmpDateArray, $flat_id);
		$data['tmpPriceT']  	 = $data['tmpPrice'] + $this->service_charges;

		$data['pro_id'] 	  	 = $pro_id;
		$data['flat_id']      	 = $flat_id;
		$return['res'] 		  	 = 'error';
		$return['msg'] 		  	 = 'Someting Worng!';

		$data['service_charges'] = $this->service_charges;
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			// payment_status
			$payment_status = 2;
			if ($_POST['payment_mode'] == '' or $_POST['payment_mode'] == 6) {
				$payment_status = 1;
			}
			if ($_POST['payment_mode'] == 2) {
				$payment_status = 3;
			}
			// payment_status


			if (@$_POST['skip_verification']) {
				if (@$_POST['skip_verification'] != 'on') {
					if ($otp = $this->model->getRow('otp', ['mobile' => $_POST['mobile']])) {
						if ($otp->otp != $_POST['verification_code']) {
							$return['msg'] 		  = 'Verification Code Incorrect!';
							echo json_encode($return);
							die();
						}
						$this->model->Delete('otp', ['mobile' => $_POST['mobile']]);
					}
				}
			}

			// $this->pr($_POST);
			$property = $this->model->getRow('property', ['flat_id' => $flat_id]);

			if ($_POST['of_adults'] == 0) {
				$_POST['of_adults'] = 1;
			}


			if ($property->capacity < $_POST['of_adults']) {
				$return['msg'] 		  = 'Out Of Capacity!';
				echo json_encode($return);
				die();
			}


			// from date - to date
			if (@$_POST['startDate'] && @$_POST['endDate']) {
				$dateArray = $this->between_dates($_POST['startDate'], $_POST['endDate']);
			} else {
				$return['msg'] 		  = 'Date not selected!';
				echo json_encode($return);
				die();
			}
			// from date - to date

			if ($this->date_availability($dateArray, $flat_id) == false) {
				$return['msg'] = 'Selected Dates Not Available!';
				echo json_encode($return);
				die();
			}

			// validation
			if ($_POST['mobile'] == '') {
				$return['msg'] = 'Enter Guest Mobile Number.';
				echo json_encode($return);
				die();
			}

			if (!validate_mobile($_POST['mobile'])) {
				$return['msg'] = 'Invalid Mobile Number!';
				echo json_encode($return);
				die();
			}

			if ($_POST['name'] == '') {
				$return['msg'] = 'Enter Guest Name!';
				echo json_encode($return);
				die();
			}

			if ($_POST['payment_mode'] == '') {
				$return['msg'] = 'Select payment mode!';
				echo json_encode($return);
				die();
			}
			//validation

			$price  = $this->get_price($dateArray, $flat_id);

			if ($_POST['price'] > $price) {
				$price  = $_POST['price'];
			} elseif ($_POST['price'] < $price) {
				$price  = $_POST['price'];
			} else {
				$price  = $this->get_price($dateArray, $flat_id);
			}


			// $this->pr($dateArray);
			if ($appuser = $this->model->getRow('appuser', ['mobile' => $_POST['mobile']])) {
				$guest_id = $appuser->id;
				$_POST['mobile'] = $appuser->mobile;
			} else {
				$saveappuser['mobile'] 	= $_POST['mobile'];
				$saveappuser['name'] 	= $_POST['name'];
				$saveappuser['dob'] 	= $_POST['dob'];
				$saveappuser['gender'] 	= $_POST['gender'];
				$saveappuser['email'] 	= $_POST['email'];
				if ($guest_id = $this->model->Save('appuser', $saveappuser)) {
				} else {
					$guest_id = false;
				}
			}

			if ($guest_id) {
				$guest = $this->model->getRow('appuser', ['id' => $guest_id]);
				$insertArry['renter_type'] 			= '';
				$insertArry['booking_type'] 		= '';
				$insertArry['booking_from'] 		= 'PANEL';
				$insertArry['guest_id'] 			= $guest_id;
				$insertArry['confirmation_code'] 	= $confirmation_code = rand(10000, 99999);
				$insertArry['status'] 				= 2;
				$insertArry['guest_name'] 			= $guest->name;
				$insertArry['gender'] 				= $guest->gender;
				$insertArry['email'] 				= $guest->email;
				$insertArry['contact'] 				= $guest->mobile;
				$insertArry['of_adults'] 			= $_POST['of_adults'];
				$insertArry['of_children'] 			= $_POST['of_children'];
				$insertArry['of_infants'] 			= $_POST['of_infants'];
				$insertArry['start_date'] 			= $dateArray[0];
				$insertArry['end_date'] 			= $_POST['endDate'];
				$insertArry['booking_type'] 		= $_POST['booking_type'];
				$insertArry['of_nights'] 			= count($dateArray);
				$insertArry['booked'] 				= '';
				$insertArry['listing'] 				= '';
				// $insertArry['earnings'] 			= '';
				$insertArry['flat_id'] 				= $data['flat_id'];
				$insertArry['notes'] 				= '';
				// $insertArry['checkin_time'] 		= null;
				$insertArry['checkin_status'] 		= 0;
				$insertArry['purpose_of_trip'] 		= '';
				$insertArry['vehcleno'] 			= '';
				// $insertArry['checkout_time1'] 		= null;
				$insertArry['price_type'] 			= '';
				$insertArry['price'] 				= ((int)$price + $this->service_charges) - (int)$_POST['discount_amount'];
				$insertArry['user_id'] 				= $user->id;
				$insertArry['security_deposit'] 	= '';
				$insertArry['lockin_days'] 			= '';
				$insertArry['notice_days'] 			= '';
				$insertArry['is_foreigner'] 		= $_POST['is_foreigner'];
				$insertArry['booking_remark'] 		= $_POST['booking_remark'];
				$insertArry['order_id'] 			= '';
				$insertArry['booking_id'] 			= '';
				$insertArry['rzp_payment_id'] 		= '';
				$insertArry['price_currency'] 		= '';
				$insertArry['rzp_capture_response'] = '';
				$insertArry['booking_date'] 		= date('Y-m-d');
				$insertArry['rzp_refund_response'] 	= '';
				$insertArry['discount_amount'] 		= $_POST['discount_amount'];
				$insertArry['discount_remark'] 		= $_POST['discount_remark'];
				$insertArry['service_charges']		= $this->service_charges;
				$insertArry['payment_mode']			= $_POST['payment_mode'];
				$insertArry['payment_status']		= $payment_status;
				$insertArry['reference_id']			= $_POST['reference_id'];
				$insertArry['agent_id']				= $_POST['agent'];
				// $insertArry['discount_remark']		= $_POST['discount_remark'];

				// $insertArry['wave_of_ermark'] 	= 8;
				// $insertArry['wave_of_remark'] 	= 5;



				$trArry['tr_date']				= date('Y-m-d');
				$trArry['type']					= $_POST['payment_mode'];
				$trArry['credit']				= $_POST['advanced'];
				$trArry['reference_no']			= $_POST['reference_id'];

				if ($booked = $this->model->Save('booking', $insertArry)) {
					$trArry['booking_id'] = $booked;
					$this->model->Save('transaction', $trArry);
					$return['res'] 		  = 'success';
					$return['msg'] 		  = 'Bookings Successful.';
				}

				if ($booked) {    			// update Calendar

					$this->update_inventory($dateArray, $flat_id, 3, $booked);
					$this->save_booking_row_items($booked, $flat_id, $extra_bedding = 0);
					//					if (@$_POST['payment_mode']==6) {
					//						file_get_contents(base_url().'send-payment-link/'.$booked);
					//					}
					//					$this->send_email($booked);
				}
				$return['receipt_url'] = base_url() . 'receipt/' . $booked;
			} else {
				$return['msg'] 		  = 'Guest Not selected!';
			}


			echo json_encode($return);
			// $this->pr($_POST);
		} else {
			$user_id = value_encryption(get_cookie('6050c764989e5'), 'decrypt');
			$data['booking_type'] = $this->model->getData('booking_type', ['status' => 1], 'asc', 'type');
			$data['agent'] = $this->model->getData('agent', ['owner_id' => $user_id]);
			$data['new_url_agent'] = base_url() . 'reservations/add_agent/';
			$data['property'] = $this->model->getRow('property', ['flat_id' => $flat_id]);
			$data['contant']  = 'reservations/new_reservation';
			$data['guests']   = $this->model->getData('appuser', 0, 'asc', 'name');
			$data['payment_mode']   = $this->model->getData('payment_mode', ['status' => 1], 'asc', 'mode');

			// $this->pr($data);
			// die();

			load_view($data['contant'], $data);
		}
	}


	public function cancel_booking($id, $response = 'yes')
	{
         
		if ($response == 'yes') {
			if ($this->input->server('REQUEST_METHOD') == 'POST') {
				$return['res'] 		  = 'error';
				$return['msg'] 		  = 'Someting Worng!';
				$return['msg'] 		  = json_encode($_POST);
				$row= $booking    = $this->model->getRow('booking_new', ['id' => $id]);
				$property  = $this->model->getRow('propmaster', ['id' => $booking->property_id]);
				$firstdate =  $row->start_date;
				$lastdate = date('Y-m-d');
				$given_datetime2 = new DateTime($row->booking_date);
				$bookingtime = $given_datetime2->format('H:i:s');
				$given_time = $property->checkintime;
				$given_datetime = new DateTime($given_time);
				$one_hour_later = $given_datetime->sub(new DateInterval('PT1H'));
				$result_time = $one_hour_later->format('H:i:s');
				$start_date = new DateTime($row->start_date);
				$end_date = new DateTime($row->end_date);
				$date_range = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);
				foreach ($date_range as $date) {
				 $newdatabooking =  $date->format('Y-m-d');
				 if( $result_time <= $bookingtime)
				 {
					$return['res'] 		  = 'error';
					$return['msg'] 		  = "We can't cancel this booking!";
					echo json_encode($return);
				   die();
				 }
			   }  
				if ($this->_cancelBooking($id)) {
					$this->send_email($id, 'cancel');
					$return['res'] 		  = 'success';
					$return['msg'] 		  = 'Booking Canceled.';
				}
				echo json_encode($return);
			} else {
				$data['row'] = $booking    = $this->model->getRow('booking_new', ['id' => $id]);
				$data['property']  = $this->model->getRow('propmaster', ['id' => $booking->property_id]);
				$data['cancel']     = $this->model->getRow('cancellations_booking', ['property_id' => $data['row']->property_id ]);
				$cond 			 = ['status' => 1];
				$data['transaction']     = $this->model->getRow('transaction', ['booking_id' => $id]);
				$data['creason'] = $this->model->getData('cancellation_reason_master', $cond);
				$data['cancellation'] = $this->model->getData('cancellations_booking',['property_id' => $data['row']->property_id ]);
				$data['a_url']	 = base_url() . 'cancel-booking/' . $id;
				$data['contant'] = 'reservations/cancel_reservation';
				load_view($data['contant'], $data);
			}
		} else {
			$this->_cancelBooking($id);
		}
	}


	private function _cancelBooking($id)
	{
		$data['user']    = $user = $this->checkLogin();
		$row = $booking=$this->model->getRow('booking_new', ['id' => $id]);
		$property  = $this->model->getRow('propmaster', ['id' => $booking->property_id]);
				$firstdate =  $row->start_date;
				$lastdate = date('Y-m-d');
				$given_datetime2 = new DateTime($row->booking_date);
				$bookingtime = $given_datetime2->format('H:i:s');
				$given_time = $property->checkintime;
				$given_datetime = new DateTime($given_time);
				$one_hour_later = $given_datetime->sub(new DateInterval('PT1H'));
				$result_time = $one_hour_later->format('H:i:s');
				$start_date = new DateTime($row->start_date);
				$end_date = new DateTime($row->end_date);
				$date_range = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);
			   // print_r($date_range);
				foreach ($date_range as $date) {
				 $newdatabooking =  $date->format('Y-m-d');
				 if( $result_time <= $bookingtime)
				 {
					$return['res'] 		  = 'error';
					$return['msg'] 		  = "We can't cancel this booking!";
					echo json_encode($return);
				   die();
				 }
			   } 
		$updateArray['status'] = 4;
		if (@$_POST['cancellation_reason_id']) {
			$updateArray['cancellation_reason_id'] = $_POST['cancellation_reason_id'];
		}
		if (@$_POST['refund_amount']) {
			$updateArray['refund_amount'] = $_POST['refund_amount'];
			$checkOutArray['received_amount'] = $_POST['refund_amount'];
			$refund['debit'] = $_POST['refund_amount'];
			$refund['remark'] = 'Refund Amount';
			$refund['action'] = "cancel";
			$refund['active'] = '1';
			$refund['booking_id'] = $id;
		}
		if (@$_POST['cancellation_note']) {
			$updateArray['cancellation_note'] = $_POST['cancellation_note'];
		}
		if (@$_POST['cancellation_charge']) {
			$updateArray['cancellation_charge'] = $_POST['cancellation_charge'];
		}
		if (@$_POST['is_igst']) {
			$updateArray['is_igst'] = $_POST['is_igst'];
		}
		$updateArray['cancellation'] = "YES"; 
		$this->model->Save('transaction', $refund);
		// generate bill no
		$booking = $this->model->getRow('booking_new',['id'=>$id]);
		$property = $this->model->getRow('propmaster',['id'=>$booking->property_id]);
		$property_doc = $this->model->getRow('propmaster_document',['prop_m_id'=>$property->id]);
		if(!empty($property->bill_format))
		{
			$rto_code = '0000'.$property->bill_format;	
		}else
		{
			$rto_code = '0000';
		}
		
		$last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('checkout_new')->row();
		if (@$last_row->bill_no) {
			$propcode ='0000'.$last_row->bill_no+1;
		}else{
			$propcode = $rto_code;
		}

		$this->model->Update('booking_new', $updateArray, ['id' => $id]);
		logs($user->id,$id,'CHANGE_STATUS','Change Booking ');
			$time = time();
			if(@$_POST['is_igst']==1){
			$checkOutArray = array(
				'booking_id' => $id,
				'guest_name' => $booking->guest_name,
				'contact_no' => $booking->contact,
				'email' => $booking->email,
				'check_out_date_time' => time(),
				'bill_no' =>$propcode,
				'property_name' =>$property->propname,
				'property_gst' => $property_doc->gst_no,
				'property_contact' =>$property->contact_preson_mobile,
				'property_email' =>$property->email,
				'is_cancel'=>'YES',
			);
		}else{
			$checkOutArray = array(
				'booking_id' => $id,
				'guest_name' => $booking->guest_name,
				'contact_no' => $booking->contact,
				'email' => $booking->email,
				'check_out_date_time' => time(),
				'bill_no' =>$propcode,
				'property_name' =>$property->propname,
				// 'property_gst' => $property_doc->gst_no,
				'property_contact' =>$property->contact_preson_mobile,
				'property_email' =>$property->email,
				'is_cancel'=>'YES',
			);
		}
			$this->model->Save('checkout_new', $checkOutArray);
			logs($user->id,$id,'CHANGE_STATUS','cancel Booking ');
		$row_items['fk_flat_id'] = $id;
		$this->model->Delete('booking_row_items', $row_items);
		logs($user->id,$id,'DELETE','Delete Booking Items');
		$period = new DatePeriod(
			new DateTime($row->start_date),
			new DateInterval('P1D'),
			new DateTime($row->end_date)
		);
		foreach ($period as $date) {
			$dateArray[] = $date->format('Y-m-d');
		}
		$dateArray[] = $row->end_date;

		$price = 0;
		foreach ($dateArray as $drow) {
			$check['date'] 		  = $drow;
			$check['property_id'] = $row->property_id;
			$updateCal['status']  = 1;
			$this->model->Update('property_inventory', $updateCal, $check);
			logs($user->id,$row->property_id,'EDIT','Edit Property Inventory');
		}

		return true;
	}

	public function inventry($flat_id, $date)
	{
		$check['property_id']  = $flat_id;
		$check['date']         = $date;
		$daily_price = $extra_bedding_price = 0;
		$cal = '';
		$astatus =  $bstatus =  $disabled = '';
		if ($row = $this->model->getRow('property_inventory', $check)) {
			$daily_price = $row->daily_price;
			$extra_bedding_price = $row->extra_bedding_price;

			if ($row->status == 1) {
				$astatus = 'selected';
				$disabled = '';
			}
			if ($row->status == 2) {
				$bstatus = 'selected';
				$disabled = 'disabled';
			}
			if ($row->status == 3) {
				$disabled = 'disabled';
			}
		}
		$cal .= "<label>Daily Price</label>";
		$cal .= "<input type='number' class='form-control input-sm' oninput='save_inventory(this)' p-type='daily_price' p-date='$date' f-id='$flat_id' min=0 value='$daily_price' >";
		$cal .= "<label>Extra Bedding Price</label>";
		$cal .= "<input type='number' class='form-control input-sm' oninput='save_inventory(this)' p-type='extra_bedding_price' p-date='$date' f-id='$flat_id' min=0 value='$extra_bedding_price'>";
		$cal .= "<label>Status</label>";
		if (@$row->status != 3) {
			$cal .= "<select class='form-control input-sm' onchange='save_inventory(this)' p-type='status' p-date='$date' f-id='$flat_id'><option value='0' > -- Status --</option><option value='1' $astatus >Available </option><option value='2' $bstatus > Blocked</option></select>";
		}
		if (@$row->status == 3) {
			$cal .= '<span class="text-info d-flex justify-content-center">Reservated</span>';
		}

		echo $cal;
	}

	public function check_availability_price($flat_id)
	{
		// $this->pr($_POST);
		$this->checkLogin();
		$data['flat_id']      = $flat_id;
		$return['res'] 		  = 'error';
		$return['msg'] 		  = 'Someting Worng!';

		// from date - to date
		if (@$_POST['start_date'] && @$_POST['end_date']) {
			$dateArray = $this->between_dates($_POST['start_date'], $_POST['end_date']);
		} else {
			$return['res'] = 'notoast';
			echo json_encode($return);
			die();
		}
		// from date - to date


		if ($this->date_availability($dateArray, $flat_id) == false) {
			$return['msg'] = 'Selected Dates Not Available!';
		} else {
			$return['res'] 	  = 'success';
			$return['msg']    = 'Selected Dates Available!';
			$return['price']  = $this->get_price($dateArray, $flat_id);
		}

		echo json_encode($return);
	}

	public function check_availability_price_flat()
	{
		$data['flat_id']  	 = $flat_id    = $_POST['flat_id'];
		$data['booking_id']  = $booking_id = $_POST['booking_id'];
		$data['startDate']   = $startDate  = $_POST['startDate'];
		$booking = $this->booking_detailes($booking_id);
		$property  = $this->property_detailes($flat_id);

		$return['res'] 		   = 'error';
		$return['msg'] 		   = 'Someting Worng!';
		$data['user'] = $user  = $this->checkLogin();

		// from date - to date
		if (@$startDate && @$booking->end_date) {
			$dateArray = $this->between_dates($startDate, $booking->end_date);
		} else {
			$return['msg'] 		  = 'Date not selected!';
			echo json_encode($return);
			die();
		}
		// from date - to date


		if ($this->date_availability($dateArray, $flat_id) == false) {
			$return['msg'] = 'Selected Dates Not Available!';
			echo json_encode($return);
			die();
		} else {
			$return['res'] 	 = 'success';
			$return['msg']   = 'Selected Dates Available!';
			$return['price'] = $this->get_price($dateArray, $flat_id);
			echo json_encode($return);
			die();
		}
	}

	public function check_availability_price_reschedule($flat_id, $booking_id)
	{
		// $this->pr($_POST);
		$this->checkLogin();
		$data['flat_id']    = $flat_id;
		$return['res'] 		= 'error';
		$return['msg'] 		= 'Someting Worng!';
		$booking 			= $this->booking_detailes($booking_id);


		$oldBookingDateArray = $this->between_dates($booking->start_date, $booking->end_date);

		// from date - to date
		if (@$_POST['start_date'] && @$_POST['end_date']) {
			$dateArray = $this->between_dates($_POST['start_date'], $_POST['end_date']);
		} else {
			$return['res'] = 'notoast';
			echo json_encode($return);
			die();
		}
		// from date - to date

		// $this->pr($dateArray);

		$date_availability = true;
		$property = $this->model->getRow('property', ['flat_id' => $flat_id]);

		$price = 0;
		foreach ($dateArray as $drow) {
			$check['date'] 		  = $drow;
			$check['property_id'] = $flat_id;
			if ($pi = $this->model->getRow('property_inventory', $check)) {
				// $previous_date = 0;
				foreach ($oldBookingDateArray as $bdrow) {
					if ($bdrow == $drow) {
						$pi->status = 1;
					}
				}

				if ($pi->status == 2 or $pi->status == 3) {
					$date_availability = false;
				}
			}
		}

		if ($date_availability == false) {
			$return['msg'] = 'Selected Dates Not Available!';
		} else {
			$return['res'] 		= 'success';
			$return['msg'] 		= 'Selected Dates Available!';
			$return['price'] 	= $this->get_price($dateArray, $flat_id);
		}
		echo json_encode($return);
	}


	public function check_in_remaining()
	{
		$data["user"]    = $user = $this->checkLogin();

		$function = 'bookings_new';
		if ($user->type == "host") {
			$function = 'host_bookings_new';
		}
		$month = date('m');
		$year  = date('Y');
		if (@$_GET['m']) {
			$month = $_GET['m'];
		}
		if (@$_GET['Y']) {
			$year  = $_GET['Y'];
		}

		$current_Month 	= $month;
		$year 			= $year;
		$FristDateOfMonth = $year . '-' . $month . '-01';
		$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

		if (@$_GET['date']) {
			$data["date"] = $date = $_GET['date'];
		} else {
			$data["date"]  = $date  = date('Y-m-d');
		}

		$data["month"] = $month;
		$data["year"]  = $year;
		$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

		if (@$_COOKIE['property_id']) {
			$_POST['propmaster'] = $_COOKIE['property_id'];
		}

		$bookings = $this->model->$function();
		if(!empty($bookings))
		{
		 $booking = $bookings;
		}else
		{
		 $booking=[];
		}
		// $this->pr($bookings);
		// prx($bookings);

		$rows = array();
		foreach ($booking as $brow) {
			if ($brow->start_date == $date && $brow->status == 2 && $brow->checkin_status == 0) {
				$rows[] = $brow;
			}
		}
		$data['rows'] = $rows;

		// $this->pr($data);
		$data['check_out_url'] = base_url() . 'checkout/';
		$data['check_pre_out_url'] = base_url() . 'pre-check-out/';
		$data['contant']  = 'reservations/report_list_check_in_remaining';
		$data['detail_url']	  =  base_url() . 'checkin/detailes/';
		$data['check_in_url'] = base_url() . 'checkin/';
		
		load_view($data['contant'], $data);

		// echo date('Y-m-d');
	}

	public function checked_in()
	{
		$data["user"]    = $user = $this->checkLogin();

		$function = 'bookings_new';
		if ($user->type == "host") {
			$function = 'host_bookings_new';
		}
		$month = date('m');
		$year  = date('Y');
		if (@$_GET['m']) {
			$month = $_GET['m'];
		}
		if (@$_GET['Y']) {
			$year  = $_GET['Y'];
		}

		$current_Month 	= $month;
		$year 			= $year;
		$FristDateOfMonth = $year . '-' . $month . '-01';
		$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

		if (@$_GET['date']) {
			$data["date"] = $date = $_GET['date'];
		} else {
			$data["date"]  = $date  = date('Y-m-d');
		}

		$data["month"] = $month;
		$data["year"]  = $year;
		$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

		$bookings = $this->model->$function();
		if(!empty($bookings))
		{
		 $booking = $bookings;
		}else
		{
		 $booking=[];
		}
		$rows = array();
		foreach ($booking as $brow) {
			// $brow->start_date == $date && 
			if ($brow->status == 2 && $brow->checkin_status == 1) {
				$rows[] = $brow;
			}
		}
		$data['rows'] = $rows;

		// $this->pr($data);

		$data['contant']  = 'reservations/report_list_checked_in';
		$data['detail_url']	  =  base_url() . 'checkout/detailes/';
		$data['check_out_url'] = base_url() . 'checkout/';
		$data['check_pre_out_url'] = base_url() . 'pre-check-out/';
		load_view($data['contant'], $data);

		// echo date('Y-m-d');
	}

	public function check_out_remaining()
	{
		$data["user"]    = $user = $this->checkLogin();

		$function = 'bookings_new';
				if ($user->type == 'host') {
					$function = 'host_bookings_new';
				}
		$month = date('m');
		$year  = date('Y');
		if (@$_GET['m']) {
			$month = $_GET['m'];
		}
		if (@$_GET['Y']) {
			$year  = $_GET['Y'];
		}

		$current_Month 	= $month;
		$year 			= $year;
		$FristDateOfMonth = $year . '-' . $month . '-01';
		$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

		if (@$_GET['date']) {
			$data["date"] = $date = $_GET['date'];
		} else {
			$data["date"]  = $date  = date('Y-m-d');
		}

		$data["month"] = $month;
		$data["year"]  = $year;
		$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

		$bookings = $this->model->$function();
		if(!empty($bookings))
		{
		 $booking = $bookings;
		}else
		{
		 $booking=[];
		}
		$rows = array();
		foreach ($booking as $brow) {
			// $brow->end_date == $date &&
			if ($brow->end_date == $date &&  $brow->status == 2 && $brow->checkout_time1 == null) {
				$rows[] = $brow;
			}
		}
		$data['rows'] = $rows;

       //$this->pr($rows);

		$data['contant']       = 'reservations/report_list_check_out_remaining';
		$data['detail_url']	  =  base_url() . 'checkout/detailes/';
		$data['check_out_url'] = base_url() . 'checkout/';
		load_view($data['contant'], $data);

		// echo date('Y-m-d');
	}

	public function checked_out()
	{
		$data["user"]    = $user = $this->checkLogin();

		$function = 'bookings_new';
		if ($user->type == 'host') {
			$function = 'host_bookings_new';
		}
		$month = date('m');
		$year  = date('Y');
		if (@$_GET['m']) {
			$month = $_GET['m'];
		}
		if (@$_GET['Y']) {
			$year  = $_GET['Y'];
		}

		$current_Month 	= $month;
		$year 			= $year;
		$FristDateOfMonth = $year . '-' . $month . '-01';
		$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

		if (@$_GET['date']) {
			$data["date"] = $date = $_GET['date'];
		} else {
			$data["date"]  = $date  = date('Y-m-d');
		}
		$data["month"] = $month;
		$data["year"]  = $year;
		$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

		$bookings = $this->model->$function();
		$rows = array();
		foreach ($bookings as $brow) {
			if ($brow->end_date == $date && $brow->status == 5 && $brow->checkout_time1 != null) {
				$rows[] = $brow;
			}
		}
		$data['rows'] = $rows;

		// $this->pr($data);

		$data['contant']  = 'reservations/report_list';
		$data['detail_url']	  =  base_url() . 'reservations/detailes/';
		load_view($data['contant'], $data);

		// echo date('Y-m-d');
	}

	public function staying()
	{
		$data["user"]    = $user = $this->checkLogin();

		$function = 'bookings_new';
		if ($user->type == 'host') {
			$function = 'host_bookings_new';
		}
		$month = date('m');
		$year  = date('Y');
		if (@$_GET['m']) {
			$month = $_GET['m'];
		}
		if (@$_GET['Y']) {
			$year  = $_GET['Y'];
		}

		$current_Month 	= $month;
		$year 			= $year;
		$FristDateOfMonth = $year . '-' . $month . '-01';
		$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

		if (@$_GET['date']) {
			$data["date"] = $date = $_GET['date'];
		} else {
			$data["date"]  = $date  = date('Y-m-d');
		}
		$data["month"] = $month;
		$data["year"]  = $year;
		$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

		$bookings = $this->model->$function();
		$rows = array();
		foreach ($bookings as $brow) {
			if (($brow->start_date >= $date) && ($brow->start_date <= $date) && ($brow->status == 2) && ($brow->checkin_status == 1)) {
				$rows[] = $brow;
			}
		}
		$data['rows'] = $rows;

		// $this->pr($data);

		$data['contant']  	= 'reservations/report_list_staying';
		$data['detail_url']	= base_url() . 'checkout/detailes/';
		$data['doc_url'] 	= base_url() . 'reservations-doc/';
		load_view($data['contant'], $data);

		// echo date('Y-m-d');
	}

	public function upcoming_booking()
	{
		$data["user"]    = $user = $this->checkLogin();

		$function = 'bookings';
		if ($user->type == "host") {
			$function = 'host_bookings';
		}
		$month = date('m');
		$year  = date('Y');
		if (@$_GET['m']) {
			$month = $_GET['m'];
		}
		if (@$_GET['Y']) {
			$year  = $_GET['Y'];
		}

		$current_Month 	= $month;
		$year 			= $year;
		$FristDateOfMonth = $year . '-' . $month . '-01';
		$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

		if (@$_GET['date']) {
			$data["date"] = $date = $_GET['date'];
		} else {
			$data["date"]  = $date  = date('Y-m-d');
		}
		$data["month"] = $month;
		$data["year"]  = $year;
		$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

		$bookings = $this->model->$function();
		$rows = array();
		foreach ($bookings as $brow) {

			$today = strtotime(date('Y-m-d'));
			$bdate = strtotime($brow->start_date);
			$datediff = $bdate - $today;
			$datediff = round($datediff / (60 * 60 * 24));

			if (($datediff >= 1) && ($brow->start_date <= $lastDateOfMonth) && ($brow->status == 2) && ($brow->checkin_status == 0)) {
				$rows[] = $brow;
			}
		}
		$data['rows'] = $rows;

		// $this->pr($data);

		$data['contant']  = 'reservations/report_list';
		$data['detail_url']	  =  base_url() . 'reservations/detailes/';
		load_view($data['contant'], $data);
		// echo date('Y-m-d');
	}
	public function cancelled_reservation()
	{
		$data["user"]    = $user = $this->checkLogin();

		$function = 'bookings_new';
				if ($user->type == 'host') {
					$function = 'host_bookings_new';
				}
		$month = date('m');
		$year  = date('Y');
		if (@$_GET['m']) {
			$month = $_GET['m'];
		}
		if (@$_GET['Y']) {
			$year  = $_GET['Y'];
		}

		$current_Month 	= $month;
		$year 			= $year;
		$FristDateOfMonth = $year . '-' . $month . '-01';
		$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

		if (@$_GET['date']) {
			$data["date"] = $date = $_GET['date'];
		} else {
			$data["date"]  = $date  = date('Y-m-d');
		}

		$data["month"] = $month;
		$data["year"]  = $year;
		$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

		$bookings = $this->model->$function();
		if(!empty($bookings))
		{
		 $booking = $bookings;
		}else
		{
		 $booking=[];
		}
		$rows = array();
		foreach ($booking as $brow) {
			if ($brow->start_date == $date && $brow->status == 4 && $brow->checkout_time1 == null) {
				$rows[] = $brow;
			}
		}
		$data['rows'] = $rows;

       //$this->pr($rows);

		$data['contant']       = 'reservations/report_list_cancelled_reservation';
		$data['detail_url']	  =  base_url() . 'checkout/detailes/';
		$data['check_out_url'] = base_url() . 'checkout/';
		load_view($data['contant'], $data);

		// echo date('Y-m-d');
	}
	public function total_reservation()
	{
		$data["user"]    = $user = $this->checkLogin();

		$function = 'bookings_new';
				if ($user->type == 'host') {
					$function = 'host_bookings_new';
				}
		$month = date('m');
		$year  = date('Y');
		if (@$_GET['m']) {
			$month = $_GET['m'];
		}
		if (@$_GET['Y']) {
			$year  = $_GET['Y'];
		}

		$current_Month 	= $month;
		$year 			= $year;
		$FristDateOfMonth = $year . '-' . $month . '-01';
		$numberOfDays   = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$lastDateOfMonth = date('Y-m-' . sprintf("%02d", $numberOfDays), mktime(12, 0, 0, $current_Month, 1, $year));

		if (@$_GET['date']) {
			$data["date"] = $date = $_GET['date'];
		} else {
			$data["date"]  = $date  = date('Y-m-d');
		}

		$data["month"] = $month;
		$data["year"]  = $year;
		$data["monthDateStr"] =  date('F-Y', strtotime($FristDateOfMonth));

		$bookings = $this->model->$function();
		if(!empty($bookings))
		{
		 $booking = $bookings;
		}else
		{
		 $booking=[];
		}
		$rows = array();
		foreach ($booking as $brow) {
			if ($brow->start_date == $date) {
				$rows[] = $brow;
			}
		}
		$data['rows'] = $rows;

       //$this->pr($rows);

		$data['contant']       = 'reservations/report_list_total_reservation';
		$data['detail_url']	  =  base_url() . 'checkout/detailes/';
		$data['check_out_url'] = base_url() . 'checkout/';
		load_view($data['contant'], $data);

		// echo date('Y-m-d');
	}
	
	public function doc($booking_id, $backBtn = 'no')
	{
		if ($user = $this->checkLogin()) {
			$data["user"]    = $user;
			$data['booking'] = $booking = $this->booking_detailes($booking_id);
			$data['doc'] 	 = $doc   	= $this->booking_doc($booking_id);
			// find checkin time
			$data['doc2']    = $this->model->getRow('checkin',['booking_id'=>$booking_id]);
			
			// echo'<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">';
			// $this->pr($data);
			$data['contant']  = 'reservations/doc';
			load_view($data['contant'], $data);
			if ($backBtn == 'yes') {
				echo '<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">';
			}
		}
		// echo $booking_id;
	}



	public function cancel_reservations($action=null,$id=null)
	{
		$data['user']  =$user  = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Cancel Bookings Master';
				$data['contant']    = 'cancel_reservations/index';
				$data['new_url']    = base_url().'cancel-reservations/create';
				$data['tb_url']	    = base_url().'cancel-reservations/tb';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
				$config = array();
		        $config["base_url"] = base_url()."cancel-reservations/tb";

		        $config["total_rows"]  = count($this->model->get_cancellation_reservation($user->id));
		        $data['total_rows']    = $config["total_rows"];
		        $config["per_page"]    = 20;
		        $config["uri_segment"] = 3;
		        $config['attributes']  = array('class' => 'pag-link');
		        $this->pagination->initialize($config);
		        $data["links"]   = $this->pagination->create_links();

				$data['page']    = $page = ($id!=null) ? $id : 0;
				$data['contant'] 	= 'cancel_reservations/tb';
				$data['rows']    =  $this->model->get_cancellation_reservation($user->id,$config["per_page"],$page);
				$data['update_url'] = base_url().'cancel-reservations/create/';
				$data['delete_url']	= base_url('cancel-reservations/delete/');
				load_view($data['contant'],$data);
				
				break;

			case 'create':

				$data['contant']        = 'cancel_reservations/create';
				
				if ($id!=null) {
					$data['action_url'] = base_url().'cancel-reservations/save/'.$id;
					$data['row'] 		=  $this->model->getRow('cancellations_booking',['id'=>$id]);
					$data['property']     = $this->model->getpropertyData($user->id);
					$data['form_class'] = 'reload-page';
				}else{
					$data['action_url'] 	= base_url().'cancel-reservations/save';
					$data['form_class'] = '';
					$data['property']     = $this->model->getpropertyData($user->id);
				}
				
				load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {

					if ($id!=null) {
						if($this->model->Update('cancellations_booking',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Cancellations Booking ');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($id = $this->model->Save('cancellations_booking',$_POST)) {
							logs($user->id,$id,'ADD','ADD Cancellations Booking ');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}					
				}
				echo json_encode($return);
				break;			

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('cancellations_booking',['id'=>$id])){
						logs($user->id,$id,'DELETE','Delete Cancellations Booking ');
						$saved = 1;
						$return['res'] = 'success';
						$return['msg'] = 'Successfully deleted.';
					}
				}
				echo json_encode($return);
				break;
			
			default:
				# code...
				break;
		}
	}




    public function check_and_cancel() {
		$return['res']='error';
		$return['msg']="Not any booking cancelled";
        $cancelled_count = $this->model->check_and_cancel_bookings();
		if($cancelled_count > 0)
		{
			$return['res']='success';
			$return['msg']="Number of bookings cancelled: " . $cancelled_count;
		}
        echo json_encode($return);
    }


}
