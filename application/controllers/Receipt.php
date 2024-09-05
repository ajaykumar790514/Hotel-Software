<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Receipt extends Main {
	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function index($bill_no)
	{
		$data['receipt']  =$receipt = $this->model->getRow('checkout_new',['bill_no'=>$bill_no]);
		$data['logo'] = base_url().'static/app-assets/images/logo/logo.png';
		$data['booking']  =$booking = $this->model->getRow('booking_new',['id'=>$receipt->booking_id]);
		$data['extended'] = $this->model->getData('booking_new',['id'=>$receipt->booking_id]);
		$data['totalcheckin'] = $this->model->getData('checkin',['booking_id'=>$receipt->booking_id]);
		$data['room_allotment'] =$flats = $this->model->getRow('room_allotment',['booking_id'=>$receipt->booking_id]);
		$data['flat'] = $flat = $this->model->getRow('property',['flat_id'=>$flats->flat_id]);
		$data['propmaster'] = $propmaster = $this->model->getRow('propmaster',['id'=>$flat->propid]);
		$data['checkinarray'] =  json_decode($receipt->check_in_ids);
		$checkgst = $this->model->CheckGST($booking->property_id);
		// if($checkgst->gst_no =='')
		// {
		// 	echo "<h3 style='color:red;text-align:center;margin-top:2rem;'>Sorry. Selected Property GST NO Not Entered</h3>";
		// 	die();
		// }
		
		$data['content'] = 'receipt2';
		load_view($data['content'],$data);
	}

	public function cancel_receipt_url($bill_no)
	{
		$data['receipt']  =$receipt = $this->model->getRow('checkout_new',['bill_no'=>$bill_no]);
		$booking_id = $receipt->booking_id;
		$data['logo'] = base_url().'static/app-assets/images/logo/logo.png';
		$data['booking']  =$booking = $this->model->getRow('booking_new',['id'=>$booking_id]);
		$data['extended'] = $this->model->getData('booking_new',['id'=>$booking_id]);
		$data['room_allotment'] =$flats = $this->model->getRow('room_allotment',['booking_id'=>$booking_id]);
		// $data['flat'] = $flat = $this->model->getRow('property',['flat_id'=>$flats->flat_id]);
		$data['propmaster'] = $propmaster = $this->model->getRow('propmaster',['id'=>$booking->property_id]);
		$data['usermaster'] = $transaction = $this->model->getRow('transaction',['booking_id'=>$booking->id]);
		$data['transaction'] = $this->model->getData('booking_new',['id'=>$booking_id]);
		$checkgst = $this->model->CheckGST($booking->property_id);
		if($checkgst->gst_no =='')
		{
			echo "<h3 style='color:red;text-align:center;margin-top:2rem;'>Sorry. Selected Property GST NO Not Entered</h3>";
			die();
		}
		$data['content'] = 'cancel_receipt';
		load_view($data['content'],$data);
	}
	


}
