<?php

/**
 * 
 */
class Model extends CI_Model
{

	public function admin_menus($parent_menu = 00)
	{
		$this->db->order_by('indexing', 'asc');
		// if ($parent_menu != 00) {
		// 	$this->db->where('parent', $parent_menu);
		// }
		return $this->db->get('tb_admin_menu')->result();
	}

	// main functions

	function Save($tb, $data)
	{
		if ($this->db->insert($tb, $data)) {
			return $this->db->insert_id();
		}
		return false;
	}

	function SaveGetId($tb, $data)
	{
		if ($this->db->insert($tb, $data)) {
			return $this->db->insert_id();
		}
		return false;
	}
 /*
     *  Select Records From Table
     */
    public function Select($Table, $Fields = '*', $Where = 1)
    {
        /*
         *  Select Fields
         */
        if ($Fields != '*') {
            $this->db->select($Fields);
        }
        /*
         *  IF Found Any Condition
         */
        if ($Where != 1) {
            $this->db->where($Where);
        }
        /*
         * Select Table
         */
        $query = $this->db->get($Table);

        /*
         * Fetch Records
         */

        return $query->result();
    }
	  /*
     * Count No Rows in Table
     */
    public function Counter($tb, $Where = 1)
    {
        $rows = $this->Select($tb, '*', $Where);

        return count($rows);
    }


	function getData($tb, $data = 0, $order = null, $order_by = null, $limit = null, $start = null)
	{

		if ($order != null) {
			if ($order_by != null) {
				$this->db->order_by($order_by, $order);
			} else {
				$this->db->order_by('id', $order);
			}
		}

		if ($limit != null) {
			$this->db->limit($limit, $start);
		}

		if ($data == 0 or $data == null) {
			return $this->db->get($tb)->result();
		}
		if (@$data['search']) {
			$search = $data['search'];
			unset($data['search']);
		}
		return $this->db->get_where($tb, $data)->result();
	}



	function getRow($tb, $data = 0)
	{
		if ($data == 0) {
			if ($data = $this->db->get($tb)->row()) {
				return $data;
			} else {
				return false;
			}
		} elseif (is_array($data)) {
			if ($data = $this->db->get_where($tb, $data)) {
				return $data->row();
			} else {
				return false;
			}
		} else {
			if ($data = $this->db->get_where($tb, array('id' => $data))) {
				return $data->row();
			} else {
				return false;
			}
		}
	}

	function Update($tb, $data, $cond)
	{
		$this->db->where($cond);
		if ($this->db->update($tb, $data)) {

			return true;
		}
		return false;
	}



	function Delete($tb, $data)
	{
		if (is_array($data)) {
			$this->db->where($data);
			if ($this->db->delete($tb)) {
				return true;
			}
		} else {
			$this->db->where('id', $data);
			if ($this->db->delete($tb)) {
				return true;
			}
		}
		return false;
	}
	// main functions


	function propmaster($limit = null, $start = null)
	{
		$this->db->order_by('id', 'desc');
		if ($limit != null) {
			$this->db->limit($limit, $start);
		}
		if (@$_POST['search']) {
			$l_id = '';
			$this->db->like('name', $_POST['search']);
			if ($lid = $this->model->getRow('location')) {
				$l_id = $lid->id;
			}
			$this->db->or_like('propname', $_POST['search']);
			$this->db->or_like('contact_preson', $_POST['search']);
			if ($l_id != '') {
				$this->db->or_like('location_id', $l_id);
			}
		}

		$this->db->where(['is_deleted' => 'NOT_DELETED']);

		return $this->db->get('propmaster')->result();
	}

	function host_propmaster($prop_list = null)
	{

		$user_id = value_encryption(get_cookie('6050c764989e5'), 'decrypt');

		if ($propmaster_ids = $this->db->get_where('propaccess', ['userid' => $user_id])->result()) {
			foreach ($propmaster_ids as $propId) {

				// echo $propId.'<br>';
				if (@$_POST['search']) {
					$l_id = '';
					$this->db->like('name', $_POST['search']);
					if ($lid = $this->model->getRow('location')) {
						$l_id = $lid->id;
					}
					$this->db->or_like('propname', $_POST['search']);
					$this->db->or_like('contact_preson', $_POST['search']);
					if ($l_id != '') {
						$this->db->or_like('location_id', $l_id);
					}
				}

				//		        if ($prop_list==null) {
				//		        	$prop_id = get_cookie('property_id');
				//			        if (!empty($prop_id)) {
				//			        	$this->db->where('id', $prop_id);
				//			        }
				//		        }

				//$this->db->having('id', $propId->propmasterid);
				if ($prop = $this->db->where(['is_deleted' => 'NOT_DELETED', 'id' => $propId->propmasterid])->get('propmaster')->row()) {
					$propmaster[] = $prop;
					//array_push($propmaster,$prop);

				}
			}
		} else {
			return false;
		}
		//print_r($propmaster);
		return $propmaster;
	}
	function host_propmaster_dropdown($prop_list = null)
	{

		$user_id = value_encryption(get_cookie('6050c764989e5'), 'decrypt');

		if ($propmaster_ids = $this->db->get_where('propaccess', ['userid' => $user_id])->result()) {
			foreach ($propmaster_ids as $propId) {

				// echo $propId.'<br>';
				if (@$_POST['search']) {
					$l_id = '';
					$this->db->like('name', $_POST['search']);
					if ($lid = $this->model->getRow('location')) {
						$l_id = $lid->id;
					}
					$this->db->or_like('propname', $_POST['search']);
					$this->db->or_like('contact_preson', $_POST['search']);
					if ($l_id != '') {
						$this->db->or_like('location_id', $l_id);
					}
				}

				//		        if ($prop_list==null) {
				//		        	$prop_id = get_cookie('property_id');
				//			        if (!empty($prop_id)) {
				//			        	$this->db->where('id', $prop_id);
				//			        }
				//		        }

				//$this->db->having('id', $propId->propmasterid);
				if ($prop = $this->db->where(['status'=>'1','approval_status'=>'Approved','is_deleted' => 'NOT_DELETED', 'id' => $propId->propmasterid])->get('propmaster')->row()) {
					$propmaster[] = $prop;
					//array_push($propmaster,$prop);

				}
			}
		} else {
			return false;
		}
		//print_r($propmaster);
		return $propmaster;
	}

	

	public function bookings($limit = null, $start = null)
	{
		$flat_ids = array();

		if (@$_POST['property']) {
			$flat_ids[] = $_POST['property'];
		} else if (@$_POST['propmaster']) {
			$properties = $this->model->getData('property', ['propid' => $id]);
			foreach ($properties as $prow) {
				$flat_ids[] = $prow->flat_id;
			}
		}

		if (@$_POST['search']) {
			$this->db->like('guest_name', $_POST['search']);
			$this->db->or_like('email', $_POST['search']);
			$this->db->or_like('contact', $_POST['search']);
		}
		if (@$_POST['payment_status']) {
			$this->db->having('payment_status', $_POST['payment_status']);
		}
		if (@$_POST['status']) {
			$this->db->having('status', $_POST['status']);
		}

		foreach ($flat_ids as $flat_id) {
			$this->db->having('flat_id', $flat_id);
		}

		$this->db->order_by('start_date', 'desc');
		if ($limit != null) {
			$this->db->limit($limit, $start);
		}
		$this->db->having('extended', 0);
		// $this->db->having('flat_changed', 0);
		if ($bookings = $this->db->get('booking')->result()) {
			foreach ($bookings as $brow) {
				$brow->extended_b     = $this->extended_b($brow->id);
				// $brow->flat_changed_b = $this->flat_changed_b($brow->id);
			}

			return $bookings;
		}
		return false;
	}


