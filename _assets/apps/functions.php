<?php
/**
 * フォーム入力データをCookieに保存/復元する関数
 * 
 * @param array $post POSTデータの配列
 * @return void
 */
function saveinput($post) {
	// 元の動作を維持するため、$_POSTを上書き（注意: 推奨されない方法だが、後方互換性のため維持）
	$_POST = $post;
	
	// Cookieの設定値
	$cookieExpire = time() + 31536000; // 1年
	$cookiePath = '/';
	$cookieDomain = '.fmmie.jp';
	
	// 保存するフィールドの定義
	$fields = [
		'u_radioname',
		'u_name',
		'u_email',
		'u_sex',
		'u_age',
		'u_zip',
		'u_address',
		'u_address2',
		'u_address3',
		'u_tel',
		'privacy_consentx',
		'savedata2'
	];
	
	// データを保存する場合
	if (isset($_POST['savedata2']) && (int)$_POST['savedata2'] === 1) {
		foreach ($fields as $index => $field) {
			$value = isset($_POST[$field]) ? (string)$_POST[$field] : '';
			// Cookieに保存する前にエスケープ（改行文字などを削除）
			$value = str_replace(["\r", "\n"], '', $value);
			// Cookieの値として安全な形式に変換
			$value = rawurlencode($value);
			setcookie("savedata2[{$index}]", $value, $cookieExpire, $cookiePath, $cookieDomain, true, true);
		}
	}
	// データを削除する場合（act=1 かつ savedata2=1 でないとき＝チェック未選択時）
	elseif (isset($_POST['act']) && (int)$_POST['act'] === 1 && (!isset($_POST['savedata2']) || (int)$_POST['savedata2'] !== 1)) {
		foreach ($fields as $index => $field) {
			// Cookieを削除（有効期限を過去に設定）
			setcookie("savedata2[{$index}]", '', time() - 3600, $cookiePath, $cookieDomain, true, true);
		}
	}

	// Cookieからデータを復元する場合（actが1でない場合）
	// 確認画面から「戻る」で戻った場合は復元しない（POSTデータを保持）
	if ((!isset($_POST['act']) || (int)$_POST['act'] !== 1) && empty($_POST['formz_confirm_back'])) {
		if (isset($_COOKIE['savedata2']) && is_array($_COOKIE['savedata2'])) {
			$cookieData = $_COOKIE['savedata2'];
			foreach ($fields as $index => $field) {
				if (isset($cookieData[$index])) {
					// Cookieから取得した値をデコード
					$value = rawurldecode($cookieData[$index]);
					// 元の動作を維持するため、$_POSTに直接設定（使用時は適切にエスケープすること）
					$_POST[$field] = $value;
				}
			}
		}
	}
}

function synqoomail($maildata){
	$body  = mb_convert_kana($maildata['body'],'UTF8');
	$headerz = "MIME-Version: 1.0\r\n"
	."Content-Transfer-Encoding: 7bit\r\n"
	."Content-Type: text/plain; charset=ISO-2022-JP\r\n"
	."Message-Id: <" . md5(uniqid(microtime())) . "@fmmie.jp>\r\n"
	."From: fmMIE <noreply@fmmie.jp>\r\n";
	$params = "-f ".'noreply@fmmie.jp';
	mb_internal_encoding("SJIS");
	
	$maildata['subject']  = mb_convert_encoding($maildata['subject'],'SJIS','auto');
	$body  = mb_convert_encoding($body,'SJIS','auto');
	mb_language('japanese');
	//mb_send_mail($maildata['to'],$maildata['subject'],$body, 'From: '.$maildata['fromname'].'<'.$maildata['from'].'>',$params);
	mb_send_mail($maildata['to'],$maildata['subject'],$body, mb_encode_mimeheader($headerz),$params);
	//mb_send_mail('dev@synqoo.com',$maildata['subject'],$body, 'From: '.$maildata['fromname'].'<'.$maildata['from'].'>',$params);
	echo ($maildata['to'].'-'.$maildata['subject'].'-'.$body.'-'. 'From: '.$maildata['from'].'-'.$params);
	mb_internal_encoding("UTF-8");
}

