<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Inventory extends Main {

	public function __construct() {
        parent::__construct();
		$this->checkPlan(@$_COOKIE['property_id']);
			$this->check_role_menu();
		}
	public function index($action=null,$pro_id=null, $flat_id=null,$cdate=null)
	{
		$data['user']    = $user = $this->checkLogin();
		$data['pro_id']  = $pro_id;
		$data['flat_id'] = $flat_id;
		switch ($action) {
			case null:
				$data['title']      = 'Property Inventory';
				$data['contant']    = 'inventory/inventory';
				$function = 'propmaster';
				if ($user->type=='host') {
					$function = 'host_propmaster';
				}
				$data['rows']    	= $this->model->$function();
				// $this->pr($data);
				$this->template($data);
				break;

			case 'tb':

				break;

			case 'calendar':

				$data['month'] 		  = date('m');
				// $data['monthName'] = date('F');
				$data['year']  		  = date('Y');
				$data['pro_id'] 	  = $pro_id;
				$data['flat_id']      = $flat_id;
				$data['title']        = 'Inventory';
				$data['prow'] 		  = $prow = $this->model->getRow('property',['flat_id'=>$flat_id]);
				$data['pmrow'] 	      = $this->model->getRow('propmaster',['id'=>@$prow->propid]);
				$data['contant']      = 'inventory/price_calender';

				load_view($data['contant'],$data);

				break;

			case 'bulk_inventory_pricing':
				$data['pro_id'] 	  = $pro_id;
				$data['flat_id']      = $flat_id;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if (@$_POST['days']) {
						if(is_array($_POST['days'])){
							$period = new DatePeriod(
								     new DateTime($_POST['startDate']),
								     new DateInterval('P1D'),
								     new DateTime($_POST['endDate'])
								);
							foreach($period as $date) {                 
						        $dateArray[] = $date->format('Y-m-d'); 
						    }
						    $dateArray[] =$_POST['endDate'];

	 						foreach ($dateArray as $drow) {
	 
								$timestamp = strtotime($drow);
								$day = date('l', $timestamp);
								
								if (in_array($day, $_POST['days'])) {
								    $inventoryData = [
										'property_id' => $pro_id,
										'sub_pro_type_id' => $flat_id,
										'date' => $drow,
										'ep_price' => $_POST['epPrice'],
										'cp_price' => $_POST['cpPrice'],
										'map_price' => $_POST['mapPrice'],
										'ap_price' => $_POST['apPrice'],
										'ep_extra_bedding_price' => $_POST['epextraBeddingPrice'],
										'cp_extra_bedding_price' => $_POST['cpextraBeddingPrice'],
										'map_extra_bedding_price' => $_POST['mapextraBeddingPrice'],
										'ap_extra_bedding_price' => $_POST['apextraBeddingPrice'],
										'status' => $_POST['status']
									];
									$this->save_inventory($inventoryData, 'no');
								}
							}
						}
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
					else{
						$return['res'] = 'error';
						$return['msg'] = 'Days not selected!';
					}
					echo json_encode($return);
				}
				else{
					
					$data['contant']      = 'inventory/bulk_inventory_pricing';
					load_view($data['contant'],$data);
				}

				break;
			//  case 'inventory_cal':
			// 		$current_Month = $_POST['month'];
			// 		$year = $_POST['year'];
			// 		$flat_id = $_POST['flat_id'];
			// 		$date = mktime(12, 0, 0, $current_Month, 1, $year);
			// 		$numberOfDays =cal_days_in_month(CAL_GREGORIAN,$current_Month, $year);
			// 		$offset = date("w", $date);
			// 		$row_number = 1;
			// 		//month header
			// 		$cal ="<table class='myCal'><br/>";
			// 		$cal .="<thead><tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr></thead> <tbody><tr>";
			// 		// print the additional td record in case the month is not starting with the Sunday.
			// 		for($i = 1; $i <= $offset; $i++)
			// 		{
			// 			$cal .="<td></td>";
			// 		}
			// 		//  this will print the number of days.
			// 		for($day = 1; $day <= $numberOfDays; $day++)
			// 		{
			// 			if( ($day + $offset - 1) % 7 == 0 && $day != 1)
			// 			{
			// 				$cal .="</tr> <tr>";
			// 				$row_number++;
			// 			}
			
			// 			$cal .="<td>";
			// 			$cal .="<span class='day row'>";
			// 			$pdate = date('Y-m-'.sprintf("%02d",$day),$date);
			
			// 			$check['sub_pro_type_id']  = $flat_id;
			// 			$check['date']         = $pdate;
			// 			$daily_price = $extra_bedding_price = 0;
			// 			$astatus = '';
			// 			$bstatus = '';
			// 			$disabled = '';
			// 			if($row = $this->model->getRow('property_inventory',$check)){
			// 				$daily_price = $row->ap_price;
			// 				$extra_bedding_price = $row->ap_extra_bedding_price;
							
			// 				if ($row->status==1) {
			// 					$astatus = 'selected';
			// 					$disabled = '';
			// 				}
			// 				if ($row->status==2) {
			// 					$bstatus = 'selected';
			// 					$disabled = 'disabled';
			// 				}
			// 				if ($row->status==3) {
			// 					$disabled = 'disabled';
			// 				}
			// 			}
			
			// 			$cal .= "<span class='col-6'><input type='checkbox' $disabled class='form-control select-date' value='$pdate' name='select_date[]' ></span>";
			// 			$cal .= "<span class='col-6 text-right'>".sprintf("%02d",$day)."</span>";
						
						
			// 			$cal .= "</span>";
			// 			$cal .= "<input type='number' class='form-control bg-primary' oninput='save_inventory(this)' p-type='daily_price' p-date='$pdate' f-id='$flat_id' min=0 value='$daily_price' >"; 
			// 			$cal .= "<input type='number' class='form-control bg-info' oninput='save_inventory(this)' p-type='extra_bedding_price' p-date='$pdate' f-id='$flat_id' min=0 value='$extra_bedding_price'>";
			// 			if (@$row->status!=3) {
			// 				$cal .= "<select class='form-control bg-dark' onchange='save_inventory(this)' p-type='status' p-date='$pdate' f-id='$flat_id'><option value='0' > -- Status --</option><option value='1' $astatus >Available </option><option value='2' $bstatus > Blocked</option></select>";
			// 			}
			// 			else {
			// 				$cal .= '<span class="text-info d-flex justify-content-center">Reservated</span>';
			// 			}
						
			// 			$cal .="</td>";
			// 		}
			// 		while( ($day + $offset) <= $row_number * 7)
			// 		{
			// 			$cal .="<td></td>";
			// 			$day++;
			// 		}
			// 		$cal .="</tr></tbody></table>";
			// 		echo $cal;
			// 	break;
				case 'inventory_cal':
					$current_Month = $_POST['month'];
					$year = $_POST['year'];
					$flat_id = $_POST['flat_id'];
					$prop_id = $_POST['prop_id'];
					$date = mktime(12, 0, 0, $current_Month, 1, $year);
					$numberOfDays =cal_days_in_month(CAL_GREGORIAN,$current_Month, $year);
					$offset = date("w", $date);
					$row_number = 1;
					//month header
					$cal ="<table class='myCal'><br/>";
					$cal .="<thead><tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr></thead> <tbody><tr>";
					// print the additional td record in case the month is not starting with the Sunday.
					for($i = 1; $i <= $offset; $i++)
					{
						$cal .="<td></td>";
					}
					//  this will print the number of days.
					for($day = 1; $day <= $numberOfDays; $day++)
					{
						if( ($day + $offset - 1) % 7 == 0 && $day != 1)
						{
							$cal .="</tr> <tr>";
							$row_number++;
						}
			
						$cal .="<td>";
						$cal .="<span class='day row'>";
						$pdate = date('Y-m-'.sprintf("%02d",$day),$date);
			
						$check['sub_pro_type_id']  = $flat_id;
						$check['date']         = $pdate;
						$daily_price = $extra_bedding_price = 0;
						$astatus = '';
						$bstatus = '';
						$disabled = '';
						if($row = $this->model->getRow('property_inventory',$check)){
							$daily_price = $row->ap_price;
							$extra_bedding_price = $row->ap_extra_bedding_price;
							
							if ($row->status==1) {
								$astatus = 'selected';
								$disabled = '';
							}
							if ($row->status==2) {
								$bstatus = 'selected';
								$disabled = 'disabled';
							}
							if ($row->status==3) {
								$disabled = 'disabled';
							}
						}
						$formattedDate = date('d F Y',strtotime($pdate));
						$cal .= "<span class='col-6'><input type='checkbox' $disabled class='form-control select-date' value='$pdate' name='select_date[]' ></span>";
						$cal .= "<span class='col-6 text-right'>".sprintf("%02d",$day)."</span>";
						
						
						$cal .= "</span>";
						$cal .= "<button type='button' class='mb-1 ml-1 btn btn-primary btn-sm'  data-toggle='modal' data-target='#showModal' data-whatever='Set Pricing of ".$formattedDate."' data-url='".base_url()."inventory/set_inventory_pricing/".$prop_id."/".$flat_id."/".$pdate."'>Set Pricing</button>";
						$cal .= "<a style='cursor:pointer' data-toggle='modal' data-target='#showModal' data-whatever='Set Pricing of ".$formattedDate."' data-url='".base_url()."inventory/view_inventory_pricing/".$prop_id."/".$flat_id."/".$pdate."' ><i class='la la-eye mb-1 ml-1 text-danger' style='margin-top:2px;font-size:25px' ></i></a>";
				
						$cal .="</td>";
					}
					while( ($day + $offset) <= $row_number * 7)
					{
						$cal .="<td></td>";
						$day++;
					}
					$cal .="</tr></tbody></table>";
					echo $cal;
				break;
				case 'set_inventory_pricing':
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!.';
					$data['pro_id'] 	  = $pro_id;
				    $data['flat_id']      = $flat_id;
					$sub_property_types = $this->model->getRow('sub_property_types',['spt_id'=>$flat_id]);
					if(!empty($sub_property_types)){
					if ($this->input->server('REQUEST_METHOD')=='POST') {
						if(!empty($_POST['date'])){
							if(!empty($flat_id)){
							$check['sub_pro_type_id']  = $flat_id;
							$check['property_id']     = $pro_id;
							$check['date']         = $_POST['date'];
							if($id=$this->model->getRow('property_inventory',$check)){
								$inventoryData = [
									'ep_price' => $_POST['epPrice'],
									'cp_price' => $_POST['cpPrice'],
									'map_price' => $_POST['mapPrice'],
									'ap_price' => $_POST['apPrice'],
									'ep_extra_bedding_price' => $_POST['epextraBeddingPrice'],
									'cp_extra_bedding_price' => $_POST['cpextraBeddingPrice'],
									'map_extra_bedding_price' => $_POST['mapextraBeddingPrice'],
									'ap_extra_bedding_price' => $_POST['apextraBeddingPrice'],
									'status' => $_POST['status']
								];
								if ($this->model->Update('property_inventory',$inventoryData,$check)) {
									logs($user->id,$id->pi_id,'EDIT','Edit Inventory ');
									$saved = 1;
								}
							}
							else{
								$inventoryData = [
									'property_id' => $pro_id,
									'sub_pro_type_id' => $flat_id,
									'date' => $_POST['date'],
									'ep_price' => $_POST['epPrice'],
									'cp_price' => $_POST['cpPrice'],
									'map_price' => $_POST['mapPrice'],
									'ap_price' => $_POST['apPrice'],
									'ep_extra_bedding_price' => $_POST['epextraBeddingPrice'],
									'cp_extra_bedding_price' => $_POST['cpextraBeddingPrice'],
									'map_extra_bedding_price' => $_POST['mapextraBeddingPrice'],
									'ap_extra_bedding_price' => $_POST['apextraBeddingPrice'],
									'status' => $_POST['status']
								];
			
								if ($id=$this->model->Save('property_inventory',$inventoryData)) {
									logs($user->id,$id,'ADD','Save Inventory');
									$saved = 1;
								}
							}
							if($saved==1){
								$return['res'] = 'success';
								$return['msg'] = 'Saved.';
							}
						 }else{
							$return['res'] = 'error';
							$return['msg'] = 'Please select Room Category.';
						 }
						}else{
							$return['res'] = 'error';
							$return['msg'] = 'Date Not Get!.';
						}
						echo json_encode($return);
					}
					else{
						$check['sub_pro_type_id'] = $flat_id;
						$check['property_id'] = $pro_id;
						$check['date'] = $cdate;
						$data['date'] = $cdate;
					    $data['inventory'] = $this->model->getRow('property_inventory', $check);
						$data['contant']      = 'inventory/set_inventory_pricing';
						load_view($data['contant'],$data);
					}
				}else{
					echo "<p class='text-danger text-center'>Please select Room Category</p>";
				}
				break;	
				case 'view_inventory_pricing':
					$data['pro_id'] 	  = $pro_id;
				    $data['flat_id']      = $flat_id;
					$sub_property_types = $this->model->getRow('sub_property_types',['spt_id'=>$flat_id]);
					if(!empty($sub_property_types)){
						$check['sub_pro_type_id'] = $flat_id;
						$check['property_id'] = $pro_id;
						$check['date'] = $cdate;
						$data['date'] = $cdate;
					    $data['inventory'] = $this->model->getRow('property_inventory', $check);
						$data['contant']      = 'inventory/view_inventory_pricing';
						load_view($data['contant'],$data);
				}else{
					echo "<p class='text-danger text-center'>Please select Room Category</p>";
				}
				break;	
				case 'save_inventory':
					$response='yes';
					$saved=0;
					$data['user']=$user    = $this->checkLogin();
					// echo json_encode($_POST);
					if ($_POST['type']!='status') {
					
						$sub_property_types = $this->model->getRow('sub_property_types',['spt_id'=>$_POST['property_id']]);
							$check['sub_pro_type_id']  = $_POST['property_id'];
							$check['property_id']     = $sub_property_types->property_id;
							$check['date']         = $_POST['date'];
							$update[$_POST['type']] = $_POST['price'];
							if($this->model->getRow('property_inventory',$check)){
								if ($this->model->Update('property_inventory',$update,$check)) {
									logs($user->id,$sub_property_types->property_id,'EDIT','Edit Inventory ');
									$saved = 1;
								}
							}
							else{
								echo $_POST['property_id'];
								$save['sub_pro_type_id']  = $_POST['property_id'];
								$save['property_id']     = $sub_property_types->property_id;
								$save[$_POST['type']] = $_POST['price'];
								$save['date']         = $_POST['date'];
			
								if ($id=$this->model->Save('property_inventory',$save)) {
									logs($user->id,$id,'ADD','Save Inventory');
									$saved = 1;
								}
							}
					}else{
						$sub_property_types = $this->model->getRow('sub_property_types',['spt_id'=>$_POST['property_id']]);
						$check['sub_pro_type_id']  = $_POST['property_id'];
						$check['property_id']     = $sub_property_types->property_id;
						$check['date']         = $_POST['date'];
			
						$update[$_POST['type']] = $_POST['price'];
						if($this->model->getRow('property_inventory',$check)){
							if ($this->model->Update('property_inventory',$update,$check)) {
								logs($user->id,$sub_property_types->property_id,'EDIT','Edit Inventory ');
								$saved = 1;
							}
						}
						else{
							$save['sub_pro_type_id']  = $_POST['property_id'];
							$save['property_id']     = $sub_property_types->property_id;
							$save[$_POST['type']] = $_POST['price'];
							$save['date']         = $_POST['date'];
			
							if ($id=$this->model->Save('property_inventory',$save)) {
								logs($user->id,$id,'ADD','Save Inventory');
								$saved = 1;
							}
						}
			
					}		
			
					if ($response=='yes') {
						if ($saved==1) {
							echo '<span class="text-success">Saved.</span>';
						}
						else{
							echo '<span class="text-danger">Not Saved!</span>';
						}
					}
					
				break;
		}
	}

	function save_inventory($data, $response = 'yes') {
		$saved = 0;
		$data['user']=$user    = $this->checkLogin();
		$check = [
			'property_id' => $data['property_id'],
			'sub_pro_type_id' => $data['sub_pro_type_id'],
			'date' => $data['date']
		];
	
		if ($in = $this->model->getRow('property_inventory', $check)) {
			if ($this->model->Update('property_inventory', $data, $check)) {
				$saved = 1;
				logs($user->id,$in->pi_id,'EDIT','Edit Inventory');
			}
		} else {
			if ($id=$this->model->Save('property_inventory', $data)) {
				$saved = 1;
				logs($user->id,$id,'ADD','Save Inventory');
			}
		}
	
		if ($response == 'yes') {
			if ($saved == 1) {
				echo '<span class="text-success">Saved.</span>';
			} else {
				echo '<span class="text-danger">Not Saved!</span>';
			}
		}
	}
	
	// function save_inventory($response='yes'){
	// 	$saved=0;
	// 	// echo json_encode($_POST);
	// 	$check['property_id']  = $_POST['property_id'];
	// 	$check['sub_pro_type_id']  = $_POST['sub_pro_type_id'];
	// 	$check['date']         = $_POST['date'];

	// 	$update[$_POST['type']] = $_POST['price'];
	// 	if($this->model->getRow('property_inventory',$check)){
	// 		if ($this->model->Update('property_inventory',$update,$check)) {
	// 			$saved = 1;
	// 		}
	// 	}
	// 	else{
	// 		$save['property_id']  = $_POST['property_id'];
	// 		$save['sub_pro_type_id']  = $_POST['sub_pro_type_id'];
	// 		$save[$_POST['type']] = $_POST['price'];
	// 		$save['date']         = $_POST['date'];
	// 		if ($this->model->Save('property_inventory',$save)) {
	// 			$saved = 1;
	// 		}
	// 	}

	// 	if ($response=='yes') {
	// 		if ($saved==1) {
	// 			echo '<span class="text-success">Saved.</span>';
	// 		}
	// 		else{
	// 			echo '<span class="text-danger">Not Saved!</span>';
	// 		}
	// 	}
		
	// }

}