	public function host_bookings($limit = null, $start = null)
	{

		$flat_ids = array();

		if (@$_POST['property'] != '') {
			$flat_ids[] = $_POST['property'];
		} else if (@$_POST['propmaster']) {
			$properties = $this->model->getData('property', ['propid' => $_POST['propmaster']]);
			foreach ($properties as $prow) {

				$flat_ids[] = $prow->flat_id;
			}
		}

		// echo prx($flat_ids);
		// die();

		$user_id = value_encryption(get_cookie('6050c764989e5'), 'decrypt');
		if (@$_POST['search']) {
			$this->db->like('guest_name', $_POST['search']);
			$this->db->or_like('email', $_POST['search']);
			$this->db->or_like('contact', $_POST['search']);
		}
		if (@$_POST['payment_status']) {
			$this->db->having('payment_status', $_POST['payment_status']);
		}
		if (@$_POST['status']) {
			$this->db->having('status', $_POST['status']);
		}

		if (@$flat_ids) {
			$this->db->where_in('flat_id', $flat_ids);
		}

		$this->db->order_by('start_date', 'desc');
		if ($limit != null) {
			// $this->db->limit($limit, $start);
		}
		// $this->db->having('extended', 0);

		if (@$_POST['b_from'] && @$_POST['b_to']) :
			$b_from = "'" . $_POST['b_from'] . "'";
			$b_to = "'" . $_POST['b_to'] . "'";
			$this->db->where(" start_date BETWEEN $b_from AND $b_to ", null);
		endif;

		// $this->db->having('flat_changed', 0);
		// $this->db->get('booking')->result();
		// echo $this->db->last_query();
		if ($bookings = $this->db->get('booking')->result()) {

			foreach ($bookings as $key => $brow) {

				$flat_id = $brow->flat_id;
				$property_id = get_cookie('property_id');
				// $brow->extended_b = false;
				if ($flat = $this->getRow('property', ['flat_id' => $flat_id, 'propid' => $property_id])) {

					if ($this->getRow('propaccess', ['userid' => $user_id, 'propmasterid' => $flat->propid])) {
						// $brow->extended_b     = $this->extended_b($brow->id);
						// $brow->flat_changed_b = $this->flat_changed_b($brow->id);

					} else {
						unset($bookings[$key]);
					}
				} else {
					unset($bookings[$key]);
				}
			}

			return $bookings;
			// echo "<pre>";
			// print_r($bookings);
			// echo "</pre>";
		}
		return false;
	}


	public function bookings_new($pro_id,$limit = null, $start = null)
	{
         

		if (@$_POST['search']) {
			$this->db->like('guest_name', $_POST['search']);
			$this->db->or_like('email', $_POST['search']);
			$this->db->or_like('contact', $_POST['search']);
		}
		if (@$_POST['payment_status']) {
			$this->db->having('payment_status', $_POST['payment_status']);
		}
		if (@$_POST['status']) {
			$this->db->having('status', $_POST['status']);
		}
		if (@$_POST['propmaster']) {
			$this->db->having('property_id', $_POST['propmaster']);
		}

		$this->db->order_by('start_date', 'desc');
		if ($limit != null) {
			$this->db->limit($limit, $start);
		}
		// $this->db->having('extended', 0);
		// $this->db->having('flat_changed', 0);
		if ($bookings = $this->db->get('booking_new')->result()) {
			foreach ($bookings as $brow) {
				// $brow->extended_b     = $this->extended_b($brow->id);
				// $brow->flat_changed_b = $this->flat_changed_b($brow->id);
			}

			return $bookings;
		}
		return false;
	}


	public function host_bookings_new($limit = null, $start = null)
	{
		$user_id = value_encryption(get_cookie('6050c764989e5'), 'decrypt');
		$property_id = get_cookie('property_id');
		if (@$_POST['checked_in'] == 'on') {
			$this->db->select('b.*,c.booking_id as checkin');
		} else {
			$this->db->select('b.*');
		}

		if (@$_POST['search']) {
			$this->db->like('b.guest_name', $_POST['search']);
			$this->db->or_like('b.email', $_POST['search']);
			$this->db->or_like('b.contact', $_POST['search']);
		}
		if (@$_POST['payment_status']) {
			$this->db->having('b.payment_status', $_POST['payment_status']);
		}
		if (@$_POST['status']) {
			$this->db->having('b.status', $_POST['status']);
		}
		$this->db->order_by('b.booking_date', 'desc');
		// $this->db->order_by('b.start_date', 'desc');
		if (@$_POST['propmaster']) {
			$this->db->having('b.property_id', $_POST['propmaster']);
		}
		if($property_id)
		{
			$this->db->where('b.property_id', $property_id);
		}

		if (@$_POST['checked_in'] == 'on') {
			// $this->db->having('checkin_status', 1);
			$this->db->join('checkin c', 'c.booking_id = b.id', 'right');
			$this->db->group_by('c.booking_id');
		}

		if (@$_POST['b_from'] && @$_POST['b_to']) :
			$b_from = "'" . $_POST['b_from'] . "'";
			$b_to = "'" . $_POST['b_to'] . "'";
			$this->db->where(" b.start_date BETWEEN $b_from AND $b_to ", null);
		endif;

		$this->db->from('booking_new b');
		if ($bookings = $this->db->get()->result()) {
			foreach ($bookings as $key => $brow) {
				
				if ($this->getRow('propaccess', ['userid' => $user_id, 'propmasterid' => @$property_id])) {
					// $brow->extended_b     = $this->extended_b($brow->id);
					// $brow->flat_changed_b = $this->flat_changed_b($brow->id);

				} else {
					unset($bookings[$key]);
				}

				$brow->check_out_list = $this->db->select('*')
					->where('booking_id', $brow->id)
					->from('checkout_new')
					->count_all_results();
			}
			return $bookings;
		}
		return false;
	}

	function booking_new_items($booking_id)
	{
		$this->db->select("mtb.*,type.name as type");
		$this->db->from('booking_new_items mtb');
		$this->db->join('sub_property_types type', 'type.spt_id=mtb.room_type', 'LEFT');
		$this->db->where('mtb.booking_id', $booking_id);
		$return = $this->db->get()->result();

		if (@$return) {
			foreach ($return as $key => $value) {
				$this->db->select("mtb.flat_no");
				$this->db->from('room_allotment mtb');
				$this->db->where('mtb.booking_id', $value->booking_id);
				$this->db->where('mtb.property_id', $value->property_id);
				$this->db->where('mtb.room_type', $value->room_type);
				$this->db->where('mtb.active', 1);
				$flats = $this->db->get()->result_array();
				$value->flats = array_map(function ($data) {
					return $data['flat_no'];
				}, $flats);
				$value->flats = (@$value->flats) ? implode(', ', $value->flats) : '';
			}
		}

		return $return;
	}
	// function booking_new_items($booking_id)
	// {
	// 	$this->db->select("mtb.*,type.name as type");
	// 	$this->db->from('booking_new_items mtb');
	// 	$this->db->join('sub_property_types type', 'type.spt_id=mtb.room_type', 'LEFT');
	// 	$this->db->where('mtb.booking_id', $booking_id);
	// 	$return = $this->db->get()->result();

