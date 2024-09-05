<?php
defined('BASEPATH') or exit('No direct script access allowed');
// ### checkbox ###
if (!function_exists('checkbox')) {
    function checkbox($name, $value, $title, $status = 1, $checked = null)
    {
        ($status == 0) ? $class = "class='red'" : $class = "";
        return "<label $class ><input type='checkbox' class='switchery' data-size='sm' name='$name' value='$value' $checked  >&nbsp;" . $title . "</label><br>";
    }
}
// ### checkbox ###

// ### options ###
if (!function_exists('option')) {
    function option($value, $title, $selected = '')
    {
        if ($selected == 0) {
            return '<option value="' . $value . '" ' . $selected . '>' . $title . ' ( Not Active )</option>';
        } else {
            return '<option value="' . $value . '" ' . $selected . '>' . $title . '</option>';
        }
    }
}

if (!function_exists('optionStatus')) {
    function optionStatus($value, $title, $status = 1, $selected = '')
    {

        if ($status == 0) {
            return '<option value="' . $value . '" ' . $selected . ' class="red">' . $title . ' ( Not Active )</option>';
        } else {
            return '<option value="' . $value . '" ' . $selected . '>' . $title . '</option>';
        }
    }
}
// ### /options ###



if (!function_exists('load_view')) {
    function load_view($page_name, $data = NULL)
    {
        $CI = &get_instance();
        return $CI->load->view($page_name, $data);
    }
}



function array_encryption($data, $type = 'encrypt')
{
    $CI = &get_instance();
    $CI->load->library('encryption');

    $return = array();
    foreach ($data as $key => $value) {
        $return[$key] = (@$value) ? $CI->encryption->$type($value) : $value;
    }
    return $return;
}

function value_encryption($data, $type = 'decrypt')
{
    $CI = &get_instance();
    $CI->load->library('encryption');
    return $CI->encryption->$type($data);
}

function title($tb, $id, $id_column = 'id', $column = null)
{
    if ($column == null) {
        $column = 'name';
    }

    $CI = &get_instance();
    if ($data = $CI->db->get_where($tb, [$id_column => $id])->row()) {
        return $data->$column;
    } else {
        return '';
    }
}

if (!function_exists('cancelation_policy')) {
    function cancelation_policy($prop_id)
    {
        $CI = &get_instance();
        $return = false;
        $query =  "SELECT mtb.* , p.descrption 
                    FROM propertypolicy mtb 
                    LEFT JOIN policy p on mtb.policy_id = p.id
                    WHERE mtb.prop_id = $prop_id AND mtb.policy_type ='cancelation'";
        if ($get = $CI->db->query($query)->row()) {
            $return = $get->descrption;
        }
        return $return;
    }
}


if (!function_exists('tax_rate')) {
    function tax_rate($amount)
    {
        $CI = &get_instance();
        $return = false;
        $query =  "SELECT * FROM `tax_range` WHERE `from` <= $amount AND `to` >= $amount AND status = 1";
        if ($get = $CI->db->query($query)->row()) {
            $return = $get->tax_rate;
        //    set default tax 12 % in future change this tax
          // $return = 12;
        }
        return $return;
    }
}


if (!function_exists('tax_amount')) {
    function tax_amount($row)
    {
		$pre_checkin_amount=0;
        $amount = $row->total;
        $discount = (@$row->discount_amount) ? $row->discount_amount : 0;
		$CI = &get_instance();	
		$Checkins = $CI->model->getData('checkin',['booking_id'=>$row->id]);
		foreach($Checkins as $checkin):
			$pre_checkin_amount += $checkin->pre_checkin_amount;
		endforeach;	
        $return['Amount']       = _number_format($amount);
        $return['discountAmount']  = _number_format($discount);
        $return['pre_checkin_amount']  = _number_format($pre_checkin_amount);
        $return['TotalAmount']  = ($return['Amount'] + $pre_checkin_amount) - $discount;

        if ($rate = tax_rate($amount)) :

            $amountWithOutTax = ($return['TotalAmount'] * 100) / ($rate + 100);

            $return['taxRate']      = $rate . ' %';
            $return['taxAmount']    = _number_format($return['TotalAmount'] - $amountWithOutTax);
            $return['amountWithOutTax']       = _number_format($amountWithOutTax);
        // $return['TotalAmount']  = _number_format($amount);
        else :
            $return['taxRate']      = '';
            $return['taxAmount']    = 0;
        // $return['Amount']       = _number_format($amount);
        // $return['TotalAmount']  = _number_format($amount);
        endif;

        $return['TotalAmount']  = _number_format($return['TotalAmount']);
        return $return;
    }
}

