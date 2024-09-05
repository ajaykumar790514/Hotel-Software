<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct(){
		parent::__construct();
       
    }

	public function register()
	{
		$data['language'] = $this->model->getData('language_speaks_master',['active'=>1]);
		$data['work'] = $this->model->getData('work_master',['active'=>1]);
		$data['countries'] = $this->model->getData('countries');
		$data['type'] 		 = $this->model->getData('property_types',['active'=>1],'asc','name');
		$data['document_type'] = $this->model->getData('property_doc_type',['active'=>1]);
		$data['ownership_type'] = $this->model->getData('ownership_type',['active'=>1, 'is_deleted'=>'NOT_DELETED']);
		// $data['page'] = 'register';
        // $this->load->view('layouts/index', $data);
        load_view('register',$data);
	}

	public function host_remote()
	{	
		$username  = $this->input->post('username');
		$table = $this->input->post('table_name');
		$data = $this->model->getRow($table,['username'=>$username]);
		if ($data == TRUE) {
			echo "duplicate";
		}
	}

	public function generate_otp()
	{
		$mobile = $this->input->post('mobile');
		$otp_code = rand(999999, 1000);
		$data = array(
			'mobile'=>$mobile,
			'otp'=>$otp_code,
		);
		//$this->session->set_userdata('user_data', $data);
		if ($this->model->getRow('otp',['mobile'=>$mobile])) {
			$this->model->Update('otp',$data,['mobile'=>$mobile]);
		}else{
			$this->model->Save('otp',$data);
		}

		$msg = $otp_code;
		//send_sms($mobile, $msg);

		$dataAjax = array('status'=>'success', 'mobile'=>$mobile);
		echo json_encode($dataAjax);
		
	}

	public function verify_otp()
	{
		$otp = $this->input->post('otp');
		$mobile = $this->input->post('mobile_2');
		//echo json_encode($user);
		
		if ($this->model->getRow('otp',['mobile'=>$mobile,'otp'=>$otp])) {
			$dataAjax = array('status'=>'success', 'mobile'=>$mobile);
		}else{
			$dataAjax = array('status'=>'fail');
		}

		echo json_encode($dataAjax);		
	}

	public function save_host()
	{
		$this->load->library('encryption');
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			if (@$_POST['language_speaks']) {
				$_POST['language_speaks'] = implode(',',$_POST['language_speaks']);
			}
			else{
				$_POST['language_speaks'] = '';
			}

			if (@$_POST['password']!='') {
				$host['password'] 	= $this->encryption->encrypt($_POST['password']);
			}	
			//echo json_encode($_POST['mob']); die;

			$host['name'] 		= $_POST['name'];
			$host['username'] 	= $_POST['username'];
			$host['email'] 		= $_POST['email'];
			$host['mobile'] 	= $_POST['mob'];

			$h_extended['about'] 			 = $_POST['about'];
			$h_extended['language_speaks'] 	 = $_POST['language_speaks'];
			$h_extended['work'] 			 = $_POST['work'];
			$h_extended['country'] 			 = $_POST['country'];
			$h_extended['state'] 			 = $_POST['state'];
			$h_extended['city'] 			 = $_POST['city'];
			$h_extended['identity_verified'] = 0;
			$h_extended['mobile_verified'] 	 = $_POST['mobile_verified'];
			$h_extended['email_verified'] 	 = $_POST['email_verified'];

			if (@$_FILES['aadhar_front']['name']) {				
				$config['upload_path']          = UPLOAD_PATH.'host_document/';
       			$config['allowed_types'] 		= '*';
                $config['remove_spaces']        = TRUE;
	            $config['encrypt_name']         = TRUE;
	            $config['max_filename']         = 20;
	            $this->load->library('upload', $config);
	            if($this->upload->do_upload('aadhar_front')){

	            	$upload_data = $this->upload->data();
	            	$file_name1 = 'host_document/'.$upload_data['file_name'];
	            	
	            }
	            $document['doc_front'] 		= $file_name1;
			}

			if (@$_FILES['aadhar_back']['name']) {				
				$config['upload_path']          = UPLOAD_PATH.'host_document/';
       			$config['allowed_types'] 		= '*';
                $config['remove_spaces']        = TRUE;
	            $config['encrypt_name']         = TRUE;
	            $config['max_filename']         = 20;
	            $this->load->library('upload', $config);
	            if($this->upload->do_upload('aadhar_back')){

	            	$upload_data = $this->upload->data();
	            	$file_name2 = 'host_document/'.$upload_data['file_name'];
	            	
	            }
	            $document['doc_back'] 		= $file_name2;
			}

			// if (@$_FILES['pan_card']['name']) {				
			// 	$config['upload_path']          = UPLOAD_PATH.'host_document/';
       		// 	$config['allowed_types'] 		= '*';
            //     $config['remove_spaces']        = TRUE;
	        //     $config['encrypt_name']         = TRUE;
	        //     $config['max_filename']         = 20;
	        //     $this->load->library('upload', $config);
	        //     if($this->upload->do_upload('pan_card')){

	        //     	$upload_data = $this->upload->data();
	        //     	$file_name3 = 'host_document/'.$upload_data['file_name'];
	            	
	        //     }
	        //    	$document['pan_card'] 		= $file_name3;
			// }						
			
			$document['doc_no'] 		= $_POST['aadhar_no'];						
			//$document['pan_no'] 		= $_POST['pan_no'];		

			// if (@$_POST['identity'] == 2) {	
			// 	if (@$_FILES['company_doc']['name']) {				
			// 		$config['upload_path']          = UPLOAD_PATH.'host_document/';
	       	// 		$config['allowed_types'] 		= '*';
	        //         $config['remove_spaces']        = TRUE;
		    //         $config['encrypt_name']         = TRUE;
		    //         $config['max_filename']         = 20;
		    //         $this->load->library('upload', $config);
		    //         if($this->upload->do_upload('company_doc')){

		    //         	$upload_data = $this->upload->data();
		    //         	$file_name4 = 'host_document/'.$upload_data['file_name'];
		            	
		    //         }
		    //         $document['company_doc'] 		= $file_name4;
			// 	}
				
			// 	$document['company_doc_no'] 		= $_POST['company_doc_no'];
			// }

			if (@$_FILES['pic']['name']) {
						
				$config['upload_path']          = UPLOAD_PATH.'host_document/';
       			$config['allowed_types'] 		= '*';
                $config['remove_spaces']        = TRUE;
	            $config['encrypt_name']         = TRUE;
	            $config['max_filename']         = 20;
	            $this->load->library('upload', $config);
	            if($this->upload->do_upload('pic')){

	            	$upload_data = $this->upload->data();
	            	$host['pic']  = 'host_document/'.$upload_data['file_name'];	            	
	            }
			}

			if($id = $this->model->SaveGetId('usermaster',$host)){
				$h_extended['usermaster_id'] = $id;
				$document['usermaster_id'] = $id;
				$this->model->Save('usermaster_extended',$h_extended);
				$this->model->Save('documents_master',$document);
				$this->session->set_userdata('host_id', $id);
				$saved = 1;
			}

			if ($saved == 1 ) {				
				$dataAjax = array('status'=>'success');
			}else{
				$dataAjax = array('status'=>'fail');
			}

			echo json_encode($dataAjax);

		}		
	}

	public function save_property()
	{
		if ($this->input->server('REQUEST_METHOD')=='POST') {

			if (@$_FILES['document']['name']) {
				$config['upload_path']          = UPLOAD_PATH.'property-document/';
       			$config['allowed_types'] 		= '*';
                $config['remove_spaces']        = TRUE;
	            $config['encrypt_name']         = TRUE;
	            $config['max_filename']         = 20;
	            $this->load->library('upload', $config);
	            if($this->upload->do_upload('document')){

	            	$upload_data = $this->upload->data();
	            	$_POST['document']  = 'property-document/'.$upload_data['file_name'];	            	
	            }					
			}
			
			$rto_code = 'FUNTC00001';
			$last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('propmaster')->row();
			if ($last_row->propcode) {
				$propcode = $last_row->propcode;
				$propcode++;
			}else{
				$propcode = $rto_code;
			}
			
			$_POST['propcode'] = $propcode;
			if ($insert_id = $this->model->Save('propmaster',$_POST)) {

				$propaccess['propmasterid'] 	= $insert_id;
				$propaccess['userid'] 			= $this->session->userdata('host_id');
				if ($this->model->Save('propaccess',$propaccess)) {
					$this->session->unset_userdata('host_id');
					$saved = 1;
				}					
			}

			if ($saved == 1 ) {				
				$dataAjax = array('status'=>'success');
			}else{
				$dataAjax = array('status'=>'fail');
			}

			echo json_encode($dataAjax);
		}
	}

	//forget password

	public function forget_password()
	{
		$data['language'] = $this->model->getData('language_speaks_master',['active'=>1]);
		// $data['work'] = $this->model->getData('work_master',['active'=>1]);
		// $data['countries'] = $this->model->getData('countries');
		// $data['type'] 		 = $this->model->getData('property_types',['active'=>1],'asc','name');
		// $data['document_type'] = $this->model->getData('property_doc_type',['active'=>1]);
		// $data['page'] = 'register';
        // $this->load->view('layouts/index', $data);
        load_view('forget_password',$data);
	}

	public function get_otp()
	{
		$username = $this->input->post('username');
		
		//$this->session->set_userdata('user_data', $data);
		if ($user = $this->model->getRow('usermaster',['username'=>$username])) {
			$mobile = $user->mobile;
			$otp_code = rand(999999, 1000);
			$data = array(
				'mobile'=>$mobile,
				'otp'=>$otp_code,
			);
			if ($this->model->getRow('otp',['mobile'=>$mobile])) {
				$this->model->Update('otp',$data,['mobile'=>$mobile]);
			}else{
				$this->model->Save('otp',$data);
			}

			$msg = $otp_code;
			//send_sms($mobile, $msg);

			$dataAjax = array('status'=>'success', 'mobile'=>$mobile, 'user'=>$username);
		}else{
			$dataAjax = array('status'=>'fail');
		}
		
		echo json_encode($dataAjax);		
	}

	public function update_password()
	{
		if ($this->input->server('REQUEST_METHOD')=='POST') {			
			$this->load->library('encryption');
		
			$username = $_POST['username'];
			$data = array(
				'password'=>$this->encryption->encrypt($_POST['password']),
			);
			if ($this->model->Update('usermaster',$data,['username'=>$username])) {

				$saved = 1;				
			}

			if ($saved == 1 ) {				
				$dataAjax = array('status'=>'success');
			}else{
				$dataAjax = array('status'=>'fail');
			}

			echo json_encode($dataAjax);
		}	
	}

	// public function verify_otp()
	// {
	// 	$otp = $this->input->post('otp');
	// 	$mobile = $this->input->post('mobile_2');
		
	// 	if ($row = $this->Model->getRow('appuser',['mobile'=>$mobile, 'otp'=>$otp])) {
	// 		if ($row->name !=null) {
	// 			$this->session->set_userdata('user_id', $row->id);
	// 			//redirect('dashboard');
	// 			$dataAjax = array('status'=>'success', 'name'=>$row->name, 'mobile'=>$mobile);
	// 		}else{
	// 			$dataAjax = array('status'=>'success', 'name'=>$row->name, 'mobile'=>$mobile);
	// 		}			
	// 	}else{
	// 		$dataAjax = array('status'=>'fail');
	// 	}

	// 	echo json_encode($dataAjax);
		
	// }

	// public function save_user()
	// {
	// 	$name = $this->input->post('name');
	// 	$gender = $this->input->post('gender');
	// 	$dob = $this->input->post('dob');
	// 	$mobile = $this->input->post('mob');
	// 	$email = $this->input->post('email');

	// 	if (!empty($_FILES['photo']['name'])) {
	// 		$config['upload_path']          = UPLOAD_PATH.'user';
   	// 		$config['allowed_types'] 		= '*';
    //         $config['remove_spaces']        = TRUE;
    //         $config['encrypt_name']         = TRUE;
    //         $config['max_filename']         = 20;
    //         $this->load->library('upload', $config);
    //         if($this->upload->do_upload('photo')){					
    //         	$upload_data = $this->upload->data();
    //         	$photo  = 'user/'.$upload_data['file_name'];
    //         }
	// 	}
	// 	//echo json_encode($_FILES['photo']['name']); die;

	// 	$otp_code = rand(999999, 1000);
	// 	$data = array(
	// 		'name'=>$name,
	// 		'gender'=>$gender,
	// 		'dob'=>$dob,
	// 		'email'=>$email,
	// 		'photo'=>$photo,
	// 	);
	// 	if ($this->Model->Update('appuser',$data,['mobile'=>$mobile])) {
	// 		$row = $this->Model->getRow('appuser',['mobile'=>$mobile]);
	// 		$this->session->set_userdata('user_id', $row->id);
	// 		$dataAjax = array('status'=>'success');
	// 	}
		
	// 	echo json_encode($dataAjax);
		
	// }

	

	// public function logout()
	// {
	// 	$this->session->unset_userdata('user_id');
	// 	redirect('login');
	// }

	// public function mobile_otp(){
	// 	$otp_code = rand(999999, 1000);
	// 	$mobile = $this->input->post('mobile');
	// 	$data = array(
	// 		'mobile'=>$mobile,
	// 		'otp'=>$otp_code,
	// 	);
	// 	if ($this->model->getRow('otp',['mobile'=>$mobile])) {
	// 		$this->model->Delete('otp',['mobile'=>$mobile]);
	// 	}

	// 	if ($this->model->Save('otp',$data)) {
	// 		$msg = 'Your OTP is '.$otp_code;
	// 		$this->send_sms($mobile, $msg);
	// 	}		
	// }

	
}
