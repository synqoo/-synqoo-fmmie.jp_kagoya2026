<?php
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
//error_reporting(0);
session_start();
$_SESSION['reg']=0;
$error=array();
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');
saveinput($_POST);
$fm_id=206;
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
    <title>ラジオでCM流しませんか？！｜レディオキューブFM三重</title>
    <meta name="description" content="職場で、車で、街中で。ラジコで御社の宣伝が流れます。FM三重のラジオCMは1本1万円（税込11,000円）から。お気軽にお問い合わせください。" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="color-scheme" content="light">

    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam ?? ''; ?>" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>

    <!-- ヒーローセクション -->
    <header class="rc-hero">
        <div class="rc-hero__inner">
            <h1 class="rc-hero__title">ラジオでCM流しませんか？！</h1>
            <div class="rc-hero__illust">
                <img src="images/rc-hero-illust.png" alt="" aria-hidden="true" loading="eager">
            </div>
            <p class="rc-hero__subtitle">職場で、車で、街中で　ラジコで<br>あなたの会社やお店の宣伝が流れます♪</p>
        </div>
    </header>

    <!-- イントロ -->
    <section class="rc-section rc-section--intro">
        <div class="rc-container">
            <p class="rc-intro__lead rc-intro__lead--accent"><img src="images/rc-accent-radio.png" alt="" class="rc-accent rc-accent--inline" width="48" height="48" aria-hidden="true">テレビ、新聞、雑誌、WEBサイト - 数あるPR媒体の中でも、広告費用が比較的安価で、直接耳にお届けできる電波媒体、それが「ラジオ」です。</p>
            <p class="rc-intro__text">ターゲットや放送期間を適切に設計すれば、1本のCMでも十分な広告効果が期待できます。繰り返し耳にするCMは自然な記憶定着を生み、「〇〇で検索」といった呼びかけが、手元のスマートフォンによる即時行動へとつながります。ラジオは、認知から検索・来店・問い合わせまでをスムーズに促す広告手法として活用できます。</p>
            <div class="rc-intro__cta">
                <strong>たった1万円（税込11,000円）から、FM三重でのラジオCMが可能です。</strong>
            </div>
        </div>
    </section>

    <!-- ナビアンカー -->
    <nav class="rc-nav-anchor">
        <div class="rc-container">
            <ul class="rc-nav-anchor__list">
                <li><a href="#cm-types">どんな広告展開・種類がありますか？</a></li>
                <li><a href="#costs">費用はどのくらい？</a></li>
                <li><a href="#voice-samples">どんな声の方が読んでくれますか？</a></li>
                <li><a href="#flow">流れを教えてください</a></li>
            </ul>
        </div>
    </nav>

    <!-- ラジオCMの種類 -->
    <section id="cm-types" class="rc-section rc-section--types">
        <div class="rc-container">
            <h2 class="rc-section__title">ラジオCMの種類</h2>
            <div class="rc-cm-types">
                <div class="rc-cm-type">
                    <h3 class="rc-cm-type__name">タイムCM（番組提供）</h3>
                    <p class="rc-cm-type__desc">3ヶ月単位で、番組のスポンサードを行う形式です。平日週5日（ベルト）番組や週1回の番組などさまざまあり、ターゲットが明確な場合は目的に合った番組のタイムCMを流すことで、社名や商品をしっかり認知させることができます。</p>
                    <ul class="rc-cm-type__points">
                        <li><strong>番組の前後にクレジットが流れる</strong>　CMのほか、番組の冒頭と終了時に「この番組は〇〇の提供でお送りします／しました」といったクレジットが流れるため、1回の放送で3回、社名や商品名が流れます。</li>
                        <li><strong>毎日同じ時間に流れる</strong>　ラジオは決まった時間に習慣的に聴いていただく場合が多いため、特定のターゲットに「△△といえば〇〇」というイメージを定着させるのに適しています。</li>
                        <li><strong>CM素材の差し替えも可能</strong>　月ごとや週ごとなど、CM素材の差し替えが可能なため、季節に合った商品のCMを流すことができます。</li>
                    </ul>
                    <p class="rc-cm-type__price">【費用】月額5万円（税込55,000円）から　※3ヶ月以上から承ります</p>
                </div>
                <div class="rc-cm-type">
                    <h3 class="rc-cm-type__name">スポットCM</h3>
                    <p class="rc-cm-type__desc">極端にいえば「1本」からでも放送が可能です。CM枠の空きがあれば、番組の間でも、番組と番組の間でも、コマーシャルを流すことができます。「この期間内に」など期限があるイベント告知などは、スポットCMで広く集中的に知っていただくことができます。</p>
                    <p class="rc-cm-type__price">【費用】10〜20本で5万円（税込55,000円）〜20万円（税込22万円）　※企画により金額が異なります</p>
                </div>
                <div class="rc-cm-type">
                    <h3 class="rc-cm-type__name">インフォマーシャルCM</h3>
                    <p class="rc-cm-type__desc">3万円（税込33,000円）／1回で広告が可能です。事前に収録したものを放送する通常のCMと違い、生放送の番組内でパーソナリティが直接原稿を読んで告知するCMです。インフォマーシャルCM（約60秒）なら、1回3万円（税込33,000円）で広くPRできます。</p>
                    <p class="rc-cm-type__price">【費用】1回3万円（税込33,000円）</p>
                </div>
                <div class="rc-cm-type">
                    <h3 class="rc-cm-type__name">三重リポート（生放送）</h3>
                    <p class="rc-cm-type__desc">FM三重リポーターがお客様のもとへ直接お伺いし、"熱い想い"をインタビュー、番組内で生放送します。タイムリーな情報発信とターゲットへの深いアプローチが可能です。<br />詳細情報は公式SNSに掲載します。</p>
                    <p class="rc-cm-type__schedule">月曜～金曜「つながるジカン」番組内 17:41～ 約5分程度</p>
                    <p class="rc-cm-type__reporters-label">リポーターの紹介</p>
                    <ul class="rc-cm-type__reporters">
                        <li class="rc-reporter">
                            <span class="rc-reporter__thumb"><img src="/personalities/profile_photos/ochiayane_sq.jpg" alt="越智綺音" width="120" height="120" loading="lazy"></span>
                            <span class="rc-reporter__name">（月）越智綺音</span>
                        </li>
                        <li class="rc-reporter">
                            <span class="rc-reporter__thumb"><img src="/personalities/profile_photos/sakotaaiko_sq.jpg" alt="迫田藍子" width="120" height="120" loading="lazy"></span>
                            <span class="rc-reporter__name">（水）迫田藍子</span>
                        </li>
                        <li class="rc-reporter">
                            <span class="rc-reporter__thumb"><img src="/personalities/profile_photos/suzukihuuna_sq.jpg" alt="鈴木風奈" width="120" height="120" loading="lazy"></span>
                            <span class="rc-reporter__name">(木) 鈴木風奈</span>
                        </li>
                        <li class="rc-reporter">
                            <span class="rc-reporter__thumb"><img src="/personalities/profile_photos/yamadarika_sq.jpg" alt="山田 梨果" width="120" height="120" loading="lazy"></span>
                            <span class="rc-reporter__name">(金) 山田梨果</span>
                        </li>
                    </ul>
                    <p class="rc-cm-type__price">【費用】1回5万円（税込55,000円） ※行政、準じる機関など設定料金が異なります。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CMにかかる費用 -->
    <section id="costs" class="rc-section rc-section--costs">
        <div class="rc-container">
            <h2 class="rc-section__title">CMにかかる費用</h2>
            <p class="rc-costs__lead">1本1万円（税込11,000円）から、御社のラジオCMが放送できます。ご予算、期間、ターゲットなど、プランニング可能ですので、まずはお問い合わせください。</p>
            <!-- <p class="rc-costs__note">お問い合わせ・見積もりのご依頼だけでも大歓迎です。お見積もり⇒CM制作⇒放送までの一連のやり取りを、メールと電話で済ませることも可能です。</p> -->
            <div class="rc-costs__download">
                <!-- <p>基本的な放送料（単価）は以下よりダウンロードください。</p>
                <a href="https://fmmie.jp/sp/radiocm/radiocubeCMprice.pdf" class="rc-btn rc-btn--primary" target="_blank" rel="noopener">料金表をダウンロード（PDF）</a>
                <p class="rc-costs__disclaimer">※各種契約条件によって放送料金が異なる場合があります</p>
            </div> -->

            <section class="rc-costs__price-section">
  <h2 class="rc-costs__price-title">FM三重 CM料金表（定価・税込み）</h2>
  <p class="rc-costs__price-note">
    ※税込価格　W：電波料　P：制作費
  </p>

  <div class="rc-costs__price-grid">
  <div class="rc-costs__price-block">
  <h3>スポットCM（秒数別）</h3>
  <div class="rc-costs__price-scroll">
    <table class="rc-costs__price-table">
      <thead>
        <tr>
          <th>秒数</th>
          <th>スポット（円）</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>5秒</td><td>9,900</td></tr>
        <tr><td>10秒</td><td>13,200</td></tr>
        <tr><td>15秒</td><td>15,400</td></tr>
        <tr><td>20秒</td><td>17,600</td></tr>
        <tr><td>30秒</td><td>23,100</td></tr>
        <tr><td>40秒</td><td>28,600</td></tr>
        <tr><td>50秒</td><td>34,100</td></tr>
        <tr><td>60秒</td><td>39,600</td></tr>
        <tr><td>80秒</td><td>50,600</td></tr>
      </tbody>
    </table>
  </div>
  </div>

  <div class="rc-costs__price-block">
  <h3>箱番組（月額）</h3>
  <div class="rc-costs__price-scroll">
    <table class="rc-costs__price-table">
      <thead>
        <tr>
          <th>分数</th>
          <th>月額（円）</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>5分</td><td>209,000</td></tr>
        <tr><td>10分</td><td>242,000</td></tr>
        <tr><td>15分</td><td>286,000</td></tr>
        <tr><td>25分</td><td>429,000</td></tr>
        <tr><td>30分</td><td>473,000</td></tr>
        <tr><td>55分</td><td>770,000</td></tr>
        <tr><td>60分</td><td>814,000</td></tr>
      </tbody>
    </table>
  </div>
  </div>

  <div class="rc-costs__price-block">
  <h3>生CM（W：電波料 / P：制作費）</h3>
  <div class="rc-costs__price-scroll">
    <table class="rc-costs__price-table rc-costs__price-table--wide">
      <thead>
        <tr>
          <th>秒数</th>
          <th>W（円）</th>
          <th>P（円）</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>40秒</td><td>27,500</td><td>22,000</td></tr>
        <tr><td>60秒</td><td>33,000</td><td>22,000</td></tr>
        <tr><td>80秒</td><td>44,000</td><td>22,000</td></tr>
        <tr><td>120秒</td><td>55,000</td><td>22,000</td></tr>
        <tr><td>180秒</td><td>77,000</td><td>22,000</td></tr>
        <tr><td>240秒</td><td>99,000</td><td>22,000</td></tr>
      </tbody>
    </table>
  </div>
  </div>
  </div>

  <p class="rc-costs__price-disclaimer">
    ※各種契約条件、実勢単価（価格）は異なる場合もありますので、都度お問合せください。<br>
    ※各企画により、リーズナブルな価格設定もありますので、お問合せください。
  </p>

  <!-- <p class="rc-costs__price-source">
    出典：FM三重 CM料金表（定価） :contentReference[oaicite:0]{index=0}
  </p> -->
