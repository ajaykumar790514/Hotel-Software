<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->service_charges = 0;
		
		
	}

	public function template($data)
	{
		$user         = $this->checkLogin();
		$data['menu'] = $this->user_module->get_menu($user);
		$data['parm'] = $this->checkPermission();
		$data['comp'] = 'M R S';
		$data['service_charges'] = $this->service_charges;
		if (!isset($data['title'])) {
			$data['title'] = $data['comp'];
		}
		$get_host_logo = $this->model->get_host_logo($user->id);
		if(!empty($get_host_logo))
		{
			$data['logo'] = IMGS_URL.$get_host_logo->pic;
			
		}else
		{
       $data['logo'] = base_url() . 'assets/photo/noimage/logo2.png';
		}
		$admin_logo = $this->model->getRow('tb_admin',['id'=>'1']);
		if(!empty($admin_logo))
		{
			$data['admin_logo'] = IMGS_URL.$admin_logo->photo;
			
		}else
		{
       $data['admin_logo'] = base_url() . 'assets/photo/noimage/logo2.png';
		}
		$data['property']=$proid = @$_COOKIE['property_id'];
		$this->checkPropertyApproved($proid);
		if($user->user_role ==4){
		$data['package'] = $this->db->select('*')->where(['property_id'=>$proid,'active'=>'1','user_id'=>$user->id,'status'=>'2'])->get('user_assign_package')->row(); 
		}elseif($user->user_role !=1 && $user->user_role !=2 && $user->user_role !=4){
			$data['package'] = $this->db->select('*')->where(['property_id'=>$proid,'active'=>'1','user_id'=>$user->host_id,'status'=>'2'])->get('user_assign_package')->row(); 
		}
		if (!isset($data['tb_url'])) {
			$data['tb_url'] = '';
		}

		$this->load->view('template', $data);
	}

	public function checkPropertyApproved($pro_id)
	{
	$data['user'] = $user 			= $this->checkLogin();
	$data=$this->model->getRow('propmaster',['id'=>$pro_id,'approval_status'=>'Approved']);
	if(!$data)
	{
      
	}
	}

	public function getLocations($state=null,$city=null,$selected_location=null){
		$return['res'] = 'error';
		$return['content'] = optionStatus('','-- Select --',1);
		if ($this->checkLogin()) {
			if ($this->input->server('REQUEST_METHOD')=='POST') {
				if ($_POST['state'] && $_POST['city']) {

					$_POST['state'] = title('states',$_POST['state']);
					$_POST['city'] = title('cities',$_POST['city']);
					
					$content = optionStatus('','-- Select --',1);
					unset($_POST['state']);
					$locations = $this->model->getData('location',$_POST);
					foreach ($locations as $row) {
						$content .= optionStatus($row->id,$row->name,1);
					}
					$return['res'] = 'success';
					$return['content'] = $content;
				}
				echo json_encode($return);	
			}
			elseif ($state!=null && $city!=null) {
				$content = '';
				$cond['state'] = title('states',$state);
				$cond['city'] = title('cities',$city);
					
				$content = optionStatus('','-- Select --',1);
				unset($cond['state']);
				$locations = $this->model->getData('location',$cond);
				foreach ($locations as $row) {
					($row->id == $selected_location) ? $selected = 'selected' : $selected = '';
					$content .= optionStatus($row->id,$row->name,1,$selected);
				}
				return $content;
			}
		}
		
	}
	public function getSubPropertyType($id = null, $selected_id = null, $return = false)
	{
		
		$content = optionStatus('', '-- Select --', 1);
		
		if ($id != null) {
		
			$rows = $this->model->getData('sub_property_types', ['property_id' => $id]);
			foreach ($rows as $row) {
				$selected = '';
				if ($row->spt_id == $selected_id) {
					$selected = 'selected';
				}
				$content .= optionStatus($row->spt_id, $row->name, 1, $selected);
			}
		}

		
		if (!$return) {
			echo $content;
		} else {
			return $content;
		}
	}
	public function changeStatus($id_column = null)
	{
		$user         = $this->checkLogin();
		if ($this->input->is_ajax_request()) {
			$data = explode(',', $_POST['data']);
			$id = $data[0];
			$tb = $data[1];
			$update = array('status' => $_POST['value']);
			if ($id_column == null) {
				$cond = ['id' => $id];
				$column = "";
			} else {
				$cond = [$id_column => $id];
				$column = "column='$id_column'";
			}

			$this->model->Update($tb, $update, $cond);
			$status = $this->model->getRow($tb, $cond)->status;
			if ($status == 1) {
				echo "<span class='changeStatus' onclick='changeStatus(this)' value='0' data='" . $id . "," . $tb . "' " . $column . " title='Click for chenage status' ><i class='la la-check-circle'></i></span>";
				logs($user->id,$id,'CHANGE_STATUS',$tb.'- Active');
			} else {
				echo "<span class='changeStatus' onclick='changeStatus(this)' value='1' data='" . $id . "," . $tb . " ' " . $column . " title='Click for chenage status'><i class='icon-close'></i></span>";
				logs($user->id,$id,'CHANGE_STATUS',$tb.'- Inactive');
			}
		}
	}

	public function change_status()
	{
		$user         = $this->checkLogin();
		if ($this->input->is_ajax_request()) {
			$data = explode(',', $_POST['data']);
			$id 	= $data[0];
			$tb 	= $data[1];
			$id_column  = $data[2];
			$val_column  = $data[3];
			$update = array($val_column => $_POST['value']);
			$cond = [$id_column => $id];
			$column = "column='$id_column'";

			$this->model->Update($tb, $update, $cond);
			$status = $this->model->getRow($tb, $cond)->$val_column;

			if ($status == 1) {
				echo "<span class='changeStatus'  data-toggle='change-status' value='0' data='" . $_POST['data'] . "' title='Click for chenage status' ><i class='la la-check-circle'></i></span>";
				logs($user->id,$id,'CHANGE_STATUS',$tb.'- Active');
			} else {
				echo "<span class='changeStatus' data-toggle='change-status' value='1' data='" . $_POST['data'] . "'  title='Click for chenage status'><i class='icon-close'></i></span>";
				logs($user->id,$id,'CHANGE_STATUS',$tb.'- Inactive');
			}
		}
	}

	
	function Menu_multiple_delete()
    {
		$user         = $this->checkLogin();
     if($this->input->post('checkbox_value'))
     {
        $id = $this->input->post('checkbox_value');
        $table = $this->input->post('table');
        for($count = 0; $count < count($id); $count++)
        {
            if($table == 'society_master')
            {
                $is_deleted = array('is_deleted' => 'DELETED');
                $this->db->where('socity_id', $id[$count])->update($table, $is_deleted);
            }
            else
            {
                $this->master_model->delete_data1($table,$id[$count]);
				logs($user->id,$id[$count],'DELETE',$table.'- DELETE');
            }
        }
        
     }
    }

	function multiple_delete()
    {
		$user         = $this->checkLogin();
     if($this->input->post('checkbox_value'))
     {
        $id = $this->input->post('checkbox_value');
        $table = $this->input->post('table');
        for($count = 0; $count < count($id); $count++)
        {
            if($table == 'society_master')
            {
                $is_deleted = array('is_deleted' => 'DELETED');
                $this->db->where('socity_id', $id[$count])->update($table, $is_deleted);
            }
            else
            {
                $this->master_model->delete_data($table,$id[$count]);
				logs($user->id,$id[$count],'DELETE',$table.'- DELETE');
            }
        }
        
     }
    }

	public function changeIndexing()
	{
		$user         = $this->checkLogin();
		if ($this->input->is_ajax_request()) {
			$data = explode(',', $_POST['data']);
			$id 	= $data[0];
			$tb 	= $data[1];
			$id_column  = $data[2];
			$val_column  = $data[3];
			$update = array($val_column => $_POST['value']);
			$cond = [$id_column => $id];
			$this->model->Update($tb, $update, $cond);
			logs($user->id,$id,'SEQ',$tb.'- SEQ');	
		}
	}
	
	public function changeStatusDispaly()
	{
		if ($this->input->is_ajax_request()) {
			$data = explode(',', $_POST['data']);
			$id = $data[0];
			$tb = $data[1];
			$ex = '';
			$update = array('display' => $_POST['value']);
			if (@$data[2]) :
				$cond = [$data[2] => $id];
				$ex = ',' . $data[2];
			else :
				$cond = ['id' => $id];
			endif;



			$this->model->Update($tb, $update, $cond);
			echo $this->db->last_query();
			echo $display = $this->model->getRow($tb, $cond)->display;

			if ((int)$display == 1) {
				echo "string";
				echo "<span class='changeStatusDispaly' value='0' data='" . $id . "," . $tb . $ex . "'><i class='la la-check-circle'></i></span>";
			} else {
				echo "string22";
				echo "<span class='changeStatusDispaly' value='1' data='" . $id . "," . $tb . $ex . " '><i class='icon-close'></i></span>";
			}
		}
	}

	public function getCountries($selected_id = null, $return = false, $value = 'id')
	{
		$rows = $this->model->getData('countries');
		$content = optionStatus('', '-- Select --', 1);
		foreach ($rows as $row) {
			$selected = '';
			if ($row->id == $selected_id) {
				$selected = 'selected';
			}
			$content .= optionStatus($row->$value, $row->name, 1, $selected);
		}
		if (!$return) {
			echo $content;
		} else {
			return $content;
		}
	}

	public function getStates($id = null, $selected_id = null, $return = false)
	{
		$content = optionStatus('', '-- Select --', 1);
		if ($id != null) {
			$rows = $this->model->getData('states', ['country_id' => $id]);
			foreach ($rows as $row) {
				$selected = '';
				if ($row->id == $selected_id) {
					$selected = 'selected';
				}
				$content .= optionStatus($row->id, $row->name, 1, $selected);
			}
		}
		if (!$return) {
			echo $content;
		} else {
			return $content;
		}
	}

	public function getCities($id = null, $selected_id = null, $return = false)
	{
		$content = optionStatus('', '-- Select --', 1);
		if ($id != null) {
			$rows = $this->model->getData('cities', ['state_id' => $id]);
			foreach ($rows as $row) {
				$selected = '';
				if ($row->id == $selected_id) {
					$selected = 'selected';
				}
				$content .= optionStatus($row->id, $row->name, 1, $selected);
			}
		}
		if (!$return) {
			echo $content;
		} else {
			return $content;
		}
	}

	public function getDistrict($id = null, $selected_id = null, $return = false)
	{
		$content = optionStatus('', '-- Select --', 1);
		if ($id != null) {
			$rows = $this->model->getData('district_master', ['state_id' => $id]);
			foreach ($rows as $row) {
				$selected = '';
				if ($row->id == $selected_id) {
					$selected = 'selected';
				}
				$content .= optionStatus($row->id, $row->name, 1, $selected);
			}
		}
		if (!$return) {
			echo $content;
		} else {
			return $content;
		}
	}

	
	public function propmasterByLocation($id, $selected_id = null, $return = false)
	{
		$rows = $this->model->getData('propmaster', ['location_id' => $id]);
		$content = optionStatus('', '-- Select --', 1);
		foreach ($rows as $row) {
			$selected = '';
			if ($row->id == $selected_id) {
				$selected = 'selected';
			}
			$content .= optionStatus($row->id, $row->propname, $row->status, $selected);
		}
		if (!$return) {
			echo $content;
		} else {
			return $content;
		}
	}
	public function subProperty($id, $selected_id = null, $return = false)
	{
		
		// $rows = $this->model->getData('property', ['propid' => $id], 'asc', 'flat_no');
		// $content = optionStatus('', '-- Select --', 1);
		// foreach ($rows as $row) {
		// 	$selected = '';
		// 	if ($row->flat_id == $selected_id) {
		// 		$selected = 'selected';
		// 	}
		// 	$content .= optionStatus($row->flat_id, $row->flat_no, $row->status, $selected);
		// }
		// if (!$return) {
		// 	echo $content;
		// } else {
		// 	return $content;
		// }
		
		$rows = $this->model->getData('sub_property_types', ['property_id' => $id], 'asc', 'name');
		$content = optionStatus('', '-- Select --', 1);
		foreach ($rows as $row) {
			$selected = '';
			if ($row->spt_id == $selected_id) {
				$selected = 'selected';
			}
			$content .= optionStatus($row->spt_id, $row->name, $row->active, $selected);
		}
		if (!$return) {
			echo $content;
		} else {
			return $content;
		}

	}
	
	// public function subProperty($id, $selected_id = null, $return = false)
	// {
		
	// 	$rows = $this->model->getData('property', ['propid' => $id], 'asc', 'flat_code_name');
	// 	$content = optionStatus('', '-- Select --', 1);
	// 	foreach ($rows as $row) {
	// 		$selected = '';
	// 		if ($row->flat_id == $selected_id) {
	// 			$selected = 'selected';
	// 		}
	// 		$content .= optionStatus($row->flat_id, $row->flat_code_name, $row->status, $selected);
	// 	}
	// 	if (!$return) {
	// 		echo $content;
	// 	} else {
	// 		return $content;
	// 	}
	// }

	public function booking_detailes($booking_id)
	{
		return $this->model->getRow('booking_new', ['id' => $booking_id]);
	}

	public function extended_bookings($booking_id)
	{
		$cond = ['ref_booking_id' => $booking_id, 'extended !=' => 0];
		return $this->model->getData('booking', $cond);
	}

	public function booking_doc($booking_id)
	{
		return $this->model->getData('check_in_guests', ['booking_id' => $booking_id]);
	}

	public function property_detailes($flatid)
	{
		return $this->model->getRow('property', ['flat_id' => $flatid]);
	}

	public function propmaster_detailes($propid)
	{
		return $this->model->getRow('propmaster', ['id' => $propid]);
	}

	public function properties_by_propmaster($propid)
	{
		return $this->model->getData('property', ['propid' => $propid], 'asc', 'flat_name');
	}
    public function validate_user_property($user , $pro_id)
	{
		$exist = $this->model->validate_user_property($user , $pro_id);
		if($exist==1)
		{
			return 1;
		}else
		{
			return 0;
		}
	}
	public function date_availability($dateArray, $property_id, $booking_id = null)
	{
		$date_availability = true;
		foreach ($dateArray as $drow) {
			$check['date'] 		  = $drow;
			$check['property_id'] = $property_id;
			if ($booking_id != null) {
				$check['booking_id !='] = $booking_id;
			}
			if ($pi = $this->model->getRow('property_inventory', $check)) {
				if ($pi->status == 2 or $pi->status == 3) {
					$date_availability = false;
				}
			}
		}
		return $date_availability;
	}

	public function get_price($dateArray, $property_id)
	{
		$user         = $this->checkLogin();
		$property = $this->model->getRow('property', ['flat_id' => $property_id]);

		$price = 0;
		foreach ($dateArray as $drow) {
			$check['date'] 		  = $drow;
			$check['property_id'] = $property_id;
			if ($pi = $this->model->getRow('property_inventory', $check)) {

				if ($pi->status == 2 or $pi->status == 3) {
					$date_availability = false;
				}
				$daily_price = $pi->daily_price;
				$extra_bedding_price = $pi->extra_bedding_price;
				$price = $price + $daily_price;
			} else {

				$saveCal['property_id'] 			= $property_id;
				$saveCal['daily_price'] 			= $property->daily_price;
				$saveCal['extra_bedding_price'] 	= $property->extra_bedding_price;

				$daily_price 			= $property->daily_price;
				$extra_bedding_price 	= $property->extra_bedding_price;
				$saveCal['date'] 		= $drow;

				$property_inventory=$this->model->Save('property_inventory', $saveCal);
				logs($user->id,$property_inventory,'ADD','Add Property Inventory');
				$price = $price + $daily_price;
			}
		}

		return $price;
	}

	public function update_inventory($dateArray, $property_id, $status, $booking_id = 0)
	{
		$user         = $this->checkLogin();
		foreach ($dateArray as $date) {
			$cond['date'] 		  = $date;
			$cond['property_id']  = $property_id;
			$update['status']     = $status;
			$update['booking_id'] = $booking_id;
			$this->model->Update('property_inventory', $update, $cond);
			logs($user->id,$property_id,'EDIT','Edit Property Inventory');
			
		}
	}

	function booking_new_inventory($dateArray, $data)
	{
		$user         = $this->checkLogin();
		foreach ($dateArray as $date) {
			$insert['booking_id']     = $data['booking_id'];
			$insert['property_id'] = $data['property_id'];
			$insert['booking_type_id'] = $data['room_type'];
			$insert['no_of_rooms'] = $data['qty'];
			$insert['date']	=	$date;
			$id=$this->model->Save('booking_new_inventory', $insert);
			logs($user->id,$id,'ADD','Add bookings New Inventory');
		}
	}

	function propmaster_s_p_availability($pro_id, $property_type_id)
	{
		$user         = $this->checkLogin();
		$cond['propid'] 		= $pro_id;
		$cond['s_p_type_id']  = $property_type_id;

		$cond_pro['propid'] 		= $pro_id;
		$cond_pro['sub_property_type_id'] = $property_type_id;
		//$cond_pro['flat_no != '] = NULL;

		$data = $this->model->getData('property',$cond_pro);
		$available = (@$data) ? count($data) : 0;
		if($this->model->getRow('propmaster_s_p_availability',$cond)){
			$this->model->Update('propmaster_s_p_availability',['available'=>$available],$cond);
			logs($user->id,$pro_id,'EDIT','Edit Prop master sp availability');
		}
		else{
			$cond['available'] 		= $available;
			$id=$this->model->Save('propmaster_s_p_availability',$cond);
			logs($user->id,$pro_id,'ADD','Add Prop master sp availability');
		}
	

	}

	public function save_booking_row_items($booked, $flat_id, $extra_bedding)
	{
		$user         = $this->checkLogin();
		$insertArry['fk_booking_id'] = $booked;
		$insertArry['fk_flat_id'] 	 = $flat_id;
		$insertArry['extra_bedding'] = $extra_bedding;
		$id=$this->model->Save('booking_row_items', $insertArry);
		logs($user->id,$id,'ADD','Add bookings New Items');
	}

	public function between_dates($start, $end)
	{
		$dateArray = array();
		$period = new DatePeriod(
			new DateTime($start),
			new DateInterval('P1D'),
			new DateTime($end)
		);
		foreach ($period as $date) {
			$dateArray[] = $date->format('Y-m-d');
		}

		return $dateArray;
	}
