# フォーム確認画面（formz_confirm）の表示カスタム

## 目的

`formz_confirm.php` の「入力の確認」テーブルでは、本来 **フィールド名（`name`）** と **POSTされた生の値** に基づいて行を組み立てます。  
`formztemp.csv` の **デフォルト項目名** がプレースホルダ（例: `ex6_select`）のままだったり、**選択肢（`ind`）が数値のまま**（例: `0`）表示されることがあります。

本ディレクトリの **`{form_id}.php`** で、**フォームごと**に「画面に見せる項目名」「選択値の文言」「**行の並び順**」を、実際の HTML フォームに揃えられます。  
（並びのデフォルトは `formztemp.csv` の行順のため、フォーム HTML とずれることがある。）

## 関連コード

| ファイル | 役割 |
|----------|------|
| `_assets/apps/formz/formz_confirm.php` | 確認画面の共通処理。`confirm_display/{form_id}.php` があれば読み込み、表示前にラベル・値を上書きする。 |
| `_assets/apps/formz/confirm_display/{form_id}.php` | その `form_id` 専用の表示マップ（任意）。無ければ従来どおり。 |
| `_assets/apps/formztemp.csv`（または `formz/formztemp.csv`） | 項目番号・デフォルト項目名・**フィールド名（POSTキー）**・型などのマスタ。`viewformztemp()` で読込。 |

フォーム側では hidden の `form_id` が確認画面まで POST される必要があります（例: `suzuka_1.php` の `name="form_id" value="257"`）。

## デフォルトの項目名・値がどう決まるか（フック適用前）

1. **項目名**  
   - 基本: `formztemp.csv` の **2列目（インデックス1）** がフィールド `row[2]` に対するデフォルトラベル。  
   - 上書き: backsites の `{form_id}_setbody.txt`（**項目番号,表示名** の CSV 行）があれば、同じ項目番号のラベルを差し替え。  
2. **値**  
   - 原則: `$_POST[フィールド名]` をそのまま表示（配列は `, ` 連結）。  
   - 特例: フィールド `x_prez` は `{form_id}_prez.txt` で数値→名称に変換（既存仕様）。

## `confirm_display/{form_id}.php` の仕様

### 配置・命名

- パス: `_assets/apps/formz/confirm_display/{form_id}.php`
- `{form_id}` は POST の `form_id` と一致する整数（例: `257.php`）。

### 戻り値

ファイルは **`return [ ... ];` する配列のみ**を返す PHP とする（画面出力なし）。

| キー | 型 | 意味 |
|------|-----|------|
| `display_order` | `list<string>` | **任意。** ここに列挙した **フィールド名** の順に確認行を並べる。`formztemp` にあり POST がある項目だけ出力される。リストに無いが POST がある項目は、その後ろに **従来どおり CSV 順**で続く。未指定時は従来どおり CSV 順のみ。 |
| `label_overrides` | `array<string, string>` | **キー**: `formztemp` のフィールド名（POST の `name` と同じ）。**値**: 確認画面の「項目名称」列に出す文言。 |
| `value_maps` | `array<string, array<string, string>>` | **第1キー**: フィールド名。**第2キー**: POST 値を **文字列化したキー**（例: `'0'`, `'1'`）。**値**: 画面に出す文言。 |

### 適用タイミング（`formz_confirm.php` 内）

1. 各フィールドの表示行（ラベル・値）を組み立てる。  
2. `display_order` がある場合: その順で行を並べ、**まだ出していない**項目を CSV 順で末尾に追加。  
3. ラベルは `fieldLabels` → `_setbody.txt` の後に `label_overrides` で上書き。  
4. 値は配列でない場合のみ `value_maps` を参照（配列フィールドは連結のみ）。  
5. その後、従来どおり `x_prez` 用の `_prez.txt` 変換が走る。

**注意:** `value_maps` のキーは **`(string)$value`** で照合する。フォームの `value="0"` は `'0'` としてマッチさせる。

## 実装例（form_id = 257）

`257.php` — 学ぼう防災・鈴鹿会場フォーム向け。  
`display_order` で `suzuka_1.php` 等の入力順に合わせている。あわせて `x_sel` / `x_bt` / `p_name1` のラベルと選択肢の表示文言を HTML に合わせている。

新しいフォーム用に同様のファイルを追加する場合は、`257.php` をコピーして `form_id` に合わせてリネームし、`display_order` / `label_overrides` / `value_maps` をそのフォームの `name`・並び・選択肢に合わせて編集する。

**補足:** `formztemp.csv` に無い `name`（例: 同意チェックのみの項目）は、現状の確認画面ロジックでは **そもそも行が出ない**。同意文を確認表に出したい場合は別途対応が必要。

## 他の手段との使い分け

