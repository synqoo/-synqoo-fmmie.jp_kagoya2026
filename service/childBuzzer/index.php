<?php
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');

$buzzerListPath = __DIR__ . '/buzzerlist.txt';
$sponsors = [];
if (is_readable($buzzerListPath)) {
    $lines = file($buzzerListPath, FILE_IGNORE_NEW_LINES);
    if ($lines !== false) {
        $lines = array_map('trim', $lines);
        $lines = array_values(array_filter($lines, static function ($l) {
            return $l !== '';
        }));
        $n = count($lines);
        for ($i = 0; $i + 1 < $n; $i += 2) {
            $name = $lines[$i];
            $next = $lines[$i + 1];
            if (preg_match('/^https?:\/\//iu', $name)) {
                continue;
            }
            $url = preg_match('/^https?:\/\//iu', $next) ? $next : '';
            $sponsors[] = ['name' => $name, 'url' => $url];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja" class="no-dark">
<head>
    <meta charset="UTF-8">
    <title>防犯ブザーキャンペーン ｜レディオキューブFM三重</title>
    <meta name="description" content="防犯ブザーキャンペーン " />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="color-scheme" content="light">

    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>

    <div class="container">
        <header class="xx">
            <h1>防犯ブザープレゼント<br>キャンペーン</h1>
            <p class="subtitle">子どもたちの安全を守るために</p>
        </header>

        <div class="intro">
            <p>近年、子どもを狙った事件や不審者情報が全国的に増加しており、三重県内でも不審者情報が報告されています。</p>
            
            <p>子どもたちは地域の未来であり、大切な宝です。</p>
            
            <p>レディオキューブFM三重では、地域密着ラジオ局として子どもたちを犯罪から守る取り組みとして、毎年4月、三重県内の新小学1年生全員<span class="emphasis">（約12,000人）</span>に防犯ブザーを贈るキャンペーンを実施します。</p>
            
            <p>防犯ブザーが、かけがえのない命を守り、子どもたちが健やかに成長していくための一助となることを願っています。</p>
        </div>

        <div class="important-message">
            <p>ただし、防犯ブザーだけで子どもたちの安全を守りきれるわけではありません。</p>
            
            <p>子どもたちの安全を守るのは、地域の「目」と「耳」です。</p>
            
            <p>県民の皆さまのご理解とご協力をお願いいたします。</p>
        </div>

        <h2>キャンペーン内容</h2>

        <div class="campaign-item">
            <div>
                <span class="campaign-number">①</span>
                <span class="campaign-title">三重県内 新小学1年生へ防犯ブザーを配布</span>
            </div>
            <div class="campaign-content">
                <p>2026年4月、各市町村の教育委員会を通じて、三重県内の新小学1年生全員に防犯ブザーを配布します。</p>
                <p class="note">（配布予定数：約12,000人）</p>
            </div>
        </div>

        <div class="campaign-item">
            <div>
                <span class="campaign-number">②</span>
                <span class="campaign-title">啓発キャンペーンの告知CMを1年間放送</span>
            </div>
            <div class="campaign-content">
                <p>レディオキューブFM三重の放送を通じて、子どもたちの安全意識向上・防犯意識の啓発を目的としたキャンペーン告知CMを放送します。</p>
            </div>
        </div>
        <div class="campaign-item campaign-item-link">
            <p>本キャンペーンにつきましては、多くの企業・団体の皆様よりご協賛を賜り実施することができました。ご協賛社の皆様を以下にご紹介いたします。（５０音順）</p>
            <?php if (!empty($sponsors)) : ?>
            <ul class="sponsor-compact-list">
                <?php foreach ($sponsors as $sp) :
                    $nameH = htmlspecialchars($sp['name'], ENT_QUOTES, 'UTF-8');
                    $urlH = htmlspecialchars($sp['url'], ENT_QUOTES, 'UTF-8');
                    ?>
                <li><?php
                    if ($sp['url'] !== '') {
                        echo '<a href="' . $urlH . '" target="_blank" rel="noopener noreferrer">' . $nameH . '</a>';
                    } else {
                        echo $nameH;
                    }
                    ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <!--※ 現在協賛企業様を募集中です。<a href="/service/childBuzzer/BouhanBuzzerCampagin.pdf" target="_blank" >
詳しくはこちら <i class="fa fa-external-link" aria-hidden="true"></i></a>
<p><a href="mailto:eigyou@fmmie.jp">eigyou@fmmie.jp</a></p>-->
        </div>
        <div class="support-section">
            <h3>後援・協力</h3>
            <div class="support-list">
                <p><strong>後援：</strong>三重県教育委員会／三重県警察本部／中日新聞社</p>
                <p><strong>協力：</strong>各29市町教育委員会</p>
            </div>
        </div>

        <div class="support-section">
            <h3>ご報告</h3>
            <div class="report-grid">
                <div class="report-item">
                    <p>三重県教育委員会に目録を贈呈いたしました。</p>
                    <img src="images/11.jpg" alt="三重県教育委員会へ目録を贈呈した様子" loading="lazy" decoding="async" />
                </div>
                <div class="report-item">
                    <p>三重県警察本部より感謝状を頂戴いたしました。</p>
                    <img src="images/12.jpg" alt="三重県警察本部からの感謝状" loading="lazy" decoding="async" />
                </div>
            </div>
        </div>


        <div class="contact">
            <h3>お問い合わせ</h3>
            <p>三重エフエム放送株式会社<br>（レディオキューブFM三重）</p>
            <p class="contact-phone">TEL：<a href="tel:0592255533">059-225-5533</a></p>
        </div>
    </div>
 </article>
</section>
</div>
<?php require_once(INCLUDE_FOOTER_PATH); ?>
</body>
</html>
