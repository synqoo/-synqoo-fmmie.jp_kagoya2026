<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!DOCTYPE html>
<html lang="ja" class="no-dark">
<head>
    <meta charset="UTF-8">
    <title>レディオキューブパン祭り｜レディオキューブFM三重</title>
    <meta name="description" content="三重県内の話題のパン屋さんが一同に会するパンまつり。イベント日程・出店者一覧・パン屋さん口コミ募集" />
    <meta name="color-scheme" content="light">

    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <link rel="stylesheet" href="css/styles.css?" />
</head>
<body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
<!-- コンテンツエリア -->

<div class="pm-container">
    <header class="pm-header">
        <div class="pm-hero-img" aria-hidden="true">
            <img src="images/panmatsuri.jpg" />
        </div>
    </header>

    <section class="pm-section pm-events">
    <!--<article class="pm-event card card-radius-lg card-shadow-sm">
    <div class="pm-event__body">
        <p class="pm-event__date"><i class="fa-solid fa-bread-slice"></i> 4月4日<span class="pm-sat">（土）</span>・5日<span class="pm-sun">（日）</span></p>
        <p class="pm-event__time">第1部10時～, 第2部12時～, 第3部14時30分～</p>
        <p class="pm-event__place">場所：イオンモール鈴鹿 1F中央コート</p>
        <button type="button" class="pm-btn pm-btn--detail" aria-expanded="false" aria-controls="pm-event-detail-1">詳細を見る</button>
        <div class="pm-event__detail" id="pm-event-detail-1" hidden>
            <div class="pm-event__detail-title">4月4日（土）出店</div>
            <div class="pm-cards">
                <div class="pm-card">
                    <p class="pm-card__name">トルタロッソ</p>
                    <p class="pm-card__addr">伊賀市下友田1371</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">アトリエ ウフ</p>
                    <p class="pm-card__addr">伊賀市土橋741</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">コクリコルージュ</p>
                    <p class="pm-card__addr">伊勢市御薗町王中島字垣溝766</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">桑ぱん</p>
                    <p class="pm-card__addr">桑名市新西方2-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">パン工房KOKO</p>
                    <p class="pm-card__addr">桑名市西別所296-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ドミニクドゥーセの店</p>
                    <p class="pm-card__addr">鈴鹿市南江島町17-30</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">NOKOTOKO</p>
                    <p class="pm-card__addr">多気郡相可127</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">アトリエ プティタプティ</p>
                    <p class="pm-card__addr">津市安濃町田端上野987-78</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">Ryomaパン工房</p>
                    <p class="pm-card__addr">津市垂水2864-17</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ヒローズ</p>
                    <p class="pm-card__addr">津市半田243-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">Chou Chou</p>
                    <p class="pm-card__addr">津市久居野口町2477-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">パンとほっぺ</p>
                    <p class="pm-card__addr">松阪市伊勢寺町55514-3 ベルファーム内</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ローゼンボルグ</p>
                    <p class="pm-card__addr">松阪市中央町453</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">Bakery&amp;Cafe かぜのテラス</p>
                    <p class="pm-card__addr">四日市市下海老町字平野109-8</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">パン工房 ブルーミング</p>
                    <p class="pm-card__addr">四日市市別名3-3-10</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">kujiraドライブイン</p>
                    <p class="pm-card__addr">四日市市松原町1-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">マーブルラパン</p>
                    <p class="pm-card__addr">鈴鹿市中旭が丘3丁目10-26</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ichvangama MAISON</p>
                    <p class="pm-card__addr">桑名市大字大仲新田181-3</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">なもパン</p>
                    <p class="pm-card__addr">桑名市城山台121</p>
                </div>
            </div>
            <div class="pm-event__detail-title">4月5日（日）出店</div>
            <div class="pm-cards">
                <div class="pm-card">
                    <p class="pm-card__name">トルタロッソ</p>
                    <p class="pm-card__addr">伊賀市下友田1371</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">コクリコルージュ</p>
                    <p class="pm-card__addr">伊勢市御薗町王中島字垣溝766</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ルポッシュ</p>
                    <p class="pm-card__addr">鈴鹿市西条4丁目10</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">パン工房KOKO</p>
                    <p class="pm-card__addr">桑名市西別所296-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ドミニクドゥーセの店</p>
                    <p class="pm-card__addr">鈴鹿市南江島町17-30</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">テテ</p>
                    <p class="pm-card__addr">津市栗真中山町16-5</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">Ryomaパン工房</p>
                    <p class="pm-card__addr">津市垂水2864-17</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ラ・ミシェット</p>
                    <p class="pm-card__addr">津市久居西鷹跡町364-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">マルスギベーカリー</p>
                    <p class="pm-card__addr">松阪市嬉野中川新町1-16</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">パン工房 ブルーミング</p>
                    <p class="pm-card__addr">四日市市別名3-3-10</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">パン屋 ロキ</p>
                    <p class="pm-card__addr">四日市市本郷町1-7 グリーンベル1F</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">kujiraドライブイン</p>
                    <p class="pm-card__addr">四日市市松原町1-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">マーブルラパン</p>
                    <p class="pm-card__addr">鈴鹿市中旭が丘3丁目10-26</p>
                </div>
            </div>
            <!- <p class="pm-event__flyer"><a href="#" target="_blank" rel="noopener"><i class="fa-solid fa-file-arrow-down" aria-hidden="true"></i> チラシのダウンロード</a></p> -
        </div>
    </div>