	// 	if (@$return) {
	// 		foreach ($return as $key => $value) {
	// 			$this->db->select("mtb.flat_no");
	// 			$this->db->from('room_allotment mtb');
	// 			$this->db->where('mtb.booking_id', $value->booking_id);
	// 			$this->db->where('mtb.property_id', $value->property_id);
	// 			$this->db->where('mtb.room_type', $value->room_type);
	// 			$this->db->group_by('mtb.room_type');
	// 			$this->db->where('mtb.active', 1);
	// 			$flats = $this->db->get()->result_array();
	// 			$value->flats = array_map(function ($data) {
	// 				return $data['flat_no'];
	// 			}, $flats);
	// 			$value->flats = (@$value->flats) ? implode(', ', $value->flats) : '';
	// 		}
	// 	}

	// 	return $return;
	// }
	function checkin_rooms($booking_id)
	{
		$this->db->select('c.*,c.extra_bedding_price as extra_bed_price,spt.name as room_type_name, item.tax_value')
			->from('checkin c')
			->join('sub_property_types spt', 'spt.spt_id = c.room_type', 'left')
			->join('booking_new_items item', 'item.room_type = c.room_type AND item.booking_id = c.booking_id', 'left')
			->where('c.booking_id', $booking_id);
		
		$return = $this->db->get()->result();
		return $return;
	}
	

	function checkout_rooms($checkout_id)
	{
		$this->db->select('c.*,c.extra_bedding_price as extra_bed_price,spt.name as room_type_name, item.tax_value')
			->join('sub_property_types spt', 'spt.spt_id = c.room_type', 'left')
			->join('booking_new_items item', 'item.room_type = c.room_type AND item.booking_id = c.booking_id', 'left')
			->from('checkin c')
			->where('c.checkout_id',$checkout_id);
		$return = $this->db->get()->result();
		return $return;
	}
	function getDataBookingItem($booking_id, $room_type)
	{
		$this->db->select('SUM(c.qty) as TotalQty')
			->from('booking_new_items c')
			->where('c.booking_id', $booking_id);
		
		$query = $this->db->get();
		return $query->row();
	}
	public function CheckExistCheckin($checkin_ids)
	{
		// Convert single value or array to JSON format string for comparison
		$json_checkin_ids = json_encode($checkin_ids);
	
		// Query setup
		$this->db->select('c.*')
				 ->from('checkout_new c')
				 ->where("JSON_CONTAINS(c.check_in_ids, '$json_checkin_ids')");
		
		$query = $this->db->get();
		return $query->num_rows();
	}
	

	
	


	public function extended_b($booking_id)
	{
		$cond = ['ref_booking_id' => $booking_id, 'extended !=' => 0];
		return $this->getData('booking', $cond, 'desc');
	}

	public function flat_changed_b($booking_id)
	{
		$cond = ['ref_booking_id' => $booking_id, 'flat_changed !=' => 0];
		return $this->getData('booking', $cond, 'desc');
	}

	public function deleteSubHostPropaccess($host_id, $propmasterid)
	{
		if ($sub_host = $this->getData('usermaster', ['parent_id' => $host_id])) {
			foreach ($sub_host as $key => $value) {
				$check['userid']   			= $value->id;
				$check['propmasterid'] 		= $propmasterid;
				if ($this->getRow('propaccess', $check)) {
					$this->Delete('propaccess', $check);
				}
			}
		}
	}

	public function expenses($date, $propmaster_ids)
	{
		$date = "'" . $date . "'";
		$propmaster_ids 	=  implode(',', $propmaster_ids);
		$query = "SELECT SUM(amount) as totalAmount FROM expense_data 
						WHERE prop_master_id IN ($propmaster_ids) AND date = $date";
		$rows = $this->db->query($query)->result();
		// echo $this->db->last_query();
		return $rows[0];
		// echo "<pre>";
		// print_r($rows[0]);
		// echo "</pre>";
	}

	public function expenses_new($date, $propmaster_ids)
	{
		$date = "'" . $date . "'";
		$query = "SELECT SUM(amount) as totalAmount FROM expense_data 
						WHERE prop_master_id IN ($propmaster_ids) AND date = $date";
		$rows = $this->db->query($query)->result();
		// echo $this->db->last_query();
		return $rows[0];
		// echo "<pre>";
		// print_r($rows[0]);
		// echo "</pre>";
	}

	function getSubPropertyTypeOfProperty($prop_id)
	{
		$property_types = $this->db->select('sub_property_type_id')
			->group_by('sub_property_type_id')
			->from('property')
			->where('propid', $prop_id)
			->get()->result();
		if (@$property_types) {
			$property_types = array_map(function ($data) {
				return $data->sub_property_type_id;
			}, $property_types);

			$this->db->select('*')
				->from('sub_property_types')
				->where_in('spt_id', $property_types);
			return $this->db->get()->result();
		}
		return false;
	}

	function _delete($tb, $data)
	{
		if (is_array($data)) {
			$this->db->where($data);
			if ($this->db->update($tb, ['is_deleted' => 'DELETED'])) {
				return true;
			}
		} else {
			$this->db->where('id', $data);
			if ($this->db->update($tb, ['is_deleted' => 'DELETED'])) {
				return true;
			}
		}
		return false;
	}
	public function mobile_check($mobile)
	{
		$this->db->select("*")
		->from('usermaster')
		->where(['mobile'=>$mobile, 'isactive'=>'1']);
	
		return $this->db->get()->num_rows();
		
	}
	function updateRow($mobile,$data ){
		if($this->db->insert('usermaster_otp',$data)){
			return $this->db->insert_id();
		}
		return false; 
	
}

   public function otp_exist($otp)
	{
		$this->db->select("a.*")
		->from('usermaster_otp a')
		->where(['a.otp'=>$otp]);
		return $this->db->get()->num_rows();
		
	}
	public function admin_otp_exist($otp)
	{
		$this->db->select("a.*")
		->from('tb_admin_otp a')
		->where(['a.otp'=>$otp]);
		return $this->db->get()->num_rows();
		
	}
	public function otp_mail_exist($otp)
	{
		$this->db->select("a.*")
		->from('usermaster_email_otp a')
		->where(['a.otp'=>$otp]);
		return $this->db->get()->num_rows();
		
	}
	public function otp_mail_exist_row($otp)
	{
		$this->db->select("a.*")
		->from('usermaster_email_otp a')
		->where(['a.otp'=>$otp]);
		return $this->db->get()->row();
		
	}
	
	public function email_check($email)
	{
		$this->db->select("*")
		->from('usermaster')
		->where(['email'=>$email, 'isactive'=>'1']);
	
		return $this->db->get()->num_rows();
		
	}
	function updateemailRow($email,$data){
		if($this->db->insert('usermaster_email_otp',$data)){
			return $this->db->insert_id();
		}
		return false; 
	
}
public function email_check_admin($email)
	{
		$this->db->select("*")
		->from('tb_admin')
		->where(['email'=>$email, 'status'=>'1']);
	
		return $this->db->get()->num_rows();
		
}
function updateAdminRow($email,$data ){
	if($this->db->insert('tb_admin_otp',$data)){
		return $this->db->insert_id();
	}
	return false; 

}
public function get_usermaster_id($mobile)
	{
		$this->db->select("a.*")
		->from('usermaster a')
		->where(['a.mobile'=>$mobile]);
		return $this->db->get()->row();
		
	}
	public function get_package_id($package_id)
	{
		$this->db->select("a.*")
		->from('user_packages_master a')
		->where(['a.id'=>$package_id]);
		return $this->db->get()->row();
		
	}

