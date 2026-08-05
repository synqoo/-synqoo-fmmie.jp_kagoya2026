<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>デジタルチケット利用方法</title>
<style>
  :root {
    --main-bg: #ffffff;
    --header-bg: #1a73e8;
    --text-color: #202124;
    --sub-text: #5f6368;
    --border-color: #e0e0e0;
    --max-width: 720px;
  }

  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: "Hiragino Kaku Gothic ProN", "Noto Sans JP", "Yu Gothic", sans-serif;
    background-color: #f5f6f7;
    color: var(--text-color);
    line-height: 1.7;
  }

  header {
    background-color: var(--header-bg);
    color: #fff;
    padding: 20px 16px;
    text-align: center;
  }

  header h1 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 700;
  }

  main {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 24px 16px 64px;
  }

  .page-title {
    text-align: center;
    margin-bottom: 8px;
  }

  .page-title h2 {
    font-size: 1.1rem;
    color: var(--sub-text);
    font-weight: 500;
    margin: 0 0 24px;
  }

  .section-title {
    font-size: 1.3rem;
    font-weight: 700;
    border-left: 6px solid var(--header-bg);
    padding-left: 12px;
    margin: 32px 0 20px;
  }

  .step {
    background-color: var(--main-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    margin-bottom: 28px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
  }

  .step-number {
    display: inline-block;
    background-color: var(--header-bg);
    color: #fff;
    font-weight: 700;
    font-size: 0.85rem;
    padding: 3px 10px;
    border-radius: 4px;
    margin: 12px 0 0 12px;
  }

  .step img {
    display: block;
    width: 100%;
    height: auto;
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    margin-top: 12px;
    background-color: #fafafa;
  }

  .step p {
    padding: 14px 16px;
    margin: 0;
    font-size: 0.95rem;
  }

  footer {
    text-align: center;
    color: var(--sub-text);
    font-size: 0.8rem;
    padding: 24px 16px;
  }
</style>
</head>
<body>

<header>
  <h1>デジタルチケット利用方法</h1>
</header>

<main>
  <div class="page-title">
    <h2>【使い方】お客様側の、スマホ画面遷移</h2>
  </div>

  <div class="step">
    <span class="step-number">STEP 1</span>
    <img src="images/step1.jpg" alt="リッチメニュー画面">
    <p>リッチメニュー ＞ 左下ブルーの【イベントチケット、Xチケットご購入はこちら】をタップ</p>
  </div>

  <div class="step">
    <span class="step-number">STEP 2</span>
    <img src="images/step2.jpg" alt="マイチケット画面">
    <p>チケットを既に購入しているお客様は、画面上部の【マイチケット】を押す。</p>
  </div>

  <div class="step">
    <span class="step-number">STEP 3</span>
    <img src="images/step3.jpg" alt="購入済みチケット一覧画面">
    <p>購入済みのチケット一覧から使用したいチケットをタップ。</p>
  </div>

  <div class="step">
    <span class="step-number">STEP 4</span>
    <img src="images/step4.jpg" alt="チケット使用枚数選択画面">
    <p>①【使用する】を選択。②使用するチケット枚数を選択。③【確定する】を押す。</p>
  </div>

  <div class="step">
    <span class="step-number">STEP 5</span>
    <img src="images/step5.jpg" alt="QRコード読み取り画面">
    <p>【カメラへ】を押したらスマホのカメラが起動するので、使用したい店舗のQRコードを読み込む。</p>
  </div>

  <div class="step">
    <span class="step-number">STEP 6</span>
    <img src="images/step6.jpg" alt="店舗名・枚数確認画面">
    <p>店舗名、使用するチケット枚数を選択して合っていたら、【チケットを使用する】を押す。</p>
  </div>

  <div class="step">
    <span class="step-number">STEP 7</span>
    <img src="images/step7.jpg" alt="ダブルチェック画面">
    <p>ダブルチェック画面、再度、店舗名、使用するチケット枚数が合っていたら、【決定する】を押す。</p>
  </div>

  <div class="step">
    <span class="step-number">STEP 8</span>
    <img src="images/step8.jpg" alt="完了画面">
    <p>この画面が出てきたら完了。</p>
  </div>
</main>

<footer>
  デジタルチケット利用方法
</footer>

</body>
</html>
