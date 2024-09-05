<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Main.php');
class Portal extends Main
{

	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }

	public function index()
	{
        $data['package'] = $this->model->getData('user_packages_master',['is_deleted'=>'NOT_DELETED','active'=>'1']);
        $data['title']  = 'The Hotel Reception';
        $data['page'] = 'portal/pages/home';
        $this->load->view('portal/includes/index',$data);
	}
    public function contact_us()
	{
        $data['title']  = 'Contact Us - The Hotel Reception';
        $data['page'] = 'portal/pages/contact_us';
        $this->load->view('portal/includes/index',$data);
	}
    public function about_us()
	{
        $data['title']  = 'About Us - The Hotel Reception';
        $data['page'] = 'portal/pages/about_us';
        $this->load->view('portal/includes/index',$data);
	}
    public function privacy_policy()
	{
        $data['title']  = 'Privacy Policy - The Hotel Reception';
        $data['page'] = 'portal/pages/privacy_policy';
        $this->load->view('portal/includes/index',$data);
	}

    public function terms_condition()
	{
        $data['title']  = 'Terms Conditions - The Hotel Reception';
        $data['page'] = 'portal/pages/terms_condition';
        $this->load->view('portal/includes/index',$data);
	}
	
	 public function cancellations_refund()
	{
        $data['title']  = 'Cancellation & Refund - The Hotel Reception';
        $data['page'] = 'portal/pages/cancellation_refund';
        $this->load->view('portal/includes/index',$data);
	}
	
	 public function shipping_delivery()
	{
        $data['title']  = 'Shipping & Delivery - The Hotel Reception';
        $data['page'] = 'portal/pages/shipping_delivery';
        $this->load->view('portal/includes/index',$data);
	}
    
        
        public function enquiry($action=null,$p1=null)
	{
		$data['user'] = $user   = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title']      = 'Enquiry';
				$data['contant']    = 'portal/enquiry/index';
				$data['tb_url']	    = base_url().'enquiry/tb';
                                $data['search']	 		= $this->input->post('search');
				$this->template($data);
				break;

			case 'tb':
                                $user = $user->id;
                                $this->load->library('pagination');
                                
                                $data['contant'] 		='portal/enquiry/tb';
                                $config = array();
                                $config["base_url"] 	= base_url()."enquiry/tb";
                                $config["total_rows"]  	= count($this->model->all_enquiry());
                                $data['total_rows']    	= $config["total_rows"];
                                $config["per_page"]    	= 10;
                                $config["uri_segment"] 	= 2;
                                $config['attributes']  	= array('class' => 'pag-link ');
                                $this->pagination->initialize($config);
                                $data['links']   		= $this->pagination->create_links();
                                $data['page']    		= $page = ($p1!=null) ? $p1 : 0;
                                $data['search']	 		= $this->input->post('search');
                                $data['delete_url']		= base_url('service-boy/delete/');
                                $data['rows']    		= $this->model->all_enquiry($config["per_page"],$page);
                                load_view($data['contant'],$data);
				
			break;

                        default:
                        break;

                }
                
        }
        
     function update_status_en($response='yes'){
	$data['user'] = $user   = $this->checkLogin();
		$saved=0;
		// echo json_encode($_POST);
		$check['id']  = $_POST['id'];

		$update['status'] = $_POST['type'];
		if($this->model->getRow('enquiry',$check)){
			if ($this->model->Update('enquiry',$update,$check)) {
				logs($user->id,$_POST['id'],'CHANGE_STATUS','Enquiry change status - '.$_POST['type']);
				$saved = 1;
                                // echo 'Hello';die();
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
		
	}



}