// Function to check and possibly adjust the end date
public function calculate_extra_nights($end_date) {
    $current_date = new DateTime();
    $end_date_obj = new DateTime($end_date);

    // Check if the end date and current date are the same
    if ($end_date_obj->format('Y-m-d') > $current_date->format('Y-m-d')) {
        return 0;
    }

    // Calculate the interval between dates
    $interval = $current_date->diff($end_date_obj);
    $days_between = $interval->days;

    // Check if the current time is greater than 12 PM
    $current_time = new DateTime();
    $noon_time = new DateTime('12:00:00');
    if ($current_time > $noon_time) {
        $days_between += 1;
    }

    return $days_between;
}


// Updated between_checkin_dates function
public function between_checkin_dates($start, $end) {
    $dateArray = array();
    $start_date_obj = new DateTime($start);
    $end_date_obj = (new DateTime($end))->modify('+1 day'); // Make end date inclusive

    $period = new DatePeriod(
        $start_date_obj,
        new DateInterval('P1D'),
        $end_date_obj
    );

    foreach ($period as $date) {
        $dateArray[] = $date->format('Y-m-d');
    }

    return $dateArray;
}

	

	function host_earnings($fristDateOfMonth, $lastDateOfMonth, $todayD, $days30)
	{
		$property_id = get_cookie('property_id');

		$countBookings = $earnings = $todayBooking = 0;
		$host_propmaster = $this->model->host_propmaster();
		$flat_ids = array();

		if ($flats = $this->properties_by_propmaster($property_id)) {
			foreach ($flats as $flat) {
				$flat_ids[] = $flat->flat_id;
			}
		}

		// return $flat_ids;
		foreach ($flat_ids as $flat_id) {
			$cond['end_date >= ']   = $fristDateOfMonth;
			$cond['end_date <= ']   = $lastDateOfMonth;
			$cond['flat_id'] 		= $flat_id;
			// $cond['status']			= 5;
			$cond['payment_status']	= 2;
			$bookings = $this->model->getData('booking', $cond);
			foreach ($bookings as $booking_row) {

				if ($booking_row->status == 2 or $booking_row->status == 5) {
					$earnings = $earnings + $booking_row->price;
				}
			}
			// echo prx($bookings);
		}



		foreach ($flat_ids as $flat_id) {
			// $cond['start_date >= '] = $days30;
			// $cond['start_date <= '] = $todayD;

			$cond['start_date >= '] = $fristDateOfMonth;
			$cond['start_date <= '] = $lastDateOfMonth;
			$cond['flat_id'] 		= $flat_id;

			$bookings = $this->model->getData('booking', $cond);
			foreach ($bookings as $booking_row) {
				if ($booking_row->status == 2 or $booking_row->status == 5) {
					$countBookings = $countBookings + 1;
				}
			}
		}

		foreach ($flat_ids as $flat_id) {
			$cond['booking_date']   = $todayD;
			$cond['flat_id'] 		= $flat_id;
			$bookings = $this->model->getData('booking', $cond);
			foreach ($bookings as $booking_row) {
				$todayBooking = $todayBooking + 1;
			}
		}

		$return['totalBookings'] = $countBookings;
		$return['totalEarnings'] = $earnings;
		$return['todayBooking'] = $todayBooking;

		return $return;
	}



