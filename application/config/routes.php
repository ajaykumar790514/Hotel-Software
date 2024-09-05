<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']   = 'Portal';
$route['404_override'] 			 = 'pagenotfound';
$route['translate_uri_dashes'] = FALSE;

$route['test/(:any)']			= 'main/test/$1';
$route['login']			= 'login/index/host/$1';
$route['login/(:any)']			= 'login/index/host/$1';
$route['admin-login']			= 'login/index/admin';
$route['dashboard_content'] 	 = 'dashboard/dashboard_content';
$route['host_dashboard_content'] = 'dashboard/host_dashboard_content';

$route['occupied-property-host']   	 = 'dashboard/host_occupied_property';
$route['availabile-property-host'] 	 = 'dashboard/host_availabile_property';

$route['delete_property_images/(:any)/(:num)'] = 'properties/delete_images/$1/$2';
$route['sp_default_image'] = 'properties/sp_default_image';


//Start :: Account
$route['account']				= 'accounts/index';
$route['account']				= 'accounts/index';
$route['account_dashboard']		= 'accounts/dashboard_content';
$route['accountChart']			= 'accounts/chart';

$route['admin_profile']						= 'accounts/admin_profile';
$route['admin_profile/(:any)'] 	   	     	= 'accounts/admin_profile/$1';
$route['admin_profile/(:any)/(:num)'] 	 	= 'accounts/admin_profile/$1/$2';

$route['my-plans'] 	 	                = 'accounts/my_plans';
$route['my-plans/(:any)'] 	   	     	= 'accounts/my_plans/$1';
$route['my-plans/(:any)/(:num)'] 	 	= 'accounts/my_plans/$1/$2';
//End :: Account

//Start :: Expenses
$route['expenses']				= 'Expenses/index';
$route['expenses/(:any)']		= 'Expenses/index/$1';
$route['expense_type']			= 'Expenses/type';
$route['expense_type/(:any)']	= 'Expenses/type/$1';
$route['expense_type/(:any)/(:any)']	= 'Expenses/type/$1/$2';
//End :: Expanses

// Start :: properties
$route['properties/(:any)'] 		= 'properties/index/$1';
$route['properties/(:any)/(:num)']  = 'properties/index/$1/$2';
$route['properties-status']  = 'properties/approval_status_change';
// End :: properties

// // Start :: Inventory
$route['inventory'] 		       		  = 'Inventory/index';
$route['inventory/(:any)'] 		   		  = 'Inventory/index/$1';
$route['inventory/(:any)/(:any)']  		  = 'Inventory/index/$1/$2';
$route['inventory/(:any)/(:any)/(:any)']  = 'Inventory/index/$1/$2/$3';
$route['inventory/(:any)/(:any)/(:any)/(:any)']  = 'Inventory/index/$1/$2/$3/$4';
// // End :: Inventory

// Start :: sub_properties
$route['sub_properties/(:num)'] 		       = 'properties/sub_properties/$1';
$route['sub_properties/(:num)/(:any)']         = 'properties/sub_properties/$1/$2';
$route['sub_properties/(:num)/(:any)/(:num)']  = 'properties/sub_properties/$1/$2/$3';
$route['inventory_cal']  					   = 'properties/inventory_cal';
$route['save_inventory']  					   = 'properties/save_inventory';
$route['upgradeplan/(:num)']  					   = 'properties/upgradeplan/$1';
// End :: sub_properties

// Sub Property TYpes
$route['sub_properties_types/(:num)'] 		       = 'properties/sub_properties_types/$1';
$route['sub_properties_types/(:num)/(:any)']         = 'properties/sub_properties_types/$1/$2';
$route['sub_properties_types/(:num)/(:any)/(:num)']  = 'properties/sub_properties_types/$1/$2/$3';
 


// Start :: sub_properties
$route['property_reviews'] 		      				   = 'properties/property_reviews';
$route['property_reviews/(:any)'] 		    		   = 'properties/property_reviews/$1';
$route['property_reviews/(:any)/(:any)'] 		       = 'properties/property_reviews/$1/$2';
$route['property_reviews/(:any)/(:any)/(:num)'] 	   = 'properties/property_reviews/$1/$2/$3';
$route['property_reviews/(:any)/(:any)/(:num)/(:num)'] = 'properties/property_reviews/$1/$2/$3/$4';
// End :: sub_properties


// Start :: sleeping_arrangements