if (!function_exists('get_tax_amount')) {
    function get_tax_amount($amount)
    {
        if ($rate = tax_rate($amount)) :
            $amountTax = ($amount * $rate)/100;
            $return['taxRate']      = $rate . ' %';
            $return['taxAmount']    = _number_format($amountTax);
            $return['Amount']       = _number_format($amount+$amountTax);
            $return['TotalAmount']  = _number_format($amount);
        else :
            $return['taxRate']      = '';
            $return['taxAmount']    = 0;
            $return['Amount']       = _number_format($amount);
            $return['TotalAmount']  = _number_format($amount);
        endif;

        return $return;
    }
}
if (!function_exists('getTaxAmount')) {
    function getTaxAmount($amount)
    {
	    $property_id = @$_COOKIE['property_id'];
		$CI = &get_instance();
        $data = $CI->model->getRow('propmaster',['id'=>$property_id,'is_gst'=>'YES']);
		if(!empty($data)){
        if ($rate = tax_rate($amount)) :
            $amountWithOutTax = ($amount * $rate) / 100;
            $return['taxRate']      = $rate . ' %';
			$return['taxRateNew']      = $rate;
            $return['taxAmount']    = _number_format($amountWithOutTax);
            $return['Amount']       = _number_format($amount);
            $return['TotalAmount']  = _number_format($amount + $amountWithOutTax);
        else :
            $return['taxRate']      = '';
			$return['taxRateNew']      = '';
            $return['taxAmount']    = 0;
            $return['Amount']       = _number_format($amount);
            $return['TotalAmount']  = _number_format($amount);
        endif;
	    }else{
			$return['taxRate']      = '';
			$return['taxRateNew']      = '';
            $return['taxAmount']    = 0;
            $return['Amount']       = _number_format($amount);
            $return['TotalAmount']  = _number_format($amount);
		}
        return $return;
    }
}
if (!function_exists('between_dates')) {
     function between_dates($start, $end)
	{
		$dateArray = array();
		$period = new DatePeriod(
			new DateTime($start),
			new DateInterval('P1D'),
			new DateTime($end)
		);
		foreach ($period as $date) {
			$dateArray[] = $date->format('Y-m-d');
		}

		return $dateArray;
	}
}

if (!function_exists('checkPlanValid')) {
function checkPlanValid($pro_id,$user_id)
{
    if(!empty($pro_id)){
    $CI = &get_instance();	
    $plan = $CI->model->get_user_package($pro_id,$user_id);
    if (!empty($plan)) {
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
        return false;
    }else
    if($isValid)
    {
        return true;
    }else 
    {
          $CI->model->activateMorePlan($pro_id,$user_id);
          return false;
    }
    }else{
        return false;
    }}else{
        return false;
    }
    
    }
}


if (!function_exists('_number_format')) {
    function _number_format($number)
    {
        return number_format($number, 2, '.', '');
    }
}

if (!function_exists('round_price')) {
    function round_price($number)
    {
        return number_format($number, 0, '', '');
    }
}





if (!function_exists('img_base_url')) {
    function img_base_url()
    {
        $CI = &get_instance();
        return $CI->config->config['img_base_url'];
    }
}

if (!function_exists('prx')) {
    function prx($v)
    {
        echo '<pre>' . print_r($v, true) . '</pre>';
    }
}

if (!function_exists('getState_by_id')) {
    function getState_by_id($id = null, $selected_id = null, $return = false)
    {
        $CI = &get_instance();
        if ($data = $CI->db->get_where('states', ['id' => $selected_id])->row()) {
            return $data->name;
        } else {
            return '';
        }
    }
}

if (!function_exists('setting')) {
    function setting()
    {
        $CI = &get_instance();
        return $CI->model->getRow('settings');
    }
}

if (!function_exists('date_time')) {
    function date_time($date)
    {
        return date('d M Y H:i A', strtotime($date));
    }
}

if (!function_exists('_date')) {
    function _date($date)
    {
        return (@$date && $date != '0000-00-00') ? date('d M Y', strtotime($date)) : '';
    }
}

