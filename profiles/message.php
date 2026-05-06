<?php
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
//error_reporting(0);
session_start();
$_SESSION['reg']=0;
$error=array();
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');
saveinput($_POST);
$fm_id=5;
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

    // Invisible reCAPTCHA 検証（このフォーム固有）
    if (empty($_POST['g-recaptcha-response'])) {
        if (!is_array($error)) $error = [];
        $error['recaptcha'] = 'reCAPTCHA認証に失敗しました。もう一度お試しください。';
    } else {
        $recaptchaVerify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?' . http_build_query([
            'secret'   => RECAPTCHA_SECRET_KEY,
            'response' => $_POST['g-recaptcha-response'],
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        ]));
        $recaptchaResult = json_decode($recaptchaVerify, true);
        if (empty($recaptchaResult['success'])) {
            if (!is_array($error)) $error = [];
            $error['recaptcha'] = 'reCAPTCHA認証に失敗しました。もう一度お試しください。';
        }
    }

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
    
    <title>メッセージ - 会社概要 - レディオキューブFM三重</title>
    <link rel="canonical" href="https://fmmie.jp/profiles/">
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <!--Include module="HTMLヘッダー -->
<!-- Open Graph Protocol -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="会社概要">
    <meta property="og:url" content="https://fmmie.jp/profiles/">
    
    <meta property="og:site_name" content="会社概要">
    <meta property="og:image" content="/mt7/mt-static/support/theme_static/theme-from-synqoo2026/img/siteicon-sample.png">
    <!-- Microdata -->
    
    <meta itemprop="name" content="会社概要">

   <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam ?? ''; ?>" />
   <link rel="stylesheet" href="https://fmmie.jp/profiles/styles.css<?php echo $themeParam ?? ''; ?>" />
   <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
   <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
  <body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
<main class="section">
      <div class="index-container stack">
        <section class="stack">
            <!-- ページヘッダーカード --> 
      <div class="v0-card">
        <div class="v0-preview-card">
        <div class="v0-h1-wrap v0-h1-bracket">
          <?php echo file_get_contents(ASSETS_PATH . '/img/svg/h1-bracket.svg'); ?>
          <div class="v0-h1-textgroup">
            <span class="v0-h1-subtitle">COMPANY</span>
            <h1 class="v0-h1-title">会社案内</h1>
          </div>
          <div class="v0-h1-bracket-accent">
            <div class="v0-h1-bracket-accent-line"></div>
            <div class="v0-h1-bracket-accent-dot"></div>
          </div>
        </div>
      </div>
      <div class="com_head_side">
          <nav class="link-column" aria-label="会社・番組情報">
            <ul>
            <li><a href="/profiles/"> 会社概要</a></li>
            <li><a href="/profiles/info-rinen.php">企業理念・行動指針</a></li>
            <li><a href="/profiles/info-kizyun.php">番組放送基準</a></li>
            <li><a href="/profiles/shingikai/">番組審議会</a></li>
            <li class="break"></li> <!-- 改行用 -->
            <li><a href="/profiles/privacypolicy.php">個人情報保護方針</a></li>
            <li><a href="/profiles/security.php">情報セキュリティ</a></li>
                <li><a href="/profiles/CivilProtectionLaw.php">国民保護業務計画</a></li>
                <li><a href="/profiles/recruit/">採用情報</a></li>
            </ul>
          </nav>
        </div>
      </div>
<article class="card stack card-color container stack-lg" role="main">
    <h2 class="entry-title" itemprop="name">お問合せ・ご意見</h2>

<!-- formzstrap-->
    <div class="stack stack-md">
<div class="form_head">
		<p>レディオキューブに対する問い合わせ・ご意見・ご要望を賜り、ありがとうございます。<br />
