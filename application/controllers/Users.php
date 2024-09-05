<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Users extends Main {

	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function user($action=null,$id=null)
	{
		$data['user']  =$user  = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] = 'Users';
				$data['contant'] = 'users/users/index';
				$data['tb_url']	  =  base_url().'user/tb';
				$data['new_url']	  =  base_url().'user/create';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	  = 'users/users/tb';
				$data['update_url']	  =  base_url().'user/create/';
				$data['delete_url']	  =  base_url().'user/delete/';
				
				$data['rows'] = $this->model->getData('tb_admin',0,'asc','name');

				// $this->pr($data);
				load_view($data['contant'],$data);
				break;

			

			case 'create':
				$data['contant'] = 'users/users/create';
				$data['action_url']	  =  base_url().'user/save';
				$data['user_role']  = $this->model->getData('tb_user_role',0,'asc','name');
				if ($id!=null) {
					$data['action_url']	  =  base_url().'user/save/'.$id;
					$data['row'] = $this->model->getRow('tb_admin',['id'=>$id]);
				}
				load_view($data['contant'],$data);

				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {

					// $this->pr($_POST);

					
					if ($id!=null) {
						$row = $this->model->getRow('tb_admin',['id'=>$id]);
						if($this->model->Update('tb_admin',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Users  By Admin');
							$saved = 1;
						}
					}
					else{
						if($id = $this->model->SaveGetId('tb_admin',$_POST)){
							logs($user->id,$id,'ADD','Add Users  By Admin');
							$saved = 1;
						}
					}

					if ($saved == 1 ) {
						$file_name = 'photo';
						if (@$_FILES[$file_name]['name']) {
						$directory = '../../public/uploads/user-images/';
						if (base_url()=='http://localhost/mrs/') {
							$directory = 'public/uploads/user-images/';
						}
						$config['upload_path']          = $directory;
               			$config['allowed_types'] 		= '*';
		                $config['remove_spaces']        = TRUE;
			            $config['encrypt_name']         = TRUE;
			            $config['max_filename']         = 20;
			            $this->load->library('upload', $config);
			            if($this->upload->do_upload($file_name)){
			            	$upload_data = $this->upload->data();
			            	$img['photo']  = img_base_url().'public/uploads/user-images/'.$upload_data['file_name'];
			            	if($this->model->Update('tb_admin',$img,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Users  image By Admin');
				            	if (@$row) {
				            		if(@$row->pic!=''){
				            			if (base_url()=='http://localhost/mrs/') {
										unlink($row->pic);
										}
										else{
											unlink('../../'.$row->pic);
										}
				            		}
								}
							}
			            }
					}
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
				}
				echo json_encode($return);
				break;

				case 'delete':
					if($this->db->delete('tb_admin', ['id' => $id]))
					{
						$return['res'] = 'success';
						$return['msg'] = 'Deleted.';
					}
					echo json_encode($return);
					break;

			}
	}

	public function admin_menu($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] = 'Admin Menu';
				$data['contant'] = 'users/admin_menu/index';
				$data['tb_url']	  =  base_url().'admin_menu/tb';
				$data['new_url']	  =  base_url().'admin_menu/create';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	  = 'users/admin_menu/tb';
				$data['update_url']	  =  base_url().'admin_menu/create/';
				$data['delete_url']	  =  base_url().'admin_menu/delete/';
				$data['rows']		= $this->model->admin_menus();
				// $this->pr($data);
				load_view($data['contant'],$data);
				break;

			case 'create':
				$data['title'] 		  = 'New Admin Menu';
				$data['contant']      = 'users/admin_menu/create';
				$data['action_url']	  =  base_url().'admin_menu/save';
				if ($id!=null) {
					$data['action_url']	  =  base_url().'admin_menu/save/'.$id;
					$data['row'] = $this->model->getRow('tb_admin_menu',['id'=>$id]);
				}
				$data['menus']   = $this->model->admin_menus('');
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('tb_admin_menu',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Admin Menu By Admin');
							$saved = 1;
						}
					}
					else{
						if($id=$this->model->Save('tb_admin_menu',$_POST)){
							logs($user->id,$id,'ADD','Add Admin Menu By Admin');
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
					if($this->db->delete('tb_admin_menu', ['id' => $id]))
					{
						$return['res'] = 'success';
						$return['msg'] = 'Deleted.';
					}
					echo json_encode($return);
					break;
			default:
				// code...
				break;
		}
		

		// $this->pr($data);
		// $this->template($data);
	}


	public function user_role($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] = 'User Role';
				$data['contant'] = 'users/user_role/index';
				$data['tb_url']	  =  base_url().'user_role/tb';
				$data['new_url']	  =  base_url().'user_role/create';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	  = 'users/user_role/tb';
				$data['update_url']	  =  base_url().'user_role/create/';
				$data['delete_url']	  =  base_url().'user_role/delete/';
				$data['m_access_url'] =  base_url().'user_role/menu_access/';
				$data['rows']		  = $this->model->getData('tb_user_role',['host_id ='=>NULL]);
				// $this->pr($data);
				load_view($data['contant'],$data);
				break;

			case 'create':
				$data['title'] 		  = 'User Role';
				$data['contant']      = 'users/user_role/create';
				$data['action_url']	  =  base_url().'user_role/save';
				if ($id!=null) {
					$data['action_url']	  =  base_url().'user_role/save/'.$id;
					$data['row'] = $this->model->getRow('tb_user_role',['id'=>$id]);
				}
				$data['menus']   = $this->model->admin_menus('');
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('tb_user_role',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit User Role By Admin');
							$saved = 1;
						}
					}
					else{
						if($id=$this->model->Save('tb_user_role',$_POST)){
							logs($user->id,$id,'ADD','Add User Role By Admin');
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

			case 'menu_access':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					// $this->pr($_POST);

					$menu_id    = $_POST['m_id'];
					$type   	= $_POST['type'];
					$role_id    = $id;
					$row = $this->model->getRow('tb_admin_menu',['id'=>$menu_id]);
					if($row){
						$check['role_id']   = $role_id;
						$check['menu_id'] 	= $menu_id;
						$value = 0;
						if ($type=='set'){
							$value = 1;
						}
						// $update['propmasterid'] 	= $p_id;

						if ($type=='set' && $_POST['name']=='') {
							
							if($this->model->getRow('tb_role_menus',$check)){
								if ($this->model->Update('tb_role_menus',$update,$check)) {
									logs($user->id,$role_id,'EDIT','Assign User Role');
									$saved = 1;
								}
							}
							else{
								if ($this->model->Save('tb_role_menus',$check)) {
									logs($user->id,$role_id,'EDIT','Assign User Role');
									$saved = 1;
								}
							}
						}
						else if($_POST['name']!=''){
							$update[$_POST['name']] = $value;
							if($this->model->getRow('tb_role_menus',$check)){
								if ($this->model->Update('tb_role_menus',$update,$check)) {
									logs($user->id,$role_id,'EDIT','Assign User Role');
									$saved = 1;
								}
							}
							else{
								$return['msg'] = 'Menu Not Assigned!';
							}
						}
						else{
							if ($this->model->Delete('tb_role_menus',$check)) {
								logs($user->id,$role_id,'EDIT','Assign User Role');
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
					$page     = 'users/user_role/menu_access';
					$data['m_access_url'] =  base_url().'users/user_role/menu_access/';

					$menus   = $this->model->admin_menus('');
					$data['role_id'] = $role_id = $id;
					if ($menus) {
						foreach ($menus as $row) {
							$row->checked = '';
							$row->c_checked = '';
							$row->u_checked = '';
							$row->d_checked = '';
							if ($t = $this->model->getRow('tb_role_menus',['menu_id'=>$row->id,'role_id'=>$role_id])) {
								$row->checked = 'checked';
							}
							if (@$t->add==1) {
								$row->c_checked = 'checked';
							}
							if (@$t->update==1) {
								$row->u_checked = 'checked';
							}
							if (@$t->delete==1) {
								$row->d_checked = 'checked';
							}
						}
					}

					// $this->pr($menus);
					$data['menus']  = $menus;
					load_view($page,$data);
				}
				break;

			
			default:
				// code...
				break;
		}
		

		// $this->pr($data);
		// $this->template($data);
	}

	public function host_roles($action=null,$id=null)
	{
		$data['user'] 	=$user	= $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] = 'host Role';
				$data['contant'] = 'users/user_role/index';
				$data['tb_url']	  =  base_url().'host-roles/tb';
				$data['new_url']	  =  base_url().'host-roles/create';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	  = 'users/user_role/tb';
				$data['update_url']	  =  base_url().'host-roles/create/';
				$data['delete_url']	  =  base_url().'host-roles/delete/';
				$data['m_access_url'] =  base_url().'host-roles/menu_access/';
				$data['rows']		  = $this->model->getData('tb_user_role',['host_id ='=>$user->id]);
				// $this->pr($data);
				load_view($data['contant'],$data);
				break;

			case 'create':
				$data['title'] 		  = 'User Role';
				$data['contant']      = 'users/user_role/create';
				$data['action_url']	  =  base_url().'host-roles/save';
				if ($id!=null) {
					$data['action_url']	  =  base_url().'host-roles/save/'.$id;
					$data['row'] = $this->model->getRow('tb_user_role',['id'=>$id]);
				}
				$data['menus']   = $this->model->admin_menus('');
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$_POST['host_id']=$user->id;
					if ($id!=null) {
						if($this->model->Update('tb_user_role',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit User Role By Admin');
							$saved = 1;
						}
					}
					else{
						if($id=$this->model->Save('tb_user_role',$_POST)){
							logs($user->id,$id,'ADD','Add User Role By Admin');
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

			case 'menu_access':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					// $this->pr($_POST);

					$menu_id    = $_POST['m_id'];
					$type   	= $_POST['type'];
					$role_id    = $id;
					$row = $this->model->getRow('tb_admin_menu',['id'=>$menu_id]);
					if($row){
						$check['role_id']   = $role_id;
						$check['menu_id'] 	= $menu_id;
						$value = 0;
						if ($type=='set'){
							$value = 1;
						}
						// $update['propmasterid'] 	= $p_id;

						if ($type=='set' && $_POST['name']=='') {
							
							if($this->model->getRow('tb_role_menus',$check)){
								if ($this->model->Update('tb_role_menus',$update,$check)) {
									logs($user->id,$role_id,'EDIT','Assign User Role');
									$saved = 1;
								}
							}
							else{
								if ($this->model->Save('tb_role_menus',$check)) {
									logs($user->id,$role_id,'EDIT','Assign User Role');
									$saved = 1;
								}
							}
						}
						else if($_POST['name']!=''){
							$update[$_POST['name']] = $value;
							if($this->model->getRow('tb_role_menus',$check)){
								if ($this->model->Update('tb_role_menus',$update,$check)) {
									logs($user->id,$role_id,'EDIT','Assign User Role');
									$saved = 1;
								}
							}
							else{
								$return['msg'] = 'Menu Not Assigned!';
							}
						}
						else{
							if ($this->model->Delete('tb_role_menus',$check)) {
								logs($user->id,$role_id,'EDIT','Assign User Role');
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
					$page     = 'users/user_role/menu_access';
					$data['m_access_url'] =  base_url().'host-roles/menu_access/';

					$menus   = $this->model->admin_menus('');
					$data['role_id'] = $role_id = $id;
					if ($menus) {
						foreach ($menus as $row) {
							$row->checked = '';
							$row->c_checked = '';
							$row->u_checked = '';
							$row->d_checked = '';
							if ($t = $this->model->getRow('tb_role_menus',['menu_id'=>$row->id,'role_id'=>$role_id])) {
								$row->checked = 'checked';
							}
							if (@$t->add==1) {
								$row->c_checked = 'checked';
							}
							if (@$t->update==1) {
								$row->u_checked = 'checked';
							}
							if (@$t->delete==1) {
								$row->d_checked = 'checked';
							}
						}
					}

					// $this->pr($menus);
					$data['menus']  = $menus;
					load_view($page,$data);
				}
				break;

			
			default:
				// code...
				break;
		}
		

		// $this->pr($data);
		// $this->template($data);
	}


	public function company_billing_info($action=null,$id=null)
	{
		$data['user']  =$user  = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Company Billing Information';
				$data['contant']    = 'users/company_billing_info/index';
				$data['new_url']    = base_url().'company-billing-info/create';
				$data['tb_url']	    = base_url().'company-billing-info/tb';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
				$config = array();
		        $config["base_url"] = base_url()."company-billing-info/tb";
		        $config["total_rows"]  = count($this->model->getData('company_billing_info'));
		        $data['total_rows']    = $config["total_rows"];
		        $config["per_page"]    = 20;
		        $config["uri_segment"] = 3;
		        $config['attributes']  = array('class' => 'pag-link');
		        $this->pagination->initialize($config);
		        $data["links"]   = $this->pagination->create_links();
				$data['page']    = $page = ($id!=null) ? $id : 0;
				$data['contant'] 	= 'users/company_billing_info/tb';
				$data['rows']    =  $this->model->getData('company_billing_info',0,'','',$config["per_page"],$page);
				$data['update_url'] = base_url().'company-billing-info/create/';
				$data['delete_url']	= base_url('company-billing-info/delete/');
				load_view($data['contant'],$data);
				
				break;

			case 'create':
				$data['contant']        = 'users/company_billing_info/create';
				if ($id!=null) {
					$data['contant']        = 'users/company_billing_info/update';
					$data['action_url'] = base_url().'company-billing-info/save/'.$id;
					$data['row'] 		=  $this->model->getRow('company_billing_info',['id'=>$id]);
					$data['form_class'] = 'reload-page';
				}else{
					$data['action_url'] 	= base_url().'company-billing-info/save';
					$data['form_class'] = '';
				}
				load_view($data['contant'],$data);
				break;


				case 'save':
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!';
				
					if ($this->input->server('REQUEST_METHOD') == 'POST') {
						$config['file_name'] = rand(10000, 10000000000);
						$config['upload_path'] = UPLOAD_PATH . 'company_logo/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
				
						if ($id != null) {
							if (!empty($_FILES['logo']['name'])) {
								$_FILES['logos']['name'] = $_FILES['logo']['name'];
								$_FILES['logos']['type'] = $_FILES['logo']['type'];
								$_FILES['logos']['tmp_name'] = $_FILES['logo']['tmp_name'];
								$_FILES['logos']['size'] = $_FILES['logo']['size'];
								$_FILES['logos']['error'] = $_FILES['logo']['error'];
				
								if ($this->upload->do_upload('logos')) {
									$image_data = $this->upload->data();
									$fileName = "company_logo/" . $image_data['file_name'];
									$datas['logo'] = $fileName;
								}
							} else {
								$rs = $this->model->getRow('company_billing_info', ['id' => $id]);
								$datas['logo'] = @$rs->logo;
							}
				
							// Update the company details
							$datas['company_name'] = $_POST['company_name'];
							$datas['gst'] = $_POST['gst'];
							$datas['email'] = $_POST['email'];
							$datas['contact'] = $_POST['contact'];
							$datas['address'] = $_POST['address'];
				
							if ($this->model->Update('company_billing_info', $datas, ['id' => $id])) {
								logs($user->id, $id, 'EDIT', 'Edit Company billing information');
								$return['res'] = 'success';
								$return['msg'] = 'Saved.';
							}
						} else {
							$existingCompany = count($this->model->getData('company_billing_info', [
								'active' => '1',
								'is_deleted' => 'NOT_DELETED',
							]));
				
							if ($existingCompany > 0) {
								$return['res'] = 'error';
								$return['msg'] = 'Company details already exist. Not creating new details, only update allowed.';
							} else {
								if (!empty($_FILES['logo']['name'])) {
									$_FILES['logos']['name'] = $_FILES['logo']['name'];
									$_FILES['logos']['type'] = $_FILES['logo']['type'];
									$_FILES['logos']['tmp_name'] = $_FILES['logo']['tmp_name'];
									$_FILES['logos']['size'] = $_FILES['logo']['size'];
									$_FILES['logos']['error'] = $_FILES['logo']['error'];
				
									if ($this->upload->do_upload('logos')) {
										$image_data = $this->upload->data();
										$fileName = "company_logo/" . $image_data['file_name'];
										$datas['logo'] = $fileName;
									}
								} else {
									$datas['logo'] = 'company_logo/default.jpg';
								}
				
								// Set company details for insertion
								$datas['company_name'] = $_POST['company_name'];
								$datas['gst'] = $_POST['gst'];
								$datas['email'] = $_POST['email'];
								$datas['contact'] = $_POST['contact'];
								$datas['address'] = $_POST['address'];
								if ($id = $this->model->Save('company_billing_info', $datas)) {
									logs($user->id, $id, 'ADD', 'Add Company billing information');
									$return['res'] = 'success';
									$return['msg'] = 'Saved.';
								}
							}
						}
					}
					echo json_encode($return);
					break;
						

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('company_billing_info',['id'=>$id])){
						logs($user->id,$id,'DELETE','Delete Company billing information');
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

	
	


}