</article>-

<article class="pm-event card card-radius-lg card-shadow-sm">
    <div class="pm-event__body">
        <p class="pm-event__date"><i class="fa-solid fa-bread-slice"></i> 4月11日<span class="pm-sat">（土）</span></p>
        <p class="pm-event__time">一部：11：00～ / 二部：13：30～</p>
        <p class="pm-event__place">場所：松阪競輪場　バンク内</p>
        <p class="pm-event__note">※一部は整理券をお持ちの方のみご参加いただけます。<br>各部整理券を10：00～現地で、先着順にて配布します。</p>
        <button type="button" class="pm-btn pm-btn--detail" aria-expanded="false" aria-controls="pm-event-detail-2">詳細を見る</button>
        <div class="pm-event__detail" id="pm-event-detail-2" hidden>
            <div class="pm-event__detail-title">4月11日（土）出店</div>
            <div class="pm-cards">
                <div class="pm-card">
                    <p class="pm-card__name">パン工房KOKO</p>
                    <p class="pm-card__addr">桑名市西別所296-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">桑ぱん</p>
                    <p class="pm-card__addr">桑名市新西方2-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">Bakery&amp;Cafe かぜのテラス</p>
                    <p class="pm-card__addr">四日市市下海老町字平野109-8</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">クジラドライブイン</p>
                    <p class="pm-card__addr">四日市市松原町1-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">パン屋 Roki</p>
                    <p class="pm-card__addr">四日市市本郷町1-7 グリーンベル1F</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ドミニクドゥーセの店</p>
                    <p class="pm-card__addr">鈴鹿市南江島町17-30</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ブレッド カメイド―</p>
                    <p class="pm-card__addr">松阪市川井町828-7</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ルポッシュ</p>
                    <p class="pm-card__addr">鈴鹿市西条4丁目10 マルカビルディングD1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">コーヴォペイン</p>
                    <p class="pm-card__addr">津市大谷89-15</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ギャルソン・ドール</p>
                    <p class="pm-card__addr">津市一身田上津部田1470-17</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ラ・ミシェット</p>
                    <p class="pm-card__addr">津市久居西鷹跡町364-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">わしの津こっぺ</p>
                    <p class="pm-card__addr">津市久居本町1396-2</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">トルタロッソ</p>
                    <p class="pm-card__addr">伊賀市下友田1371</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">NOKOTOKO</p>
                    <p class="pm-card__addr">多気郡多気町相可127</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">コクリコ ルージュ</p>
                    <p class="pm-card__addr">伊勢市御薗町王中島字垣溝766</p>
                </div>
            </div>
            <p class="pm-event__flyer"><a href="/special/photos/pan0411.pdf" target="_blank" rel="noopener"><i class="fa-solid fa-file-arrow-down" aria-hidden="true"></i> チラシのダウンロード</a></p>
        </div>
    </div>
