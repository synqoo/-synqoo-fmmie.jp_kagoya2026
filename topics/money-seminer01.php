<?php
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
//error_reporting(0);
session_start();
$_SESSION['reg']=0;
$error=array();
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');
saveinput($_POST);
$fm_id=262;
// 確認画面の表示制御: 1=確認画面を表示, 0=確認画面をスキップしてregist.phpに直接送信
$confirm=1;
// 任意入力フィールドの折りたたみ機能のON/OFF制御　true: 折りたたみ機能を有効化、false: 常に表示
$enable_optional_fields_toggle = 0;

formz_config($fm_id);
if($_POST['act']==1){
    // 確認画面から「送信」された場合はバリデーションをスキップして登録処理へ
    if (!empty($_POST['formz_do_regist'])) {
        require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_regist.php');
        exit;
    }
    require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_validate.php');
    if (!is_array($error)){
        if ($confirm == 0) {
            // 確認画面をスキップして直接登録
            require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_regist.php');
            exit;
        }
        define('FORMZ_CONFIRM_STEP', true);
        require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_regist.php');
        require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/formz_confirm.php');
        exit;
    }else{
        $_SESSION['reg']=0;
        if(is_array($error)){$enable_optional_fields_toggle = false;
        $_POST['privacy_consent']==0;}
    }
}
?>

<!DOCTYPE html>
<html lang="ja" itemscope itemtype="http://schema.org/Blog">
  <head>
    <meta charset="UTF-8">
    
    <title>今さら聞けない オカネ初心者のためのやさしい勉強会 ～お金と仲良くなるコツ～ - 特番・イベント - レディオキューブFM三重</title>
    <link rel="canonical" href="https://fmmie.jp/topics/">
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <!--Include module="HTMLヘッダー -->
<!-- Open Graph Protocol -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="特番・イベント">
    <meta property="og:url" content="https://fmmie.jp/topics/">
    
    <meta property="og:site_name" content="特番・イベント">
    <meta property="og:image" content="/mt7/mt-static/support/theme_static/rainier/img/siteicon-sample.png">
    <!-- Microdata -->
    
    <meta itemprop="name" content="特番・イベント">

   <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam; ?>" />
   <link rel="stylesheet" href="/topics/styles.css<?php echo $themeParam; ?>" />
   <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</head>
  <body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
<main class="section">
      <div class="index-container stack">
        <section class="stack">
<article class="entry-card stack card-color container stack-lg" role="main">
    <h2 class="entry-title" itemprop="name">今さら聞けない オカネ初心者のためのやさしい勉強会 ～お金と仲良くなるコツ～　申し込み</h2>
