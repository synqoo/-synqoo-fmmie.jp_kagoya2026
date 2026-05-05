# `:root`カラー定義の整理レビュー

## 🔍 発見された問題点

### 1. **テーマカラーの値が間違っている**
**問題**: 11-12行目の`--primary-*`と`--secondary-*`がブルーになっているが、コメントでは「オレンジ」と記載されている。

```css
/* デフォルトテーマ: オレンジ（既存のブランドカラーに基づく） */
--primary-light: #66B3FF; --primary-main: #4785FF; --primary-dark: #4285FF; 
--secondary-light: #7B9BFF; --secondary-main: #6B8BFF; --secondary-dark: #5C7BFF;
```

**正しい値（オレンジテーマ）**:
```css
--primary-light: #FFB366;
--primary-main: #FFA347;
--primary-dark: #FF8C42;
--secondary-light: #FF7B7B;
--secondary-main: #FF6B6B;
--secondary-dark: #FF5C5C;
```

### 2. **未定義の変数を参照している**
**問題**: 以下の変数が定義されていないのに参照されている。

- `--color-warm-white` (42行目: `--bg-body`)
- `--color-sofa-beige` (43行目: `--bg-surface`)
- `--color-wall-blue` (44行目: `--bg-surface-sub`)
- `--color-wood-brown` (53行目: `--accent-secondary`, 57行目: `--border-strong`)
- `--color-accent-rose` (52行目: `--accent-primary`)

**影響**: これらの変数を使用している箇所で正しく動作しない可能性がある。

### 3. **未使用の変数**
**問題**: 定義されているが使用されていない変数。

- `--link-color: #EA580C;` (21行目)
  - 実際には`--primary-dark`を使用している

### 4. **重複・矛盾している定義**
**問題**: 
- `--color-accent`が`--brand-blue`を参照しているが、テーマシステムでは`--primary-main`を使うべき
- `--accent-primary`と`--accent-secondary`が未定義の変数を参照している

### 5. **ダークモードでの`--primary-*`の扱い**
**問題**: ダークモードで`--primary-*`と`--secondary-*`が定義されていない。
- テーマシステムが動的に変更するため、ダークモードでもテーマカラーが適用されるべき

## 📋 整理提案

### 提案1: テーマカラーの値を修正
```css
/* デフォルトテーマ: オレンジ（既存のブランドカラーに基づく） */
--primary-light: #FFB366;
--primary-main: #FFA347;
--primary-dark: #FF8C42;
--secondary-light: #FF7B7B;
--secondary-main: #FF6B6B;
--secondary-dark: #FF5C5C;
```

### 提案2: `--color-accent`を`--primary-main`に統一
```css
--color-accent: var(--primary-main, var(--brand-blue));
--color-accent-soft: rgba(255, 163, 71, 0.12); /* primary-mainベース */
```

### 提案3: 未定義の変数を削除または定義
**オプションA: 削除する（未使用の場合）**
```css
/* 以下を削除 */
--bg-body: var(--color-warm-white);
--bg-surface: var(--color-sofa-beige);
--bg-surface-sub: var(--color-wall-blue);
--accent-primary: var(--color-accent-rose);
--accent-secondary: var(--color-wood-brown);
--border-strong: var(--color-wood-brown);
```

**オプションB: 既存の変数に置き換える**
```css
--bg-body: var(--color-bg);
--bg-surface: var(--color-bg-elevated);
--bg-surface-sub: var(--color-bg);
--accent-primary: var(--primary-main);
--accent-secondary: var(--secondary-main);
--border-strong: var(--color-border);
```

### 提案4: 未使用の変数を削除
```css
/* 削除 */
--link-color: #EA580C;
```

### 提案5: ダークモードでのテーマカラー
ダークモードでもテーマシステムが動作するため、`--primary-*`と`--secondary-*`は定義不要。
ただし、`--color-accent-soft`の色はダークモード用に調整が必要な場合がある。

## 🎯 推奨される整理方針

1. **テーマカラーの値を正しいオレンジに修正**
2. **`--color-accent`を`--primary-main`に統一**
3. **未定義の変数を削除または既存変数に置き換え**
4. **未使用の`--link-color`を削除**
5. **ダークモードではテーマシステムに任せる（追加定義不要）**

