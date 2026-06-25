<?php
/**
 * フォームバリデーション処理
 * 入力データの検証とエラーチェックを行う
 */

// エラー配列の初期化
$error = null;

// フォームテンプレートの読み込み
viewformztemp();

// バリデーション設定ファイルの読み込み
// セキュリティ: タイムアウト設定とエラーハンドリングを追加
//$configUrl = 'https://backsite.pro/fmmie/storage/formzconfig/' . $fm_id . '_setbody.txt';
$configUrl = 'https://fmmie.backsite.pro/formzconfig/' . $fm_id . '_setbody.txt';
// コンテキスト設定（タイムアウト: 5秒）
$context = stream_context_create([
    'http' => [
        'timeout' => 5,
        'method' => 'GET'
    ]
]);

$fp = @file_get_contents($configUrl, false, $context);

// ファイル読み込み失敗時のエラーハンドリング
if ($fp === false) {
    error_log("Failed to load validation config: " . $configUrl);
    //$error['config'] = '<span class="error_mess">設定ファイルの読み込みに失敗しました。しばらくしてから再度お試しください。</span>';
    $validateListbuf = [];
} else {
    $validateListbuf = explode("\n", $fp);
}

// バリデーションリストの初期化
$validateList = [];
$validateListname = [];

// メッセージフィールドの特殊文字処理（バックスラッシュを全角に変換）
if (isset($_POST['r_message'])) {
    $_POST['r_message'] = str_replace('\\', '＼', $_POST['r_message']);
}

// バリデーション設定の解析
for ($i = 0; $i < count($validateListbuf); $i++) {
    // 改行コードの除去（戻り値を使用）
    $validateListbuf[$i] = str_replace(array("\r\n", "\r", "\n", "<br />"), '', $validateListbuf[$i]);
    
    // 空行のスキップ
    if (trim($validateListbuf[$i]) === '') {
        continue;
    }
    
    $dataarray = explode(",", $validateListbuf[$i]);
    
    // バリデーションが必要な項目（'v'フラグ）をリストに追加
    if (isset($dataarray[2]) && $dataarray[2] == 'v') {
        $validateList[] = $dataarray[0];
        $validateListname[] = isset($dataarray[1]) ? $dataarray[1] : '';
    }
}

// プレゼント選択時は必須項目を追加（パフォーマンス改善: ループ外で処理）
if (isset($_POST['x_prez']) && $_POST['x_prez'] != 0) {
    $requiredFields = [7, 8, 9, 10, 11, 12, 14, 16];
    foreach ($requiredFields as $fieldId) {
        if (!in_array($fieldId, $validateList)) {
            $validateList[] = $fieldId;
            $validateListname[] = '';
        }
    }
}

// ハニーポット（スパム対策）チェック
if (isset($_POST['bodymessage']) && $_POST['bodymessage'] != '') {
    http_response_code(403);
    die('Fields not allowed');
}

// 個人情報取り扱い同意（必須）
if (!isset($_POST['privacy_consentx']) || (string)$_POST['privacy_consentx'] !== '1') {
    $error['privacy_consentx'] = '個人情報の取り扱いについて同意してください。';
}

// デバッグ: $validateList を出力して終了
// header('Content-Type: text/html; charset=UTF-8');
// echo '<pre>' . htmlspecialchars(print_r($validateList, true)) . '</pre>';
// exit;