	public function check_package_valid($user)
	{
		$this->db->select("a.*")
		->from('user_assign_package a')
		->where(['a.active'=>'1','a.user_id'=>$user]);
		return $this->db->get()->row();
		
	}
	public function CheckGST($property)
	{
		$this->db->select("a.*")
		->from('propmaster_document a')
		->where(['a.prop_m_id'=>$property]);
		return $this->db->get()->row();
		
	}
	
	public function getuserdatabymobile($mobile)
	{
		$this->db->select("a.*,c.*,c.email as proemail,d.gst_no,d.gst_certificate,e.name as prop_type_name,f.name as country_name,g.name as city_name,h.name as state_name,i.name as doc_type_name,j.name as location_name")
		->from('usermaster a')
		->join('propaccess b','b.userid=a.id','left')
		->join('propmaster c','c.id=b.propmasterid','left')
		->join('propmaster_document d','d.prop_m_id=c.id','left')
		->join('property_types e','e.pt_id=c.property_type_id','left')
		->join('countries f','f.id=c.country','left')
		->join('cities g','g.id=c.city','left')
		->join('states h','h.id=c.state','left')
		->join('property_doc_type i','i.id=c.doc_type_id','left')
		->join('location j','j.id=c.location_id','left')
		->where(['a.mobile'=>$mobile]);
		return $this->db->get()->row();
		
	}
	
	public function getUserDataById($mobile)
	{
		$this->db->select("a.*")
		->from('usermaster a')
		->where(['a.mobile'=>$mobile]);
		return $this->db->get()->row();
		
	}
	public function get_prop_id($userid)
	{
		$this->db->select("a.*")
		->from('propaccess a')
		->where(['a.userid'=>$userid]);
		return $this->db->get()->row();
		
	}
	public function get_user_property($userid)
	{
		$this->db->select("b.no_of_properties")
		->from('user_assign_package a')
		->join('user_packages_master b','b.id=a.package_id','left')
		->where(['a.user_id'=>$userid]);
		return $this->db->get()->row();
		
	}
	public function get_user_assign_property($userid)
	{
		$this->db->select("b.*")
		->from('propaccess a')
		->join('propmaster b','b.id=a.propmasterid','left')
		->where(['a.userid'=>$userid,'b.approval_status'=>'Approved']);
		return $this->db->get()->num_rows();
		
	}

