<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
require_once(APPPATH . 'third_party/razorpay-php-2.9.0/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
require_once(APPPATH . 'third_party/tcpdf/TCPDF/tcpdf.php');
class Login extends Main {

	public function index($type='host',$flag='')
	{
		if ($this->input->server('REQUEST_METHOD')=='POST') {

			if (!$_POST['username'] or !$_POST['password']) {
				$return['res'] = 'error';
				$return['msg'] = 'Please Enter Username & Password !';
				echo json_encode($return); die();
			}
			
			$check['username'] = $_POST['username'];
			$type = $_POST['type'];
			$user_password = '';
			if (@$_POST['type']=='admin') {
				$user = $this->model->getRow('tb_admin',$check);
				$user_password =  $this->encryption->decrypt(@$user->password);
			}
			elseif(@$_POST['type']=='host') {

				$user = $this->model->getRow('usermaster',$check);
				
				if ($user) {
				  $status = 	$user->status = $user->isactive;
				}
				//$_POST['password']; //= $this->encryption->encrypt($_POST['password']);
				$user_password = $this->encryption->decrypt(@$user->password);
             
			}
			else{
				$user = false;
			}
			//echo $status;die();

			if ($user) {
				
				if ($user->status==1) {
					
					if ($_POST['password']==$user_password) {
						// Admin Check
						if (@$_POST['type']=='admin') {
						logs($user->id,$user->id,'LOGIN','Admin Login');
						$user = array_encryption($user);
						$type = value_encryption($type,'encrypt');
						set_cookie('6050c764989e5',$user['id'],8000*24*30);
						set_cookie('6050c7712a12e',$user['username'],8000*24*30);
						set_cookie('gjs50c7815a42z',$type,8000*24*30);
						$return['res'] = 'success';
						$return['msg'] = 'Login Successful Please Wait Redirecting...';
						$return['redirect_url'] = base_url('dashboard');
                       //  End Admin
						}
						elseif(@$_POST['type']=='host') {
						
						
					// 	$rs = $this->model->check_package_valid($user->id);
                    // //    check package
				    //  // Your specific date in the format 'YYYY-MM-DD'
					// 	$myDate = $rs->start_date;

					// 	// Current date
					// 	$today = date('Y-m-d');

					// 	// Create DateTime objects for the specified date and today
					// 	$myDateTime = new DateTime($myDate);
					// 	$todayDateTime = new DateTime($today);

					// 	// Calculate the difference between the two dates
					// 	$interval = $myDateTime->diff($todayDateTime);

					// 	// Get the number of days as an integer
					// 	$daysDifference = $interval->days;

					// 	// Output the result
					// 	 $daysDifference ;
					// 	 $mydays = $rs->no_of_days;
					// 	 if($daysDifference <= $mydays)
					// 	 {
					    if($user->isactive==1)
						{
						logs($user->id,$user->id,'LOGIN','Host Login');
						$rsr = $this->model->get_prop_id($user->id);
						if(!empty($rsr->propmasterid)):
						set_cookie('property_id', @$rsr->propmasterid, 365);
						endif;
						$user = array_encryption($user);
						$type = value_encryption($type,'encrypt');
						set_cookie('6050c764989e5',$user['id'],8000*24*30);
						set_cookie('6050c7712a12e',$user['username'],8000*24*30);
						set_cookie('gjs50c7815a42z',$type,8000*24*30);
						// echo "hello";die();
						$return['res'] = 'success';
						$return['msg'] = 'Login Successful Please Wait Redirecting...';
						$return['redirect_url'] = base_url('dashboard');
						
						}else
						{
							$return['res'] = 'error';
							$return['msg'] = 'Sorry your account is under verification / deactivate.';
						}
					// }else
				    //   {
                    //     $return['res'] = 'error';
					// 	$return['msg'] = 'Sorry your package has been expired.';
					//  }
					}
                      
					
					
					}
					else {
						$return['res'] = 'error';
						$return['msg'] = 'Incorrect Password';
					}
				}
				else {
					$return['res'] = 'error';
					$return['msg'] = 'Sorry your account is under verification / deactivate.';
				}
			}
			else {
				$return['res'] = 'error';
				$return['msg'] = 'User Not Found!';
			}
			echo json_encode($return);

		}
		else{
			if (get_cookie('6050c764989e5') && get_cookie('6050c7712a12e') && get_cookie('gjs50c7815a42z')) {
			$data['user'] = $user  = $this->checkLogin();
			if(!empty(@$user))
			{
				redirect(base_url('dashboard'));
			}
		   }
			$admin_logo = $this->model->getRow('tb_admin',['id'=>'1']);
			if(!empty($admin_logo))
			{
				$data['admin_logo'] = IMGS_URL.$admin_logo->photo;
				
			}else
			{
		    $data['admin_logo'] = base_url() . 'assets/photo/noimage/logo2.png';
			}
			$data['flag'] = $flag;
			$data['remote']     = base_url().'login_remote/user/';
			$data['type1'] 		 = $this->model->getData('property_types',['active'=>1],'asc','name');
			$data['countries'] = $this->model->getData('countries',0,'asc','name');
			$data['document_type'] = $this->model->getData('property_doc_type',['active'=>1]);
			$data['ownership_type'] = $this->model->getData('ownership_type',['active'=>1, 'is_deleted'=>'NOT_DELETED']);
			$data['user_packages_master'] = $this->model->getData('user_packages_master',['active'=>1, 'is_deleted'=>'NOT_DELETED'],'asc','seq');
			$data['title'] 	= 'Login';
			$data['type']=$type;
			load_view('login',$data);
		}
	}
	// public function index($type='host')
	// {
	// 	if ($this->input->server('REQUEST_METHOD')=='POST') {

	// 		if (!$_POST['username'] or !$_POST['password']) {
	// 			$return['res'] = 'error';
	// 			$return['msg'] = 'Please Enter Username & Password !';
	// 			echo json_encode($return); die();
	// 		}
			
	// 		$check['username'] = $_POST['username'];
	// 		$type = $_POST['type'];
	// 		$user_password = '';
	// 		if (@$_POST['type']=='admin') {
	// 			$user = $this->model->getRow('tb_admin',$check);
	// 			$user_password = $user->password;
	// 		}
	// 		elseif(@$_POST['type']=='host') {

	// 			$user = $this->model->getRow('usermaster',$check);
				
	// 			if ($user) {
	// 				$user->status = $user->isactive;
	// 			}
	// 			//$_POST['password']; //= $this->encryption->encrypt($_POST['password']);
	// 			$user_password = $this->encryption->decrypt($user->password);
             
	// 		}
	// 		else{
	// 			$user = false;
	// 		}

	// 		if ($user) {
	// 			if ($user->status==1) {
					
	// 				if ($_POST['password']==$user_password) {
                       
	// 					$user = array_encryption($user);
	// 					$type = value_encryption($type,'encrypt');
	// 					set_cookie('6050c764989e5',$user['id'],8000*24*30);
	// 					set_cookie('6050c7712a12e',$user['username'],8000*24*30);
	// 					set_cookie('gjs50c7815a42z',$type,8000*24*30);
	// 					$return['res'] = 'success';
	// 					$return['msg'] = 'Login Successful Please Wait Redirecting...';
	// 					$return['redirect_url'] = base_url();
				
	// 				}
	// 				else {
	// 					$return['res'] = 'error';
	// 					$return['msg'] = 'Incorrect Password';
	// 				}
	// 			}
	// 			else {
	// 				$return['res'] = 'error';
	// 				$return['msg'] = 'Account Temporarily Disabled!';
	// 			}
	// 		}
	// 		else {
	// 			$return['res'] = 'error';
	// 			$return['msg'] = 'User Not Found!';
	// 		}
	// 		echo json_encode($return);

	// 	}
	// 	else{
	// 		$data['remote']     = base_url().'login_remote/user/';
	// 		$data['type1'] 		 = $this->model->getData('property_types',['active'=>1],'asc','name');
	// 		$data['countries'] = $this->model->getData('countries',0,'asc','name');
	// 		$data['document_type'] = $this->model->getData('property_doc_type',['active'=>1]);
	// 		$data['ownership_type'] = $this->model->getData('ownership_type',['active'=>1, 'is_deleted'=>'NOT_DELETED']);
	// 		$data['user_packages_master'] = $this->model->getData('user_packages_master',['active'=>1, 'is_deleted'=>'NOT_DELETED']);
	// 		$data['title'] 	= 'Login';
	// 		$data['type']	=	$type;
	// 		load_view('login',$data);
	// 	}
	// }

	public function logout()
	{
		$type = value_encryption(get_cookie('gjs50c7815a42z'),'decrypt');
		$user_id = value_encryption(get_cookie('6050c764989e5'),'decrypt');
		if ($type == 'host') {
			delete_cookie('6050c764989e5');	
			delete_cookie('6050c7712a12e');	
			delete_cookie('gjs50c7815a42z');
			logs($user_id,$user_id,'LOGOUT','Host Logout');	
			redirect(base_url('login'));
		}else{
			delete_cookie('6050c764989e5');	
			delete_cookie('6050c7712a12e');	
			delete_cookie('gjs50c7815a42z');
			logs($user_id,$user_id,'LOGOUT','Admin Logout');	
			redirect(base_url('admin-login'));
		}
		
	}
	  public function login_remote($type,$id=null,$column='username')
    {
		//echo $_GET[$column];
        if ($type=='user') {
            $tb = 'usermaster';
        }
        else{

        }
        $this->db->where([$column=>$_GET[$column],'is_completed'=>'1']);
        if($id!=NULL){
            $this->db->where('id != ',$id);
        }
        $count=$this->db->count_all_results($tb);
        if($count>0)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }        
    }

	public function logout_admin()
	{
		$user_id = value_encryption(get_cookie('6050c764989e5'),'decrypt');
		delete_cookie('6050c764989e5');	
		delete_cookie('6050c7712a12e');	
		delete_cookie('gjs50c7815a42z');
		logs($user_id,$user_id,'LOGOUT','Admin Logout');		
		redirect(base_url('admin-login'));
	}

	public function new_account($action=null,$p1=null)
	{
		//$data['user'] = $user = $this->checkLogin();	
		switch($action)
		{
			case 'checkmobile':
				$mobile=$_POST['mob'];
				$mobile_check = $this->model->mobile_check($_POST['mob']);
					if($mobile_check ==0)
					{
				$this->db->delete('usermaster_otp', array('mobile' => $mobile));
				if(isset($_POST['mob']) && $_POST['mob']!==''){
						$otp=mt_rand(100000, 999999);
						$data =array(
							  'otp'=>$otp,
							  'mobile'=>$_POST['mob'],
						);
		
						if($this->model->updateRow($mobile,$data))
						{
							//code to send the otp to the mobile number will be placed here
							if(TRUE)
							{
								$return = 'Otp Send Your Mobile Number';
								$msg=$otp.' is your login OTP. Treat this as confidential. Techfi Zone will never call you to verify your OTP. Techfi Zone Pvt Ltd.';
		                    	send_sms($mobile, $msg);
							}
							else
							{
								$return = "Message could not be sent.";	
							}
						}
						else
						{
								$return= "Otp could not be generated.";	
						}
				}	
				else
				{
					$return=  "Mobile number not received.";
				}
			
		       }
		          else
				{
					$return =  "Mobile Already Exist";
				}

			
				echo ($return);
				return TRUE;
			
			break;	
			case 'checkotp':
				$otp=$_POST['otp'];
				if(isset($_POST['otp']) && $_POST['otp']!==''){
					
					  $check_existing_otp = $this->model->otp_exist($_POST['otp']); 
					  if($check_existing_otp)
					  {
						$return= "OTP Correct";
					  }else{
						$return= "Not Valid OTP";
					  }
		
				}else
				{
					$return =  "Mobile number not received.";
				}
				echo ($return);
				return TRUE;
			break;	

			case 'set_location':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if(isset($_POST['password']) == isset($_POST['cpassword']))
				{
				if ($this->input->server('REQUEST_METHOD')=='POST') {
				
						$data = array(
					   'longitude'     => $this->input->post('longitude'),
					   'latitude'     => $this->input->post('latitude'),
					   'contact_number'     => $this->input->post('mobile'),
					   'user_role'=>9,
					   );
							if($this->model->Save('vendors',$data)){
							$saved = 1;
						}
						}
					}else
					{
						$return['res'] = 'error';
						$return['msg'] = 'Password and Comfirm Password does not matched.';
					}
					
					if ($saved == 1 ) {
						$return['res'] = 'success';
						$return['msg'] = 'Your location set Successfully.';
						$return['contact1']=$this->input->post('mobile');
					}
					echo json_encode($return);
					return TRUE;
		    break;		
			case 'new_account_step':			
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
			
				if ($_POST['password'] == $_POST['cpassword']) {
					if ($this->input->server('REQUEST_METHOD') == 'POST') {
						$mobile = $this->input->post('mobile');
						$rs = $this->model->getRow('usermaster', ['mobile' => $mobile]);
			
						// Function to handle file upload
						function uploadFile($fieldName, $config, $rsField = null) {
							$CI =& get_instance();
							$CI->load->library('upload', $config);
							$CI->upload->initialize($config);
			
							if (!empty($_FILES[$fieldName]['name'])) {
								if ($CI->upload->do_upload($fieldName)) {
									$image_data = $CI->upload->data();
									return "users/" . $image_data['file_name'];
								}
							}
							return $rsField;
						}
			
						$config = [
							'upload_path' => UPLOAD_PATH . 'users/',
							'allowed_types' => 'jpg|jpeg|png|gif|webp',
							'file_name' => rand(10000, 10000000000)
						];
			
						$pic = uploadFile('pic', $config, @$rs->pic);
						$pic1 = uploadFile('pic1', $config, @$rs->aadhaar_front);
						$pic2 = uploadFile('pic2', $config, @$rs->aadhaar_back);
			
						$email = $this->input->post('email_verification');
						$emailaddress = !empty($email) ? $email : $this->input->post('email');
						$mail = !empty($email) ? 1 : 0;
			
						$data = [
							'name' => $this->input->post('name'),
							'username' => $this->input->post('username'),
							'password' => $this->encryption->encrypt($this->input->post('password')),
							'pic' => $pic,
							'email' => $emailaddress,
							'aadhaar_no' => @$this->input->post('aadhaar'),
							'isactive' => 0,
							'mobile' => $this->input->post('mobile'),
						];
			
						if ($pic1 != '') {
							$data['aadhaar_front'] = $pic1;
						}
			
						if ($pic2 != '') {
							$data['aadhaar_back'] = $pic2;
						}
			
						$countuser = $this->model->Counter('usermaster', ['mobile' => $this->input->post('mobile')]);
						if ($countuser == 0) {
							if ($saveid = $this->model->Save('usermaster', $data)) {
								$data1 = [
									'usermaster_id' => $saveid,
									'mobile_verified' => 1,
									'email_verified' => $mail,
								];
								$this->model->Save('usermaster_extended', $data1);
								$saved = 1;
							}
						} else {
							$rs = $this->model->get_usermaster_id($this->input->post('mobile'));
							if ($saveid = $this->model->Update('usermaster', $data, ['id' => $rs->id])) {
								$data1 = [
									'usermaster_id' => $rs->id,
									'mobile_verified' => 1,
									'email_verified' => $mail,
								];
								$this->model->Update('usermaster_extended', $data1, ['usermaster_id' => $rs->id]);
								$saved = 1;
							}
						}
					}
				} else {
					$return['res'] = 'error';
					$return['msg'] = 'Password and Confirm Password do not match.';
				}
			
				if ($saved == 1) {
					$return['res'] = 'success';
					$return['msg'] = 'Basic details added successfully. Now proceed to the next step.';
				}
			
				echo json_encode($return);
				break;
			
		// 	case 'new_account_step':			
		// 		$return['res'] = 'error';
		// 		$return['msg'] = 'Not Saved!';
		// 		$saved = 0;
		// 		// print_r($_FILES['pic']['name']);die();
		// 		if($_POST['password'] == $_POST['cpassword'])
		// 		{
		// 		if ($this->input->server('REQUEST_METHOD')=='POST') {
		// 			$mobile = $this->input->post('mobile');
		// 			$rs = $this->model->getRow('usermaster',['mobile'=>$mobile]);
		// 			$config['file_name'] = rand(10000, 10000000000);
		// 			$config['upload_path'] = UPLOAD_PATH.'users/';
		// 			$config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
		// 			$this->load->library('upload', $config);
		// 			$this->upload->initialize($config);
		
		// 			if (!empty($_FILES['pic']['name'])) {
		// 				//upload images
		// 				$_FILES['pics']['name'] = $_FILES['pic']['name'];
		// 				$_FILES['pics']['type'] = $_FILES['pic']['type'];
		// 				$_FILES['pics']['tmp_name'] = $_FILES['pic']['tmp_name'];
		// 				$_FILES['pics']['size'] = $_FILES['pic']['size'];
		// 				$_FILES['pics']['error'] = $_FILES['pic']['error'];
		
		// 				if ($this->upload->do_upload('pics')) {
		// 					$image_data = $this->upload->data();
		// 					$fileName = "users/" . $image_data['file_name'];
		// 				}
		// 			 $pic = $data['pic'] = @$fileName;
		// 			} 
		// 			if(!empty($pic))
		// 			{
		// 				$pic = @$pic;
		// 			}else
		// 			{
		// 				$pic = @$rs->pic;
		// 			}
		// 			$config['file_name'] = rand(10000, 10000000000);
		// 			$config['upload_path'] = UPLOAD_PATH.'users/';
		// 			$config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
		// 			$this->load->library('upload', $config);
		// 			$this->upload->initialize($config);
		
		// 			if (!empty($_FILES['pic1']['name'])) {
		// 				//upload images
		// 				$_FILES['pic1s']['name'] = $_FILES['pic1']['name'];
		// 				$_FILES['pic1s']['type'] = $_FILES['pic1']['type'];
		// 				$_FILES['pic1s']['tmp_name'] = $_FILES['pic1']['tmp_name'];
		// 				$_FILES['pic1s']['size'] = $_FILES['pic1']['size'];
		// 				$_FILES['pic1s']['error'] = $_FILES['pic1']['error'];
		
		// 				if ($this->upload->do_upload('pic1s')) {
		// 					$image_data = $this->upload->data();
		// 					$fileName = "users/" . $image_data['file_name'];
		// 				}
		// 			 $pic1 = $data['pic1'] = @$fileName;
		// 			}
		// 			if(!empty($pic1))
		// 			{
		// 				$pic1 = $pic1;
		// 			}else
		// 			{
		// 				$pic1 = @$rs->aadhaar_front;
		// 			}

		// 			$config['file_name'] = rand(10000, 10000000000);
		// 			$config['upload_path'] = UPLOAD_PATH.'users/';
		// 			$config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
		// 			$this->load->library('upload', $config);
		// 			$this->upload->initialize($config);
		
		// 			if (!empty($_FILES['pic2']['name'])) {
		// 				//upload images
		// 				$_FILES['pic2s']['name'] = $_FILES['pic2']['name'];
		// 				$_FILES['pic2s']['type'] = $_FILES['pic2']['type'];
		// 				$_FILES['pic2s']['tmp_name'] = $_FILES['pic2']['tmp_name'];
		// 				$_FILES['pic2s']['size'] = $_FILES['pic2']['size'];
		// 				$_FILES['pic2s']['error'] = $_FILES['pic2']['error'];
		
		// 				if ($this->upload->do_upload('pic2s')) {
		// 					$image_data = $this->upload->data();
		// 					$fileName = "users/" . $image_data['file_name'];
		// 				}
		// 			   $pic2 =  $data['pic2'] = @$fileName;
		// 			} 
		// 			if(!empty($pic2))
		// 			{
		// 				$pic2 = $pic2;
		// 			}else
		// 			{
		// 				$pic2 = @$rs->aadhaar_back;
		// 			}
		// 			$email = $this->input->post('email_verification');
		// 			if(!empty($email))
		// 			{
		// 				$emailaddress = $email;
		// 				$mail = 1;
		// 			}else
		// 			{
		// 				$emailaddress =$this->input->post('email');
		// 				$mail = 0;
		// 			}
		// 			     $pass =  $this->input->post('password');
		// 				$aadhaar =  $this->input->post('aadhaar');
		// 				if($pic1 =='' && $pic2 !='' && $pic!=''){
		// 				$data = array(
		// 			   'name'     => $this->input->post('name'),
		// 			   'username'     => $this->input->post('username'),
		// 			   'password'     =>$this->encryption->encrypt($pass),
		// 			   //'aadhaar_front'     =>$pic1,
		// 			   'aadhaar_back'     =>$pic2,
		// 			   'pic'    =>$pic,
		// 			   'email'    =>$emailaddress,
		// 			   'aadhaar_no'  => @$aadhaar,
		// 			   'isactive'   =>0,
		// 			   'mobile'     =>$this->input->post('mobile'),
		// 			   );
		// 			}elseif($pic1 !='' && $pic2 =='' && $pic!='')
		// 			{
		// 				$data = array(
		// 					'name'     => $this->input->post('name'),
		// 					'username'     => $this->input->post('username'),
		// 					'password'     =>$this->encryption->encrypt($pass),
		// 					'aadhaar_front'     =>$pic1,
		// 					//'aadhaar_back'     =>$pic2,
		// 					'pic'    =>$pic,
		// 					'email'    =>$emailaddress,
		// 					'aadhaar_no'  => @$aadhaar,
		// 					'isactive'   =>0,
		// 					'mobile'     =>$this->input->post('mobile'),
		// 					);
		// 			}elseif($pic1 =='' && $pic2 =='' && $pic !='')
		// 			{
		// 				$data = array(
		// 					'name'     => $this->input->post('name'),
		// 					'username'     => $this->input->post('username'),
		// 					'password'     =>$this->encryption->encrypt($pass),
		// 					'aadhaar_front'     =>$pic1,
		// 					'aadhaar_back'     =>$pic2,
		// 					//'pic'    =>$pic,
		// 					'email'    =>$emailaddress,
		// 					'aadhaar_no'  => @$aadhaar,
		// 					'isactive'   =>0,
		// 					'mobile'     =>$this->input->post('mobile'),
		// 					);
		// 			}elseif($pic1 =='' && $pic2 =='' && $pic=='')
		// 			{
		// 				$data = array(
		// 					'name'     => $this->input->post('name'),
		// 					'username'     => $this->input->post('username'),
		// 					'password'     =>$this->encryption->encrypt($pass),
		// 					//'aadhaar_front'     =>$pic1,
		// 					//'aadhaar_back'     =>$pic2,
		// 					//'pic'    =>$pic,
		// 					'email'    =>$emailaddress,
		// 					'aadhaar_no'  => @$aadhaar,
		// 					'isactive'   =>0,
		// 					'mobile'     =>$this->input->post('mobile'),
		// 					);	
		// 			}else
		// 			{
		// 				$data = array(
		// 					'name'     => $this->input->post('name'),
		// 					'username'     => $this->input->post('username'),
		// 					'password'     =>$this->encryption->encrypt($pass),
		// 					'aadhaar_front'     =>$pic1,
		// 					'aadhaar_back'     =>$pic2,
		// 					'pic'    =>$pic,
		// 					'email'    =>$emailaddress,
		// 					'aadhaar_no'  => @$aadhaar,
		// 					'isactive'   =>0,
		// 					'mobile'     =>$this->input->post('mobile'),
		// 					);	
		// 			}
		// 			   $countuser = $this->model->Counter('usermaster', array( 'mobile'=> $this->input->post('mobile')));
		// 			   if($countuser==0){
		// 				if($saveid = $this->model->Save('usermaster',$data)){
		// 						$data1 = array(
		// 							'usermaster_id'    =>$saveid,
		// 							'mobile_verified'     => 1,
		// 							'email_verified'     => $mail,
		// 						);
		// 						$this->model->Save('usermaster_extended',$data1);
								
		// 					$saved = 1;
		// 				}
		// 			       }else
		// 				   {
		// 					$rs  = $this->model->get_usermaster_id($this->input->post('mobile'));
		// 					if($saveid = $this->model->Update('usermaster',$data,['id'=>$rs->id])){
		// 						$data1 = array(
		// 							'usermaster_id'    =>$rs->id,
		// 							'mobile_verified'     => 1,
		// 							'email_verified'     => $mail,
		// 						);
		// 						$this->model->Update('usermaster_extended',$data1,['usermaster_id'=>$rs->id]);
								
		// 					$saved = 1;
		// 				}
		// 				   }
		// 				}
		// 			}else
		// 			{
		// 				$return['res'] = 'error';
		// 				$return['msg'] = 'Password and Comfirm Password does not matched.';
		// 			}
					
		// 			if ($saved == 1 ) {
		// 				$return['res'] = 'success';
		// 				$return['msg'] = 'Basic details added successfully now proceed to next step.';
		// 			}
		// 			echo json_encode($return);
		// 			//return TRUE;
		//  break;	
		 case 'checkmail':
			$email=$_POST['email'];
			// $email_check = $this->model->email_check($_POST['email']);
			// 	if($email_check ==1)
			// 	{
			$this->db->delete('usermaster_email_otp', array('email' => $email));
			if(isset($_POST['email']) && $_POST['email']!==''){
					$otp=mt_rand(100000, 999999);
					$data =array(
						  'otp'=>$otp,
						  'email'=>$_POST['email'],
					);
					if($this->model->updateemailRow($email,$data))
					{
						//code to send the otp to the mobile number will be placed here
						if(TRUE)
						{
							$return = 'Otp Send Your Email Address';
							$message = "Email verification otp.".$otp;
							$email = $_POST['email'];
							$subject = "Email verification otp.";
							sendMail($message,$email,$subject);
						}
						else
						{
							$return = "Message could not be sent.";	
						}
					}
					else
					{
							$return= "Otp could not be generated.";	
					}
			}	
			else
			{
				$return=  "Email Address  not received.";
			}
		
		//    }
		// 	  else
		// 	{
		// 		$return =  "Failed";
		// 	}

		
			echo ($return);
			return TRUE;
			break;	
			case 'checkmailotp':
				$otp=$_POST['email-otp'];
				if(isset($_POST['email-otp']) && $_POST['email-otp']!==''){
					
					  $check_existing_otp = $this->model->otp_mail_exist($_POST['email-otp']); 
					  $check_otp_row = $this->model->otp_mail_exist_row($_POST['email-otp']); 
					  if($check_existing_otp)
					  {
						$return['res'] = 'success';
					    $return['msg'] =  "Otp validate successfully.";
						$return['email'] = $check_otp_row->email;
					  }else{
					 	$return['res'] = 'error';
					    $return['msg'] =  "Invalid OTP.";
					  }
		
				}else
				{
					$return['res'] = 'error';
					$return['msg'] =  "Otp not received.";
				}
				echo json_encode($return);
				return TRUE;
			break;	
			case 'accout_step_3':	
					
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if(@$_POST['mobile'])
					{
						$mobile = $_POST['mobile'];
					}
					$rs  = $this->model->get_usermaster_id($mobile);
					$rs3 = $this->model->get_prop_id($rs->id);
					$doc = $this->model->getRow('propmaster',['id'=>@$rs3->propmasterid]);
					$config['file_name'] = rand(10000, 10000000000);
					$config['upload_path'] = UPLOAD_PATH.'property-document/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
		
					if (!empty($_FILES['document']['name'])) {
						//upload images
						$_FILES['documents']['name'] = $_FILES['document']['name'];
						$_FILES['documents']['type'] = $_FILES['document']['type'];
						$_FILES['documents']['tmp_name'] = $_FILES['document']['tmp_name'];
						$_FILES['documents']['size'] = $_FILES['document']['size'];
						$_FILES['documents']['error'] = $_FILES['document']['error'];
		
						if ($this->upload->do_upload('documents')) {
							$image_data = $this->upload->data();
							$fileName = "property-document/" . $image_data['file_name'];
							$document = $fileName;
						}else{
							$document = 'property-document/default.jpg';
						}

					 
					} 
					if(!empty($document)){
						$document = @$document;
					}else
					{
						$document = @$doc->document;
					}
					$config['file_name'] = rand(10000, 10000000000);
					$config['upload_path'] = UPLOAD_PATH.'property-images/invoice-image/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
		
					if (!empty($_FILES['logo']['name'])) {
						//upload images
						$_FILES['logos']['name'] = $_FILES['logo']['name'];
						$_FILES['logos']['type'] = $_FILES['logo']['type'];
						$_FILES['logos']['tmp_name'] = $_FILES['logo']['tmp_name'];
						$_FILES['logos']['size'] = $_FILES['logo']['size'];
						$_FILES['logos']['error'] = $_FILES['logo']['error'];
		
						if ($this->upload->do_upload('logos')) {
							$image_data = $this->upload->data();
							$fileName = "property-images/invoice-image/" . $image_data['file_name'];
							$logos = $fileName;
						}else{
							$logos = 'property-images/invoice-image/default.jpg';
						}
					} 
					if(!empty($logos)){
						$logos = @$logos;
					}else
					{
						$logos = @$doc->logo;
					}
					//echo $_POST['old_gst_certificate'];die();
					if (@$_FILES['gst_certificate']['name']) {
						$upload = $this->_uploadFile('property-document','gst_certificate');
						$_POST['gst_certificate'] = $upload;	
						unset($_POST['old_gst_certificate']);					
					}else{
						if (@$_POST['old_gst_certificate']) {
							$_POST['gst_certificate'] = $_POST['old_gst_certificate'];							
						}		
						unset($_POST['old_gst_certificate']);				
					}
					if (@$_POST['is_gst'] == 'YES') {
						$prop_doc['gst_no'] = $_POST['gst_no'];
						$prop_doc['gst_certificate'] = $_POST['gst_certificate'];
					}	
					unset($_POST['gst_certificate']);
					$rto_code = 'FUNTC00001';//$district->rot_code.'0001';
					$last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('propmaster')->row();
					if (@$last_row->propcode) {
						$propcode = $last_row->propcode;
						$propcode++;
					}else{
						$propcode = $rto_code;
					}
					
					$_POST['propcode'] = $propcode;
					// print_r($propcode);
					// die;
					if($document ==''){
					$datas = array(
                         'propcode'    =>$propcode,
						 'propcodename'    =>$this->input->post('propcodename'),
						 'propname'    =>$this->input->post('propname'),
						 'address'    =>$this->input->post('address'),
						 'pincode'    =>$this->input->post('pincode'),
						 'contact_preson'    =>$this->input->post('contact_preson'),
						 'contact_preson_mobile'    =>$this->input->post('contact_preson_mobile'),
						 'property_type_id'    =>@$this->input->post('property_type_id'),
						 'country'    =>$this->input->post('country'),
						 'state'    =>$this->input->post('state'),
						 'city'    =>$this->input->post('city'),
						 'doc_type_id'    =>$this->input->post('doc_type_id'),
						 //'document'    =>$document,
						 'email' => $this->input->post('email_address'),
						 'is_gst'      =>$this->input->post('is_gst'),
						 'location_id'   =>$this->input->post('location_id'),
						 'checkintime'=>$this->input->post('checkintime'),
						 'checkinupto'=>$this->input->post('checkinupto'),
						 'checkouttime'=>$this->input->post('checkouttime'),
						 'checkoutupto'=>$this->input->post('checkoutupto'),
						 'company_name' =>$this->input->post('company_name'),
						'bill_format' =>$this->input->post('bill_no'),
						 'approval_status' =>'Approved', 
						 'logo' =>$logos, 
					);
				}else
				{
					$datas = array(
						'propcode'    =>$propcode,
						'propcodename'    =>$this->input->post('propcodename'),
						'propname'    =>$this->input->post('propname'),
						'address'    =>$this->input->post('address'),
						'pincode'    =>$this->input->post('pincode'),
						'contact_preson'    =>$this->input->post('contact_preson'),
						'contact_preson_mobile'    =>$this->input->post('contact_preson_mobile'),
						'property_type_id'    =>@$this->input->post('property_type_id'),
						'country'    =>$this->input->post('country'),
						'state'    =>$this->input->post('state'),
						'city'    =>$this->input->post('city'),
						'doc_type_id'    =>$this->input->post('doc_type_id'),
						'document'    =>$document,
						'logo' =>$logos,
						'email' => $this->input->post('email_address'),
						'is_gst'      =>$this->input->post('is_gst'),
						'location_id'   =>$this->input->post('location_id'),
						'checkintime'=>$this->input->post('checkintime'),
						'checkinupto'=>$this->input->post('checkinupto'),
						'checkouttime'=>$this->input->post('checkouttime'),
						'checkoutupto'=>$this->input->post('checkoutupto'),
						'company_name' =>$this->input->post('company_name'),
					   'bill_format' =>$this->input->post('bill_no'),
						'approval_status' =>'Approved', 
				   );
				}
					//$rs  = $this->model->get_usermaster_id($mobile);
					//echo $rs->id;die();
					$countuser = $this->model->Counter('propaccess', array( 'userid'=> $rs->id));
					if($countuser==0){
					if ($insert_id = $this->model->Save('propmaster',$datas)) {
						set_cookie('property_id', $insert_id, 365);
						if (!empty($rs->id)) {
							$propaccess['propmasterid'] 	= $insert_id;
							$propaccess['userid'] 			= $rs->id;
							$this->model->Save('propaccess',$propaccess);
						}
					
						$prop_doc['prop_m_id'] = $insert_id;							

						if ($this->model->Save('propmaster_document',$prop_doc)) {
							$saved=1;
						}
						$add = array(
							'country'    =>$this->input->post('country'),
							'state'    =>$this->input->post('state'),
							'city'    =>$this->input->post('city'),
						);
						if ($this->model->Update('usermaster_extended',$add,['usermaster_id'=>$rs->id])) {
							$saved=1;
						}
						
					}
				  }else
				  {     
					if ($this->model->Update('propmaster',$datas,['id'=>$rs3->propmasterid])) {
						
						$prop_doc['prop_m_id'] = $rs3->propmasterid;							
						set_cookie('property_id', $rs3->propmasterid, 365);
						if ($this->model->Update('propmaster_document',$prop_doc,['prop_m_id'=>$rs3->propmasterid])) {
							$saved=1;
						}
						$add = array(
							'country'    =>$this->input->post('country'),
							'state'    =>$this->input->post('state'),
							'city'    =>$this->input->post('city'),
						);
						if ($this->model->Update('usermaster_extended',$add,['usermaster_id'=>$rs->id])) {
							$saved=1;
						}
						
					}
				  }
				}
					
					if ($saved == 1 ) {
						$return['res'] = 'success';
						$return['msg'] = 'Basic details added successfully now fill next step.';
					}
					echo json_encode($return);
					return TRUE;
		 break;	
		 case 'accout_step_4':	
			$saved = 0;
			if ($this->input->server('REQUEST_METHOD')=='POST') {
				if(@$_POST['mobile'])
				{
					$mobile = $_POST['mobile'];
				}
				if(@$_POST['package_id'])
				{
					$package_id = $_POST['package_id'];
				}
				$name = $_POST['name'];
				
				$property_id = $this->input->cookie('property_id', TRUE);
				$currentDate = date('Y-m-d');
				     $rs  = $this->model->get_usermaster_id($mobile);
					 $user_id = $rs->id;
					 $rs2  = $this->model->get_package_id($package_id);
					 $gst_amount = ($rs2->price*$rs2->gst)/100;
					 $total =$rs2->price+$gst_amount;
					 $selected_room = $_POST['room'];
					 $additional_amount = 0;
					 if($name=='Custom Plan'){
					 if ($selected_room > $rs2->min_room-1) {
						 $additional_amount = ceil(($selected_room - $rs2->min_room-1) / 10) * 100;
					 }
					 $total += $additional_amount;
					 }

					 $currentDate = new DateTime(); // Assuming $currentDate is a DateTime object
                     $newDate = $currentDate->modify('+' . $rs2->duration_in_days . ' days')->format('Y-m-d');
				      $datas = array(
					 'property_id'    =>$property_id,
					 'package_id'    =>$package_id,
					 'user_id'    =>$rs->id,
					 'start_date'    =>date('Y-m-d'),
					 'price'       =>$rs2->price,
					'no_of_days'     =>$rs2->duration_in_days,
					'gst'     =>$rs2->gst,
					'gst_amount'     =>$gst_amount,
					'total'     =>$total,
					'min_room'     =>$rs2->min_room,
					'max_room'     =>$rs2->max_room,
					'selected_room'     =>$_POST['room'],
					'expiry_date'   =>$newDate,
					'additional_amount'=>$additional_amount

		   );
				if ($insert_id = $this->model->Save('user_assign_package',$datas)) {
					$orderIds = $insert_id;
					
					 $saved = 1;

					
				}
				if ($saved == 1 ) {
					$return = 'success';
				
					  //razorpay code
					  $date = strtotime("now");
					  $mon=date('M', $date);
					  //generate unique orderid 
					  $num_padded = sprintf("%05d", $insert_id);
					  $code="HO".strtoupper($mon).$num_padded;
					  $razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();

					  $payable_final_amt = $total;
                      
					  if( $payable_final_amt > 0 ):
						  // razorpay api 
						  $api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
						  $orderData = [
							  'receipt'         => $code,
							  'amount'          => $payable_final_amt*100, // 2000 rupees in paise
							  'currency'        => 'INR',
							  'payment_capture' => 1 // auto capture
						  ];
						  $razorpayOrder = $api->order->create($orderData);
						  // end razorpay api
						  
						  $response = json_encode(
							  array(
								  'secret_key'=>$razorpay_data->razorpay_key_id,
								  'order_id_razor' => $razorpayOrder['id'],
								  'total' => $payable_final_amt,
							  )
						  );
  
						  //get user details by userid
						 
						  $user_detail = $this->model->getRow('usermaster',['id'=>$user_id]);
						  $user_name = $user_detail->name;
						  $user_mobile = $user_detail->mobile;
						  $user_email = $user_detail->email;
						   $this->db->delete('usermaster_otp', array('mobile' => $user_mobile));
						  $this->db->delete('usermaster_email_otp', array('email' => $user_email));
						 
					 $this->db->where('user_id', $user_id)->update('user_assign_package',['status'=>'3','active'=>'0']);
						  echo json_encode(array('flag'=>'success','data'=>$response,'user_name'=>$user_name,'user_mobile'=>$user_mobile,'user_email'=>$user_email,'order_id'=>$orderIds, 'total'=>$payable_final_amt));
						 
					  else:
						  $data = [
							  'status'=> '2',    //success 
							  'active' => '1',
						  ];
						  $user_detail = $this->model->getRow('usermaster',['id'=>$user_id]);
						  $user_name = $user_detail->name;
						  $user_mobile = $user_detail->mobile;
						  $user_email = $user_detail->email;
						  $data2 = array(
							'isactive' =>'1',
							'is_completed' =>'1',
				           );
						   $this->db->where('user_id', $user_id)->update('user_assign_package',['active'=>'0']);
						   $this->model->Update('usermaster',$data2,['id'=>$user_id]);
						  $this->db->where('id', $insert_id)->update('user_assign_package', $data);
						   $this->db->delete('usermaster_otp', array('mobile' => $user_mobile));
						  $this->db->delete('usermaster_email_otp', array('email' => $user_email));
						  logs($user_id,$user_id,'Add','Add Account');
						  echo json_encode(array('flag'=>'notpaymentresponse'));
					  endif;
					
				}else
				{
					echo json_encode(array('flag'=>'error'));
				}
					}
				
				
				//echo ($return);
				return TRUE;
	 break;	
	 case 'verify_payment':

		$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();

		$razorpay_payment_id = $this->input->post('razorpay_payment_id');
		$razorpay_order_id = $this->input->post('razorpay_order_id');
		$razorpay_signature = $this->input->post('razorpay_signature');
		$order_idrazor = $this->input->post('order_idrazor');
		 $post = [
			'order_idrazor'=>$order_idrazor,
			'razorpay_order_id' => $razorpay_order_id,
			'razorpay_payment_id' => $razorpay_payment_id,
			'razorpay_signature' => $razorpay_signature,
		];
		$success = 'true';
		$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
		try{
			$api->utility->verifyPaymentSignature($post);
		}catch(SignatureVerificationError $e){
			$success = 'Razorpay Error : ' . $e->getMessage();
		}
		echo $success;
		break;
		case 'update_order_status':
		$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();
		$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
			$payment_gateway = $this->input->post('payment_gateway');
			$payment_id = $this->input->post('payment_id');
			$signature = $this->input->post('signature');
			$razorpay_ord_id = $this->input->post('razorpay_ord_id');
			$order_id = $this->input->post('order_id');
			$total = $this->input->post('total');
			$razorpayPayment=$api->order->fetch($razorpay_ord_id)->payments();
				if ($razorpayPayment && !empty($razorpayPayment->items)) {
		    // Access the bank name and payment method from the first payment item
			    $bank_name = $razorpayPayment->items[0]->bank;
			    $method = $razorpayPayment->items[0]->method;
			} else {
			    // No payment information found
			    $bank_name = "No payment information found";
			    $method = "No payment information found";
			}
			$datapayment = [
				'status'=> '2',
				'payment_method' => $method,
				'amount'=>$total,
				'razorpay_order_id' => $razorpay_ord_id,
			    'razorpay_signature' => $signature,
				'item_id'=>$order_id,
				'payment_gateway'=>$payment_gateway,
				'bank_name'=>$bank_name,
			];
            $this->db->insert('payemnttranscation',$datapayment);
			$data = [
				'status'=> '2',
				'active'=>'1',
			];
			
			//update inventory
			$rs = $this->model->getRow('user_assign_package',['id'=>$order_id]);
			 $data2 = array(
						'isactive' =>'1',
						'is_completed' =>'1',
			);
			$rs2 = $this->model->getRow('usermaster',['id'=>$rs->user_id]);
			logs($rs->user_id,$rs->user_id,'Add','Add Account');	
			$message1 ='Your registration has been successfully with My Hotel Reception & Your account will be activated with in 24 hours after documents verification.';
			$email  = $rs2->email;
			$subject = 'Account registration with  My Hotel Reception ';
			sendMail($message1,$email,$subject);
			$this->model->Update('usermaster',$data2,['id'=>$rs->user_id]);
			$this->db->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
			if($this->db->where_in('id',$order_id)->update('user_assign_package',$data))
			{
				
				
				echo "success";
			}
			else
			{
				echo "failed";
			}
			break;

		 case 'update_order_status_failed':
		$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();
		$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
		
			$payment_gateway = $this->input->post('payment_gateway');
			$payment_id = $this->input->post('payment_id');
			$signature = $this->input->post('signature');
			$razorpay_ord_id = $this->input->post('razorpay_ord_id');
			$order_id = $this->input->post('order_id');
			$total = $this->input->post('total');
			$razorpayPayment=$api->order->fetch($razorpay_ord_id)->payments();
				if ($razorpayPayment && !empty($razorpayPayment->items)) {
		    // Access the bank name and payment method from the first payment item
			    $bank_name = $razorpayPayment->items[0]->bank;
			    $method = $razorpayPayment->items[0]->method;
			} else {
			    // No payment information found
			    $bank_name = "No payment information found";
			    $method = "No payment information found";
			}
			
			$datapayment = [
				'status'=> '4',
				'payment_method' => $method,
				'amount'=>$total,
				'razorpay_order_id' => $razorpay_ord_id,
			    'razorpay_signature' => $signature,
				'item_id'=>$order_id,
				'payment_gateway'=>$payment_gateway,
				'bank_name'=>$bank_name,
			];

            $this->db->insert('payemnttranscation',$datapayment);
			$data = [
				'status'=> '4',
				'active'=>'0',
			];
			
			//update inventory
			$rs = $this->model->getRow('user_assign_package',['id'=>$order_id]);
		
			$this->db->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
			if($this->db->where_in('id',$order_id)->update('user_assign_package',$data))
			{
				
				
				echo "success";
			}
			else
			{
				echo "failed";
			}
			
	  break;	

	  case 'update_order_status_failure':
	$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();
		$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
			$payment_gateway = $this->input->post('payment_gateway');
			$payment_id = $this->input->post('payment_id');
			$signature = $this->input->post('signature');
			$razorpay_ord_id = $this->input->post('razorpay_ord_id');
			$order_id = $this->input->post('order_id');
			$total = $this->input->post('total');
			$razorpayPayment=$api->order->fetch($razorpay_ord_id)->payments();
				if ($razorpayPayment && !empty($razorpayPayment->items)) {
			    $bank_name = $razorpayPayment->items[0]->bank;
			    $method = $razorpayPayment->items[0]->method;
			} else {
			    // No payment information found
			    $bank_name = "No payment information found";
			    $method = "No payment information found";
			}
			
			$datapayment = [
				'status'=> '4',
				'payment_method' => $method,
				'amount'=>$total,
				'razorpay_order_id' => $razorpay_ord_id,
			    'razorpay_signature' => $signature,
				'item_id'=>$order_id,
				'payment_gateway'=>$payment_gateway,
				'bank_name'=>$bank_name,
			];

            $this->db->insert('payemnttranscation',$datapayment);
			$data = [
				'status'=> '4',
				'active'=>'0',
			];
			
			//update inventory
			$rs = $this->model->getRow('user_assign_package',['id'=>$order_id]);
			$this->db->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
			if($this->db->where_in('id',$order_id)->update('user_assign_package',$data))
			{
				
				
				echo "success";
			}
			else
			{
				echo "failed";
			}
	  break;
	  
	  case 'update_failed_payment':
		    $payment_gateway = $this->input->post('payment_gateway');
			$order_id = $this->input->post('order_id');
			$total = $this->input->post('total');
			$bank_name = "No payment information found";
			$method = "No payment information found";
			$datapayment = [
				'status'=> '3',
				'amount'=>$total,
				'item_id'=>$order_id,
				'payment_gateway'=>$payment_gateway,
				'bank_name'=>$bank_name,
				'payment_method'=>$method,
			];

		$this->db->insert('payemnttranscation',$datapayment);
		$data = [
			'status'=> '3',
			'active'=>'0',
		];
		
		//update inventory
		$rs = $this->model->getRow('user_assign_package',['id'=>$order_id]);
		$this->db->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
		if($this->db->where_in('id',$order_id)->update('user_assign_package',$data))
		{
			
			
			echo "success";
		}
		else
		{
			echo "failed";
		}
     break;		
	   default :break;		
		}
		
	}
   public	function submit_enquiry()
   {
	$return = "Failed";
	
     if ($this->input->server('REQUEST_METHOD')=='POST') {
		$captcha_response = trim($this->input->post('g-recaptcha-response'));

		if($captcha_response != '')
		{
			$keySecret = captcha_settings()->secretKey;

			$check = array(
				'secret'		=>	$keySecret,
				'response'		=>	$this->input->post('g-recaptcha-response')
			);

			$startProcess = curl_init();

			curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

			curl_setopt($startProcess, CURLOPT_POST, true);

			curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));

			curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);

			curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

			$receiveData = curl_exec($startProcess);

			$finalResponse = json_decode($receiveData, true);

			if($finalResponse['success'])
			{
           $data = array(
		'name'=>$_POST['name'],
		'email'=>$_POST['email'],
		'mobile'=>$_POST['mobile'],
		'subject'=>$_POST['subject'],
		'message'=>$_POST['message'],
		);
		if ($id = $this->model->Save('enquiry',$data)) {
			$return = "success";
		}					
		}
		else
			{
				$return = 'Please verify  you are Humann!';
			}
		}
	}
		echo $return;
       }
	public function forgot_password($action=null,$p1=null)
	{
		//$data['user'] = $user = $this->checkLogin();	
		switch($action)
		{
			case 'checkmobile':
				$mobile=$_POST['mob'];
				$mobile_check = $this->model->mobile_check($_POST['mob']);
					if($mobile_check ==1)
					{
				$this->db->delete('usermaster_otp', array('mobile' => $mobile));
				if(isset($_POST['mob']) && $_POST['mob']!==''){
						$otp=mt_rand(100000, 999999);
						$data =array(
							  'otp'=>$otp,
							  'mobile'=>$_POST['mob'],
						);
		
						if($this->model->updateRow($mobile,$data))
						{
							//code to send the otp to the mobile number will be placed here
							if(TRUE)
							{
								$return = 'Otp Send Your Mobile Number';
								$msg = 'Your OTP is '.$otp;
		                    	send_sms($mobile, $msg);
							}
							else
							{
								$return = "Message could not be sent.";	
							}
						}
						else
						{
								$return= "Otp could not be generated.";	
						}
				}	
				else
				{
					$return=  "Mobile number not received.";
				}
			
		       }
		          else
				{
					$return =  "Mobile number does not exist. ";
				}

			
				echo ($return);
				return TRUE;
			
			break;	
			case 'checkotp':
				$otp=$_POST['otp'];
				if(isset($_POST['otp']) && $_POST['otp']!==''){
					
					  $check_existing_otp = $this->model->otp_exist($_POST['otp']); 
					  if($check_existing_otp)
					  {
						$return= "OTP Correct";
					  }else{
						$return= "Not Valid OTP";
					  }
		
				}else
				{
					$return =  "Mobile number not received.";
				}
				echo ($return);
				return TRUE;
			break;		
		case 'submit_password':
			$newpassword=$_POST['password'];
			$cpassword=$_POST['cpassword'];
			$mobile=$_POST['mobile'];
			if(isset($_POST['password']) && $_POST['cpassword']!==''){
				$data =array(
				 'password'=>$this->encryption->encrypt($newpassword),
				);
				if($this->model->user_update_password($mobile,$data))
				{
					$user = $this->model->getRow('usermaster',['mobile'=>$mobile]);
					$return = 'success';
					logs($user->id,$user->id,'RESET_PASSWORD','User Reset Password');
					$this->db->delete('usermaster_otp', array('mobile' => $mobile));
	
				}else
				{
					$return = 'error';
				}
	
			}
		
			echo ($return);

		break;	
		case 'checkemail_admin':
			$email=$_POST['email'];
			$email_check = $this->model->email_check_admin($_POST['email']);
				if($email_check ==1)
				{
			$this->db->delete('tb_admin_otp', array('email' => $email));
			if(isset($_POST['email']) && $_POST['email']!==''){
					$otp=mt_rand(100000, 999999);
					$data =array(
						  'otp'=>$otp,
						  'email'=>$_POST['email'],
					);
	
					if($this->model->updateAdminRow($email,$data))
					{
						//code to send the otp to the mobile number will be placed here
						if(TRUE)
						{
							$return = 'Otp Send Your Email Address';
							$message = "Email verification otp.".$otp;
							$email = $_POST['email'];
							$subject = "Email verification otp.";
							sendMail($message,$email,$subject);;
						}
						else
						{
							$return = "Message could not be sent.";	
						}
					}
					else
					{
							$return= "Otp could not be generated.";	
					}
			}	
			else
			{
				$return=  "Email Address not received.";
			}
		
		   }
			  else
			{
				$return =  "Email address does not exist. ";
			}

		
			echo ($return);
		return TRUE;
	   break;		
		case 'adminverifyotpforgot':
			$otp=$_POST['otp'];
			if(isset($_POST['otp']) && $_POST['otp']!==''){
				
				  $check_existing_otp = $this->model->admin_otp_exist($_POST['otp']); 
				  if($check_existing_otp)
				  {
					$return= "OTP Correct";
				  }else{
					$return= "Not Valid OTP";
				  }
	
			}else
			{
				$return =  "Email Address  not received.";
			}
			echo ($return);
			return TRUE;
	  break;	
	  case 'admin_submit_password':
		$newpassword=$_POST['password'];
		$cpassword=$_POST['cpassword'];
		$email=$_POST['email'];
		if(isset($_POST['password']) && $_POST['cpassword']!==''){
			$data =array(
			 'password'=>$this->encryption->encrypt($newpassword),
			);
			if($this->model->admin_user_update_password($email,$data))
			{
				$return = 'success';
				$user = $this->model->getRow('tb_admin',['email'=>$email]);
					logs($user->id,$user->id,'RESET_PASSWORD','Admin Reset Password');
				$this->db->delete('tb_admin_otp', array('email' => $email));

			}else
			{
				$return = 'error';
			}

		}
	
		echo ($return);

	break;	
	   default :break;		
		}
		
	}
	
	public function getUserDataById() {
         $mobile = $this->input->post('mobile');  // Assuming the 'mobile' is sent via POST

        // Load the model and get the user data by mobile
       $userData = $this->model->getUserDataById($mobile);
        // Return the data as JSON
        header('Content-Type: application/json');
		if(!empty($userData))
		{
			$res = array(
			    'error'=>'false',
				'data'=>$userData
			  );
		}else
		{
			$res = array(
				'error'=>'true',
			  );
		}
		
        echo json_encode($res);
    }
	public function getuserdatabymobile() {
		$mobile = $this->input->post('mobile');  // Assuming the 'mobile' is sent via POST

	   // Load the model and get the user data by mobile
	  $userData = $this->model->getuserdatabymobile($mobile);
	   // Return the data as JSON
	   header('Content-Type: application/json');
	   if(!empty($userData))
		{
			$res = array(
			    'error'=>'false',
				'data'=>$userData
			  );
		}else
		{
			$res = array(
				'error'=>'true',
			  );
		}
	   echo json_encode($res);
   }
	

}