if (!function_exists('captcha_settings')) {
    function captcha_settings()
    {
        $CI = &get_instance();
        return $CI->model->getRow('captcha_settings');
    }
}

function _time($time)
{
    return (@$time) ? date('h:i A', strtotime($time)) : '';
}

function _days_diff($date1, $date2)
{
    $diff = strtotime($date2) - strtotime($date1);
    return round($diff / 86400);
}


// send mail
if (!function_exists('sendMail'))
{
   function sendMail($message,$email,$subject)
    {
        
          $ch = curl_init();
          $fields = array( 'message'=>$message, 'email'=>$email,'subject'=>$subject);
          $postvars = '';
          foreach($fields as $key=>$value) {
            $postvars .= $key . "=" . $value . "&";
          }
          $url = "https://www.techfizone.com/techfiprojects/email_master/sheffieldsvapeoutlet/mailApi.php";
          curl_setopt($ch,CURLOPT_URL,$url);
          curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
          curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
          curl_setopt($ch,CURLOPT_TIMEOUT, 20);
          $response = curl_exec($ch);
    
          curl_close ($ch);

        //use curl for mail sending
        
    }    
}
if (!function_exists('sendMailReceipt'))
{
   function sendMailReceipt($message,$email,$subject,$attatchment="",$filename="")
    {
        
          $ch = curl_init();
          $fields = array( 'message'=>$message, 'email'=>$email,'subject'=>$subject,'attatchment'=>$attatchment,'filename'=>$filename);
          $postvars = '';
          foreach($fields as $key=>$value) {
            $postvars .= $key . "=" . $value . "&";
          }
          $url = "https://www.techfizone.com/techfiprojects/email_master/sheffieldsvapeoutlet/mailApi.php";
          curl_setopt($ch,CURLOPT_URL,$url);
          curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
          curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
          curl_setopt($ch,CURLOPT_TIMEOUT, 20);
          $response = curl_exec($ch);
    
          curl_close ($ch);

        //use curl for mail sending
        
    }    
}


// send mobile otp

if (!function_exists('send_sms'))
{
 function send_sms($mobile,$message)
{
        $senderId='TECHFZ';
        $serverUrl='http://msg.msgclub.net/rest/services/sendSMS/sendGroupSms?AUTH_KEY=';
        $authKey='51ed3366a65d909977ade34af8c5523';
        $routeId='1';
        $country=91;
        $getData='mobileNos='.$mobile.'&message='.urlencode($message).'&senderId='.$senderId.'&routeId='.$routeId;
        
        $endpoints = $serverUrl.$authKey."&".$getData;
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $endpoints,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            
        ));
        $output = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
        $flag = 0;
        if(!$output) {
            trigger_error(curl_error($ch));
        } else {
            $flag=1;
        }

        curl_close($ch);

        return $flag;
    
}

// get setting of users
if (!function_exists('setting')) {
    function setting()
    {
        $CI = &get_instance();
        return $CI->model->getRow('settings');
    }
}








}

if (!function_exists('get_route_name')) {
    function get_route_name() {
        $CI =& get_instance();
        $uri_string = $CI->uri->uri_string();
        return $uri_string;
    }
}

if (!function_exists('logs')) {
	function logs($user,$item,$action,$alias) {
		$table='logs';
		$CI =& get_instance();
		$CI->load->database();
		$route_name = get_route_name();
		$logdata = array(
		  'user_id'=>$user,
		  'item_id'=>$item,
		  'action'=>$action,
		  'url'=>$route_name,
		  'alias'=>$alias,
		);
		return $CI->db->insert($table, $logdata);
	}
}


 function calculate_extra_nights($end_date) {
    $current_date = new DateTime();
    $end_date_obj = new DateTime($end_date);

    // Check if the end date and current date are the same
    if ($end_date_obj->format('Y-m-d') > $current_date->format('Y-m-d')) {
        return 0;
    }

    // Calculate the interval between dates
    $interval = $current_date->diff($end_date_obj);
    $days_between = $interval->days;

    // Check if the current time is greater than 12 PM
    $current_time = new DateTime();
    $noon_time = new DateTime('12:00:00');
    if ($current_time > $noon_time) {
        $days_between += 1;
    }

    return $days_between;
}
