<?php
// 
//  thread.php
//  <thrad api>
//  QQ:95327294
//  Created by mssjunlin on 2016-04-04.
//  Copyright 2016 mssjunlin. All rights reserved.
// 


if(!defined('PHPSAY_API')) {
	exit('Access Denied');
}

$data['code'] = '1';
$uid = $userinfo['uid'];
//执行业务


$clubList = PHPSay::getClubList( $DB, isset($_GET['cid']) ? intval($_GET['cid']) : 0 );

$list = PHPSay::getTopic($DB,"club",$clubList,$currentPage,30);

$data['list'] = $list['list'];

$data['count'] = count($list['list'])>1?$list['count']:0;

$data['nowPage'] = intval($_GET['page']);

$DB->close();