	public function getpropertyData($user)
	{
		$this->db->select("b.*")
		->from('propaccess a')
		->join('propmaster b','b.id=a.propmasterid')
		->where(['a.userid'=>$user,'b.approval_status'=>'Approved']);
		return $this->db->get()->result();
		
	}

	
	public function get_cancellation_reservation($user,$limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('cancellations_booking t1')
		->select('t1.*,t2.propname')
		->join('propmaster t2','t2.id=t1.property_id')
		->where(['t1.is_deleted'=>'NOT_DELETED','t1.user_id'=>$user]) 
		->order_by('t1.before_days','asc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			$this->db->like('t1.title',$_POST['search']);
			$this->db->group_end();
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();

	}
	public function sales_report($limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('booking_new t1')
		->select('SUM(t2.credit) as TCR,SUM(t2.debit) as TDR,t1.*')
		->join('transaction t2','t2.booking_id=t1.id','left')
		->where(['t2.is_deleted'=>'NOT_DELETED']) 
		->group_by('t1.id')
		->order_by('t1.booking_date','asc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			//$this->db->like('t1.title',$_POST['search']);
			$this->db->group_end();
		}
		if (@$_POST['start_date']) {
			$start_date = $_POST['start_date'] . ' 00:00:00';    
		}
		
		if (@$_POST['end_date']) {
			$end_date = $_POST['end_date'] . ' 23:59:59';
		}
		
		if (isset($start_date) && isset($end_date)) {
			$this->db->where('t1.start_date <=', $end_date);
			$this->db->where('t1.end_date >=', $start_date);
		} elseif (isset($start_date)) {
			$this->db->where('t1.end_date >=', $start_date);
		} elseif (isset($end_date)) {
			$this->db->where('t1.start_date <=', $end_date);
		}
		if (@$_POST['property']) {
			$property = $_POST['property'];
			$this->db->where('t1.property_id',$property);
		}
		if (@$_POST['status']) {
			$status = $_POST['status'];
			$this->db->where('t1.status',$status);
		}
		if (@$_POST['payment_status']) {
			$payment_status = $_POST['payment_status'];
			$this->db->where('t1.payment_status',$payment_status);
		}
		if (@$_POST['agent']) {
			$agent = $_POST['agent'];
			$this->db->where('t1.agent',$agent);
		}
		if (@$_POST['payment_mode']) {
			$payment_mode = $_POST['payment_mode'];
			$this->db->where('t2.type',$payment_mode);
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();

	}
	public function host_sales_report($property_id,$limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('booking_new t1')
		->select('SUM(t2.credit) as TCR,SUM(t2.debit) as TDR,t1.*')
		->join('transaction t2','t2.booking_id=t1.id','left')
		->where('t2.is_deleted','NOT_DELETED')
		->where_in('t1.property_id',$property_id) 
		->group_by('t1.id')
		->order_by('t1.booking_date','asc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			//$this->db->like('t1.title',$_POST['search']);
			$this->db->group_end();
		}
		if (@$_POST['start_date']) {
			$start_date = $_POST['start_date'] . ' 00:00:00';    
		}
		
		if (@$_POST['end_date']) {
			$end_date = $_POST['end_date'] . ' 23:59:59';
		}
		
		if (isset($start_date) && isset($end_date)) {
			$this->db->where('t1.start_date <=', $end_date);
			$this->db->where('t1.end_date >=', $start_date);
		} elseif (isset($start_date)) {
			$this->db->where('t1.end_date >=', $start_date);
		} elseif (isset($end_date)) {
			$this->db->where('t1.start_date <=', $end_date);
		}
		
		if (@$_POST['property']) {
			$property = $_POST['property'];
			$this->db->where('t1.property_id',$property);
		}
		if (@$_POST['status']) {
			$status = $_POST['status'];
			$this->db->where('t1.status',$status);
		}
		if (@$_POST['payment_status']) {
			$payment_status = $_POST['payment_status'];
			$this->db->where('t1.payment_status',$payment_status);
		}
		if (@$_POST['agent']) {
			$agent = $_POST['agent'];
			$this->db->where('t1.agent',$agent);
		}
		if (@$_POST['payment_mode']) {
			$payment_mode = $_POST['payment_mode'];
			$this->db->where('t2.type',$payment_mode);
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();

	}


	public function arr_report($limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('booking_new t1')
		->select('SUM(t2.credit) as TCR,SUM(t2.debit) as TDR,t1.*')
		->join('transaction t2','t2.booking_id=t1.id','left')
		->where(['t2.is_deleted'=>'NOT_DELETED']) 
		->group_by('t1.id')
		->order_by('t1.booking_date','asc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			//$this->db->like('t1.title',$_POST['search']);
			$this->db->group_end();
		}
		if (@$_POST['start_date']) {
			$start_date = $_POST['start_date'] . ' 00:00:00';    
		}
		
		if (@$_POST['end_date']) {
			$end_date = $_POST['end_date'] . ' 23:59:59';
		}
		
		if (isset($start_date) && isset($end_date)) {
			$this->db->where('t1.start_date <=', $end_date);
			$this->db->where('t1.end_date >=', $start_date);
		} elseif (isset($start_date)) {
			$this->db->where('t1.end_date >=', $start_date);
		} elseif (isset($end_date)) {
			$this->db->where('t1.start_date <=', $end_date);
		}
		if (@$_POST['property']) {
			$property = $_POST['property'];
			$this->db->where('t1.property_id',$property);
		}
		if (@$_POST['status']) {
			$status = $_POST['status'];
			$this->db->where('t1.status',$status);
		}
		if (@$_POST['payment_status']) {
			$payment_status = $_POST['payment_status'];
			$this->db->where('t1.payment_status',$payment_status);
		}
		if (@$_POST['agent']) {
			$agent = $_POST['agent'];
			$this->db->where('t1.agent',$agent);
		}
		if (@$_POST['payment_mode']) {
			$payment_mode = $_POST['payment_mode'];
			$this->db->where('t2.type',$payment_mode);
		}
		$bookings = $this->db->get()->result();

		$filtered_bookings = [];
		foreach ($bookings as $row) {
			$room_count = $this->model->getData('room_allotment', ['property_id' => $row->property_id, 'booking_id' => $row->id, 'is_checkout' => '0']);
			if (count($room_count) > 0) {
				$filtered_bookings[] = $row;
			}
		}
	
		
		if($limit!=null)
		return $bookings;
		else
		return $bookings;

	}
	public function host_arr_report($property_id,$limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('booking_new t1')
		->select('SUM(t2.credit) as TCR,SUM(t2.debit) as TDR,t1.*')
		->join('transaction t2','t2.booking_id=t1.id','left')
		->where('t2.is_deleted','NOT_DELETED')
		->where_in('t1.property_id',$property_id) 
		->group_by('t1.id')
		->order_by('t1.booking_date','asc');
		if (@$_POST['start_date']) {
			$start_date = $_POST['start_date'] . ' 00:00:00';    
		}
		
		if (@$_POST['end_date']) {
			$end_date = $_POST['end_date'] . ' 23:59:59';
		}
		
		if (isset($start_date) && isset($end_date)) {
			$this->db->where('t1.start_date <=', $end_date);
			$this->db->where('t1.end_date >=', $start_date);
		} elseif (isset($start_date)) {
			$this->db->where('t1.end_date >=', $start_date);
		} elseif (isset($end_date)) {
			$this->db->where('t1.start_date <=', $end_date);
		}
		
		if (@$_POST['property']) {
			$property = $_POST['property'];
			$this->db->where('t1.property_id',$property);
		}
		if (@$_POST['status']) {
			$status = $_POST['status'];
			$this->db->where('t1.status',$status);
		}
		if (@$_POST['payment_status']) {
			$payment_status = $_POST['payment_status'];
			$this->db->where('t1.payment_status',$payment_status);
		}
		if (@$_POST['agent']) {
			$agent = $_POST['agent'];
			$this->db->where('t1.agent',$agent);
		}
		if (@$_POST['payment_mode']) {
			$payment_mode = $_POST['payment_mode'];
			$this->db->where('t2.type',$payment_mode);
		}
		$bookings = $this->db->get()->result();

		$filtered_bookings = [];
		foreach ($bookings as $row) {
			$room_count = $this->model->getData('room_allotment', ['property_id' => $row->property_id, 'booking_id' => $row->id, 'is_checkout' => '0']);
			if (count($room_count) > 0) {
				$filtered_bookings[] = $row;
			}
		}
	
		
		if($limit!=null)
		return $bookings;
		else
		return $bookings;

	}
	
	public function dash_arr_report($property_id,$date)
	{
		$this->db
		->from('booking_new t1')
		->select('SUM(t2.credit) as TCR,SUM(t2.debit) as TDR,t1.*')
		->join('transaction t2','t2.booking_id=t1.id','left')
		->where('t2.is_deleted','NOT_DELETED')
		->where_in('t1.property_id',$property_id) 
		->group_by('t1.id')
		->order_by('t1.booking_date','asc');
		if (isset($date)) {
			$this->db->where('t1.start_date <=', $date);
			$this->db->where('t1.end_date >=', $date);
		} elseif (isset($start_date)) {
			$this->db->where('t1.end_date >=', $date);
		} 
		$bookings = $this->db->get()->result();

		$filtered_bookings = [];
		foreach ($bookings as $row) {
			$room_count = $this->model->getData('room_allotment', ['property_id' => $row->property_id, 'booking_id' => $row->id, 'is_checkout' => '0']);
			if (count($room_count) > 0) {
				$filtered_bookings[] = $row;
			}
		}
		return $bookings;

	}

	
	function getDataRoomAllotment($tb, $data = 0, $order = null, $order_by = null, $limit = null, $start = null)
	{

		if ($order != null) {
			if ($order_by != null) {
				$this->db->order_by($order_by, $order);
			} else {
				$this->db->order_by('id', $order);
			}
		}

		if ($limit != null) {
			$this->db->limit($limit, $start);
		}

		if ($data == 0 or $data == null) {
			return $this->db->get($tb)->result();
		}
		if (@$data['search']) {
			$search = $data['search'];
			unset($data['search']);
		}
		$this->db->group_by('room_type');
		return $this->db->get_where($tb, $data)->result();
	}
	public function host_expanse_report($property_id,$limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('expense_data t1')
		->select('SUM(t1.amount) as Tamount,t1.*,t2.name as expanse_name,t3.propname,t3.propcode')
		->join('expense_master t2','t2.id=t1.expense_master_id','left')
		->join('propmaster t3','t3.id=t1.prop_master_id','left')
		->where_in(['t1.prop_master_id'=>$property_id]) 
		->group_by('t1.id')
		->order_by('t1.date','asc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			//$this->db->like('t1.title',$_POST['search']);
			$this->db->group_end();
		}
		if (@$_POST['start_date']) {
			$start_date = $_POST['start_date'] .' 00:00:00';    
			$this->db->where('t1.date >=',$start_date);
		}

		if (@$_POST['end_date']) {
			$end_date = $_POST['end_date'] . ' 23:59:59';
			$this->db->where('t1.date <=',$end_date);
		}
		if (@$_POST['property']) {
			$property = $_POST['property'];
			$this->db->where('t1.prop_master_id',$property);
		}
		if (@$_POST['expense_master']) {
			$expense_master = $_POST['expense_master'];
			$this->db->where('t1.expense_master_id',$expense_master);
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();

	}
	public function expanse_report($limit=null,$start=null)
	{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('expense_data t1')
		->select('SUM(t1.amount) as Tamount,t1.*,t2.name as expanse_name,t3.propname,t3.propcode')
		->join('expense_master t2','t2.id=t1.expense_master_id','left')
		->join('propmaster t3','t3.id=t1.prop_master_id','left')
		//->where(['t1.prop_master_id'=>$property_id]) 
		->group_by('t1.id')
		->order_by('t1.date','asc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			//$this->db->like('t1.title',$_POST['search']);
			$this->db->group_end();
		}
		if (@$_POST['start_date']) {
			$start_date = $_POST['start_date'] .' 00:00:00';    
			$this->db->where('t1.date >=',$start_date);
		}

		if (@$_POST['end_date']) {
			$end_date = $_POST['end_date'] . ' 23:59:59';
			$this->db->where('t1.date <=',$end_date);
		}
		if (@$_POST['property']) {
			$property = $_POST['property'];
			$this->db->where('t1.prop_master_id',$property);
		}
		if (@$_POST['expense_master']) {
			$expense_master = $_POST['expense_master'];
			$this->db->where('t1.expense_master_id',$expense_master);
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();

	}
	
	
	
	public function get_room_allot($flat_id)
	{
		$this->db->select("b.*")
		->from('room_allotment a')
		->join('booking_new b','b.id=a.booking_id','left')
		->where(['a.flat_id'=>$flat_id]);
		$rs =  $this->db->get()->row();
		if(!empty($rs->start_date) && !empty($rs->end_date) )
		{
			$start_date =  $rs->start_date;
			$end_date =  $rs->end_date;
			$this->db->select('*');
			$this->db->from('room_allotment a'); // replace 'your_table' with your actual table name
			$this->db->join('booking_new b','b.id=a.booking_id','left');
			$this->db->where('b.start_date >=', $start_date);
			$this->db->where('b.end_date <=', $end_date);
			return $this->db->get()->num_rows();
		}else
		{
        return 0;
		}		

		
	}
	
public function find_guest_count($guest_count)
{
	$this->db->select('*');
	$this->db->from('check_in_guests'); 
	$this->db->where($guest_count);
	
	return $this->db->get()->num_rows();
}
public function get_bookings_new($prop_id,$firstDate,$lastDate)
{
	$this->db->select('t1.*');
	$this->db->from('booking_new t1'); 
	$this->db->join('checkin t2','t2.booking_id=t1.id'); 
	$this->db->distinct('t2.booking_id');
	$this->db->where('t1.property_id',$prop_id);
	$this->db->where('t2.booking_date >=',$firstDate);
	$this->db->where('t2.booking_date <=',$lastDate);
	return $this->db->get()->result();
}
public function get_bookings_new_transaction($prop_id,$firstDate,$lastDate)
{
	$this->db->select('t2.*');
	$this->db->from('booking_new t1'); 
	$this->db->join('transaction t2','t2.booking_id=t1.id'); 
	$this->db->where('t2.is_deleted','NOT_DELETED');
	$this->db->where('t1.property_id',$prop_id);
	$this->db->where('t2.is_deleted','NOT_DELETED');
	$this->db->where('t2.tr_date >=',$firstDate);
	$this->db->where('t2.tr_date <=',$lastDate);
	return $this->db->get()->result();
}
public function get_host_logo($user)
{
	$this->db->select("t1.*")
	->from('usermaster t1')
	->join('propaccess a','a.userid=t1.id')
	->join('propmaster b','b.id=a.propmasterid')
	->where(['t1.id'=>$user,'b.approval_status'=>'Approved','t1.user_role'=>'4']);
	return $this->db->get()->row();
	
}
public function get_user_package($property,$user)
{
	$this->db->select("t1.*,t1.added as plan_date,t2.*,t1.updated as time")
	->from('user_assign_package t1')
	->join('user_packages_master t2','t2.id=t1.package_id','left')
	->where(['t1.property_id'=>$property,'t1.user_id'=>$user,'t1.active'=>'1','t1.status'=>'2']);
	return $this->db->get()->row();
	
}
public function activateMorePlan($property,$user_id) {
	$update = $this->model->Update('user_assign_package', ['active' => '0'], ['property_id'=>$property,'user_id' => $user_id]);
	if($update)
	{
		$update2 = $this->model->Update('user_assign_package', ['active' => '1'], ['property_id'=>$property,'extended_plan'=>'1','user_id' => $user_id]);
		if ($update2) {
			return true; 
		} else {
			return false;
		}
	}else{
		return false;
	}
}
public function getDataPackage($property,$user)
{
	$this->db->select("t1.id as plan_id,t1.*,t1.added as plan_date,t2.*")
	->from('user_assign_package t1')
	->join('user_packages_master t2','t2.id=t1.package_id','left')
	->where(['t1.property_id'=>$property,'t1.user_id'=>$user,'t1.active'=>'0','t1.extended_plan'=>'1','t1.status'=>'2']);
	return $this->db->get()->result();
	
}

public function validate_user_property($user,$propid)
{
	$this->db->select("t1.*")
	->from('usermaster t1')
	->join('propaccess a','a.userid=t1.id')
	->join('propmaster b','b.id=a.propmasterid')
	->where(['t1.id'=>$user,'b.approval_status'=>'Approved','b.id'=>$propid]);
	return $this->db->get()->num_rows();
	
}
public function user_update_password($mobile,$data)
	{
		return $this->db->where('mobile', $mobile)->update('usermaster', $data);
	}
	public function admin_user_update_password($email,$data)
	{
		return $this->db->where('email', $email)->update('tb_admin', $data);
	}
public function sub_properties_types($pro_id,$userid,$search,$limit=null,$start=null)
{
	if($pro_id){
		$property_id =$pro_id;
	}else{
		$property_id =  @$_COOKIE['property_id'];
	}
		
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('sub_property_types u')
		->select('u.*,pro.propname')
		->join('propaccess p','p.propmasterid=u.property_id','left')
		->join('propmaster pro','pro.id=u.property_id','left')
		->where(['u.is_deleted'=>'NOT_DELETED','pro.id'=>$property_id,'p.userid'=>$userid]) 
		// ->or_where('pro.id',$property_id)
		->order_by('u.added','desc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			$this->db->like('u.name',$_POST['search']);
			$this->db->group_end();
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();

}
public function getexpensesData($userid)
{
	$property_id =  @$_COOKIE['property_id'];
	
		$this->db
		->from('expense_master u')
		->select('u.*,pro.propname')
		->join('propaccess p','p.propmasterid=u.prop_id','left')
		->join('propmaster pro','pro.id=u.prop_id','left')
		->where(['u.is_deleted'=>'NOT_DELETED','pro.id'=>$property_id,'p.userid'=>$userid]) 
		->order_by('u.name','asc');
		return $this->db->get()->result();

}
public function count_row($tb,$id=null)
	{
		$this->db->select("*")
		->from($tb)
		->where(['is_deleted'=>'NOT_DELETED', 'active'=>'1']);
		if ($id!=null) {
			$this->db->where('spt_id',$id); 
		}
		return $this->db->get()->num_rows();
	}
	public function get_host_package_row($userid)
	{
		$this->db->select("b.name,a.id,a.status")
		->from('user_assign_package a')
		->join('user_packages_master b','b.id=a.package_id','left')
		->where(['a.user_id'=>$userid]);
		return $this->db->get()->row();	
   }
	public function get_host_package_row_new($userid,$prop_id)
	{
		$this->db->select("b.name,a.id,a.status")
		->from('user_assign_package a')
		->join('user_packages_master b','b.id=a.package_id','left')
		->where(['a.user_id'=>$userid,'a.property_id'=>$prop_id]);
		return $this->db->get()->row();	
	}

public function all_enquiry($limit=null,$start=null)
{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('enquiry u')
		->select('u.*')
		->order_by('u.added','desc');					
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			$this->db->like('u.name',$_POST['search']);
			$this->db->like('u.mobile',$_POST['search']);
			$this->db->like('u.email',$_POST['search']);
			$this->db->group_end();
		}
		if (@$_POST['start_date']) {
			$start_date = $_POST['start_date'] .' 00:00:00';    
			$this->db->where('u.added >=',$start_date);
		}

		if (@$_POST['end_date']) {
			$end_date = $_POST['end_date'] . ' 23:59:59';
			$this->db->where('u.added <=',$end_date);
		}
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();

}	

public function occupancy_report($search,$limit=null,$start=null)
{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('booking_new t1')
		->select('t1.*,t4.of_adults as adult,t4.of_children as children,t4.of_infant as infant,t4.room_no as rooms,t5.name as room_type,t4.guest_name as guest,t4.contact as guest_contact,t4.id as checkinid,t6.available,t2.no_of_rooms')
		->join('booking_new_inventory t2','t2.booking_id=t1.id','left')
		->join('checkin t4','t4.booking_id=t1.id','left')
		->join('sub_property_types t5','t5.spt_id=t4.room_type','left')
		->join('propmaster_s_p_availability t6','t6.s_p_type_id=t5.spt_id','left')
		->order_by('t1.booking_date','desc')
		->where('t4.checkout_id IS NULL');			
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			$this->db->like('t1.guest_name',$_POST['search']);
			$this->db->like('t1.contact',$_POST['search']);
			$this->db->like('t1.email',$_POST['search']);
			$this->db->group_end();
		}
		if (@$_POST['agent']) {
			$agent = $_POST['agent'];
			$this->db->where('t1.agent',$agent);
		}
		if (@$_POST['property']) {
			$property = $_POST['property'];
			$this->db->where('t1.property_id',$property);
		}
		if (@$_POST['booking_type']) {
			$booking_type = $_POST['booking_type'];
			$this->db->where('t1.booking_type',$booking_type);
		}
		if (@$_POST['room_type']) {
			$room_type = $_POST['room_type'];
			$this->db->where('t2.booking_type_id',$room_type);
		}
		
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();

}
public function host_occupancy_report($property_id,$search,$limit=null,$start=null)
{
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
		$this->db
		->from('booking_new t1')
		->select('t1.*,t4.of_adults as adult,t4.of_children as children,t4.of_infant as infant,t4.room_no as rooms,t5.name as room_type,t4.guest_name as guest,t4.contact as guest_contact,t4.id as checkinid,t6.available,t2.no_of_rooms')
		->join('booking_new_inventory t2','t2.booking_id=t1.id','left')
		->join('checkin t4','t4.booking_id=t1.id','left')
		->join('sub_property_types t5','t5.spt_id=t4.room_type','left')
		->join('propmaster_s_p_availability t6','t6.s_p_type_id=t5.spt_id','left')
		->order_by('t1.booking_date','desc')
		->where_in(['t1.prop_master_id'=>$property_id]) 
		->where('t4.checkout_id IS NULL');			
		if (@$_POST['search']) {
			$data['search'] = $_POST['search'];
			$this->db->group_start();
			$this->db->like('t1.guest_name',$_POST['search']);
			$this->db->like('t1.contact',$_POST['search']);
			$this->db->like('t1.email',$_POST['search']);
			$this->db->group_end();
		}
		if (@$_POST['agent']) {
			$agent = $_POST['agent'];
			$this->db->where('t1.agent',$agent);
		}
		if (@$_POST['property']) {
			$property = $_POST['property'];
			$this->db->where('t1.property_id',$property);
		}
		if (@$_POST['booking_type']) {
			$booking_type = $_POST['booking_type'];
			$this->db->where('t1.booking_type',$booking_type);
		}
		if (@$_POST['room_type']) {
			$room_type = $_POST['room_type'];
			$this->db->where('t2.booking_type_id',$room_type);
		}
		
		if($limit!=null)
			return $this->db->get()->result();
		else
		return $this->db->get()->result();

}



public function getYearSales($propid,$year) {
    $monthlyData = [];

    for ($month = 1; $month <= 12; $month++) {
        $this->db->select('MONTH(t2.tr_date) as month, SUM(t2.credit) as total_credit, SUM(t2.debit) as total_debit');
        $this->db->from('booking_new t1');
        $this->db->join('transaction t2', 't2.booking_id=t1.id', 'left');
		$this->db->where('t2.is_deleted','NOT_DELETED');
        $this->db->where('YEAR(t2.tr_date)', $year);
        $this->db->where('MONTH(t2.tr_date)', $month);
		$this->db->where('t1.property_id',$propid);
        $this->db->group_by('MONTH(t2.tr_date)');
        $query = $this->db->get();
        
        $result = $query->row();
        if (!$result) {
            $result = (object) [
                'month' => $month,
                'total_credit' => 0,
                'total_debit' => 0,
            ];
        }

        // Get the month name
        $result->month_name = date("F", strtotime("2022-$month-01"));

        $monthlyData[] = $result;
    }

    return $monthlyData;
}
public function getDaySales($propid,$dateRange) {
    $dailyData = [];

    list($start_date, $end_date) = explode(" - ", $dateRange);

    $start_date = date_create_from_format('m/d/Y', $start_date);
    $end_date = date_create_from_format('m/d/Y', $end_date);

    if ($start_date && $end_date) {
        // Format dates as 'Y-m-d'
        $start_date = $start_date->format('Y-m-d');
        $end_date = $end_date->format('Y-m-d');

        $currentDate = date_create($start_date);
        $endDate = date_create($end_date);

        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('Y-m-d');

            // Database query for each day
            $this->db->select('t2.tr_date, SUM(t2.credit) as total_credit, SUM(t2.debit) as total_debit');
            $this->db->from('booking_new t1');
            $this->db->join('transaction t2', 't2.booking_id=t1.id', 'left');
			$this->db->where('t2.is_deleted','NOT_DELETED');
            $this->db->where('DATE(t2.tr_date)', $formattedDate);
			$this->db->where('t1.property_id',$propid);
            $query = $this->db->get();

            $result = $query->row();
            
			if (!$result) {
				$result = (object) [
					'tr_date' => $formattedDate,
					'total_credit' => 0,
					'total_debit' => 0,
				];
			} else {
				$result->tr_date = $formattedDate; 
				$result->total_credit = isset($result->total_credit) ? $result->total_credit : 0;
				$result->total_debit = isset($result->total_debit) ? $result->total_debit : 0;
			}


            $dailyData[] = $result;

            $currentDate->modify('+1 day');
        }
    } else {
        echo "Invalid date range.";
    }

    return $dailyData;
}
// Assuming you have a function to get all distinct years from the transaction table
function getDistinctYears() {
    $this->db->select('YEAR(tr_date) as year');
    $this->db->from('transaction');
	$this->db->where('is_deleted','NOT_DELETED');
    $this->db->group_by('YEAR(tr_date)');
    $query = $this->db->get();

    return $query->result();
}

// Function to get yearly data
public function getYearlyData($prop_id) {
	//$prop_id = @$_COOKIE['property_id'];
    $yearsData = [];
    $distinctYears = $this->getDistinctYears();

    foreach ($distinctYears as $year) {
        $this->db->select('SUM(t2.credit) as total_credit, SUM(t2.debit) as total_debit');
        $this->db->from('booking_new t1');
		$this->db->join('transaction t2','t2.booking_id=t1.id','left');
		$this->db->where('t2.is_deleted','NOT_DELETED');
        $this->db->where('YEAR(t2.tr_date)', $year->year);
		$this->db->where('t1.property_id',$prop_id);
        $query = $this->db->get();
        
        $result = $query->row();

        if (!$result) {
            // If no data for the year, initialize with zeros
            $result = (object) [
                'total_credit' => 0,
                'total_debit' => 0,
            ];
        }

        $result->year = $year->year;
        $yearsData[] = $result;
    }

    return $yearsData;
}
public function getYearlyDataAdmin($prop_id) {
    $yearsData = [];
    $distinctYears = $this->getDistinctYears();

    foreach ($distinctYears as $year) {
        $this->db->select('SUM(t2.credit) as total_credit, SUM(t2.debit) as total_debit');
        $this->db->from('booking_new t1');
		$this->db->join('transaction t2','t2.booking_id=t1.id','left');
		$this->db->where('t2.is_deleted','NOT_DELETED');
        $this->db->where('YEAR(t2.tr_date)', $year->year);
		$this->db->where('t1.property_id',$prop_id);
        $query = $this->db->get();
        
        $result = $query->row();

        if (!$result) {
            // If no data for the year, initialize with zeros
            $result = (object) [
                'total_credit' => 0,
                'total_debit' => 0,
            ];
        }

        $result->year = $year->year;
        $yearsData[] = $result;
    }

    return $yearsData;
}
public function getYearSalesAdmin($propid,$year) {
    $monthlyData = [];

    for ($month = 1; $month <= 12; $month++) {
        $this->db->select('MONTH(t2.tr_date) as month, SUM(t2.credit) as total_credit, SUM(t2.debit) as total_debit');
        $this->db->from('booking_new t1');
        $this->db->join('transaction t2', 't2.booking_id=t1.id', 'left');
		$this->db->where('t2.is_deleted','NOT_DELETED');
        $this->db->where('YEAR(t2.tr_date)', $year);
        $this->db->where('MONTH(t2.tr_date)', $month);
		$this->db->where('t1.property_id',$propid);
        $this->db->group_by('MONTH(t2.tr_date)');
        $query = $this->db->get();
        
        $result = $query->row();
        if (!$result) {
            $result = (object) [
                'month' => $month,
                'total_credit' => 0,
                'total_debit' => 0,
            ];
        }

        // Get the month name
        $result->month_name = date("F", strtotime("2022-$month-01"));

        $monthlyData[] = $result;
    }

    return $monthlyData;
}
public function getDaySalesAdmin($propid,$dateRange) {
    $dailyData = [];

    list($start_date, $end_date) = explode(" - ", $dateRange);

    $start_date = date_create_from_format('m/d/Y', $start_date);
    $end_date = date_create_from_format('m/d/Y', $end_date);

    if ($start_date && $end_date) {
        // Format dates as 'Y-m-d'
        $start_date = $start_date->format('Y-m-d');
        $end_date = $end_date->format('Y-m-d');

        $currentDate = date_create($start_date);
        $endDate = date_create($end_date);

        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('Y-m-d');

            // Database query for each day
            $this->db->select('t2.tr_date, SUM(t2.credit) as total_credit, SUM(t2.debit) as total_debit');
            $this->db->from('booking_new t1');
            $this->db->join('transaction t2', 't2.booking_id=t1.id', 'left');
			$this->db->where('t2.is_deleted','NOT_DELETED');
            $this->db->where('DATE(t2.tr_date)', $formattedDate);
			$this->db->where('t1.property_id',$propid);
            $query = $this->db->get();

            $result = $query->row();
            
			if (!$result) {
				$result = (object) [
					'tr_date' => $formattedDate,
					'total_credit' => 0,
					'total_debit' => 0,
				];
			} else {
				$result->tr_date = $formattedDate; 
				$result->total_credit = isset($result->total_credit) ? $result->total_credit : 0;
				$result->total_debit = isset($result->total_debit) ? $result->total_debit : 0;
			}


            $dailyData[] = $result;

            $currentDate->modify('+1 day');
        }
    } else {
        echo "Invalid date range.";
    }

    return $dailyData;
}
public function host_tax_report($property_id,$limit=null,$start=null)
{
	if ($limit!=null) {
		$this->db->limit($limit, $start);
	}
	$this->db
    ->from('booking_new t1')
    ->select('SUM(t3.credit) as TCR,SUM(t3.debit) as TDR,t1.*,t3.tr_date,t2.bill_no,t2.is_igst')
    ->join('checkout_new t2', 't2.booking_id = t1.id', 'left')
    ->join('transaction t3', 't3.booking_id = t1.id','left')
	->where('t3.is_deleted','NOT_DELETED')
    ->where(['t3.action'=>'checkout']) 
	->where_in('t1.property_id', $property_id)
    ->group_by('t1.id')
    ->order_by('t1.booking_date', 'asc');
	//echo $this->db->last_query();die();
	if (@$_POST['search']) {
		$data['search'] = $_POST['search'];
		$this->db->group_start();
		//$this->db->like('t1.title',$_POST['search']);
		$this->db->group_end();
	}
	if (@$_POST['start_date']) {
		$start_date = $_POST['start_date'] .' 00:00:00';    
		$this->db->where('t1.start_date >=',$start_date);
	}

	if (@$_POST['end_date']) {
		$end_date = $_POST['end_date'] . ' 23:59:59';
		$this->db->where('t1.end_date <=',$end_date);
	}
	if (@$_POST['property']) {
		$property = $_POST['property'];
		$this->db->where('t1.property_id',$property);
	}
	
	if($limit!=null)
		return $this->db->get()->result();
	else
	return $this->db->get()->result();

}




public function tax_report($limit=null,$start=null)
{
	if ($limit!=null) {
		$this->db->limit($limit, $start);
	}
	$this->db
	->from('booking_new t1')
	->select('SUM(t3.credit) as TCR,SUM(t3.debit) as TDR,t1.*,t3.tr_date,t2.bill_no,t2.is_igst')
	->join('checkout_new t2','t2.booking_id=t1.id','left')
	->join('transaction t3','t3.booking_id=t1.id','left')
	->where('t3.is_deleted','NOT_DELETED')
	->where(['t3.action'=>'checkout']) 
	->group_by('t1.id')
	->order_by('t1.booking_date','asc');					
	if (@$_POST['search']) {
		$data['search'] = $_POST['search'];
		$this->db->group_start();
		//$this->db->like('t1.title',$_POST['search']);
		$this->db->group_end();
	}
	if (@$_POST['start_date']) {
		$start_date = $_POST['start_date'] .' 00:00:00';    
		$this->db->where('t1.start_date >=',$start_date);
	}

	if (@$_POST['end_date']) {
		$end_date = $_POST['end_date'] . ' 23:59:59';
		$this->db->where('t1.end_date <=',$end_date);
	}
	if (@$_POST['property']) {
		$property = $_POST['property'];
		$this->db->where('t1.property_id',$property);
	}
	if($limit!=null)
		return $this->db->get()->result();
	else
	return $this->db->get()->result();

}

    public function check_and_cancel_bookings() {
	$current_date = date('Y-m-d');
	$this->db->select('t1.id,t1.property_id, t2.room_type');
	$this->db->from('booking_new t1');
	$this->db->join('booking_new_items t2','t1.id=t2.booking_id AND t2.property_id=t1.property_id');
	$this->db->where('end_date <', $current_date);
	$query = $this->db->get();
	$bookings = $query->result();
	$cancelled_count = 0; // Initialize cancellation count
	foreach ($bookings as $booking) {
		$this->db->select('*');
		$this->db->from('room_allotment');
		$this->db->where('booking_id', $booking->id);
		$this->db->where('property_id', $booking->property_id);
		$this->db->where('room_type', $booking->room_type);
		$allotment_query = $this->db->get();
		if ($allotment_query->num_rows() == 0) {
			$this->db->where('id', $booking->id);
			$this->db->update('booking_new', ['status' => '4','cancellation'=>'YES']);
			$cancelled_count++; 
		 }
	  }
	return $cancelled_count; 
	}

	public function all_role_menu_data($role_id)
    {
        $this->db
        ->select('t1.*,t2.menu_id')
        ->from('tb_admin_menu t1')
        ->join('tb_role_menus t2', 't2.menu_id = t1.id')
        ->where('t2.role_id',$role_id)
        ->order_by('t1.indexing','asc');
        return $this->db->get()->result();
    }

}
