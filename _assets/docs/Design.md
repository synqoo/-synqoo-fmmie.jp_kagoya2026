# Design.md — FM三重（fmmie.jp）

## 概要

FM三重（レディオキューブ FM三重）の公式ウェブサイト。三重県内のリスナーに向けた番組情報・タイムテーブル・パーソナリティ紹介を提供するメディアサイト。デザイントークンベースのCSS設計を採用。

---

## CSS ファイル構成

| ファイル | 役割 |
|---|---|
| `/_assets/css/design-tokens.css` | カラー・タイポグラフィ・スペーシングのCSS変数定義 |
| `/_assets/css/utilities.css` | レイアウト・コンポーネント・ユーティリティクラス |

---

## デザイントークン

### カラー — デフォルトテーマ（`:root`）

| トークン名 | 値 | 用途 |
|---|---|---|
| `--primary-light` | `#88fbff` | プライマリ明 |
| `--primary-main` | `#00d0b0` | プライマリ主色（ティール） |
| `--primary-dark` | `rgb(60, 133, 143)` | プライマリ暗 |
| `--primary-title` | `#1497a8` | タイトル用プライマリ |
| `--secondary-light` | `#4478e7` | セカンダリ明 |
| `--secondary-main` | `#5471d1` | セカンダリ主色（ブルー） |
| `--secondary-dark` | `#0e46af` | セカンダリ暗 |

### カラー — ニュートラル（全テーマ共通）

| トークン名 | 値 |
|---|---|
| `--gray-light` | `#FFF7ED` |
| `--gray-medium` | `#F4F8FA` |
| `--gray-dark` | `#78716C` |
| `--black` | `#292524` |
| `--white` | `#FFFFFF` |
| `--link-color` | `#eb6016`（オレンジ） |

### カラー — セマンティックトークン

| トークン名 | 意味 |
|---|---|
| `--bg-body` | ページ背景 |
| `--bg-surface` | カード・パネル背景 |
| `--bg-surface-sub` | サブ背景 |
| `--text-main` | 本文テキスト |
| `--text-muted` | 補足テキスト |
| `--text-on-accent` | アクセント上のテキスト |
| `--accent-primary` | プライマリアクセント |
| `--accent-secondary` | セカンダリアクセント |
| `--border-soft` | 薄いボーダー |
| `--border-strong` | 強いボーダー |
| `--shadow-soft` | ソフトシャドウ |
| `--color-danger` | 危険・エラー色 |

### オプショナルテーマ（クラスで切替）

`fmmie` / `white` / `orange` / `blue` / `purple` / `warm-orange` / `rose`

---

### タイポグラフィ

| トークン名 | 内容 |
|---|---|
| `--font-sans` | サンセリフ |
| `--font-serif` | セリフ |
| `--font-mono` | 等幅 |
| `--font-size-h1` 〜 `--font-size-h6` | 見出しスケール |
| `--font-size-base` | 本文基準サイズ |

**ウェブフォント（ユーティリティクラス）**

| クラス | フォント |
|---|---|
| `.oswald` | Oswald |
| `.kaiso` | 廻想体 |
| `.font-stardos` | Stardos Stencil |
| `.font-kosugi-maru` | Kosugi Maru |
| `.en` | Roboto Flex（欧文） |

---

### スペーシング・レイアウト

| トークン名 | 用途 |
|---|---|
| `--space-xs/sm/md/lg/xl` | 余白スケール |
| `--layout-max-width` | `1240px`（最大幅） |
| `--layout-inline-padding` | 左右パディング |
| `--radius-sm/md/lg` | 角丸スケール |
| `--transition-fast/normal` | アニメーション速度 |

---

## レイアウトコンポーネント

### 構造

```
<header class="globalheader">
  <div class="header-logo-sns"> ロゴ + SNSアイコン群 </div>
  <nav class="global-nav"> TIMETABLE / PROGRAM / PERSONALITY </nav>
</header>

<main>
  [NOW ON AIR] 現在放送中番組
  [TIMETABLE] 曜日タブ + 時間帯ジャンプ + 番組カード一覧
  [PICKUP] 特集コンテンツ
  [POWER PLAY .powerplay-section] 楽曲紹介
  サービス情報
</main>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-top"> ロゴ + .frequency-info </div>
    <div class="footer-bottom"> .footer-links / .company-info </div>
  </div>
  <button class="to-top">▲ ページトップへ</button>
</footer>
```

