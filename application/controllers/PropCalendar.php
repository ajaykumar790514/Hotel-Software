<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Main.php');
class PropCalendar extends Main
{

	public function __construct() {
        parent::__construct();
		$this->checkPlan(@$_COOKIE['property_id']);
			$this->check_role_menu();
		}
	public function index($action = null, $pro_id = null, $flat_id = null, $id = null)
	{

		$data['user']    = $user = $this->checkLogin();
		$data['action']  = $action;
		$data['pro_id']  = $pro_id;
		$data['flat_id'] = $flat_id;
		$data['id']      = $id;
		switch ($action) {
			case null:
				$data['title']      = 'Property Calendar';
				$data['content']    = 'propCalendar/propCalendar';
				$data['cookie_property_id'] = @$_COOKIE['property_id'];
				$function = 'propmaster';
				if ($user->type == 'host') {
					$function = 'host_propmaster';
				}
				$data['rows'] = $this->model->$function();
				// $data['sub_property_types'] = $this->model->getData('sub_property_types');
				$this->template($data);

				break;

		     	case 'calendar':
				$data['month'] 		= date('m');
				$data['year']  		= date('Y');
				$data['contant']    = 'propCalendar/calendar';
				$data['propmaster'] = $this->model->getRow('propmaster', $pro_id);
				$data['rows']       = $this->model->getData('property', ['propid' => $pro_id], 'asc', 'flat_name');
				// $this->pr($data);
				load_view($data['contant'], $data);
				break;

		     	case 'pro-calendar-org':
				// $this->pr($data);

				// echo "<pre>";
				// print_r($_POST);
				// echo "</pre>";

				$current_Month 	= $_POST['month'];
				$year 			= $_POST['year'];
				$pro_id 		= $pro_id;
				$date = mktime(12, 0, 0, $current_Month, 1, $year);
				$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
				$offset = date("w", $date);
				$row_number = 1;

				$detail_url	  =  base_url() . 'reservations/detailes/';
				$inventry_url =  base_url() . 'reservations/inventry/';

				$rows  = $this->model->getData('property', ['propid' => $pro_id], 'asc', 'flat_name');

				// echo "<pre>";
				// print_r($rows);
				// echo "</pre>";

				$cal  = "<table class='table table-bordered'>";
				$cal .= '<tr>';
				$cal .= '<th class="text-center">';
				$cal .= 'Room';
				$cal .= '</th>';
				for ($day = 1; $day <= $numberOfDays; $day++) {
					$cal .= '<th class="text-center">';
					$cal .= sprintf("%02d", $day) . "<br>";
					$pdate = date('Y-m-' . sprintf("%02d", $day), $date);
					// $cal .= date('Y-m-'.sprintf("%02d",$day),$date);
					$cal .= date_format(date_create($pdate), "D");
					$cal .= '</th>';
				}
				$cal .= '</tr>';
				foreach ($rows as $row) {
					$button = '<a class="link text-center float-right text-primary" data-toggle="modal" data-target="#showModal-xl" data-whatever="Bookings" data-url="' . base_url() . 'reservations/reservation/' . $pro_id . '/' . $row->flat_id . '">
                                               <i class="ft-bookmark"></i>
                                            </a>';

					$cal .= '<tr>';
					$cal .= '<td class="text-center flat-name" style="">';
					$cal .= $row->flat_code_name;
					$cal .= $button;
					$cal .= '</td>';
					for ($day = 1; $day <= $numberOfDays; $day++) {
						$cal .= '<td class="text-center">';
						$pdate = date('Y-m-' . sprintf("%02d", $day), $date);




						if ($pdate < date('Y-m-d')) {
							$cal .= '<a href="javascript:void(0)" style="cursor: auto;" >';
						} else {
							$cal .= '<a href="#" data-toggle="modal" data-target="#showModal-xl" data-whatever="Bookings" data-url="' . base_url() . 'reservations/reservation/' . $pro_id . '/' . $row->flat_id . '/' . $pdate . '" >';
						}



						$check['property_id']  = $row->flat_id;
						$check['date']         = $pdate;
						$status = '<i class="la la-dot-circle-o text-success"></i>';
						$daily_price = $extra_bedding_price = "<br>0";
						if ($in_row = $this->model->getRow('property_inventory', $check)) {
							$daily_price 		 = '<br>' . $in_row->daily_price;
							$extra_bedding_price = '<br>' . $in_row->extra_bedding_price;
							// if ($in_row->status==1) {
							// 	echo $in_row->status;
							// }
							if ($in_row->status == 2) {
								$status = '<i class="la la-ban text-danger"></i>';
							}
							if ($in_row->status == 3) {
								// $checkbooking['start_date <=']   	= $pdate;
								// $checkbooking['end_date >=']     	= $pdate;
								// $checkbooking['flat_id']  			= $row->flat_id;
								$checkbooking['id']  				= $in_row->booking_id;
								$checkbooking['status !=']  		= 4;
								$booking = $this->model->getRow('booking', $checkbooking);
								// echo "<pre>";
								// print_r($booking);
								// echo $pdate;
								// echo "</pre>";
								// if($booking = $this->model->getRow('booking',$checkbooking)){
								// 	$status = '<span class="text-dark">'.$booking->guest_name.'</span>';
								// }
								$status = '<i class="la la-check-circle-o text-dark"></i> <br> <a href="#" data-toggle="modal" data-target="#showModal-xl" data-whatever="Bookings Detailes" data-url="' . $detail_url . $booking->id . '" ><i class="text-primary">' . $booking->guest_name . '</i></a>';
								$daily_price = $extra_bedding_price = "";
							}
						}


						// $cal .= $pdate;	
						$cal .= $status;
						// $cal .= $daily_price;	
						// $cal .= $extra_bedding_price;	
						$cal .= '</a>';
						$cal .= '</td>';
					}
					$cal .= '</tr>';
				}
				$cal .= "</table>";

				$data['contant']    = 'propCalendar/pro-calendar';
				$data['cal']    	= $cal;
				load_view($data['contant'], $data);
				// echo $cal;
				break;



			case 'pro-calendar':
				// $this->pr($data);

				// echo "<pre>";
				// print_r($_POST);
				// echo "</pre>";

				$current_Month 	= $_POST['month'];
				$year 			= $_POST['year'];
				$pro_id 		= $pro_id;
				$date = mktime(12, 0, 0, $current_Month, 1, $year);
				$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
				$offset = date("w", $date);
				$row_number = 1;

				$detail_url	  =  base_url() . 'reservations/detailes/';
				$inventry_url =  base_url() . 'reservations/inventry/';

				$rows  = $this->model->getData('property', ['propid' => $pro_id, 'is_deleted' => 'not_deleted'], 'asc', 'flat_name');
				$sub_property_types = [];
				if (@$rows) {

					$typeIds = array_map(function ($data) {
						return $data->sub_property_type_id;
					}, $rows);
					$typeIds = array_unique($typeIds);
					$sub_property_types = $this->db->where('active', 1)->where_in('spt_id', $typeIds)->get('sub_property_types')->result();
				}
				// prx($sub_property_types); die();
				$calData['current_Month'] 	= $current_Month;
				$calData['year'] 			= $year;
				$calData['pro_id'] 			= $pro_id;
				$calData['date'] 			= $date;
				$calData['numberOfDays'] 	= $numberOfDays;
				$calData['offset'] 			= $offset;
				$calData['detail_url'] 		= $detail_url;
				$calData['rows'] 			= $rows;
				$calData['anchortag']		= true;
				$calData['sub_property_types'] = $sub_property_types;


				$data['contant']    = 'propCalendar/pro-calendar';
				$data['cal']    	= $this->calendar_html($calData);
				load_view($data['contant'], $data);
				// echo $cal;
				break;

			default:

				break;
		}
	}