| 手段 | できること |
|------|------------|
| `{form_id}_setbody.txt`（リモート） | **項目名のみ**（項目番号単位）。数値→文言の変換はしない。 |
| `formztemp.csv` の2列目を編集 | 全フォーム共通テンプレに影響しうるため、個別フォームの見せ方には不向き。 |
| **本ディレクトリの `{form_id}.php`** | **項目名と値の両方**を、リポジトリ上でバージョン管理しつつフォーム単位に調整可能。 |

## メンテナンス時のチェックリスト

- [ ] フォーム HTML の `name` と `formztemp.csv` の **3列目（フィールド名）** が一致しているか。  
- [ ] ラジオ・セレクトの `value` と `value_maps` のキー（文字列）が一致しているか。  
- [ ] 確認画面を通すフローで `form_id` が POST に含まれているか。  
- [ ] HTML の入力順を変えたら `display_order` も同じ順に更新したか。  

質問・変更があれば `formz_confirm.php` の `confirm_display` 読込ブロック（`$confirmDisplayPath` 付近）を参照すること。

---

## AI／作業者向け：HTML フォームから `confirm_display/{form_id}.php` を生成するプロンプト（コピー用）

以下のブロック全体を、チャット AI やドキュメントに貼り付け、**対象のフォーム HTML**（ファイル内容またはパス）と **`form_id`** を追記して使う。  
生成物は **JSON ではなく PHP** だが、配列の構造は JSON オブジェクトと同じ考え方でよい（`return [ ... ];` 形式で出力させる）。

````markdown
## 依頼内容

このリポジトリの仕様に従い、**フォーム付き HTML** を解析して、確認画面用の PHP ファイル **`_assets/apps/formz/confirm_display/{form_id}.php`** の中身を生成してください。

### 仕様の前提（必ず守る）

1. ファイルは **PHP のみ**。先頭に短いドキュメントコメント、本文は **`return [ ... ];` だけ**（`<?php` は付けてよい。HTML 出力・exit 禁止）。
2. 返す配列のトップレベルキーは次の3つだけ使う（不要なキーは省略可）:
   - **`display_order`**: 文字列の配列。各要素は `input` / `select` / `textarea` の **`name` 属性**（POST キー）。**フォーム上の表示順（上から下）**で列挙する。
   - **`label_overrides`**: 連想配列。キー = フィールド名（`name`）、値 = 確認画面「項目名称」に出す文言（HTML の `label` 文言に合わせる。`必須` バッジ等は除く）。
   - **`value_maps`**: 連想配列の入れ子。キー = フィールド名。値 = **POST 値（必ず文字列キー）** → 画面表示文言。`<select>` の各 `option`、`type="radio"` の各選択肢について、`value` とユーザーに見えているラベルテキストの対応をすべて書く。
3. **`value_maps` の内側のキーは必ず文字列**（例: `'0'`  not 数値 0）。PHP では `'0' => '１年生'` のように記述する。
4. 次は **`display_order` に含めない**（確認画面では別扱いまたは非表示のため）:
   - `type="hidden"` の項目
   - `type="submit"` / 送信ボタンの `name`
   - `formztemp.csv` に存在しない `name`（同意チェックのみ等）は、現行の `formz_confirm.php` では行として出ないため、配列には含めないでよい。必要ならコメントで「CSV に無いため未対応」と書く。
5. **`formztemp.csv` の3列目（フィールド名）** と HTML の `name` が一致している項目だけが確認画面に出る。不一致がある場合はコメントで警告を書く。
6. ラベルが `label[for]` で結ばれている場合はそのテキストを優先。ラジオ群はグループ先頭の見出しラベル（親の `form-field` 等）を `label_overrides` に使う。

### 入力（ここを埋める）

- **form_id**: （例: 257）
- **フォーム HTML**: （ファイル全文、または `<form>` ～ `</form>` まで貼り付け）
- **補足**（任意）: 会場名・ページ名などファイルコメント用

### 期待する出力

1. 保存パス: `_assets/apps/formz/confirm_display/{form_id}.php`
2. 完全なファイル内容（コピーしてそのまま保存できる形）
3. `display_order` が HTML の入力コントロールの順と一致していること
4. プレースホルダ的な CSV デフォルト名（ex6_select 等）に依存せず、HTML に合わせた `label_overrides` / `value_maps` があること

### 参照ドキュメント

リポジトリ内 `_assets/apps/formz/confirm_display/README.md` の「戻り値」「適用タイミング」「注意」を前提とする。
````

### 使い方のメモ

- 先に **`form_id`** と **hidden の `name="form_id"`** がフォームと一致していることを確認する。
- 生成後は **`php -l`** で構文チェックし、実際に確認画面へ進んで行順・文言を目視確認する。
- 中間成果物として **JSON を一度出力させ、その構造をそのまま PHP の `return` に写す**運用でもよい（キーはすべて文字列に揃える）。