public function checkPlan($pro_id)
{
$data['user'] = $user 			= $this->checkLogin();
if($user->user_role ==4){
if(!empty($pro_id)){
$plan = $this->model->get_user_package($pro_id,$user->id);
if (!empty($plan)) {
$currentDate = new DateTime();
$planStartDate = new DateTime($plan->plan_date);
$planEndDate = clone $planStartDate;
$planEndDate->modify("+" . $plan->no_of_days . " days");
$currentDateString = $currentDate->format('Y-m-d H:i:s');
$planStartDateString = $planStartDate->format('Y-m-d H:i:s');
$planEndDateString = $planEndDate->format('Y-m-d H:i:s');
$isValid =  $currentDateString <= $planEndDateString;
if(@$plan->package_id =='')
{
	redirect(base_url('renew-plan/'.$pro_id));
}else
if($isValid)
{
 return true;
}else 
{
	$update = $this->model->Update('user_assign_package', ['active' => '0'], ['property_id'=>$pro_id,'user_id' => $user->id]);

	if($update)
	{
		logs($user->id,$pro_id,'ADD','Assign User Package Plan');
		$update2 = $this->model->Update('user_assign_package', ['active' => '1','extended_plan'=>'0'], ['property_id'=>$pro_id,'extended_plan'=>'1','user_id' => $user->id]);
		if ($update2) {
			logs($user->id,$pro_id,'ADD','Assign User Package Plan');
			return true; 
		} else {
			return false;
			redirect(base_url('renew-plan/'.$pro_id));
		}
	}else{
		return false;
		redirect(base_url('renew-plan/'.$pro_id));
	}
	
}
}else{
	redirect(base_url('renew-plan/'.$pro_id));
}
}else{
	redirect(base_url('dashboard'));
}
}elseif($user->user_role !=1 && $user->user_role !=2 && $user->user_role !=4){

	if(!empty($pro_id)){
		$plan = $this->model->get_user_package($pro_id,$user->host_id);
		if (!empty($plan)) {
		$currentDate = new DateTime();
		$planStartDate = new DateTime($plan->plan_date);
		$planEndDate = clone $planStartDate;
		$planEndDate->modify("+" . $plan->no_of_days . " days");
		$currentDateString = $currentDate->format('Y-m-d H:i:s');
		$planStartDateString = $planStartDate->format('Y-m-d H:i:s');
		$planEndDateString = $planEndDate->format('Y-m-d H:i:s');
		$isValid =  $currentDateString <= $planEndDateString;
		if(@$plan->package_id =='')
		{
			redirect(base_url('renew-plan/'.$pro_id));
		}else
		if($isValid)
		{
		 return true;
		}else 
		{
			$update = $this->model->Update('user_assign_package', ['active' => '0'], ['property_id'=>$pro_id,'user_id' => $user->host_id]);
		
			if($update)
			{
				logs($user->host_id,$pro_id,'ADD','Assign User Package Plan');
				$update2 = $this->model->Update('user_assign_package', ['active' => '1','extended_plan'=>'0'], ['property_id'=>$pro_id,'extended_plan'=>'1','user_id' => $user->host_id]);
				if ($update2) {
					logs($user->host_id,$pro_id,'ADD','Assign User Package Plan');
					return true; 
				} else {
					return false;
					redirect(base_url('renew-plan/'.$pro_id));
				}
			}else{
				return false;
				redirect(base_url('renew-plan/'.$pro_id));
			}
			
		}
		}else{
			redirect(base_url('renew-plan/'.$pro_id));
		}
		}else{
			redirect(base_url('dashboard'));
		}
}	
 
}


	public function checkLogin()
	{
		// echo value_encryption(get_cookie('6050c7712a12e'), 'decrypt');die();
		$loggedin = false;
		if (get_cookie('6050c764989e5') && get_cookie('6050c7712a12e') && get_cookie('gjs50c7815a42z')) {
			
			$user_id = value_encryption(get_cookie('6050c764989e5'), 'decrypt');
			$user_nm = value_encryption(get_cookie('6050c7712a12e'), 'decrypt');
			$type    = value_encryption(get_cookie('gjs50c7815a42z'), 'decrypt');
		
			if (is_numeric($user_id) && ($user_nm)) {
				//echo "hello";die();
				$check['id'] 	   = $user_id;
				$check['username'] = $user_nm;
				if ($type == 'admin') {
					$user = $this->model->getRow('tb_admin', $check);
				} elseif ($type == 'host') {
					$user = $this->model->getRow('usermaster', $check);
					if ($user) {
						$tb_user_role = $this->model->getRow('tb_user_role',['id'=>$user->user_role]);
						$user->host_id=$tb_user_role->host_id;
						$user->status = $user->isactive;
						// $user->user_role = 4;

					}
				} else {
					$user = false;
				}
				
				if ($user) {
					if ($user->status == 1) {
						$user->type = $type;
						$loggedin = true;
					}
				}
			}
		}

		// echo "<pre>";
		// print_r($user);
		// print_r($_COOKIE);
		// echo "</pre>";

		// die();

		if ($loggedin) {
			return $user;
		} else {
			delete_cookie('6050c764989e5');
			delete_cookie('6050c7712a12e');
			delete_cookie('gjs50c7815a42z');
			redirect(base_url() . 'login');
		}
	}

	public function checkCookie()
	{
		$loggedin = false;
		if (get_cookie('6050c764989e5') && get_cookie('6050c7712a12e') && get_cookie('gjs50c7815a42z')) {
			$user_id = value_encryption(get_cookie('6050c764989e5'), 'decrypt');
			$user_nm = value_encryption(get_cookie('6050c7712a12e'), 'decrypt');
			if (is_numeric($user_id) && !is_numeric($user_nm)) {
				$loggedin = true;
			}
		}

		if ($loggedin) {
			return true;
		} else {
			delete_cookie('6050c764989e5');
			delete_cookie('6050c7712a12e');
			delete_cookie('gjs50c7815a42z');
			redirect(base_url() . 'login');
		}
	}
	   
    public function check_role_menu(){
        $data['user']  = $user         =  $this->checkLogin();
        $admin_role_id = $user->user_role;
        $uri = $this->uri->segment(1);
        $role_menus = $this->model->all_role_menu_data($admin_role_id);
        $url_array = array();
        if(!empty($role_menus))
        {
            foreach($role_menus as $menus)
            {
                array_push($url_array,$menus->url);
            }
            if(!in_array($uri,$url_array))
            {
                redirect(base_url());
            }
        }
        else
        {
            redirect(base_url());
            exit;
        }      
    } 

	function checkPermission()
	{
		$add = $update = $delete = 1;

		$user = $this->checkLogin();
		$base_url = base_url();
		$current_url = current_url();
		$url = str_replace($base_url, "", $current_url);

		$url = explode('/', $url);
		if (count($url) > 1) {
			$url = $url[0] . '/' . $url[1];
		} else {
			$url = $url[0];
		}
		if ($menu_id = $this->model->getRow('tb_admin_menu', array('url' => $url, 'status' => 1))) {
			$d = array('role_id' => $user->user_role, 'menu_id' => $menu_id->id);
			if ($parmission = $this->model->getRow('tb_role_menus', $d)) {
				$add = $parmission->add;
				$update = $parmission->update;
				$delete = $parmission->delete;
			}
		}
		$data['add'] = $add;
		$data['update'] = $update;
		$data['delete'] = $delete;
		return $data;
	}

	function checkPermission2($action)
	{
		$permission = $this->checkPermission();
		if ($permission[$action] == 1) {
			return true;
		} else {
			// echo "string";
			$data['contant'] = 'access_denied';
			$this->loadTemplate($data);
		}
	}

	function gen_Otp($mobile)
	{
		$this->delete_old_otp();
		$otp = rand(10000, 99999);
		$data = $this->model->getRow('otp', array('mobile' => $mobile));
		if ($data) {
			$otp = $data->otp;
		} else {
			$this->send_sms($otp, $mobile);
			$d = array('mobile' => $mobile, 'otp' => $otp, 'time' => time());
			$this->model->add('otp', $d);
		}
	}

	function resend_Otp($mobile)
	{
		$this->delete_old_otp();
		$otp = rand(10000, 99999);
		$data = $this->model->getRow('otp', array('mobile' => $mobile));
		if ($data) {
			$otp = $data->otp;
		} else {
			$d = array('mobile' => $mobile, 'otp' => $otp, 'time' => time());
			$this->model->add('otp', $d);
		}
		$this->send_sms($otp, $mobile);
		echo "Resend";
	}

	public function delete_old_otp()
	{
		$data = $this->model->get('otp');
		foreach ($data as $row) {
			$time =  time() - (int)$row->time;
			if ($time >= 900) {
				$this->model->delete('otp', array('id' => $row->id));
			}
		}
	}


	function send_sms($otp, $mob)
	{
		file_get_contents("http://techfizone.com/send_sms?mob=" . $mob . "&otp=" . $otp . "&id=EasyCareer");
	}

	function send_email($booking_id, $type = 'booking')
	{

		$b = $this->model->getRow('booking', $booking_id);
		// echo prx($b);

		if (@$b->email) {
			$sendOk = true;

			if ($type == 'booking') {
				$subject  = "New Booking ";
				$bodyHtml = "<p><strong>GUESTS NAME</strong> : " . $b->guest_name . " </p>
							<p><strong>BOOKING FOR</strong> : " . date('D, M d, Y', strtotime($b->start_date)) . " - " . date('D, M d, Y', strtotime($b->end_date)) . " </p>
							<p><strong>CONFIRMATION CODE</strong> : " . $b->confirmation_code . "</p>
							<p><strong>MOBILE</strong> : " . $b->contact . " </p>";
				if (@$b->razorpay_payment_link_id) {
					$bodyHtml .= "<a href='https://razorpay.com/payment-link/" . $b->razorpay_payment_link_id . "'>
				            Click here to pay</a>";
				}
			} elseif ($type == 'extend') {
				$subject = "Booking extended ";
				$bodyHtml = "<p><strong>GUESTS NAME</strong> : " . $b->guest_name . " </p>
							<p><strong>BOOKING FOR</strong> : " . date('D, M d, Y', strtotime($b->start_date)) . " - " . date('D, M d, Y', strtotime($b->end_date)) . " </p>
							<p><strong>MOBILE</strong> : " . $b->contact . " </p>";
			} elseif ($type == 'cancel') {
				$subject = "Booking cancelled ";
				$bodyHtml = "<p><strong>GUESTS NAME</strong> : " . $b->guest_name . " </p>
							<p><strong>BOOKING FOR</strong> : " . date('D, M d, Y', strtotime($b->start_date)) . " - " . date('D, M d, Y', strtotime($b->end_date)) . " </p>
							<p><strong>MOBILE</strong> : " . $b->contact . " </p>";
			} else {
				$subject = "Amazon SES test (SMTP interface accessed using PHP)";
				$bodyHtml = '<h1>Email Test</h1>
				            <p>This email was sent through the
				            <a href="https://aws.amazon.com/ses">Amazon SES</a> SMTP
				            interface using the <a href="https://github.com/PHPMailer/PHPMailer">
				            PHPMailer</a> class.</p>';
			}

			$flat = $this->model->getRow('property', ['flat_id' => $b->flat_id]);
			$propmaster = $this->model->getRow('propmaster', ['id' => $flat->propid]);

			$bodyHtml .= "<br><br><p>" . $propmaster->propname . "</p><p>" . $flat->flat_name . "( " . $flat->flat_no . " )</p><p>" . $propmaster->address . "</p><p>" . $flat->contact_preson . "</p><p>" . $flat->contact_preson_mobile . "</p>";
		}
		// die();


		if (@$sendOk) {
			$postData['to'] 		= $b->email;
			$postData['to'] 		= 'ankitv4087@gmail.com';
			// $postData['to'] 		= 'nitin.deep2008@gmail.com';
			$postData['subject'] 	= $subject;
			$postData['bodyText'] 	= "";
			$postData['bodyHtml'] 	= $bodyHtml;

			// $postData1 = json_encode($postData);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, base_url() . "mail/send");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			curl_close($ch);

			// echo prx($server_output);
		}

		// [id] => 1
		//   [renter_type] => 
		//   [booking_type] => 
		//   [booking_from] => PANEL
		//   [guest_id] => 20
		//   [confirmation_code] => 39591
		//   [status] => 4
		//   [guest_name] => Ankit Verma
		//   [gender] => Male
		//   [email] => ankitv4087@gmail.com
		//   [contact] => 8887382475
		//   [of_adults] => 1
		//   [of_children] => 0
		//   [of_infants] => 0
		//   [start_date] => 2022-01-18
		//   [end_date] => 2022-01-22
		//   [of_nights] => 5
		//   [booked] => 
		//   [listing] => 
		//   [earnings] => 
		//   [flat_id] => 330
		//   [notes] => 
		//   [checkin_time] => 
		//   [checkin_status] => 0
		//   [purpose_of_trip] => 
		//   [vehcleno] => 
		//   [checkout_time1] => 
		//   [checkout_date] => 
		//   [pre_checkout] => 0
		//   [price_type] => 
		//   [price] => 6295
		//   [user_id] => 1
		//   [security_deposit] => 0
		//   [lockin_days] => 0
		//   [notice_days] => 0
		//   [checkout_remark] => 
		//   [checkout_next_place] => 
		//   [cancel_reason] => 
		//   [is_foreigner] => 1
		//   [booking_remark] => test
		//   [order_id] => 
		//   [booking_id] => 
		//   [rzp_payment_id] => 
		//   [price_currency] => 
		//   [rzp_capture_response] => 
		//   [booking_date] => 2022-01-10
		//   [rzp_refund_response] => 
		//   [extended] => 0
		//   [extended_remark] => 
		//   [ref_booking_id] => 0
		//   [discount_amount] => 100
		//   [discount_remark] => test
		//   [flat_changed] => 0
		//   [change_flat_remark] => 
		//   [wave_off_amount] => 0
		//   [wave_off_remark] => 
		//   [service_charges] => 0
		//   [rescheduled] => 1
		//   [reschedule_remark] => 
		//   [reschedule_wave_off_amount] => 100
		//   [reschedule_wave_off_remark] => 
		//   [razorpay_payment_link_id] => plink_Ii6PTCorx2iD2s
		//   [reference_id] => 61dc5c49b84ad
		//   [payment_status] => 3
		//   [payment_mode] => 6
		//   [cancellation_reason_id] => 1
		//   [refund_amount] => 5000.00
		//   [cancellation_note] => 
	}

	public function _uploadFile($path = '', $file_name = "file")
	{
		$directory = UPLOAD_PATH . $path . '/';
		$config['upload_path']          = $directory;
		$config['allowed_types'] 		= '*';
		$config['remove_spaces']        = TRUE;
		$config['encrypt_name']         = TRUE;
		$config['max_filename']         = 20;
		$config['max_size']    			= '100';
		$this->load->library('upload', $config);
		if ($this->upload->do_upload($file_name)) {
			$upload_data = $this->upload->data();
			return $path . '/' . $upload_data['file_name'];
		} else {
			// File upload failed, handle the error
			$error = $this->upload->display_errors();
			//echo "Upload failed: $error"; // Display the error message
			return false;
		}
		// if ($this->upload->do_upload($file_name)) {
		// 	$upload_data = $this->upload->data();
		// 	return $path . '/' . $upload_data['file_name'];
		// }
		// return false;
	}
	public function _unlink_file($path, $file_name)
	{
		$directory = UPLOAD_PATH . $path . '/';
		unlink($directory . $file_name);
	}


	public function pr($data)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
	}

	public function test($amount)
	{
		echo "<img src='../../public/uploads/property-images/1617829587.jpg'>";
		$this->load->helper('file');
		$src = "../public/uploads/property-images/1617829587.jpg";  // source folder or file





		// $dest = "../public/uploads/16178295877.jpg";   // destination folder or file        
		// // echo $string = read_file('../../public/uploads/property-images/1617829587.jpg');
		// copy($src, $dest);
		// echo prx(tax_amount($amount));
	}
	