$route['sleeping_arr/(:num)/(:any)/(:num)']  		= 'properties/sleeping_arrangements/$1/$2/$3';
$route['sleeping_arr/(:num)/(:any)/(:num)/(:num)']  = 'properties/sleeping_arrangements/$1/$2/$3/$4';

// End :: sleeping_arrangements



$route['flatcode'] 		           = 'properties/flatcode/$1';
$route['flatcode/(:num)'] 		   = 'properties/flatcode/$1/$2';
$route['propcode'] 		      	   = 'properties/index/propcode';
$route['propcode/(:num)'] 		   = 'properties/index/propcode/$1';
$route['load_locations'] 		   = 'properties/load_locations';
$route['load_locations_new'] 		   = 'properties/load_locations_new';
// Start :: sub_properties
$route['appUser'] 		      		   = 'appUser/users';
$route['appUser/(:any)'] 		   	   = 'appUser/users/$1';
$route['appUser/(:any)/(:any)'] 	   = 'appUser/users/$1/$2';
$route['appUser/(:any)/(:any)/(:num)'] = 'appUser/users/$1/$2/$3';

// End :: sub_properties

// // Start :: Reservations
// new
$route['reservation_new_form'] 		  		= 'reservations/reservation_new_form';
$route['reservation_new_form/(:any)'] 		= 'reservations/reservation_new_form/$1';
$route['reservations/reservation_new'] 		  		    = 'reservations/reservation_new';


$route['reservations/get_price']             = 'reservations/get_price_new';
$route['reservations/check_availability']    = 'reservations/check_availability';
$route['reservations/count_nights']          = 'reservations/count_nights';
$route['reservations/find_taxRate']          = 'reservations/find_taxRate';
$route['cron/check_and_cancel'] = 'reservations/check_and_cancel';


// new

// update
$route['reservations/check_availability_update']    = 'reservations/check_availability_update';
$route['reservations/count_nights_update']          = 'reservations/count_nights_update';
$route['reservations/get_price_update']             = 'reservations/get_price_update_new';


$route['reservations/save'] 		  		= 'reservations/save';
$route['reservations/save/(:any)'] 		  	= 'reservations/save/$1';
$route['reservations/save/(:any)/(:num)']  	= 'reservations/index/$1/$2';

$route['reservations'] 		           		 		= 'reservations/index';
$route['reservations/inventry'] 	   				= 'reservations/inventry';
$route['reservations/inventry/(:any)']       		= 'reservations/inventry/$1';
$route['cancel-booking/(:num)'] 			 		= 'reservations/cancel_booking/$1';
$route['check-availability-price/(:num)']    		= 'reservations/check_availability_price/$1';
$route['check-availability-price-re/(:num)/(:num)'] = 'reservations/check_availability_price_reschedule/$1/$2';
$route['check-availability-price-flat']  	 		= 'reservations/check_availability_price_flat';
$route['reservations/(:any)'] 		   		 		= 'reservations/index/$1';
$route['reservations/(:any)/(:num)']         		= 'reservations/index/$1/$2';
$route['reservations/(:any)/(:any)']         		= 'reservations/index/$1/$2';
$route['reservations-doc/(:num)']         		    = 'reservations/doc/$1';
$route['reservations-doc/(:num)/(:any)']            = 'reservations/doc/$1/$2';

$route['reservations/check_in_remaining'] 		  	= 'reservations/check_in_remaining';
$route['reservations/checked_in'] 		  			= 'reservations/checked_in';
$route['reservations/check_out_remaining'] 		  	= 'reservations/check_out_remaining';
$route['checked_out'] 		  			= 'reservations/checked_out';
$route['staying'] 		  				= 'reservations/staying';
$route['upcoming_booking'] 		  		= 'reservations/upcoming_booking';
$route['reservations/cancelled_reservation'] 		  	= 'reservations/cancelled_reservation';
$route['reservations/total_reservation'] 		  	= 'reservations/total_reservation';


$route['checkin/(:num)'] 		  		    = 'checkin/index/$1';
$route['checkin-new/(:num)'] 		  		    = 'checkin/checkin_new/$1';

$route['checkin-guests-details/(:num)']     = 'checkin/checkin_guests_details/$1';
$route['checkout/(:num)'] 		  		    = 'checkout/index/$1';
$route['checkout/list/(:num)'] 		  		= 'checkout/list/$1';
$route['checkout/checkout_receipt/(:num)'] 	= 'checkout/checkout_receipt/$1';
$route['checkout/edit_checkout/(:num)'] 	= 'checkout/edit_checkout/$1';

