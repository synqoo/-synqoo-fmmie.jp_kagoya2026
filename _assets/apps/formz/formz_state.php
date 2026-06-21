<?php
$fp = file_get_contents('https://backsite.pro/fmmie/storage/formzconfig/'.$fm_id.'_config.txt');
//$fp = file_get_contents('https://fmmie.backsite.pro/formzconfig'.$fm_id.'_config.txt');
$conf_array = explode(";",$fp);
$stateusmode = $conf_array[0];
$opendate = $conf_array[1];
$closedate = $conf_array[2];

$now=date('Y-m-d H:i:s');
if($opendate!='0000-00-00 00:00:00' and $stateusmode==1){
	$timestamp1 = strtotime($opendate);
    $timestamp2 = strtotime($now);
	if(($timestamp2 - $timestamp1) < 0){
		$submitmode=1;
		$submit_mess="募集開始までしばらくお待ちください。";
	}else{
		$submitmode=0;
	}
}

if($closedate!='0000-00-00 00:00:00' and $stateusmode==1 and $submitmode==0){
	$timestamp1 = strtotime($closedate);
    $timestamp2 = strtotime($now);
	if(($timestamp2 - $timestamp1) > 0){
		$submitmode=1;
		$submit_mess="応募は締め切りました。";
	}else{
		$submitmode=0;
	}
}

if($stateusmode==0){
	$testmode=1;$submitmode=0;
}elseif($stateusmode==1){
	$testmode=0;
}elseif($stateusmode==1){
	$testmode=0;$submitmode=1;
}
?>