/*
function synqoomail2($maildata){
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $to_name = $maildata['toname'];
        $to_addr = $maildata['to'];
        $to_name_enc = mb_encode_mimeheader($to_name,"ISO-2022-JP");
        $to = "$to_name_enc<$to_addr>";
        // 送信元情報をエンコード
        $from_name = $maildata['fromname'];
        $from_addr = $maildata['from'];
        $from_name_enc = mb_encode_mimeheader($from_name, "ISO-2022-JP");
        $from = "$from_name_enc<$from_addr>";
        // メールヘッダを作成
        $header  = "From: $from\n";
        $header .= "Reply-To: $from";
        // 件名や本文をセット(ここは自動的にエンコードされる)
        $subject = $maildata['subject'];
        $body  = mb_convert_kana($maildata['body'],'UTF8');
        $res = mb_send_mail($to, $subject, $body, $header);
        return $res;
}*/

// function connectKami_old(){
// 	if (!$con=mysql_connect('o4043-462.kagoya.net','kir691871','2d791a8032876e7e')){$ecode = 4;}
// 	mysql_query('set names utf8');
// 	if (!$rom=mysql_select_db("fmmie_backsite",$con)){$ecode = 5;}
// 	if ($ecode <> 0){
//     	echo('dbng'.$ecode);
// 		exit;
// 	}
// }

function connectKami(){
	global $mysqli,$baseurl;
	if(!$mysqli = new mysqli('o4043-462.kagoya.net','kir691871','2d791a8032876e7e','fmmie_backsite')){$ecode=3;}
	$result = $mysqli->query('set names utf8mb4');
	if ($ecode <> 0){
    	header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".$baseurl."/?ecode=".$ecode);
		exit;
	}
}

// function connectAws(){
//     if (!$con=mysql_connect('backsitebase-1.chj4gxkh4puq.ap-northeast-1.rds.amazonaws.com','fmmie_admin','ABoh0W4avGuNbxBw')){$ecode = 4;}
//     mysql_query('set names utf8');
//     if (!$rom=mysql_select_db("backsite_fmmie",$con)){$ecode = 6;}
//     if ($ecode <> 0){
//         echo('dbngAWS'.$ecode);
//         exit;
//     }
// }

function mailcheck($email){
	$email = trim(mb_convert_kana(gpc_stripslashes($email), 's,n','UTF8'));
	$chkst = explode('@',$email);
	$chked = explode('.',$chkst[1]);
	if (count($chkst) == 2 and count($chked) >= 2){
		return true;
	}else{
		return false;
	}
}
function gpc_stripslashes($st) {
 	// if (get_magic_quotes_gpc()==1) { 
 	// 	return stripslashes($st); 
 	// } else { 
 		return $st; 
 	} 


/**
 * formin 層 A 設定ファイルのローカル保存先（kinkyuformz=1 時）。
 * .htaccess で HTTP 直リンク拒否のため file_get_contents(URL) 不可。
 *
 * @return string
 */
function formz_config_local_dir()
{
	return rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formzconfig';
}

/**
 * 通常時（kinkyuformz=0）の AWS formzconfig 公開 URL ベース（Laravel /formzconfig/ ルート）
 *
 * @return string
 */
function formz_config_remote_base()
{
	return 'https://fmmie.backsite.pro/formzconfig/';
}

/**
 * formin 緊急モードフラグ（mode.php → formin_set_mode_manual が書き込む）
 *
 * @return string
 */
function formz_kinkyuformz_flag_path()
{
	return formz_config_local_dir() . '/.kinkyuformz';
}

/**
 * 緊急モードフラグを読む。未存在・読取不可時は 0（通常モード）。
 *
 * @return int
 */
function formz_read_kinkyuformz()
{
	$path = formz_kinkyuformz_flag_path();
	if (! is_file($path) || ! is_readable($path)) {
		return 0;
	}

	$value = file_get_contents($path);
	if ($value === false) {
		return 0;
	}

	return trim($value) === '1' ? 1 : 0;
}

/**
 * @param int|string $fm_id
 * @param string     $suffix  config.txt / setbody.txt / prez.txt / formdef.json 等
 * @return string|false
 */
