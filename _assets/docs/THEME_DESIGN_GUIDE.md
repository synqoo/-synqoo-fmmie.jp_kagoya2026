# テーマ配色デザインスキーム決定ガイド

## 📋 決めるべき項目

### 1. **基本カラーパレット（各テーマごと）**

各テーマには以下の6つの色が必要です：

#### Primary（プライマリカラー）3色
- **`primary-light`**: 明るい色（グラデーションの開始、ホバー背景など）
- **`primary-main`**: メインカラー（ボタン、リンク、アクセントなど）
- **`primary-dark`**: 濃い色（ホバー時のボタン、強調表示など）

#### Secondary（セカンダリカラー）3色
- **`secondary-light`**: 明るい色（SVG背景のグラデーションなど）
- **`secondary-main`**: メインカラー（SVG背景、補助アクセントなど）
- **`secondary-dark`**: 濃い色（SVG背景のグラデーションなど）

### 2. **使用箇所の決定**

テーマカラーが適用される箇所：

- **ボタン（`.btn-primary`）**: `primary-main` → ホバー時 `primary-dark`
- **リンク（`a`）**: `primary-main` → ホバー時 `primary-dark`
- **カードアクセント（`.card-accent`）**: `primary-main`
- **ボタン（`.btn-secondary`, `.btn-outline`, `.btn-ghost`）**: ホバー時に `primary-light` と `primary-main` を使用
- **SVG背景**: `primary` と `secondary` のグラデーション
- **既存のアクセントカラー（`--color-accent`）**: `primary-main` にマッピング

### 3. **コントラスト比の確認**

- **WCAG 2.1 AA基準**: テキストと背景のコントラスト比は4.5:1以上
- **ボタン**: 白文字（`#fff`）とのコントラスト比を確認
- **リンク**: 背景色とのコントラスト比を確認

### 4. **テーマ数の決定**

現在は6テーマ（オレンジ、ブルー、グリーン、パープル、ピンク、ティール）
- 追加・削除・変更が可能
- ブランドカラーに合わせて調整

---

## 🔧 改定すべきファイルと箇所

### 1. **テーマ定義の変更** 
**ファイル**: `_assets/js/theme-switcher.js`

**箇所**: 9-34行目の `themes` オブジェクト

```javascript
const themes = {
  orange: {
    primary: ['#FFB366', '#FFA347', '#FF8C42'],  // [light, main, dark]
    secondary: ['#FF7B7B', '#FF6B6B', '#FF5C5C']  // [light, main, dark]
  },
  // 他のテーマ...
};
```

**変更方法**:
- テーマを追加: 新しいオブジェクトを追加
- テーマを削除: 該当オブジェクトを削除
- 色を変更: 配列の色コードを変更

### 2. **デフォルトテーマの設定**
**ファイル**: `_assets/css/design-tokens.css`

**箇所**: 78-88行目のテーマ変数定義

```css
/* デフォルトテーマ: オレンジ（既存のブランドカラーに基づく） */
--primary-light: #FFB366;
--primary-main: #FFA347;
--primary-dark: #FF8C42;
--secondary-light: #FF7B7B;
--secondary-main: #FF6B6B;
--secondary-dark: #FF5C5C;
```

**変更方法**:
- デフォルトテーマの色を変更
- 既存のブランドカラー（`--brand-blue`など）に合わせて調整

### 3. **テーマパネルのボタン色**
**ファイル**: `_assets/css/theme-switcher.css`

**箇所**: 64-70行目のテーマボタンのグラデーション

```css
.theme-orange { background: linear-gradient(135deg, #FFB366, #FF8C42); }
.theme-blue { background: linear-gradient(135deg, #66B3FF, #4285FF); }
/* 他のテーマ... */
```

**変更方法**:
- 各テーマボタンのグラデーション色を変更
- `primary-light` と `primary-dark` を使用

### 4. **初期テーマの設定**
**ファイル**: `_assets/js/theme-switcher.js`

**箇所**: 100行目付近の `init()` 関数内

```javascript
let savedTheme = 'orange'; // デフォルトテーマ名
```

**変更方法**:
- デフォルトで表示したいテーマ名に変更

---

## 📝 デザインスキーム決定の手順

### Step 1: ブランドカラーの確認
1. 既存のブランドカラー（`design-tokens.css`の`--brand-*`）を確認
2. メインカラーを決定（例: `--brand-blue: #4E7AFF`）

### Step 2: カラーパレットの作成
1. **Primaryカラー3色を作成**
   - メインカラーを基準に、明るい色と濃い色を生成
   - ツール: [Coolors](https://coolors.co/), [Adobe Color](https://color.adobe.com/)
   - 例: `#4E7AFF` → `#7BA3FF` (light), `#4E7AFF` (main), `#2E5ACC` (dark)

2. **Secondaryカラー3色を作成**
   - Primaryと調和する色を選択
   - 補色、類似色、またはブランドカラーの組み合わせ

### Step 3: コントラスト比の確認
1. [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)で確認
2. 白文字（`#fff`）とのコントラスト比が4.5:1以上であることを確認
3. 不十分な場合は色を調整

### Step 4: 実装
1. `theme-switcher.js`の`themes`オブジェクトに追加
2. `theme-switcher.css`のテーマボタンにグラデーションを追加
3. `design-tokens.css`のデフォルト値を更新（必要に応じて）

### Step 5: テスト
1. ブラウザでテーマを切り替えて確認
2. ボタン、リンク、カードなどの表示を確認
3. SVG背景の色が正しく変更されることを確認
4. コントラスト比を再確認

---

## 🎨 実装例：FM三重のブランドカラーに基づくテーマ

### オレンジテーマ（既存ブランドカラー）
```javascript
orange: {
  primary: ['#FFB366', '#F8772E', '#E85D1A'],  // brand-orangeベース
  secondary: ['#FF7B7B', '#FF6B6B', '#E23C39']  // brand-redベース
}
```

### ブルーテーマ（既存ブランドカラー）
```javascript
blue: {
  primary: ['#7BA3FF', '#4E7AFF', '#2E5ACC'],  // brand-blueベース
  secondary: ['#66B3FF', '#4E7AFF', '#2E5ACC']
}
```

---

## 📌 チェックリスト

- [ ] 各テーマのPrimaryカラー3色を決定
- [ ] 各テーマのSecondaryカラー3色を決定
- [ ] コントラスト比を確認（WCAG 2.1 AA基準）
- [ ] `theme-switcher.js`の`themes`オブジェクトを更新
- [ ] `theme-switcher.css`のテーマボタンを更新
- [ ] `design-tokens.css`のデフォルト値を更新
- [ ] ブラウザで動作確認
- [ ] すべてのコンポーネントで色が正しく表示されることを確認

---

## 💡 ヒント

1. **色の選び方**
   - 既存のブランドカラーを基準にする
   - 色相環を参考に調和する色を選ぶ
   - 明度と彩度を調整してバリエーションを作る

2. **命名規則**
   - テーマ名は英語で統一（`orange`, `blue`など）
   - 色の明度は `light` < `main` < `dark` の順

3. **アクセシビリティ**
   - コントラスト比を必ず確認
   - 色だけでなく、アイコンやテキストでも情報を伝える

