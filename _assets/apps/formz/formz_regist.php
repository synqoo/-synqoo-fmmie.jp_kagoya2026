<?php
$isConfirmStep = defined('FORMZ_CONFIRM_STEP');

// 確認画面生成の中間ステップでは重複送信判定を行わない。
// 戻る→未変更で再送信したケースを誤って「送信済み」と判定しないため。
if(!$isConfirmStep && isset($_SESSION['post_buf']) && $_SESSION['post_buf']==$_POST){
    $tit= urlencode((isset($row) && !empty($row['fm_title'])) ? $row['fm_title'] : (isset($_POST['form_title']) ? trim((string)$_POST['form_title']) : ''));
    $page = '/complete.php?s='.(isset($_POST['send_user']) ? $_POST['send_user'] : '').'&t='.$tit.'&r='.(isset($row) && isset($row['fm_mail']) ? $row['fm_mail'] : '').'&d='.$_POST['form_id'];
    header("HTTP/1.1 302 Moved Permanently");
	header("Location: ".$page);
	exit;
}

/**
 * フォーム登録処理
 * ファイルアップロードとデータ登録を行う
 */

// 定数定義（絶対パスのまま）
define('IMAGES_DIR', '/home/kir691871/public_html/backsite/_backsite/usr_img/2026');
define('THUMBNAIL_DIR', '/home/kir691871/public_html/backsite/_backsite/usr_img/2026/thumbnails');
define('THUMBNAIL_WIDTH', 320);
define('MAX_FILE_SIZE', 8388608);    // 8MB (8*1024*1024)

// 許可するMIMEタイプ
define('ALLOWED_IMAGE_TYPES', ['image/gif', 'image/jpeg', 'image/png']);
define('ALLOWED_VIDEO_TYPES', ['video/mp4']);

/**
 * ファイルアップロード処理（セキュリティ強化版）
 * 
 * @param array $file $_FILES配列の要素
 * @param bool $allowVideo 動画ファイルを許可するか（デフォルト: false）
 * @return string|false アップロード成功時はファイル名、失敗時はfalse
 */
function uploadFileSecure($file, $allowVideo = false) {
    // ファイルがアップロードされていない場合
    if (!isset($file['name']) || $file['name'] == '') {
        return false;
    }
    
    // GDライブラリの確認（画像処理に必要）
    if (!function_exists('imagecreatetruecolor')) {
        error_log("GD library is not installed");
        return false;
    }
    
    // アップロードエラーチェック
    if (!isset($file['error']) || $file['error'] != UPLOAD_ERR_OK) {
        error_log("Upload error: " . (isset($file['error']) ? $file['error'] : 'unknown'));
        return false;
    }
    
    // 一時ファイルの存在確認
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        error_log("Invalid upload file");
        return false;
    }
    
    // ファイルサイズチェック（8MB）
    $size = filesize($file['tmp_name']);
    if (!$size || $size > MAX_FILE_SIZE) {
        error_log("File size too large: " . $size);
        return false;
    }
    
    // ファイルタイプの検証（セキュリティ強化: finfo_openを使用）
    $imagesize = @getimagesize($file['tmp_name']);
    $mimeType = null;
    $ext = null;
    
    if ($imagesize !== false) {
        // 画像ファイルの場合
        $mimeType = $imagesize['mime'];
        
        // finfo_openで再検証（MIMEタイプ偽装対策）
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo === false) {
                error_log("finfo_open failed");
                return false;
            }
            $detectedMime = finfo_file($finfo, $file['tmp_name']);
            
            if ($detectedMime === false) {
                error_log("finfo_file failed to detect MIME type");
                return false;
            }
            // getimagesizeとfinfo_openの結果が一致するか確認
            if ($mimeType !== $detectedMime) {
                error_log("MIME type mismatch: getimagesize={$mimeType}, finfo={$detectedMime}");
                return false;
            }
        }
        
        // 許可された画像タイプか確認
        if (!in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
            error_log("Invalid image type: " . $mimeType);
            return false;
        }
        
        // 拡張子の決定
        switch ($mimeType) {
            case 'image/gif':
                $ext = '.gif';
                break;
            case 'image/jpeg':
                $ext = '.jpg';
                break;
            case 'image/png':
                $ext = '.png';
                break;
            default:
                error_log("Unsupported image type: " . $mimeType);
                return false;
        }
    } else {
        // 画像ファイルでない場合
        if (!$allowVideo) {
            error_log("Invalid file type: not an image and video not allowed");
            return false;
        }
        
        // 動画ファイルのMIMEタイプチェック
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = $finfo !== false ? finfo_file($finfo, $file['tmp_name']) : false;
        } else {
            // finfo_openが利用できない場合、拡張子から推測（非推奨だが互換性のため）
            $pathInfo = pathinfo($file['name']);
            $uploadedExt = strtolower('.' . ($pathInfo['extension'] ?? ''));
            if ($uploadedExt === '.mp4') {
                $mimeType = 'video/mp4';
            } else {
                error_log("Cannot determine MIME type for video");
                return false;
            }
        }
        
        if (!in_array($mimeType, ALLOWED_VIDEO_TYPES)) {
            error_log("Invalid video type: " . $mimeType);
            return false;
        }
        $ext = '.mp4';
    }
    
    // ディレクトリの存在確認と作成
    if (!is_dir(IMAGES_DIR)) {
        if (!mkdir(IMAGES_DIR, 0755, true)) {
            error_log("Failed to create directory: " . IMAGES_DIR);
            return false;
        }
    }
    
    // 安全なファイル名の生成（予測困難にするためrandom_bytesを使用）
    $randomBytes = random_bytes(16);
    $imageFileName = bin2hex($randomBytes) . $ext;
    $imageFilePath = IMAGES_DIR . '/' . $imageFileName;
    
    // ファイル名の衝突チェック（念のため）
    $counter = 0;
    while (file_exists($imageFilePath) && $counter < 10) {
        $randomBytes = random_bytes(16);
        $imageFileName = bin2hex($randomBytes) . $ext;
        $imageFilePath = IMAGES_DIR . '/' . $imageFileName;
        $counter++;
    }
    
    if ($counter >= 10) {
        error_log("Failed to generate unique filename");
        return false;
    }
    
    // ファイルの移動
    if (!move_uploaded_file($file['tmp_name'], $imageFilePath)) {
        error_log("Failed to move uploaded file");
        return false;
    }
    
    return $imageFileName;
}