function formz_load_config_file($fm_id, $suffix)
{
	global $kinkyuformz;

	$fm_id = (int) $fm_id;
	if ($fm_id <= 0) {
		return false;
	}

	$filename = $fm_id . '_' . $suffix;

	if ($kinkyuformz == 1) {
		$path = formz_config_local_dir() . '/' . $filename;
		if (! is_file($path) || ! is_readable($path)) {
			error_log('Failed to load formz config (local): ' . $path);

			return false;
		}
		$content = file_get_contents($path);

		return $content === false ? false : $content;
	}

	$url = formz_config_remote_base() . $filename;
	$context = stream_context_create([
		'http' => [
			'timeout' => 5,
			'method' => 'GET',
		],
		'ssl' => [
			'verify_peer' => false,
			'verify_peer_name' => false,
		],
	]);
	$content = @file_get_contents($url, false, $context);
	if ($content === false) {
		error_log('Failed to load formz config (remote): ' . $url);
	}

	return $content;
}

/**
 * レガシー formzconfig URL（backsite.pro 公開ストレージ。confirm 等のフォールバック用）
 *
 * @return string
 */
function formz_config_legacy_remote_base()
{
	return 'https://backsite.pro/fmmie/storage/formzconfig/';
}

/**
 * formz_load_config_file に加え、kinkyuformz=0 時のみレガシー URL へフォールバック。
 *
 * @param int|string  $fm_id
 * @param string      $suffix  config.txt / setbody.txt / prez.txt / formdef.json 等
 * @param string|null $sourceLabel  debug 用取得元（remote / local / legacy / none）
 * @return string|false
 */
function formz_load_config_file_with_fallback($fm_id, $suffix, &$sourceLabel = null)
{
	global $kinkyuformz;

	$content = formz_load_config_file($fm_id, $suffix);
	if ($content !== false && trim($content) !== '') {
		if ($sourceLabel !== null) {
			$sourceLabel = ($kinkyuformz == 1) ? 'local' : 'remote';
		}

		return $content;
	}

	if ($kinkyuformz == 1) {
		if ($sourceLabel !== null) {
			$sourceLabel = 'none';
		}

		return false;
	}

	$url = formz_config_legacy_remote_base() . (int) $fm_id . '_' . $suffix;
	$context = stream_context_create([
		'http' => [
			'timeout' => 5,
			'method' => 'GET',
		],
		'ssl' => [
			'verify_peer' => false,
			'verify_peer_name' => false,
		],
	]);
	$content = @file_get_contents($url, false, $context);
	if ($content !== false && trim($content) !== '') {
		if ($sourceLabel !== null) {
			$sourceLabel = 'legacy';
		}

		return $content;
	}

	error_log('Failed to load formz config (legacy fallback): ' . $url);
	if ($sourceLabel !== null) {
		$sourceLabel = 'none';
	}

	return false;
}

/**
 * formdef.json を配列で取得（formz_load_config_file_with_fallback 経由）
 *
 * @param int|string  $fm_id
 * @param string|null $sourceLabel
 * @return array|null
 */
function formz_load_config_formdef($fm_id, &$sourceLabel = null)
{
	$raw = formz_load_config_file_with_fallback($fm_id, 'formdef.json', $sourceLabel);
	if ($raw === false) {
		return null;
	}

	$decoded = json_decode($raw, true);
	if (! is_array($decoded)) {
		error_log('Failed to decode formdef.json for form_id=' . (int) $fm_id);
		if ($sourceLabel !== null) {
			$sourceLabel = 'none';
		}

		return null;
	}

	return $decoded;
}