</section>

</div>
        </div>
    </section>

    <!-- サンプル音声 -->
    <section id="voice-samples" class="rc-section rc-section--voices">
        <div class="rc-container">
            <h2 class="rc-section__title">サンプル音声</h2>
            <p class="rc-voices__lead">アナウンサーの声のサンプルをお聴きいただけます。</p>
            <div class="rc-voice-list">
                <div class="rc-voice-item" data-audio="audio/sample_miyahara.mp3">
                    <div class="rc-voice-item__thumb">
                        <img src="https://fmmie.jp/personality/profile_photos/miyaharaerika_sq.jpg" alt="宮原 えりか" width="120" height="120" loading="lazy">
                    </div>
                    <span class="rc-voice-item__name">宮原 えりか</span>
                    <button type="button" class="rc-voice-play" aria-label="再生">
                        <img class="rc-voice-play__icon rc-voice-play__icon--play" src="images/voice.png" alt="">
                        <img class="rc-voice-play__icon rc-voice-play__icon--playing" src="images/voice2.png" alt="" hidden>
                    </button>
                    <audio class="rc-audio" preload="metadata"><source src="audio/sample_miyahara.mp3" type="audio/mpeg"></audio>
                </div>
                <div class="rc-voice-item" data-audio="audio/sample_kiyota.mp3">
                    <div class="rc-voice-item__thumb">
                        <img src="https://fmmie.jp/personality/profile_photos/kiyotanozomi_sq.jpg" alt="清田 のぞみ" width="120" height="120" loading="lazy">
                    </div>
                    <span class="rc-voice-item__name">清田 のぞみ</span>
                    <button type="button" class="rc-voice-play" aria-label="再生">
                        <img class="rc-voice-play__icon rc-voice-play__icon--play" src="images/voice.png" alt="">
                        <img class="rc-voice-play__icon rc-voice-play__icon--playing" src="images/voice2.png" alt="" hidden>
                    </button>
                    <audio class="rc-audio" preload="metadata"><source src="audio/sample_kiyota.mp3" type="audio/mpeg"></audio>
                </div>
                <!--<div class="rc-voice-item" data-audio="audio/sample_abe.mp3">
                    <div class="rc-voice-item__thumb">
                        <img src="https://fmmie.jp/personality/profile_photos/abetakeru_sq.jpg" alt="阿部 剛瑠" width="120" height="120" loading="lazy">
                    </div>
                    <span class="rc-voice-item__name">阿部 剛瑠</span>
                    <button type="button" class="rc-voice-play" aria-label="再生">
                        <img class="rc-voice-play__icon rc-voice-play__icon--play" src="images/voice.png" alt="">
                        <img class="rc-voice-play__icon rc-voice-play__icon--playing" src="images/voice2.png" alt="" hidden>
                    </button>
                    <audio class="rc-audio" preload="metadata"><source src="audio/sample_abe.mp3" type="audio/mpeg"></audio>
                </div>-->
                <div class="rc-voice-item" data-audio="audio/sample_shirota.mp3">
                    <div class="rc-voice-item__thumb">
                        <img src="https://fmmie.jp/personality/profile_photos/shirotakazuya_sq.jpg" alt="代田 和也" width="120" height="120" loading="lazy">
                    </div>
                    <span class="rc-voice-item__name">代田 和也</span>
                    <button type="button" class="rc-voice-play" aria-label="再生">
                        <img class="rc-voice-play__icon rc-voice-play__icon--play" src="images/voice.png" alt="">
                        <img class="rc-voice-play__icon rc-voice-play__icon--playing" src="images/voice2.png" alt="" hidden>
                    </button>
                    <audio class="rc-audio" preload="metadata"><source src="audio/sample_shirota.mp3" type="audio/mpeg"></audio>
                </div>
            </div>
        </div>
    </section>

    <!-- ラジオCM制作の流れ -->
    <section id="flow" class="rc-section rc-section--flow">
        <div class="rc-container">
            <h2 class="rc-section__title">ラジオCM制作の流れ</h2>
            <div class="rc-flow-steps">
                <div class="rc-flow-step">
                    <span class="rc-flow-step__num">①</span>
                    <h3 class="rc-flow-step__title">CM原稿を作成</h3>
                    <p>ご要望と趣旨を丁寧にヒアリングし、19秒以内で聞き取りやすく放送倫理に配慮したCM原稿を制作します。</p>
                </div>
                <div class="rc-flow-step">
                    <span class="rc-flow-step__num">②</span>
                    <h3 class="rc-flow-step__title">放送日時を相談</h3>
                    <p>スポット／タイムCMの放送日時（ローテーション）を並行して相談します。</p>
                </div>
                <div class="rc-flow-step">
                    <span class="rc-flow-step__num">③</span>
                    <h3 class="rc-flow-step__title">素材搬入・放送</h3>
                    <p>素材搬入期限までにOKかどうか決定し、あとは放送されるのをお待ちください。</p>
                </div>
            </div>
            <div class="rc-flow-bonus">
                <h3>♪ 全国展開も可能です！ ♪</h3>
                <p>レディオキューブFM三重はJFNネットワーク加盟局のため、全国38局へのCM展開が可能です。三重県内企業でも、北海道や九州など特定エリアへの出稿ができ、お歳暮シーズンの重点地域への訴求や、新規進出エリアでの事前認知向上など、目的に応じた全国プロモーションにご活用いただけます。</p>
            </div>
        </div>
    </section>

    <!-- お問い合わせ -->
    <section id="contact" class="rc-section rc-section--contact">
        <div class="rc-container">
            <h2 class="rc-section__title">まずはお問い合わせください</h2>
            <div class="stack stack-md"  <?php if($submitmode==1){echo 'style="display:none;"';}?>>
        <p class="text-muted"><span class="vad">必須</span> 印は入力必須項目です。 </p>
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <div id="formz_input">
            <hr />
            <div class="form-field">
                <label class="form-field__label">ご関心のサービス</label>
                <div class="cluster cluster-gap-md">
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="x_bt" value="0" <?php if($_POST['x_bt']==0){echo 'checked="checked"';}?>  />
                        <span>ラジオCM</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="x_bt" value="1" <?php if($_POST['x_bt']==1){echo 'checked="checked"';}?>  />
                        <span>三重リポート</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="x_bt" value="2" <?php if($_POST['x_bt']==2){echo 'checked="checked"';}?>  />
                        <span>イベント関連</span>
                    </label>
                    <label class="cluster cluster-gap-xs">
                        <input type="radio" name="x_bt" value="3" <?php if($_POST['x_bt']==3){echo 'checked="checked"';}?> />
                        <span>その他</span>
                    </label>
                </div>
                <?php if (!empty($error['x_bt'])): ?>
                    <p class="form-field__error"><?php echo $error['x_bt'] ?></p>
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
                <label class="form-field__label" for="r_message">お問い合わせ内容</label>
                <textarea id="r_message" name="r_message" rows="10" required="required"><?php echo $_POST['r_message'] ?></textarea>
                <?php if (!empty($error['r_message'])): ?>
                    <p class="form-field__error"><?php echo $error['r_message'] ?></p>
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
            <input type="hidden" name="form_id" value="206" />
            <input type="hidden" name="form_title" value="CM制作サービス" />
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
    <!-- formzstrap-->  
    </section>
              