$route['propCalendar/reservation']	= 'propCalendar/reservation';
$route['propCalendar/reservation/(:num)']	= 'propCalendar/reservation/$1';
$route['propCalendar/create_reservation']['post'] = 'propCalendar/create_reservation';

$route['propCalendar'] 		            = 'propCalendar/index';
$route['propCalendar/(:any)'] 		    = 'propCalendar/index/$1';
$route['propCalendar/(:any)/(:num)']    = 'propCalendar/index/$1/$2';

$route['property-calendar-extend/(:num)'] 		= 'propCalendar/property_calendar_for_extend/$1';
$route['property-calendar-change-flat/(:num)']	= 'propCalendar/property_calendar_for_change_flat/$1';
$route['property-calendar-reschedule/(:num)']	= 'propCalendar/property_calendar_for_reschedule/$1';


$route['extend/(:num)']					= 'reservation_update/extend/$1';
$route['change-flat/(:num)']			= 'reservation_update/change_flat/$1';
$route['pre-check-out/(:num)']			= 'reservation_update/pre_check_out/$1';
$route['pre-check-out/(:num)/(:any)']	= 'reservation_update/pre_check_out/$1/$2';
$route['reschedule-booking/(:num)']		= 'reservation_update/reschedule_booking/$1';
	
// // End :: Reservations

$route['send-payment-link/(:num)']		= 'payment/send_payment_link/$1';
$route['callback']						= 'payment/callback';
$route['paynow/(:num)']					= 'payment/paynow/$1';




// Start :: Masters
$route['reviews_source'] 		       		   = 'masters/reviews_source';
$route['reviews_source/(:any)'] 		       = 'masters/reviews_source/$1';
$route['reviews_source/(:any)/(:num)'] 		   = 'masters/reviews_source/$1/$2';

$route['package'] 		       		   = 'masters/package_master';
$route['package/(:any)'] 		       = 'masters/package_master/$1';
$route['package/(:any)/(:num)'] 		   = 'masters/package_master/$1/$2';

$route['sleeping_title_master'] 		       	 = 'masters/sleeping_arr_title';
$route['sleeping_title_master/(:any)'] 	   	     = 'masters/sleeping_arr_title/$1';
$route['sleeping_title_master/(:any)/(:num)'] 	 = 'masters/sleeping_arr_title/$1/$2';

$route['sleeping_desc_master'] 		       		 = 'masters/sleeping_arr_desc';
$route['sleeping_desc_master/(:any)'] 	   	     = 'masters/sleeping_arr_desc/$1';
$route['sleeping_desc_master/(:any)/(:num)'] 	 = 'masters/sleeping_arr_desc/$1/$2';

$route['broadband_master'] 		       		 	= 'masters/broadband_master';
$route['broadband_master/(:any)'] 	   	     	= 'masters/broadband_master/$1';
$route['broadband_master/(:any)/(:num)'] 	 	= 'masters/broadband_master/$1/$2';

$route['location_master'] 		       		 	= 'masters/location_master';
$route['location_master/(:any)'] 	   	     	= 'masters/location_master/$1';
$route['location_master/(:any)/(:num)'] 	 	= 'masters/location_master/$1/$2';

$route['district_master'] 		       		 	= 'masters/district_master';
$route['district_master/(:any)'] 	   	     	= 'masters/district_master/$1';
$route['district_master/(:any)/(:num)'] 	 	= 'masters/district_master/$1/$2';

$route['tax-range'] 		       		 		= 'masters/tax_range';
$route['tax-range/(:any)'] 	   	     			= 'masters/tax_range/$1';
$route['tax-range/(:any)/(:num)'] 	 			= 'masters/tax_range/$1/$2';

$route['create_json_file']					 =	'website/create_json_file';

$route['work_master'] 		       		 	= 'masters/work_master';
$route['work_master/(:any)'] 	   	     	= 'masters/work_master/$1';
$route['work_master/(:any)/(:num)'] 	 	= 'masters/work_master/$1/$2';

$route['home_banner'] 		       		 	= 'masters/home_banner';
$route['home_banner/(:any)'] 	   	     	= 'masters/home_banner/$1';
$route['home_banner/(:any)/(:num)'] 	 	= 'masters/home_banner/$1/$2';

