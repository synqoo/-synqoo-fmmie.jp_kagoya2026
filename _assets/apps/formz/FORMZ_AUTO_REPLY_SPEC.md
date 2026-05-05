# Formz 自動返信メール — 実装仕様（引き継ぎ用）

クライアント依頼後の実装開始時に参照する。本書は設計・現状コードに基づく。

---

## 1. 目的

フォーム送信が **RDS 登録まで成功したあと**、**特定のフォームのみ**、入力者（例: `u_email`）へ **カスタム文面**の自動返信メールを送る。

---

## 2. 現在の遷移（`$confirm = 1` の例）

| 段階 | 処理 |
|------|------|
| a | 入力 → バリデーション → 確認画面（`FORMZ_CONFIRM_STEP` 時は `formz_regist.php` が早期 `return`。**この時点では AWS/RDS 本登録はしない**） |
| b | 確認画面から確定 → `formz_regist.php` が本処理 → `awsapi_formz_regist` / `aws_formz_regist`（必要なら `formz_regist_kagoya.php`） |
| c | `complete.php` へ 302 リダイレクト（サンクス） |

`$confirm = 0` の場合も、本登録は同じ `formz_regist.php` 経路に乗る想定。

---

## 3. メール送信のタイミング（必須）

- **場所**: `_assets/apps/formz/formz_regist.php` 内、**外部登録成功直後**、**`complete.php` への `header('Location: …')` より前**。
- **送らない**: 確認画面のみの経路（`FORMZ_CONFIRM_STEP` で `return` する前）、バリデーション失敗時。
- **理由**: 登録済みであること・`$_POST` に全フィールドがあること・二重送信ガード（同一 POST の再処理で登録もメールも再実行しない）との整合。

**サンクスページ `complete.php` 表示時に送らない**: 同ページは主に GET パラメータのみで、POST 全文が無い。直リンク・再訪の扱いも複雑になるため。

---

## 4. ファイル配置（案）

| 役割 | パス |
|------|------|
| 送信処理・テンプレ読込のオーケストレーション | `_assets/apps/formz/formz_auto_reply.php`（既に `formz_mail_send_plain_utf8()` あり） |
| フォーム別テンプレート（1 フォーム 1 ファイル） | `_assets/apps/formz/auto_reply/{fm_id}.php`（**新規ディレクトリ**。番号は `confirm_display/{fm_id}.php` と同じ体系が望ましい） |
| 登録処理への差し込み | `_assets/apps/formz/formz_regist.php`（`require_once` + 1 関数呼び出し程度） |

テンプレートが無い `fm_id` のときは **送信しない（no-op）**。

---

## 5. メール送信の実装方針

- **旧 `synqoomail()`（`functions.php`）は使わない**。デバッグ `echo`、ヘッダと本文の符号化の不整合、グローバルな `mb_internal_encoding` 切り替えなどの理由。
- **本仕様では** `_assets/apps/formz/formz_auto_reply.php` の **`formz_mail_send_plain_utf8()`** を利用する（UTF-8 プレーンテキスト、`mb_language('uni')`、宛先・Envelope From 検証、送信後に mb 設定を復元）。
- `synqoomail()` の改修は **本機能の必須条件ではない**（別用途で使う場合は `echo` 削除とエンコーディング整理を推奨）。

---

## 6. フォーム特定・文面

- **どのフォームで送るか**: `form_id` / `$fm_id`（既存の Formz の識別子）で分岐。
- **文面のカスタム**: `auto_reply/{fm_id}.php` で件名・本文を組み立てる（戻り値や配列の形式は実装時に固定する）。

---

## 7. 失敗時のポリシー（実装時に確定）

- 例: **登録は成功のまま**、メール失敗は `error_log` のみ（ユーザーには従来どおりサンクス）。
- 例: メール失敗時にユーザーへエラー表示 … は **登録ロールバック**等の設計が要るため、採用する場合は別途合意が必要。

---

## 8. 実装タスク checklist（依頼後）

1. `auto_reply/` を作成し、対象 `fm_id` 用テンプレを追加。
2. `formz_auto_reply.php` に「テンプレ存在時のみ `formz_mail_send_plain_utf8` を呼ぶ」エントリ関数を実装（名前は実装時に決定）。
3. `formz_regist.php` の **登録成功ブロック末尾・リダイレクト前** に上記を 1 回呼び出す。
4. ステージングで実送信テスト（宛先・文面・二重送信の有無）。

---

## 9. 参考コード位置

- フォームテンプレ例: `topics/form_cube.php`（`$confirm`、`formz_regist.php` の `include` 順）
- 確認画面カスタムの先例: `_assets/apps/formz/confirm_display/*.php`
- 登録本体: `_assets/apps/formz/formz_regist.php`（`FORMZ_CONFIRM_STEP` の early return、AWS 呼び出し、302）

---

*最終更新: 仕様合意時点（クライアント依頼前のドラフト）*