</article>-->
<!--
<article class="pm-event card card-radius-lg card-shadow-sm">
    <div class="pm-event__body">
        <p class="pm-event__date"><i class="fa-solid fa-bread-slice"></i> 5月3日<span class="pm-sun">（日）</span></p>
        <p class="pm-event__time">第1部 10:00～ / 第2部 13:30～</p>
        <p class="pm-event__place">場所：イオンタウン四日市泊1F イベント広場（四日市市泊小柳町4番5-1号）</p>
        <p class="pm-event__note">※第1部で列にお並びいただき、入場できなかった方には第2部に優先入場いただける整理券を配布いたします。</p>
        <button type="button" class="pm-btn pm-btn--detail" aria-expanded="false" aria-controls="pm-event-detail-3">詳細を見る</button>
        <div class="pm-event__detail" id="pm-event-detail-3" hidden>
            <div class="pm-event__detail-title">5月3日（日）出店</div>
            <div class="pm-cards">
                <div class="pm-card">
                    <p class="pm-card__name">トルタロッソ</p>
                    <p class="pm-card__addr">伊賀市下友田1371</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">アトリエ ウフ</p>
                    <p class="pm-card__addr">伊賀市土橋741</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">コクリコルージュ</p>
                    <p class="pm-card__addr">伊勢市御薗町王中島字垣溝766</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">桑ぱん</p>
                    <p class="pm-card__addr">桑名市新西方2-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">パン工房KOKO</p>
                    <p class="pm-card__addr">桑名市西別所296-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ルポッシュ</p>
                    <p class="pm-card__addr">鈴鹿市西条4丁目10</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">ドミニクドゥーセの店</p>
                    <p class="pm-card__addr">鈴鹿市南江島町17-30</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">NOKOTOKO</p>
                    <p class="pm-card__addr">多気郡相可127</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">アトリエ プティタプティ</p>
                    <p class="pm-card__addr">津市安濃町田端上野987-78</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">Chou Chou</p>
                    <p class="pm-card__addr">津市久居野口町2477-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">わしの津コッペ</p>
                    <p class="pm-card__addr">津市久居本町1396-2</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">カサネベーカリー</p>
                    <p class="pm-card__addr">四日市市小古曽5-27-13</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">Bakery&amp;Café かぜのテラス</p>
                    <p class="pm-card__addr">四日市市下海老町字平野109-8</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">kujiraドライブイン</p>
                    <p class="pm-card__addr">四日市市松原町1-1</p>
                </div>
                <div class="pm-card">
                    <p class="pm-card__name">マーブルラパン</p>
                    <p class="pm-card__addr">鈴鹿市中旭が丘3丁目10-26</p>
                </div>
            </div>
            <p class="pm-event__flyer"><a href="/event/panMatsuri/pdf/20260503pan.pdf" target="_blank" rel="noopener"><i class="fa-solid fa-file-arrow-down" aria-hidden="true"></i> チラシのダウンロード</a></p>
        </div>
    </div>
</article>-->

<article class="pm-event card card-radius-lg card-shadow-sm">
    <div class="pm-event__body">
        <p class="pm-event__date"><i class="fa-solid fa-bread-slice"></i> 5月17日<span class="pm-sun">（日）</span></p>
        <p class="pm-event__time">第1部 11時～12時 第2部13時～15時</p>
        <p class="pm-event__place">場所：桑名ハウジングセンター  <br />桑名市江場436 電話番号0594-24-1522（センターハウス）<br />
アクセス 国道258号 桑名警察署交差点から北へ約900ⅿ</p>
        <p class="pm-event__note">※各回パンの販売個数には限りがあります。<br />
※パンの購入には受付で配布される「家サイトパス」が必要となります。<br />
※お支払いは現金とPayPayのみとなります。</p>

        <button type="button" class="pm-btn pm-btn--detail" aria-expanded="false" aria-controls="pm-event-detail-4">詳細を見る</button>
        <div class="pm-event__detail" id="pm-event-detail-4" hidden>
            <div class="pm-event__detail-title">5月17日（日）出店</div>
            <div class="pm-cards">
    <div class="pm-card">
        <p class="pm-card__name">トルタロッソ</p>
        <p class="pm-card__addr">伊賀市下友田1371</p>
    </div>
    <div class="pm-card">
        <p class="pm-card__name">アトリエ ウフ</p>
        <p class="pm-card__addr">伊賀市土橋741</p>
    </div>
    <div class="pm-card">
        <p class="pm-card__name">コクリコルージュ</p>
        <p class="pm-card__addr">伊勢市御薗町王中島字垣溝766</p>
    </div>
    <div class="pm-card">
        <p class="pm-card__name">ヒラノベーカリー</p>
        <p class="pm-card__addr">桑名市多度町小山台1丁目4-18</p>
    </div>
    <div class="pm-card">
        <p class="pm-card__name">ルポッシュ</p>
        <p class="pm-card__addr">鈴鹿市西条4丁目10</p>
    </div>
    <div class="pm-card">
        <p class="pm-card__name">アトリエ プティタプティ</p>
        <p class="pm-card__addr">津市安濃町田端上野987-78</p>
    </div>
    <div class="pm-card">
        <p class="pm-card__name">わしの津コッペ</p>
        <p class="pm-card__addr">津市久居本町1396-2</p>
    </div>
    <div class="pm-card">
        <p class="pm-card__name">ローゼンボルグ</p>
        <p class="pm-card__addr">松阪市中央町453</p>
    </div>
    <div class="pm-card">
        <p class="pm-card__name">カサネベーカリー</p>
        <p class="pm-card__addr">四日市市小古曽5-27-13</p>
    </div>
    <div class="pm-card">
        <p class="pm-card__name">Bakery&amp;Café かぜのテラス</p>
        <p class="pm-card__addr">四日市市下海老町字平野109-8</p>
    </div>
    </div>
    <p>会場の地図</p>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1633.1133766423607!2d136.69101500170046!3d35.05106954639748!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60039ac860b790dd%3A0x9025225710c8f1a4!2z5qGR5ZCN44OP44Km44K444Oz44Kw44K744Oz44K_44O8!5e0!3m2!1sja!2sjp!4v1778148275227!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

           <!-- <p class="pm-event__flyer"><a href="#" target="_blank" rel="noopener"><i class="fa-solid fa-file-arrow-down" aria-hidden="true"></i> チラシのダウンロード</a></p>-->
        </div> 
    </div>
