<?php
/**
 * form_id=264（おやじバンド合戦 松阪の陣 応募）の確認画面表示
 * topics/message/oyaziband26.php の入力順・項目名に合わせる
 *
 * 注意:
 * - HTML 上は「応募曲①」「応募曲②」の見出し配下に同名ラベル（Youtube URL / 曲名）
 *   が並ぶため、確認画面では区別できるよう label_overrides で接頭辞を付けている。
 * - hidden（form_type / act / form_id / form_title）と同意系（savedata2 /
 *   privacy_consentx）、ページ見出しは display_order に含めない。
 */
return [
    'display_order' => [
        'u_radioname',
        'u_name',
        'u_age',
        'u_body',
        'x_fld1',
        'x_fld2',
        'x_fld3',
        'x_fld4',
        'r_message',
        'r_attached',
        'u_email',
        'u_zip',
        'u_address',
        'u_address2',
        'u_address3',
        'u_tel',
        'u_tel2',
    ],
    'label_overrides' => [
        'u_radioname' => 'バンド名',
        'u_name' => '代表者名',
        'u_age' => '代表者年齢',
        'u_body' => 'メンバー名',
        'x_fld1' => '応募曲① Youtube URL',
        'x_fld2' => '応募曲① 曲名',
        'x_fld3' => '応募曲② Youtube URL',
        'x_fld4' => '応募曲② 曲名',
        'r_message' => 'プロフィール',
        'r_attached' => '写真',
        'u_email' => 'メールアドレス',
        'u_zip' => '郵便番号',
        'u_address' => '都道府県・市町',
        'u_address2' => '番地',
        'u_address3' => 'マンション等',
        'u_tel' => '電話番号',
        'u_tel2' => '携帯電話番号',
    ],
    // ラジオ／セレクト項目は無いため value_maps は空
    'value_maps' => [],
];