function formz_config($fm_id){
	global $stateusmode,$testmode,$submitmode,$submit_mess,$faxactive,$prezcsv,$kinkyuformz;
	
	// formin mode.php が formzconfig/.kinkyuformz に書込（emergency=1 / normal=0）
	$kinkyuformz = formz_read_kinkyuformz();
	
	// 設定ファイルの読み込み
	$fp = formz_load_config_file($fm_id, 'config.txt');
	
	// ファイル読み込み失敗時のエラーハンドリング
	if ($fp === false) {
		error_log('Failed to load formz config for form_id=' . (int) $fm_id);
		// デフォルト値を設定
		$stateusmode = 0;
		$testmode = 1;
		$submitmode = 0;
		$opendate = '0000-00-00 00:00:00';
		$closedate = '0000-00-00 00:00:00';
		$faxactive = 0;
	} else {
		$conf_array = explode(";", $fp);
		$stateusmode = isset($conf_array[0]) ? (int)$conf_array[0] : 0;
		$opendate = isset($conf_array[1]) ? trim($conf_array[1]) : '0000-00-00 00:00:00';
		$closedate = isset($conf_array[2]) ? trim($conf_array[2]) : '0000-00-00 00:00:00';
		$faxactive = isset($conf_array[3]) ? (int)$conf_array[3] : 0;
	}
	
	$now = date('Y-m-d H:i:s');
	
	// 開始日のチェック
	if($opendate != '0000-00-00 00:00:00' && $stateusmode == 1){
		$timestamp1 = strtotime($opendate);
		$timestamp2 = strtotime($now);
		if($timestamp1 !== false && $timestamp2 !== false && ($timestamp2 - $timestamp1) < 0){
			$submitmode = 1;
			$submit_mess = "募集開始までしばらくお待ちください。";
		}else{
			$submitmode = 0;
		}
	}
	
	// 締切日のチェック
	if($closedate != '0000-00-00 00:00:00' && $stateusmode == 1 && $submitmode == 0){
		$timestamp1 = strtotime($closedate);
		$timestamp2 = strtotime($now);
		if($timestamp1 !== false && $timestamp2 !== false && ($timestamp2 - $timestamp1) > 0){
			$submitmode = 1;
			$submit_mess = "応募は締め切りました。";
		}else{
			$submitmode = 0;
		}
	}
	
	// ステータスモードによる設定
	if($stateusmode == 0){
		$testmode = 1;
		$submitmode = 0;
	}elseif($stateusmode == 1){
		$testmode = 0;
	}elseif($stateusmode == 2){
		$testmode = 0;
		$submitmode = 1;
		$submit_mess = "応募は締め切りました。";
	}
	
	// プレゼント設定の読み込み
	$prezContent = formz_load_config_file($fm_id, 'prez.txt');
	
	if($prezContent !== false){
		$prezcsv = array();
		$lines = explode("\n", $prezContent);
		foreach($lines as $line){
			$data = trim($line);
			if($data != ''){
				$prezcsv[] = $data;
			}
		}
	}
}

