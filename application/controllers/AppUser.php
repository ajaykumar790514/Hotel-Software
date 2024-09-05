<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class AppUser extends Main {

	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	
	public function users($action=null,$id=null)
	{
		$data['user']    = $this->checkLogin();
		switch ($action) {
			case null:
				echo "string";
			break;

			case 'tb':
				echo "tb";
			break;

			case 'search':
				if(!empty($_POST["keyword"])) {
					$pro_id = $_POST['propmaster'];
					 $this->db
					->from('appuser')
					->select('*')
					->where(['is_deleted'=>'NOT_DELETED','property_id'=>$pro_id]) 
					->order_by('name','asc');					
					if (@$_POST['keyword']) {
						$data['keyword'] = $_POST['keyword'];
						$this->db->group_start();
						$this->db->like('mobile',$_POST["keyword"]);
					    $this->db->or_like('name',$_POST["keyword"]);
						$this->db->group_end();
					}
	               	$appuser =  $this->db->get()->result();
					// $this->db->like('mobile',$_POST["keyword"]);
					// $this->db->or_like('name',$_POST["keyword"]);
			     	// $appuser   = $this->model->getData('appuser',['property_id'=>$pro_id],'asc','name');
				
					if(!empty($appuser)) {
						echo'<ul id="country-list">';
						foreach($appuser as $aurow) {
					?>
					<li onClick="selectUser('<?=$aurow->mobile?>',<?=$aurow->id?>);"><?=$aurow->name?> - <?=$aurow->mobile?></li>
					<?php } 
				echo '</ul>';
				} } 
				break;

			case 'detailes':
				if(!empty($_POST["id"])) {
					$_POST['id'];
					$response['name']   = '';
					$response['dob']	= '';
					$response['gender']	= '';
					$response['email']	= '';
					if ($appuser  = $this->model->getRow('appuser',['id'=>$_POST['id']])) {
						$response['name']   = $appuser->name;
						$response['dob']	= $appuser->dob;
						$response['gender']	= $appuser->gender;
						$response['email']	= $appuser->email;
					}

					echo json_encode($response);
				}
				break;

			case 'verification_code':
				// echo json_encode($_POST);
				$return['res'] = 'error';
				$return['msg'] = 'Verification Code Not Send!';
				if ($this->gen_Otp($_POST['mobile'])) {
					$return['res'] = 'success';
					$return['msg'] = 'Verification Code Send Successfully.';
				}
				echo json_encode($return);
				break;
		}

	}



	function gen_Otp($mobile){
		$this->delete_old_otp();
		$otp=rand( 10000 , 99999 );
		$data=$this->model->getRow('otp',array('mobile'=>$mobile));
		if ($data) {
			$otp=$data->otp;
		}
		else
		{
			$this->send_sms($otp,$mobile);
			$d=array('mobile'=>$mobile,'otp'=>$otp,'time'=>time());
			$this->model->Save('otp',$d);
		}	
		return true;
	}

	function resend_Otp($mobile){
		$this->delete_old_otp();
		$otp=rand ( 10000 , 99999 );	
		$data=$this->model->getRow('otp',array('mobile'=>$mobile));
		if ($data) {
			$otp=$data->otp;
		}
		else
		{
			$d=array('mobile'=>$mobile,'otp'=>$otp,'time'=>time());
			$this->model->Save('otp',$d);
		}	
		$this->send_sms($otp,$mobile);
		echo "Resend";
	}

	public function delete_old_otp()
	{
		$data=$this->model->getData('otp');
		foreach ($data as $row) {
			$time =  time()-(int)$row->time;
			if ($time>=900) {
				$this->model->Delete('otp',array('id' => $row->id));
			}
			
		}
	}

	function send_sms($otp,$mob)
	{
	 	file_get_contents("http://techfizone.com/send_sms?mob=".$mob."&otp=".$otp."&id=EasyCareer");
	}
}
