<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Expenses  extends Main {

	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function index($action = null , $p1 = null , $p2 = null)
	{
		$data['user'] = $user = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] 		= 'Expenses';
				$data['contant']  	= 'accounts/expenses/index';
				$urlappend 			= 'none';
				if (@$_POST) {
					$urlappend 		= urlencode(base64_encode(serialize($_POST)));
				}

				$data['tb_url']	  	= base_url().'expenses/tb?data='.$urlappend;
				$function 			= 'propmaster';
				if ($user->type 	=='host') {
					$function 		= 'host_propmaster';
				}
				$data['from']  		= date("Y-m-d",strtotime(date('Y-m-d').'- 30 day '));
				$data['to']  		= date('Y-m-d');
				if(!empty(@$_COOKIE['property_id'])){
				$data['propmaster'] = $this->model->$function();
				$data['expmaster'] 	= $this->model->getData('expense_master',['prop_id'=>@$_COOKIE['property_id']],'asc','name');
				}
				$this->template($data);
				break;

			case 'tb':

				$_POST['from'] = date("Y-m-d",strtotime(date('Y-m-d').'- 30 day '));
				$_POST['to']   = date('Y-m-d');

				if (@$_GET['data']!='none') {
					// $_GET['data'] = (base64_decode(unserialize($_GET['data'])));
					$_GET['data'] 	= unserialize(base64_decode(urldecode($_GET['data'])));
					$_POST['from'] 	= $_GET['data']['from'];
					$_POST['to'] 	= $_GET['data']['to'];
				}

				$from = "'".$_POST['from']."'";
				$to = "'".$_POST['to']."'";

				$this->db->where("date between $from AND $to" , Null);
				$this->db->order_by('id','desc');
				$data['rows'] = $this->model->getData('expense_data',['prop_master_id'=>@$_COOKIE['property_id']],'desc','date_time');
				$data['contant'] = 'accounts/expenses/tb';
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					if(!empty($_POST['prop_master_id'])){
					
					
					$old_receipt = $_POST['old_receipt']; unset($_POST['old_receipt']);
					

					if (@$_POST['id']) {
						$cond['id'] = $_POST['id'];
						unset($_POST['id']);
						if($this->model->Update('expense_data',$_POST,$cond)){
							logs($user->id,$_POST['id'],'EDIT','Edit Expenses ');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}
					else {
						// $_POST['date_time'] = date('d-M-Y h:m a');
						$_POST['date'] = date('Y-m-d',strtotime($_POST['date_time']));
						$_POST['user_ID']   = $user->id;
						if ($cond['id'] = $this->model->Save('expense_data',$_POST)) {
							logs($user->id,$cond['id'],'ADD','Add Expenses ');
							$return['res'] = 'success';
							$return['msg'] = 'Saved.';
						}
					}

					if ($return['res']=='success') {
						if (@$_FILES['photo']['name']) {
							if ($file_name = $this->_uploadFile('expenses','photo')) {
								$u['photo'] = $file_name;
								$fileerror =  "File upload error".$this->upload->display_errors();
								$return['res'] = 'error';
								$return['msg'] = $fileerror;
								echo json_encode($return);
								die();
								if($this->model->Update('expense_data',$u,$cond)){
									logs($user->id,$cond['id'],'EDIT','Add Expenses Image');
									if (@$old_receipt) {
										$old_receipt = explode('/',$old_receipt);
										$old_receipt = end($old_receipt);
										$this->_unlink_file('expenses',$old_receipt);
									}
								}
							}
						}
						
					}
				  }else{
					$return['res'] = 'error';
					$return['msg'] = "Please select property first.";
				  }
				}
				echo json_encode($return);
				break;
			
			default:
				// code...
				break;
		}
	}

	public function type($action = null, $p1 = null, $p2 = null)
	{
		$data['user'] = $user = $this->checkLogin();
		switch ($action) {
			case null:
				$data['title'] 		= 'Expanses Type';
				$data['contant']  	= 'accounts/expense_type/index';
				$data['tb_url']	  	= base_url().'expense_type/tb';
				$this->template($data);
				break;

			case 'tb':
				$data['rows'] = $this->model->getexpensesData($user->id);
				$data['contant'] = 'accounts/expense_type/tb';
				$data['delete_url']		= base_url('expense_type/delete/');
				load_view($data['contant'],$data);
				break;

			case 'save':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$check['name'] = $_POST['name'];
					$check['id != '] = $_POST['id'];
					$check['prop_id'] = @$_COOKIE['property_id'];
					if (!$this->model->getRow('expense_master',$check)) {
						$save['prop_id']=  @$_COOKIE['property_id'];
						$save['name'] = $_POST['name'];
						if (@$_POST['id']) {
							$cond['id'] = $_POST['id'];
							if($this->model->Update('expense_master',$save,$cond)){
								logs($user->id,$cond['id'],'EDIT','Edit Expanses Type');
								$return['res'] = 'success';
								$return['msg'] = 'Saved.';
							}
						}
						else{
							if ($cond['id']=$this->model->Save('expense_master',$save)) {
								logs($user->id,$cond['id'],'ADD','Add Expanses Type');
								$return['res'] = 'success';
								$return['msg'] = 'Saved.';
							}
						}
					}
					else{
						$return['res'] = 'error';
						$return['msg'] = 'Expanse type already exists.';
					}
				}
				echo json_encode($return);
				break;
				case 'delete':
					$return['res'] = 'error';
					$return['msg'] = 'Not Deleted!';
					if ($p1!=null) {
					if($this->model->_delete('expense_master',['id'=>$p1])){
						logs($user->id,$p1,'DELETE','Delete Expanses Type');
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


}
