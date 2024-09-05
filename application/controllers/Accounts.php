<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Accounts extends Main {

	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
		$data['user'] = $user = $this->checkLogin();
		if ($user->type=='host') {
			 $this->checkPlan(@$_COOKIE['property_id']);
		}
    }
	public function index()
	{
		$data['pAssets'] = ['daterangepicker','chart'];
		$data["user"]    = $user = $this->checkLogin();
		$data["title"]   = 'Account Dashboard';
		$data["contant"] = 'dashboard';
		
		$data['page_content_url'] = base_url().'account_dashboard';
		$this->template($data);
	}

	public function dashboard_content()
	{
		$data["user"]    	= $user = $this->checkLogin();
		$data["title"]   	= 'Account Dashboard';
		$data["contant"] 	= 'accounts/account_dashboard_content';
		load_view($data["contant"],$data);
	}


	// public function chart()
	// {
	// 	$data["user"]    	= $user = $this->checkLogin();
	// 	if (@$_POST['daterange'] && @$user) {
	// 		$date = explode(',', $_POST['daterange']);
	// 		$_POST['from'] 	= trim($date[0]);
	// 		$_POST['to'] 	= trim($date[1]);
	// 	}
	// 	else{
	// 		echo "<center><h3 class='text-danger mt-2'> Some error occurred in fetching account Details </h3></center>";
	// 		die();
	// 	}
		
	// 	$data["contant"] 	= 'accounts/chart';
	// 	$totalIncome 		= $totalExpense = $totalBookings = 0;
	// 	$dateArray 			= $incomeArray = $expenseArray = $bcountsArray = array();
	// 	// echo prx($_POST);

	// 	$between_dates = $this->between_dates($_POST['from'],$_POST['to']);
	// 	$between_dates[] = $_POST['to'];

	// 	// echo prx($between_dates);
		

	// 	$earnings = $flat_ids = $propmaster_ids = array();
		
	// 	$host_propmaster = $this->model->host_propmaster();
	// 	foreach ($host_propmaster as $propmaster) {
	// 		$propmaster_ids[] = $propmaster->id;
	// 		if($flats = $this->properties_by_propmaster($propmaster->id)){
	// 			foreach ($flats as $flat) {
	// 				$flat_ids[] = $flat->flat_id;
	// 			}
	// 		}
	// 	}
	// 	foreach ($between_dates as $date) {
	// 		$tmprow = $this->model->expenses($date,$propmaster_ids);

	// 		if (@$tmprow->totalAmount) {
	// 			$expenseArray[] = $tmprow->totalAmount;
	// 		}
	// 		else{
	// 			$expenseArray[] = 0;
	// 		}
	// 	}
	// 	$flat_ids 	=  implode(',', $flat_ids); 

	// 	foreach ($between_dates as $date) {
	// 		$date 		= "'".$date."'";
	// 		$query 		= " SELECT booking_new.* FROM booking_new 
	// 					WHERE flat_id IN ( $flat_ids ) 
	// 						AND end_date = $date
	// 						AND payment_status = 2
	// 						AND (status = 2 OR status = 5)";


	// 		$query =   "SELECT Count(*) AS count, $date as date , c.sum 
	// 					FROM   booking_new 
	// 				CROSS JOIN ( 
	// 					SELECT  SUM(price) as sum
	// 					FROM booking_new 
	// 					WHERE end_date = $date 
	// 					) as c
	// 				WHERE flat_id IN ( $flat_ids )
	// 					AND end_date = $date 
	// 					AND payment_status = 2
	// 					AND (status = 2 OR status = 5)";

	// 		$rows[] = $this->db->query($query)->row();
	// 	}

	// 	foreach ($rows as $value) {
	// 		$dateArray[] 		= $value->date;
	// 		$incomeArray[]   	= $income = (@$value->sum) ? $value->sum : 0 ;
	// 		$totalIncome   		+= $income;
	// 		$bcountsArray[]    	= $count = $value->count;
	// 		$totalBookings      += $count;
	// 	}

	// 	// all_bookings &  all_expense
	// 	$fdate = "'".$_POST['from']."'";
	// 	$tdate = "'".$_POST['to']."'";
	// 	$query 		= " SELECT booking_new.* FROM booking_new 
	// 					WHERE flat_id IN ( $flat_ids ) 
	// 						AND end_date BETWEEN $fdate AND $tdate
	// 						AND payment_status = 2
	// 						AND (status = 2 OR status = 5)
	// 					order by start_date desc ";

	// 	$data['all_bookings'] = $this->db->query($query)->result();


	// 	$propmaster_ids 	=  implode(',', $propmaster_ids); 
	// 	$query 		= " SELECT expense_data.* FROM expense_data 
	// 					WHERE prop_master_id IN ( $propmaster_ids ) 
	// 						AND date BETWEEN $fdate AND $tdate
							
	// 					order by date desc ";

	// 	$data['all_expense'] = $this->db->query($query)->result();
	// 	// all_bookings &  all_expense
		


	// 	$data['label'] 			= $dateArray;
	// 	$data['incomeArray'] 	= $incomeArray;
	// 	$data['expenseArray'] 	= $expenseArray;
	// 	$data['bcountsArray'] 	= $bcountsArray;
	// 	$data['totalIncome'] 	= $totalIncome;
	// 	$data['totalExpense'] 	= array_sum($expenseArray);
	// 	$data['totalBookings'] 	= $totalBookings;

	// 	// echo prx($dateArray);
	// 	// // echo prx($host_propmaster);
	// 	// echo prx($ddateArray);
	// 	// echo prx($earningsArray);
	// 	// echo prx($rows);
	// 	// echo prx($data);
	// 	// die();

	// 	load_view($data["contant"],$data);
	// }

	public function chart()
	{
		$data["user"] = $user = $this->checkLogin();
		if (@$_POST['daterange'] && @$user) {
			$date = explode(',', $_POST['daterange']);
			$_POST['from'] = trim($date[0]);
			$_POST['to'] = trim($date[1]);
		} else {
			echo "<center><h3 class='text-danger mt-2'> Some error occurred in fetching account Details </h3></center>";
			die();
		}
	
		$data["contant"] = 'accounts/chart';
		$totalIncome = $totalExpense = $totalBookings = 0;
		$dateArray = $incomeArray = $expenseArray = $bcountsArray = array();
	
		$between_dates = $this->between_dates($_POST['from'], $_POST['to']);
		$between_dates[] = $_POST['to'];
	
		$earnings = $flat_ids = $propmaster_ids = array();
		
		$host_propmaster = $this->model->host_propmaster();
		foreach ($host_propmaster as $propmaster) {
			$propmaster_ids[] = $propmaster->id;
			if($flats = $this->properties_by_propmaster($propmaster->id)){
				foreach ($flats as $flat) {
					$flat_ids[] = $flat->flat_id;
				}
			}
		}
		$propmaster_ids = @$_COOKIE['property_id'];
	
		foreach ($between_dates as $date) {
			$tmprow = $this->model->expenses_new($date, $propmaster_ids);
	
			if (@$tmprow->totalAmount) {
				$expenseArray[] = $tmprow->totalAmount;
			} else {
				$expenseArray[] = 0;
			}
		}
		$flat_ids 	=  implode(',', $flat_ids);	
		$rows = array();
		foreach ($between_dates as $date) {
			$date = "'" . $date . "'";
			$query = "
				SELECT COUNT(*) AS count, $date as date, 
					   COALESCE(SUM(transaction.credit), 0) as sum 
				FROM booking_new 
				LEFT JOIN transaction ON booking_new.id = transaction.booking_id
				WHERE property_id IN ($propmaster_ids)
				  AND (
					  (start_date <= $date AND end_date >= $date) OR 
					  (start_date <= $date AND end_date >= $date)
				  )
				  AND (booking_new.status = 2 OR booking_new.status = 5)";
	
			$rows[] = $this->db->query($query)->row();
		}
	
		foreach ($rows as $value) {
			$dateArray[] = $value->date;
			$incomeArray[] = $income = (@$value->sum) ? $value->sum : 0;
			$totalIncome += $income;
			$bcountsArray[] = $count = $value->count;
			$totalBookings += $count;
		}
	
		$fdate = "'" . $_POST['from'] . "'";
		$tdate = "'" . $_POST['to'] . "'";
		$query = "
			SELECT booking_new.*, COALESCE(SUM(transaction.credit), 0) as total_credit 
			FROM booking_new 
			LEFT JOIN transaction ON booking_new.id = transaction.booking_id
			WHERE property_id IN ($propmaster_ids) 
			  AND (
				  (start_date BETWEEN $fdate AND $tdate) OR 
				  (end_date BETWEEN $fdate AND $tdate)
			  )
			  AND (booking_new.status = 2 OR booking_new.status = 5)
			GROUP BY booking_new.id
			ORDER BY start_date DESC";
	
		$data['all_bookings'] = $this->db->query($query)->result();
	
		$query = "
			SELECT expense_data.* 
			FROM expense_data 
			WHERE prop_master_id IN ($propmaster_ids) 
			  AND date BETWEEN $fdate AND $tdate
			ORDER BY date DESC";
	
		$data['all_expense'] = $this->db->query($query)->result();
	
		$data['label'] = $dateArray;
		$data['incomeArray'] = $incomeArray;
		$data['expenseArray'] = $expenseArray;
		$data['bcountsArray'] = $bcountsArray;
		$data['totalIncome'] = $totalIncome;
		$data['totalExpense'] = array_sum($expenseArray);
		$data['totalBookings'] = $totalBookings;
	
		load_view($data["contant"], $data);
	}
	


	public function admin_profile($action=null,$id=null)
	{
		$data['user']    = $user = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Profile';
				$data['contant']    = 'accounts/profile/index';
				$data['new_url']    = base_url().'admin_profile/create';
				$proid = @$_COOKIE['property_id'];
				$data['packages'] = $packages = $this->model->get_user_package($proid,$user->id);
				$data['user_packages_master'] = $this->model->getData('user_packages_master',['id !='=>@$packages->package_id,'active'=>1, 'is_deleted'=>'NOT_DELETED']);
				$this->template($data);
				break;

			case 'create':
				$data['contant']        = 'accounts/profile/create';
				$data['action_url'] 	= base_url().'admin_profile/save';

					
				
				// $this->template($data);
				load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($this->encryption->decrypt(@$user->password) == $_POST['old_password']) {
						
						$data = array(
							'password'=>$this->encryption->encrypt($_POST['password']),
						);
						
							if($_POST['type']=='admin'){
							if($this->model->Update('tb_admin',$data,['id'=>$user->id])){
								logs($user->id,$user->id,'EDIT','Change Password Admin');
								$return['res'] = 'success';
								$return['msg'] = 'Saved.';
							}
						 }elseif($_POST['type']=='host'){
							if($this->model->Update('usermaster',$data,['id'=>$user->id])){
								logs($user->id,$user->id,'EDIT','Change Password Host');
								$return['res'] = 'success';
								$return['msg'] = 'Saved.';
							}
						}
					}
					else{
						$return['res'] = 'error';
						$return['msg'] = 'Old password not match.';
					}				
				}
				echo json_encode($return);
				break;				
				case 'update':
				
					$id = $user->id;
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!';
					if ($this->input->server('REQUEST_METHOD')=='POST') {
							if (!empty($_FILES['photo']['name'])) {
								//upload images
							
								$_FILES['photos']['name'] = $_FILES['photo']['name'];
								$_FILES['photos']['type'] = $_FILES['photo']['type'];
								$_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
								$_FILES['photos']['size'] = $_FILES['photo']['size'];
								$_FILES['photos']['error'] = $_FILES['photo']['error'];
								$config['file_name'] = rand(10000, 10000000000);
								$config['upload_path'] = UPLOAD_PATH.'users/';
								$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp';
								$config['allowed_types'] 		= '*';
								$config['remove_spaces']        = TRUE;
								$config['encrypt_name']         = TRUE;
								$config['max_filename']         = 20;
								$config['max_size']    			= '100';
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								if ($this->upload->do_upload('photos')) {
									$image_data = $this->upload->data();
									$fileName = "users/" . $image_data['file_name'];
									$_POST['photo'] = $fileName;
									if (@$_POST) {
										if($this->model->Update('tb_admin',$_POST,['id'=>$id])){
											logs($user->id,$id,'EDIT','Edit Admin Profile Image');
											$return['res'] = 'success';
											$return['msg'] = 'Saved.';
										}	
									}
								}
								else{
									$error = $this->upload->display_errors();
								   $return['res'] = 'error';
								   $return['msg'] = $error;
								   die();
								}
							 
							} else{
								if (@$_POST) {
									if($this->model->Update('tb_admin',$_POST,['id'=>$id])){
										logs($user->id,$id,'EDIT','Edit Admin Profile');
										$return['res'] = 'success';
										$return['msg'] = 'Saved.';
									}	
								}
							}
							
						
					}
					echo json_encode($return);
			break;
			case 'host_update':
				
				$id = $user->id;
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
                         $rs=  $this->model->getRow('usermaster',['id'=>$user->id]);
						$config['file_name'] = rand(10000, 10000000000);
						$config['upload_path'] = UPLOAD_PATH.'users/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp';
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
			
						if (!empty($_FILES['photo']['name'])) {
							//upload images
							$_FILES['photos']['name'] = $_FILES['photo']['name'];
							$_FILES['photos']['type'] = $_FILES['photo']['type'];
							$_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
							$_FILES['photos']['size'] = $_FILES['photo']['size'];
							$_FILES['photos']['error'] = $_FILES['photo']['error'];
			
							if ($this->upload->do_upload('photos')) {
								$image_data = $this->upload->data();
								$fileName = "users/" . $image_data['file_name'];
								$photo =  $_POST['photo'] = $fileName;
							}
						    
						} 
						if(!empty($photo))
						{
							$pic = $photo;
						}else
						{
                          $pic = $rs->pic;
						}
						if (!empty($_FILES['aadhaar_front']['name'])) {
							//upload images
							$_FILES['aadhaar_fronts']['name'] = $_FILES['aadhaar_front']['name'];
							$_FILES['aadhaar_fronts']['type'] = $_FILES['aadhaar_front']['type'];
							$_FILES['aadhaar_fronts']['tmp_name'] = $_FILES['aadhaar_front']['tmp_name'];
							$_FILES['aadhaar_fronts']['size'] = $_FILES['aadhaar_front']['size'];
							$_FILES['aadhaar_fronts']['error'] = $_FILES['aadhaar_front']['error'];
			
							if ($this->upload->do_upload('aadhaar_fronts')) {
								$image_data = $this->upload->data();
								$fileName = "users/" . $image_data['file_name'];
							}
						     $aadhaar_front =  $_POST['aadhaar_front'] = $fileName;
						} 
						if(!empty($aadhaar_front))
						{
							$aadhaarfront = $aadhaar_front;
						}else
						{
                          $aadhaarfront = $rs->aadhaar_front;
						}
						if (!empty($_FILES['aadhaar_back']['name'])) {
							//upload images
							$_FILES['aadhaar_backs']['name'] = $_FILES['aadhaar_back']['name'];
							$_FILES['aadhaar_backs']['type'] = $_FILES['aadhaar_back']['type'];
							$_FILES['aadhaar_backs']['tmp_name'] = $_FILES['aadhaar_back']['tmp_name'];
							$_FILES['aadhaar_backs']['size'] = $_FILES['aadhaar_back']['size'];
							$_FILES['aadhaar_backs']['error'] = $_FILES['aadhaar_back']['error'];
			
							if ($this->upload->do_upload('aadhaar_backs')) {
								$image_data = $this->upload->data();
								$fileName = "users/" . $image_data['file_name'];
							}
						     $aadhaar_back =  $_POST['aadhaar_back'] = $fileName;
						} 
						if(!empty($aadhaar_back))
						{
							$aadhaarback = $aadhaar_back;
						}else
						{
                          $aadhaarback = $rs->aadhaar_back;
						}
                      $dataupdate = array(
                         'pic' =>$pic,
						 'aadhaar_front' =>$aadhaarfront,
						 'aadhaar_back' =>$aadhaarback,
						 'name'   =>$this->input->post('name'),
						 'mobile'   =>$this->input->post('mobile'),
						 'email'   =>$this->input->post('email'),
						 'username'   =>$this->input->post('username'),
					  );

						if (@$dataupdate) {
							if($this->model->Update('usermaster',$dataupdate,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Host Profile ');
								$return['res'] = 'success';
								$return['msg'] = 'Saved.';
							}	
						}
					
				}
				echo json_encode($return);
				break;
			default:
				# code...
				break;
		}
	}


	public function my_plans($action=null,$id=null)
	{
		$data['user']    = $user = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'My Plan';
				$data['contant']    = 'accounts/plan/index';
				$proid = @$_COOKIE['property_id'];
				$data['packages'] = $packages = $this->model->get_user_package($proid,$user->id);
				$data['user_packages_master'] = $this->model->getDataPackage($proid,$user->id);
				$this->template($data);
				break;
				default:
				# code...
				break;
		}
	}

}
