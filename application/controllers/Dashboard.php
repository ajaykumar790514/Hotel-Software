<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Dashboard extends Main {

	// public function __construct() {
    //     parent::__construct();
	// 	$this->check_role_menu();
    // }
	public function index()
	{
		
		$data["user"]    = $user = $this->checkLogin();
		$data["title"]   = 'Dashboard';
		$data["contant"] = 'dashboard';		
		
		$data['page_content_url'] = base_url().'dashboard_content';
		if (@$_GET['content']=='tomorrow') {
			$content  = 'tomorrow';
		}
		else {
			$content  = 'today';
		}
		
		// content
		if ($user->type=="host") {
			
			$data['page_content_url'] = base_url().'host_dashboard_content?content='.$content;
		}
		// $this->pr($data);
		$this->template($data);
	}

	public function dashboard_content()
	{
		
		$data["user"]    = $user = $this->checkLogin();
		$data["title"]   = 'Dashboard';
		$data["contant"] = 'dashboard_content';
		$data["total_host"] = $this->model->getData('usermaster');
		$data["total_property"] = $this->model->getData('propmaster');
		// $this->pr($data);
		// $this->template($data);
		load_view($data["contant"],$data);
	}

	public function host_dashboard_content()
	{
		
		if (!$_GET['content']) {
			die();
		}
		
		$data["user"]    = $user = $this->checkLogin();
		$data["title"]   = 'Dashboard';
		$data["contant"] = 'host_dashboard_content';

		if (@$_GET['content']=='tomorrow') {
			$date  = date("Y-m-d",strtotime(' +1 day'));
		}
		else {
			$date  = date('Y-m-d');
		}

		$data["date"]  	 = $date ;
		$data["month"] 	 = $month = date('m',strtotime($date));
		$data["year"]  	 = $year  = date('Y',strtotime($date));

		$data["monthDateStr"]     = date('d F Y D',strtotime($date));
		$data["_month"]   		  = date('F',strtotime($date));
		$data["todayD"] = $todayD =	$date;
		$data["days30"] = $days30 = date("Y-m-d",strtotime($date.' -30 day'));
		$data["tomorrowD"]  	  = date("Y-m-d",strtotime(' +1 day'));

		// $data["date"]  = $date  = date('Y-m-d');
		// $data["month"] = $month = date('m');
		// $data["year"]  = $year  = date('Y');
		// $data["monthDateStr"] = date('F-Y');

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		// die();

		$current_Month 	  = $month;
		$year 			  = $year;
		$numberOfDays     = cal_days_in_month(CAL_GREGORIAN,$current_Month,$year);
		$lastDateOfMonth  = date('Y-m-'.sprintf("%02d",$numberOfDays),mktime(12, 0, 0, $current_Month, 1, $year));
		$fristDateOfMonth = $year.'-'.$month.'-01';

		$lastDateOfMonth;
		$fristDateOfMonth;

		$earnings = $this->host_earnings_new($fristDateOfMonth,$lastDateOfMonth,$todayD,$days30);
		// echo "<pre>";
		// print_r($earnings);
		// echo "</pre>";
		// die();
		//  $property_id = get_cookie('property_id');
		//  $cond['property_id'] =  $property_id;

		//  $cond['end_date >= ']   = $fristDateOfMonth;
		//  $cond['end_date <= ']   = $lastDateOfMonth;


		//$host_propmaster = $this->model->host_propmaster();

		 $property_id = get_cookie('property_id');

		//  Get total booking
		 $cond['property_id'] =  $property_id;	
		 $cond['end_date >= ']   = $fristDateOfMonth;
		 $cond['end_date <= ']   = $lastDateOfMonth;
		 $rs = $this->model->get_bookings_new($property_id,$fristDateOfMonth,$lastDateOfMonth);
		 $Tbooking = 0;
         foreach($rs as $r):
         $Tbooking = $Tbooking + 1;
		 $precheckin = $this->FindPreCheckin($r->id);
		 endforeach;	
		 $rs2 = $this->model->get_bookings_new_transaction($property_id,$fristDateOfMonth,$lastDateOfMonth);
		 $Tearning = 0;
         foreach($rs2 as $r2):
         $Tearning = $Tearning + $r2->credit;
		 endforeach;
		// $total_flats = 0;
		$flats = array();
		
				// if($flat = $this->model->getData('property',['propid'=>$property_id,'status'=>1,'is_deleted'=>'not_deleted'])){
				// 	foreach ($flat as $frow) {
				// 		$flats[] = $frow;
				// 	}
				// 	// $total_flats = $total_flats + count($flat);
				// }
				if ($flat = $this->model->getData('property', ['propid' => $property_id, 'status' => 1, 'is_deleted' => 'not_deleted'])) {
					foreach ($flat as $frow) {
						$this->db->select('*');
						$this->db->from('property_inventory');
						$this->db->where([
							'property_inventory.property_id' => $frow->propid,
							'property_inventory.sub_pro_type_id' => $frow->sub_property_type_id,
						]);
						$inventory_status = $this->db->get()->row();
				
						if (!$inventory_status) {
							$flats[] = $frow;
							continue;
						}
				
						if ($inventory_status->status != 2) {
							$flats[] = $frow;
						}
					}
				}

		// $available = $total_flats;

		// availability 
		$available = $blocked = $occupied = array();

		foreach ($flats as $frow) {
			$pi = $this->model->getRow('room_allotment',['is_checkout'=>'0','property_id'=>$frow->propid,'flat_id'=> $frow->flat_id]);
			if(@$pi->flat_id == $frow->flat_id)
			{
				$occupied[] = $frow;
			}
			if(@$pi->flat_id != $frow->flat_id)
			{
				$available[] = $frow;
			}
			// $check['date'] 		  = $date;
			// $check['property_id'] = $frow->flat_id;
			// if ($pi = $this->model->getRow('property_inventory',$check)) {
			// 	// print_r($pi);
			// 	if ($pi->status==0 or $pi->status==1) {
			// 		$available[] = $frow->flat_id;
			// 	}
			// 	if ($pi->status==2) {
			// 		$blocked[] = $frow->flat_id;
			// 	}
			// 	// 3
			// 	if ($pi->status==2) {
			// 		$occupied[] = $frow->flat_id;
			// 	}
			// }
			// else{
			// 	$available[] = $frow->flat_id;
			// }
		}
		// availability 
		$count['available'] = $available;
		$count['blocked']   = $blocked;
		$count['occupied']  = $occupied;
		// echo $available;
		
		// echo $date;
		$TAverage=$Troom=$Rooms=$TSale =0;
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($_COOKIE['property_id'])) { 
	    $report    =  $this->model->dash_arr_report($_COOKIE['property_id'],$date);
	    
          foreach ($report as $re):
			$Rooms = count($this->model->getDataRoomAllotment('room_allotment',['property_id'=>$re->property_id,'booking_id'=>$re->id,'is_checkout'=>'0']));
			$TSale +=$re->total;
			$Troom +=$Rooms;
			if($Rooms > 0){
			$TAverage = $TSale/$Troom;
			}
		  endforeach;		
		}

		$data['available'] = $available;
		$data['blocked']   = $blocked;
		$data['occupied']  = $occupied;
		$data['TAverage'] =$TAverage;
		$data['TSale']    =$TSale;
		$data['Troom']   = $Troom;  
		$data['totalBookings']  = $earnings['totalBookings'];
		$data['totalEarnings']  = $earnings['totalEarnings'];
		$data['todayBookings']  = $earnings['todayBooking'];
        $data['TBoooking']      = $Tbooking;
		// get amount transaction table and checkin
		$data['Tearning']       = $Tearning;
		$data['property_xist']  = @$_COOKIE['property_id'];
		// $data['Tearning']       = $Tearning + @$precheckin;
		// $this->pr($count);

		if(@$_COOKIE['property_id']){
			$_POST['propmaster'] = $_COOKIE['property_id'];
		}

		$bookings = $this->model->host_bookings_new();
       if(!empty($bookings))
	   {
        $booking = $bookings;
	   }else
	   {
		$booking=[];
	   }
		$check_in_remaining 	= array();
		$checked_in 			= array();
		$check_out_remaining 	= array();
		$checked_out 			= array();
		$staying 				= array();
		$upcoming_booking 		= array();
		$payments 				= array();
		$reservations_total 		= array();
		$cancelled_reservation  = array();

		foreach ($booking as $brow) {

			// check_in_remaining
			if ($brow->start_date==$date && $brow->status==2 && $brow->checkin_status==0) {
				$check_in_remaining[] = $brow;
			}

			// checked_in $brow->start_date==$date &&
			if( $brow->status==2 && $brow->checkin_status==1){
				$checked_in[] = $brow;
			}

			// check_out_remaining
			if($brow->end_date==$date && $brow->status==2 && $brow->checkout_time1==null){
				$check_out_remaining[] = $brow;
			}

			// checked_out
			if($brow->end_date==$date && $brow->status==5 && $brow->checkout_time1!=null){
				$checked_out[] = $brow;
			}

			// staying
			if( ($brow->start_date>=$date) && ($brow->start_date<=$date) && ($brow->status==2) && ($brow->checkin_status==1)){
				$staying[] = $brow;
			}

			// reservations total
			if( ($brow->start_date==$date)){
				$reservations_total[] = $brow;
			}
			// reservations total
			if( ($brow->start_date ==$date) && $brow->status==4  && $brow->cancellation =="YES"){
				$cancelled_reservation[] = $brow;
			}

			// upcoming_booking
			$today = strtotime(date('Y-m-d'));
			$bdate = strtotime($brow->start_date);
			$datediff = $bdate - $today;
			$datediff = round($datediff / (60 * 60 * 24));
			// echo "<pre>";
			// echo $brow->start_date."<br>";
			// echo date('Y-m-d',time())."<br>";
			// echo $datediff.'<br>';

			
			
			// echo "</pre>";
			if(($datediff>=1) && ($brow->start_date<=$lastDateOfMonth) && ($brow->status==2) && ($brow->checkin_status==0)){
				$brow->datediff = $datediff;
				$upcoming_booking[] = $brow;
			}
		}

		$data['check_in_remaining'] 	= $check_in_remaining;
		$data['checked_in'] 			= $checked_in;
		$data['check_out_remaining'] 	= $check_out_remaining;
		$data['checked_out'] 			= $checked_out;
		$data['staying'] 				= $staying;
		$data['upcoming_booking'] 		= $upcoming_booking;
		$data['reservations_total']     = $reservations_total;
		$data['cancelled_reservation']  = $cancelled_reservation;
		// $data['detail_url']	  			= base_url().'reservations/detailes/';
		$get_host_logo = $this->model->get_host_logo($user->id);
		if(empty($get_host_logo))
		{
			$data['logo'] = IMGS_URL.@$get_host_logo->logo;
			
		}else
		{
       $data['logo'] = base_url() . 'static/app-assets/images/logo/logo.png';
		}
		$prop_list = 'list';
		$data['rows']    	= $this->model->host_propmaster($prop_list);

		// $this->pr($data);
		// $this->template($data);
		load_view($data["contant"],$data);
	}

		public function host_occupied_property()
	{
		if (@$_GET['date']==date("Y-m-d",strtotime(' +1 day'))) {
			$date  = date("Y-m-d",strtotime(' +1 day'));
		}
		else {
			$date  = date('Y-m-d');
		}
		$data["date"]  	 = $date ;
		$host_propmaster = $this->model->host_propmaster();

		$flats = array();
		foreach ($host_propmaster as $h_propRow) {
			// if($flat = $this->model->getData('property',['propid'=>$h_propRow->id,'status'=>1],'asc','flat_no')){
			// 	foreach ($flat as $frow) {
			// 		$flats[] = $frow;
			// 	}
			// }
			if ($flat = $this->model->getData('property', ['propid' =>$h_propRow->id, 'status' => 1, 'is_deleted' => 'not_deleted'])) {
				foreach ($flat as $frow) {
					$this->db->select('*');
					$this->db->from('property_inventory');
					$this->db->where([
						'property_inventory.property_id' => $frow->propid,
						'property_inventory.sub_pro_type_id' => $frow->sub_property_type_id,
					]);
					$inventory_status = $this->db->get()->row();
			
					if (!$inventory_status) {
						$flats[] = $frow;
						continue;
					}
			
					if ($inventory_status->status != 2) {
						$flats[] = $frow;
					}
				}
			}
		}

		// $available = $total_flats;

		// availability 
		$occupied = array();

		foreach ($flats as $frow) {
			$pi = $this->model->getRow('room_allotment',['is_checkout'=>'0','property_id'=>$frow->propid,'flat_id'=> $frow->flat_id]);
			if(@$pi->flat_id == $frow->flat_id)
			{
				$occupied[] = $frow;
				$occupied[count($occupied) - 1]->booking_id = $pi->booking_id;
			}
			//  $check['date'] 		  = $date;
			//  $check['property_id'] = $frow->flat_id;
			// if ($pi = $this->model->getRow('property_inventory',$check)) {
				
			// 	if ($pi->status==3) {
			// 		$occupied[] = $frow;
			// 	}
			// }
			// else{
			// 	$occupied[] = $frow;
			// }
		}
		// availability 

		$data['rows']  	   = $occupied;
		$data['contant']   = 'host_occupied_property';
		load_view($data["contant"],$data);
		// $this->pr($data);
		// echo "occupied_property";
	}

	public function host_availabile_property()
	{
		if (@$_GET['date']==date("Y-m-d",strtotime(' +1 day'))) {
			$date  = date("Y-m-d",strtotime(' +1 day'));
		}
		else {
			$date  = date('Y-m-d');
		}
		$data["date"]  	 = $date ;
		$host_propmaster = $this->model->host_propmaster();
    
		$flats = array();
		foreach ($host_propmaster as $h_propRow) {
			if($flat = $this->model->getData('property',['propid'=>$h_propRow->id,'status'=>1,'is_deleted'=>'not_deleted'],'asc','flat_no')){
				foreach ($flat as $frow) {
					$this->db->select('*');
					$this->db->from('property_inventory');
					$this->db->where([
						'property_inventory.property_id' => $frow->propid,
						'property_inventory.sub_pro_type_id' => $frow->sub_property_type_id,
					]);
					$inventory_status = $this->db->get()->row();
			
					if (!$inventory_status) {
						$flats[] = $frow;
						continue;
					}
			
					if ($inventory_status->status != 2) {
						$flats[] = $frow;
					}
				}
			}
		}
		// $available = $total_flats;

		// availability 
		$available = array();

		foreach ($flats as $frow) {
			$pi = $this->model->getRow('room_allotment',['is_checkout'=>'0','property_id'=>$frow->propid,'flat_id'=> $frow->flat_id]);
			if(@$pi->flat_id != $frow->flat_id)
			{
				
				$available[] = $frow;
			}
			// if ($pi = $this->model->getRow('room_allotment',$check)) {
			// 	// print_r($pi);
			// 	if ( $pi->flat_id != $frow->flat_id) {
			// 		$available[] = $frow;
			// 	}
			// }
			// else{
			// 	$available[] = $frow;
			// }

			// if ($pi = $this->model->getRow('property_inventory',$check)) {
			// 	// print_r($pi);
			// 	if ($pi->status==0 or $pi->status==1) {
			// 		$available[] = $frow;
			// 	}
			// }
			// else{
			// 	$available[] = $frow;
			// }
		}
		// availability 

		$data['rows']  	   = $available;
		$data['contant']   = 'availability_property_list';
		load_view($data["contant"],$data);
	}



	
}
