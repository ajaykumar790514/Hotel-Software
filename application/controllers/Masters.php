<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Masters extends Main {

	// Start::reviews_source_master 
	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function reviews_source($action=null,$id=null)
	{
		$data['user'] =$user   = $this->checkLogin();
		switch ($action) {
			case null:
					$data['title']      = 'Reviews Source Master';
					$data['contant']    = 'masters/reviews_source';
					$data['tb_url']	    =  base_url().'reviews_source/tb';
					$this->template($data);
				break;

			case 'tb':
				$data['contant'] = 'masters/tb_reviews_source';
				$data['rows']    =  $this->model->getData('reviews_source_master',0,'asc','name');
				load_view($data['contant'],$data);
				break;

			case 'new':
				$data['title']     = 'Reviews Source Master';
				$data['contant']   = 'masters/new_reviews_source';
				$this->template($data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('reviews_source_master',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Reviews Source Master By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($insert_id=$this->model->Save('reviews_source_master',$_POST)) {
							logs($user->id,$insert_id,'ADD','Add Reviews Source Master By Admin');
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
	// End::reviews_source_master 

	// Start::sleeping_arrangements_master 
	public function sleeping_arr_title($action=null,$id=null)
	{
		$data['user']  =$user  = $this->checkLogin();
		switch ($action) {
			case null:
					$data['title']      = 'Sleeping Arrangements';
					$data['contant']    = 'masters/sleeping_arr/title/index';
					$data['new_url']    = base_url().'sleeping_title_master/save';
					$data['tb_url']	    = base_url().'sleeping_title_master/tb';
					$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	= 'masters/sleeping_arr/title/tb';
				$data['update_url'] = base_url().'sleeping_title_master/save/';
				$data['rows']    	=  $this->model->getData('sleeping_title_master',0,'asc','title');
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('sleeping_title_master',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Sleeping Arrangements By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($insert_id=$this->model->Save('sleeping_title_master',$_POST)) {
							logs($user->id,$insert_id,'ADD','Add Sleeping Arrangements By Admin');
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

	public function sleeping_arr_desc($action=null,$id=null)
	{
		$data['user'] =$user   = $this->checkLogin();
		switch ($action) {
			case null:
					$data['title']      = 'Sleeping Arrangements';
					$data['contant']    = 'masters/sleeping_arr/desc/index';
					$data['new_url']    = base_url().'sleeping_desc_master/save';
					$data['tb_url']	    = base_url().'sleeping_desc_master/tb';
					$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	= 'masters/sleeping_arr/desc/tb';
				$data['update_url'] = base_url().'sleeping_desc_master/save/';
				$data['rows']    	=  $this->model->getData('sleeping_master',0,'asc','title');
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('sleeping_master',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Sleeping Arrangements Desc  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($insert_id=$this->model->Save('sleeping_master',$_POST)) {
							logs($user->id,$insert_id,'ADD','Add Sleeping Arrangements Desc  By Admin');
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

	// End::sleeping_arrangements_master

	// Start::broadband_masters 
	public function broadband_master($action=null,$id=null)
	{
		$data['user']  =$user  = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Broadband';
				$data['contant']    = 'masters/broadband/index';
				$data['new_url']    = base_url().'broadband_master/create';
				$data['tb_url']	    = base_url().'broadband_master/tb';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	= 'masters/broadband/tb';
				$data['update_url'] = base_url().'broadband_master/create/';
				$data['rows']    	=  $this->model->getData('broadband_master',0,'asc','name');
				load_view($data['contant'],$data);
				break;

			case 'create':
				$data['contant']        = 'masters/broadband/create';
				if ($id!=null) {
					$data['action_url'] = base_url().'broadband_master/save/'.$id;
					$data['row']    	=  $this->model->getRow('broadband_master',['id'=>$id]);

				}
				else{
					$data['action_url'] = base_url().'broadband_master/save';
				}

				load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('broadband_master',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Broadband  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($insert_id=$this->model->Save('broadband_master',$_POST)) {
							logs($user->id,$insert_id,'ADD','Add Broadband  By Admin');
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

	// End::broadband_masters 

	// Start::location_master 
	public function location_master($action=null,$id=null)
	{
		$data['user'] =$user   = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Locations';
				$data['contant']    = 'masters/location/index';
				$data['new_url']    = base_url().'location_master/create';
				$data['tb_url']	    = base_url().'location_master/tb';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
				$config = array();
		        $config["base_url"] = base_url()."location_master/tb";

		        $data['search'] = '';
		        if (@$_POST['search']) {
		        	$data['search'] = $s = $_POST['search'];
		        	$this->db->like('name',$s );
					$this->db->or_like('loc_name', $s);
					$this->db->or_like('city', $s);
					$this->db->or_like('state', $s);
					$this->db->or_like('country', $s);
		        }
		        $config["total_rows"]  = count($this->model->getData('location'));
		        $data['total_rows']    = $config["total_rows"];
		        $config["per_page"]    = 20;
		        $config["uri_segment"] = 3;
		        $config['attributes']  = array('class' => 'pag-link');
		        $this->pagination->initialize($config);
		        $data["links"]   = $this->pagination->create_links();

				$data['page']    = $page = ($id!=null) ? $id : 0;
				$data['contant'] 	= 'masters/location/tb';
				if (@$_POST['search']) {
					$s = $_POST['search'];
		        	$this->db->like('name',$s );
					$this->db->or_like('loc_name', $s);
					$this->db->or_like('city', $s);
					$this->db->or_like('state', $s);
					$this->db->or_like('country', $s);
				}
				$data['rows']    =  $this->model->getData('location',0,'asc','indexing',$config["per_page"],$page);
				$data['update_url'] = base_url().'location_master/create/';
				$data['route_url']  = base_url().'location_master/route/';
				load_view($data['contant'],$data);
				
				break;

			case 'create':
				$data['contant']        = 'masters/location/create';
				$data['back_url']    = base_url().'location_master';
				$data['form_class'] = '';
				if ($id!=null) {
					$data['action_url'] = base_url().'location_master/save/'.$id;
					$data['row'] = $row =  $this->model->getRow('location',['id'=>$id]);
					$data['states']     = $this->getStates(101,$row->state_id,true);
					$data['cities']     = $this->getCities($row->state_id,$row->cityid,true);
					$data['form_class'] = 'reload-page';
				}
				else{
					$data['states']     = $this->getStates(101,null,true);
					$data['action_url'] = base_url().'location_master/save';
				}
				$this->template($data);
				// load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$_POST['city'] = title('cities',$_POST['cityid']);
					$_POST['state'] = title('states',$_POST['state_id']);
					
					if ($id!=null) {
						$row = $this->model->getRow('location',['id'=>$id]);
						if($this->model->Update('location',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Locations  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($insert_id = $this->model->Save('location',$_POST)) {
							logs($user->id,$insert_id,'ADD','Add Locations  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}

					$file_name = 'image';
					if (@$_FILES[$file_name]['name']) {
						
						$config['upload_path']          = UPLOAD_PATH.'location-images/';
               			$config['allowed_types'] 		= '*';
		                $config['remove_spaces']        = TRUE;
			            $config['encrypt_name']         = TRUE;
			            $config['max_filename']         = 20;
			            $this->load->library('upload', $config);
			            if($this->upload->do_upload($file_name)){								
								
			            	$upload_data = $this->upload->data();
			            	$img['image']  = 'location-images/'.$upload_data['file_name'];
			            	if($this->model->Update('location',$img,['id'=>$id])){
								logs($user->id,$id,'EDIT','Edit Image Locations  By Admin');
				            	if (@$row) {
				            		if(@$row->image!=''){				            			
										unlink(UPLOAD_PATH.$row->image);
				            		}
								}
							}
			            }
					}

				
				// $directory = 'public/uploads/property-images/';
				}
				echo json_encode($return);
				break;
				
			case 'route':
				$return['res'] = 'error';
				$return['msg'] = 'Someting Worng!';
				$type = $_POST['type'];
				$row = $this->model->getRow('location',['id'=>$id]);
				if ($type=='set') {
					$this->model->Update('location',['is_route'=>0],['cityid'=>$row->cityid]);
					if ($this->model->Update('location',['is_route'=>1],['id'=>$id])) {
						logs($user->id,$id,'ADD','Route Set Locations  By Admin');
						$return['res'] = 'success';
						$return['msg'] = 'Route Set Successfully.';
					}
				}
				else{
					if ($this->model->Update('location',['is_route'=>0],['id'=>$row->id])) {
						logs($user->id,$row->id,'DELETE','Route Removed Locations  By Admin');
						$return['res'] = 'success';
						$return['msg'] = 'Route Removed Successfully.';
					}
				}
				// echo json_encode($return);
				echo json_encode($return);
				break;
			
			default:
				# code...
				break;
		}
	}
	// End::location_master 

	// Start::district_master 
	public function district_master($action=null,$id=null)
	{
		$data['user']=$user    = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'District';
				$data['contant']    = 'masters/district/index';
				$data['new_url']    = base_url().'district_master/create';
				$data['tb_url']	    = base_url().'district_master/tb';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
				$config = array();
		        $config["base_url"] = base_url()."district_master/tb";

		        $data['search'] = '';
		        if (@$_POST['search']) {
		        	$data['search'] = $s = $_POST['search'];
		        	$this->db->like('name',$s );
					$this->db->or_like('loc_name', $s);
					$this->db->or_like('city', $s);
					$this->db->or_like('state', $s);
					$this->db->or_like('country', $s);
		        }
		        $config["total_rows"]  = count($this->model->getData('district_master'));
		        $data['total_rows']    = $config["total_rows"];
		        $config["per_page"]    = 20;
		        $config["uri_segment"] = 3;
		        $config['attributes']  = array('class' => 'pag-link');
		        $this->pagination->initialize($config);
		        $data["links"]   = $this->pagination->create_links();

				$data['page']    = $page = ($id!=null) ? $id : 0;
				$data['contant'] 	= 'masters/district/tb';
				if (@$_POST['search']) {
					$s = $_POST['search'];
		        	$this->db->like('name',$s );
					$this->db->or_like('loc_name', $s);
					$this->db->or_like('city', $s);
					$this->db->or_like('state', $s);
					$this->db->or_like('country', $s);
				}
				$data['rows']    =  $this->model->getData('district_master',['is_deleted'=>'NOT_DELETED'],'desc','id',$config["per_page"],$page);
				// print_r($data['rows'][0]->state_id); die;
				// $data['state']     = $this->getStates(101,$data['rows']->state_id,true);
				$data['update_url'] = base_url().'district_master/create/';
				$data['delete_url']	= base_url('district_master/delete/');
				load_view($data['contant'],$data);
				
				break;

			case 'create':
				$data['contant']        = 'masters/district/create';
				$data['back_url']    = base_url().'district_master';
				$data['form_class'] = '';
				if ($id!=null) {
					$data['action_url'] = base_url().'district_master/save/'.$id;
					$data['row'] = $row =  $this->model->getRow('district_master',['id'=>$id]);
					$data['states']     = $this->getStates(101,$row->state_id,true);
					//$data['cities']     = $this->getCities($row->state_id,$row->cityid,true);
					$data['form_class'] = 'reload-page';
				}
				else{
					$data['states']     = $this->getStates(101,null,true);
					$data['action_url'] = base_url().'district_master/save';
				}
				$this->template($data);
				// load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {
					// $_POST['city'] = title('cities',$_POST['cityid']);
					// $_POST['state'] = title('states',$_POST['state_id']);

					$data = array(
						'name'=>$_POST['name'],
						'rot_code'=>$_POST['rot_code'],
						'state_id'=>$_POST['state_id'],
						'active'=>1,
					);
					
					if ($id!=null) {
						$row = $this->model->getRow('district_master',['id'=>$id]);
						if($this->model->Update('district_master',$data,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit District  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($id = $this->model->Save('district_master',$data)) {
							logs($user->id,$id,'ADD','Add District  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}

					// $file_name = 'image';

					// if (@$_FILES[$file_name]['name']) {
					// 	$directory = '../../public/uploads/location-images/';
					// 	if (base_url()=='http://localhost/mrs/') {
					// 		$directory = 'public/uploads/location-images/';
					// 	}
					// 	$config['upload_path']          = $directory;
               		// 	$config['allowed_types'] 		= '*';
		            //     $config['remove_spaces']        = TRUE;
			        //     $config['encrypt_name']         = TRUE;
			        //     $config['max_filename']         = 20;
			        //     $this->load->library('upload', $config);
			        //     if($this->upload->do_upload($file_name)){
			            	
								
								
			        //     	$upload_data = $this->upload->data();
			        //     	$img['image']  = 'public/uploads/location-images/'.$upload_data['file_name'];
			        //     	if($this->model->Update('location',$img,['id'=>$id])){
				    //         	if (@$row) {
				    //         		if(@$row->image!=''){
				    //         			if (base_url()=='http://localhost/mrs/') {
					// 					unlink($row->image);
					// 					}
					// 					else{
					// 						unlink('../../'.$row->image);
					// 					}
				    //         		}
					// 			}
					// 		}
			        //     }
					// }

				
				// $directory = 'public/uploads/property-images/';
				}
				echo json_encode($return);
				break;			

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('district_master',['id'=>$id])){
						$saved = 1;
						logs($user->id,$id,'DELETE','Delete District  By Admin');
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
	// End::district_master 


	// Start::tax_range 
	public function tax_range($action=null,$id=null)
	{
		$data['user']   =$user = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Tax Range';
				$data['contant']    = 'masters/tax_range/index';
				$data['new_url']    = base_url().'tax-range/create';
				$data['tb_url']	    = base_url().'tax-range/tb';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	= 'masters/tax_range/tb';
				$data['update_url'] = base_url().'tax-range/create/';
				$data['rows']    	=  $this->model->getData('tax_range',0,'asc','tax_rate');
				load_view($data['contant'],$data);
				break;

			case 'create':
				$data['contant']        = 'masters/tax_range/create';
				if ($id!=null) {
					$data['action_url'] = base_url().'tax-range/save/'.$id;
					$data['row']    	=  $this->model->getRow('tax_range',['id'=>$id]);

				}
				else{
					$data['action_url'] = base_url().'tax-range/save';
				}

				load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('tax_range',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Tax Range  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($id=$this->model->Save('tax_range',$_POST)) {
							logs($user->id,$id,'ADD','Add Tax Range  By Admin');
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

	public function work_master($action=null,$id=null)
	{
		$data['user']    =$user= $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Work';
				$data['contant']    = 'masters/work/index';
				$data['new_url']    = base_url().'work_master/create';
				$data['tb_url']	    = base_url().'work_master/tb';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
				$config = array();
		        $config["base_url"] = base_url()."work_master/tb";

		        $config["total_rows"]  = count($this->model->getData('work_master'));
		        $data['total_rows']    = $config["total_rows"];
		        $config["per_page"]    = 20;
		        $config["uri_segment"] = 3;
		        $config['attributes']  = array('class' => 'pag-link');
		        $this->pagination->initialize($config);
		        $data["links"]   = $this->pagination->create_links();

				$data['page']    = $page = ($id!=null) ? $id : 0;
				$data['contant'] 	= 'masters/work/tb';
				$data['rows']    =  $this->model->getData('work_master',0,'desc','wm_id',$config["per_page"],$page);
				$data['update_url'] = base_url().'work_master/create/';
				$data['delete_url']	= base_url('work_master/delete/');
				load_view($data['contant'],$data);
				
				break;

			case 'create':
				$data['contant']        = 'masters/work/create';
				
				if ($id!=null) {
					$data['action_url'] = base_url().'work_master/save/'.$id;
					$data['row'] 		=  $this->model->getRow('work_master',['wm_id'=>$id]);
					$data['form_class'] = 'reload-page';
				}else{
					$data['action_url'] 	= base_url().'work_master/save';
					$data['form_class'] = '';
				}
				
				// $this->template($data);
				load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {

					$data = array(
						'work'=>$_POST['work'],
					);
					
					if ($id!=null) {
						if($this->model->Update('work_master',$data,['wm_id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Work  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($id = $this->model->Save('work_master',$data)) {
							logs($user->id,$id,'ADD','Add Work  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}					
				}
				echo json_encode($return);
				break;			

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('work_master',['wm_id'=>$id])){
						logs($user->id,$id,'DELETE','Delete Work  By Admin');
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

	public function language_master($action=null,$id=null)
	{
		$data['user']    = $user=$this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Language';
				$data['contant']    = 'masters/language/index';
				$data['new_url']    = base_url().'language_master/create';
				$data['tb_url']	    = base_url().'language_master/tb';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
				$config = array();
		        $config["base_url"] = base_url()."language_master/tb";

		        $config["total_rows"]  = count($this->model->getData('language_speaks_master'));
		        $data['total_rows']    = $config["total_rows"];
		        $config["per_page"]    = 20;
		        $config["uri_segment"] = 3;
		        $config['attributes']  = array('class' => 'pag-link');
		        $this->pagination->initialize($config);
		        $data["links"]   = $this->pagination->create_links();

				$data['page']    = $page = ($id!=null) ? $id : 0;
				$data['contant'] 	= 'masters/language/tb';
				$data['rows']    =  $this->model->getData('language_speaks_master',0,'desc','lsm_id',$config["per_page"],$page);
				$data['update_url'] = base_url().'language_master/create/';
				$data['delete_url']	= base_url('language_master/delete/');
				load_view($data['contant'],$data);
				
				break;

			case 'create':
				$data['contant']        = 'masters/language/create';
				
				if ($id!=null) {
					$data['action_url'] = base_url().'language_master/save/'.$id;
					$data['row'] 		=  $this->model->getRow('language_speaks_master',['lsm_id'=>$id]);
					$data['form_class'] = 'reload-page';
				}else{
					$data['action_url'] 	= base_url().'language_master/save';
					$data['form_class'] = '';
				}
				
				// $this->template($data);
				load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {

					$data = array(
						'language'=>$_POST['language'],
					);
					
					if ($id!=null) {
						if($this->model->Update('language_speaks_master',$data,['lsm_id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Language  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($id = $this->model->Save('language_speaks_master',$data)) {
							logs($user->id,$id,'ADD','Add Language  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}					
				}
				echo json_encode($return);
				break;			

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('language_speaks_master',['lsm_id'=>$id])){
						logs($user->id,$id,'DELETE','Delete Language  By Admin');
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

	// End::broadband_masters 

	public function property_document($action=null,$id=null)
	{
		$data['user']    =$user= $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Property Document Type';
				$data['contant']    = 'masters/property_document/index';
				$data['new_url']    = base_url().'property_document/create';
				$data['tb_url']	    = base_url().'property_document/tb';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
				$config = array();
		        $config["base_url"] = base_url()."property_document/tb";

		        $config["total_rows"]  = count($this->model->getData('property_doc_type'));
		        $data['total_rows']    = $config["total_rows"];
		        $config["per_page"]    = 20;
		        $config["uri_segment"] = 3;
		        $config['attributes']  = array('class' => 'pag-link');
		        $this->pagination->initialize($config);
		        $data["links"]   = $this->pagination->create_links();

				$data['page']    = $page = ($id!=null) ? $id : 0;
				$data['contant'] 	= 'masters/property_document/tb';
				$data['rows']    =  $this->model->getData('property_doc_type',0,'desc','id',$config["per_page"],$page);
				$data['update_url'] = base_url().'property_document/create/';
				$data['delete_url']	= base_url('property_document/delete/');
				load_view($data['contant'],$data);
				
				break;

			case 'create':
				$data['contant']        = 'masters/property_document/create';
				
				if ($id!=null) {
					$data['action_url'] = base_url().'property_document/save/'.$id;
					$data['row'] 		=  $this->model->getRow('property_doc_type',['id'=>$id]);
					$data['form_class'] = 'reload-page';
				}else{
					$data['action_url'] 	= base_url().'property_document/save';
					$data['form_class'] = '';
				}
				
				// $this->template($data);
				load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {

					$data = array(
						'name'=>$_POST['name'],
					);
					
					if ($id!=null) {
						if($this->model->Update('property_doc_type',$data,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Property Document Type  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($id = $this->model->Save('property_doc_type',$data)) {
							logs($user->id,$id,'ADD','Add Property Document Type  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}					
				}
				echo json_encode($return);
				break;			

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('property_doc_type',['id'=>$id])){
						logs($user->id,$id,'DELETE','Delete Property Document Type Language  By Admin');
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


	public function home_banner($action=null,$id=null)
	{
		$data['user']  =$user = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Home Banner';
				$data['contant']    = 'masters/home_banner/index';
				$data['new_url']    = base_url().'home_banner/create';
				$data['tb_url']	    = base_url().'home_banner/tb';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
				$config = array();
		        $config["base_url"] = base_url()."home_banner/tb";

		        $config["total_rows"]  = count($this->model->getData('home_banner',['is_deleted'=>'NOT_DELETED']));
		        $data['total_rows']    = $config["total_rows"];
		        $config["per_page"]    = 20;
		        $config["uri_segment"] = 3;
		        $config['attributes']  = array('class' => 'pag-link');
		        $this->pagination->initialize($config);
		        $data["links"]   = $this->pagination->create_links();

				$data['page']    = $page = ($id!=null) ? $id : 0;
				$data['contant'] 	= 'masters/home_banner/tb';
				$data['rows']    =  $this->model->getData('home_banner',['is_deleted'=>'NOT_DELETED'],'desc','id',$config["per_page"],$page);
				$data['update_url'] = base_url().'home_banner/create/';
				$data['delete_url']	= base_url('home_banner/delete/');
				load_view($data['contant'],$data);
				
				break;

			case 'create':
				$data['contant']        = 'masters/home_banner/create';
				
				if ($id!=null) {
					$data['action_url'] = base_url().'home_banner/save/'.$id;
					$data['row'] 		=  $this->model->getRow('home_banner',['id'=>$id]);
					$data['form_class'] = 'reload-page';
				}else{
					$data['action_url'] 	= base_url().'home_banner/save';
					$data['form_class'] = '';
				}
				
				// $this->template($data);
				load_view($data['contant'],$data);
				break;

			case 'location':				
				$data =  $this->model->getData('location',['visible_in_website'=>1]);

				foreach($data as $row){
					if ($id == $row->id) {
						$selected = 'selected';
					}else{
						$selected = '';
					}
					echo '<option value="'.$row->id.'" '.$selected.'>'.$row->name.'</option>';
				}				
				break;

			case 'property':
				$data =  $this->model->getData('propmaster',['status'=>1, 'is_deleted'=>'NOT_DELETED']);

				foreach($data as $row){
					if ($id == $row->id) {
						$selected = 'selected';
					}else{
						$selected = '';
					}

					echo '<option value="'.$row->id.'" '.$selected.'>'.$row->propname.'</option>';
				}
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {

					if (@$_FILES['photo']['name']) {
						$upload = $this->_uploadFile('home-banner', 'photo');
						$photo = $upload;
					}else{
						$photo = $_POST['old_photo'];
					}

					$data = array(
						'name'=>$_POST['name'],
						'title'=>$_POST['title'],
						'type'=>$_POST['type'],
						'link_id'=>$_POST['link'],
						'seq'=>$_POST['seq'],
						'photo'=>$photo,
					);
					
					if ($id!=null) {
						if (@$_FILES['photo']['name']) {
							$row = $this->model->getRow('home_banner', ['id'=>$id]);
							if (@$row) {
								if (@$row->photo !='') {
									unlink(UPLOAD_PATH.$row->photo);
								}
							}
						}

						if($this->model->Update('home_banner',$data,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Home Banner  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if ($id = $this->model->Save('home_banner',$data)) {
							logs($user->id,$id,'ADD','Add Home Banner  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}					
				}
				echo json_encode($return);
				break;			

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('home_banner',['id'=>$id])){
						logs($user->id,$id,'DELETE','Delete Home Banner  By Admin');
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
	public function package_master($action=null,$id=null)
	{
		$data['user']  =$user  = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Package Master';
				$data['contant']    = 'masters/package/index';
				$data['new_url']    = base_url().'package/create';
				$data['tb_url']	    = base_url().'package/tb';
				$this->template($data);
				break;

			case 'tb':
				$this->load->library('pagination');
				$config = array();
		        $config["base_url"] = base_url()."package/tb";

		        $config["total_rows"]  = count($this->model->getData('user_packages_master'));
		        $data['total_rows']    = $config["total_rows"];
		        $config["per_page"]    = 20;
		        $config["uri_segment"] = 3;
		        $config['attributes']  = array('class' => 'pag-link');
		        $this->pagination->initialize($config);
		        $data["links"]   = $this->pagination->create_links();

				$data['page']    = $page = ($id!=null) ? $id : 0;
				$data['contant'] 	= 'masters/package/tb';
				$data['rows']    =  $this->model->getData('user_packages_master',0,'asc','seq',$config["per_page"],$page);
				$data['update_url'] = base_url().'package/create/';
				$data['delete_url']	= base_url('package/delete/');
				load_view($data['contant'],$data);
				
				break;

			case 'create':
				$data['contant']        = 'masters/package/create';
				
				if ($id!=null) {
					$data['action_url'] = base_url().'package/save/'.$id;
					$data['row'] 		=  $this->model->getRow('user_packages_master',['id'=>$id]);
					$data['form_class'] = 'reload-page';
				}else{
					$data['action_url'] 	= base_url().'package/save';
					$data['form_class'] = '';
				}
				
				// $this->template($data);
				load_view($data['contant'],$data);
				break;


			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$config['file_name'] = rand(10000, 10000000000);
                    $config['upload_path'] = UPLOAD_PATH.'package/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|webp';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
					if ($id!=null) {
						if (!empty($_FILES['doc']['name'])) {
							//upload images
							$_FILES['docs']['name'] = $_FILES['doc']['name'];
							$_FILES['docs']['type'] = $_FILES['doc']['type'];
							$_FILES['docs']['tmp_name'] = $_FILES['doc']['tmp_name'];
							$_FILES['docs']['size'] = $_FILES['doc']['size'];
							$_FILES['docs']['error'] = $_FILES['doc']['error'];
			
							if ($this->upload->do_upload('docs')) {
								$image_data = $this->upload->data();
								$fileName = "package/" . $image_data['file_name'];
							}
						  $docs=  $data['doc'] = $fileName;
						} else {
						$rs = 	$this->model->getRow('user_packages_master',['id'=>$id]);
							$docs= @$rs->photo;
						}
						$data = array(
							'name'=>$_POST['name'],
							'pic' =>$docs,
							'duration_in_days'=>$_POST['duration_in_days'],
							'price' =>$_POST['price'],
							'no_of_properties'=>$_POST['no_of_properties'],
                            'description'   =>$_POST['description'],
							'gst'   =>$_POST['gst'],
							'min_room'   =>$_POST['min_room'],
							'max_room'   =>$_POST['max_room'],
							'seq'   =>$_POST['seq'],
							'is_promotion'=>$_POST['is_promotion']
						);
						if($this->model->Update('user_packages_master',$data,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Package Master  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if (!empty($_FILES['doc']['name'])) {
							//upload images
							$_FILES['docs']['name'] = $_FILES['doc']['name'];
							$_FILES['docs']['type'] = $_FILES['doc']['type'];
							$_FILES['docs']['tmp_name'] = $_FILES['doc']['tmp_name'];
							$_FILES['docs']['size'] = $_FILES['doc']['size'];
							$_FILES['docs']['error'] = $_FILES['doc']['error'];
			
							if ($this->upload->do_upload('docs')) {
								$image_data = $this->upload->data();
								$fileName = "package/" . $image_data['file_name'];
							}
						  $docs=  $data['doc'] = $fileName;
						} else {
						$docs=  $data['doc']  ='';
						}
						$data = array(
							'name'=>$_POST['name'],
							'pic' =>$docs,
							'duration_in_days'=>$_POST['duration_in_days'],
							'price' =>$_POST['price'],
							'no_of_properties'=>$_POST['no_of_properties'],
                            'description'   =>$_POST['description'],
							'gst'   =>$_POST['gst'],
							'min_room'   =>$_POST['min_room'],
							'max_room'   =>$_POST['max_room'],
							'seq'   =>$_POST['seq'],
							'is_promotion'=>$_POST['is_promotion']
						);
						if ($id = $this->model->Save('user_packages_master',$data)) {
							logs($user->id,$id,'ADD','Add Package Master  By Admin');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}					
				}
				echo json_encode($return);
				break;			

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($id!=null) {
					if($this->model->_delete('user_packages_master',['id'=>$id])){
						logs($user->id,$id,'DELETE','Delete Package Master  By Admin');
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
