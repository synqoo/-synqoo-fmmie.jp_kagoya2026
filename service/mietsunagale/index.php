<?php
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
//error_reporting(0);
session_start();
$_SESSION['reg']=0;
$error=array();
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');
saveinput($_POST);
$fm_id=252;
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
<html lang="ja" class="no-dark">
<head>
    <meta charset="UTF-8">
    <title>みえツナゲール - 人と人をつなぐイベントサービス</title>
  <!-- レスポンシブ -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="format-detection" content="telephone=no" />
  <!-- 説明文 -->
  <meta name="description" content="" />
  <meta name="color-scheme" content="light"> 

 <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
 <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam; ?>" />
 <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
    <!-- ヒーローセクション -->
    <header class="hero">
        <img src="images/toptitle2.png" style="margin:auto" alt="みえツナゲール" />
    </header>
    
    <!-- イベント主催者のお悩み -->
    <section class="section section--problems">
        <div class="container">
            <h2 class="section-title">イベント主催者のお悩み</h2>
            <img src="images/ppl.png" alt="レディオキューブが解決します！" class="solution-image" />
            <div class="problems-grid">
                <div class="problem-card">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    イベントの運営をしてほしい
                </div>
                <div class="problem-card">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    イベント企画を考えてほしい
                </div>
                <div class="problem-card">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    集客あるイベントを実施したい
                </div>
                <div class="problem-card">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    イベント司会者を探してほしい
                </div>
                <div class="problem-card">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    タレントを探してほしい！
                </div>
                <div class="problem-card">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    イベントの告知をしてほしい
                </div>
            </div>
            
            <div class="solution-banner">
                レディオキューブが解決します！
            </div>
        </div>
    </section>
    
    <!-- サービス内容と事例 -->
    <section class="section section--services">
        <div class="container">
            <h2 class="section-title">サービス内容と事例</h2>
            <h3 class="section-subtitle">主催者の目的に応じた会場手配やイベントの企画制作運営をサポートします。</h3>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-header">地域貢献イベント</div>
                    <img src="images/event8.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        地域活性化や記念式典などのイベント
                        <div class="service-example">事例：JA伊勢合併記念、玉城町催し</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">来店促進イベント</div>
                    <img src="images/event1.jpg" alt="来店促進イベント画像" class="service-image" />
                    <div class="service-body">
                        集客を目的としたイベントの企画・運営
                        <div class="service-example">事例：レディオキューブパン祭り</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">研修・セミナー</div>
                    <img src="images/event8.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        ビジネス向けの研修や講演会の企画・運営
                        <div class="service-example">事例：マネーセミナー</div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-header">展示会</div>
                    <img src="images/event4.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        商品やサービスの展示会イベント
                        <div class="service-example">事例：輸入車ディーラー合同フェア</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">コンサート企画</div>
                    <img src="images/event8.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        コンサートの企画・運営をサポート
                        <div class="service-example">事例：岡田文化財団 はらみちゃんコンサート</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">学園祭</div>
                    <img src="images/event8.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        大学や学校の学園祭イベントサポート
                        <div class="service-example">事例：鈴鹿医療科学大学学園祭</div>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-header">公開放送</div>
                    <img src="images/event7.jpg" alt="SDGsイベント" class="service-image" />
                    <div class="service-body">
                        イベントなどでの番組公開放送の企画・運営
                        <div class="service-example">事例：みんなでエシカル公開生放送</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">eスポーツイベント</div>
                    <img src="images/event8.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        最新のeスポーツ大会の企画・運営
                        <div class="service-example">事例：四日市市 こにゅうどうくんカップ</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">司会・MC派遣</div>
                    <img src="images/event8.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        司会者・MCをイベントに派遣
                        <div class="service-example">事例：アナウンサー・タレント派遣</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">タレントブッキング</div>
                    <img src="images/event8.jpg" alt="タレント・アーティストブッキング" class="service-image" />
                    <div class="service-body">
                        タレントやアーティストをイベントに派遣
                        <div class="service-example">事例：タレント・アーティスト派遣</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- できること -->
    <section class="section section--capabilities">
        <div class="container">
            <h2 class="section-title">できること</h2>
            <div class="capabilities-grid">
                <div class="capability-card">
                    <h3>イベントMC</h3>
                    <p>イベントや周年パーティーなど、あらゆるエンターテインメントイベントを盛り上げます。</p>
                </div>
                <div class="capability-card">
                    <h3>司会</h3>
                    <p>記念式典や結婚式、表彰式、講演会などフォーマルなイベントでの進行をします。</p>
                </div>
                <div class="capability-card">
                    <h3>アーティスト</h3>
                    <p>お祭りや周年イベントなどのステージコンテンツとして、各種ジャンルの音楽演奏を行うアーティストのブッキングを行います。</p>
                </div>
                <div class="capability-card">
                    <h3>ナレーション</h3>
                    <p>CMや企業動画などの映像ナレーション、会場案内や音声ガイダンスなど声のみの収録となります。</p>
                </div>
                <div class="capability-card">
                    <h3>イベント企画・運営</h3>
                    <p>音楽・食・講演会・式典など各種イベントの企画運営を行います。</p>
                </div>
                <div class="capability-card">
                    <h3>CM・番組企画・店内放送</h3>
                    <p>CM放送、番組制作、店舗用ラジオ番組風BGMの作成など。</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- 選ばれる理由 -->
    <section class="section section--reasons">
        <div class="container">
            <h2 class="section-title">レディオキューブが選ばれる理由</h2>
            <div class="reasons-grid">
                <div class="reason-card">
                    <div class="reason-card-icon">
                        <img src="images/goods.png" alt="信用度アイコン">
                    </div>
                    <div class="reason-card-text">三重県唯一の民放ラジオ局の信用度</div>
                </div>
                <div class="reason-card">
                    <div class="reason-card-icon">
                        <img src="images/goods.png" alt="ラジオアイコン">
                    </div>
                    <div class="reason-card-text">ラジオであなたのイベントを紹介される</div>
                </div>
                <div class="reason-card">
                    <div class="reason-card-icon">
                        <img src="images/goods.png" alt="一貫サービスアイコン">
                    </div>
                    <div class="reason-card-text">企画・運営・告知まで一貫通貫のご提案ができる</div>
                </div>
                <div class="reason-card">
                    <div class="reason-card-icon">
                        <img src="images/goods.png" alt="実績アイコン">
                    </div>
                    <div class="reason-card-text">長年にわたり多種多様なイベントの実績がある</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- よくある質問 -->
    <section class="section section--faq">
        <div class="container">
            <h2 class="section-title">よくある質問</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question">Q：お問い合わせをする場合どんな情報が必要ですか？</div>
                    <div class="faq-answer">A：開催時期、場所、目的、趣旨、予算を教えてください。場所の選定から企画運営までお手伝いできます。</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Q：司会者・タレント・アーティストだけの手配はできますか？</div>
                    <div class="faq-answer">A：はい、可能です。イベント内容に沿ったキャスティングを行います。</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Q：イベント開催のどれくらい前から相談するのがいいですか？</div>
                    <div class="faq-answer">A：開催当日から逆算して最低3ヶ月前からです。</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Q：費用はどれくらいでしょうか？</div>
                <div class="faq-answer">A：司会・MCなら4万円～、タレントブッキングは10万円～、番組公開放送は60万円～</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- お問い合わせ -->
    <section class="section section--contact">
        <div class="container">
            <div class="contact-section">
                <h2>お問い合わせ</h2>
                
                <div class="stack stack-md"  <?php if($submitmode==1){echo 'style="display:none;"';}?>>
        <p class="text-muted"><span class="vad">必須</span> 印は入力必須項目です。 </p>
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <div id="formz_input">
            <hr />
            <div class="form-field">
                <label class="form-field__label" for="r_message">メッセージ</label>
                <textarea id="r_message" name="r_message" rows="10" ><?php echo $_POST['r_message'] ?></textarea>
                <?php if (!empty($error['r_message'])): ?>
                    <p class="form-field__error"><?php echo $error['r_message'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_radioname">貴局名・社名<span class="vad">必須</span></label>
                <input id="u_radioname" name="u_radioname" type="text" value="<?php echo $_POST['u_radioname'] ?>" required="required" />
                <?php if (!empty($error['u_radioname'])): ?>
                    <p class="form-field__error"><?php echo $error['u_radioname'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-field__label" for="u_name">ご担当者氏名<span class="vad">必須</span></label>
                <input id="u_name" name="u_name" type="text" value="<?php echo $_POST['u_name'] ?>" required="required" />
                <?php if (!empty($error['u_name'])): ?>
                    <p class="form-field__error"><?php echo $error['u_name'] ?></p>
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
            <input type="hidden" name="form_id" value="252" />
            <input type="hidden" name="form_title" value="みえツナゲール" />
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
    
            </div>
        </div>
    </section>

    <?php require_once(INCLUDE_FOOTER_PATH); ?> 

    </body>
    </html>