function prezsource(){
	global $prezcsv,$prmother,$pr;
	if(count($prezcsv) <=1){
	}else{
		$prezsource = '<h5 class="optional-fields-heading prezh5">プレゼント</h5>';
		$prezsource .= '<p>';
		$linecount = count($prezcsv);
		$pr = explode(';',$prezcsv[0]);
		$prtype = $pr[0];
		$prezcount = 0;
		$label ='';//2021/10/03added
		$prmother = $pr[1];

		$now=date('Y-m-d H:i:s');
		// prtype=2（複数選択式）は商品ごとに日付判定。1行目 prmother による全体ゲートは使わない
		// （新 formz の「2;{setid}」出力で、setid 商品の日付だけが他商品を巻き込んで非表示になるのを防ぐ）
		if($prtype <= 1 || $prtype >= 3){
		for($i=1;$i<$linecount;$i++){
			if($prezcsv[$i]!=''){
				$line = explode(';',$prezcsv[$i]);
				if($line[1]==$prmother){
					$opendate = $line[3];
					$closedate = $line[4];
					$timestamp1 = strtotime($opendate);
					$timestamp2 = strtotime($now);
					if($opendate!='0000-00-00 00:00:00'){
						if(($timestamp2 - $timestamp1) < 0){
							$prezmode=1;
							$submit_mess1="募集開始までしばらくお待ちください。";
							$submit_mess1="";
						}else{
							$prezmode=0;
						}
					}
					if($closedate!='0000-00-00 00:00:00'){
						$timestamp1 = strtotime($closedate);
					    $timestamp2 = strtotime($now);
						if(($timestamp2 - $timestamp1) > 0){
							//$prezmodeclose=1;
							$submit_mess2="応募は締め切りました。";
							$submit_mess2 = '';
						}else{
							$prezmodeclose=0;
						}
					}
				}
			}
		}
		}
		if($prtype<=2){
			for($i=1;$i<$linecount;$i++){
				if($prezcsv[$i]!=''){
					$line = explode(';',$prezcsv[$i]);
                    $opendate = $line[3];
                    $closedate = $line[4];
                    $timestamp1 = strtotime($opendate);
                    $timestamp2 = strtotime($now);
                    $timestamp3 = strtotime($closedate);
                    if($opendate!='0000-00-00 00:00:00' or $closedate!='0000-00-00 00:00:00'){
                        if(($timestamp2 - $timestamp1) > 0 and ($timestamp2 - $timestamp3) < 0){
        					$prezsource .= '<span class="formz-list-item"><input type="radio" name="x_prez"  id="x_prez'.$i.'" value="'.$line[1].'" ';
        					if ($_POST['x_prez'] ==intval($line[1]) or $linecount==2){$prezsource .= 'checked="checked"';}
        					$prezsource .= '/> <label for = "x_prez'.$i.'" class="formz-list-item-label">'.$line[0].'</label></span><br />';
                            $prezcount++;
                        }else{
                            $prezsource .= '';
                        }
                    }else{
                        $prezsource .= '<span class="formz-list-item"><input type="radio" name="x_prez"  id="x_prez'.$i.'" value="'.$line[1].'" ';
                        if ($_POST['x_prez'] ==intval($line[1]) or $linecount==2){$prezsource .= 'checked="checked"';}
                        $prezsource .= '/> <label for = "x_prez'.$i.'" class="formz-list-item-label">'.$line[0].'</label></span><br />';
                        $prezcount++;
                    }
			      }
			}
            if($prtype==1 or $prtype==2){
                $prezsource .= '<span class="formz-list-item"><input type="radio" name="x_prez"  id="x_prez30" value="0" ';
                if ($_POST['x_prez'] ==0){$prezsource .= 'checked="checked"';}
                $prezsource .= '/> <label for = "x_prez30" class="formz-list-item-label">希望しない</label></span>';
            }   
		}else{
			for($i=1;$i<$linecount;$i++){
				if($prezcsv[$i]!=''){
					$line = explode(';',$prezcsv[$i]);
					if($line[1]!=0){$label .= $line[0].' / ';}
					if($i==1 and $line[1]!=0){$prmother2 = $line[1];}
				}
			}
			$prezsource .= '<span class="formz-list-item"><input type="radio" name="x_prez"  id="x_prez'.$i.'" value="'.$prmother2.'" ';
			if(($_POST['x_prez'] ==intval($prmother)) or ($linecount==3)){$prezsource .= 'checked="checked"';} //20160303 dummy
			$prezsource .= '/> <label for = "x_prez'.$i.'" class="formz-list-item-label">'.$label.'</label></span><br />';
            $prezcount++;
			if($prtype==4){
				$prezsource .= '<span class="formz-list-item"><input type="radio" name="x_prez"  id="x_prez30" value="0" ';
				if ($_POST['x_prez'] ==0){$prezsource .= 'checked="checked"';}
				$prezsource .= '/> <label for = "x_prez30" class="formz-list-item-label">希望しない</label></span>';
			}	
		}
		$prezsource .= '</p>';
        
		if($prezmode==0 and $prezmodeclose ==0){
		    if($prezcount==0){$prezsource = '';}
			echo $prezsource;
		}elseif($prezmode==1 and $prezmodeclose==0){
			echo $submit_mess1;
		}elseif($prezmode==0 and $prezmodeclose==1){
			echo $submit_mess2;
		}
	}
    
}

function viewformztemp(){
	global $formztemp;
	$formztemp = array();
	
	// ファイルパスを動的に生成
	$file = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formztemp.csv';
	
	// ファイルが存在しない場合は代替パスを試す
	if (!file_exists($file)) {
		$file = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formztemp.csv';
	}
	
	// ファイルが存在しない場合はエラーを返す
	if (!file_exists($file)) {
		error_log("formztemp.csv not found: " . $file);
		return;
	}
	
	$fp = fopen($file, "r");
	if ($fp === false) {
		error_log("Failed to open formztemp.csv: " . $file);
		return;
	}
	
	$i = 0;
	$maxLines = 100; // 最大行数を制限
	
	while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
		$formztemp[] = $data;
		$i++;
		if ($i >= $maxLines) {
			break; // exitの代わりにbreakを使用
		}
	}
	
	fclose($fp);
}