$route['language_master'] 		       		 	= 'masters/language_master';
$route['language_master/(:any)'] 	   	     	= 'masters/language_master/$1';
$route['language_master/(:any)/(:num)'] 	 	= 'masters/language_master/$1/$2';

$route['property_document'] 		       		 	= 'masters/property_document';
$route['property_document/(:any)'] 	   	     	= 'masters/property_document/$1';
$route['property_document/(:any)/(:num)'] 	 	= 'masters/property_document/$1/$2';
// End :: Masters

//Start :: host

$route['sub-host']							= 'host_m/sub_host';
$route['sub-host/(:any)']					= 'host_m/sub_host/$1';
$route['sub-host/(:any)/(:any)']			= 'host_m/sub_host/$1/$2';
$route['sub-host/(:any)/(:any)/(:any)']		= 'host_m/sub_host/$1/$2/$3';

$route['more-info']							= 'host_m/more_details';
$route['more-info/(:any)']					= 'host_m/more_details/$1';
$route['more-info/(:any)/(:any)']			= 'host_m/more_details/$1/$2';

//End :: host



$route['getStates']        					 = 'main/getStates';
$route['getStates/(:num)']        			 = 'main/getStates/$1';
$route['getStates/(:num)/(:num)'] 			 = 'main/getStates/$1/$2';
$route['getCities']        			 		 = 'main/getCities';
$route['getCities/(:num)']        			 = 'main/getCities/$1';
$route['getCities/(:num)/(:num)'] 			 = 'main/getCities/$1/$2';
$route['getLocations'] 		                     = 'main/getLocations';
$route['getLocations/(:num)']        			 = 'main/getLocations/$1';
$route['getLocations/(:num)/(:num)'] 			 = 'main/getLocations/$1/$2';
$route['propmasterByLocation/(:num)']   	 = 'main/propmasterByLocation/$1';
$route['propmasterByLocation/(:num)/(:num)'] = 'main/propmasterByLocation/$1/$2';
$route['subProperty/(:num)'] 				 = 'main/subProperty/$1';
$route['subProperty/(:num)/(:num)'] 		 = 'main/subProperty/$1/$2';
$route['getDistrict/(:num)']        		 = 'main/getDistrict/$1';
$route['getSubPropertyType']        					 = 'main/getSubPropertyType';
$route['getSubPropertyType/(:num)']        			 = 'main/getSubPropertyType/$1';
$route['getSubPropertyType/(:num)/(:num)'] 			 = 'main/getSubPropertyType/$1/$2';

$route['changeStatus']         		= 'main/changeStatus';
$route['changeVisibility']         	= 'main/changeStatus';
$route['changeStatus/(:any)']  		= 'main/changeStatus/$1';
$route['changeVisibility/(:any)']  	= 'main/changeStatus/$1';

$route['changeStatusDispaly']  = 'main/changeStatusDispaly';
$route['change_status']        = 'main/change_status';
$route['changeIndexing']       = 'main/changeIndexing';
$route['title/(:any)/(:num)']  = 'main/title/$1/$2';
$route['logout'] 	           = 'login/logout';
$route['logout-admin'] 	       = 'login/logout_admin';

$route['receipt/(:any)']       = 'receipt/index/$1';
$route['cancel_receipt_url/(:num)']       = 'receipt/cancel_receipt_url/$1';

$route['new-account'] 	 = 'login/new_account';
$route['new-account/(:any)'] 	 = 'login/new_account/$1';

$route['thanks'] = 'Properties/thanks';

$route['forgot-password'] 	 = 'login/forgot_password';
$route['forgot-password/(:any)'] 	 = 'login/forgot_password/$1';


$route['login_remote/(:any)'] 		= 'login/login_remote/$1';
$route['login_remote/(:any)/(:any)'] 	= 'login/login_remote/$1/$2';
$route['login_remote/(:any)/(:any)/(:any)'] = 'login/login_remote/$1/$2/$3';
$route['login_remote/(:any)/(:any)/(:any)/(:any)'] = 'login/login_remote/$1/$2/$3/$4';

$route['submit-enquiry'] 		= 'login/submit_enquiry';
$route['checkSubProperty/(:any)'] 		= 'properties/checkSubProperty/$1';
$route['activatePlan'] 		= 'properties/activatePlan';

