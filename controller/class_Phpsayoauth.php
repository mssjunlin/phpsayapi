<?php

class Phpsayoauth
{
	public static function Authorization($oauth_token='0',$oauth_token_secret='0')
	{
		if(!$oauth_token){
			return false;
			exit;
		}
		if(!$oauth_token_secret){
			return false;
			exit;
		}
		
	    return true;
	   
	}	
	
	public static function getUserinfo($oauth_token,$oauth_token_secret,$DB){
		$user = $DB->fetch_one_array("SELECT `uid` FROM `phpsay_member` WHERE `oauth_token`=".$oauth_token." and `oauth_token_secret`=".$oauth_token_secret);
	    return $user;
	}
	
}
?>