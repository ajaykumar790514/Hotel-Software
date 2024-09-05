<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
require_once(APPPATH . 'third_party/razorpay-php-2.9.0/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
require_once(APPPATH . 'third_party/tcpdf/TCPDF/tcpdf.php');
class Properties extends Main {
 
	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function index($action=null,$id=null,)
	{
		$this->checkPlan(@$_COOKIE['property_id']);
		$data['user'] = $user = $this->checkLogin();
		$data['property_id'] = $id;
		switch ($action) {
			case null:
				$data['title'] 		= 'Properties';
				$data['contant']  	= 'properties/properties';
				$data['tb_url']	  	= base_url().'properties/tb';

				if ($user->type=='host') {
					$data['tb_url']	= base_url().'properties/tb_host_pro';
				}
				
				$this->template($data);
				break;
			
			case 'tb':
					$this->load->library('pagination');
					$config = array();
			        $config["base_url"] = base_url()."properties/tb";

			        $data['search'] = '';
			        if (@$_POST['search']) {
			        	$data['search'] = $_POST['search'];
			        }
			        $config["total_rows"]  = count($this->model->propmaster());
			        $data['total_rows']    = $config["total_rows"];
			        $config["per_page"]    = 20;
			        $config["uri_segment"] = 3;
			        $config['attributes']  = array('class' => 'pag-link');
			        $this->pagination->initialize($config);
			        $data["links"]   = $this->pagination->create_links();
					$data['page']    = $page = ($id!=null) ? $id : 0;
					$data['contant'] = 'properties/tb_properties';
					$data['rows']    =  $this->model->propmaster($config["per_page"],$page);
					$data['user_role'] = $user->user_role;
					//$this->pr($data['rows']); die;
					load_view($data['contant'],$data);
				    break;
                    case 'plan-details':
					$data['contant'] = 'properties/plan_details';
					$data['packages'] = $packages = $this->model->get_user_package($id,$user->id);
					load_view($data['contant'],$data);
			        break;	
			        case 'tb_host_pro':
					$this->load->library('pagination');
					$config = array();
			        $config["base_url"] = base_url()."properties/tb";

			        $data['search'] = '';
			        if (@$_POST['search']) {
			        	$data['search'] = $_POST['search'];
			        }
			        $config["total_rows"]  = count($this->model->host_propmaster());
			        $data['total_rows']    = $config["total_rows"];
			    
			        $data["links"]   = '';

					$data['page']    = $page = ($id!=null) ? $id : 0;
					$data['contant'] = 'properties/tb_properties';
					
					$data['rows']    =  $this->model->host_propmaster();

					// $this->pr($data);
					load_view($data['contant'],$data);
				break;

			case 'new':
				$data['user']      = $this->checkLogin();
				$data['title']     = 'Properties';
				$data['type'] 		 = $this->model->getData('property_types',['active'=>1],'asc','name');
				$data['countries'] = $this->model->getData('countries',0,'asc','name');
				$data['document_type'] = $this->model->getData('property_doc_type',['active'=>1]);
				$data['ownership_type'] = $this->model->getData('ownership_type',['active'=>1, 'is_deleted'=>'NOT_DELETED']);
				$data['contant']   = 'properties/new_property';
				$this->template($data);
				break;

			case 'update':
				$data['title']      = 'Update Property';
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
				$data['contant']    = 'properties/update_property';
				// $this->pr($data);
				$this->template($data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if($user->user_role !='4'):
					$return['res'] = 'error';
				   $return['msg'] = 'New Property add only host!.';
					echo json_encode($return);
					die();
					endif;	
					if (@$_FILES['document']['name']) {
						$upload = $this->_uploadFile('property-document','document');
						if ($upload !== false) {
							$_POST['document'] = $upload;
							unset($_POST['old_document']);
							$return['res'] = 'success';
							$return['msg'] = 'File uploaded successfully';
						} else {
							// File upload failed
							$fileerror = "File upload error: " . $this->upload->display_errors();
							$return['res'] = 'error';
							$return['msg'] = $fileerror;
							echo json_encode($return);
						die();
						}		
					}else{
						if (@$_POST['old_document']) {
							$_POST['document'] = $_POST['old_document'];							
						}
						unset($_POST['old_document']);												
					}

					if (@$_FILES['logo']['name']) {
						$config['upload_path']          = UPLOAD_PATH.'property-images/invoice-image/';
						$config['allowed_types'] 		= '*';
				        $config['remove_spaces']        = TRUE;
				        $config['encrypt_name']         = TRUE;
				        $config['max_filename']         = 20;
						$config['max_size']    			= '100';
				        $this->load->library('upload', $config);
				        $this->upload->initialize($config);
				        if($this->upload->do_upload('logo')){
				        	$upload_data = $this->upload->data();
				        	$file_name = 'property-images/invoice-image/'.$upload_data['file_name'];

				        	$config2['image_library']		= 'gd2';
							$config2['source_image'] 		= UPLOAD_PATH.'property-images/invoice-image/'.$upload_data['file_name'];
							$config2['maintain_ratio'] 		= TRUE;
							// $config2['width']         		= 300;
							$config2['new_image']        	= UPLOAD_PATH.'property-images/invoice-image/thumbnail/'.$upload_data['file_name'];
							//$config2['height']       = 50;

							$this->load->library('image_lib', $config2);
							$this->image_lib->initialize($config2);
							$this->image_lib->resize();
							$this->image_lib->clear();
                          $file_img  = 'property-images/invoice-image/'.$upload_data['file_name'];
							// $file_img  = 'property-images/invoice-image/thumbnail/'.$upload_data['file_name'];
							//$file_img_delete  = UPLOAD_PATH.'property-images/invoice-image/'.$upload_data['file_name'];
				        }else{
							$fileerror =  "File upload error".$this->upload->display_errors();
							$return['res'] = 'error';
							$return['msg'] = $fileerror;
							echo json_encode($return);
							die();	
						}
                        if(!empty($file_img)){
						 $_POST['logo'] = $file_img;
					// 	unset($_POST['old_logo']);
					// 	if (!empty($file_img)) {
					// 		unlink($file_img_delete);
					// 	}					
					// }else{
					// 	if (@$_POST['old_logo']) {
					// 		$_POST['logo'] = $_POST['old_logo'];							
					// 	}
					// 	unset($_POST['old_logo']);
					}else
					{
						$rs3 = $this->model->getRow('propmaster',['id'=>$id]);
						$_POST['logo']	 = $rs3->logo;
					}
					
					
					}
					
					///propdoc

					if (@$_FILES['certificate']['name']) {
						$upload = $this->_uploadFile('property-document','certificate');	
						if ($upload !== false) {
							$_POST['certificate'] = $upload;
							unset($_POST['old_certificate']);
							$return['res'] = 'success';
							$return['msg'] = 'File uploaded successfully';
						} else {
							// File upload failed
							$fileerror = "File upload error: " . $this->upload->display_errors();
							$return['res'] = 'error';
							$return['msg'] = $fileerror;
							echo json_encode($return);
						die();
						}		
					}else{
						if (@$_POST['old_certificate']) {
							$_POST['certificate'] = $_POST['old_certificate'];								
						}	
						unset($_POST['old_certificate']);				
					}

					if (@$_FILES['pan_photo']['name']) {
						$upload = $this->_uploadFile('property-document','pan_photo');	
						if ($upload !== false) {
							$_POST['pan_photo'] = $upload;
							unset($_POST['old_pan_photo']);
							$return['res'] = 'success';
							$return['msg'] = 'File uploaded successfully';
						} else {
							// File upload failed
							$fileerror = "File upload error: " . $this->upload->display_errors();
							$return['res'] = 'error';
							$return['msg'] = $fileerror;
							echo json_encode($return);
						die();
						}			
					}else{
						if (@$_POST['old_pan_photo']) {
							$_POST['pan_photo'] = $_POST['old_pan_photo'];							
						}			
						unset($_POST['old_pan_photo']);			
					}

					if (@$_FILES['gst_certificate']['name']) {
						$upload = $this->_uploadFile('property-document', 'gst_certificate');
					if ($upload !== false) {
						$_POST['gst_certificate'] = $upload;
						unset($_POST['old_gst_certificate']);
						$return['res'] = 'success';
						$return['msg'] = 'File uploaded successfully';
					} else {
						// File upload failed
						$fileerror = "File upload error: " . $this->upload->display_errors();
						$return['res'] = 'error';
						$return['msg'] = $fileerror;
						echo json_encode($return);
					die();
					}						
					}else{
						if (@$_POST['old_gst_certificate']) {
							$_POST['gst_certificate'] = $_POST['old_gst_certificate'];							
						}		
						unset($_POST['old_gst_certificate']);				
					}

					// $prop_doc = array(
					// 	'ownership_type'=>$_POST['ownership_type'],
					// 	'certificate'=>@$_POST['certificate'],
					// 	'pan_name'=>$_POST['pan_name'],
					// 	'pan_no'=>$_POST['pan_no'],
					// 	'pan_card'=>@$_POST['pan_photo'],
					// );

					if (@$_POST['is_gst'] == 'YES') {
						$prop_doc['gst_no'] = $_POST['gst_no'];
						$prop_doc['gst_certificate'] = @$_POST['gst_certificate'];
					}				

					unset($_POST['ownership_type']);
					unset($_POST['certificate']);
					unset($_POST['pan_name']);
					unset($_POST['pan_no']);
					unset($_POST['pan_photo']);
					unset($_POST['gst_no']);
					unset($_POST['gst_certificate']);

					if ($id!=null) {
						if (@$_FILES['document']['name']) {
							$row = $this->model->getRow('propmaster',['id'=>$id]);
							if ($row) {
								@unlink(UPLOAD_PATH.$row->document);
							}
						}

						// if (@$_FILES['logo']['name']) {
						// 	$row = $this->model->getRow('propmaster',['id'=>$id]);
						// 	if ($row) {
						// 		if ($row->logo) {
						// 			unlink(UPLOAD_PATH.$row->logo);
						// 		}								
						// 	}
						// }
						$_POST['display'] = 0;
						

						if($this->model->Update('propmaster',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Update Property ');
							if ($this->model->Update('propmaster_document',$prop_doc,['prop_m_id'=>$id])) {
								logs($user->id,$id,'EDIT','Update Property Document');
								$return['res'] = 'success';
								$return['msg'] = 'Saved.';
							}							
						}
					}
					else{
						//$district = $this->model->getRow('district_master',['id'=>$_POST['district']]);
						$rto_code = 'FUNTC00001';//$district->rot_code.'0001';
						$last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('propmaster')->row();
						if ($last_row->propcode) {
							$propcode = $last_row->propcode;
							$propcode++;
						}else{
							$propcode = $rto_code;
						}
						
						$_POST['propcode'] = $propcode;
						// print_r($propcode);
						// die;
						$_POST['approval_status'] = 'Pending';
						if ($insert_id = $this->model->Save('propmaster',$_POST)) {
							logs($user->id,$insert_id,'ADD','Add Property');
							if ($user->type=="host") {
								$propaccess['propmasterid'] 	= $insert_id;
								$propaccess['userid'] 			= $user->id;
								$i=$this->model->Save('propaccess',$propaccess);
								logs($user->id,$i,'ADD','Add Property Access');
							}

							$prop_doc['prop_m_id'] = $insert_id;							

							if ($id=$this->model->Save('propmaster_document',$prop_doc)) {
								logs($user->id,$id,'ADD','Add Property Document');
								$return['res'] = 'success';
								$return['msg'] = 'Property Saved.';
							}

							
						}
					}
				}
				echo json_encode($return);
				break;

			case 'info':
				$page = 'properties/property_info';
				$data['row'] = $row = $this->model->getRow('propmaster',['id'=>$id]);
				$data['type'] 		  = $this->model->getRow('property_types',['pt_id'=>$row->property_type_id]);
				$data['prop_doc'] = $this->model->getRow('propmaster_document',['prop_m_id'=>$id]);
				load_view($page,$data);
				// echo $id.'...................';
				break;

			case 'remark':
				$data['reamrk'] = $this->model->getRow('propmaster',['id'=>$id]);
				$data['action_url'] = base_url().'properties/save_remark/'.$id;
				$page = 'properties/property_remark';
				load_view($page,$data);
				break;

			case 'save_remark':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if($this->model->Update('propmaster',$_POST,['id'=>$id])){
						logs($user->id,$id,'ADD','Save Property Remark');
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';							
					}
				}
				echo json_encode($return);
				break;

			// case 'images':
			// 	$page = 'properties/images';
			// 	$data['type'] = 'properties';
			// 	$data['row'] = $row = $this->model->getRow('propmaster',['id'=>$id]);
			// 	load_view($page,$data);

			// 	break;

			case 'propcode':
				$string = $_POST['title'];
				$string = trim($string);
				$string = preg_replace("/[^a-zA-Z 0-9]+/", "", $string);
				$output = str_replace(' ', '', $string);
				$output = strtoupper($output);
				$output = trim(preg_replace('/-+/', '-', $output), '-');
				$output = substr($output,0,8);
				if($this->model->getRow('propmaster',['propcode'=>$output])){
					$output = $output.'1';
				}
				echo $output;
				break;

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($this->model->_delete('propmaster',$id)) {
					if ($rows = $this->model->getData('property',['propid'=>$id])) {
						foreach ($rows as $row) {
							$this->delete_sub_property($row->flat_id,$response='no');
							logs($user->id,$row->flat_id,'DELETE','Delete Sub Property');
						}
					}
					$return['res'] = 'success';
					$return['msg'] = 'Deleted Successfully.';
				}
				echo json_encode($return);
				break;

			case 'policy':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;				
				$pro_id=$id;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($_POST['p_id']=='select_all') {
						if ($this->subprop_policy_select_all($id,$pro_id)) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
						echo json_encode($return);
						die();
					}
					$p_id   = $_POST['p_id'];
					$type   = $_POST['type'];
					$row = $this->model->getRow('policy',['id'=>$p_id]);
					if($row){
						$check['property_id']   	= $id;
						$check['policy_id'] 		= $p_id;

						$set['property_id']     	= $id;
						$set['policy_id']   		= $p_id;
						$set['policy_type'] 		= $row->policy_type;
						$set['policy_name'] 		= $row->policy_name;

						$update['policy_type'] 	= $row->policy_type;
						$update['policy_name'] 	= $row->policy_name;
						if ($type=='set') {
							
							if($this->model->getRow('propertypolicy',$check)){
								if ($this->model->Update('propertypolicy',$update,$check)) {
									logs($user->id,$p_id,'EDIT','Edit  Property  Policy');
									$saved = 1;
								}
							}
							else{
								if ($p_id=$this->model->Save('propertypolicy',$set)) {
									logs($user->id,$p_id,'ADD','Add  Property Policy');
									$saved = 1;
								}
							}
						}
						else if($type=='data'){
							$update[$_POST['cloumn']] = $_POST['value'];
							if($this->model->getRow('propertypolicy',$check)){
								if ($this->model->Update('propertypolicy',$update,$check)) {
									logs($user->id,$p_id,'EDIT','Edit  Property  Policy');
									$saved = 1;
								}
							}
							else{
								$return['msg'] = 'Policy Not Assigned!';
							}
						}

						else{
							if ($this->model->Delete('propertypolicy',$check)) {
								logs($user->id,$p_id,'DELETE','Delete  Property Policy');
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
					$page     = 'properties/properties_policy';
					$policies = $this->model->getData('policy');
					if ($policies = $this->model->getData('policy')) {
						foreach ($policies as $row) {
							if ($t=$this->model->getRow('propertypolicy',['property_id'=>$id,'policy_id'=>$row->id])) {
								$row->checked = 'checked';
								$row->is_highlighted = $t->is_highlighted;
								$row->highlighted_description = $t->highlighted_description;
							}
							else{
								$row->checked = '';
								$row->is_highlighted = '';
								$row->highlighted_description = '';
							}
						}
					}
					$data['policies']  = $policies;
					load_view($page,$data);
				}
				break;

			case 'activity':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$a_id   = $_POST['a_id'];
					$type   = $_POST['type'];
					$row = $this->model->getRow('property_activity_master',['id'=>$a_id]);
					if($row){
						$check['property_id']   		= $id;
						$check['activity_id'] 		= $a_id;

						$set['property_id']     		= $id;
						$set['activity_id']   		= $a_id;

						$update['activity_id'] 		= $a_id;

						if ($type=='set') {
							
							if($this->model->getRow('property_activity_master_assign',$check)){
								if ($this->model->Update('property_activity_master_assign',$update,$check)) {
									logs($user->id,$a_id,'EDIT','Edit  Property Activity Master ');
									$saved = 1;
								}
							}
							else{
								if ($a_id=$this->model->Save('property_activity_master_assign',$set)) {
									logs($user->id,$a_id,'ADD','Add   Property Activity Master');
									$saved = 1;
								}
							}
						}
						else if($type=='data'){
							$update[$_POST['cloumn']] = $_POST['value'];
							if($this->model->getRow('property_activity_master_assign',$check)){
								if ($this->model->Update('property_activity_master_assign',$update,$check)) {
									logs($user->id,$a_id,'EDIT','Edit  Property Activity Master');
									$saved = 1;
								}
							}
							else{
								$return['msg'] = 'Activity Not Assigned!';
							}
						}
						else{
							if ($this->model->Delete('property_activity_master_assign',$check)) {
								logs($user->id,$a_id,'DELETE','Delete  Property Activity Master ');
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
					$page     = 'properties/properties_activity';
					$activity = $this->model->getData('property_activity_master');
					if ($activity) {
						foreach ($activity as $row) {
							$row->checked = '';
							$row->paidorfree = '';
							$row->price = '';
							if ($ama = $this->model->getRow('property_activity_master_assign',['property_id'=>$id,'activity_id'=>$row->id])) {
								$row->checked = 'checked';
								$row->paidorfree = $ama->paidorfree;
								$row->price = $ama->price;
							}
						}
					}
					$data['activity']  = $activity;
					load_view($page,$data);
				}
				break;

			case 'amenities':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$type   = $_POST['type'];
					if ($_POST['a_id']=='select_all') {
						if ($this->subprop_amenities_select_all($id,$pro_id)) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
						echo json_encode($return);
						die();
					}
					
					$a_id   = $_POST['a_id'];
					$type   = $_POST['type'];
					$row = $this->model->getRow('amenities',['id'=>$a_id]);
					if($row){
						$check['property_id']   			= $id;
						$check['amenitiid'] 		= $a_id;

						$set['property_id']     			= $id;
						$set['amenitiid']   		= $a_id;
						//$set['property_id'] 		= $pro_id;

						$update['amenitiid'] 	= $a_id;

						if ($type=='set') {
							
							if($this->model->getRow('flatamenities',$check)){
								if ($this->model->Update('flatamenities',$update,$check)) {
									logs($user->id,$a_id,'EDIT','Edit  flatamenities ');
									$saved = 1;
								}
							}
							else{
								if ($a_id=$this->model->Save('flatamenities',$set)) {
									logs($user->id,$a_id,'ADD','Add flatamenities ');
									$saved = 1;
								}
							}
						}
						else if($type=='data'){
							$update[$_POST['cloumn']] = $_POST['value'];
							if($this->model->getRow('flatamenities',$check)){
								if ($this->model->Update('flatamenities',$update,$check)) {
									logs($user->id,$a_id,'EDIT','Edit flatamenities ');
									$saved = 1;
								}
							}
							else{
								$return['msg'] = 'Amenity Not Assigned!';
							}
						}
						else{
							if ($this->model->Delete('flatamenities',$check)) {
								logs($user->id,$a_id,'DELETE','Delete flatamenities ');
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
					$page     = 'properties/properties_amenities';
					$amenities = $this->model->getData('amenities');
					if ($amenities) {
						foreach ($amenities as $row) {
							if ($t = $this->model->getRow('flatamenities',['property_id'=>$id,'amenitiid'=>$row->id])) {
								$row->checked = 'checked';
								$row->is_highlighted = $t->is_highlighted;
							}
							else{
								$row->checked = '';
								$row->is_highlighted = '';
							}
						}
					}
					$data['amenities']  = $amenities;
					load_view($page,$data);
				}
				break;			

			case 'broadBand':
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!';
					$saved = 0;
					//$_POST['pro_id']  = $pro_id;
					$_POST['property_id'] = $id;
					$_POST['mobile_networks'] = implode(",",$_POST['mobile_networks']);
					if ($row = $this->model->getRow('property_broadband_arrangement',['property_id'=>$id])) {
						if($this->model->Update('property_broadband_arrangement',$_POST,['id'=>$row->id])){
							logs($user->id,$row->id,'EDIT','Edit  Property Broadband Arrangement ');
							$saved = 1;
						}
					}
					else{
						if ($id=$this->model->Save('property_broadband_arrangement',$_POST)) {
							logs($user->id,$id,'ADD','Add  Property Broadband Arrangement ');
							$saved = 1;
						}
					}
					if ($saved == 1) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
					echo json_encode($return);
				}
				else{
					$page = 'properties/properties_broadBand';
					$data['action_url'] = base_url()."properties/broadBand/$id";
					$data['providers']  =  $this->model->getData('broadband_master',0,'asc','name');
					$data['row']  		= $this->model->getRow('property_broadband_arrangement',['property_id'=>$id]);
					load_view($page,$data);
				}
				break;

			case 'images':
				$page = 'properties/images_th';
				$data['rows'] =$rows = $this->model->getData('propertypic',['propid'=>$id],'asc','indexing');
				// $this->pr($data);

				$data['type'] = 'properties';
				//$data['pro_id'] = $pro_id;
				//$data['flat_id'] = $id;
				load_view($page,$data);
				break;

			case 'saveimg':
				$return['res'] = 'error';
				$return['msg'] = 'Image Not Uploaded!';
				$file_name = 'image';
				$directory = UPLOAD_PATH.'property-images/';				

				$files = $_FILES;

				$count = count($_FILES[$file_name]['name']); // count element 
				for($i=0; $i<$count; $i++):
					$_FILES['userfile']['name']     = $files[$file_name]['name'][$i];
			        $_FILES['userfile']['type']     = $files[$file_name]['type'][$i];
			        $_FILES['userfile']['tmp_name'] = $files[$file_name]['tmp_name'][$i];
			        $_FILES['userfile']['error']    = $files[$file_name]['error'][$i];
			        $_FILES['userfile']['size']     = $files[$file_name]['size'][$i];   
	                $config['upload_path'] 			= $directory;
	                $config['allowed_types'] 		= '*';
	                $config['remove_spaces']        = TRUE;
		            $config['encrypt_name']         = TRUE;
		            $config['max_filename']         = 20;
		            $config['max_size']    			= '100';
	         		$this->load->library('upload', $config);
	         		$this->upload->initialize($config);	         		

	         		if($this->upload->do_upload('userfile')){
	         			$upload_data = $this->upload->data();
		                $img['photo']  = 'property-images/'.$upload_data['file_name'];
		                $img['propid'] = $id;
		                //$img['flatid'] = $id;

		                $config2['image_library']		= 'gd2';
						$config2['source_image'] 		= UPLOAD_PATH.'property-images/'.$upload_data['file_name'];
						$config2['maintain_ratio'] 		= TRUE;
						$config2['width']         		= 300;
						$config2['new_image']        	= UPLOAD_PATH.'property-images/thumbnail/'.$upload_data['file_name'];
						//$config2['height']       = 50;

						$this->load->library('image_lib', $config2);
						$this->image_lib->initialize($config2);
						$this->image_lib->resize();
						$this->image_lib->clear();

						$img['thumbnail']  = 'property-images/thumbnail/'.$upload_data['file_name'];

		                if($id=$this->model->Save('propertypic',$img)){
							logs($user->id,$id,'ADD','Add  Property Pic ');
							$return['res'] = 'success';
							$return['msg'] = 'Image uploaded.';
						} 
	         		}
	         		else{
	         			$error = $this->upload->display_errors();
                        $return['res'] = 'error';
						$return['msg'] = $error;
	         		}
            	endfor;
            	echo json_encode($return);
				break;

			case 'img_details':
				
				$return['res'] = 'error';
				$return['msg'] = 'Someting Worng!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$details = $_POST['details'];
					$id = $_POST['id'];
					
						if ($this->model->Update('propertypic',['details'=>$details],['id'=>$id])) {
							logs($user->id,$id,'EDIT','Edit  Property Pic ');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
				}	
				echo json_encode($return);
				
				break;


			default:
				//echo "kjsdbf";
				break;
		}
		
	}
  
	public function new()
	{
		$data['user'] = $user = $this->checkLogin();
		$this->checkPlan(@$_COOKIE['property_id']);
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$return['res'] = 'error';
			$return['msg'] = 'Property not Saved!';
			if ($this->checkLogin()) {
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					
					if ($id=$this->model->Save('propmaster',$_POST)) {
						logs($user->id,$id,'ADD','Add  Property ');
						$return['res'] = 'success';
						$return['msg'] = 'Property Saved.';
					}
				}
			}
			// echo json_encode($_POST);
			echo json_encode($return);
		}
		else{
			$data['user']      = $this->checkLogin();
			$data['title']     = 'Properties';
			$data['type'] 		 = $this->model->getData('property_types',['active'=>1],'asc','name');
			$data['countries'] = $this->model->getData('countries',0,'asc','name');			
			$data['contant']   = 'properties/new_property';
			$this->template($data);
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
	public function load_locations_new($state=null,$city=null,$selected_location=null){
		$return['res'] = 'error';
		$return['content'] = optionStatus('','-- Select --',1);
			if ($this->input->server('REQUEST_METHOD')=='POST') {
				if ($_POST['state'] && $_POST['city']) {
                    $selected_location = @$_POST['id'];
					$_POST['state'] = title('states',$_POST['state']);
					$_POST['city'] = title('cities',$_POST['city']);
					
					$content = optionStatus('','-- Select --',1);
					unset($_POST['state']);
					$locations = $this->model->getData('location',$_POST);
					foreach ($locations as $row) {
						$selected = '';
				          if ($row->id == $selected_location) {
					      $selected = 'selected';
				           }
						$content .= optionStatus($row->id,$row->name,1,$selected);
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


	public function sub_properties($pro_id,$action=null,$id=null)
	{
		$this->checkPlan(@$_COOKIE['property_id']);
		$data['user']    = $user    = $this->checkLogin();
		$data['pro_id']  = $pro_id;
		$data['flat_id'] = $id;
		$this->checkSubPropertyPlan($user->id,$pro_id,$id);
		switch ($action) {
			case null:
					$data['title']      = 'Rooms';
					$data['contant']    = 'properties/sub_p/sub_properties';
					$data['tb_url']	  =  base_url().'sub_properties/'.$pro_id.'/tb';
					$data['propertyrow']   = $this->model->getRow('propmaster',$pro_id);
					$data['properties'] = $this->model->getData('propmaster',0,'desc');
					$data['properties_type'] = $this->model->getData('sub_property_types',['active'=>1],0,'desc');

					if ($user->type=='host') {
						$data['properties']	= $this->model->host_propmaster();
					}
				
					$this->template($data);
				break;
					
			case 'tb':
					$data['title']      = 'Sub Properties';
					$data['contant']    = 'properties/sub_p/tb_sub_properties';
					$data['property']   = $this->model->getRow('propmaster',['id'=>$pro_id,'is_deleted'=>'NOT_DELETED']);
					
					$data['user_role'] = $user->user_role;
					// if ($id!=null) {
						$data['rows']       = $this->model->getData('property',['propid'=>$pro_id,'sub_property_type_id'=>$id,'is_deleted'=>'NOT_DELETED'],'ASC','flat_no');
					// }else{
					// 	$data['rows']       = $this->model->getData('property',['propid'=>$pro_id,'is_deleted'=>'NOT_DELETED'],'desc','flat_id');
					// }
					load_view($data['contant'],$data);
					
				break;

			case 'new':
					$data['title']      = 'New Rooms';
					$data['contant']    = 'properties/sub_p/new_sub_properties';
					$data['propertyrow']   = $this->model->getRow('propmaster',$pro_id);
					$data['type'] 		 = $this->model->getData('sub_property_types',['property_id'=>$pro_id,'active'=>1],'asc','name');
					$data['row']       = $this->model->getRow('property',['flat_id'=>$id]);
					$this->template($data);
				break;

			case 'update':
				    $data['pro_id']=$pro_id;
					$data['title']      = 'Update Rooms';
					$data['contant']    = 'properties/sub_p/update_sub_properties';
					$data['propmaster']   = $this->model->getRow('propmaster',['id'=>$pro_id]);
					$data['type'] 		  = $this->model->getData('sub_property_types',['active'=>1],'asc','name');
					$data['row']        = $this->model->getRow('property',['flat_id'=>$id]);

					//  $this->pr($data['property']);	
					$this->template($data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {

					$units = $_POST['units'];
					$property_type_id = $_POST['sub_property_type_id'];

					$property_type = $this->model->getData('property',['sub_property_type_id'=>$property_type_id, 'is_deleted'=>'NOT_DELETED']);

					if ($units > count($property_type)) {
						$count_property = ($units - count($property_type));
					}
					elseif($units == count($property_type)){

					}
					else{
						$return['res'] = 'error';
						$return['msg'] = 'Please increase No. of Units';
						echo json_encode($return);
						die;
					}
					

					//print_r($count_property); die;

					$_POST['propid'] = $pro_id;
					if ($id!=null) {
						$plan = $this->db->select('*')->where(['property_id'=>$pro_id,'active'=>'1','user_id'=>$user->id])->get('user_assign_package')->row(); 
						//echo $units ;die();
						$property_type_already =  count($property_type);
						// if(($plan->selected_room-$property_type_already) >= $units ){
						if (!empty($count_property)) {
							$property_type_data = $this->model->getRow('property',['flat_id'=>$id, 'is_deleted'=>'NOT_DELETED']);
							for ($i=0; $i < $count_property; $i++) { 
								unset($property_type_data->flat_id);
								unset($property_type_data->flat_no);
								unset($property_type_data->approval_status);
								if($id=$this->model->Save('property',$property_type_data))
									{
										logs($user->id,$id,'ADD','Add Sub Property ');
										$return['res'] = 'success';
										$return['msg'] = 'Saved.';
									}
								// $this->model->Save('property',$property_type_data);
							}
						}

						$room = $this->model->getRow('property',['flat_id'=>$id]);
						if ($room->flat_no == "") {
							$flat_no_arr = array('flat_no'=>$_POST['flat_no']);
							$this->model->Update('property',$flat_no_arr,['flat_id'=>$id]);
							logs($user->id,$id,'EDIT','Edit Sub Property by flat id ');
							$return['res'] = 'success';
							$return['msg'] = 'Saved Only Room No.';
						}else{
							unset($_POST['flat_no']);
							$_POST['approval_status'] = 'Approved';
							if($this->model->Update('property',$_POST,['sub_property_type_id'=>$property_type_id])){
								logs($user->id,$property_type_id,'EDIT','Edit Sub Property by Property type');
								$return['res'] = 'success';
								$return['msg'] = 'Change in all '.$_POST['flat_name'].' Room';
							}	
						}
					//   }else
					//   {
					// 	$return['link'] = base_url('checkSubProperty/'.$pro_id);
					// 	$return['plan'] = '1';
					// 	$return['res'] = 'error';
					// 	$return['msg'] = 'Sorry Please upgrade your plan than add sub property / room.';
					//   }
						
					}
					else{

						$plan = $this->db->select('*')->where(['property_id'=>$pro_id,'active'=>'1','user_id'=>$user->id])->get('user_assign_package')->row(); 
						
						$property_type_already =  count($property_type);
						// echo $plan ;die();
						if($property_type_already > 0){
						if(($plan->selected_room ? $plan->selected_room : 0 -$property_type_already) >= ($units) ){
									
						// if ($property_type == TRUE) { 
                            
						// 	if (!empty($count_property)) {
						// 		$property_type_data = $this->model->getRow('property',['flat_id'=>$id, 'is_deleted'=>'NOT_DELETED']);
						// 		for ($i=0; $i < $count_property; $i++) { 
						// 			unset($property_type_data->flat_id);
						// 			unset($property_type_data->flat_no);
						// 			unset($property_type_data->approval_status);
						// 			if($this->model->Save('property',$property_type_data))
						// 			{
						// 				$return['res'] = 'success';
						// 				$return['msg'] = 'Saved.';
						// 			}
									
						// 		}														
						// 	}else{
						// 		$return['res'] = 'error';
						// 		$return['msg'] = 'Please increase No. of Units';
						// 		echo json_encode($return);
						// 		die;
						// 	}
						// }else{
							$starting_flat_no = intval($_POST['flat_no']);
							for ($i=0; $i < $units; $i++) { 
								// unset($_POST['flat_no']);
								$_POST['flat_no'] = $starting_flat_no + $i; 
								if($p_id=$this->model->Save('property',$_POST)){
									logs($user->id,$p_id,'ADD','Add Sub Property ');
									$return['res'] = 'success';
									$return['msg'] = 'Saved.';
								}
							// }
						}	
						// echo json_encode($_POST);
					$this->propmaster_s_p_availability($pro_id,$property_type_id);	
				  	}	
					
				   else{
					  $return['link'] =base_url('checkSubProperty/'.$pro_id);
					  $return['plan'] = '1';
					  $return['res'] = 'error';
					  $return['msg'] = 'Sorry Please upgrade your plan than add sub property / room.';
				 			
					}
				}else{
					         $starting_flat_no = intval($_POST['flat_no']);
							for ($i=0; $i < $units; $i++) { 
								// unset($_POST['flat_no']);
								$_POST['flat_no'] = $starting_flat_no + $i; 
								if($p_id=$this->model->Save('property',$_POST)){
									logs($user->id,$p_id,'ADD','Add Sub Property ');
									$return['res'] = 'success';
									$return['msg'] = 'Saved.';
								}
						}	
					$this->propmaster_s_p_availability($pro_id,$property_type_id);
				}
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

			case 'save_remark':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if($this->model->Update('property',$_POST,['flat_id'=>$id])){
						logs($user->id,$id,'ADD','Add Property Remark');
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';							
					}
				}
				echo json_encode($return);
				break;

			case 'images':
				$page = 'properties/sub_p/images_th';
				$data['rows'] =$rows = $this->model->getData('propertypic',['flatid'=>$id, 'is_deleted'=>'NOT_DELETED'],'asc','indexing');
				// $this->pr($data);

				$data['type'] = 'properties';
				$data['pro_id'] = $pro_id;
				$data['flat_id'] = $id;
				load_view($page,$data);
				break;

			case 'saveimgtest':
				$return['res'] = 'error';
				$return['msg'] = 'Image Not Uploaded!';

				$imgdata = $_POST['image'];
				$imgdata = explode(";", $imgdata);
				$imgdata2 = explode(",", $imgdata[1]);
				$imgdata3 = base64_decode($imgdata2[1]);
				$imgname = time() .'.jpg';
				$image_name = '../../public/uploads/property-images/'.$imgname;
				// $image_name = '../../public/uploads/property-images/'. time() .'.jpg';
				file_put_contents($image_name, $imgdata3);
				$img['photo']  = 'public/uploads/property-images/'.$imgname;
                $img['propid'] = $pro_id;
                $img['flatid'] = $id;
                if($idpic=$this->model->Save('propertypic',$img)){
					logs($user->id,$idpic,'ADD','Add Property Pics');
					$return['res'] = 'success';
					$return['msg'] = 'Image uploaded.';
				} 

				echo $image_name;

				// echo json_encode($_POST);
				break;


			case 'saveimg':
				$return['res'] = 'error';
				$return['msg'] = 'Image Not Uploaded!';
				$file_name = 'image';
				$directory = UPLOAD_PATH.'property-images/';				

				$files = $_FILES;

				$count = count($_FILES[$file_name]['name']); // count element 
				for($i=0; $i<$count; $i++):
					$_FILES['userfile']['name']     = $files[$file_name]['name'][$i];
			        $_FILES['userfile']['type']     = $files[$file_name]['type'][$i];
			        $_FILES['userfile']['tmp_name'] = $files[$file_name]['tmp_name'][$i];
			        $_FILES['userfile']['error']    = $files[$file_name]['error'][$i];
			        $_FILES['userfile']['size']     = $files[$file_name]['size'][$i];   
	                $config['upload_path'] 			= $directory;
	                $config['allowed_types'] 		= '*';
	                $config['remove_spaces']        = TRUE;
		            $config['encrypt_name']         = TRUE;
		            $config['max_filename']         = 20;
		            $config['max_size']    			= '100';
	         		$this->load->library('upload', $config);
	         		$this->upload->initialize($config);
	         		
	         		if($this->upload->do_upload('userfile')){
	         			$upload_data = $this->upload->data();
		                $img['photo']  = 'property-images/'.$upload_data['file_name'];
		                //$img['propid'] = $pro_id;
		                $img['flatid'] = $id;

		                $config2['image_library']		= 'gd2';
						$config2['source_image'] 		= UPLOAD_PATH.'property-images/'.$upload_data['file_name'];
						$config2['maintain_ratio'] 		= TRUE;
						$config2['width']         		= 300;
						$config2['new_image']        	= UPLOAD_PATH.'property-images/thumbnail/'.$upload_data['file_name'];
						//$config2['height']       = 50;

						$this->load->library('image_lib', $config2);
						$this->image_lib->initialize($config2);
						$this->image_lib->resize();
						$this->image_lib->clear();

						$img['thumbnail']  = 'property-images/thumbnail/'.$upload_data['file_name'];

		                if($idpic=$this->model->Save('propertypic',$img)){
							logs($user->id,$idpic,'ADD','Add Property Pics');
							$return['res'] = 'success';
							$return['msg'] = 'Image uploaded.';
						} 
	         		}
	         		else{
	         			$error = $this->upload->display_errors();
                        $return['res'] = 'error';
						$return['msg'] = $error;
	         		}
            	endfor;
            	echo json_encode($return);
				break;

			case 'img_details':
				
				$return['res'] = 'error';
				$return['msg'] = 'Someting Worng!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$details = $_POST['details'];
					$id = $_POST['id'];
					
						if ($this->model->Update('propertypic',['details'=>$details],['id'=>$id])) {
							logs($user->id,$id,'EDIT','Edit Property Pics');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
				}	
				echo json_encode($return);
				
				break;

			case 'info':
				$page = 'properties/sub_p/sub_property_info';
				$data['row'] = $row = $this->model->getRow('property',['flat_id'=>$id]);
				$data['type'] 		  = $this->model->getRow('sub_property_types',['spt_id'=>$row->sub_property_type_id]);
				$data['pics'] 		  = $this->model->getData('propertypic',['flatid'=>$id]);
				$data['property']   = $this->model->getRow('propmaster',['id'=>$row->propid]);
				load_view($page,$data);
				break;

			case 'flatcode':
				$string = $_POST['title'];
				$string = trim($string);
				$string = preg_replace("/[^a-zA-Z 0-9]+/", "", $string);
				$output = str_replace(' ', '', $string);
				$output = strtoupper($output);
				$output = trim(preg_replace('/-+/', '-', $output), '-');
				$output = substr($output,0,8);
				if($this->model->getRow('property',['flat_id'=>$id])){
					$output = $output.'1';
				}
				echo $output;
				break;

			case 'inventory':
				date_default_timezone_set('Asia/Kolkata');

				$data['month'] = date('m');
				// $data['monthName'] = date('F');
				$data['year']  = date('Y');
				$data['pro_id'] 		 = $pro_id;
				$data['flat_id']      = $id;
				$data['title']        = 'Inventory';
				$data['prow'] = $prow = $this->model->getRow('property',['flat_id'=>$id]);
				$data['pmrow'] 	    = $this->model->getRow('propmaster',['id'=>$prow->propid]);
				$data['contant']      = 'properties/sub_p/price_calender';
				$this->template($data);
				break;

			case 'bulk_inventory_pricing':
				$data['pro_id'] 	  = $pro_id;
				$data['flat_id']      = $id;
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
									$_POST['property_id'] = $id;
									$_POST['date']        = $drow;
									$_POST['type']        = 'daily_price';
									$_POST['price']		  = $_POST['dailyPrice'];
									$inventoryID=$this->save_inventory($response='no');
									logs($user->id,$inventoryID,'ADD','Add New Property Inventory');
									$_POST['type']        = 'extra_bedding_price';
									$_POST['price']		  = $_POST['extraBeddingPrice'];
									$inventoryID=$this->save_inventory($response='no');
									logs($user->id,$inventoryID,'ADD','Add New Property Inventory');

									if (@$_POST['status']) {
										$_POST['type']        = 'status';
										$_POST['price']		  = $_POST['status'];
										$inventoryID=$this->save_inventory($response='no');
										logs($user->id,$inventoryID,'ADD','Add New Property Inventory');
									}

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
					
					$data['contant']      = 'properties/sub_p/bulk_inventory_pricing';
					load_view($data['contant'],$data);
				}
				
				break;

			case 'reservation':
				$data['pro_id'] 	  = $pro_id;
				$data['flat_id']      = $id;
				$return['res'] 		  = 'error';
				$return['msg'] 		  = 'Someting Worng!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$prow = $this->model->getRow('property',['flat_id'=>$id]);

					if ($prow->capacity<$_POST['of_adults']) {
						$return['msg'] 		  = 'Out Of Capacity!';
						echo json_encode($return);
						die();
					}

					// if (@$_POST['append']) {
					// 	$dateArray = explode(',',$_POST['append']);
					// }
					// else{
					// 	$return['msg'] 		  = 'Date not selected!';
					// 	echo json_encode($return);
					// 	die();
					// }


					

					// from date - to date
					if (@$_POST['startDate'] && @$_POST['endDate']) {
						$period = new DatePeriod(
							     new DateTime($_POST['startDate']),
							     new DateInterval('P1D'),
							     new DateTime($_POST['endDate'])
						);
						foreach($period as $date) {                 
						      $dateArray[] = $date->format('Y-m-d'); 
						}
						$dateArray[] =$_POST['endDate'];
					}
					else{
						$return['msg'] 		  = 'Date not selected!';
						echo json_encode($return);
						die();
					}	
					// from date - to date


					

					$date_availability = true;
					$property = $this->model->getRow('property',['flat_id'=>$data['flat_id']]);

					$price = 0;
					foreach ($dateArray as $drow) {
						$check['date'] 		  = $drow;
						$check['property_id'] = $data['flat_id'];
						if ($pi = $this->model->getRow('property_inventory',$check)) {
							if ($pi->status==2 or $pi->status==3) {
								$date_availability = false;
							}
							$daily_price = $pi->daily_price;
							$extra_bedding_price = $pi->extra_bedding_price;
							$price = $price + $daily_price;
						}
						else{
							$saveCal['property_id'] 			= $data['flat_id'];
							$saveCal['daily_price'] 			= $property->daily_price;
							$saveCal['extra_bedding_price'] 	= $property->extra_bedding_price;

							$daily_price 			= $property->daily_price;
							$extra_bedding_price 	= $property->extra_bedding_price;

							$saveCal['date'] 					= $drow;
							$inventoryID=$this->model->Save('property_inventory',$saveCal);
							logs($user->id,$inventoryID,'ADD','Add New Property Inventory');
							$price = $price + $daily_price;
						}
					}







					if ($date_availability==false) {
						$return['msg'] = 'Selected Dates Not Available!';
						echo json_encode($return);
						die();
					}

					

					// $this->pr($dateArray);
					if($appuser = $this->model->getRow('appuser',['mobile'=>$_POST['mobile']])) {
						$guest_id = $appuser->id;
						$_POST['mobile'] = $appuser->mobile;
					}
					else {
						$saveappuser['mobile'] 	= $_POST['mobile'];
						$saveappuser['name'] 	= $_POST['name'];
						$saveappuser['dob'] 	= $_POST['dob'];
						$saveappuser['gender'] 	= $_POST['gender'];
						$saveappuser['email'] 	= $_POST['email'];
						if ($guest_id = $this->model->Save('appuser',$saveappuser)) {
							logs($user->id,$guest_id,'ADD','Add New App User');
							
						}
						else {
							$guest_id = false;
						}
					}

					if ($guest_id) {
						$guest = $this->model->getRow('appuser',['id'=>$guest_id]);
						$insertArry['renter_type'] 			= '';
						$insertArry['booking_type'] 		= '';
						$insertArry['booking_from'] 		= 'PANEL';
						$insertArry['guest_id'] 			= $guest_id;
						$insertArry['confirmation_code'] 	= $confirmation_code = rand( 10000 , 99999 );
						$insertArry['status'] 				= 2;
						$insertArry['guest_name'] 			= $guest->name;
						$insertArry['gender'] 				= $guest->gender;
						$insertArry['email'] 				= $guest->email;
						$insertArry['contact'] 				= $guest->mobile;
						$insertArry['of_adults'] 			= $_POST['of_adults'];
						$insertArry['of_children'] 			= $_POST['of_children'];
						$insertArry['of_infants'] 			= $_POST['of_infants'];
						$insertArry['start_date'] 			= $dateArray[0];
						$insertArry['end_date'] 			= end($dateArray);
						$insertArry['of_nights'] 			= '';
						$insertArry['booked'] 				= '';
						$insertArry['listing'] 				= '';
						$insertArry['earnings'] 			= '';
						$insertArry['flat_id'] 				= $data['flat_id'];
						$insertArry['notes'] 				= '';
						$insertArry['checkin_time'] 		= '';
						$insertArry['checkin_status'] 		= '';
						$insertArry['purpose_of_trip'] 		= '';
						$insertArry['vehcleno'] 			= '';
						$insertArry['checkout_time1'] 		= '';
						$insertArry['price_type'] 			= '';
						$insertArry['price'] 				= $price;
						$insertArry['user_id'] 				= '';
						$insertArry['security_deposit'] 	= '';
						$insertArry['lockin_days'] 			= '';
						$insertArry['notice_days'] 			= '';
						$insertArry['is_foreigner'] 		= '';
						$insertArry['booking_remark'] 		= '';
						$insertArry['order_id'] 			= '';
						$insertArry['booking_id'] 			= '';
						$insertArry['rzp_payment_id'] 		= '';
						$insertArry['price_currency'] 		= '';
						$insertArry['rzp_capture_response'] = '';
						$insertArry['booking_date'] 		= '';
						$insertArry['rzp_refund_response'] 	= '';

						if ($booked = $this->model->Save('booking',$insertArry)) {
							logs($user->id,$booked,'ADD','Add New Booking');
							$return['res'] 		  = 'success';
							$return['msg'] 		  = 'Bookings Successful.';
						}

						if ($booked) {    			// update Calendar
							foreach($dateArray as $date) {
								$check['date'] 		  = $date;
								$check['property_id'] = $data['flat_id'];
								$row_items['fk_booking_id'] = $booked;
								$row_items['fk_flat_id'] = $data['flat_id'];
								$row_items['extra_bedding'] = 0;
								$itemsID=$this->model->Save('booking_row_items',$row_items);
								logs($user->id,$itemsID,'ADD','Add booking Items');
								if ($cal = $this->model->getRow('property_inventory',$check)) {
									$updateCal['status'] = 3;
									$this->model->Update('property_inventory',$updateCal,$check);
									logs($user->id,$data['flat_id'],'EDIT','Edit Property Inventory');
								}
								else {
									$property = $this->model->getRow('property',['flat_id'=>$data['flat_id']]);
									$saveCal['property_id'] 			= $data['flat_id'];
									$saveCal['daily_price'] 			= $property->daily_price;
									$saveCal['extra_bedding_price'] 	= $property->extra_bedding_price;
									$saveCal['date'] 					= $date;
									$saveCal['status'] 					= 3;
									$p_id=$this->model->Save('property_inventory',$saveCal);
									logs($user->id,$p_id,'ADD','Add Property Inventory');
								}
							}
						}
					}
					else{
						$return['msg'] 		  = 'Guest Not selected!';
					}

					echo json_encode($return);

					
					// $this->pr($_POST);
					
				}
				else{
					
					$data['contant']  = 'properties/sub_p/reservation';
					$data['guests']   = $this->model->getData('appuser',0,'asc','name'); 
					load_view($data['contant'],$data);
				}
				
				break;




			case 'policy':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($_POST['p_id']=='select_all') {
						if ($this->subprop_policy_select_all($id,$pro_id)) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
						echo json_encode($return);
						die();
					}
					$p_id   = $_POST['p_id'];
					$type   = $_POST['type'];
					$row = $this->model->getRow('policy',['id'=>$p_id]);
					if($row){
						$check['prop_id']   		= $id;
						$check['policy_id'] 		= $p_id;

						$set['prop_id']     		= $id;
						$set['policy_id']   		= $p_id;
						$set['policy_type'] 		= $row->policy_type;
						$set['policy_name'] 		= $row->policy_name;

						$update['policy_type'] 	= $row->policy_type;
						$update['policy_name'] 	= $row->policy_name;
						if ($type=='set') {
							
							if($this->model->getRow('propertypolicy',$check)){
								if ($this->model->Update('propertypolicy',$update,$check)) {
									logs($user->id,$p_id,'EDIT','Edit property Policy');
									$saved = 1;
								}
							}
							else{
								if ($p_id=$this->model->Save('propertypolicy',$set)) {
									logs($user->id,$p_id,'ADD','Add property Policy');
									$saved = 1;
								}
							}
						}
						else if($type=='data'){
							$update[$_POST['cloumn']] = $_POST['value'];
							if($this->model->getRow('propertypolicy',$check)){
								if ($this->model->Update('propertypolicy',$update,$check)) {
									logs($user->id,$p_id,'EDIT','Edit property Policy');
									$saved = 1;
								}
							}
							else{
								$return['msg'] = 'Policy Not Assigned!';
							}
						}

						else{
							if ($this->model->Delete('propertypolicy',$check)) {
								logs($user->id,$p_id,'DELETE','Delete property Policy');
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
					$page     = 'properties/sub_p/sub_pro_policy';
					$policies = $this->model->getData('policy');
					if ($policies = $this->model->getData('policy')) {
						foreach ($policies as $row) {
							if ($t=$this->model->getRow('propertypolicy',['prop_id'=>$id,'policy_id'=>$row->id])) {
								$row->checked = 'checked';
								$row->is_highlighted = $t->is_highlighted;
								$row->highlighted_description = $t->highlighted_description;
							}
							else{
								$row->checked = '';
								$row->is_highlighted = '';
								$row->highlighted_description = '';
							}
						}
					}
					$data['policies']  = $policies;
					load_view($page,$data);
				}
				break;

			case 'activity':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$a_id   = $_POST['a_id'];
					$type   = $_POST['type'];
					$row = $this->model->getRow('property_activity_master',['id'=>$a_id]);
					if($row){
						$check['flat_id']   		= $id;
						$check['activity_id'] 		= $a_id;

						$set['flat_id']     		= $id;
						$set['activity_id']   		= $a_id;

						$update['activity_id'] 		= $a_id;

						if ($type=='set') {
							
							if($this->model->getRow('property_activity_master_assign',$check)){
								if ($this->model->Update('property_activity_master_assign',$update,$check)) {
									logs($user->id,$a_id,'EDIT','Edit Activity Master Assign');
									$saved = 1;
								}
							}
							else{
								if ($a_id=$this->model->Save('property_activity_master_assign',$set)) {
									logs($user->id,$a_id,'ADD','Add Activity Master Assign');
									$saved = 1;
								}
							}
						}
						else if($type=='data'){
							$update[$_POST['cloumn']] = $_POST['value'];
							if($this->model->getRow('property_activity_master_assign',$check)){
								if ($this->model->Update('property_activity_master_assign',$update,$check)) {
									logs($user->id,$a_id,'EDIT','Edit Activity Master Assign');
									$saved = 1;
								}
							}
							else{
								$return['msg'] = 'Activity Not Assigned!';
							}
						}
						else{
							if ($this->model->Delete('property_activity_master_assign',$check)) {
								logs($user->id,$a_id,'DELETE','Delete Activity Master Assign');
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
					$page     = 'properties/sub_p/sub_pro_activity';
					$activity = $this->model->getData('property_activity_master');
					if ($activity) {
						foreach ($activity as $row) {
							$row->checked = '';
							$row->paidorfree = '';
							$row->price = '';
							if ($ama = $this->model->getRow('property_activity_master_assign',['flat_id'=>$id,'activity_id'=>$row->id])) {
								$row->checked = 'checked';
								$row->paidorfree = $ama->paidorfree;
								$row->price = $ama->price;
							}
						}
					}
					$data['activity']  = $activity;
					load_view($page,$data);
				}
				break;

			case 'amenities':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$type   = $_POST['type'];
					if ($_POST['a_id']=='select_all') {
						if ($this->subprop_amenities_select_all($id,$pro_id)) {
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
						echo json_encode($return);
						die();
					}
					
					$a_id   = $_POST['a_id'];
					$type   = $_POST['type'];
					$row = $this->model->getRow('amenities',['id'=>$a_id]);
					if($row){
						$check['flatid']   			= $id;
						$check['amenitiid'] 		= $a_id;

						$set['flatid']     			= $id;
						$set['amenitiid']   		= $a_id;
						//$set['property_id'] 		= $pro_id;

						$update['amenitiid'] 	= $a_id;

						if ($type=='set') {
							
							if($this->model->getRow('flatamenities',$check)){
								if ($this->model->Update('flatamenities',$update,$check)) {
									logs($user->id,$a_id,'EDIT','Edit Sub Property Amenities');
									$saved = 1;
								}
							}
							else{
								if ($id=$this->model->Save('flatamenities',$set)) {
									logs($user->id,$id,'ADD','Add Sub Property Amenities');
									$saved = 1;
								}
							}
						}
						else if($type=='data'){
							$update[$_POST['cloumn']] = $_POST['value'];
							if($this->model->getRow('flatamenities',$check)){
								if ($this->model->Update('flatamenities',$update,$check)) {
									logs($user->id,$a_id,'EDIT','Edit Sub Property Amenities');
									$saved = 1;
								}
							}
							else{
								$return['msg'] = 'Amenity Not Assigned!';
							}
						}
						else{
							if ($this->model->Delete('flatamenities',$check)) {
								logs($user->id,$a_id,'DELETE','Delete Sub Property Amenities');
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
					$page     = 'properties/sub_p/sub_pro_amenities';
					$amenities = $this->model->getData('amenities');
					if ($amenities) {
						foreach ($amenities as $row) {
							if ($t = $this->model->getRow('flatamenities',['flatid'=>$id,'amenitiid'=>$row->id])) {
								$row->checked = 'checked';
								$row->is_highlighted = $t->is_highlighted;
							}
							else{
								$row->checked = '';
								$row->is_highlighted = '';
							}
						}
					}
					$data['amenities']  = $amenities;
					load_view($page,$data);
				}
				break;

			case 'kitchen':
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!';
					$saved = 0;
					$_POST['pro_id']  = $pro_id;
					$_POST['flatid'] = $id;
					if ($row = $this->model->getRow('property_kitchen_arrangement',['flatid'=>$id])) {
						if($this->model->Update('property_kitchen_arrangement',$_POST,['id'=>$row->id])){
							logs($user->id,$row->id,'EDIT','Edit Property Kitchen Arrangement ');
							$saved = 1;
						}
					}
					else{
						if ($id=$this->model->Save('property_kitchen_arrangement',$_POST)) {
							logs($user->id,$id,'ADD','Add Property Kitchen Arrangement ');
							$saved = 1;
						}
					}
					if ($saved == 1) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
					echo json_encode($return);
				}
				else{
					$page = 'properties/sub_p/kitchen';
					$data['action_url'] = base_url()."sub_properties/$pro_id/kitchen/$id";
					$data['row']  = $this->model->getRow('property_kitchen_arrangement',['flatid'=>$id]);
					load_view($page,$data);
				}
				break;

			case 'broadBand':
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$return['res'] = 'error';
					$return['msg'] = 'Not Saved!';
					$saved = 0;
					$_POST['pro_id']  = $pro_id;
					$_POST['flatid'] = $id;
					$_POST['mobile_networks'] = implode(",",$_POST['mobile_networks']);
					if ($row = $this->model->getRow('property_broadband_arrangement',['flatid'=>$id])) {
						if($this->model->Update('property_broadband_arrangement',$_POST,['id'=>$row->id])){
							logs($user->id,$row->id,'EDIT','Edit Property Broadband Arrangement ');
							$saved = 1;
						}
					}
					else{
						if ($newId=$this->model->Save('property_broadband_arrangement',$_POST)) {
							logs($user->id,$newId,'ADD','Add Property Broadband Arrangement ');
							$saved = 1;
						}
					}
					if ($saved == 1) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
					echo json_encode($return);
				}
				else{
					$page = 'properties/sub_p/broadBand';
					$data['action_url'] = base_url()."sub_properties/$pro_id/broadBand/$id";
					$data['providers']  =  $this->model->getData('broadband_master',0,'asc','name');
					$data['row']  		= $this->model->getRow('property_broadband_arrangement',['flatid'=>$id]);
					load_view($page,$data);
				}
				break;

			case 'duplicate':
				$done = 0;
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
                $sub_property_type_id=0;
                $units=0;
				$duplicate = array();
				if($row = $this->model->getRow('property',['flat_id'=>$id])){
					unset($row->flat_id);
					foreach ($row as $key => $value) {
                       if($key!="flat_no")
                       {
				            $duplicate[$key] = $value;
                       }
                       if($key=="sub_property_type_id")
                       {
                            $sub_property_type_id=$value;
                       }
                       if($key=="units")
                       {
                          $units=$value;
                          $units=$units+1;   
                          $duplicate[$key] = $units;
                       }
                        
					}
                    
                    $dataUpdateAll=array(
                        'units'=>$units
                    );
                   //print_r($dataUpdateAll);
					if ($newId = $this->model->Save('property',$duplicate)) {
						logs($user->id,$newId,'ADD','Add Sub Property ');
                        
                        //replicate no of units increase in all same type of sub property
                        $this->model->Update('property',$dataUpdateAll,['sub_property_type_id'=>$sub_property_type_id]);
						logs($user->id,$sub_property_type_id,'EDIT','Edit Sub Property Type ');
                        //end above condition
                        
						$done = 1;
						if($images = $this->model->getData('propertypic',['flatid'=>$id])):
							foreach ($images as $img) :
								if (file_exists('../'.$img->photo)) :

									$new = explode('.',$img->photo);
									$newtmp = $newId.'-copy.'.end($new);
									unset($new[count($new)-1]);
									$new[count($new)-1] .= $newtmp;
									$new = implode('.',$new);
									if(copy('../'.$img->photo, '../'.$new)):
										$insertArry['propid'] = $img->propid;
										$insertArry['flatid'] = $newId;
										$insertArry['photo'] = $new;
										$insertArry['iscover'] = $img->iscover;
										$insertArry['details'] = $img->details;
										$insertArry['indexing'] = $img->indexing;
										$id=$this->model->Save('propertypic',$insertArry);
										logs($user->id,$id,'ADD','Add Property Pic ');
										unset($insertArry);
									endif;

								endif;
							endforeach;
						endif;

					}
				}
				if ($done==1) {
					$return['res'] = 'success';
					$return['msg'] = 'Saved.';
				}
				echo json_encode($return);
				break;

			case 'delete':
				$this->delete_sub_property($id);
				logs($user->id,$id,'DELETE','Delete Sub Property ');
				break;

			case 'saveimgtest':
				echo "string";
				echo json_encode($_POST);
				break;

			default:
				# code...
				break;
		}

	}

	private function subprop_policy_select_all($flatid,$pro_id)
	{
		$data['user']  =$user  = $this->checkLogin();
		$this->checkPlan(@$_COOKIE['property_id']);
		$saved = 0;
		$type   = $_POST['type'];
		$policies = $this->model->getData('policy');
		if ($policies) {
			foreach($policies as $prow){
				$p_ids[]=$prow->id;
				$policy_type[]=$prow->policy_type;
				$policy_name[]=$prow->policy_name;
			}
		}
		if (@$p_ids) {
			$n=0;
			foreach ($p_ids as $p_id) {
				$check['prop_id']   		= $flatid;
				$check['policy_id'] 		= $p_id;

				$set['prop_id']     		= $flatid;
				$set['policy_id']   		= $p_id;
				$set['policy_type'] 		= $policy_type[$n];
				$set['policy_name'] 		= $policy_name[$n];

				$update['policy_type'] 	= $policy_type[$n];
				$update['policy_name'] 	= $policy_name[$n];
				if ($type=='set') {
					
					if($this->model->getRow('propertypolicy',$check)){
						if ($this->model->Update('propertypolicy',$update,$check)) {
							logs($user->id,$p_id,'EDIT','Edit Sub Prop Policy Select ');
							$saved = 1;
						}
					}
					else{
						if ($p_id=$this->model->Save('propertypolicy',$set)) {
							logs($user->id,$p_id,'ADD','Add Sub Prop Policy Select ');
							$saved = 1;
						}
					}
				}
				else{
					if ($this->model->Delete('propertypolicy',$check)) {
						logs($user->id,$p_id,'DELETE','Delete Sub Prop Policy Select ');
						$saved = 1;
					}
				}
				++$n;
			}
			
		}	
		return $saved;
	}

	private function subprop_amenities_select_all($flatid,$pro_id)
	{
		$data['user']  =$user  = $this->checkLogin();
		$this->checkPlan(@$_COOKIE['property_id']);
		$saved = 0;
		$type   = $_POST['type'];
		$amenities = $this->model->getData('amenities');
		if ($amenities) {
			foreach($amenities as $arow){
				$a_ids[]=$arow->id;
			}
		}
		if (@$a_ids) {
			foreach ($a_ids as $a_id) {
				$check['flatid']   		= $flatid;
				$check['amenitiid'] 	= $a_id;
				$set['flatid']     		= $flatid;
				$set['amenitiid']   	= $a_id;
				$set['property_id'] 	= $pro_id;
				$update['amenitiid'] 	= $a_id;
				if ($type=='set') {
					if($this->model->getRow('flatamenities',$check)){
						if ($this->model->Update('flatamenities',$update,$check)) {
							logs($user->id,$a_id,'EDIT','Edit Sub Prop Amenities Select ');
							$saved = 1;
						}
					}
					else{
						if ($id=$this->model->Save('flatamenities',$set)) {
							logs($user->id,$id,'EDIT','Edit Sub Prop Amenities Select ');
							$saved = 1;
						}
					}
				}
				else{
					if ($this->model->Delete('flatamenities',$check)) {
						logs($user->id,$a_id,'DELETE','Delete Sub Prop Amenities Select ');
						$saved = 1;
					}
				}
			}
			
		}	
		return $saved;
	}

	public function sleeping_arrangements($pro_id=null,$action=null,$flat_id=null,$id=null)
	{
		$this->checkPlan(@$_COOKIE['property_id']);
		$data['user']  =$user  = $this->checkLogin();
		$data['pro_id']  = $pro_id;
		$data['flat_id'] = $flat_id;
		switch ($action) {
			case 'index':
				// $this->pr($data);

				$data['flat'] = $this->model->getRow('property',['flat_id'=>$flat_id]);

				// $this->pr($data);

				$data['title']      = 'Sleeping Arrangements';
				$data['contant']    = 'properties/sleeping_arrangement/sleeping_arrangement';
				$data['tb_url']	    = base_url().'sleeping_arr/'.$pro_id.'/tb/'.$flat_id;
				$data['propmaster']   = $this->model->getRow('propmaster',$pro_id);
				$data['properties'] = $this->model->getData('propmaster',0,'desc');
				$this->template($data);
				break;

			case 'tb':
				$data['title']   = 'Sleeping Arrangements';
				$data['contant'] = 'properties/sleeping_arrangement/tb_sleeping_arrangement';
				$data['rows']    = $this->model->getData('property_sleeping_arrangements',['flat_id'=>$flat_id]);
				// $this->pr($data);
				load_view($data['contant'],$data);
					
				break;

			case 'new':
				$data['contant']    = 'properties/sleeping_arrangement/new_sleeping_arrangement';
				$data['titles']    	= $this->model->getData('sleeping_title_master',0,'asc','title');
				$data['desc']    	= $this->model->getData('sleeping_master',0,'asc','title');
				$data['icons']	    = $this->model->getdata('icons',0);
				load_view($data['contant'],$data);
				break;

			case 'update':
				$data['contant']    = 'properties/sleeping_arrangement/update_sleeping_arrangement';
				$data['row']        = $this->model->getRow('property_sleeping_arrangements',['sa_id'=>$id]);
				$data['titles']    	= $this->model->getData('sleeping_title_master',0,'asc','title');
				$data['desc']    	= $this->model->getData('sleeping_master',0,'asc','title');
				$data['icons']	    = $this->model->getdata('icons',0);

				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$_POST['flat_id'] = $flat_id;
					if ($id!=null) {
						if($this->model->Update('property_sleeping_arrangements',$_POST,['sa_id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Sleeping Arrrangements ');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if($cond=$this->model->Save('property_sleeping_arrangements',$_POST)){
							logs($user->id,$cond,'ADD','Add Sleeping Arrrangements ');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
				}
				echo json_encode($return);

				break;

			case 'delete':
				$this->delete_sleeping_arrangement(['sa_id'=>$id]);
				logs($user->id,$id,'DELETE','Delete Sleeping Arrrangements ');
				break;

			default:
				# code...
				break;
		}
	}

	function delete_sleeping_arrangement($cond,$response='yes'){
		$data['user']=$user    = $this->checkLogin();
		$deleted=0;
		$return['res'] = 'error';
		$return['msg'] = 'Not Deleted!';
		if ($this->model->Delete('property_sleeping_arrangements',$cond)) {
			logs($user->id,$cond,'DELETE','Delete Sleeping Arrrangements ');
			$deleted = 1;
		}

		if ($response=='yes') {
			if ($deleted==1) {
				$return['res'] = 'success';
				$return['msg'] = 'Deleted Successfully.';
			}
			echo json_encode($return);
		}
	}


	// test




	// test



	function delete_images($type,$id)
	{
		$data['user']    = $user = $this->checkLogin();
		if ($type=='sub_property') {
			$tb = 'propertypic';
		}
		$return['res'] = 'error';
		$return['msg'] = 'Image Not Deleted!';
		$row = $this->model->getRow('propertypic',['id'=>$id]);
		if ($this->model->Delete($tb,$id)) {
			logs($user->id,$id,'DELETE','Image Deleted ');
			@unlink(UPLOAD_PATH.$row->photo);
			@unlink(UPLOAD_PATH.$row->thumbnail);
			$return['res'] = 'success';
			$return['msg'] = 'Image Deleted Successfully.';
		}
		echo json_encode($return);
	}

	function sp_default_image()
	{
		$data['user']    = $user = $this->checkLogin();
		$return['res'] = 'error';
		$return['msg'] = 'Someting Worng!';
		$type = $_POST['type'];
		$id = $_POST['id'];
		$row = $this->model->getRow('propertypic',['id'=>$id]);
		if ($type=='setDefault') {
			$this->model->Update('propertypic',['iscover'=>0],['flatid'=>$row->flatid]);
			if ($this->model->Update('propertypic',['iscover'=>1],['id'=>$id])) {
				logs($user->id,$id,'ADD','Default Image Set');
				$return['res'] = 'success';
				$return['msg'] = 'Default Image Set Successfully.';
			}
		}
		else{
			if ($this->model->Update('propertypic',['iscover'=>0],['flatid'=>$row->flatid])) {
				logs($user->id,$row->flatid,'DELETE','Default Image Removed');
				$return['res'] = 'success';
				$return['msg'] = 'Default Image Removed Successfully.';
			}
		}
		echo json_encode($return);
	}

	

	function delete_sub_property($flat_id,$response='yes'){
		$deleted=0;
		$data['user']    = $user = $this->checkLogin();
		$return['res'] = 'error';
		$return['msg'] = 'Image Not Deleted!';
		if ($this->model->_delete('property',['flat_id'=>$flat_id])) {
			if ($rows = $this->model->getData('propertypic',['flatid'=>$flat_id])) {
				foreach ($rows as $row) {
					if($this->model->_delete('propertypic',$row->id)){
						logs($user->id,$row->id,'DELETE','Sub Property Image Deleted');
						//unlink(UPLOAD_PATH.$row->photo);						
					}
				}
			}
			$deleted = 1;
		}

		if ($response=='yes') {
			if ($deleted==1) {
				$return['res'] = 'success';
				$return['msg'] = 'Deleted Successfully.';
			}
			echo json_encode($return);
		}
	}





	// Start :: propertie reviews
	public function property_reviews($action=null, $pro_id=null, $flat_id=null, $id=null)
	{
		$this->checkPlan(@$_COOKIE['property_id']);
		$data['user']    = $user = $this->checkLogin();
		$data['action']  = $action;
		$data['pro_id']  = $pro_id;
		$data['flat_id'] = $flat_id;
		$data['id']      = $id;
		switch ($action) {
			case null:
					$data['title']      = 'Property Reviews';
					$data['contant']    = 'properties/review/property_reviews';
					$data['countries']  = $this->model->getData('countries',0,'asc','name');
					$data['locations']  = $this->model->getData('location',0,'asc','name');
					if ($user->type=='host') {
						$propmaster = $this->model->host_propmaster();
					}
					else{
						$propmaster = $this->model->propmaster();
					}
					$data['propmaster'] = $propmaster;
					$this->template($data);
				break;

			case 'reviews':


				$this->load->library('pagination');
				$data['search'] = '';
				if (@$_POST['search']) {
					$data['search'] = $_POST['search'];
					$this->db->having('flat_id', $flat_id);
					$this->db->like('reviewfrom', $_POST['search']);
		        	$this->db->or_like('guest_name', $_POST['search']);
					$this->db->or_like('review', $_POST['search']);	
					$this->db->or_like('rating', $_POST['search']);

					// echo $flat_id;
					// die();
			    }
				$config = array();
		        $config["base_url"] = base_url()."property_reviews/reviews/null/".$flat_id.'/';
				$config["total_rows"]  = count($this->model->getData('propertyreview',['flat_id'=>$flat_id]));
				$data['total_rows']    = $config["total_rows"];
				$config["per_page"]    = 5;
				$config["uri_segment"] = 5;
				$config['attributes']  = array('class' => 'pag-link');
				$this->pagination->initialize($config);
				$data["links"]   = $this->pagination->create_links();
				$data['page']    = $page = ($id!=null) ? $id : 0;
				if (@$_POST['search']) {
					$this->db->having('flat_id', $flat_id);
					$this->db->like('reviewfrom', $_POST['search']);
		        	$this->db->or_like('guest_name', $_POST['search']);
					$this->db->or_like('review', $_POST['search']);	
					$this->db->or_like('rating', $_POST['search']);
			    }
				$data['rows']    =  $this->model->getData('propertyreview',['flat_id'=>$flat_id],'desc','id',$config["per_page"],$page);

				$data['title']      = 'Property Reviews';
				$data['contant']    = 'properties/review/property_reviews_tb';
				$property 			= $this->model->getRow('property',['flat_id'=>$flat_id]);
				$data['property'] 	= $property;
				$data['pro_id'] 	= $property->propid;
				// $data['rows']       = $this->model->getdata('propertyreview',['flat_id'=>$flat_id]);
				load_view($data['contant'],$data);
				break;

			case 'new':
				$data['contant']        = 'properties/review/property_review_new';
				$curd	   			    = date('Y-m-d');
				$curt	                = date('H:i');
				$data['current_d']	    = $curd.'T'.$curt;
				$data['r_source']	    = $this->model->getdata('reviews_source_master',0,'asc','name');
				load_view($data['contant'],$data);
				break;

			case 'update':
				$data['contant']       = 'properties/review/property_review_update';
				$data['r_source']	   = $this->model->getdata('reviews_source_master',0,'asc','name');
				$data['row']	   	   = $this->model->getRow('propertyreview',['id'=>$id]);
				
				$date = $data['row']->created_on;
				$dd   = date_format(date_create($date),"Y-m-d");
				$dt   = date_format(date_create($date),"H:i");

				$data['current_d'] = $dd.'T'.$dt;

				load_view($data['contant'],$data);
				break;

			case 'save':

				$created_on           = explode('T', $_POST['created_on']);
				$_POST['created_on']  = $created_on[0].' '.$created_on[1];
				$_POST['flat_id']     = $flat_id;
				$_POST['property_id'] = $pro_id;

				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if ($id!=null) {
						if($this->model->Update('propertyreview',$_POST,['id'=>$id])){
							logs($user->id,$id,'EDIT','Edit Property Reviews');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if($id=$this->model->Save('propertyreview',$_POST)){
							logs($user->id,$id,'ADD','Add Property Reviews');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
				}
				echo json_encode($return);
				// echo json_encode($_POST);
				
				break;

			case 'delete':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($this->model->Delete('propertyreview',['id'=>$id])) {
					$this->model->Delete('property_reviews_reply',['reviewid'=>$id]);
					logs($user->id,$id,'DELETE','Delete Property Reviews');
					$return['res'] = 'success';
					$return['msg'] = 'Deleted Successfully.';
				}
				echo json_encode($return);
				break;

			case 'reply':
				$data['contant']       = 'properties/review/property_review_reply';
				$data['rows']	   	   = $this->model->getData('property_reviews_reply',['reviewid'=>$id]);
				load_view($data['contant'],$data);
				break;

			case 'save_reply':
				$_POST['reviewid'] = $id;
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if($this->model->Save('property_reviews_reply',$_POST)){
						logs($user->id,$id,'ADD','Add Reply Property Reviews');
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}
				}
				echo json_encode($return);				
				break;

			case 'delete_reply':
				$return['res'] = 'error';
				$return['msg'] = 'Not Deleted!';
				if ($this->model->Delete('property_reviews_reply',['id'=>$id])) {
					logs($user->id,$id,'DELETE','Delete Reply Property Reviews');
					$return['res'] = 'success';
					$return['msg'] = 'Deleted Successfully.';
				}
				echo json_encode($return);
				break;



			default:
				
				break;
		}
	}
	// End :: propertie reviews

	public function approval_status_change()
	{
		$data['user'] = $user 			= $this->checkLogin();
		$id = $_POST['id'];
		$where = $_POST['where'];
		$status = array('approval_status'=>$_POST['status']);
		$table = $_POST['table'];
		if($this->model->Update($table,$status,[$where=>$id])){
			logs($user->id,$id,'CHANGE_STATUS','Change Status Propmaster By Admin - '.$_POST['status']);
			echo $_POST['status'];
		}

	}
	
	public function newchangeIndexing()
	{
		$data['user'] = $user 			= $this->checkLogin();
		if ($this->input->is_ajax_request()) {
			
			$data = explode(',', $_POST['data']);
			$id 	= $data[0];
			$tb 	= $data[1];
			$id_column  = $data[2];
			$val_column  = $data[3];
			$propid  = $data[4];
			$update = array($val_column => $_POST['value']);
			$cond = [$id_column => $id];
			$this->db->where('flat_no',$_POST['value']);
			if($propid!=NULL){
				$this->db->where('propid',$propid);
			}
			$count=$this->db->count_all_results($tb);
			// echo $count;die();
			if($count>0)
			{
				echo 'error';
			}
			else
			{   echo 'success';
				$this->model->Update($tb, $update, $cond);
				logs($user->id,$id,'Room number alloted',$tb.'- Room number alloted');	
			}  
			
		}
}

public function sub_properties_types($pro_id,$action=null,$p1=null)
{
	$this->checkPlan(@$_COOKIE['property_id']);
$data['user'] = $user 			= $this->checkLogin();
$this->checkSubPropertyPlan($user->id,$pro_id,$p1);
$view_dir = 'properties/sub_p_types/';
$data['pro_id'] = $pro_id;
switch ($action) {
case null:
$data['title'] 			= 'Room Category';
$data['contant'] 		= $view_dir.'index';
$data['tb_url']	  		= current_url().'/tb';
$data['new_url']        = current_url().'/create';
$data['search']	 		= $this->input->post('search');
$this->template($data);
break;
case 'tb':
    $userid=$user->id;
    $data['search'] = '';
    $search='null';
   
    if($p1!=null)
            {
    $data['search'] = $p1;
    $search = $p1;
            }
            //end of section
    if (@$_POST['search']) {
    $data['search'] = $_POST['search'];
    $search=$_POST['search'];
           
            }
    $this->load->library('pagination');
    
    $data['contant'] 		= $view_dir.'tb';
    $config = array();
    $config["base_url"] 	= base_url()."sub_properties_types/tb";
    $config["total_rows"]  	= count($this->model->sub_properties_types($pro_id,$userid,$search));
    $data['total_rows']    	= $config["total_rows"];
    $config["per_page"]    	= 10;
    $config["uri_segment"] 	= 2;
    $config['attributes']  	= array('class' => 'pag-link ');
    $this->pagination->initialize($config);
    $data['links']   		= $this->pagination->create_links();
    $data['page']    		= $page = ($p1!=null) ? $p1 : 0;
    $data['search']	 		= $this->input->post('search');
    $data['update_url']		= base_url('sub_properties_types/'.$pro_id.'/create/');
    $data['delete_url']		= base_url('sub_properties_types/'.$pro_id.'/delete');
    $data['rows']    		= $this->model->sub_properties_types($pro_id,$userid,$search,$config["per_page"],$page);
    load_view($data['contant'],$data);
    break;
    
    
    case 'create':
    $data['title'] 		  	= 'New Sub Property Types';
    $data['contant']      	= $view_dir.'create';
    $data['action_url']	  	= base_url('sub_properties_types/'.$pro_id.'/save');
    $data['total_data'] =0;
    if ($p1!=null) {
    $data['action_url']     = base_url('sub_properties_types/'.$pro_id.'/save/').$p1;
    $data['value']          = $this->model->getRow('sub_property_types',['spt_id'=>$p1]);
    $config["total_data"]  	= $this->model->count_row('sub_property_types',$p1);
    $data['total_data']    	= $config["total_data"];
    
    
    }
    $data['form_id']= uniqid();
    
    load_view($data['contant'],$data);
    break;

    case 'save':
        $id=$p1;
		$property_id = $pro_id;
        $return['res'] = 'error';
        $return['msg'] = 'Not Saved!';
        $saved = 0;
        if ($this->input->server('REQUEST_METHOD')=='POST') {
            if ($id!=null) {
                    $data = array(
                        'name'     => $this->input->post('name'),
                        'property_id'     => $property_id,
                      ); 
                if($this->model->Update('sub_property_types',$data,['spt_id'=>$id])){
					logs($user->id,$id,'EDIT','Edit Sub Property Types');
                    $saved = 1;
                }
               }else{
                $data = array(
                    'name'     => $this->input->post('name'),
                     'property_id'     => $property_id,
					 'active'=>'1',
                  );
                if($id=$this->model->Save('sub_property_types',$data)){
					logs($user->id,$id,'ADD','Add Sub Property Types');
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
            $return['res'] = 'error';
            $return['msg'] = 'Not Deleted!';
            if ($p1!=null) {
            if($this->model->_delete('sub_property_types',['spt_id'=>$p1])){
				logs($user->id,$p1,'DELETE','Delete Sub Property Types');
                    $saved = 1;
                    $return['res'] = 'success';
                    $return['msg'] = 'Successfully deleted.';
                }
            }
            echo json_encode($return);
            break;
            
            default:
// code...
break;
		}
    }
   

	public function checkSubPropertyPlan($user,$pro_id,$flat_id)
	{
	$data['user'] = $user 			= $this->checkLogin();
	if($user->user_role ==4){
	$plan = $this->model->get_user_package($pro_id,$user->id);
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
		redirect(base_url('checkSubProperty/'.$pro_id));
	}else
	if($isValid)
	{
		$data['isValid']='1';
	}else 
	{
		redirect(base_url('checkSubProperty/'.$pro_id));
	}
	}elseif($user->user_role !=1 && $user->user_role !=2 && $user->user_role !=4){
	$plan = $this->model->get_user_package($pro_id,$user->host_id);
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
		redirect(base_url('checkSubProperty/'.$pro_id));
	}else
	if($isValid)
	{
		$data['isValid']='1';
	}else 
	{
		redirect(base_url('checkSubProperty/'.$pro_id));
	}	
	}
	 
	}


	
	public function checkSubProperty($pro_id)
	{
	$data['user'] = $user 			= $this->checkLogin();
	if($user->user_role ==4){
	$plan =$data['plan']= $this->model->get_user_package($pro_id,$user->id);
	$seq = $this->model->getRow('user_packages_master',['id'=>@$plan->package_id,'is_promotion'=>'0']);
    $currentDate = new DateTime();
	$planStartDate = new DateTime(@$plan->plan_date);
	$planEndDate = clone $planStartDate;
	$planEndDate->modify("+" . $plan->no_of_days . " days");
	$currentDateString = $currentDate->format('Y-m-d H:i:s');
	$planStartDateString = $planStartDate->format('Y-m-d H:i:s');
	$planEndDateString = $planEndDate->format('Y-m-d H:i:s');
	$isValid =  $currentDateString <= $planEndDateString;
	if(@$plan->package_id =='')
	{
		$data['isValid']='2';
		$data['user_packages_master'] = $this->model->getData('user_packages_master',['active'=>1, 'is_deleted'=>'NOT_DELETED','is_promotion'=>'0']);
	}else
	if($isValid)
	{
		$data['isValid']='1';
		$data['user_packages_master'] = $this->model->getData('user_packages_master',['seq >='=>@$seq->seq ? $seq->seq : '0','active'=>'1','is_deleted'=>'NOT_DELETED','is_promotion'=>'0']);
	}else
	{
		$data['isValid']='0';
		$data['user_packages_master'] = $this->model->getData('user_packages_master',['active'=>1, 'is_deleted'=>'NOT_DELETED','is_promotion'=>'0']);
	}
	 $data['row'] = $this->model->getRow('propmaster', ['id' => $pro_id]);
	 
	 $data['title']     = 'Sub Properties Check Plan';		
	 $data['contant']   = 'properties/validateplan';
	 $this->template($data);
	}elseif($user->user_role !=1 && $user->user_role !=2 && $user->user_role !=4){
		$plan =$data['plan']= $this->model->get_user_package($pro_id,$user->host_id);
		$seq = $this->model->getRow('user_packages_master',['id'=>@$plan->package_id,'is_promotion'=>'0']);
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
			$data['isValid']='2';
			$data['user_packages_master'] = $this->model->getData('user_packages_master',['active'=>1, 'is_deleted'=>'NOT_DELETED','is_promotion'=>'0']);
		}else
		if($isValid)
		{
			$data['isValid']='1';
			$data['user_packages_master'] = $this->model->getData('user_packages_master',['seq >='=>@$seq->seq ? $seq->seq : '0','active'=>'1','is_deleted'=>'NOT_DELETED','is_promotion'=>'0']);
		}else
		{
			$data['isValid']='0';
			$data['user_packages_master'] = $this->model->getData('user_packages_master',['active'=>1, 'is_deleted'=>'NOT_DELETED','is_promotion'=>'0']);
		}
		 $data['row'] = $this->model->getRow('propmaster', ['id' => $pro_id]);
		 
		 $data['title']     = 'Sub Properties Check Plan';		
		 $data['contant']   = 'properties/validateplan';
		 $this->template($data);
	   }
	}




public function upgradeplan($pro_id){
	$data['user'] = $user 			= $this->checkLogin();
    $user_id =$user->id;		
	if ($this->input->server('REQUEST_METHOD')=='POST') {
		$PackageData = $this->model->getData('user_assign_package',['property_id'=>$pro_id,'extended_plan'=>'1','active'=>'0','user_id'=>$user->id]);
		if(!empty($PackageData))
		{
			$PackageDataCount = count($PackageData);
			if($PackageDataCount >=1)
			{
				echo json_encode(array('flag'=>'package'));
				die();
			}
		}
       
		$rs2  = $this->model->get_package_id($_POST['plan']);
		$rs = $this->model->getRow('user_assign_package',['active'=>'1','user_id'=>$user->id]);
		$select_room =  $rs->selected_room;
		 if($select_room <=$_POST['room']){
		$gst_amount = ($rs2->price*$rs2->gst)/100;
		$total =$rs2->price+$gst_amount;
		$currentDate = new DateTime(); // Assuming $currentDate is a DateTime object
            $newDate = $currentDate->modify('+' . $rs2->duration_in_days . ' days')->format('Y-m-d');
		 $datas = array(
		'property_id'    =>$pro_id,
		'package_id'    =>$_POST['plan'],
		'user_id'    =>$user->id,
		'start_date'    =>date('Y-m-d'),
		'price'       =>$rs2->price,
		'no_of_days'     =>$rs2->duration_in_days,
		'gst'     =>$rs2->gst,
		'gst_amount'     =>$gst_amount,
		'total'     =>$total,
		'min_room'     =>$rs2->min_room,
		'max_room'     =>$rs2->max_room,
		'selected_room'     =>$_POST['room'],
		'active'=>'1',
		'expiry_date'   =>$newDate,
		'extended_plan'=>'0',

   );
   if($insert_id = $this->model->Save('user_assign_package',$datas)) {	
	$orderIds = $insert_id;
					  //razorpay code
					  $date = strtotime("now");
					  $mon=date('M', $date);
					  //generate unique orderid 
					  $num_padded = sprintf("%05d", $insert_id);
					  $code="CK".strtoupper($mon).$num_padded;
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
								  'total' => $payable_final_amt
							  )
						  );
  
						  //get user details by userid
						 
						  $user_detail = $this->model->getRow('usermaster',['id'=>$user_id]);
						  $user_name = $user_detail->name;
						  $user_mobile = $user_detail->mobile;
						  $user_email = $user_detail->email;
						  echo json_encode(array('flag'=>'success','data'=>$response,'user_name'=>$user_name,'user_mobile'=>$user_mobile,'user_email'=>$user_email,'order_id'=>$orderIds, 'total'=>$payable_final_amt,'property_id'=>$pro_id, ));
					  else:
						$valid = checkPlanValid($pro_id,$user_id);
						if($valid)
						{
							$data = [
								'status'=> '1',
								'active' => '0',
								'extended_plan'=>'1',
							];
	
							$this->db->where('id', $insert_id)->update('user_assign_package', $data);
							logs($user->id,$insert_id,'ADD','User Assign Package');
						}else{
							$this->db->where('user_id', $user_id)->update('user_assign_package',['active'=>'0']);
							
							$data = [
								'status'=> '1',
								'active' => '1',
							];
	
							$this->db->where('id', $insert_id)->update('user_assign_package', $data);
							logs($user->id,$insert_id,'ADD','User Assign Package');
						}
						
						  echo json_encode(array('flag'=>'notresponse'));
					  endif;
					}
				}else
				{
					echo json_encode(array('flag'=>'error','msg'=>'Sorry you not enter room  less than selected previous room!'));
				}
					
				}
				return TRUE;
				}

	public function update_payment_status($action=null)
	{
	switch ($action) {
	case 'upgrade_verify_payment':
		$shop_id = '6';
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
			'shopid' => '6',
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
	case 'upgrade_update_order_status':
		$data['user'] = $user 			= $this->checkLogin();
		$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();
			$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
				$payment_gateway = $this->input->post('payment_gateway');
				$payment_id = $this->input->post('payment_id');
				$signature = $this->input->post('signature');
				$razorpay_ord_id = $this->input->post('razorpay_ord_id');
				$order_id = $this->input->post('order_id');
				$total = $this->input->post('total');
				$property_id = $this->input->post('property_id');
				
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
				
				$rs = $this->model->getRow('user_assign_package',['property_id'=>$property_id,'id'=>$order_id]);
				$valid = checkPlanValid($rs->property_id,$rs->user_id);
				if($valid)
				{
					$data = [
						'status'=> '2',
						'active'=>'0',
						'extended_plan'=>'1',
					];
					if($this->db->where_in('id',$order_id)->update('user_assign_package',$data))
					{
						echo "success";
						logs($user->id,$order_id,'ADD','User Assign Package');
					}
					else
					{
						echo "failed";
						logs($user->id,$order_id,'ADD','User Not Assign Package');
					}

				}else{
					$data = [
						'status'=> '2',
						'active'=>'1',
						'extended_plan'=>'0',
					];
					
					$this->db->where('property_id',$property_id)->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
					if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
					{
						echo "success";
						logs($user->id,$order_id,'ADD','User Assign Package');
					}
					else
					{
						echo "failed";
						logs($user->id,$order_id,'ADD','User Not Assign Package');
					}
				}
		   break;
          case 'update_order_status_failed':
		$data['user'] = $user 			= $this->checkLogin();
		$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();
			$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
			
		$payment_gateway = $this->input->post('payment_gateway');
		$payment_id = $this->input->post('payment_id');
		$signature = $this->input->post('signature');
		$razorpay_ord_id = $this->input->post('razorpay_ord_id');
		$order_id = $this->input->post('order_id');
		$total = $this->input->post('total');
		$property_id=$this->input->post('property_id');
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
	
		
		//update inventory
		$rs = $this->model->getRow('user_assign_package',['property_id'=>$property_id,'id'=>$order_id]);
		$valid = checkPlanValid($rs->property_id,$rs->user_id);
		if($valid)
		{

			$data = [
				'status'=> '4',
				'active'=>'0',
				'extended_plan'=>'0',
			];
			if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
			{
				echo "success";
				logs($user->id,$order_id,'ADD','User Assign Package failed ');
			}
			else
			{
				echo "failed";
				logs($user->id,$order_id,'ADD','User Assign Package failed ');
			}
		}else{
			$data = [
				'status'=> '4',
				'active'=>'0',
				'extended_plan'=>'0',
			];
			$this->db->where('property_id',$property_id)->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
			if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
			{
				echo "success";
				logs($user->id,$order_id,'ADD','User Assign Package failed ');
			}
			else
			{
				echo "failed";
				logs($user->id,$order_id,'ADD','User Assign Package failed ');
			}
		}
		break;
          case 'update_order_status_failure':
		$data['user'] = $user 			= $this->checkLogin();
		$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();
	    $api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
		$payment_gateway = $this->input->post('payment_gateway');
		$payment_id = $this->input->post('payment_id');
		$signature = $this->input->post('signature');
		$razorpay_ord_id = $this->input->post('razorpay_ord_id');
		$order_id = $this->input->post('order_id');
		$total = $this->input->post('total');
		$property_id =$this->input->poost('property_id');
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
		
		
		//update inventory
		$rs = $this->model->getRow('user_assign_package',['property_id'=>$property_id,'id'=>$order_id]);
		$valid = checkPlanValid($rs->property_id,$rs->user_id);
		if($valid)
		{
			$data = [
				'status'=> '4',
				'active'=>'0',
				'extended_plan'=>'0',
			];
			if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
			{
				echo "success";
				logs($user->id,$order_id,'ADD','User Assign Package failed ');
			}
			else
			{
				echo "failed";
				logs($user->id,$order_id,'ADD','User Assign Package failed ');
			}

		}else{
			$data = [
				'status'=> '4',
				'active'=>'0',
				'extended_plan'=>'0',
			];
			$this->db->where('property_id',$property_id)->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
			if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
			{
				echo "success";
				logs($user->id,$order_id,'ADD','User Assign Package failed ');
			}
			else
			{
				echo "failed";
				logs($user->id,$order_id,'ADD','User Assign Package failed ');
			}
		}
		break;
        case 'update_failed_payment':
		$data['user'] = $user 			= $this->checkLogin();
		$payment_gateway = $this->input->post('payment_gateway');
		$order_id = $this->input->post('order_id');
		$total = $this->input->post('total');
		$property_id =$this->input->poost('property_id');
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
			
			
			//update inventory
			$rs = $this->model->getRow('user_assign_package',['id'=>$order_id]);
			$valid = checkPlanValid($rs->property_id,$rs->user_id);
			if($valid)
			{
				$data = [
					'status'=> '3',
					'active'=>'0',
					'extended_plan'=>'0',
				];
				if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
				{
					echo "success";
					logs($user->id,$order_id,'ADD','User Assign Package failed payment');
				}
				else
				{
					echo "failed";
					logs($user->id,$order_id,'ADD','User Assign Package failed payment ');
				}
			}else{
				$data = [
					'status'=> '3',
					'active'=>'0',
					'extended_plan'=>'0',
				];
				$this->db->where('property_id',$property_id)->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
				if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
				{
					echo "success";
					logs($user->id,$order_id,'ADD','User Assign Package failed payment');
				}
				else
				{
					echo "failed";
					logs($user->id,$order_id,'ADD','User Assign Package failed payment');
				}
			}

			break;
			}
			}	
			public function upgrade_verify_payment()
			{
				
				$shop_id = '6';
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
					'shopid' => '6',
				];
				$success = 'true';
				$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
				try{
					$api->utility->verifyPaymentSignature($post);
				}catch(SignatureVerificationError $e){
					$success = 'Razorpay Error : ' . $e->getMessage();
				}
				echo $success;
			}

		public function upgrade_update_order_status()
		{
			$data['user'] = $user 			= $this->checkLogin();
			$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();
				$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
					$payment_gateway = $this->input->post('payment_gateway');
					$payment_id = $this->input->post('payment_id');
					$signature = $this->input->post('signature');
					$razorpay_ord_id = $this->input->post('razorpay_ord_id');
					$order_id = $this->input->post('order_id');
					$total = $this->input->post('total');
					$property_id = $this->input->post('property_id');
					
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
					
					$rs = $this->model->getRow('user_assign_package',['property_id'=>$property_id,'id'=>$order_id]);
					$valid = checkPlanValid($rs->property_id,$rs->user_id);
					if($valid)
					{
						$data = [
							'status'=> '2',
							'active'=>'0',
							'extended_plan'=>'1',
						];
						if($this->db->where_in('id',$order_id)->update('user_assign_package',$data))
						{
							echo "success";
							logs($user->id,$order_id,'ADD','User Assign Package');
						}
						else
						{
							echo "failed";
							logs($user->id,$order_id,'ADD','User Not Assign Package');
						}

					}else{
						$data = [
							'status'=> '2',
							'active'=>'1',
							'extended_plan'=>'0',
						];
						
						$this->db->where('property_id',$property_id)->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
						if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
						{
							echo "success";
							logs($user->id,$order_id,'ADD','User Assign Package');
						}
						else
						{
							echo "failed";
							logs($user->id,$order_id,'ADD','User Not Assign Package');
						}
					}
				

		}


public function update_order_status_failed()
  {
	$data['user'] = $user 			= $this->checkLogin();
	$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();
		$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
		
			$payment_gateway = $this->input->post('payment_gateway');
			$payment_id = $this->input->post('payment_id');
			$signature = $this->input->post('signature');
			$razorpay_ord_id = $this->input->post('razorpay_ord_id');
			$order_id = $this->input->post('order_id');
			$total = $this->input->post('total');
			$property_id=$this->input->post('property_id');
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
		
			
			//update inventory
			$rs = $this->model->getRow('user_assign_package',['property_id'=>$property_id,'id'=>$order_id]);
			$valid = checkPlanValid($rs->property_id,$rs->user_id);
			if($valid)
			{

				$data = [
					'status'=> '4',
					'active'=>'0',
					'extended_plan'=>'0',
				];
				if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
				{
					echo "success";
					logs($user->id,$order_id,'ADD','User Assign Package failed ');
				}
				else
				{
					echo "failed";
					logs($user->id,$order_id,'ADD','User Assign Package failed ');
				}
			}else{
				$data = [
					'status'=> '4',
					'active'=>'0',
					'extended_plan'=>'0',
				];
				$this->db->where('property_id',$property_id)->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
				if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
				{
					echo "success";
					logs($user->id,$order_id,'ADD','User Assign Package failed ');
				}
				else
				{
					echo "failed";
					logs($user->id,$order_id,'ADD','User Assign Package failed ');
				}
			}
			
	
}
 public function update_order_status_failure(){
	$data['user'] = $user 			= $this->checkLogin();
	$razorpay_data = $this->db->select('razorpay_key_id, razorpay_key_secret')->get_where('settings', array('id'=>'1'))->row();
		$api = new Api($razorpay_data->razorpay_key_id, $razorpay_data->razorpay_key_secret);
			$payment_gateway = $this->input->post('payment_gateway');
			$payment_id = $this->input->post('payment_id');
			$signature = $this->input->post('signature');
			$razorpay_ord_id = $this->input->post('razorpay_ord_id');
			$order_id = $this->input->post('order_id');
			$total = $this->input->post('total');
			$property_id =$this->input->poost('property_id');
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
			
			
			//update inventory
			$rs = $this->model->getRow('user_assign_package',['property_id'=>$property_id,'id'=>$order_id]);
			$valid = checkPlanValid($rs->property_id,$rs->user_id);
			if($valid)
			{
				$data = [
					'status'=> '4',
					'active'=>'0',
					'extended_plan'=>'0',
				];
				if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
				{
					echo "success";
					logs($user->id,$order_id,'ADD','User Assign Package failed ');
				}
				else
				{
					echo "failed";
					logs($user->id,$order_id,'ADD','User Assign Package failed ');
				}

			}else{
				$data = [
					'status'=> '4',
					'active'=>'0',
					'extended_plan'=>'0',
				];
				$this->db->where('property_id',$property_id)->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
				if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
				{
					echo "success";
					logs($user->id,$order_id,'ADD','User Assign Package failed ');
				}
				else
				{
					echo "failed";
					logs($user->id,$order_id,'ADD','User Assign Package failed ');
				}
			}
			
		}


public function update_failed_payment()
{
	$data['user'] = $user 			= $this->checkLogin();
    $payment_gateway = $this->input->post('payment_gateway');
			$order_id = $this->input->post('order_id');
			$total = $this->input->post('total');
			$property_id =$this->input->poost('property_id');
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
		
		
		//update inventory
		$rs = $this->model->getRow('user_assign_package',['id'=>$order_id]);
		$valid = checkPlanValid($rs->property_id,$rs->user_id);
		if($valid)
		{
			$data = [
				'status'=> '3',
				'active'=>'0',
				'extended_plan'=>'0',
			];
			if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
			{
				echo "success";
				logs($user->id,$order_id,'ADD','User Assign Package failed payment');
			}
			else
			{
				echo "failed";
				logs($user->id,$order_id,'ADD','User Assign Package failed payment ');
			}
		}else{
			$data = [
				'status'=> '3',
				'active'=>'0',
				'extended_plan'=>'0',
			];
			$this->db->where('property_id',$property_id)->where('user_id', $rs->user_id)->update('user_assign_package',['active'=>'0']);
			if($this->db->where('property_id',$property_id)->where_in('id',$order_id)->update('user_assign_package',$data))
			{
				echo "success";
				logs($user->id,$order_id,'ADD','User Assign Package failed payment');
			}
			else
			{
				echo "failed";
				logs($user->id,$order_id,'ADD','User Assign Package failed payment');
			}
		}
	
}	


public function renew_plan($pro_id)
	{
	$data['user'] = $user 			= $this->checkLogin();
	$data['isValid']=1;
	$data['assign'] = $this->model->getRow('user_assign_package',['active'=>1, 'user_id'=>$user->id,'property_id'=>$pro_id]);
	if(!empty($data['assign'])){
	if($data['assign']->no_of_days=='0'){
	$data['isValid']='0';
	}
   }else{
	$data['package_id']='';
	$data['assign']='';
   }
	$data['user_packages_master'] = $this->model->getData('user_packages_master',['active'=>1, 'is_deleted'=>'NOT_DELETED','is_promotion'=>'0']);
	 $data['row'] = $this->model->getRow('propmaster', ['id' => $pro_id]);
	 $data['title']     = 'Renew Your Plan';		
	 $data['contant']   = 'properties/renewplan';
	 $this->template($data);
	}
	


	public function renew_yoru_plan($pro_id){
		$data['user'] = $user 			= $this->checkLogin();
		$user_id =$user->id;
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			$PackageData = $this->model->getData('user_assign_package',['property_id'=>$pro_id,'extended_plan'=>'1','active'=>'0','user_id'=>$user->id]);
				if(!empty($PackageData))
				{
					$PackageDataCount = count($PackageData);
					if($PackageDataCount >=1)
					{
						echo json_encode(array('flag'=>'package'));
						die();
					}
				}
			$rs2  = $this->model->get_package_id($_POST['plan']);
			$rs = $this->model->getData('property', ['propid' => $pro_id, 'is_deleted' => 'NOT_DELETED', 'approval_status' => 'Approved']);
			$SelectRooms = $this->model->getRow('user_assign_package',['active'=>'1','user_id'=>$user->id]);
			$total_rooms = count($rs);
			$select_room =  $SelectRooms->selected_room;
			if(!empty($PackageData))
			{
		    if($select_room <=$_POST['room']){
			 if($total_rooms <= $_POST['room']){
			$gst_amount = ($rs2->price*$rs2->gst)/100;
			$total =$rs2->price+$gst_amount;
			$currentDate = new DateTime(); // Assuming $currentDate is a DateTime object
            $newDate = $currentDate->modify('+' . $rs2->duration_in_days . ' days')->format('Y-m-d');
			 $datas = array(
			'property_id'    =>$pro_id,
			'package_id'    =>$_POST['plan'],
			'user_id'    =>$user->id,
			'start_date'    =>date('Y-m-d'),
			'price'       =>$rs2->price,
			'no_of_days'     =>$rs2->duration_in_days,
			'gst'     =>$rs2->gst,
			'gst_amount'     =>$gst_amount,
			'total'     =>$total,
			'min_room'     =>$rs2->min_room,
			'max_room'     =>$rs2->max_room,
			'selected_room'     =>$_POST['room'],
			'active'=>'1',
			'expiry_date'   =>$newDate,
			'extended_plan'=>'0',
	
	   );
	   if($insert_id = $this->model->Save('user_assign_package',$datas)) {
		$orderIds = $insert_id;	
		//razorpay code
		$date = strtotime("now");
		$mon=date('M', $date);
		//generate unique orderid 
		$num_padded = sprintf("%05d", $insert_id);
		$code="CK".strtoupper($mon).$num_padded;
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
					'total' => $payable_final_amt
				)
			);

			//get user details by userid
		   
			$user_detail = $this->model->getRow('usermaster',['id'=>$user_id]);
			$user_name = $user_detail->name;
			$user_mobile = $user_detail->mobile;
			$user_email = $user_detail->email;
			echo json_encode(array('flag'=>'success','data'=>$response,'user_name'=>$user_name,'user_mobile'=>$user_mobile,'user_email'=>$user_email,'order_id'=>$orderIds, 'total'=>$payable_final_amt,'property_id'=>$pro_id));
		else:
			$valid = checkPlanValid($pro_id,$user_id);
			if($valid)
			{
				$data = [
					'status'=> '1',
					'active' => '0',
					'extended_plan' => '1',
				];
				logs($user->id,$insert_id,'ADD','Renew New  Package Plan by Host');
				$this->db->where('id', $insert_id)->update('user_assign_package', $data);
			}else{
				$this->db->where('user_id', $user_id)->update('user_assign_package',['active'=>'0']);
				$data = [
					'status'=> '1',
					'active' => '1',
				];
				logs($user->id,$insert_id,'ADD','Renew New  Package Plan by Host');
				$this->db->where('id', $insert_id)->update('user_assign_package', $data);
			}
		
			echo json_encode(array('flag'=>'notresponse'));
		endif;
		}
	  }else
	  {
		echo json_encode(array('flag'=>'error','msg'=>'Sorry enter room number should be grater than property rooms!'));
	  }
	}else
	{
	  echo json_encode(array('flag'=>'error','msg'=>'Sorry you not enter room  less than selected previous room!'));
	}
  }else{
	if($total_rooms <= $_POST['room']){
		$gst_amount = ($rs2->price*$rs2->gst)/100;
		$total =$rs2->price+$gst_amount;
		$currentDate = new DateTime(); // Assuming $currentDate is a DateTime object
		$newDate = $currentDate->modify('+' . $rs2->duration_in_days . ' days')->format('Y-m-d');
		 $datas = array(
		'property_id'    =>$pro_id,
		'package_id'    =>$_POST['plan'],
		'user_id'    =>$user->id,
		'start_date'    =>date('Y-m-d'),
		'price'       =>$rs2->price,
		'no_of_days'     =>$rs2->duration_in_days,
		'gst'     =>$rs2->gst,
		'gst_amount'     =>$gst_amount,
		'total'     =>$total,
		'min_room'     =>$rs2->min_room,
		'max_room'     =>$rs2->max_room,
		'selected_room'     =>$_POST['room'],
		'active'=>'1',
		'expiry_date'   =>$newDate,
		'extended_plan'=>'0',

   );
   if($insert_id = $this->model->Save('user_assign_package',$datas)) {
	$orderIds = $insert_id;	
	//razorpay code
	$date = strtotime("now");
	$mon=date('M', $date);
	//generate unique orderid 
	$num_padded = sprintf("%05d", $insert_id);
	$code="CK".strtoupper($mon).$num_padded;
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
				'total' => $payable_final_amt
			)
		);

		//get user details by userid
	   
		$user_detail = $this->model->getRow('usermaster',['id'=>$user_id]);
		$user_name = $user_detail->name;
		$user_mobile = $user_detail->mobile;
		$user_email = $user_detail->email;
		echo json_encode(array('flag'=>'success','data'=>$response,'user_name'=>$user_name,'user_mobile'=>$user_mobile,'user_email'=>$user_email,'order_id'=>$orderIds,'property_id'=>$pro_id, 'total'=>$payable_final_amt));
	else:
		$valid = checkPlanValid($pro_id,$user_id);
		if($valid)
		{
			$data = [
				'status'=> '1',
				'active' => '0',
				'extended_plan' => '1',
			];
			logs($user->id,$insert_id,'ADD','Renew New  Package Plan by Host');
			$this->db->where('id', $insert_id)->update('user_assign_package', $data);
		}else{
			$this->db->where('user_id', $user_id)->update('user_assign_package',['active'=>'0']);
			$data = [
				'status'=> '1',
				'active' => '1',
			];
			logs($user->id,$insert_id,'ADD','Renew New  Package Plan by Host');
			$this->db->where('id', $insert_id)->update('user_assign_package', $data);
		}
	
		echo json_encode(array('flag'=>'notresponse'));
	endif;
	}
  }else
  {
	echo json_encode(array('flag'=>'error','msg'=>'Sorry enter room number should be grater than property rooms!'));
  }
  }
		
	}
	return TRUE;
	}
	

	public function thanks()
	{
	$data['user'] = $user 			= $this->checkLogin();
	 $data['title']     = 'Thanks';		
	 $data['contant']   = 'properties/thanks';
	 $this->template($data);
	}
	

	public function activatePlan() {
		$data['user'] = $user 			= $this->checkLogin();
		$plan_id = trim($this->input->post('plan_id'));
		$property = trim($this->input->post('property'));
		$userid = trim($this->input->post('user_id'));
	
		if (!empty($plan_id) && !empty($userid)) {
			$update = $this->model->Update('user_assign_package', ['active' => '0'], ['user_id' => $userid]);
			if ($update) {
				$data = [
					'active' => '1',
					'extended_plan' => '0'
				];
				 $this->db->where('id', $plan_id)->update('user_assign_package', $data);
	
				if ($this->db->affected_rows() > 0) {
					logs($user->id,$plan_id,'ADD','Plan activated by Host');
					$response = array('success' => true, 'message' => 'Plan activated successfully.');
				} else {
					$response = array('success' => false, 'message' => 'Failed to activate the plan.');
				}
			} else {
				$response = array('success' => false, 'message' => 'Failed to deactivate previous plans.');
			}
		} else {
			$response = array('success' => false, 'message' => 'Invalid plan ID or user ID.');
		}
	
		echo json_encode($response);
	}
	
	


}
