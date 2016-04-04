<?php
// 
//  user.php
//  <login 等>
//  QQ:95327294
//  Created by Administrator on 2016-04-04.
//  Copyright 2016 Administrator. All rights reserved.
// 
if( isset($_GET['account'],$_GET['password']) ){
	
		$loginAccount	= strtolower(stripslashes(trim($_GET['account'])));
		
		$loginPassword	= stripslashes($_GET['password']);
		
		if( strlen($loginAccount) < 2 )
		{
			
			$data['msg'] = "账号无效";
			$data['code'] = '-99';
			
		}			
						
		if( strlen($loginPassword) < 6 || strlen($loginPassword) > 26 || substr_count($loginPassword," ") > 0 )
		{
						$data['msg'] = "密码无效";
						$data['code'] = '-98';
		}
		
		$loginType = "nickname";
					
		
		if(emailCheck($loginAccount) )
		{
			$loginType = "email";
						
		}
		else
		{
			if( checkNickname($loginAccount) != "" )
			{
							$data['msg'] = "账号不合法";
							$data['code'] = '-97';
						
			}
		}
		
		$userInfo = PHPSay::getMemberInfo($DB,$loginType,$loginAccount);
		
		if( empty($userInfo['uid']) )
			{
				$data['msg'] = "账号不存在";
				$data['code'] = '-96';
			}
			else
			{
				if( md5($loginPassword) == $userInfo['password'] )
				{
					loginCookie($PHPSayConfig['ppsecure'],$userInfo['uid'],$userInfo['nickname'],$userInfo['groupid']);

					$data['msg'] = "ok";
					
				    $data['code'] = '1';
					
					$token = api_core::getOAuthToken($userInfo['uid']);
					
					$secret = api_core::getOAuthTokenSecret();
					
					$DB->query("UPDATE `phpsay_member` SET oauth_token='".$token."',oauth_token_secret='".$secret."' WHERE `uid`=".$userInfo['uid']);
					
					$data['userinfo'] = array('uid'=>$userInfo['uid'],'username'=>$userInfo['nickname'],'avatar'=>$userInfo['avatar'],'oauth_token'=>$token,'oauth_token_secret'=>$secret);
				
				}
				else
				{
					$data['msg'] = "密码错误";
				    $data['code'] = '-95';
				}
		}
			
		$DB->close();
}	