function guestimage($number){
	$sc = '<ul class="guestimage">';
	$sc .= '</ul>';
}

function time_diff($time_from, $time_to){
    $dif = $time_to - $time_from;
    $dif_time = date("H:i:s", $dif);
    $dif_days = (strtotime(date("Y-m-d", $dif)) - strtotime("1970-01-01")) / 86400;
    //return "{$dif_days}日 {$dif_time}";
    return "{$dif_days}日";
}


function aws_formz_regist($POST){
    $url = 'https://backsite.pro/fmmie/formz/regist';
    $POST = http_build_query($POST, "", "&");
    //$options = array('http' => array('method' => 'POST','content' => $POST,));
	$options = array(
		'http' => array('method' => 'POST','content' => $POST),
		'ssl' => array('verify_peer'=> false,'verify_peer_name' => false)
	);
    $options = stream_context_create($options);
	$contents = file_get_contents($url, false, $options);
    return $contents;
}

// 新 formz（fmmie.backsite.pro）並行テスト用。本番切替後は aws_formz_regist をこちらに統合予定。
function aws_formz_regist_new($POST){
    $url = 'https://fmmie.backsite.pro/formz/regist';
    $POST = http_build_query($POST, "", "&");
	$options = array(
		'http' => array('method' => 'POST','content' => $POST),
		'ssl' => array('verify_peer'=> false,'verify_peer_name' => false)
	);
    $options = stream_context_create($options);
	$contents = file_get_contents($url, false, $options);
    return $contents;
}

function awsapi_formz_regist($POST){
    $url = 'https://b5lmch2ac3.execute-api.ap-northeast-1.amazonaws.com/formz';
    $POST = http_build_query($POST, "", "&");
    $options = array('http' => array('method' => 'POST','content' => $POST,));
    $options = stream_context_create($options);
	$contents = file_get_contents($url, false, $options);
    return $contents;
}




/**
 * プロフィールJSONからHTMLを生成
 * style 0: 縦長画像 → 2カラム（左: 画像＋pr、右: データテーブル）
 * style 1: 横長画像 → 1カラム（上: 画像、その下: pr、その下: データテーブル）
 * CSS: personalities/_temps/_temp_styles.css（公開時は /personalities/css/styles.css 等）
 *
 * @param string|object|array $profile_input JSON文字列、またはデコード済みのオブジェクト/配列。$profile_temp をそのまま渡しても可。
 */
