<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Dashboard extends Main {

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

		$earnings = $this->host_earnings($fristDateOfMonth,$lastDateOfMonth,$todayD,$days30);
//		 echo "<pre>";
//		 print_r($earnings);
//		 echo "</pre>";
//		 die();

		$host_propmaster = $this->model->host_propmaster();

		

		// $total_flats = 0;
		$flats = array();
		if ($host_propmaster) {
			foreach ($host_propmaster as $h_propRow) {
				if($flat = $this->model->getData('property',['propid'=>$h_propRow->id,'status'=>1])){
					foreach ($flat as $frow) {
						$flats[] = $frow;
					}
					// $total_flats = $total_flats + count($flat);
				}
			}
		}

		// $available = $total_flats;

		// availability 
		$available = $blocked = $occupied = array();

		foreach ($flats as $frow) {
			$check['date'] 		  = $date;
			$check['property_id'] = $frow->flat_id;
			if ($pi = $this->model->getRow('property_inventory',$check)) {
				// print_r($pi);
				if ($pi->status==0 or $pi->status==1) {
					$available[] = $frow->flat_id;
				}
				if ($pi->status==2) {
					$blocked[] = $frow->flat_id;
				}
				if ($pi->status==3) {
					$occupied[] = $frow->flat_id;
				}
			}
			else{
				$available[] = $frow->flat_id;
			}
		}
		// availability 
		$count['available'] = $available;
		$count['blocked']   = $blocked;
		$count['occupied']  = $occupied;
		// echo $available;

		$data['available'] = $available;
		$data['blocked']   = $blocked;
		$data['occupied']  = $occupied;
		$data['totalBookings']  = $earnings['totalBookings'];
		$data['totalEarnings']  = $earnings['totalEarnings'];
		$data['todayBookings']  = $earnings['todayBooking'];

		// $this->pr($count);

		$bookings = $this->model->host_bookings();

		$check_in_remaining 	= array();
		$checked_in 			= array();
		$check_out_remaining 	= array();
		$checked_out 			= array();
		$staying 				= array();
		$upcoming_booking 		= array();
		$payments 				= array();

		foreach ($bookings as $brow) {

			// check_in_remaining
			if ($brow->start_date==$date && $brow->status==2 && $brow->checkin_status==0) {
				$check_in_remaining[] = $brow;
			}

			// checked_in
			if($brow->start_date==$date && $brow->status==2 && $brow->checkin_status==1){
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
		// $data['detail_url']	  			= base_url().'reservations/detailes/';
		$data['logo'] = base_url().'static/app-assets/images/logo/logo.png';
		$data['rows']    	= $this->model->host_propmaster();

		// $this->pr($data);
		// $this->template($data);
		load_view($data["contant"],$data);
	}

		public function host_occupied_property()
	{
		$date  = date('Y-m-d');
		$host_propmaster = $this->model->host_propmaster();

		$flats = array();
		foreach ($host_propmaster as $h_propRow) {
			if($flat = $this->model->getData('property',['propid'=>$h_propRow->id,'status'=>1])){
				foreach ($flat as $frow) {
					$flats[] = $frow;
				}
			}
		}

		// $available = $total_flats;

		// availability 
		$occupied = array();

		foreach ($flats as $frow) {
			$check['date'] 		  = $date;
			$check['property_id'] = $frow->flat_id;
			if ($pi = $this->model->getRow('property_inventory',$check)) {
				if ($pi->status==3) {
					$occupied[] = $frow;
				}
			}
		}
		// availability 

		$data['rows']  	   = $occupied;
		$data['contant']   = 'availability_property_list';
		load_view($data["contant"],$data);
		// $this->pr($data);
		// echo "occupied_property";
	}

	public function host_availabile_property()
	{
		$date  = date('Y-m-d');
		$host_propmaster = $this->model->host_propmaster();

		$flats = array();
		foreach ($host_propmaster as $h_propRow) {
			if($flat = $this->model->getData('property',['propid'=>$h_propRow->id,'status'=>1])){
				foreach ($flat as $frow) {
					$flats[] = $frow;
				}
			}
		}

		// $available = $total_flats;

		// availability 
		$occupied = array();

		foreach ($flats as $frow) {
			$check['date'] 		  = $date;
			$check['property_id'] = $frow->flat_id;
			if ($pi = $this->model->getRow('property_inventory',$check)) {
				// print_r($pi);
				if ($pi->status==0 or $pi->status==1) {
					$available[] = $frow;
				}
			}
			else{
				$available[] = $frow;
			}
		}
		// availability 

		$data['rows']  	   = $available;
		$data['contant']   = 'availability_property_list';
		load_view($data["contant"],$data);
	}



	
}
