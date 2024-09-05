<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Reports extends Main {
	public function __construct() {
         parent::__construct();
	 $data['user'] = $user = $this->checkLogin();
	 if ($user->type=='host') {
          $this->checkPlan(@$_COOKIE['property_id']);
	 }
	$this->check_role_menu();
	}

	
	public function sales_report($action=null,$id=null)
	{
	$data['user'] = $user = $this->checkLogin();
	$data['property_id'] = $id;
	switch ($action) {
	case null:
	$data['title'] 		= 'Sales Reports';
	$data['contant']  	= 'reports/sales/index';
        if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) {
		$this->db->where_in('id', $propmaster_ids);
		$this->db->where('approval_status', 'Approved');
		$this->db->where('status', '1');
		$query = $this->db->get('propmaster');
		$data['propmaster'] = $query->result();
		$this->db->where('owner_id', $user->id);
		$query1 = $this->db->get('agent');
		$data['agent'] = $query1->result();
		}
        }else
        {
        $data['propmaster']  = $this->model->getData('propmaster',['approval_status'=>'Approved','status'=>'1']);
        $data['agent']  = $this->model->getData('agent',0);
         }      
         $data['payment_status']  = $this->model->getData('payment_status',0);
        $data['b_status']  = $this->model->getData('booking_status',['active'=>'1']);
        $data['payment_mode']  = $this->model->getData('payment_mode',['status'=>'1']);
	$data['tb_url']	  	= base_url().'sales-report/tb';
	$this->template($data);
	break;
        case 'tb':
        $this->load->library('pagination');
        $config = array();
        $config["base_url"] = base_url()."reports/sales/tb";
        $data['search'] = '';
        if (@$_POST['search']) {
        $data['search'] = $_POST['search'];
        }
        if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) {
        $config["total_rows"]  = count($this->model->host_sales_report($propmaster_ids));
		}
        }else{    
        $config["total_rows"]  = count($this->model->sales_report());
        }
        $data['total_rows']    = $config["total_rows"];
        $config["per_page"]    = 200;
        $config["uri_segment"] = 3;
        $config['attributes']  = array('class' => 'pag-link');
        $this->pagination->initialize($config);
        $data["links"]   = $this->pagination->create_links();
        $data['page']    = $page = ($id!=null) ? $id : 0;
        $data['contant'] = 'reports/sales/tb';
        if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) { 
        $data['rows']    =  $this->model->host_sales_report($propmaster_ids,$config["per_page"],$page);
		}
        }else{  
        $data['rows']    =  $this->model->sales_report($config["per_page"],$page);
        }
        $data['user_role'] = $user->user_role;
        
        load_view($data['contant'],$data);
        break;
        default:
        break;
 
       }
      }

      public function arr_report($action=null,$id=null)
      {
      $data['user'] = $user = $this->checkLogin();
      $data['property_id'] = $id;
      switch ($action) {
      case null:
      $data['title'] 		= 'ARR Reports';
      $data['contant']  	= 'reports/arr/index';
      if ($user->type=='host') {
	      $userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
	      $propmaster_ids = [];
	      foreach ($userproperty as $up) {
	      $propmaster_ids[] = $up->propmasterid;
	      }
	      if (!empty($propmaster_ids)) {
	      $this->db->where_in('id', $propmaster_ids);
	      $this->db->where('approval_status', 'Approved');
	      $this->db->where('status', '1');
	      $query = $this->db->get('propmaster');
	      $data['propmaster'] = $query->result();
	      $this->db->where('owner_id', $user->id);
	      $query1 = $this->db->get('agent');
	      $data['agent'] = $query1->result();
	      }
      }else
      {
      $data['propmaster']  = $this->model->getData('propmaster',['approval_status'=>'Approved','status'=>'1']);
      $data['agent']  = $this->model->getData('agent',0);
       }      
       $data['payment_status']  = $this->model->getData('payment_status',0);
      $data['b_status']  = $this->model->getData('booking_status',['active'=>'1']);
      $data['payment_mode']  = $this->model->getData('payment_mode',['status'=>'1']);
      $data['tb_url']	  	= base_url().'arr-report/tb';
      $this->template($data);
      break;
      case 'tb':
      $this->load->library('pagination');
      $config = array();
      $config["base_url"] = base_url()."reports/arr/tb";
      $data['search'] = '';
      if (@$_POST['search']) {
      $data['search'] = $_POST['search'];
      }
      if ($user->type=='host') {
	      $userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
	      $propmaster_ids = [];
	      foreach ($userproperty as $up) {
	      $propmaster_ids[] = $up->propmasterid;
	      }
	      if (!empty($propmaster_ids)) {
      $config["total_rows"]  = count($this->model->host_arr_report($propmaster_ids));
	      }
      }else{    
      $config["total_rows"]  = count($this->model->arr_report());
      }
      $data['total_rows']    = $config["total_rows"];
      $config["per_page"]    = 200;
      $config["uri_segment"] = 3;
      $config['attributes']  = array('class' => 'pag-link');
      $this->pagination->initialize($config);
      $data["links"]   = $this->pagination->create_links();
      $data['page']    = $page = ($id!=null) ? $id : 0;
      $data['contant'] = 'reports/arr/tb';
      if ($user->type=='host') {
	      $userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
	      $propmaster_ids = [];
	      foreach ($userproperty as $up) {
	      $propmaster_ids[] = $up->propmasterid;
	      }
	      if (!empty($propmaster_ids)) { 
      $data['rows']    =  $this->model->host_arr_report($propmaster_ids,$config["per_page"],$page);
	      }
      }else{  
      $data['rows']    =  $this->model->arr_report($config["per_page"],$page);
      }
      $data['user_role'] = $user->user_role;
      
      load_view($data['contant'],$data);
      break;
      default:
      break;

     }
    }

      
      public function occupancy_report($action=null,$id=null)
      {
          $data['user'] = $user = $this->checkLogin();
          $data['property_id'] = $id;
          $view_dir = 'reports/occupancy/';
          switch ($action) {
          case null:
          $data['title'] 		= 'Occupancy Reports';
          $data['contant']  	= 'reports/occupancy/index';
          if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) {
		$this->db->where_in('id', $propmaster_ids);
		$this->db->where('approval_status', 'Approved');
		$this->db->where('status', '1');
		$query = $this->db->get('propmaster');
		$data['propmaster'] = $query->result();
		$this->db->where('owner_id', $user->id);
		$query1 = $this->db->get('agent');
		$data['agent'] = $query1->result();
		}
          }else
          {
          $data['propmaster']  = $this->model->getData('propmaster',['approval_status'=>'Approved','status'=>'1']);
          $data['agent']  = $this->model->getData('agent',0);
           }      
          $data['payment_status']  = $this->model->getData('payment_status',0);
          $data['room_type']  = $this->model->getData('sub_property_types',['active'=>'1','property_id'=>@$_COOKIE['property_id']]);
          $data['booking_type']  = $this->model->getData('booking_type_master',['active'=>'1']);
          $data['tb_url']	  	= base_url().'occupancy-report/tb';
          $this->template($data);
          break;
          case 'tb':
            $data['search'] = '';
            $search='null';
           
            if($id!=null)
                    {
            $data['search'] = $id;
            $search = $id;
                    }
                    //end of section
            if (@$_POST['search']) {
            $data['search'] = $_POST['search'];
            $search=$_POST['search'];
                   
                    }
            $this->load->library('pagination');
            
            $data['contant'] 		= $view_dir.'tb';
            $config = array();
            $config["base_url"] 	= base_url()."occupancy-report/tb";
	    if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) {
            $config["total_rows"]  	= count($this->model->host_occupancy_report($propmaster_ids,$search));
		}
	   }else{
	   $config["total_rows"]  	= count($this->model->occupancy_report($search));
	   }
            $data['total_rows']    	= $config["total_rows"];
            $config["per_page"]    	= 10;
            $config["uri_segment"] 	= 2;
            $config['attributes']  	= array('class' => 'pag-link ');
            $this->pagination->initialize($config);
            $data['links']   		= $this->pagination->create_links();
            $data['page']    		= $page = ($id!=null) ? $id : 0;
            $data['search']	 		= $this->input->post('search');
			if ($user->type=='host') {
			$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
			$propmaster_ids = [];
			foreach ($userproperty as $up) {
			$propmaster_ids[] = $up->propmasterid;
			}
			if (!empty($propmaster_ids)) {
				$data['rows']    		= $this->model->host_occupancy_report($propmaster_ids,$search,$config["per_page"],$page);
			}
	   }else{
	 $data['rows']    		= $this->model->occupancy_report($search,$config["per_page"],$page);
	   }
            load_view($data['contant'],$data);
            break;
          default:
          break;
   
         }
        }


        
        public function comparison_report($action=null,$id=null)
        {
            $data['user'] = $user = $this->checkLogin();
            $data['property_id'] = $id;
            $view_dir = 'reports/comparison/';
            switch ($action) {
            case null:
            $data['title'] 		= 'Comparison Reports';
            $data['contant']  	= 'reports/comparison/index';
            if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) {
		$this->db->where_in('id', $propmaster_ids);
		$this->db->where('approval_status', 'Approved');
		$this->db->where('status', '1');
		$query = $this->db->get('propmaster');
		$data['propmaster'] = $query->result();
		$this->db->where('owner_id', $user->id);
		$query1 = $this->db->get('agent');
		$data['agent'] = $query1->result();
		}
            }else
            {
            $data['propmaster']  = $this->model->getData('propmaster',['approval_status'=>'Approved','status'=>'1']);
            $data['agent']  = $this->model->getData('agent',0);
             }      
            $data['payment_status']  = $this->model->getData('payment_status',0);
            $data['room_type']  = $this->model->getData('sub_property_types',['active'=>'1','property_id'=>@$_COOKIE['property_id']]);
            $data['booking_type']  = $this->model->getData('booking_type_master',['active'=>'1']);
            $data['tb_url']	  	= base_url().'comparison-report/tb';
            $this->template($data);
            break;
            case 'tb':
                if ($user->type=='host') {
                  if (@$_POST['property']) {
                                $prop_id = $_POST['property'];    
                        }else{
                                $prop_id =@$_COOKIE['property_id'];   
                        }
                if (@$_POST['year']) {
		$data['year']=$year = $_POST['year'];
                $data['yearchart']    = $this->model->getYearSales($prop_id,@$year);
		}else
                {
                 $data['yearchart']    ='';
                }
                if (@$_POST['daterange']) {
                   $data['daterange']=$daterange = $_POST['daterange'];
                  $data['dayschart']    = $this->model->getDaySales($prop_id,@$daterange);
                }
                if (@$_POST['type']=='Yearly') {
                        $data['getYearlyData'] = $this->model->getYearlyData($prop_id);
                     } 
                }else
                {
                        if (@$_POST['property']) {
                                $prop_id = $_POST['property'];    
                        }else{
                                $prop_id ='';    
                        }
                        if (@$_POST['year']) {
                        $data['year']=$year = $_POST['year'];
                        $data['yearchart']    = $this->model->getYearSalesAdmin($prop_id,@$year);
                        }else
                        {
                         $data['yearchart']    ='';
                        }
                        if (@$_POST['daterange']) {
                           $data['daterange']=$daterange = $_POST['daterange'];
                          $data['dayschart']    = $this->model->getDaySalesAdmin($prop_id,@$daterange);
                        }
                        if (@$_POST['type']=='Yearly') {
                                $data['getYearlyData'] = $this->model->getYearlyDataAdmin($prop_id);
                             }       
                }
              $data['contant'] 		= $view_dir.'tb';
              load_view($data['contant'],$data);
              break;
            default:
            break;
     
           }
          }

  
		public function expanse_report($action=null,$id=null)
		{
		$data['user'] = $user = $this->checkLogin();
		$data['property_id'] = $id;
		switch ($action) {
		case null:
		$data['title'] 		= 'Expanse Reports';
		$data['contant']  	= 'reports/expanse/index';
		if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) {
		$this->db->where_in('id', $propmaster_ids);
		$this->db->where('approval_status', 'Approved');
		$this->db->where('status', '1');
		$query = $this->db->get('propmaster');
		$data['propmaster'] = $query->result();
		$this->db->where_in('prop_id', $propmaster_ids);
		$query1 = $this->db->get('expense_master');
		$data['expense_master'] = $query1->result();
		}
		}else
		{
		$data['propmaster']  = $this->model->getData('propmaster',['approval_status'=>'Approved','status'=>'1']);
		$data['expense_master']  = $this->model->getData('expense_master',0);
		}      
		$data['tb_url']	  	= base_url().'expanse-report/tb';
		$this->template($data);
		break;
		case 'tb':
		$this->load->library('pagination');
		$config = array();
		$config["base_url"] = base_url()."reports/expanse/tb";
		$data['search'] = '';
		if (@$_POST['search']) {
		$data['search'] = $_POST['search'];
		}
		if ($user->type=='host') {
			$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
			$propmaster_ids = [];
			foreach ($userproperty as $up) {
			$propmaster_ids[] = $up->propmasterid;
			}
			if (!empty($propmaster_ids)) {
		$config["total_rows"]  = count($this->model->host_expanse_report($propmaster_ids));
			}
		}else{    
		$config["total_rows"]  = count($this->model->expanse_report());
		}
		$data['total_rows']    = $config["total_rows"];
		$config["per_page"]    = 20;
		$config["uri_segment"] = 3;
		$config['attributes']  = array('class' => 'pag-link');
		$this->pagination->initialize($config);
		$data["links"]   = $this->pagination->create_links();
		$data['page']    = $page = ($id!=null) ? $id : 0;
		$data['contant'] = 'reports/expanse/tb';
		if ($user->type=='host') {
			$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
			$propmaster_ids = [];
			foreach ($userproperty as $up) {
			$propmaster_ids[] = $up->propmasterid;
			}
			if (!empty($propmaster_ids)) {  
		$data['rows']    =  $this->model->host_expanse_report($propmaster_ids,$config["per_page"],$page);
		}
		}else{  
		$data['rows']    =  $this->model->expanse_report($config["per_page"],$page);
		}
		$data['user_role'] = $user->user_role;
		
		load_view($data['contant'],$data);
		break;
		default:
		break;

		}
		}

		// tax_report
		public function tax_report($action=null,$id=null)
		{
		$data['user'] = $user = $this->checkLogin();
		$data['property_id'] = $id;
		switch ($action) {
		case null:
		$data['title'] 		= 'Tax Reports';
		$data['contant']  	= 'reports/tax/index';
		if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) {
		$this->db->where_in('id', $propmaster_ids);
		$this->db->where('approval_status', 'Approved');
		$this->db->where('status', '1');
		$query = $this->db->get('propmaster');
		$data['propmaster'] = $query->result();
		}
		}else
		{
		$data['propmaster']  = $this->model->getData('propmaster',['approval_status'=>'Approved','status'=>'1']);
		}      
		$data['tb_url']	  	= base_url().'tax-report/tb';
		$this->template($data);
		break;


		case 'tb':
		$this->load->library('pagination');
		$config = array();
		$config["base_url"] = base_url()."reports/tax/tb";
		$data['search'] = '';
		if (@$_POST['search']) {
		$data['search'] = $_POST['search'];
		}
		if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) {
		$config["total_rows"]  = count($this->model->host_tax_report($propmaster_ids));
		}
		}else{    
		$config["total_rows"]  = count($this->model->tax_report());
		}
		$data['total_rows']    = $config["total_rows"];
		$config["per_page"]    = 20;
		$config["uri_segment"] = 3;
		$config['attributes']  = array('class' => 'pag-link');
		$this->pagination->initialize($config);
		$data["links"]   = $this->pagination->create_links();
		$data['page']    = $page = ($id!=null) ? $id : 0;
		$data['contant'] = 'reports/tax/tb';
		if ($user->type=='host') {
		$userproperty = $this->model->getData('propaccess', ['userid' => $user->id]);
		$propmaster_ids = [];
		foreach ($userproperty as $up) {
		$propmaster_ids[] = $up->propmasterid;
		}
		if (!empty($propmaster_ids)) {
		$data['rows']    =  $this->model->host_tax_report($propmaster_ids,$config["per_page"],$page);
		}
		}else{  
		$data['rows']    =  $this->model->tax_report($config["per_page"],$page);
		}
		$data['user_role'] = $user->user_role;

		load_view($data['contant'],$data);
		break;
		default:
		break;

		}
		}


		}