if((!isset($_SESSION['reg']) || $_SESSION['reg']==0) && (!isset($_SESSION['post_buf']) || $_SESSION['post_buf']!=$_POST)){
    $_SESSION['post_buf']=$_POST;
    
    // 1つ目のファイルアップロード（画像・動画対応）
    if (isset($_FILES['r_attached']['name']) && $_FILES['r_attached']['name'] != '') {
        $uploadedFileName = uploadFileSecure($_FILES['r_attached'], true); // 動画も許可
        if ($uploadedFileName === false) {
            http_response_code(400);
            die('ファイルのアップロードに失敗しました。ファイル形式とサイズ（8MB以下）をご確認ください。');
        }
        $_POST['r_attached'] = $uploadedFileName;
    }

    // 2020/07/18 追加: 2つ目のファイルアップロード（画像のみ）
    if (isset($_FILES['r_attached2']['name']) && $_FILES['r_attached2']['name'] != '') {
        $uploadedFileName = uploadFileSecure($_FILES['r_attached2'], false); // 画像のみ
        if ($uploadedFileName === false) {
            http_response_code(400);
            die('2つ目のファイルのアップロードに失敗しました。ファイル形式とサイズ（8MB以下）をご確認ください。');
        }
        $_POST['a_memo'] = $uploadedFileName;
    }
}
// 確認画面表示モードの場合はここで終了
if (defined('FORMZ_CONFIRM_STEP')) {
    return;
}
// フォーム名: 呼び出し元の $row['fm_title'] が無い場合は POST の form_title を使用（complete.php の表示用）
$fm_title_value = '';
if (isset($row) && !empty($row['fm_title'])) {
    $fm_title_value = $row['fm_title'];
} elseif (isset($_POST['form_title']) && trim((string)$_POST['form_title']) !== '') {
    $fm_title_value = trim((string)$_POST['form_title']);
}
$_POST['fm_title'] = $fm_title_value;
$_POST['msg_body'] = isset($msg_body) ? $msg_body : '';
$_POST['u_agent'] = $_SERVER['HTTP_USER_AGENT'];
$_POST['u_ip'] = $_SERVER["REMOTE_ADDR"];
if($_POST['form_id']==28){
    awsapi_formz_regist($_POST);
}else{
    aws_formz_regist($_POST);
}

// if($_POST['form_id']==28 or $kinkyuformz == 1){
//     include '/home/kir691871/public_html/fmmie.jp/_app/formz_regist_kagoya.php';
// }

    $tit= urlencode($fm_title_value);
    $page = '/complete.php?s='.(isset($_POST['send_user']) ? $_POST['send_user'] : '').'&t='.$tit.'&r='.(isset($row) && isset($row['fm_mail']) ? $row['fm_mail'] : '').'&d='.$_POST['form_id'];

	$_SESSION['reg']=1;
	$_SESSION['bufmail'] = $_POST['u_email'];
	header("HTTP/1.1 302 Moved Permanently");
	header("Location: ".$page);
	exit;

?>
