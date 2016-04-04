<?php
// 
//  api.php
//  <api.int>
//  QQ:95327294
//  Created by mssjunlin on 2016-04-04.
//  Copyright 2016 mssjunlin. All rights reserved.
// 

// phpsay系统根目录路径
define('SITE_PATH', dirname(dirname(__FILE__)));

define('API_PATH', SITE_PATH.'/api/mod/');

define('PHPSAY_API', true);

require(SITE_PATH."/global.php");

$apimode = array('user','thread','viewthread','reply');


$mod = $_GET['mod']; 


$data['msg'] = '';

$data['code'] = '-1'; 
  
if (in_array($mod, $apimode)) {
	
	if($apimode == 'user' ){
		 
		 require_once API_PATH.'./user.inc.php';	
		 
	}else{
		 
		 $oauth_token = isset($_GET['oauth_token'])?strtolower(stripslashes(trim($_GET['oauth_token']))):'0';
		 
		 $oauth_token_secret =  isset($_GET['oauth_token_secret'])?strtolower(stripslashes(trim($_GET['oauth_token_secret']))):'0';
		 
		 if(api_core::init($oauth_token,$oauth_token_secret)){
		 	
		 	$DB = database();
			 
		 	$userinfo = api_core::getUser($oauth_token,$oauth_token_secret,$DB);	
			
		    require_once API_PATH.$mod.'.php';	
			 	 	
		 }else{
		 	
            $data['code'] = '-1';
			
			$data['msg'] = 'Oauth error'; 	
				 	
		 }

	}
	
   
}
api_core::result($data);

class api_core {

        static function init($oauth_token='0',$oauth_token_secret='0'){
        	
        	require(PHPSAY_SITE."/controller/class_Phpsayoauth.php");
			
        	return Phpsayoauth::Authorization($oauth_token,$oauth_token_secret);
			
        }
		
		static function getUser($oauth_token,$oauth_token_secret,$DB){
			
        	return Phpsayoauth::getUserinfo($oauth_token,$oauth_token_secret,$DB);
			
        }

		static function result($result) {
			
				ob_end_clean();
				
				function_exists('ob_gzhandler') ? ob_start('ob_gzhandler') : ob_start();
				
				header("Content-type: application/json");
				
				$result = self::json(self::format($result));
				
				if(defined('FORMHASH')) {
					
					echo empty($_GET['jsoncallback_'.FORMHASH]) ? $result : $_GET['jsoncallback_'.FORMHASH].'('.$result.')';
					
				} else {
					
					echo $result;
					
				}
				
				exit;
		}
		
		 static function format($result) {
			
				switch (gettype($result)) {
				
					case 'array':
					
						foreach($result as $_k => $_v) {
						
							$result[$_k] = self::format($_v);
							
						}
						
						break;
						
					case 'boolean':
					
					case 'integer':
					
					case 'double':
					
					case 'float':
					
						$result = (string)$result;
						
						break;
				}
				
				return $result;
	     }
		
		 static function json($encode) {
			
		    require_once SITE_PATH.'/api/json.class.php';
		   
		    return CJSON::encode($encode);
		   
	     }
		
		 static function getOAuthToken($uid){
			
	        return md5( $uid . uniqid() );
		   
         } 
		
         static function getOAuthTokenSecret(){
	        return md5( time() . uniqid() );
         }
		
		
}
