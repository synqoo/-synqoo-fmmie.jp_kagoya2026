# プログラム／特設ページ用「記事レイアウト」生成プロンプト

Movable Type のトップページテンプレートの「ここに自由にコンテンツ」部分（約50行目付近）に差し込む HTML＋CSS を AI（Claude 等）に生成させるためのプロンプトです。  
以下をそのままコピーし、**「あなたの原稿・要件」** のところに具体的な内容を書いてから AI に投げてください。

---

## プロンプト（コピー用）

```
あなたは、ラジオ局サイトのプログラム／特設ページの「記事エリア」をレイアウト・デザインする担当です。

【差し込まれる場所】
次の HTML の「＝＝＝ここに自由にコンテンツ＝＝＝」の部分に、生成したマークアップをそのまま貼り付けます。
既存のラッパーは次のとおりです。

```html
<div class="entry-card stack">
  <div id="index-main" class="main" role="main">
    <article class="card stack stack-sm card-color-nomargin">
      <h2 class="entry-title"></h2>
      <div class="entry-excerpt">
        ＝＝＝ここに自由にコンテンツ＝＝＝
      </div>
    </article>
  </div>
</div>
```

【必須ルール】
1. **CSS の利用**
   - 基本スタイルは、サイトで読み込んでいる **design-tokens.css** の CSS 変数を使う。
   - 使用する変数の例：`--text-main`, `--text-muted`, `--bg-surface`, `--accent-primary`, `--primary-main`, `--secondary-main`, `--font-size-base`, `--font-size-h2`, `--font-size-h3`, `--space-md`, `--space-lg`, `--radius-md`, `--shadow-soft`, `--border-soft`, `--link-color` など。
   - 文字色・テーブル・カード・余白など、独自にデザインする部分は、コンテンツの**いちばん上**に `<style>...</style>` を1つだけ置き、その中に記述する。

2. **ページの基本**
   - 背景は **白（#fff または var(--white) / var(--color-bg)）** を基本とする。
   - **極端に小さい文字は使わない**。本文は `var(--font-size-base)` 以上、見出しは `var(--font-size-h2)` / `var(--font-size-h3)` を活用する。

3. **画像のプレースホルダー**
   - 原稿に「<<画像>>」と書かれている箇所は、**&lt;img src="#" alt="（説明）" /&gt;** のように img タグで出力する（後で src を差し替える想定）。

4. **レスポンシブ**
   - レイアウトはレスポンシブにすること。必要に応じて `clamp()` や `%`、`max-width`、メディアクエリ `@media (max-width: 768px)` などを用いる。
   - 画像は `max-width: 100%` と `height: auto` を指定する。

5. **マークアップ**
   - セマンティックに書く（見出しは h2/h3、段落は p、リストは ul/ol、表は table など）。
   - 既存の `.entry-excerpt` の直下に置くため、**&lt;style&gt; 1つ ＋ 本文のブロック** という構成でよい。

【あなたの原稿・要件】
（ここに、ページの目的・見出し・本文・「ここに画像」「ここに表」などの指示を書く）

上記ルールに従い、「＝＝＝ここに自由にコンテンツ＝＝＝」の部分に貼り付ける **HTML（&lt;style&gt; 含む）** のみを出力してください。説明は不要です。
```

---

## 原稿例（「あなたの原稿・要件」に書くときの例）

- 「番組の紹介文を3段落で。最初に<<画像>>を1枚。見出しは「番組について」」
- 「出演者一覧を表で。列は名前・担当・コメント。その上に<<画像>>。カード風に見せる」
- 「放送時間・パーソナリティ・概要の3ブロックをカードで並べ、スマホでは縦1列に」

---

## 参照：design-tokens.css で使える主な変数

| 用途 | 変数例 |
|------|--------|
| 文字色 | `--text-main`, `--text-muted`, `--black` |
| 背景 | `--bg-body`, `--bg-surface`, `--white`, `--gray-light`, `--gray-medium` |
| アクセント | `--accent-primary`, `--primary-main`, `--secondary-main`, `--link-color` |
| フォントサイズ | `--font-size-base`, `--font-size-h1`〜`--font-size-h6` |
| 余白 | `--space-xs`, `--space-sm`, `--space-md`, `--space-lg`, `--space-xl` |
| レイアウト | `--layout-max-width`, `--layout-inline-padding` |
| 角丸・影 | `--radius-sm`, `--radius-md`, `--radius-lg`, `--shadow-soft` |
| 枠線 | `--border-soft`, `--border-strong`, `--color-border` |

※ 既存の `mt-core.css` で `.card`, `.stack`, `.entry-title`, `.entry-excerpt` などが定義されているため、クラス名を増やしすぎず、必要なら `.entry-excerpt` 内の子要素にクラスを付けてスタイルするのがよい。