<?php require_once(INCLUDE_FOOTER_PATH); ?>

<script>
(function(){
    var voiceList = document.querySelector('.rc-voice-list');
    if (!voiceList) return;
    var audios = voiceList.querySelectorAll('.rc-audio');
    var buttons = voiceList.querySelectorAll('.rc-voice-play');

    function setPlaying(btn, isPlaying) {
        var playIcon = btn ? btn.querySelector('.rc-voice-play__icon--play') : null;
        var playingIcon = btn ? btn.querySelector('.rc-voice-play__icon--playing') : null;
        if (playIcon) playIcon.hidden = !!isPlaying;
        if (playingIcon) playingIcon.hidden = !isPlaying;
    }

    function stopAllExcept(currentAudio) {
        audios.forEach(function(a) {
            if (a !== currentAudio) {
                a.pause();
                a.currentTime = 0;
            }
        });
        buttons.forEach(function(btn) {
            var item = btn.closest('.rc-voice-item');
            var audio = item ? item.querySelector('.rc-audio') : null;
            setPlaying(btn, audio === currentAudio && !audio.paused);
        });
    }

    audios.forEach(function(audio) {
        audio.addEventListener('play', function() { stopAllExcept(audio); setPlaying(audio.closest('.rc-voice-item').querySelector('.rc-voice-play'), true); });
        audio.addEventListener('pause', function() { setPlaying(audio.closest('.rc-voice-item').querySelector('.rc-voice-play'), false); });
        audio.addEventListener('ended', function() { setPlaying(audio.closest('.rc-voice-item').querySelector('.rc-voice-play'), false); });
    });

    buttons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var item = btn.closest('.rc-voice-item');
            var audio = item ? item.querySelector('.rc-audio') : null;
            if (!audio) return;
            if (audio.paused) {
                audio.play();
            } else {
                audio.pause();
            }
        });
    });
})();
</script>
</body>
</html>
