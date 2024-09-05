<?php
	if(! defined('ENVIRONMENT') )
	{
		$domain = strtolower($_SERVER['HTTP_HOST']);
		switch($domain) {
			case 'www.thehotelreception.com' : 						define('ENVIRONMENT', 'production'); 	break;
			case 'thehotelreception.com' : 						define('ENVIRONMENT', 'production'); 	break;
			case 'adminshopzone.herokuapp.com': 		define('ENVIRONMENT', 'staging'); 		break;
			default : 									define('ENVIRONMENT', 'development'); 	break;
		}
	}
?>