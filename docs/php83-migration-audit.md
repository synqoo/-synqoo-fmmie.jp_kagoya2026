# PHP 7.2 → 8.3.36 移行：ソース互換性調査

**調査日**: 2026-10-30  
**対象リポジトリ**

| パス | 範囲 |
|------|------|
| `fmmie.jp_kagoya_2026` | 公開サイト PHP 一式 |
| `fmmie.jp_kagoya_backsite/_tools` | バックサイト稼働中コード（formin / setup / alas-watch 等） |

**対象外（今回の結論から除外）**

- `fmmie.jp_kagoya_backsite` 直下の旧 formz / bannerz 等（未稼働のためコードレビュー対象外）
- phpMyAdmin / WordPress / Movable Type 本体（別製品の版上げ・設定が必要）

**調査方法**

- ローカル PHP 8.3.30 で全対象 `.php` の `php -l`（構文チェック）
- 削除 API（`mysql_*` / `get_magic_quotes_gpc` / `mb_ereg_*` 等）の静的検索
- 実行時互換の目視確認

**ソース改変**: 未実施（本ドキュメントは調査結果のみ）

---

## 調査サマリ

| 領域 | 変更必須（日常運用） |
|------|----------------------|
| 公開サイト `kagoya_2026` | **原則なし**（DB 置換ユーティリティ実行時のみ例外） |
| バックサイト `_tools` | **`_tools` 内 PHP 単体では必須修正なし** |

`_tools/formin` は DB 接続のため `backsite/admin_functions.php` を `require` する。**`_tools` 外のファイルだが、formin 稼働に同梱される依存**（後述「推奨」参照）。

---

## 1. 変更必須

PHP 8.3 で該当コードを**実行した場合に Fatal 等で停止する**もの。

### 1.1 公開サイト（`fmmie.jp_kagoya_2026`）

| ファイル | 内容 | いつ問題になるか |
|----------|------|------------------|
| `_assets/apps/searchreplacedb2.php` | **`mysql_*` 拡張前提**の DB 検索置換ツール（Interconnect IT 系） | **メンテナンスで本スクリプトを実行するときのみ** Fatal。通常のページ表示・フォーム送信経路には含まれない |

上記以外の公開サイト PHP（139 ファイル）は、構文チェック上 8.3 問題なし。削除済み API の**稼働経路上の使用は検出されず**（`gpc_stripslashes()` は magic_quotes 分岐をコメントアウト済み）。

### 1.2 バックサイト `_tools`

| 判定 |
|------|
| `_tools` 配下 41 PHP ファイルに、`get_magic_quotes_gpc` / `mysql_*` / `mb_ereg_*` / `create_function` / `each()` 等の**削除 API の使用なし** |

**結論**: `_tools` 内ソースだけを見れば、**PHP 8.3 向けの必須コード変更は不要**。

---

## 2. 変更推奨（動作はするが、移転前後で直すとよい）

### 2.1 公開サイト（`fmmie.jp_kagoya_2026`）

| 項目 | ファイル例 | 理由 |
|------|-----------|------|
| `lastRSS` の動的プロパティ | `_assets/apps/lastRSS.php` | PHP 8.2+ で **Deprecated**（`fetch_program_rdf.php` 等で利用）。ログ増加の可能性 |
| `unserialize()` に `allowed_classes` 未指定 | `lastRSS.php`（RSS キャッシュ） | 互換は取れるが **セキュリティ上の推奨** |
| 関数シグネチャ（省略引数の後に必須引数） | `searchreplacedb2.php`、`formz/formz_auto_reply.php` 等 | PHP 8.0+ **Deprecated**（8.3 でも実行可） |
| HTTP 取得依存 | `profiles/message.php`（reCAPTCHA）、`lastRSS` / RSS 取得 | **`allow_url_fopen` や外向き通信**に依存（8.3 固有ではないが新サーバで落ちやすい） |
| 絶対パス | `formz/formz_regist.php` の `IMAGES_DIR` 等 | PHP 版ではなく **サーバパス移転**の作業 |
| DB 接続ヘルパ | `_assets/apps/functions.php` の `connectKami()` | 未使用に近いが、残す場合は `$ecode` 未初期化・接続失敗時の扱い整理を推奨 |

### 2.2 バックサイト `_tools`

| 項目 | 内容 | 理由 |
|------|------|------|
| **`admin_functions.php` 依存** | `formin/lib/ui_bootstrap.php`・`formin/lib/bootstrap.php` が `../../../admin_functions.php` を require。`formin_db()` → `connectKami()` | `_tools` 単体ではないが **formin 稼働に必要**。同ファイル内の `gpc_stripslashes()` が `get_magic_quotes_gpc()` を呼ぶため、**他処理から `gpc_stripslashes` が呼ばれた場合** PHP 8 で Fatal（formin 本体からの直接呼び出しはなし）。公開側と同様「常に `$st` を返す」実装への統一を推奨 |
| `connectKami()` のエラー処理 | 上記 `admin_functions.php` | 成功時 `$ecode` 未初期化、失敗時の `$mysqli->query` 等。Warning / 論理不整合になりやすい |
| 将来 `_tools` へ DB 接続を内包 | `formin/lib/db.php` | `admin_functions.php` への依存をやめれば、旧 backsite ファイルと切り離しやすい |

`_tools` 内の formin / alas-watch / setup_* は **`declare(strict_types=1)` + mysqli** 中心で、7.2 時代の典型的な非互換パターンは少ない。

### 2.3 サーバ・拡張（コード以外）

移転時に合わせて確認。

| 種別 | 内容 |
|------|------|
| PHP 拡張 | `mysqli`, `mbstring`, `json`, `curl`（formin API）, `gd`（フォーム画像）, `zip` + `libxml`（DOCX）, `openssl` |
| php.ini | `allow_url_fopen`（RSS / reCAPTCHA 等）、セッション、メール（`mb_send_mail` / sendmail） |
| サードパーティ | phpMyAdmin・WordPress・Movable Type は各製品の **PHP 8.3 対応版**を別途用意 |

---

## 3. 移転後の確認提案（チェックリスト）

- [ ] 公開サイト：トップ、番組ページ、タイムテーブル、フォーム（入力→確認→完了）
- [ ] `fetch_program_rdf.php` / RSS 連携（cron がある場合）
- [ ] `_tools/formin`：一覧、詳細、エクスポート、API（中継・受信）
- [ ] `_tools/setup_profile.php` / `setup_topbannerz.php`（利用する場合）
- [ ] `_tools/alas-watch`（cron がある場合）
- [ ] エラーログに Deprecated（`lastRSS` 動的プロパティ等）が出ていないか

---

## 4. 参考：必須扱いから外したもの（旧 backsite）

以下は **未稼働の旧ファイル**のため、本調査の対象外とした。

- `bannerz/bannerz_update.php`（`mb_ereg_replace`）
- `formz/listchk.php`（`mysql_num_rows`）
- `bannerz/bn.php`（`mysql_*`）
- 旧 `formz/*.php` 内の `mysql_*` コメント／残骸

---

## 改訂履歴

| 日付 | 内容 |
|------|------|
| 2026-10-30 | 初版（旧 backsite 除外、`_tools` のみに scope 整理） |
