<?php
session_start();
$_session['reg']=0;
require_once '../../_app/functions.php';
saveinput($_POST);
$fm_id=252;
formz_config($fm_id);
if($_POST['act']==1){
	require_once '../../_app/formz_validate.php';
	if (!is_array($error)){
        require_once '../../_app/formz_regist.php';
	}else{
		$_session['reg']=0;
	}
}
$phppath = '<$MTGetVar name="config.includephppath"$>'
?>
<!DOCTYPE html>
<html lang="ja" itemscope itemtype="http://schema.org/Blog">
  <head>

<?php require_once("/home/kir691871/public_html/fmmie.jp/_include/inc_htmlheader.php"); ?>
<?php require_once('/home/kir691871/public_html/fmmie.jp/service/_include/header.php'); ?>

<style>
    #footer_navi {
        font-size:0.8em;
    }
    #headersp img{
        margin-top:-10px;
    }
    header{
        background-color:#fff;
    }
</style>
  </head>
<body>
<?php
require_once("/home/kir691871/public_html/fmmie.jp/_include/inc_header_sp.php");
?>

    <!-- ヒーローセクション -->
    <header class="hero">
        <img src="images/toptitle2.png" style="margin:auto"/>
        <!-- <h1>みえツナゲール</h1> -->
        <!-- <p class="subtitle">人と人をつなぐイベントサービス</p> -->
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
            レディブキューブFM三重が解決します！
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
                    <img src="images/event1.jpg" alt="地域貢献イベント" class="service-image" />
                    <div class="service-body">
                    企業・行政・団体などのイベントの企画・運営
                        <div class="service-example">事例：JA伊勢合併5周年</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">来店促進イベント</div>
                    <img src="images/event2.jpg" alt="来店促進イベント画像" class="service-image" />
                    <div class="service-body">
                        集客を目的としたイベントの企画・運営
                        <div class="service-example">事例：レディオキューブパン祭り</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">研修・セミナー</div>
                    <img src="images/event3.jpg" alt="研修・セミナー" class="service-image" />
                    <div class="service-body">
                        ビジネス向けの研修や講演会の企画・運営
                        <div class="service-example">事例：マネーセミナー</div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-header">展示会</div>
                    <img src="images/event4.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        商品やサービスの展示会イベントの企画・運営
                        <div class="service-example">事例：輸入車ディーラー合同フェア</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">コンサート企画</div>
                    <img src="images/event6.jpg" alt="コンサート企画" class="service-image" />
                    <div class="service-body">
                        コンサートの企画・運営をサポート
                        <div class="service-example">事例：おやじバンド合戦松阪の陣</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">学園祭</div>
                    <img src="images/event5.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        大学や学校の学園祭イベントサポート
                        <div class="service-example">事例：鈴鹿医療科学大学学園祭</div>
                    </div>
                </div>
                
                <div class="service-card">
                    <div class="service-header">公開放送</div>
                    <img src="images/event7.jpg" alt="SDGsイベント" class="service-image" />
                    <div class="service-body">
                    番組の公開録音・公開生放送の企画・運営
                        <div class="service-example">事例：みんなでエシカル公開生放送</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">eスポーツイベント</div>
                    <img src="images/event8c.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                    eスポーツの大会、体験会の企画・運営
                        <div class="service-example">事例：四日市市 こにゅうどうくんカップ</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">司会・MC派遣</div>
                    <img src="images/event9.jpg" alt="eスポーツイベント" class="service-image" />
                    <div class="service-body">
                        司会者・MCをイベントに派遣
                        <div class="service-example">事例：アナウンサー・タレント派遣</div>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-header">タレントブッキング</div>
                    <img src="images/event0.jpg" alt="タレント・アーティストブッキング" class="service-image" />
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
                    <h3>イベント企画・運営</h3>
                    <p>音楽・食・講演会・式典など各種イベントの企画運営を行います。</p>
                </div>
                <div class="capability-card">
                    <h3>イベントMC</h3>
                    <p>イベントや周年パーティーなど、あらゆるエンターテインメントイベントを盛り上げます。</p>
                </div>
                <div class="capability-card">
                    <h3>司会</h3>
                    <p>記念式典や結婚式、表彰式、講演会などフォーマルなイベントでの進行をします。</p>
                </div>
                <div class="capability-card">
                    <h3>アーティストブッキング</h3>
                    <p>お祭りや周年イベントなどのステージコンテンツとして、アーティスト、芸人、文化人、スポーツ選手等のブッキングを行います。</p>
                </div>
                <div class="capability-card">
                    <h3>ナレーション</h3>
                    <p>CMや企業動画などの映像ナレーション、会場案内や音声ガイダンスなど声のみの収録となります。</p>
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
                <div class="contact-form">
                <form  action="" method="post" enctype="multipart/form-data">
            <div id="formz_box">
            <?php echo $error['top'] ?>
            ・入力いただきました個人情報は、[みえツナゲール]受付以外では使用しません。詳しくは、<a href="/company/security.php">プライバシーポリシー</a>をご参照ください。<br />
            <!-- ・<span class="vad">*</span>印は入力必須項目です。 -->
            
            <div id="formz_input" <?php if($submitmode==1){echo 'style="display:none;"';}?>>
            <hr class="req_sep_bar" />
                        <div class="form-group">
                        <label class="control-label " for="r_message">お問い合わせ内容</label>
                        <textarea class="form-control" cols="20" id="r_message" name="r_message" rows="10" ><?php echo $_POST['r_message'] ?></textarea>
                        </div>
            <div class="form-group">
                <label class="control-label " for="u_radioname">貴局名・社名<span class="vad">*</span></label>
                <input class="form-control" value="<?php echo $_POST['u_radioname'] ?>" id="u_radioname" name="u_radioname" type="text" required="required" />
                <span class="error_red"><?php echo $error['u_radioname'] ?></span>
            </div>
            <div class="form-group">
                <label class="control-label " for="u_name">ご担当者氏名<span class="vad">*</span></label>
                <input class="form-control" value="<?php echo $_POST['u_name'] ?>" id="u_name" name="u_name" type="text" required="required" />
                <span class="error_red"><?php echo $error['u_name'] ?></span>
            </div>
            <div class="form-group">
                <label class="control-label " for="u_tel">電話番号<span class="vad">*</span></label>
                <input class="form-control" value="<?php echo $_POST['u_tel'] ?>" id="u_tel" name="u_tel" type="text" required="required" />
                <span class="error_red"><?php echo $error['u_tel'] ?></span>
            </div>
            <div class="form-group">
                <label class="control-label " for="u_email">メールアドレス<span class="vad">*</span></label>
                <input class="form-control" value="<?php echo $_POST['u_email'] ?>" id="u_email" name="u_email" type="text" required="required" />
                <span class="error_red"><?php echo $error['u_email'] ?></span>
            </div>
            <!-- <hr clear="all" /> -->
            <!-- <div class="form-group">
                <div class="checkbox">
                <label>
                    <input type="checkbox" name="savedata" id="savedata" value="1" <?php if($_POST['savedata']==1){echo 'checked="checked"';} ?> /> お名前などの入力項目をブラウザに保存する。 
                </label>
                </div>
            </div>     -->
            <input type="hidden" name="form_type" value="0" />
            <input type="hidden" name="act" value="1" />
            <input type="hidden" name="form_id" value="252" />
            </div>
            <div class="form-group center-block">
            <?php if($submitmode==0){?>
                <button class="btn btn-primary " name="submit" type="submit">送信</button>
            <?php }else{ ?>
                <span class="formz-submit-closed"><?= $submit_mess ?></span>
            <?php }?>
            </div>
            </div>
        </form>
                </div>
            </div>
        </div>
    </section>
    <?php
require_once("/home/kir691871/public_html/fmmie.jp/_include/inc_footer.php");
?>