内容につきましては、可能な限りお答え申し上げておりますが、数多くのメッセージを頂いております関係上、全てにはお答えいたしかねる場合、回答に時間を要する場合がございます。</p>

        <p>
        ◆放送した楽曲名については、<a href="https://noa.audee.jp/search/view/nu/">こちら「NOW ON AIR」</a>より、放送日時・番組名などから検索できます。<br />
        ◆番組内容に関するお問い合わせは、番組名や放送日時などを、楽曲に関するお問い合わせは、番組名や放送日時、洋楽か邦楽か、男性ボーカルか女性ボーカルか等、お分かりになる範囲で、出来る限り詳しく記入ください。<br />
        <!-- ◆「回答のご希望の有無」については、ご質問者の意向を確認させて頂くためのものであって、必ずしも具体的な回答を、お約束するものではありません。<br />
　「希望する」を選ばれても、お送りする回答は、ご意見を頂いた旨をご報告する内容に留まる場合があります。<br /> -->
        ◆お電話で回答させて頂く場合もございます。
        </p>
        <p align="right">レディオキューブ ＦＭ三重　編成広報担当</p></div>

     <div class="stack stack-md"  <?php if($submitmode==1){echo 'style="display:none;"';}?>>
        <p class="text-muted"><span class="vad">必須</span> 印は入力必須項目です。 </p>
        <form id="formz-main" class="form" action="" method="post" enctype="multipart/form-data">
            <div id="formz_input">
        
        <h5 class="optional-fields-heading"><i class="fa fa-pencil" aria-hidden="true"></i>お問い合わせ・ご意見・ご要望</h5>
            <div class="form-field">
                <label class="form-field__label" for="u_name">お名前 <span class="vad">必須</span></label>
                <input id="u_name" name="u_name" type="text" value="<?php echo $_POST['u_name'] ?>" required="required" />
                <?php if (!empty($error['u_name'])): ?>
                    <p class="form-field__error"><?php echo $error['u_name'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_kana">フリガナ</label>
                <input id="u_kana" name="u_kana" type="text" value="<?php echo $_POST['u_kana'] ?>"  />
                <?php if (!empty($error['u_kana'])): ?>
                    <p class="form-field__error"><?php echo $error['u_kana'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_email">メールアドレス<span class="vad">必須</span></label>
                <input id="u_email" name="u_email" type="email" value="<?php echo $_POST['u_email'] ?>" required="required" />
                <?php if (!empty($error['u_email'])): ?>
                    <p class="form-field__error"><?php echo $error['u_email'] ?></p>
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
                <label class="form-field__label" for="u_age">年齢<span class="vad">必須</span></label>
                <div class="cluster cluster-gap-xs">
                    <input id="u_age" name="u_age" type="number" class="input-narrow" value="<?php echo $_POST['u_age'] ?>" required="required" /><span>歳</span>
                </div>
                <?php if (!empty($error['u_age'])): ?>
                    <p class="form-field__error"><?php echo $error['u_age'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_body">お問い合わせ内容</label>
                <textarea id="u_body" name="u_body" rows="10" required="required"><?php echo $_POST['u_body'] ?></textarea>
                <?php if (!empty($error['u_body'])): ?>
                    <p class="form-field__error"><?php echo $error['u_body'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="x_fld1">放送日時</label>
                <input id="x_fld1" name="x_fld1" type="text" value="<?php echo $_POST['x_fld1'] ?>"  />
                <?php if (!empty($error['x_fld1'])): ?>
                    <p class="form-field__error"><?php echo $error['x_fld1'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="x_fld2">番組名</label>
                <input id="x_fld2" name="x_fld2" type="text" value="<?php echo $_POST['x_fld2'] ?>"  />
                <?php if (!empty($error['x_fld2'])): ?>
                    <p class="form-field__error"><?php echo $error['x_fld2'] ?></p>
                <?php endif; ?>
            </div>
        
        <h5 class="optional-fields-heading"><i class="fa fa-pencil" aria-hidden="true"></i>よろしければ以下もお書き添えください</h5>
            <div class="form-field">
                <label class="form-field__label">性別</label>
                <div class="cluster cluster-gap-md">
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="u_sex" value="女性" <?php if($_POST['u_sex']=='女性'){echo 'checked="checked"';}?> />
                        <span>女性</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="u_sex" value="男性" <?php if($_POST['u_sex']=='男性'){echo 'checked="checked"';}?> />
                        <span>男性</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="u_sex" value="無回答" <?php if($_POST['u_sex']=='無回答'){echo 'checked="checked"';}?> />
                        <span>無回答</span>
                    </label>
                </div>
                <?php if (!empty($error['u_sex'])): ?>
                    <p class="form-field__error"><?php echo $error['u_sex'] ?></p>
                <?php endif; ?>
            </div>
            <?php if ($enable_optional_fields_toggle): ?>
            <!-- 任意入力フィールドの折りたたみ機能 -->
            <div id="optional-fields-toggle-wrapper">
                <button type="button" id="optional-fields-toggle-btn" class="optional-fields-toggle-btn">
                    <i class="fa fa-chevron-down" aria-hidden="true"></i> 下に開く
                </button>
                <div id="optional-fields-gradient" class="optional-fields-gradient"></div>
            </div>
            <div id="optional-fields-container" class="optional-fields-container" style="display: none;">
            <?php endif; ?>
            
            <div class="form-field">
                <label class="form-field__label" for="u_zip">郵便番号</label>
                <input id="u_zip" class="input-narrow" name="u_zip" type="text" value="<?php echo $_POST['u_zip'] ?>" onKeyUp="AjaxZip3.zip2addr(this,'','u_address','u_address');" placeholder="例：514-8505"  />
                <?php if (!empty($error['u_zip'])): ?>
                    <p class="form-field__error"><?php echo $error['u_zip'] ?></p>
                <?php endif; ?>
                <p class="form-field__hint">※郵便番号を正しく入力すると住所が自動入力されます</p>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_address">ご住所</label>
                <input id="u_address" name="u_address" type="text" value="<?php echo $_POST['u_address'] ?>"  />
                <?php if (!empty($error['u_address'])): ?>
                    <p class="form-field__error"><?php echo $error['u_address'] ?></p>
                <?php endif; ?>
            </div>
            <hr />
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
            
            <input type="hidden" name="form_type" value="1" />
            <input type="hidden" name="act" value="1" />
            <input type="hidden" name="form_id" value="5" />
            <input type="hidden" name="form_title" value="お問い合わせ・ご意見・ご要望" />
            </div>
            
            <?php if (!empty($error['recaptcha'])): ?>
                <p class="form-field__error"><?php echo $error['recaptcha']; ?></p>
            <?php endif; ?>

            <div id="recaptcha-widget" class="g-recaptcha"
                 data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"
                 data-callback="onRecaptchaSubmit"
                 data-size="invisible"></div>

            <div class="form-actions">
                <?php if($submitmode==0){?>
                    <button class="formz-btn" type="submit">送 信</button>
                <?php }else{ ?>
                    <span class="formz-submit-closed"><?= $submit_mess ?></span>
                <?php }?>
            </div>
        </form>
    </div>
    
    
	<!-- formzstrap-->  
            </div>
        </article>
        </section>
      </div>
    </main>
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
<?php if ($enable_optional_fields_toggle): ?>    
    <script src="/_assets/js/formz_optional_toggle.js"></script>
    <?php endif; ?>
    <script>
    var formzMain = document.getElementById('formz-main');
    if (formzMain) {
        formzMain.addEventListener('submit', function(e) {
            e.preventDefault();
            grecaptcha.execute();
        });
    }
    function onRecaptchaSubmit(token) {
        HTMLFormElement.prototype.submit.call(document.getElementById('formz-main'));
    }
    </script>
  </body>
</html>