function host_earnings_new($fristDateOfMonth, $lastDateOfMonth, $todayD, $days30)
{
	//echo $days30;die();
	$property_id = get_cookie('property_id');

	$countBookings = 0;
	$host_propmaster = $this->model->host_propmaster();
	$flat_ids = array();

	if ($flats = $this->properties_by_propmaster($property_id)) {
		foreach ($flats as $flat) {
			 $flat_ids[] = $flat->flat_id;
		}
	}
	//print_r($flat_ids);die();
	// return $flat_ids;
	foreach ($flat_ids as $flat_id) {
		// by AJAY KUMAR get property id
		$property = $this->model->getRow('property',['flat_id'=>$flat_id]);
		$cond['property_id'] =  $property->propid;
		$cond['end_date >= ']   = $fristDateOfMonth;
		$cond['end_date <= ']   = $lastDateOfMonth;
		//$cond['flat_id'] 		= $flat_id;
		// $cond['status']			= 5;
		//$cond['payment_status']	= 2;

		$bookings = $this->model->getData('booking_new', $cond);
		$earnings =0;
		foreach ($bookings as $booking_row) {

			if ($booking_row->status == 2 or $booking_row->status == 5) {
				$earnings = $earnings + $booking_row->total;
			}
		}
		// echo prx($bookings);
	}



	foreach ($flat_ids as $flat_id) {
		// $cond['start_date >= '] = $days30;
		// $cond['start_date <= '] = $todayD;
		$property = $this->model->getRow('property',['flat_id'=>$flat_id]);
		$cond['property_id'] =  $property->propid;
		$cond['end_date >= ']   = $fristDateOfMonth;
		$cond['end_date <= ']   = $lastDateOfMonth;
		// $cond['start_date >= '] = $fristDateOfMonth;
		// $cond['start_date <= '] = $lastDateOfMonth;
		// $cond['flat_id'] 		= $flat_id;

		$bookings = $this->model->getData('booking_new', $cond);
		foreach ($bookings as $booking_row) {
			if ($booking_row->status == 2 or $booking_row->status == 5) {
				$countBookings = $countBookings + 1;
			}
		}
	}

	foreach ($flat_ids as $flat_id) {
		$property = $this->model->getRow('property',['flat_id'=>$flat_id]);
		$cond['property_id'] =  $property->propid;
		// $cond['end_date >= ']   = $fristDateOfMonth;
		// $cond['end_date <= ']   = $lastDateOfMonth;
		$cond['booking_date']   = $todayD;
		// $cond['flat_id'] 		= $flat_id;
		$bookings = $this->model->getData('booking_new', $cond);
		 $todayBooking=0;
		foreach ($bookings as $booking_row) {
			$todayBooking = $todayBooking + 1;
		}
	}

	$return['totalBookings'] = $countBookings;
	$return['totalEarnings'] = @$earnings;
	$return['todayBooking'] = @$todayBooking;

	return $return;
}

function FindPreCheckin($booking_id)
{
	$cond['booking_id']   = $booking_id;
	$checkins = $this->model->getData('checkin', $cond);
	$Tpre = 0;
	foreach($checkins as $c)
	{
     $Tpre = $Tpre+$c->pre_checkin_amount;
	}

	return $Tpre;
}


}