</article>

    <hr class="pm-divider" />

    <section class="pm-section pm-article">
        <img src="images/bosyu.jpg" alt="パンまつり出店者募集" />
        <h2 class="pm-article__title">パン祭り出店者募集</h2>
        <div class="pm-article__body">
            <p class="pm-article__lead">レディオキューブFM三重では、1年を通して三重県内の話題のパン屋さんが一同に会する「パンまつり」を行っています。
            <span class="pm-article__lead-text">そこで、自薦、他薦を問わずリスナーのみなさんからの口コミ情報を募集しています。</span></p>
            <p>エントリーされましたパン屋さんにお声がけさせていただき、ご都合があえば出店していただけます。<br>
            パン屋さんには、イベント用に人員を割いていただく必要はなく、出品分の個数のパンを買取させていただきます。<br />
            <a href="panmaturi.pdf">詳しくはこちら概要書 <i class="fa-solid fa-file-arrow-down"></i></a> にてご確認ください</p>
            <ul class="pm-article__examples">
                <li><i class="fa-solid fa-comment-dots" aria-hidden="true"></i>うちのパン屋ヨロシクお願いします！（自薦）</li>
                <li><i class="fa-solid fa-comment-dots" aria-hidden="true"></i>私の行きつけのパン屋さんがオススメなんです！（他薦）</li>
                <li><i class="fa-solid fa-comment-dots" aria-hidden="true"></i>こぢんまりしてますが念願だった自宅内パン屋をはじめました。（自薦）</li>
                <li><i class="fa-solid fa-comment-dots" aria-hidden="true"></i>我が家の毎日の朝食には〇〇のこのパンが欠かせないんです（他薦）</li>
                <li><i class="fa-solid fa-comment-dots" aria-hidden="true"></i>ちょっと遠いのですが、ここのパンが食べたくて通ってます（他薦）</li>
                <li><i class="fa-solid fa-comment-dots" aria-hidden="true"></i>友達から〇〇のパンが美味しいって聞いて気になってます（他薦）</li>
            </ul>
            <p class="pm-article__closing">などなど、パン屋さん情報を、お寄せください！</p>
        </div>
        <p class="pm-article__cta">
            <a href="message.php" class="pm-btn pm-btn--primary"><i class="fa-solid fa-envelope" aria-hidden="true"></i> 推薦パン屋さん情報を送る</a>
        </p>
    </section>


    <section class="pm-section">
        <div class="pm-qr">
            <a href="https://www.instagram.com/mie_panmatsuri?igsh=ZGFkZmNpM3V0ZGFv&utm_source=qr"><img src="images/qr.jpg" alt="QRコード" width="300"></a>
        </div>
    </section>

</div>

<!-- コンテンツエリア -->
<script>
(function() {
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.pm-btn--detail');
        if (!btn) return;
        var id = btn.getAttribute('aria-controls');
        if (!id) return;
        var detail = document.getElementById(id);
        if (!detail) return;
        var isHidden = detail.hasAttribute('hidden');
        if (isHidden) {
            detail.removeAttribute('hidden');
            btn.setAttribute('aria-expanded', 'true');
            btn.textContent = '詳細を閉じる';
        } else {
            detail.setAttribute('hidden', '');
            btn.setAttribute('aria-expanded', 'false');
            btn.textContent = '詳細を見る';
        }
    });
})();
</script>
<?php require_once(INCLUDE_FOOTER_PATH); ?>
</body>
</html>
