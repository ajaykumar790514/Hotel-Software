<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Website extends Main {

	public function index($action=null,$id=null)
	{

	}

	public function properties($action=null,$id=null)
	{
		$data['user']    = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] = 'Website Properties';
				$data['contant'] = 'website/properties/index';
				$data['tb_url']	  =  base_url().'website/properties/tb';
				$data['new_url']	  =  base_url().'website/properties/new';
				$this->template($data);
				break;

			case 'tb':
				$data['contant'] 	  = 'website/properties/tb';
				$data['update_url']	  =  base_url().'website/properties/update/';
				$data['delete_url']	  =  base_url().'website/properties/delete/';
				$rows   			  = $this->model->getData('website_properties',0);
				foreach ($rows as $row) {
					$flat_name = array();
					$flat_ids = explode(',', $row->flat_ids);
                    foreach ($flat_ids as $frow) {
                    	if($flat = $this->model->getRow('property',['flat_id'=>$frow])){
                    		$flat_name[] = 'Property Master - '.title('propmaster',$flat->propid,'id','propname').'<br> Flat - '.$flat->flat_name;
                    	}
                    }
                    $row->flat_name = $flat_name;
                    unset($flat_name);
				}
				$data['rows'] = $rows;
				load_view($data['contant'],$data);
				break;

			case 'new':
				$data['title'] = 'New Website Property';
				$data['contant'] = 'website/properties/new';
				$data['back_url']	  =  base_url().'website/properties';
				$data['action_url']	  =  base_url().'website/properties/save';
				$data['properties']  = $this->model->getData('propmaster',0,'asc','propname');
				$data['states']      = $this->getStates(101,null,true);
				$data['flats']  = $this->model->getData('property',0,'asc','flat_name');
				$this->template($data);
				break;

			case 'update':
				$data['title'] = 'Update Website Property';
				$data['contant'] = 'website/properties/update';
				$data['back_url']	  =  base_url().'website/properties';
				$data['action_url']	  =  base_url().'website/properties/save/'.$id;
				$data['properties']  = $this->model->getData('propmaster',0,'asc','propname');
				$flats  = $this->model->getData('property',0,'asc','flat_name');
				$data['states']      = $this->getStates(101,null,true);
				$data['row']  = $this->model->getRow('website_properties',['id'=>$id]);
				if($data['row']->flat_ids){
					$sflat_ids = explode(',', $data['row']->flat_ids);
				}
				else{
					$sflat_ids =array();
				}
				
				$selected_flats = '';
				foreach ($flats as $frow) {
					$checked = '';
					foreach ($sflat_ids as $sf_id) {
						if ($frow->flat_id==$sf_id) {
							$checked = 'checked';
							$selected_flats .= "<span class='sflat' id='$sf_id'>".$frow->flat_name."( ".$frow->flat_no." )<i class='la la-close'></i></span>";
						}
					}
					$frow->checked = $checked;					
				}
				$data['flats'] = $flats;
				$data['selected_flats'] = $selected_flats;
				$this->template($data);
				break;

			case 'propmasters':
				if (@$_POST['search']) {
					$this->db->like('propname', $_POST['search']);
					$this->db->or_like('propcodename', $_POST['search']);
					$this->db->or_like('propcode', $_POST['search']);
			    }
			    $cond = null;
			    if (@$_POST['state']) { $this->db->having('state', $_POST['state']);}
			    if (@$_POST['city']) { $this->db->having('city', $_POST['city']);  }

			    $properties  = $this->model->getData('propmaster',$cond,'asc','propname');
			    if ($properties) {
			    	foreach ($properties as $row) {
	                    echo "<li>";
	                    $pmaster = $row->propname.' ( '.$row->propcode.' )';
	                    echo checkbox('properties',$row->id,$pmaster,$row->status);
	                    echo "</li>";
	                }
			    }
                else{
                	echo "<li>";
                	echo "<span class='text-danger'>Property Not Fount!</span>";
                	echo "</li>";
                }
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';

				if ($this->input->server('REQUEST_METHOD')=='POST') {
					unset($_POST['properties']);
					$_POST['flat_ids'] = implode(',', $_POST['flat_ids']);
					if ($id!=null) {
						if($this->model->Update('website_properties',$_POST,['id'=>$id])){
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else{
						if($this->model->Save('website_properties',$_POST)){
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
					if ($this->model->Delete('website_properties',['id'=>$id])) {
						$return['res'] = 'success';
						$return['msg'] = 'Deleted Successfully.';
					}
					echo json_encode($return);	
				break;

			}
	}


	public function create_json_file()
	{
		$this->load->helper('file');
		$defLargeImg = 'https://myrentalstay.in/public/defaults/no-image-large.png';
		$defSmallImg = 'https://myrentalstay.in/public/defaults/no-image-small.jpeg';
		// Start :: nearbyDefaultList
		$cond = ['status'=>1,'visible_in_website'=>1];
		$locations   = $this->model->getData('location',$cond,'asc','indexing');
		unset($cond);
		
		$n=1;
		for ($i=0; $i < count($locations); $i++) { 

			if ($n==1) {
				$array = 'nearbyDefaultList';
			}
			else{
				$array = 'nearbyDefaultList'.$n;
			}
			$array = 'nearbyDefaultList';


			$response[$array][] = array('id'	=> $locations[$i]->id,
									'name'	=> $locations[$i]->name,
									'image'	=> ($locations[$i]->image) ? img_base_url().$locations[$i]->image : $defLargeImg ,
									'desc'	=> '');
			// $i++;
			// if (@$locations[$i]) {
			// 	$response[$array][] = array('id'	=> $locations[$i]->id,
			// 						'name'	=> $locations[$i]->name,
			// 						'image'	=> $locations[$i]->image,
			// 						'desc'	=> '');
			// }
			
			// $i++;

			// if (@$locations[$i]) {
			// 	$response[$array][] = array('id'	=> $locations[$i]->id,
			// 						'name'	=> $locations[$i]->name,
			// 						'image'	=> $locations[$i]->image,
			// 						'desc'	=> '');
			// }
			
			// $i++;
			// if (@$locations[$i]) {
			// $response[$array][] = array('id'	=> $locations[$i]->id,
			// 						'name'	=> $locations[$i]->name,
			// 						'image'	=> $locations[$i]->image,
			// 						'desc'	=> '');
			// }
		$n++;
		}
		// End :: nearbyDefaultList

		// Start :: propertyTypes
		$cond = ['status'=>1];
		$properties   = $this->model->getData('website_properties',$cond,'asc','indexing'); unset($cond);
		if (@$properties) {
			$n=1;
			foreach ($properties as $key => $value) {
				$flat_ids = explode(',', $value->flat_ids);
				$list = array();
				foreach ($flat_ids as $fid) {
					$cond = ['flat_id'=>$fid];
					// $cond = ['status'=>1,'flat_id'=>$fid];
					$flat  = $this->model->getRow('property',$cond); unset($cond);
					$cond = ['flatid'=>$fid,'iscover'=>1];
					$img  = $defSmallImg;
					if($flat_img = $this->model->getRow('propertypic',$cond)){
						$img = img_base_url().$flat_img->photo;
					}
					else{
						unset($cond);
						$cond = ['flatid'=>$fid];
						if($flat_img = $this->model->getRow('propertypic',$cond)){
							$img = img_base_url().$flat_img->photo;
						}
					}

					$list[] = array('id'		=> $flat->propid,
									'flat_id'	=> $flat->flat_id,
									'name'		=> $flat->flat_name,
									'image'		=> $img
								);
				}

				if ($n==1) {
					$array = 'propertyTypes';
				}
				else{
					$array = 'propertyTypes'.$n;
				}

				$array = 'propertyTypes';

				$response[$array][] = array('heading'	=> $value->heading ,
											'headId'	=> $value->id,
										  	'subtitle'  => $value->subHeading,
	     									'list'		=> $list
	     					);
				unset($list);

				$n++;
			}
		}

		// die();
		
		// End :: propertyTypes





		// Start :: hostFeatures
     	$hostFeatures = array('heading' =>'Join millions of hosts on Myrentalstay' ,
     						'list' =>  array(
     									  array("id"	=> 1, 
				     							"name"	=> "Host your home", 
				     							"image"	=> "https://www.youtube.com/embed/IgAnj6r1O48"),
     									  array("id" 	=> 2, 
				     							"name"	=> "Host an Online Experience", 
				     							"image"	=> "https://www.youtube.com/embed/IgAnj6r1O48"),
     									  array("id" 	=> 3, 
				     							"name"	=> "Host and Experience", 
				     							"image"	=> "https://www.youtube.com/embed/IgAnj6r1O48"),
     										)
     					);
 		// End :: hostFeatures

 		// Start :: footerLinks
     	$footerLinks[] = array('id' => 1,
     						'heading' =>'ABOUT' ,
     						'list' =>  array(
     									  array("id" => 1, "name"=> "How Myrentalstay works", "path"=> ""),
     									  array("id" => 2, "name"=> "Newsroom", "path"=> ""),
     									  array("id" => 3, "name"=> "Investors", "path"=> ""),
     									  array("id" => 4, "name"=> "Myrentalstay Plus", "path"=> ""),
     									  array("id" => 5, "name"=> "Myrentalstay Luxe", "path"=> ""),
     									  array("id" => 6, "name"=> "HotelTonight", "path"=> ""),
     									  array("id" => 7, "name"=> "Myrentalstay for Work", "path"=> ""),
     									  array("id" => 8, "name"=> "Olympics", "path"=> ""),
     									  array("id" => 9, "name"=> "Careers", "path"=> "")
     										)
     					);
     	$footerLinks[] = array('id' => 2,
     						'heading' =>'COMMUNITY' ,
     						'list' =>  array(
     									  array("id" => 1, "name"=> "Diversity & Belonging", "path"=> ""),
     									  array("id" => 2, "name"=> "Accessibility", "path"=> ""),
     									  array("id" => 3, "name"=> "Myrentalstay Associates", "path"=> ""),
     									  array("id" => 4, "name"=> "Frontline Stays", "path"=> ""),
     									  array("id" => 5, "name"=> "Invite friends", "path"=> ""),
     									  array("id" => 6, "name"=> "Myrentalstay.org", "path"=> "")
     										)
     					);
     	$footerLinks[] = array('id' => 3,
     						'heading' =>'HOST' ,
     						'list' =>  array(
     									  array("id" => 1, "name"=> "Host your home", "path", "path"=> ""),
     									  array("id" => 2, "name"=> "Host an Online Experience", "path"=> ""),
     									  array("id" => 3, "name"=> "Host and Experience", "path"=> ""),
     									  array("id" => 4, "name"=> "Responsible hosting", "path"=> ""),
     									  array("id" => 5, "name"=> "Resource Center", "path"=> ""),
     									  array("id" => 6, "name"=> "Community Center", "path"=> "")
     									)
     					);
     	$footerLinks[] = array('id' => 4,
     						'heading' =>'SUPPORT' ,
     						'list' =>  array(
     									  array("id" => 1, "name"=> "Our COVID-19 Responsive", "path"=> ""),
     									  array("id" => 2, "name"=> "Help Center", "path"=> ""),
     									  array("id" => 3, "name"=> "Cancellation options", "path"=> ""),
     									  array("id" => 4, "name"=> "Neighbourhood Support", "path"=> ""),
     									  array("id" => 5, "name"=> "Trust & Safety", "path"=> "")
     										)
     					);
 		// End :: footerLinks


 		// Start :: futureGateways
     	$futureGateways = array('heading' =>'Inspiration for future getaways' ,
     						'list' =>array( 
     									 array(
											'id'		=> 1,
											'heading'	=> "Destinations for arts & culture",
											'list'		=>array(
	     									 	   array("id" => 1, "city" => "New York", "state" => "New York" ),
										           array("id" => 2, "city" => "Miami", "state" => "Florida" ),
										           array("id" => 3, "city" => "Austin", "state" => "Washington" ),
										           array("id" => 4, "city" => "Seattle", "state" => "Texas" ),
										           array("id" => 5, "city" => "Houson", "state" => "Arizona" ),
										           array("id" => 6, "city" => "Memphis", "state" => "Italy" ),
										           array("id" => 7, "city" => "New York", "state" => "New York" ),
										           array("id" => 8, "city" => "Miami", "state" => "Florida" ),
										           array("id" => 9, "city" => "Austin", "state" => "Washington" ),
										           array("id" => 10, "city" => "Seattle", "state" => "Texas" ),
										           array("id" => 11, "city" => "Houson", "state" => "Arizona" ),
										           array("id" => 12, "city" => "Memphis", "state" => "Italy" ),
										           array("id" => 13, "city" => "New York", "state" => "New York" ),
										           array("id" => 14, "city" => "Miami", "state" => "Florida" ),
										           array("id" => 15, "city" => "Austin", "state" => "Washington" ),
										           array("id" => 16, "city" => "Seattle", "state" => "Texas" ),
										           array("id" => 17, "city" => "Houson", "state" => "Arizona" ),
										           array("id" => 18, "city" => "Memphis", "state" => "Italy" ),
										           array("id" => 19, "city" => "New York", "state" => "New York" ),
										           array("id" => 20, "city" => "Miami", "state" => "Florida" ),
										           array("id" => 21, "city" => "Austin", "state" => "Washington" ),
										           array("id" => 22, "city" => "Seattle", "state" => "Texas" ),
										           array("id" => 23, "city" => "Houson", "state" => "Arizona" ),
										           array("id" => 24, "city" => "Memphis", "state" => "Italy" )
	     										)
										),
     									array(
											'id'		=> 2,
											'heading'	=> "Destinations for outdoor adventure",
											'list'		=>array(
	     									  		array("id" => 7, "city" => "Phoenix", "state" => "Arizona" ),
													array("id" => 8, "city" => "San Diego", "state" => "Florida" ),
													array("id" => 9, "city" => "Boston", "state" => "Arizona" ),
													array("id" => 10, "city" => "New York", "state" => "New York" ),
													array("id" => 11, "city" => "Miami", "state" => "Florida" ),
													array("id" => 12, "city" => "Austin", "state" => "Washington" ),
													array("id" => 13, "city" => "Seattle", "state" => "Texas" ),
													array("id" => 14, "city" => "Houson", "state" => "Arizona" ),
													array("id" => 15, "city" => "Memphis", "state" => "Italy" ),
													array("id" => 16, "city" => "Phoenix", "state" => "Arizona" )
	     										)
										),
										array(
											'id'		=> 3,
											'heading'	=> "Mountain cabins",
											'list'		=>array(
	     									  		array("id" => 17, "city" => "San Diego", "state" => "Florida" ),
												    array("id" => 18, "city" => "Boston", "state" => "Arizona" ),
												    array("id" => 19, "city" => "New York", "state" => "New York" ),
												    array("id" => 20, "city" => "Miami", "state" => "Florida" ),
												    array("id" => 21, "city" => "Austin", "state" => "Washington" ),
												    array("id" => 22, "city" => "Seattle", "state" => "Texas" )
	     										)
										),
										array(
											'id'		=> 4,
											'heading'	=> "Popular destinations",
											'list'		=>array(
	     									  		array("id" => 23, "city" => "Houson", "state" => "Arizona" ),
										          	array("id" => 24, "city" => "Memphis", "state" => "Italy" ),
										          	array("id" => 25, "city" => "Phoenix", "state" => "Arizona" )
	     										)
										)
									)
     					);
     
 		// End :: futureGateways

 		// $response['hostFeatures'] = $hostFeatures;
 		$response['footerLinks'] = $footerLinks;
 		$response['futureGateways'] = $futureGateways;
	
 		
 		$file = '../../mrsws/myrentalstay/public/json/homePage2.json';
		if (base_url()=='http://localhost/mrs/') {
			$file = '../../public/json/homePage2.json';
		}
		$created_json_file = 0;
		$fp = fopen($file, 'w');
        if (fwrite($fp, urldecode(json_encode($response,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)))){
 			$created_json_file = 1;
 		}

 		if ($created_json_file==1) {
 			$res['res'] = 'success';
 			$res['msg'] = 'File created successfully';
 		}
 		else{
 			$res['res'] = 'error';
 			$res['msg'] = 'File not created!';
 		}

 		echo json_encode($res);
	}





}