function profile_fomating($profile_input){
    if (is_object($profile_input)) {
        $obj = $profile_input;
    } elseif (is_array($profile_input)) {
        $obj = json_decode(json_encode($profile_input));
        if ($obj === null) {
            return '<!-- プロフィールデータの読み込みに失敗しました -->';
        }
    } else {
        $profile_input = str_replace(array("\r\n","\r","\n"), '', (string) $profile_input);
        $obj = json_decode($profile_input);
        if ($obj === null || json_last_error() !== JSON_ERROR_NONE) {
            return '<!-- プロフィールデータの読み込みに失敗しました -->';
        }
    }
    
    $profile_job = isset($obj->{'job'}) ? $obj->{'job'} : [];
    $profile_data = isset($obj->{'data'}) ? $obj->{'data'} : [];
    $profile_photo = isset($obj->{'photo'}) ? $obj->{'photo'} : [];
    
    if(empty($profile_photo) || !isset($profile_photo[0]->{'img'})){
        return '<!-- プロフィール写真がありません -->';
    }
    
    $style = (isset($obj->{'style'}) && (string)$obj->{'style'} === '0') ? 0 : 1;
    $photo_img = '/personalities/profile_photos/' . h($profile_photo[0]->{'img'});
    $name = h($obj->{'name'} ?? '');
    $pr_html = strip_tags($obj->{'pr'} ?? '', '<br><br/><strong><em><b><i><u><a><p><span>');
    
    // データテーブル部分（共通）※ type を一番上に（temp_index.php と同じ .profiletag + proa/prob/proc）
    $type_val = $obj->{'type'} ?? '';
    $type_class = 'prob';
    if ($type_val === 'アナウンサー') $type_class = 'proa';
    elseif ($type_val === 'リポーター') $type_class = 'proc';
    elseif ($type_val === 'パーソナリティ') $type_class = 'prob';
    $data_table = '';
    $data_table .= '<div class="profile-data-row"><span class="profile-data-label"></span><span class="profile-data-value"><span class="profiletag ' . $type_class . '">' . h($type_val) . '</span></span></div>';
    $data_table .= '<div class="profile-data-row"><span class="profile-data-label">よみ</span><span class="profile-data-value">' . h($obj->{'kana'} ?? '') . '</span></div>';
    $data_table .= '<div class="profile-data-row"><span class="profile-data-label">名前</span><span class="profile-data-value profile-name">' . $name . '</span></div>';
    if(!empty($obj->{'nickname'})){
        $data_table .= '<div class="profile-data-row"><span class="profile-data-label">nickname</span><span class="profile-data-value">' . h($obj->{'nickname'}) . '</span></div>';
    }
    $data_table .= '<div class="profile-data-row"><span class="profile-data-label">生年月日・血液型</span><span class="profile-data-value">' . h($obj->{'birth'} ?? '') . '生まれ　' . h($obj->{'blood'} ?? '') . '</span></div>';
    $data_table .= '<div class="profile-data-row profile-sns"><span class="profile-data-label">SNS</span><span class="profile-data-value"><ul class="pro_sns">';
    if(!empty($obj->{'sns_twitter'})) $data_table .= '<li><a href="'.h($obj->{'sns_twitter'}).'" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a></li>';
    if(!empty($obj->{'sns_facebook'})) $data_table .= '<li><a href="'.h($obj->{'sns_facebook'}).'" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a></li>';
    if(!empty($obj->{'sns_instagram'})) $data_table .= '<li><a href="'.h($obj->{'sns_instagram'}).'" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a></li>';
    if(!empty($obj->{'sns_youtube'})) $data_table .= '<li><a href="'.h($obj->{'sns_youtube'}).'" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fa-brands fa-youtube" aria-hidden="true"></i></a></li>';
    if(!empty($obj->{'sns_tiktok'})) $data_table .= '<li><a href="'.h($obj->{'sns_tiktok'}).'" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><i class="fa-brands fa-tiktok" aria-hidden="true"></i></a></li>';
    $data_table .= '</ul></span></div>';
    $data_table .= '<div class="profile-data-row"><span class="profile-data-label">担当番組</span><span class="profile-data-value">';
    foreach($profile_job as $j){
        if(!empty($j->{'url'})) $data_table .= '<i class="fa fa-caret-right" aria-hidden="true"></i> <a href="'.h($j->{'url'}).'">'.h($j->{'title'} ?? '').'</a><br />';
        else $data_table .= '<i class="fa fa-caret-right" aria-hidden="true"></i> '.h($j->{'title'} ?? '').'<br />';
    }
    $data_table .= '</span></div>';
    foreach($profile_data as $d){
        $data_table .= '<div class="profile-data-row"><span class="profile-data-label">' . h($d->{'title'} ?? '') . '</span><span class="profile-data-value">' . strip_tags($d->{'body'} ?? '', '<br><br/><strong><em><b><i><u><a><p><span>') . '</span></div>';
    }
    
    if($style === 0){
        // 縦長: 2カラム 左=画像+pr、右=データテーブル
        $buf = '<section class="profilebox profile-style-0">';
        $buf .= '<div class="profile-main">';
        $buf .= '<div class="profile-photo-col">';
        $buf .= '<img src="'.$photo_img.'" alt="'.$name.'" class="profile-photo-img" />';
        $buf .= '<div class="profile-pr"><p><i class="fa fa-user-circle" aria-hidden="true"></i> '.$pr_html.'</p></div>';
        $buf .= '</div>';
        $buf .= '<div class="profile-data-col"><div class="profile-data-table">'.$data_table.'</div></div>';
        $buf .= '</div>';
    } else {
        // 横長: 1カラム 上=画像、その下=pr、その下=データテーブル
        $buf = '<section class="profilebox profile-style-1">';
        $buf .= '<div class="profile-photo-full"><img src="'.$photo_img.'" alt="'.$name.'" class="profile-photo-img" /></div>';
        $buf .= '<div class="profile-pr"><p><i class="fa fa-user-circle" aria-hidden="true"></i> '.$pr_html.'</p></div>';
        $buf .= '<div class="profile-data-col"><div class="profile-data-table">'.$data_table.'</div></div>';
    }
    
    for($i=1;$i<count($profile_photo);$i++){
        if(empty($profile_photo[$i]->{'img'})) continue;
        $tcom = isset($profile_photo[$i]->{'type'}) ? h($profile_photo[$i]->{'type'}) : '';
        $desc = isset($profile_photo[$i]->{'desc'}) ? h($profile_photo[$i]->{'desc'}) : '';
        $buf .= '<div class="profile-photo-extra"><img src="/personality/profile_photos/'.h($profile_photo[$i]->{'img'}).'" alt="'.$name.'" /><p><i class="fa fa-comment" aria-hidden="true"></i> '.$tcom.' '.$desc.'</p></div>';
    }
    $buf .= '</section>';
    return $buf;
}