	public function calendar_html($calData)
	{
		$current_Month 	= $calData['current_Month'];
		$year 			= $calData['year'];
		$pro_id 		= $calData['pro_id'];
		$date 			= $calData['date'];
		$numberOfDays 	= $calData['numberOfDays'];
		$offset 		= $calData['offset'];
		$detail_url 	= $calData['detail_url'];
		$rows 			= $calData['rows'];
		$anchortag		= $calData['anchortag'];
		$sub_property_types = $calData['sub_property_types'];

		$cal = '';
		$cal .= "<div class='row mr-0'>";
		$cal .= "<div class='col-2 pr-0'>";
		$cal .= "<ul class='list-group p-cal-flat'>";
		$cal .= "<li class='list-group-item'>";
			// $cal .= "<h3 class='text-center'>Room</h3><br>";
			$cal .="<select id='sub_property_types' class='form-control'>";
			$cal .="<option value=''> All </option>";
			foreach ($sub_property_types as $rt_key => $rt_value) {
				$cal .="<option value='$rt_value->spt_id'>$rt_value->name</option>";
			}
			$cal .="</select>";
		$cal .= "</li>";
		foreach ($rows as $key => $value) {
			$room_type = title('sub_property_types', $value->sub_property_type_id, 'spt_id', 'name');
			$cal .= "<li class='list-group-item' room-type='$value->sub_property_type_id'>";
			$cal .= $room_type;
			$cal .= (@$value->flat_no) ? " ($value->flat_no)" : ' (N/A)';
			$cal .= "</li>";
		}
		$cal .= "</ul>";
		$cal .= "</div>";
		$cal .= "<div class='col-10 p-cal'>";
		$cal .= "<ul class='list-inline'>";
		for ($day = 1; $day <= $numberOfDays; $day++) {
			$cal .= "<li class='list-inline-item' date='" . sprintf("%02d", $day) . "'>";
			$cal .=	sprintf("%02d", $day) . "<br>";
			$pdate = date('Y-m-' . sprintf("%02d", $day), $date);
			$cal .= date_format(date_create($pdate), "D");
			$cal .= "</li>";
		}
		$cal .= "</ul>";
		foreach ($rows as $key => $value) {
			$cal .= "<ul class='list-inline'  room-type='$value->sub_property_type_id'>";
			for ($day = 1; $day <= $numberOfDays; $day++) {
				$pdate = date('Y-m-' . sprintf("%02d", $day), $date);
				$check['property_id']  = $value->flat_id;
				$check['date']         = $pdate;
				$status = '<i class="la la-dot-circle-o text-success"></i>';



				$cal .= "<li class='list-inline-item'>";

				if ($pdate < date('Y-m-d')) {
					$cal .= '<a href="javascript:void(0)" style="cursor: auto;" >';
				} else {
					$cal .= '<a href="javascript:void(0)" style="cursor: auto;" >';
				}

			

				$check_room_allotment['flat_id'] = $value->flat_id;
				$check_room_allotment['date']         = $pdate;

				if ($in_row = $this->model->getRow('room_allotment', $check_room_allotment)) {

					$checkb['id'] 			= $in_row->booking_id;
					$checkb['status !='] 	= 4;
					$booking = $this->model->getRow('booking_new', $checkb);
                 
					$status = ' <a href="#" data-toggle="modal" data-target="#showModal-xl" data-whatever="Bookings Detailes" data-url="' . $detail_url . $booking->id . '" ><i class="text-primary">' . $booking->guest_name . '</i></a>';
					$daily_price = $extra_bedding_price = "";
				}


				$cal .= $status;
				$cal .= '</a>';

				$cal .= "</li>";
			}
			$cal .= "</ul>";
		}


		$cal .= "</div>";

		$cal .= "</div>";
		if ($anchortag == false) {
			$cal .= "<script type='text/javascript'>
						$('body').on('click','.p-cal a',function(e){
							return false;
						})
						$('.p-cal a').attr('disabled',true)
						</script>";
		}


		return $cal;
	}