$route['cancel-reservations']        					 = 'reservations/cancel_reservations';
$route['cancel-reservations/(:any)']        			 = 'reservations/cancel_reservations/$1';
$route['cancel-reservations/(:any)/(:any)'] 			 = 'reservations/cancel_reservations/$1/$2';

$route['sales-report']        					 = 'Reports/sales_report';
$route['sales-report/(:any)']        			 = 'Reports/sales_report/$1';

$route['arr-report']        					 = 'Reports/arr_report';
$route['arr-report/(:any)']        			 = 'Reports/arr_report/$1';

$route['expanse-report']        					 = 'Reports/expanse_report';
$route['expanse-report/(:any)']        			 = 'Reports/expanse_report/$1';
$route['renew-plan/(:any)']        			 = 'Properties/renew_plan/$1';
$route['renew_yoru_plan/(:any)']        			 = 'Properties/renew_yoru_plan/$1';
$route['update_payment_status/(:any)']        			 = 'Properties/update_payment_status/$1';
$route['update_payment_status/(:any)/(:any)']        			 = 'Properties/update_payment_status/$1/$2';


$route['enquiry']        					 = 'Portal/enquiry';
$route['enquiry/(:any)']        			 = 'Portal/enquiry/$1';
$route['enquiry/(:any)/(/any)']        			 = 'Portal/enquiry/$1/$2';
$route['update_status_en']  					   = 'Portal/update_status_en';

$route['about-us']        					 = 'Portal/about_us';
$route['contact-us']        					 = 'Portal/contact_us';
$route['privacy-policy']        					 = 'Portal/privacy_policy';
$route['terms-condition']        					 = 'Portal/terms_condition';
$route['cancellations-refund']        					 = 'Portal/cancellations_refund';
$route['shipping-delivery']        					 = 'Portal/shipping_delivery';

$route['occupancy-report']        					 = 'Reports/occupancy_report';
$route['occupancy-report/(:any)']        			 = 'Reports/occupancy_report/$1';

$route['comparison-report']        					 = 'Reports/comparison_report';
$route['comparison-report/(:any)']        			 = 'Reports/comparison_report/$1';

$route['tax-report']        					 = 'Reports/tax_report';
$route['tax-report/(:any)']        			 = 'Reports/tax_report/$1';

$route['check_and_cancel']        					 = 'Reservations/check_and_cancel';

$route['host_m/(:any)'] = 'host_m/$1';
$route['host_m/(:any)/(:any)'] = 'host_m/$1/$2';
$route['host_m/(:any)/(:any)/(:any)'] = 'host_m/$1/$2/$3';
$route['host_m/(:any)/(:any)/(:any)/(:any)'] = 'host_m/$1/$2/$3/$4';


$route['admin_menu'] = 'users/admin_menu/';
$route['admin_menu/(:any)'] = 'users/admin_menu/$1';
$route['admin_menu/(:any)/(:any)'] = 'users/admin_menu/$1/$2';


$route['user'] = 'users/user/';
$route['user/(:any)'] = 'users/user/$1';
$route['user/(:any)/(:any)'] = 'users/user/$1/$2';

$route['user_role'] = 'users/user_role/';
$route['user_role/(:any)'] = 'users/user_role/$1';
$route['user_role/(:any)/(:any)'] = 'users/user_role/$1/$2';

$route['host-roles'] = 'users/host_roles/';
$route['host-roles/(:any)'] = 'users/host_roles/$1';
$route['host-roles/(:any)/(:any)'] = 'users/host_roles/$1/$2';



$route['host'] = 'host_m/host/';
$route['host/(:any)'] = 'host_m/host/$1';
$route['host/(:any)/(:any)'] = 'host_m/host/$1/$2';
$route['host/(:any)/(:any)/(:any)'] = 'host_m/host/$1/$2/$3';
$route['host/(:any)/(:any)/(:any)/(:any)'] = 'host_m/host/$1/$2/$3/$4';

$route['website-properties'] = 'website/website_properties/';
$route['website-properties/(:any)'] = 'website/website_properties/$1';
$route['website-properties/(:any)/(:any)'] = 'website/website_properties/$1/$2';


$route['company-billing-info'] = 'users/company_billing_info/';
$route['company-billing-info/(:any)'] = 'users/company_billing_info/$1';
$route['company-billing-info/(:any)/(:any)'] = 'users/company_billing_info/$1/$2';
