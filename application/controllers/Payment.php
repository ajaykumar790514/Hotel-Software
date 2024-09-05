
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Payment extends Main {

	public function __construct() {
        parent::__construct();
		$this->check_role_menu();
    }
	public function send_payment_link($booking_id)
	{
		$response['res'] = 'error';
		$response['msg'] = 'Payment Link Not Created!';

		$booking = $this->booking_detailes($booking_id);

		$transaction_data['amount'] 		= $booking->price*100;
		// $transaction_data['amount'] 		= 1*100;
		$transaction_data['expire_by'] 		= time() + 30*60;
		$transaction_data['reference_id'] 	= uniqid();
		$transaction_data['name'] 			= $booking->guest_name;
		$transaction_data['contact'] 		= $booking->contact;
		$transaction_data['email'] 			= $booking->email;

		// $transaction_data['name'] 			= 'Ankit Verma';
		// $transaction_data['contact'] 		= '8887382475';
		// $transaction_data['email'] 			= 'ankitv4087@gmail.com';
		// $transaction_data['callback_url']	= "http://techfizone.com/callback.php/";
		$transaction_data['callback_url']	= base_url()."callback/";

		// uncomment for live
		$returnData = $this->curl_handler($transaction_data);
		// uncomment for live

		// comment for live
		// $returnData['status']=='created';
		// comment for live

			
		$returnData = json_decode($returnData,true);
		// echo "<pre>";
		// print_r($returnData);
		// echo "</pre>";
		// if (@$returnData['error']) {
		// 	echo "error";
		// }
		if (@$returnData['status']=='created') {
			$response['res'] = 'success';
			$response['msg'] = 'Payment Link Created.';
			$updateArray['razorpay_payment_link_id'] = $returnData['id'];
			$updateArray['reference_id'] 			 = $returnData['reference_id'];
			$updateArray['payment_status'] 			 = 3;
			$this->model->Update('booking',$updateArray,['id'=>$booking_id]);
		}

		echo json_encode($response);
	}


	private function curl_handler($transaction_data)  {
 		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payment_links/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$str=[
		  "amount" => $transaction_data['amount'],
		  "currency"=> "INR",
		  "accept_partial"=> false,
		  "expire_by"=> $transaction_data['expire_by'],
		  "reference_id"=> $transaction_data['reference_id'],
		  "description"=> "Payment for policy no #23456",
		  "customer"=> [
		    "name"=> $transaction_data['name'],
		    "contact"=> $transaction_data['contact'],
		    "email"=> $transaction_data['email']
		  ],
		  "notify"=> [
		    "sms"=> true,
		    "email"=> true
		  ],
		  "reminder_enable"=> true,
		  "notes"=> [
		    "policy_name"=> "Hotel Pyament"
		  ],
		  "callback_url"=> $transaction_data['callback_url'],
		  "callback_method"=> "get"
		];
		$str = json_encode($str);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
		// curl_setopt($ch, CURLOPT_USERPWD, 'rzp_test_eevX5UYieZanwA' . ':' . 'iSL7W9lmwDQ7BQTMoB5rYewl');
		curl_setopt($ch, CURLOPT_USERPWD, 'rzp_live_COtjGsfkrOJtLQ' . ':' . 'isOWzwdsZm7FCuFzKk46d0oQ');

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
    }  

    public function callback()
    {
		$cond['reference_id']              = $_GET['razorpay_payment_link_reference_id'];
		$cond['razorpay_payment_link_id']  = $_GET['razorpay_payment_link_id'];
		$cond['payment_status']            = 2;
		$status = 0;        //'error'
		if($this->model->getRow('booking',$cond)){
		    $status = 1;   //'already_paid'
		}
		else{
		    if ($_GET['razorpay_payment_link_status']=='paid') {
		        $expected_signature = $_GET['razorpay_payment_link_id'] . '|' .
		                         $_GET['razorpay_payment_link_reference_id'] . '|' .
		                         $_GET['razorpay_payment_link_status'] . '|' .
		                         $_GET['razorpay_payment_id'];

		        // $hash = hash_hmac('sha256',$expected_signature, "iSL7W9lmwDQ7BQTMoB5rYewl");
		        $hash = hash_hmac('sha256',$expected_signature, "isOWzwdsZm7FCuFzKk46d0oQ");
		        if ($hash==$_GET['razorpay_signature']) {
		            $status = 2;   //'paid'
		            $updateArray['rzp_payment_id']       = $_GET['razorpay_payment_id'];
		            $updateArray['rzp_capture_response'] = '';
		            $updateArray['payment_status']       = 2;
		            unset($cond['payment_status']);
		            $this->model->Update('booking',$updateArray,$cond);
		        }
		    }
		}

		if ($status==0) {
		        echo "<body style='display: table;'>";
		         echo "<h1 style='display: table-cell;
		                         vertical-align: middle;
		                         width: 100vw;
		                         height: 100vh;
		                         text-align: center;
		                         color: red;'>
		                Payment Failed!<h1>";
		         echo "</body>";
		}
		else if ($status==1) {
		    echo "<body style='display: table;'>";
		    echo "<h1 style='display: table-cell;
		                 vertical-align: middle;
		                 width: 100vw;
		                 height: 100vh;
		                 text-align: center;
		                 color: red;'>
		        Already Paid!<h1>";
		    echo "</body>";
		}
		else{
		    echo "<body style='display: table;'>";
		    echo "<h1 style='display: table-cell;
		                 vertical-align: middle;
		                 width: 100vw;
		                 height: 100vh;
		                 text-align: center;
		                 color: green;'>
		        Payment Successful.<h1>";
		    echo "</body>";
		}
    }

    public function paynow($booking_id)
    {
    	$data['booking'] = $booking = $this->booking_detailes($booking_id);

    	if ($this->input->server('REQUEST_METHOD')=='POST') {
    		$response['res'] = 'error';
    		$response['msg'] = 'Error!';
    		if ($booking->payment_status==2) {
    			$response['res'] = 'error';
    			$response['msg'] = 'Already Paid!';
    		}
    		else {
    			$updateArray['payment_mode']    = $_POST['payment_mode'];
	            $updateArray['reference_id'] 	= $_POST['reference_id'];
	            $updateArray['payment_status']  = 2;

	            $cond['id'] = $booking_id;
	            if($this->model->Update('booking',$updateArray,$cond)){
	            	$response['res'] = 'success';
    				$response['msg'] = 'Payment Successful.';
	            }
    		}

    		echo json_encode($response);
    	} else {
    		if ($booking->payment_status==2) {
	    		echo "<body style='display: table;'>";
			    echo "<h1 style='display: table-cell;
			                vertical-align: middle;
			                width: 100vw;
			                height: 100vh;
			                text-align: center;
			                color: red;'>
			        Already Paid!<h1>";
			    echo "</body>";
			    die();
	    	}

	    	$data['contant'] 	 = 'reservations/paynow';
	    	$data['paynow_url']	 = base_url().'paynow/'.$booking_id;
	    	$data['payment_mode']   = $this->model->getData('payment_mode',['status'=>1,'id!='=>6],'asc','mode'); 
	    	load_view($data['contant'],$data);

    	}
    	




    }


}
?>
