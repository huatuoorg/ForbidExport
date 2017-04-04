<?php
if (!defined('MEDIAWIKI')){
    die('错误');
}
$wgExtensionCredits['other'][] = array(
    'path'           => __FILE__,
    'name'           =>'ForbidExport',
    'version'        =>'1.0',
    'author'         =>'华佗百科',
    'descriptionmsg' =>'导出功能加强',
    'url'            =>'http://www.huatuo.org'
	);
$wgHooks['SpecialPage_initList'][] = 'removeExportSpecial';
function removeExportSpecial(&$aSpecialPages){
	global $wgUser;
	if (!$wgUser->isLoggedIn()) {
		unset($aSpecialPages['Export']);
	}else{
		$uId=$wgUser->getId();
		$dbr=wfGetDB(DB_SLAVE);
		$rs=$dbr->select("user_groups",'ug_user',array('ug_group'=>"sysop",'ug_user'=>$uId),__METHOD__);
		$num=$rs->numRows($rs);
		if($num==""){
			unset($aSpecialPages['Export']);
		}
	}
	return true;
}

MagicWord::$mCacheTTLs['numberofarticles'] = 86400;
MagicWord::$mCacheTTLs['currenttimestamp'] = 86400;
?>