<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Db_repair extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// booking_new
		if (!$this->db->field_exists('agent', 'booking_new'))
		{
		    $query = "ALTER TABLE `booking_new` ADD `agent` INT NULL AFTER `booking_from`";
		    if($this->db->query($query)){
		    	echo "agent field created in `booking_new` table.<br>";
		    }
		}

		if (!$this->db->field_exists('property_id', 'booking_new_items'))
		{
		    $query = "ALTER TABLE `booking_new_items` ADD `property_id` INT NULL AFTER `id`";
		    if($this->db->query($query)){
		    	echo "property_id field created in `booking_new_items` table.<br>";
		    }
		}

		if (!$this->db->field_exists('booking_remark', 'booking_new'))
		{
		    $query = "ALTER TABLE `booking_new` ADD `booking_remark` LONGTEXT NULL AFTER `total`";
		    if($this->db->query($query)){
		    	echo "booking_remark field created in `booking_new` table.<br>";
		    }

			$query = "ALTER TABLE `booking_new` ADD `discount_amount` bigint DEFAULT '0' AFTER `booking_remark`";
		    if($this->db->query($query)){
		    	echo "discount_amount field created in `booking_new` table.<br>";
		    }

			$query = "ALTER TABLE `booking_new` ADD `discount_remark` TEXT NULL AFTER `discount_amount`";
		    if($this->db->query($query)){
		    	echo "discount_remark field created in `booking_new` table.<br>";
		    }

			$query = "ALTER TABLE `booking_new` ADD `payment_status` INT NULL AFTER `discount_remark`";
		    if($this->db->query($query)){
		    	echo "payment_status field created in `booking_new` table.<br>";
		    }

			$query = "ALTER TABLE `booking_new` ADD `cancellation_reason_id` INT NULL AFTER `payment_status`";
		    if($this->db->query($query)){
		    	echo "cancellation_reason_id field created in `booking_new` table.<br>";
		    }

			$query = "ALTER TABLE `booking_new` ADD `cancellation_note` VARCHAR(100) NULL AFTER `cancellation_reason_id`";
		    if($this->db->query($query)){
		    	echo "cancellation_note field created in `booking_new` table.<br>";
		    }
		}

		if (!$this->db->field_exists('booking_date', 'booking_new'))
		{
		    $query = "ALTER TABLE `booking_new` ADD `booking_date` TIMESTAMP NULL AFTER `cancellation_note`";
		    if($this->db->query($query)){
		    	echo "booking_date field created in `booking_new` table.<br>";
		    }
		}

		if (!$this->db->field_exists('checkin_status', 'booking_new'))
		{
		    $query = "ALTER TABLE `booking_new` ADD `checkin_status` INT DEFAULT '0' AFTER `status`";
		    if($this->db->query($query)){
		    	echo "checkin_status field created in `booking_new` table.<br>";
		    }
		}

		if (!$this->db->field_exists('checkout_time1', 'booking_new'))
		{
		    $query = "ALTER TABLE `booking_new` ADD `checkout_time1` TIME NULL";
		    if($this->db->query($query)){
		    	echo "checkout_time1 field created in `booking_new` table.<br>";
		    }
		}

		if (!$this->db->field_exists('extended', 'booking_new'))
		{
		    $query = "ALTER TABLE `booking_new` ADD `extended` INT DEFAULT '0' ";
		    if($this->db->query($query)){
		    	echo "extended field created in `booking_new` table.<br>";
		    }
			$query = "ALTER TABLE `booking_new` ADD `extended_remark` TEXT NULL";
		    if($this->db->query($query)){
		    	echo "extended_remark field created in `booking_new` table.<br>";
		    }

		}

		if (!$this->db->field_exists('checkin_time', 'booking_new'))
		{
		    $query = "ALTER TABLE `booking_new` ADD `checkin_time` time NULL";
		    if($this->db->query($query)){
		    	echo "checkin_time field created in `booking_new` table.<br>";
		    }
		}

		if (!$this->db->field_exists('user_id', 'booking_new'))
		{
		    $query = "ALTER TABLE `booking_new` ADD `user_id` time NULL";
		    if($this->db->query($query)){
		    	echo "user_id field created in `booking_new` table.<br>";
		    }
			$query = "ALTER TABLE `checkin` CHANGE `flat_id` `flat_id` INT(11) NULL";
			$this->db->query($query);
			$query = "ALTER TABLE `checkin` CHANGE `user_id` `user_id` INT(11) NULL";
			$this->db->query($query);
			$query = "ALTER TABLE `room_allotment` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT";
			$this->db->query($query);
		}
		

		if (!$this->db->field_exists('extra_bedding', 'booking_new_items'))
		{
		    $query = "ALTER TABLE `booking_new_items` ADD `extra_bedding` INT NULL AFTER `qty`";
		    if($this->db->query($query)){
		    	echo "extra_bedding field created in `booking_new_items` table.<br>";
		    }
			$query = "ALTER TABLE `booking_new_items` ADD `extra_bedding_price` INT NULL AFTER `price`";
		    if($this->db->query($query)){
		    	echo "extra_bedding_price field created in `booking_new_items` table.<br>";
		    }
		}


		if (!$this->db->field_exists('discount', 'booking_new_items'))
		{
		    $query = "ALTER TABLE `booking_new_items` ADD `discount` INT NULL AFTER `extra_bedding`";
		    if($this->db->query($query)){
		    	echo "discount field created in `booking_new_items` table.<br>";
		    }
		}

		if (!$this->db->field_exists('total_discount', 'booking_new_items'))
		{
		    $query = "ALTER TABLE `booking_new_items` ADD `total_discount` INT NULL AFTER `discount`";
		    if($this->db->query($query)){
		    	echo "total_discount field created in `booking_new_items` table.<br>";
		    }
		}
		
		// booking_new

		// transaction
		if (!$this->db->field_exists('remark', 'transaction'))
		{
		    $query = "ALTER TABLE `transaction` ADD `remark` text NULL AFTER `reference_no`";
		    if($this->db->query($query)){
		    	echo "remark field created in `transaction` table.<br>";
		    }
		}
		// transaction




		// room_allotment
		if (!$this->db->table_exists('room_allotment'))
		{
		    $query = "CREATE TABLE `room_allotment` (
					  `id` int(11) NOT NULL,
					  `booking_id` int NOT NULL,
					  `property_id` int NOT NULL,
					  `room_type` int NOT NULL,
					  `date` date NOT NULL,
					  `active` enum('1','0') NOT NULL DEFAULT '1'
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		    if($this->db->query($query)){

		    	$query = "ALTER TABLE `room_allotment`
		    				ADD PRIMARY KEY (`id`)";
		    	$this->db->query($query);
		    	echo "room_allotment table created.<br>";
		    }
		}
		
		if (!$this->db->field_exists('flat_id', 'room_allotment'))
		{
		    $query = "ALTER TABLE `room_allotment` ADD `flat_id` int NULL AFTER `room_type`";
		    if($this->db->query($query)){
		    	echo "flat_id field created in `room_allotment` table.<br>";
		    }
			$query = "ALTER TABLE `room_allotment` ADD `flat_no` int NULL AFTER `flat_id`";
		    if($this->db->query($query)){
		    	echo "flat_no field created in `room_allotment` table.<br>";
		    }
		}

		if (!$this->db->field_exists('checkin_id', 'room_allotment'))
		{
		    $query = "ALTER TABLE `room_allotment` ADD `checkin_id` int NULL AFTER `booking_id`";
		    if($this->db->query($query)){
		    	echo "checkin_id field created in `room_allotment` table.<br>";
		    }
		}
		// room_allotment


		// checkin
		if (!$this->db->field_exists('room_no', 'checkin'))
		{
		    $query = "ALTER TABLE `checkin` ADD `room_no` INT NULL AFTER `flat_id`";
		    if($this->db->query($query)){
		    	echo "room_no field created in `checkin` table.<br>";
		    }

			$query = "ALTER TABLE `checkin` ADD `room_type` INT NULL AFTER `room_no`";
		    if($this->db->query($query)){
		    	echo "room_type field created in `checkin` table.<br>";
		    }

			$query = "ALTER TABLE `checkin` ADD `price` INT NULL AFTER `room_type`";
		    if($this->db->query($query)){
		    	echo "price field created in `checkin` table.<br>";
		    }

			$query = "ALTER TABLE `checkin` ADD `discount` INT NULL AFTER `price`";
		    if($this->db->query($query)){
		    	echo "discount field created in `checkin` table.<br>";
		    }

			$query = "ALTER TABLE `checkin` ADD `pre_checkin_amount` INT NULL AFTER `discount`";
		    if($this->db->query($query)){
		    	echo "pre_checkin_amount field created in `checkin` table.<br>";
		    }

			$query = "ALTER TABLE `checkin` ADD `extra_bedding` INT NULL AFTER `pre_checkin_amount`";
		    if($this->db->query($query)){
		    	echo "extra_bedding field created in `checkin` table.<br>";
		    }

			
		}

		if (!$this->db->field_exists('is_checked_out', 'checkin'))
		{
		    $query = "ALTER TABLE `checkin` ADD `is_checked_out` INT NULL ";
		    if($this->db->query($query)){
		    	echo "is_checked_out field created in `checkin` table.<br>";
		    }

			$query = "ALTER TABLE `checkin` ADD `check_out_date_time` BIGINT NULL ";
		    if($this->db->query($query)){
		    	echo "check_out_date_time field created in `checkin` table.<br>";
		    }

			$query = "ALTER TABLE `checkin` ADD `checkout_id` INT NULL ";
		    if($this->db->query($query)){
		    	echo "checkout_id field created in `checkin` table.<br>";
		    }
		}
		// checkin


		if (!$this->db->table_exists('check_in_guests'))
		{
		    $query = "CREATE TABLE `check_in_guests` (
					  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
					  `booking_id` int NULL,
					  `checkin_id` int NULL,
					  `name` varchar(255) NULL,
					  `type` varchar(255) NULL,
					  `nationality` varchar(255) NULL,
					  `id_proof_type` varchar(255) NULL,
					  `id_proof_no` varchar(255) NULL,
					  `id_proof_pic_front` varchar(255) NULL,
					  `id_proof_pic_back` varchar(255) NULL,
					  `agreement_doc` varchar(255) NULL,
					  `guest_photo` varchar(255) NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		    if($this->db->query($query)){
		    	echo "check_in_guests table created.<br>";
		    }
		}

		if (!$this->db->table_exists('checkout_new'))
		{
		    $query = "CREATE TABLE `checkout_new` (
					  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
					  `booking_id` int NULL,
					  `guest_name` varchar(255) NULL,
					  `contact_no` varchar(50) NULL,
					  `email` varchar(50) NULL,
					  `company_name` varchar(255) NULL,
					  `address` text NULL,
					  `gst_no` varchar(20) NULL,
					  `check_in_ids` json NULL,
					  `food_amount` BIGINT NULL,
					  `other_amount` BIGINT NULL,
					  `grand_total` BIGINT NULL,
					  `lump_sum_discount` BIGINT NULL,
					  `check_out_date_time` BIGINT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		    if($this->db->query($query)){
		    	echo "checkout_new table created.<br>";
		    }
		}
	
		


	



		// transaction_heads
		// if (!$this->db->table_exists('transaction_heads'))
		// {
		//     $query = "CREATE TABLE `transaction_heads` (
		// 			  `id` int(11) NOT NULL,
		// 			  `name` varchar(250) NOT NULL,
		// 			  `active` enum('1','0') NOT NULL DEFAULT '1',
		// 			  `is_deleted` enum('DELETED','NOT_DELETED') NOT NULL DEFAULT 'NOT_DELETED',
		// 			  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		// 			  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		// 			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
		//     if($this->db->query($query)){

		//     	$query = "ALTER TABLE `transaction_heads`
		//     				ADD PRIMARY KEY (`id`)";
		//     	$this->db->query($query);

		//     	$query = "INSERT INTO `transaction_heads` (`id`, `name`, `active`, `is_deleted`, `created`, `updated`) VALUES
		//     	(1, 'Appointment Fees', '1', 'NOT_DELETED', '2023-01-31 05:28:55', '2023-01-31 05:28:55'),
		//     	(2, 'Medicine Fees', '1', 'NOT_DELETED', '2023-01-31 05:29:03', '2023-01-31 05:29:03')";
		//     	$this->db->query($query);


		//     	echo "transaction_heads table created.<br>";
		//     }
		// }
		// transaction_heads

		


		
	}

	public function get_tb($tb)
	{
		$rows = $this->db->get($tb)->result();

		echo _prx($rows);
	}
}
?>