// ユーザーデータのバリデーション
for ($j = 0; $j < count($validateList); $j++) {
    $buf = $validateList[$j];
    
    // バリデーション項目名の取得
    if ($validateListname[$j] == '') {
        $v_title = isset($formztemp[$buf][1]) ? $formztemp[$buf][1] : '';
    } else {
        $v_title = $validateListname[$j];
    }
    
    // エラーメッセージのエスケープ（XSS対策）
    $v_title_escaped = htmlspecialchars($v_title, ENT_QUOTES, 'UTF-8');
    
    switch ($buf) {
        case '4': // 氏名
            $_POST['u_name'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_name'] ?? ''), "s"));
            if ($_POST['u_name'] == "") {
                $error['u_name'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            // 全角文字（日本語）チェック
            if (strlen($_POST['u_name']) == mb_strlen($_POST['u_name'])) {
                $error['u_name'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'は全角文字（日本語）で入力してください</span>';
            }
            break;
            
        case '5': // フリガナ
            $_POST['u_kana'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_kana'] ?? ''), "s"));
            if ($_POST['u_kana'] == "") {
                $error['u_kana'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
            
        case '6': // ラジオネーム
            $_POST['u_radioname'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_radioname'] ?? ''), "s"));
            if ($_POST['u_radioname'] == "") {
                $error['u_radioname'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
        
        case '700': // 性別
            if (!isset($_POST['u_sex']) || $_POST['u_sex'] == "") {
                $error['u_sex'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を選択してください</span>';
            }
            break;
            
        case '800': // 年齢
            $_POST['u_age'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_age'] ?? ''), 's,n', 'UTF8'));
            if ($_POST['u_age'] == "") {
                $error['u_age'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            } elseif (!preg_match("/^[0-9-]*$/", $_POST['u_age'])) {
                $error['u_age'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を正しく入力してください</span>';
            }
            break;
            
        case '9': // 郵便番号
            $_POST['u_zip'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_zip'] ?? ''), 's,n', 'UTF8'));
            $_POST['u_zip'] = str_replace(array("ー", "－"), '-', $_POST['u_zip']);
            
            // 7桁の数字をハイフン付きに変換
            if (strlen($_POST['u_zip']) == 7) {
                $_POST['u_zip'] = substr($_POST['u_zip'], 0, 3) . '-' . substr($_POST['u_zip'], 3, 4);
            }
            
            // モバイル以外の場合、形式チェック
            if (!isset($_POST['mob']) || $_POST['mob'] == 0) {
                if (!preg_match("/^\d{3}\-\d{4}$/", $_POST['u_zip'])) {
                    $error['u_zip'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を正しく入力してください</span>';
                }
            }
            
            if ($_POST['u_zip'] == "") {
                $error['u_zip'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
            
        case '11': // 住所1
            $_POST['u_address'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_address'] ?? ''), "s"));
            if ($_POST['u_address'] == "") {
                $error['u_address'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
            
        case '12': // 住所2
            $_POST['u_address2'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_address2'] ?? ''), "s"));
            if ($_POST['u_address2'] == "" && (!isset($_POST['mob']) || $_POST['mob'] == 0)) {
                $error['u_address2'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
            
        case '14': // 電話番号
            $_POST['u_tel'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_tel'] ?? ''), 's,n', 'UTF8'));
            $_POST['u_tel'] = str_replace(array("ー", "－"), '-', $_POST['u_tel']);
            
            if ($_POST['u_tel'] == "") {
                $error['u_tel'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            } elseif (!preg_match("/^[0-9-]*$/", $_POST['u_tel']) || strlen($_POST['u_tel']) < 10) {
                // 修正: or → || に変更、9文字以下 → 10文字未満に変更（より厳密な検証）
                $error['u_tel'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を正しく入力してください</span>';
            }
            break;
            
        case '15': // 電話番号2
            $_POST['u_tel2'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_tel2'] ?? ''), 's,n', 'UTF8'));
            $_POST['u_tel2'] = str_replace(array("ー", "－"), '-', $_POST['u_tel2']);
            
            if ($_POST['u_tel2'] == "") {
                $error['u_tel2'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            } elseif (!preg_match("/^[0-9-]*$/", $_POST['u_tel2'])) {
                $error['u_tel2'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を正しく入力してください</span>';
            }
            break;
            
        case '16': // メールアドレス
            $_POST['u_email'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_email'] ?? ''), 'r,n', 'UTF8'));
            $_POST['u_email'] = replaceText($_POST['u_email']);
            
            if ($_POST['u_email'] == "") {
                $error['u_email'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            } elseif (!filter_var($_POST['u_email'], FILTER_VALIDATE_EMAIL)) {
                // 修正: mailcheck関数からfilter_varに変更（より厳密な検証）
                $error['u_email'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を正しく入力してください</span>';
            }
            break;
            
        case '17': // プレゼント
            $_POST['u_present'] = trim(mb_convert_kana(gpc_stripslashes($_POST['u_present'] ?? ''), "s"));
            if ($_POST['u_present'] == "") {
                $error['u_present'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
        
        case '18': // アーティスト名
            $_POST['r_artist'] = trim(mb_convert_kana(gpc_stripslashes($_POST['r_artist'] ?? ''), "s"));
            if ($_POST['r_artist'] == "") {
                $error['r_artist'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
        
        case '19': // 曲名
            $_POST['r_songtitle'] = trim(mb_convert_kana(gpc_stripslashes($_POST['r_songtitle'] ?? ''), "s"));
            if ($_POST['r_songtitle'] == "") {
                $error['r_songtitle'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
            
        case '20': // メッセージ
            // メッセージは特殊文字処理済みのため、trimのみ
            if (!isset($_POST['r_message']) || $_POST['r_message'] == "") {
                $error['r_message'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
            
        case '23': // カスタムフィールド1
            $_POST['x_fld1'] = trim(mb_convert_kana(gpc_stripslashes($_POST['x_fld1'] ?? ''), "s"));
            if ($_POST['x_fld1'] == "") {
                $error['x_fld1'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
            
        case '30': // プレゼント応募者 氏名
            $_POST['p_name1'] = trim(mb_convert_kana(gpc_stripslashes($_POST['p_name1'] ?? ''), "s"));
            if ($_POST['p_name1'] == "") {
                $error['p_name1'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;

        case '31': // プレゼント応募者 フリガナ
            $_POST['p_kana1'] = trim(mb_convert_kana(gpc_stripslashes($_POST['p_kana1'] ?? ''), "s"));
            if ($_POST['p_kana1'] == "") {
                $error['p_kana1'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;

        case '32': // プレゼント応募者 年齢
            $_POST['p_age1'] = trim(mb_convert_kana(gpc_stripslashes($_POST['p_age1'] ?? ''), 's,n', 'UTF8'));
            if ($_POST['p_age1'] == "") {
                $error['p_age1'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            } elseif (!preg_match("/^[0-9-]*$/", $_POST['p_age1'])) {
                $error['p_age1'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を正しく入力してください</span>';
            }
            break;
            
        case '33': // プレゼント応募者 性別
            if (!isset($_POST['p_sex1']) || $_POST['p_sex1'] == "") {
                $error['p_sex1'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を選択してください</span>';
            }
            break;

        case '34': // プレゼント応募者 連絡先
            $_POST['p_con1'] = trim(mb_convert_kana(gpc_stripslashes($_POST['p_con1'] ?? ''), "s"));
            if ($_POST['p_con1'] == "") {
                $error['p_con1'] = '<span class="error_mess">↑ ' . $v_title_escaped . 'を入力してください</span>';
            }
            break;
            
        default:
            // その他の項目は処理なし
            break;
    }
}

// エラーがある場合、セッションに保存
if (is_array($error) && count($error) > 0) {
    $error['top'] = '<div class="form-field__error">！入力に誤りがあります。再度ご確認ください。</div>';
    $error['topmob'] = '<font color="#ff0000"><b>！入力に誤りがあります。再度ご確認ください。</b></font><br /><br />';
    $_SESSION['error'] = $error;
}

/**
 * 特殊文字を通常文字に置換する関数
 * メールアドレスなどで使用される特殊文字を変換
 * 
 * @param string $str 変換対象の文字列
 * @return string 変換後の文字列
 */
function replaceText($str) {
    // 注意: PHP 7.4以降ではmagic_quotesは削除されているため、stripslashesは不要
    // 旧バージョンとの互換性が必要な場合は、gpc_stripslashes関数を使用すること
    
    // 特殊文字の置換テーブル
    $arr = array(
        '①' => '(1)',
        '②' => '(2)',
        '③' => '(3)',
        '④' => '(4)',
        '⑤' => '(5)',
        '⑥' => '(6)',
        '⑦' => '(7)',
        '⑧' => '(8)',
        '⑨' => '(9)',
        '⑩' => '(10)',
        '㈱' => '(株)',
        '㈲' => '(有)',
        'Ⅰ' => '１',
        'Ⅱ' => '２',
        'Ⅲ' => '３',
        'Ⅳ' => '４',
        'Ⅴ' => '５',
        'Ⅵ' => '６',
        'Ⅶ' => '７',
        'Ⅷ' => '８',
        'Ⅸ' => '９',
        'Ⅹ' => '１０',
        '＠' => '@',
        '．' => '.',
        'ー' => '-'
    );
    
    return str_replace(array_keys($arr), array_values($arr), $str);
}

?>