	public function property_calendar_for_extend($booking_id)
	{
		$data['booking'] 	= $booking    	= $this->booking_detailes($booking_id);
		$data['extended'] 	= $extended 	= $this->extended_bookings($booking_id);
		// $this->pr($extended);
		$data['flat_id'] = $flat_id    = $booking->flat_id;
		$guest_id   = $booking->guest_id;
		$_GET['flat_id'] = $flat_id;
		// echo $guest_id;
		$month  = $current_Month = $_GET['m'];
		$year   = $_GET['y'];

		$detail_url	  = base_url() . 'reservations/detailes/';
		$date         = mktime(12, 0, 0, $current_Month, 1, $year);
		$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$offset 	  = date("w", $date);

		$rows  = $this->model->getData('property', ['flat_id' => $flat_id], 'asc', 'flat_name');

		$calData['current_Month'] 	= $current_Month;
		$calData['year'] 			= $year;
		$calData['pro_id'] 			= $rows[0]->propid;
		$calData['date'] 			= $date;
		$calData['numberOfDays'] 	= $numberOfDays;
		$calData['offset'] 			= $offset;
		$calData['detail_url'] 		= $detail_url;
		$calData['rows'] 			= $rows;
		$calData['anchortag']		= false;

		$data['contant']    = 'propCalendar/pro-calendar-extend';
		$data['cal']    	= $this->calendar_html($calData);
		// $data['booking']	= $booking;
		load_view($data['contant'], $data);
	}

