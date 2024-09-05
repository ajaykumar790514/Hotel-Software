<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Host_m extends Main {

	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function index($action=null,$id=null)
	{

	}

	public function host($action=null,$id=null,$id2=null,$id3=null)
	{
		$data['user'] =$user   = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] = 'Host';
				$data['contant'] = 'host_m/host/index';
				$data['tb_url']	  =  base_url().'host/tb';
				$data['new_url']	  =  base_url().'host/create';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
					$config = array();
			        $config["base_url"] = base_url()."host/tb";

			        $data['search'] = '';
			        if (@$_POST['search']) {
			        	$data['search'] = $_POST['search'];
						$this->db->like('name', $_POST['search']);
			        	$this->db->or_like('email', $_POST['search']);
						$this->db->or_like('mobile', $_POST['search']);
					
			        }
			        $config["total_rows"]  = count($this->model->getData('usermaster',['parent_id'=>0,'is_deleted'=>'NOT_DELETED']));
			        $data['total_rows']    = $config["total_rows"];
			        $config["per_page"]    = 20;
			        $config["uri_segment"] = 4;
			        $config['attributes']  = array('class' => 'pag-link');
			        $this->pagination->initialize($config);
			        $data["links"]   = $this->pagination->create_links();

					$data['page']    = $page = ($id!=null) ? $id : 0;
					$data['contant'] = 'properties/tb_properties';
					if (@$_POST['search']) {
						$data['search'] = $_POST['search'];
						$this->db->like('name', $_POST['search']);
			        	$this->db->or_like('email', $_POST['search']);
						$this->db->or_like('mobile', $_POST['search']);
					}
					$rows    =  $this->model->getData('usermaster',['parent_id'=>0,'is_deleted'=>'NOT_DELETED'],'desc','id',$config["per_page"],$page);
 				$data['contant'] 	  = 'host_m/host/tb';
				$data['update_url']	  =  base_url().'host/create/';
				$data['delete_url']	  =  base_url().'host/delete/';
				// $rows   			  = $this->model->getData('usermaster',0,'desc');
				foreach ($rows as $row) {
					$row->extended =  $this->model->getRow('usermaster_extended',['usermaster_id'=>$row->id]);
					$row->propaccess =  $this->model->getData('propaccess',['userid'=>$row->id]);
					$propnames = array();
					
					if ($row->propaccess) {
						foreach ($row->propaccess as $proprow) {
							$propnames[] = title('propmaster', $proprow->propmasterid,'id','propname');
						}
					}
					$row->propnames = $propnames;
					unset($propnames);
				}
				
				$data['rows'] = $rows;

				// $this->pr($rows);
				load_view($data['contant'],$data);
				break;
               case 'propaccess-list':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {

					$p_id   = $_POST['p_id'];
					$type   = $_POST['type'];
					$host_id = $id;
					$row = $this->model->getRow('propmaster',['id'=>$p_id]);
					if($row){
						$check['userid']   			= $host_id;
						$check['propmasterid'] 		= $p_id;
						$update['propmasterid'] 	= $p_id;

						if ($type=='set') {
							
							if($this->model->getRow('propaccess',$check)){
								if ($this->model->Update('propaccess',$update,$check)) {
									logs($user->id,$p_id,'EDIT','Edit Propmaster Access');
									$saved = 1;
								}
							}
							else{
								if ($p_id=$this->model->Save('propaccess',$check)) {
									logs($user->id,$p_id,'Add','Add Propmaster Access');
									$saved = 1;
								}
							}
						}
						else{
							if ($this->model->Delete('propaccess',$check)) {
								logs($user->id,$p_id,'DELETE','Delete Propmaster Access');
								$this->model->deleteSubHostPropaccess($host_id,$p_id);
								$saved = 1;
							}
						}
					}
					if ($saved == 1) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}

					echo json_encode($return);
					
				}
				else{
					$data['rs']=$rs    =  $this->model->getRow('usermaster',['id'=>$id]);
					$rs1  = $this->model->getData('propaccess',['userid'=>$rs->id]);
					foreach($rs1 as $r)
					{
						$propmaster     = $this->model->getData('propmaster',['id'=>$r->propmasterid],'asc','propname');
					}
					$data['title'] = 'Host';
					$data['contant']     = 'host_m/host/propaccess_new';
					$data['host_id'] = $host_id = $id;
					$data['propmaster']  = @$propmaster ? @$propmaster : [];
					$data['countries'] = $this->getCountries(null,'return');
					$data['tb_filter_url'] = base_url().'host/propaccess_tb_filter/'.$id;
					$data['more_info_url'] =  base_url().'more-info/';
					$this->template($data);
				}
				break;
			case 'propaccess':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					// $this->pr($_POST);

					$p_id   = $_POST['p_id'];
					$type   = $_POST['type'];
					$host_id = $id;
					$row = $this->model->getRow('propmaster',['id'=>$p_id]);
					if($row){
						$check['userid']   			= $host_id;
						$check['propmasterid'] 		= $p_id;

						// $set['propmasterid'] = $a_id;
						// $set['userid'] 		 = $host_id;

						$update['propmasterid'] 	= $p_id;

						if ($type=='set') {
							
							if($this->model->getRow('propaccess',$check)){
								if ($this->model->Update('propaccess',$update,$check)) {
									logs($user->id,$p_id,'EDIT','Edit Propmaster Access');
									$saved = 1;
								}
							}
							else{
								if ($p_id=$this->model->Save('propaccess',$check)) {
									logs($user->id,$p_id,'Add','Add Propmaster Access');
									$saved = 1;
								}
							}
						}
						else{
							if ($this->model->Delete('propaccess',$check)) {
								logs($user->id,$p_id,'DELETE','Delete Propmaster Access');
								$this->model->deleteSubHostPropaccess($host_id,$p_id);
								$saved = 1;
							}
						}
					}
					if ($saved == 1) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}

					echo json_encode($return);
					
				}
				else{
					$rs    =  $this->model->getRow('usermaster',['id'=>$id]);
					$rs1  = $this->model->getData('propaccess',['userid'=>$rs->id]);
					foreach($rs1 as $r)
					{
						$propmaster     = $this->model->getData('propmaster',['id'=>$r->propmasterid],'asc','propname');
					}
					$page     = 'host_m/host/propaccess';
					
					$data['host_id'] = $host_id = $id;
					// if ($propmaster) {
					// 	foreach ($propmaster as $row) {
					// 		$row->checked = '';
					// 		if ($t = $this->model->getRow('propaccess',['propmasterid'=>$row->id,'userid'=>$host_id])) {
					// 			$row->checked = 'checked';
					// 		}
					// 	}
					// }

					// $checked = array_column($propmaster, 'checked');

					// array_multisort($checked, SORT_DESC, $propmaster);



					$data['propmaster']  = @$propmaster ? @$propmaster : [];
					$data['countries'] = $this->getCountries(null,'return');
					$data['tb_filter_url'] = base_url().'host/propaccess_tb_filter/'.$id;
					$data['more_info_url'] =  base_url().'more-info/';
					// $this->pr($data);
					load_view($page,$data);
				}
				break;		
              case 'package':
				$page     = 'host_m/host/host_package';
				$data['package'] = $package = $this->model->getRow('user_assign_package',['id'=>$id]);
				$data['package_master'] = $this->model->getRow('user_packages_master',['id'=>$package->package_id]);
				$this->load->view($page,$data);
			  break;
			case 'propaccess_tb_filter':

				$cond = array_filter($_POST);

				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$page     = 'host_m/host/propaccess_tb';
					if (@$cond['search']) {
						$s = $cond['search'];
						$this->db->like('propname',$s);
					}
					$propmaster     = $this->model->getData('propmaster',$cond,'asc','propname');
					$data['host_id'] = $host_id = $id;
					if ($propmaster) {
						foreach ($propmaster as $row) {
							$row->checked = '';
							if ($t = $this->model->getRow('propaccess',['propmasterid'=>$row->id,'userid'=>$host_id])) {
								$row->checked = 'checked';
							}
						}
					}
					$checked = array_column($propmaster, 'checked');

					array_multisort($checked, SORT_DESC, $propmaster);
					$data['propmaster']  = $propmaster;
					load_view($page,$data);
				}
				// $this->pr($_POST);

				break;

			case 'create':
				$data['title'] = 'New Website Property';
				$data['contant'] = 'host_m/host/create';
				$data['action_url']	  =  base_url().'host/save';
				$data['countries']      = $this->getCountries(null,'return');
				
				if ($id!=null) {
					$data['action_url']	  =  base_url().'host/save/'.$id;

					$data['row'] = $this->model->getRow('usermaster',['id'=>$id]);
					$row_extended = $this->model->getRow('usermaster_extended',['usermaster_id'=>$id]);
					$data['row_extended'] = $row_extended;
					$data['document'] = $this->model->getRow('documents_master',['usermaster_id'=>$id]);
					$data['countries']    = $this->getCountries($row_extended->country,'return');
					$data['states']     = $this->getStates($row_extended->country,$row_extended->state,true);
					$data['cities']     = $this->getCities($row_extended->state,$row_extended->city,true);
				}
				
				
				$data['language']  = $this->model->getData('language_speaks_master',0,'asc','language');
				$data['work']  = $this->model->getData('work_master',0,'asc','work');

				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
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
					
					$host['name'] 		= $_POST['name'];
					$host['username'] 	= $_POST['username'];
					$host['email'] 		= $_POST['email'];
					$host['mobile'] 	= $_POST['mobile'];
					$host['aadhaar_no'] 	= $_POST['aadhar_no'];

					//$h_extended['about'] 			 = $_POST['about'];
					$h_extended['language_speaks'] 	 = $_POST['language_speaks'];
					//$h_extended['work'] 			 = $_POST['work'];
					$h_extended['country'] 			 = $_POST['country'];
					$h_extended['state'] 			 = $_POST['state'];
					$h_extended['city'] 			 = $_POST['city'];
					$h_extended['identity_verified'] = 0;
					$h_extended['mobile_verified'] 	 = $_POST['mobile_verified'];;
					$h_extended['email_verified'] 	 = $_POST['email_verified'];;

					(@$_POST['identity_verified']) ? $h_extended['identity_verified'] = '1' : '' ;
					// (@$_POST['mobile_verified']) ? $h_extended['mobile_verified'] = '1' : '' ;
					// (@$_POST['email_verified']) ? $h_extended['email_verified'] = '1' : '' ;					

					// $this->pr($_POST);										

						$file_name = 'aadhar_front';
						if (@$_FILES[$file_name]['name']) {
							$directory =  UPLOAD_PATH.'users/';
							
							$config['upload_path']          = $directory;
	               			$config['allowed_types'] 		= '*';
			                $config['remove_spaces']        = TRUE;
				            $config['encrypt_name']         = TRUE;
				            $config['max_filename']         = 20;
							$config['max_size']    			= '100';
				            $this->load->library('upload', $config);
				            if($this->upload->do_upload($file_name)){

				            	$upload_data = $this->upload->data();
				            	$file_name1 = 'users/'.$upload_data['file_name'];
								$host['aadhaar_front'] 		= $file_name1;
				            }
							else{
								$error = $this->upload->display_errors();
							   $return['res'] = 'error';
							   $return['msg'] = $error;
							}
				          
						}else{
							$host['aadhaar_front'] 		= $_POST['old_aadhar_front'];
						}

						$file_name = 'aadhar_back';
						if (@$_FILES[$file_name]['name']) {
							$directory =  UPLOAD_PATH.'users/';
							
							$config['upload_path']          = $directory;
	               			$config['allowed_types'] 		= '*';
			                $config['remove_spaces']        = TRUE;
				            $config['encrypt_name']         = TRUE;
				            $config['max_filename']         = 20;
							$config['max_size']    			= '100';
				            $this->load->library('upload', $config);
				            if($this->upload->do_upload($file_name)){

				            	$upload_data = $this->upload->data();
				            	$file_name2 = 'users/'.$upload_data['file_name'];
								$host['aadhaar_back'] 		= $file_name2;
				            }else{
								$error = $this->upload->display_errors();
							   $return['res'] = 'error';
							   $return['msg'] = $error;
							}
							
				         
						}else{
							$host['aadhaar_back'] 		= $_POST['old_aadhar_back'];
						}

						// $file_name = 'pan_card';
						// if (@$_FILES[$file_name]['name']) {
						// 	$directory =  UPLOAD_PATH.'host_document/';
							
						// 	$config['upload_path']          = $directory;
	               		// 	$config['allowed_types'] 		= '*';
			            //     $config['remove_spaces']        = TRUE;
				        //     $config['encrypt_name']         = TRUE;
				        //     $config['max_filename']         = 20;
				        //     $this->load->library('upload', $config);
				        //     if($this->upload->do_upload($file_name)){

				        //     	$upload_data = $this->upload->data();
				        //     	$file_name3 = 'host_document/'.$upload_data['file_name'];
				            	
				        //     }
				        //    	$document['pan_card'] 		= $file_name3;
						// }else{
						// 	$document['pan_card'] 		= $_POST['old_pan_card'];
						// }						
						
						// $document['doc_no'] 		= $_POST['aadhar_no'];						
						// $document['pan_no'] 		= $_POST['pan_no'];

					

					// if (@$_POST['identity'] == 2) {	
					// 	$file_name = 'company_doc';
					// 	if (@$_FILES[$file_name]['name']) {
					// 		$directory =  UPLOAD_PATH.'host_document/';
							
					// 		$config['upload_path']          = $directory;
	               	// 		$config['allowed_types'] 		= '*';
			        //         $config['remove_spaces']        = TRUE;
				    //         $config['encrypt_name']         = TRUE;
				    //         $config['max_filename']         = 20;
				    //         $this->load->library('upload', $config);
				    //         if($this->upload->do_upload($file_name)){

				    //         	$upload_data = $this->upload->data();
				    //         	$file_name4 = 'host_document/'.$upload_data['file_name'];
				            	
				    //         }
				    //         $document['company_doc'] 		= $file_name4;
					// 	}else{
					// 		$document['company_doc'] 		= $_POST['old_company_doc'];
					// 	}
						
					// 	$document['company_doc_no'] 		= $_POST['company_doc_no'];
					// }

					if ($id!=null) {
						$row = $this->model->getRow('usermaster',['id'=>$id]);
						if (@$row) {
		            		if(@$row->send_email = 'NULL'){
		            			$password = $this->encryption->decrypt($row->password);
		            			$subject = 'Your account activate.';
								$message = 'Username is '.$row->username.'<br>';
								$message .= 'Password is '.$password;
								$this->php_mail_func($row->email, $subject, $message);
								$host['send_email'] = 1;
		            		}
						}
						if($this->model->Update('usermaster',$host,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Host By Admin');
							$this->model->Update('usermaster_extended',$h_extended,['usermaster_id'=>$id]);
							//$this->model->Update('documents_master',$document,['usermaster_id'=>$id]);
							$saved = 1;
						}
					}
					else{
						if($id = $this->model->SaveGetId('usermaster',$host)){
							logs($user->id,$id,'ADD','Add Host By Admin');
							$h_extended['usermaster_id'] = $id;
							//$document['usermaster_id'] = $id;
							$this->model->Save('usermaster_extended',$h_extended);
							//$this->model->Save('documents_master',$document);
							$saved = 1;
						}
					}

					if ($saved == 1 ) {

						$file_name = 'pic';
						if (@$_FILES[$file_name]['name']) {
						
						$config['upload_path']          = UPLOAD_PATH.'users/';
               			$config['allowed_types'] 		= '*';
		                $config['remove_spaces']        = TRUE;
			            $config['encrypt_name']         = TRUE;
			            $config['max_filename']         = 20;
						$config['max_size']    			= '100';
			            $this->load->library('upload', $config);
			            if($this->upload->do_upload($file_name)){

			            	$upload_data = $this->upload->data();
			            	$img['pic']  = 'users/'.$upload_data['file_name'];
			            	if($this->model->Update('usermaster',$img,['id'=>$id])){
				            	if (@$row) {
				            		if(@$row->pic!=''){
				            			unlink(UPLOAD_PATH.$row->pic);
				            		}
								}
							}
			            }else{
							$error = $this->upload->display_errors();
						   $return['res'] = 'error';
						   $return['msg'] = $error;
						}
					}
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
				}
				echo json_encode($return);
				break;
				case 'remark':
					$data['reamrk'] = $this->model->getRow('property',['flat_id'=>$id]);
					$data['action_url'] = base_url().'sub_properties/'.$pro_id.'/save_remark/'.$id;
					$page = 'properties/sub_p/sub_property_remark';
					load_view($page,$data);
					break;
				case 'delete':
					$return['res'] = 'error';
					$return['msg'] = 'Not Deleted!';
					if ($id!=null) {
						if($this->model->_delete('usermaster',['id'=>$id])){
							logs($user->id,$id,'DELETE','Delete Host By Admin');
							$this->model->Update('usermaster',['isactive'=>0],['id'=>$id]);
							$saved = 1;
							$return['res'] = 'success';
							$return['msg'] = 'Successfully deleted.';
						}
					}
					echo json_encode($return);	
				break;

			case 'remote':
				$username  = $this->input->post('username');
				$table = $this->input->post('table_name');
				$data = $this->model->getRow($table,['username'=>$username]);
				if ($data == TRUE) {
					echo "duplicate";
				}				
				break;
				case 'details':
					$data['title'] 		= 'Property Details';
					$data['contant']  	= 'host_m/host/more_details';
					$data['row'] = $row = $this->model->getRow('propmaster',['id'=>$id]);
					$data['type'] 		= $this->model->getData('property_types',['active'=>1],'asc','name');
					$data['countries']  = $this->model->getData('countries',0,'asc','name');
					$data['states']     = $this->getStates($row->country,$row->state,true);
					$data['district']   = $this->getDistrict($row->state,$row->district,true);
					$data['cities']     = $this->getCities($row->state,$row->city,true);
					$data['locations']  = $this->load_locations($row->state,$row->city,$row->location_id);
					$data['document_type'] = $this->model->getData('property_doc_type',['active'=>1]);
					$data['ownership_type'] = $this->model->getData('ownership_type',['active'=>1, 'is_deleted'=>'NOT_DELETED']);
					$data['prop_doc'] = $this->model->getRow('propmaster_document',['prop_m_id'=>$id]);
					$this->template($data);
					break;
					case 'approval__remark':
						$data['user']  = $user  = $this->checkLogin();
						 $id = $_POST['id'];
						 $remark = $_POST['remark'];
						$status = array('remark'=>$_POST['remark']);
						$table = 'propmaster';
						if($this->model->Update($table,$status,['id'=>$id])){
						logs($user->id,$id,'CHANGE_STATUS','Change Status Propmaster By Admin '.$table.$remark);
							echo 'success';
						}else
						{
							echo 'error';
						}
				break;
				case 'approval_status_change':
					$data['user'] = $user 			= $this->checkLogin();
					$id = $_POST['id'];
					$where = $_POST['where'];
					$status = array('approval_status'=>$_POST['status']);
					$table = $_POST['table'];
					if($this->model->Update($table,$status,[$where=>$id])){
						logs($user->id,$id,'CHANGE_STATUS','Change Status Propmaster By Admin - '.$_POST['status']);
						echo $_POST['status'];
					}
			break;
			case 'package-invoice';
            $package_id = $id;
			$user_id = $id2;
			$property_id = $id3;
			break;
			}
	}
	public function more_details($action = null, $p1 = null, $p2 = null)
	{
		
		$data['user'] = $user = $this->checkLogin();
		switch ($action) {
			case 'details':
				$data['title'] 		= 'Property Details';
				$data['contant']  	= 'host_m/host/more_details';
				$data['row'] = $row = $this->model->getRow('propmaster',['id'=>$p1]);
				$data['type'] 		= $this->model->getData('property_types',['active'=>1],'asc','name');
				$data['countries']  = $this->model->getData('countries',0,'asc','name');
				$data['states']     = $this->getStates($row->country,$row->state,true);
				$data['district']   = $this->getDistrict($row->state,$row->district,true);
				$data['cities']     = $this->getCities($row->state,$row->city,true);
				$data['locations']  = $this->load_locations($row->state,$row->city,$row->location_id);
				$data['document_type'] = $this->model->getData('property_doc_type',['active'=>1]);
				$data['ownership_type'] = $this->model->getData('ownership_type',['active'=>1, 'is_deleted'=>'NOT_DELETED']);
				$data['prop_doc'] = $this->model->getRow('propmaster_document',['prop_m_id'=>$p1]);
				$this->template($data);
				break;
			}
		
		}
		public function load_locations($state=null,$city=null,$selected_location=null){
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
	public function email_otp(){
		$otp_code = rand(999999, 1000);
		$email = $this->input->post('email');
		$data = array(
			'mobile'=>$email,
			'otp'=>$otp_code,
		);
		if ($this->model->getRow('otp',['mobile'=>$email])) {
			$this->model->Delete('otp',['mobile'=>$email]);
		}

		if ($this->model->Save('otp',$data)) {
			$subject = 'Verify Email';
			$message = 'Email OTP is '.$otp_code;
			$this->php_mail_func($email, $subject, $message);
		}		
	}

	public function email_verify(){
		$email = $this->input->post('email');
		$otp = $this->input->post('otp_code');
		$ume_id = $this->input->post('ume_id');
		
		if ($this->model->getRow('otp',['mobile'=>$email, 'otp'=>$otp])) {
			if ($ume_id !=0) {
				$data = array(
					'email_verified'=>1,
				);
				$this->model->Update('usermaster_extended',$data,['ume_id'=>$ume_id]);
			}			
			echo 'success';
		}else{
			echo 'fail';
		}			
	}

	public function mobile_otp(){
		$otp_code = rand(999999, 1000);
		$mobile = $this->input->post('mobile');
		$data = array(
			'mobile'=>$mobile,
			'otp'=>$otp_code,
		);
		if ($this->model->getRow('otp',['mobile'=>$mobile])) {
			$this->model->Delete('otp',['mobile'=>$mobile]);
		}

		if ($this->model->Save('otp',$data)) {
			$msg = 'Your OTP is '.$otp_code;
			$this->send_sms($mobile, $msg);
			// send sms function change in future
		}		
	}

	public function mobile_verify(){
		$mobile = $this->input->post('mobile');
		$otp = $this->input->post('otp_code');
		$ume_id = $this->input->post('ume_id');

		if ($this->model->getRow('otp',['mobile'=>$mobile, 'otp'=>$otp])) {
			if ($ume_id !=0) {
				$data = array(
					'mobile_verified'=>1,
				);
				$this->model->Update('usermaster_extended',$data,['ume_id'=>$ume_id]);
			}
			echo 'success';
		}else{
			echo 'fail';
		}			
	}

	public function send_sms($mob,$msg)
    {
        $senderId="TECHFZ";
        $serverUrl="msg.msgclub.net";
        $authKey="51ed3366a65d909977ade34af8c5523";
        $routeId="1";
        
        $message=$msg." is your login OTP. Treat this as confidential. Techfi Zone will never call you to verify your OTP. Techfi Zone Pvt Ltd.";
        
        $getData = 'mobileNos='.$mob.'&message='.urlencode($message).'&senderId='.$senderId.'&routeId='.$routeId;

        //API URL
        $url="http://".$serverUrl."/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$authKey."&".$getData;


        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0

        ));


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);

        return $output;
    }

	public function php_mail_func($email, $subject, $message){
		$ch = curl_init();
		$fields = array( 'message'=>$message, 'email'=>$email,'subject'=>$subject);
		$postvars = '';
		foreach($fields as $key=>$value) {
			$postvars .= $key . "=" . $value . "&";
		}
		$url = "https://www.techfizone.com/techfiprojects/email_master/movementsparkle/mailApi.php";
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
		curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
		curl_setopt($ch,CURLOPT_TIMEOUT, 20);
		$response = curl_exec($ch);

		curl_close ($ch);		
	}

	public function sub_host($action=null,$id=null)
	{
		$this->checkPlan(@$_COOKIE['property_id']);
		$data['user']  = $user  = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] 			= 'Sub-Host';
				$data['contant'] 		= 'host_m/sub-host/index';
				$data['tb_url']	  		=  base_url().'sub-host/tb';
				$data['new_url']	  	=  base_url().'sub-host/create';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
					$config = array();
			        $config["base_url"] = base_url()."sub-host/tb";

			        $data['search'] = '';
			        if (@$_POST['search']) {
			        	$data['search'] = $_POST['search'];
						$this->db->like('name', $_POST['search']);
			        	$this->db->or_like('email', $_POST['search']);
						$this->db->or_like('mobile', $_POST['search']);
					
			        }
			        $config["total_rows"]  = count($this->model->getData('usermaster',['parent_id'=>$user->id]));
			        $data['total_rows']    = $config["total_rows"];
			        $config["per_page"]    = 20;
			        $config["uri_segment"] = 4;
			        $config['attributes']  = array('class' => 'pag-link');
			        $this->pagination->initialize($config);
			        $data["links"]   = $this->pagination->create_links();

					$data['page']    = $page = ($id!=null) ? $id : 0;
					$data['contant'] = 'properties/tb_properties';
					if (@$_POST['search']) {
						$data['search'] = $_POST['search'];
						$this->db->like('name', $_POST['search']);
			        	$this->db->or_like('email', $_POST['search']);
						$this->db->or_like('mobile', $_POST['search']);
					}
					$rows    =  $this->model->getData('usermaster',['parent_id'=>$user->id],'desc','id',$config["per_page"],$page);



				$data['contant'] 	  = 'host_m/sub-host/tb';
				$data['update_url']	  =  base_url().'sub-host/create/';
				$data['delete_url']	  =  base_url().'sub-host/delete/';
				// $rows   			  = $this->model->getData('usermaster',0,'desc');
				foreach ($rows as $row) {
					$row->extended =  $this->model->getRow('usermaster_extended',['usermaster_id'=>$row->id]);
					$row->propaccess =  $this->model->getData('propaccess',['userid'=>$row->id]);
					$propnames = array();
					if ($row->propaccess) {
						foreach ($row->propaccess as $proprow) {
							$propnames[] = title('propmaster', $proprow->propmasterid,'id','propname');
						}
					}
					$row->propnames = $propnames;
					unset($propnames);
				}
				
				$data['rows'] = $rows;

				// $this->pr($rows);
				load_view($data['contant'],$data);
				break;

			case 'propaccess':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					// $this->pr($_POST);

					$p_id   = $_POST['p_id'];
					$type   = $_POST['type'];
					$host_id = $id;
					
					$row = $this->model->getRow('propmaster',['id'=>$p_id]);



					if($row){
						$check['userid']   			= $host_id;
						$check['propmasterid'] 		= $p_id;

						// $set['propmasterid'] = $a_id;
						// $set['userid'] 		 = $host_id;

						$update['propmasterid'] 	= $p_id;

						if ($type=='set') {
							
							if($this->model->getRow('propaccess',$check)){
								if ($this->model->Update('propaccess',$update,$check)) {
									logs($user->id,$p_id,'EDIT','Edit Property Access');
									$saved = 1;
								}
							}
							else{
								if ($p_id=$this->model->Save('propaccess',$check)) {
									logs($user->id,$p_id,'ADD','Add Property Access');
									$saved = 1;
								}
							}
						}
						else{
							if ($this->model->Delete('propaccess',$check)) {
								logs($user->id,$p_id,'DELETE','Delete Property Access');
								$saved = 1;
							}
						}
					}
					if ($saved == 1) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}

					echo json_encode($return);
					
				}
				else{
					$page     = 'host_m/sub-host/propaccess';
					$propmaster     = $this->model->getData('propmaster',0,'asc','propname');

					foreach ($propmaster as $key => $value) {
						if(!$this->model->getRow('propaccess',['propmasterid'=>$value->id,'userid'=>$user->id])){
							unset($propmaster[$key]);
						}
					}
					
					$data['host_id'] = $host_id = $id;
					if ($propmaster) {
						foreach ($propmaster as $row) {
							$row->checked = '';
							if ($t = $this->model->getRow('propaccess',['propmasterid'=>$row->id,'userid'=>$host_id])) {
								$row->checked = 'checked';
							}
						}
					}

					$checked = array_column($propmaster, 'checked');

					array_multisort($checked, SORT_DESC, $propmaster);



					$data['propmaster']  = $propmaster;
					$data['countries'] = $this->getCountries(null,'return');
					$data['tb_filter_url'] = base_url().'sub-host/propaccess_tb_filter/'.$id;
					// $this->pr($data);
					load_view($page,$data);
				}
				break;

			case 'propaccess_tb_filter':

				$cond = array_filter($_POST);

				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$page     = 'host_m/sub-host/propaccess_tb';
					if (@$cond['search']) {
						$s = $cond['search'];
						$this->db->like('propname',$s);
					}
					$propmaster     = $this->model->getData('propmaster',$cond,'asc','propname');
					foreach ($propmaster as $key => $value) {
						if(!$this->model->getRow('propaccess',['propmasterid'=>$value->id,'userid'=>$user->id])){
							unset($propmaster[$key]);
						}
					}
					$data['host_id'] = $host_id = $id;
					if ($propmaster) {
						foreach ($propmaster as $row) {
							$row->checked = '';
							if ($t = $this->model->getRow('propaccess',['propmasterid'=>$row->id,'userid'=>$host_id])) {
								$row->checked = 'checked';
							}
						}
					}
					$checked = array_column($propmaster, 'checked');

					array_multisort($checked, SORT_DESC, $propmaster);
					$data['propmaster']  = $propmaster;
					load_view($page,$data);
				}
				// $this->pr($_POST);

				break;





			case 'create':
				$data['title'] = 'New Sub-Host';
				$data['contant'] = 'host_m/sub-host/create';
				$data['action_url']	  =  base_url().'sub-host/save';
				$data['countries']      = $this->getCountries(null,'return');
				$data['remote']             = base_url().'host_m/remote/usermaster/';
				$data['rows']		  = $this->model->getData('tb_user_role',['host_id ='=>$user->id]);
				if ($id!=null) {
					$data['action_url']	  =  base_url().'sub-host/save/'.$id;
					$data['remote']             = base_url().'host_m/remote/usermaster/'.$id;
					$data['row'] = $this->model->getRow('usermaster',['id'=>$id]);
					$row_extended = $this->model->getRow('usermaster_extended',['usermaster_id'=>$id]);
					$data['row_extended'] = $row_extended;
					$data['countries']    = $this->getCountries($row_extended->country,'return');
					$data['states']     = $this->getStates($row_extended->country,$row_extended->state,true);
					$data['cities']     = $this->getCities($row_extended->state,$row_extended->city,true);
				}
				$data['language']  = $this->model->getData('language_speaks_master',0,'asc','language');
				$data['work']  = $this->model->getData('work_master',0,'asc','work');

				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {

					if (@$_POST['password']!=$_POST['cpassword']) {
						$return['res'] = 'error';
						$return['msg'] = 'Password or Confirm Password do not match.';
			         	echo json_encode($return);
						die();
					}

					// if (@$_POST['language_speaks']) {
					// 	$_POST['language_speaks'] = implode(',',$_POST['language_speaks']);
					// }
					// else{
					// 	$_POST['language_speaks'] = '';
					// }

					if (@$_POST['password']!='') {
						$host['password'] 	=$this->encryption->encrypt($_POST['password']);
					}

					

					$host['name'] 		= $_POST['name'];
					$host['username'] 	= $_POST['username'];
					$host['email'] 		= $_POST['email'];
					$host['mobile'] 	= $_POST['mobile'];
					$host['parent_id']	= $user->id;
					$host['user_role']	= $_POST['user_role'];
					$host['is_completed']	= '1';
					

					$h_extended['about'] 			 = $_POST['about'];
					// $h_extended['language_speaks'] 	 = $_POST['language_speaks'];
					// $h_extended['work'] 			 = $_POST['work'];
					$h_extended['country'] 			 = $_POST['country'];
					$h_extended['state'] 			 = $_POST['state'];
					$h_extended['city'] 			 = $_POST['city'];
					$h_extended['identity_verified'] = 0;
					$h_extended['mobile_verified'] 	 = 0;
					$h_extended['email_verified'] 	 = 0;

					(@$_POST['identity_verified']) ? $h_extended['identity_verified'] = '1' : '' ;
					(@$_POST['mobile_verified']) ? $h_extended['mobile_verified'] = '1' : '' ;
					(@$_POST['email_verified']) ? $h_extended['email_verified'] = '1' : '' ;
					
					

					// $this->pr($_POST);

					
					if ($id!=null) {
						$row = $this->model->getRow('usermaster',['id'=>$id]);
						$config['file_name'] = rand(10000, 10000000000);
						$config['upload_path'] = UPLOAD_PATH.'users/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if (!empty($_FILES['photo']['name'])) {
							$_FILES['photos']['name'] = $_FILES['photo']['name'];
							$_FILES['photos']['type'] = $_FILES['photo']['type'];
							$_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
							$_FILES['photos']['size'] = $_FILES['photo']['size'];
							$_FILES['photos']['error'] = $_FILES['photo']['error'];
							if ($this->upload->do_upload('photos')) {
								$image_data = $this->upload->data();
								$fileName = "users/" . $image_data['file_name'];
							}
						  $host['pic'] = $fileName;
						}else{
						$host['pic'] = @$row->pic;
						} 
						if($this->model->Update('usermaster',$host,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit User from Usermaster');
							$this->model->Update('usermaster_extended',$h_extended,['usermaster_id'=>$id]);
							logs($user->id,$id,'EDIT','Edit User Extended from Usermaster Extended');
							$saved = 1;
						}
					}
					else{
						$config['file_name'] = rand(10000, 10000000000);
						$config['upload_path'] = UPLOAD_PATH.'users/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if (!empty($_FILES['photo']['name'])) {
							$_FILES['photos']['name'] = $_FILES['photo']['name'];
							$_FILES['photos']['type'] = $_FILES['photo']['type'];
							$_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
							$_FILES['photos']['size'] = $_FILES['photo']['size'];
							$_FILES['photos']['error'] = $_FILES['photo']['error'];
							if ($this->upload->do_upload('photos')) {
								$image_data = $this->upload->data();
								$fileName = "users/" . $image_data['file_name'];
							}
						  $host['pic'] = $fileName;
						}else{
						$host['pic'] = 'users/default.jpg';
						} 
						if($id = $this->model->SaveGetId('usermaster',$host)){
							logs($user->id,$id,'ADD','Add User  from Usermaster ');
							$h_extended['usermaster_id'] = $id;
							$usermaster_extended=$this->model->Save('usermaster_extended',$h_extended);
							logs($user->id,$usermaster_extended,'EDIT','Edit User Extended from Usermaster Extended');
							$saved = 1;
						}
					}

					if ($saved == 1 ) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
				}
				echo json_encode($return);
				break;

				case 'delete':
					// $return['res'] = 'error';
					// $return['msg'] = 'Not Deleted!';
					// if ($this->model->Delete('website_properties',['id'=>$id])) {
					// 	$return['res'] = 'success';
					// 	$return['msg'] = 'Deleted Successfully.';
					// }
					// echo json_encode($return);	
				break;

			}
	}
	public function remote($type,$id=null,$column='name')
    {
        if ($type=='usermaster') {
            $tb = 'usermaster';
        }
        else{

        }
        $this->db->where($column,$_GET[$column]);
        if($id!=NULL){
            $this->db->where('id != ',$id)->where('is_deleted','NOT_DELETED');
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
	public function approval_status_change()
	{
		$data['user']  = $user  = $this->checkLogin();
		 $id = $_POST['id'];
		 $remark = $_POST['remark'];
		$status = array('remark'=>$_POST['remark']);
		$table = 'propmaster';
		if($this->model->Update($table,$status,['id'=>$id])){
			logs($user->id,$id,'CHANGE_STATUS','Change Status Propmaster By Admin '.$table.$status);
			echo 'success';
		}else
		{
			echo 'error';
		}

	}
}