/**
 * プログラムRDF JSONファイルを読み込む関数
 * 
 * @param string $filePath JSONファイルのパス
 * @return array|false 読み込んだデータの配列、失敗時はfalse
 */
function load_program_rdf($filePath = null) {
    if ($filePath === null) {
        $filePath = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/xml/_program_rdf.json';
    }
    
    // ファイルが存在しない場合はfalseを返す
    if (!file_exists($filePath)) {
        error_log("Program RDF file not found: " . $filePath);
        return false;
    }
    
    // JSONファイルを読み込む
    $jsonContent = @file_get_contents($filePath);
    if ($jsonContent === false) {
        error_log("Failed to read Program RDF file: " . $filePath);
        return false;
    }
    
    // JSONをデコード
    $data = json_decode($jsonContent, true);
    if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
        error_log("Failed to decode Program RDF JSON: " . json_last_error_msg());
        return false;
    }
    
    // program配列を返す
    if (isset($data['program']) && is_array($data['program'])) {
        return $data['program'];
    }
    
    return false;
}


function radiko_timefree($radiko_week,$radiko_time){
	// 引数の検証
	if(!is_array($radiko_week) || !is_array($radiko_time) || empty($radiko_time)){
		error_log("radiko_timefree: Invalid arguments. radiko_week and radiko_time must be arrays, and radiko_time must not be empty.");
		return;
	}
	
	//$weeks = explode(',', $w);//array(5);//$_GET['weeks']
	//$times = explode(',', $t);//array(1700);//$_GET['times']
	$nowfree = date("Y-m-d H:i:s");
	$nowtime = date("Hi");
	$nowweek = date('w');
	$playdays = array();
	$playurl = array();
	$playpast = array();
	
	// 放送時刻の最初の要素を取得（存在チェック済み）
	$radiko_time_first = isset($radiko_time[0]) ? (int)$radiko_time[0] : 0;
	
	for($i=0;$i<count($radiko_week);$i++){
		$s = $nowweek - $radiko_week[$i];
		if($radiko_time_first > $nowtime){
			if ($s<=0){$s = $s+7;}
		}else{
			if ($s<0){$s = $s+7;}
		}
		$playdays[] = $s;   // .= ではなく = を使用
	}
	sort($playdays);
	
	// $sm変数の処理（グローバル変数の可能性を考慮）
	global $sm;
	$sm = isset($sm) ? (int)$sm : 0;
	if($sm == 1){
		$u = "http://radiko.jp/share/?sid=FMMIE&t=";
	}else{
		$u = "http://radiko.jp/#!/ts/FMMIE/";
	}

	for($i=0;$i<count($playdays);$i++){
		$r = $playdays[$i] * -1;
		$timesx = sprintf('%04d', $radiko_time_first);
		$playurl[] = $u.date("Ymd",strtotime($r." day")).$timesx.'01'.'&noreload=1';  // .= ではなく = を使用
		$playpast[] = date("m月d日",strtotime($r." day"));  // .= ではなく = を使用
	}
	//print_r($playdays);print_r($playurl);echo '<br />';

	for($i=0;$i<count($playpast);$i++){
		echo '<!--<img src="/_include/img/tri.png" />--><a href="'.$playurl[$i].'" target="_blank"><i class="fa fa-volume-up" aria-hidden="true"></i> '.$playpast[$i].'放送分を聴く</a><br />';
	}
}
?>