# confirm_display 生成依頼テンプレート

`_assets/apps/formz/confirm_display/{form_id}.php` を AI に作成依頼する際のテンプレートです。  
この内容をそのまま貼り付けて、対象フォーム情報だけ差し替えてください。

---

## 依頼テンプレート（コピー用）

```markdown
`/topics/{対象フォーム}.php` を参照して、`/_assets/apps/formz/confirm_display/{form_id}.php` を生成してください。

目的:
- confirm 画面で、入力画面と同じ順序・項目名で表示したい
- 既存の `/_assets/apps/formz/confirm_display/260.php` などと同じ形式にしたい

要件:
1. `display_order`
   - 入力フォームの上から順に、`name` 属性を並べる
   - `hidden` / 送信ボタン系は含めない
2. `label_overrides`
   - 入力画面のラベル文言に合わせる（「必須」などの装飾文言は除く）
3. `value_maps`
   - `radio` / `select` は value と表示文言の対応を作る
   - キーは必ず文字列（例: `'0'`, `'1'`）
4. 返却形式
   - `<?php` + `return [ ... ];` のみ
   - 既存ファイルと同じ配列構造にする

参照:
- `/_assets/apps/formz/confirm_display/README.md`
- `/_assets/apps/formz/confirm_display/260.php`

注意:
- フォーム内で同じ `name` が複数回使われている場合は、確認画面で採用する意図をコメントで明記してください。
```

---

## 依頼時の記入例

- 対象フォーム: `money-seminer01.php`
- form_id: `262`

実際の依頼文:

```markdown
`/topics/money-seminer01.php` を参照して、`/_assets/apps/formz/confirm_display/262.php` を生成してください。
これは、confirm 画面において、入力画面と同じ順序と項目名を参照するためのページです。同階層の `260.php` などを参考にしてください。
```