### レイアウトクラス

| クラス | 説明 |
|---|---|
| `.container` | 最大幅制限コンテナ |
| `.section` | セクション基本 |
| `.stack` / `.stack-xs〜xl` | 縦方向 Flex（ギャップ付き） |
| `.stack-center/start/end` | 縦方向配置調整 |
| `.stack-readable` | 読みやすい幅制限 |
| `.stack-split` | 上下分割 |
| `.cluster` / `.cluster-gap-xs〜xl` | 横方向 Flex |
| `.cluster-center/end/start/between/around/evenly` | 横方向配置調整 |
| `.grid` / `.grid-2〜5` | グリッドレイアウト（2〜5カラム） |

---

## UIコンポーネント

### カード `.card`

| バリアント | クラス |
|---|---|
| ボーダー | `.card-border-light` / `.card-border-strong` |
| シャドウ | `.card-flat` / `.card-shadow-sm/md/lg` |
| カラー | `.card-soft` / `.card-color` / `.card-accent` / `.card-warning` / `.card-danger` |
| 形状 | `.card-radius-sm/md/lg/full` |
| ホバー | `.card-hover-lift` / `.card-hover-glow` / `.card-hover-border` |
| 特殊 | `.card-feature`（アイコン+テキスト）/ `.card-horizontal` / `.card-hero` |

### 番組コンポーネント `.corner`

| 要素 | クラス |
|---|---|
| ヘッダー | `.corner-header` |
| タイトル | `.corner-title` |
| メタ情報 | `.corner-meta` |
| 説明 | `.corner-desc` |
| フッター | `.corner-footer` |
| ラベル | `.corner-label`（`orange/red/green/yellow`） |
| バリアント | `.corner--compact` / `.corner--thumb` |
| レイアウト | `.corner-grid` |

### ボタン `.btn`

| バリアント | クラス |
|---|---|
| サイズ | `.btn-sm` / `.btn-lg` / `.btn-block` |
| カラー | `.btn-primary` / `.btn-secondary` / `.btn-outline` / `.btn-ghost` / `.btn-danger` |
| アイコン | `.btn-icon` |

### SNSアイコン

| クラス | 対応サービス |
|---|---|
| `.sns-icon-x` | X（旧Twitter） |
| `.sns-icon-instagram` | Instagram |
| `.sns-icon-youtube` | YouTube |
| `.sns-icon-radiko` | radiko |

### フォーム

| 要素 | クラス |
|---|---|
| コンテナ | `.form` |
| フィールド | `.form-field` |
| ラベル | `.form-field__label` |
| ヒント | `.form-field__hint` |
| エラー | `.form-field__error` |
| 必須マーク | `.vad` |
| インライン | `.form-inline` |
| チェック/ラジオ | `.form-check-group` / `.form-check` |

### フッター

| 要素 | クラス |
|---|---|
| 企業情報 | `.company-info` |
| コンタクト | `.contact-button` |
| リンク群 | `.footer-links` / `.links-list` |
| 周波数情報 | `.frequency-info` / `.frequency-infoall` |
| カラム | `.link-column` |

---

## ユーティリティ

| クラス | 説明 |
|---|---|
| `.sr-only` | スクリーンリーダー専用（視覚的非表示） |
| `.text-muted` | グレーアウトテキスト |
| `.text-center` / `.center` | センタリング |
| `.prose` | 記事本文リズム（長文用） |
| `.hr-line` | 水平線 |
| `.h3-title` | H3装飾（背景・矢印付き） |
| `.alert-emergency` | 緊急アラートバナー |
| `.msg-card` / `.msg-heading` / `.msg-body` | メッセージページ用 |

---

## SNSシェア

| クラス | 対応 |
|---|---|
| `.entry-sns-share` | シェアセクション |
| `.sns-share-x` | X（旧Twitter） |
| `.sns-share-line` | LINE |

---

## アナリティクス

| サービス | 設定値 |
|---|---|
| Google Analytics | `G-MCDXHQQLYL` |
