<?php
$docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
if (! function_exists('formz_load_config_file')) {
	require_once $docRoot . '/_assets/apps/functions.php';
}

global $stateusmode, $testmode, $submitmode, $submit_mess, $kinkyuformz;

if (! isset($kinkyuformz)) {
	$kinkyuformz = formz_read_kinkyuformz();
}

$fp = formz_load_config_file($fm_id, 'config.txt');

if ($fp === false) {
	error_log('Failed to load formz config (formz_state) for form_id=' . (int) $fm_id);
	$stateusmode = 0;
	$testmode = 1;
	$submitmode = 0;
	$opendate = '0000-00-00 00:00:00';
	$closedate = '0000-00-00 00:00:00';
} else {
	$conf_array = explode(';', $fp);
	$stateusmode = isset($conf_array[0]) ? (int) $conf_array[0] : 0;
	$opendate = isset($conf_array[1]) ? trim($conf_array[1]) : '0000-00-00 00:00:00';
	$closedate = isset($conf_array[2]) ? trim($conf_array[2]) : '0000-00-00 00:00:00';
}

$now = date('Y-m-d H:i:s');

if ($opendate != '0000-00-00 00:00:00' && $stateusmode == 1) {
	$timestamp1 = strtotime($opendate);
	$timestamp2 = strtotime($now);
	if ($timestamp1 !== false && $timestamp2 !== false && ($timestamp2 - $timestamp1) < 0) {
		$submitmode = 1;
		$submit_mess = '募集開始までしばらくお待ちください。';
	} else {
		$submitmode = 0;
	}
}

if ($closedate != '0000-00-00 00:00:00' && $stateusmode == 1 && $submitmode == 0) {
	$timestamp1 = strtotime($closedate);
	$timestamp2 = strtotime($now);
	if ($timestamp1 !== false && $timestamp2 !== false && ($timestamp2 - $timestamp1) > 0) {
		$submitmode = 1;
		$submit_mess = '応募は締め切りました。';
	} else {
		$submitmode = 0;
	}
}

if ($stateusmode == 0) {
	$testmode = 1;
	$submitmode = 0;
} elseif ($stateusmode == 1) {
	$testmode = 0;
} elseif ($stateusmode == 2) {
	$testmode = 0;
	$submitmode = 1;
	$submit_mess = '応募は締め切りました。';
}
?>