	public function property_calendar_for_change_flat($booking_id)
	{
		$data['booking']    = $booking = $this->booking_detailes($booking_id);
		$data['property']   = $property  = $this->property_detailes($booking->flat_id);
		$data['properties'] = $this->properties_by_propmaster($property->propid);

		$data['flat_id'] = $flat_id    = $booking->flat_id;
		$guest_id   = $booking->guest_id;
		$_GET['flat_id'] = $flat_id;
		// echo $guest_id;
		$month  = $current_Month = $_GET['m'];
		$year   = $_GET['y'];

		$detail_url	  = base_url() . 'reservations/detailes/';
		$date         = mktime(12, 0, 0, $current_Month, 1, $year);
		$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$offset 	  = date("w", $date);

		$rows  = $this->model->getData('property', ['propid' => $property->propid], 'asc', 'flat_name');


		$calData['current_Month'] 	= $current_Month;
		$calData['year'] 			= $year;
		$calData['pro_id'] 			= $property->propid;
		$calData['date'] 			= $date;
		$calData['numberOfDays'] 	= $numberOfDays;
		$calData['offset'] 			= $offset;
		$calData['detail_url'] 		= $detail_url;
		$calData['rows'] 			= $rows;
		$calData['anchortag']		= false;

		$data['contant']    = 'propCalendar/property_calendar_change_flat';
		$data['cal']    	= $this->calendar_html($calData);
		// $data['booking']	= $booking;
		load_view($data['contant'], $data);
		// $this->pr($_GET);
		// return "string";
	}

	public function property_calendar_for_reschedule($booking_id)
	{
		$data['booking'] = $booking    = $this->booking_detailes($booking_id);
		$data['extended'] = $extended = $this->extended_bookings($booking_id);
		// $this->pr($extended);
		$data['flat_id'] = $flat_id    = $booking->flat_id;
		$guest_id   = $booking->guest_id;
		$_GET['flat_id'] = $flat_id;
		// echo $guest_id;
		$month  = $current_Month = $_GET['m'];
		$year   = $_GET['y'];

		$detail_url	  = base_url() . 'reservations/detailes/';
		$date         = mktime(12, 0, 0, $current_Month, 1, $year);
		$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $current_Month, $year);
		$offset 	  = date("w", $date);

		$rows  = $this->model->getData('property', ['flat_id' => $flat_id], 'asc', 'flat_name');

		$calData['current_Month'] 	= $current_Month;
		$calData['year'] 			= $year;
		$calData['pro_id'] 			= $rows[0]->propid;
		$calData['date'] 			= $date;
		$calData['numberOfDays'] 	= $numberOfDays;
		$calData['offset'] 			= $offset;
		$calData['detail_url'] 		= $detail_url;
		$calData['rows'] 			= $rows;
		$calData['anchortag']		= false;

		$data['contant']    = 'propCalendar/pro-calendar-reschedule';
		$data['cal']    	= $this->calendar_html($calData);
		// $data['booking']	= $booking;
		load_view($data['contant'], $data);
		// $this->pr($_GET);
		// return "string";
	}

	public function reservation($pro_id = '')
	{
		// echo $pro_id;
		$data['user'] = $user = $this->checkLogin();
		$data['rows'] = ($user->type == 'host') ? $this->model->host_propmaster() : $this->model->propmaster();
		$data['sub_property_types'] = $this->model->getData('sub_property_types');
		$data['pro_id'] = $pro_id;
		$data['startDate'] 	 = date('Y-m-d');
		$data['endDate'] 	 = date("Y-m-d", strtotime('+ 1 day '));
		$data['booking_type'] = $this->model->getData('booking_type', ['status' => 1], 'asc', 'type');
		$data['action_url'] = base_url('propCalendar/create_reservation');
		// prx($data);

		$data['contant']    = 'propCalendar/reservation';
		load_view($data['contant'], $data);
	}

	public function create_reservation()
	{

		$post = $this->input->post();
		// from date - to date
		if (@$post['startDate'] && @$post['endDate']) {
			$dateArray = $this->between_dates($post['startDate'], $post['endDate']);
		} else {
			$return['msg'] 		  = 'Date not selected!';
			echo json_encode($return);
			die();
		}
		// from date - to date

		if ($this->date_availability($dateArray, $flat_id) == false or 1 == 2) {
			$return['msg'] = 'Selected Dates Not Available!';
			echo json_encode($return);
			die();
		}


		$booking = (object)[];
		$booking->property_id = $post['propmaster'];
		$booking->booking_type = $post['booking_type'];
		$booking->booking_from = $post['booking_from'];
		$booking->agent = $post['propmaster'];
		$booking->guest_id = $post['propmaster'];
		$booking->guest_name = $post['propmaster'];
		$booking->gender = $post['propmaster'];
		$booking->email = $post['propmaster'];
		$booking->contact = $post['propmaster'];
		$booking->of_adults = $post['propmaster'];
		$booking->of_children = $post['propmaster'];
		$booking->of_infants = $post['propmaster'];
		$booking->of_adults = $post['propmaster'];
		$booking->start_date = $post['propmaster'];
		$booking->end_date = $post['propmaster'];
		$booking->dob = $post['propmaster'];
		$booking->total = $post['propmaster'];

		prx(['booking' => $booking]);
		prx(['post' => $_POST]);
	}
}