<?php echo $error['top'] ?>

    <div class="stack stack-md"  <?php if($submitmode==1){echo 'style="display:none;"';}?>>
        <p class="text-muted"><span class="vad">必須</span> 印は入力必須項目です。 </p>
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <div id="formz_input">
        <h5 class="optional-fields-heading"><i class="fa fa-pencil" aria-hidden="true"></i>応募フォーム</h5>
            <div class="form-field">
                <label class="form-field__label">参加希望時間<span class="vad">必須</span></label>
                <div class="cluster cluster-gap-md">
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="x_bt" value="0" <?php if($_POST['x_bt']==0){echo 'checked="checked"';}?> required="required" />
                        <span>6月27日(土)10:30～</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="x_bt" value="1" <?php if($_POST['x_bt']==1){echo 'checked="checked"';}?> required="required" />
                        <span>6月27日(土)14:30～</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="x_bt" value="2" <?php if($_POST['x_bt']==2){echo 'checked="checked"';}?> required="required" />
                        <span>6月27日(土)午前・午後どちらでもOK</span>
                    </label>
                </div>
                <?php if (!empty($error['x_bt'])): ?>
                    <p class="form-field__error"><?php echo $error['x_bt'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_name">お名前 <span class="vad">必須</span></label>
                <input id="u_name" name="u_name" type="text" value="<?php echo $_POST['u_name'] ?>" required="required" />
                <?php if (!empty($error['u_name'])): ?>
                    <p class="form-field__error"><?php echo $error['u_name'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_kana">フリガナ<span class="vad">必須</span></label>
                <input id="u_kana" name="u_kana" type="text" value="<?php echo $_POST['u_kana'] ?>" required="required" />
                <?php if (!empty($error['u_kana'])): ?>
                    <p class="form-field__error"><?php echo $error['u_kana'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_age">年齢<span class="vad">必須</span></label>
                <div class="cluster cluster-gap-xs">
                    <input id="u_age" name="u_age" type="number" class="input-narrow" value="<?php echo $_POST['u_age'] ?>" required="required" /><span>歳</span>
                </div>
                <?php if (!empty($error['u_age'])): ?>
                    <p class="form-field__error"><?php echo $error['u_age'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="x_fld1">職業<span class="vad">必須</span></label>
                <input id="x_fld1" name="x_fld1" type="text" value="<?php echo $_POST['x_fld1'] ?>" required="required" />
                <?php if (!empty($error['x_fld1'])): ?>
                    <p class="form-field__error"><?php echo $error['x_fld1'] ?></p>
                <?php endif; ?>
            </div>
            <hr />
            <div class="form-field">
                <label class="form-field__label" for="u_address">都道府県・市町<span class="vad">必須</span></label>
                <input id="u_address" name="u_address" type="text" value="<?php echo $_POST['u_address'] ?>" required="required" />
                <?php if (!empty($error['u_address'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_address2">番地<span class="vad">必須</span></label>
                <input id="u_address2" name="u_address2" type="text" value="<?php echo $_POST['u_address2'] ?>" required="required" />
                <?php if (!empty($error['u_address2'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address2'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_address3">マンション等</label>
                <input id="u_address3" name="u_address3" type="text" value="<?php echo $_POST['u_address3'] ?>"  />
                <?php if (!empty($error['u_address3'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address3'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_tel">電話番号<span class="vad">必須</span></label>
                <input id="u_tel" name="u_tel" type="tel" value="<?php echo $_POST['u_tel'] ?>" required="required" />
                <?php if (!empty($error['u_tel'])): ?>
                    <p class="form-field__error"><?php echo $error['u_tel'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_email">メールアドレス<span class="vad">必須</span></label>
                <input id="u_email" name="u_email" type="email" value="<?php echo $_POST['u_email'] ?>" required="required" />
                <?php if (!empty($error['u_email'])): ?>
                    <p class="form-field__error"><?php echo $error['u_email'] ?></p>
                <?php endif; ?>
            </div>
            <hr />
            <div class="form-field">
                <label class="form-field__label" for="x_sel">複数名での参加</label>
                <select id="x_sel" name="x_sel" required="required">
                    <option <?php if($_POST['x_sel'] == 0){echo 'selected="selected"';} ?> value="0">無し</option>
                    <option <?php if($_POST['x_sel'] == 1){echo 'selected="selected"';} ?> value="1">有り</option>
                </select>
                <?php if (!empty($error['x_sel'])): ?>
                    <p class="form-field__error"><?php echo $error['x_sel'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="p_name1">お連れ様の名前</label>
                <input id="p_name1" name="p_name1" type="text" value="<?php echo $_POST['p_name1'] ?>" required="required" />
                <?php if (!empty($error['p_name1'])): ?>
                    <p class="form-field__error"><?php echo $error['p_name1'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="p_age1">お連れ様の年齢</label>
                <div class="cluster cluster-gap-xs">
                    <input id="p_age1" name="p_age1" type="number" class="input-narrow" value="<?php echo $_POST['p_age1'] ?>" required="required" /><span>歳</span>
                </div>
                <?php if (!empty($error['p_age1'])): ?>
                    <p class="form-field__error"><?php echo $error['p_age1'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="p_con1">お連れ様の職業</label>
                <input id="p_con1" name="p_con1" type="text" value="<?php echo $_POST['p_con1'] ?>" required="required" />
                <?php if (!empty($error['p_con1'])): ?>
                    <p class="form-field__error"><?php echo $error['p_con1'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="x_sel">お連れ様とのご関係</label>
                <select id="x_sel" name="x_sel" required="required">
                    <option <?php if($_POST['x_sel'] == 0){echo 'selected="selected"';} ?> value="0">家族・パートナー</option>
                    <option <?php if($_POST['x_sel'] == 1){echo 'selected="selected"';} ?> value="1">ご友人</option>
                    <option <?php if($_POST['x_sel'] == 2){echo 'selected="selected"';} ?> value="2">その他</option>
                </select>
                <?php if (!empty($error['x_sel'])): ?>
                    <p class="form-field__error"><?php echo $error['x_sel'] ?></p>
                <?php endif; ?>
            </div>
            <hr />
            <div class="form-field">
                <label class="form-field__label" for="x_fld2">どこでこのイベントをお知りになりましたか？</label>
                <input id="x_fld2" name="x_fld2" type="text" value="<?php echo $_POST['x_fld2'] ?>" required="required" placeholder="FM三重のCMやホームページ、その他等詳しくお書きください" />
                <?php if (!empty($error['x_fld2'])): ?>
                    <p class="form-field__error"><?php echo $error['x_fld2'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="r_message">本セミナーへの参加理由、お金についての疑問や質問など、自由にご記入ください。</label>
                <textarea id="r_message" name="r_message" rows="10" ><?php echo $_POST['r_message'] ?></textarea>
                <?php if (!empty($error['r_message'])): ?>
                    <p class="form-field__error"><?php echo $error['r_message'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_body">司会の多田えりかに対する質問やメッセージを、自由にご記入ください。</label>
                <textarea id="u_body" name="u_body" rows="10" ><?php echo $_POST['u_body'] ?></textarea>
                <?php if (!empty($error['u_body'])): ?>
                    <p class="form-field__error"><?php echo $error['u_body'] ?></p>
                <?php endif; ?>
            </div>
            <?php if ($enable_optional_fields_toggle): ?>
            </div><!-- /#optional-fields-container -->
            <?php endif; ?>
            <hr />
            
            <div class="form-field">
                <label class="cluster cluster-gap-xs">
                    <input type="checkbox" name="savedata2" id="savedata2" value="1" <?php if($_POST['savedata2']==1){echo 'checked="checked"';} ?> />
                    <span>次回以降の入力を簡略化するため、お名前などの入力項目をブラウザに保存する。</span>
                </label>
            </div>
            
            <div class="form-field" id="privacy-consent-field">
                <p>▶ 当サイト内で入力された個人情報は、本件の対応のためにのみ利用します。詳しくは<a href="/profiles/privacypolicy.php" target="_blank">プライバシーポリシー</a>をご覧ください。<br />
                    
                <label class="cluster cluster-gap-xs">
                    <input type="checkbox" name="privacy_consentx" id="privacy_consentx" value="1" required="required" <?php if($_POST['privacy_consentx']==1){echo 'checked="checked"';} ?> />
                    <span>個人情報の取り扱いについて同意します<span class="vad">必須</span></span>
                </label>
                <?php if (!empty($error['privacy_consentx'])): ?>
                    <p class="form-field__error"><?php echo $error['privacy_consent'] ?></p>
                <?php endif; ?></p>
            </div>
            
            <!-- 既に同意済みの場合はhidden inputで送信 -->
            <!--<input type="hidden" name="privacy_consent" id="privacy_consent_hidden" value="1" />-->
            
            <input type="hidden" name="form_type" value="0" />
            <input type="hidden" name="act" value="1" />
            <input type="hidden" name="form_id" value="262" />
            <input type="hidden" name="form_title" value="今さら聞けない オカネ初心者のためのやさしい勉強会" />
            </div>
            
            <div class="form-actions">
                <?php if($submitmode==0){?>
                    <button class="formz-btn" name="submit" type="submit">送 信</button>
                <?php }else{ ?>
                    <span class="formz-submit-closed"><?= $submit_mess ?></span>
                <?php }?>
            </div>
        </form>
    </div>
    <span class="formz-submit-closed"><?= $submit_mess ?></span>
    
            </div>
        </article>
        </section>
      </div>
    </main>
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
    <?php if ($enable_optional_fields_toggle): ?>    
    <script src="/_assets/js/formz_optional_toggle.js"></script>
    <?php endif; ?>
  </body>
</html>