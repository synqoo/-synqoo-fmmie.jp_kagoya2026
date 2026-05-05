<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UIカラーテーマ集 - 追加5パターン</title>
  <?php include '../_include_htmlhead.php'; ?>
  <script crossorigin src="https://cdnjs.cloudflare.com/ajax/libs/react/18.2.0/umd/react.production.min.js"></script>
  <script crossorigin src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/18.2.0/umd/react-dom.production.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/7.23.5/babel.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      margin: 0;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
    }
  </style>
</head>
<body>
  <?php include '../_include_globalheader.php'; ?>
  <div id="root"></div>

  <script type="text/babel">
    const { useState } = React;

    // Lucide アイコンの代替（SVGで直接定義）
    const Palette = ({ className, style }) => (
      <svg className={className} style={style} fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
      </svg>
    );

    const Check = ({ className, style }) => (
      <svg className={className} style={style} fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
      </svg>
    );

    const ColorThemes = () => {
      const [selectedTheme, setSelectedTheme] = useState(0);

      const themes = [
        {
          name: "コーポレートレッド",
          description: "力強さと情熱を表現する企業・金融サイト向けテーマ",
          primary: {
            main: "#DC2626",
            light: "#F87171",
            dark: "#991B1B"
          },
          secondary: {
            main: "#0F172A",
            light: "#475569",
            dark: "#020617"
          },
          gray: {
            light: "#F8FAFC",
            dark: "#64748B"
          },
          black: "#0F172A",
          white: "#FFFFFF",
          link: "#DC2626"
        },
        {
          name: "サイバーネオン",
          description: "未来的でテック感のあるスタートアップ・ゲーム向けテーマ",
          primary: {
            main: "#06B6D4",
            light: "#22D3EE",
            dark: "#0E7490"
          },
          secondary: {
            main: "#D946EF",
            light: "#E879F9",
            dark: "#A21CAF"
          },
          gray: {
            light: "#1E293B",
            dark: "#94A3B8"
          },
          black: "#0F172A",
          white: "#F1F5F9",
          link: "#22D3EE"
        },
        {
          name: "ウォームサンセット",
          description: "温かみのあるクリエイティブ・ライフスタイル向けテーマ",
          primary: {
            main: "#F97316",
            light: "#FB923C",
            dark: "#C2410C"
          },
          secondary: {
            main: "#F59E0B",
            light: "#FBBF24",
            dark: "#D97706"
          },
          gray: {
            light: "#FEF3C7",
            dark: "#92400E"
          },
          black: "#451A03",
          white: "#FFFBEB",
          link: "#EA580C"
        },
        {
          name: "クールミント",
          description: "爽やかで清涼感のある医療・ウェルネス向けテーマ",
          primary: {
            main: "#14B8A6",
            light: "#5EEAD4",
            dark: "#0F766E"
          },
          secondary: {
            main: "#06B6D4",
            light: "#67E8F9",
            dark: "#0E7490"
          },
          gray: {
            light: "#F0FDFA",
            dark: "#6B7280"
          },
          black: "#134E4A",
          white: "#FFFFFF",
          link: "#14B8A6"
        },
        {
          name: "ロイヤルゴールド",
          description: "高級感と信頼性を兼ね備えたプレミアムサービス向けテーマ",
          primary: {
            main: "#1E40AF",
            light: "#3B82F6",
            dark: "#1E3A8A"
          },
          secondary: {
            main: "#CA8A04",
            light: "#FACC15",
            dark: "#854D0E"
          },
          gray: {
            light: "#F9FAFB",
            dark: "#6B7280"
          },
          black: "#111827",
          white: "#FFFFFF",
          link: "#1E40AF"
        }
      ];

      const currentTheme = themes[selectedTheme];

      const ColorBox = ({ color, label }) => (
        <div className="text-center">
          <div 
            className="w-20 h-20 rounded-lg shadow-md mb-2 border border-gray-200"
            style={{ backgroundColor: color }}
          />
          <p className="text-xs font-mono text-gray-600">{color}</p>
          <p className="text-xs text-gray-500 mt-1">{label}</p>
        </div>
      );

      return (
        <div className="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-8">
          <div className="max-w-7xl mx-auto">
            <div className="text-center mb-8">
              <div className="flex items-center justify-center gap-2 mb-2">
                <Palette className="w-8 h-8 text-blue-600" />
                <h1 className="text-4xl font-bold text-gray-900">UIカラーテーマ集</h1>
              </div>
              <p className="text-gray-600">追加の配色パターン - 5テーマ</p>
            </div>

            {/* テーマセレクター */}
            <div className="flex flex-wrap justify-center gap-3 mb-8">
              {themes.map((theme, index) => (
                <button
                  key={index}
                  onClick={() => setSelectedTheme(index)}
                  className={`px-6 py-3 rounded-lg font-semibold transition-all ${
                    selectedTheme === index
                      ? 'bg-blue-600 text-white shadow-lg scale-105'
                      : 'bg-white text-gray-700 hover:bg-gray-50 shadow'
                  }`}
                >
                  {theme.name}
                </button>
              ))}
            </div>

            {/* カラーパレット表示 */}
            <div className="bg-white rounded-2xl shadow-xl p-8 mb-8">
              <h2 className="text-2xl font-bold text-gray-900 mb-2">{currentTheme.name}</h2>
              <p className="text-gray-600 mb-6">{currentTheme.description}</p>
              
              <div className="space-y-6">
                <div>
                  <h3 className="text-lg font-semibold text-gray-800 mb-4">Primary Colors</h3>
                  <div className="flex gap-6 flex-wrap">
                    <ColorBox color={currentTheme.primary.main} label="Main" />
                    <ColorBox color={currentTheme.primary.light} label="Light" />
                    <ColorBox color={currentTheme.primary.dark} label="Dark" />
                  </div>
                </div>

                <div>
                  <h3 className="text-lg font-semibold text-gray-800 mb-4">Secondary Colors</h3>
                  <div className="flex gap-6 flex-wrap">
                    <ColorBox color={currentTheme.secondary.main} label="Main" />
                    <ColorBox color={currentTheme.secondary.light} label="Light" />
                    <ColorBox color={currentTheme.secondary.dark} label="Dark" />
                  </div>
                </div>

                <div>
                  <h3 className="text-lg font-semibold text-gray-800 mb-4">Neutral Colors</h3>
                  <div className="flex gap-6 flex-wrap">
                    <ColorBox color={currentTheme.gray.light} label="Gray Light" />
                    <ColorBox color={currentTheme.gray.dark} label="Gray Dark" />
                    <ColorBox color={currentTheme.black} label="Black" />
                    <ColorBox color={currentTheme.white} label="White" />
                  </div>
                </div>
              </div>
            </div>

            {/* UIコンポーネントプレビュー */}
            <div className="bg-white rounded-2xl shadow-xl p-8">
              <h2 className="text-2xl font-bold text-gray-900 mb-6">UIコンポーネントプレビュー</h2>
              
              <div className="space-y-8">
                {/* ボタン */}
                <div>
                  <h3 className="text-lg font-semibold text-gray-800 mb-4">Buttons</h3>
                  <div className="flex flex-wrap gap-4">
                    <button
                      className="px-6 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all"
                      style={{ 
                        backgroundColor: currentTheme.primary.main,
                        color: currentTheme.white 
                      }}
                    >
                      Primary Button
                    </button>
                    <button
                      className="px-6 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all"
                      style={{ 
                        backgroundColor: currentTheme.secondary.main,
                        color: currentTheme.white 
                      }}
                    >
                      Secondary Button
                    </button>
                    <button
                      className="px-6 py-3 rounded-lg font-semibold border-2 hover:shadow-md transition-all"
                      style={{ 
                        borderColor: currentTheme.primary.main,
                        color: currentTheme.primary.main,
                        backgroundColor: currentTheme.white
                      }}
                    >
                      Outline Button
                    </button>
                  </div>
                </div>

                {/* リンク */}
                <div>
                  <h3 className="text-lg font-semibold text-gray-800 mb-4">Links</h3>
                  <div className="space-y-2">
                    <p>
                      <a 
                        href="#" 
                        className="font-medium underline hover:no-underline"
                        style={{ color: currentTheme.link }}
                      >
                        通常のテキストリンク
                      </a>
                      <span className="text-gray-600"> - ホバーすると下線が消えます</span>
                    </p>
                    <p>
                      <a 
                        href="#" 
                        className="font-medium hover:underline"
                        style={{ color: currentTheme.link }}
                      >
                        ホバーで下線表示
                      </a>
                      <span className="text-gray-600"> - ホバーすると下線が表示されます</span>
                    </p>
                  </div>
                </div>

                {/* カード */}
                <div>
                  <h3 className="text-lg font-semibold text-gray-800 mb-4">Cards</h3>
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div 
                      className="rounded-xl p-6 shadow-md"
                      style={{ backgroundColor: currentTheme.gray.light }}
                    >
                      <div 
                        className="w-12 h-12 rounded-lg mb-4 flex items-center justify-center"
                        style={{ backgroundColor: currentTheme.primary.main }}
                      >
                        <Check className="w-6 h-6" style={{ color: currentTheme.white }} />
                      </div>
                      <h4 className="text-lg font-bold mb-2" style={{ color: currentTheme.black }}>
                        カード 1
                      </h4>
                      <p style={{ color: currentTheme.gray.dark }}>
                        グレーライト背景のカードデザイン。読みやすく落ち着いた印象を与えます。
                      </p>
                      <button
                        className="mt-4 px-4 py-2 rounded-lg font-semibold text-sm"
                        style={{ 
                          backgroundColor: currentTheme.primary.main,
                          color: currentTheme.white 
                        }}
                      >
                        詳細を見る
                      </button>
                    </div>

                    <div 
                      className="rounded-xl p-6 shadow-md border"
                      style={{ 
                        backgroundColor: currentTheme.white,
                        borderColor: currentTheme.gray.dark + '30'
                      }}
                    >
                      <div 
                        className="w-12 h-12 rounded-lg mb-4 flex items-center justify-center"
                        style={{ backgroundColor: currentTheme.secondary.main }}
                      >
                        <Check className="w-6 h-6" style={{ color: currentTheme.white }} />
                      </div>
                      <h4 className="text-lg font-bold mb-2" style={{ color: currentTheme.black }}>
                        カード 2
                      </h4>
                      <p style={{ color: currentTheme.gray.dark }}>
                        白背景にボーダーのカードデザイン。クリーンで明るい印象です。
                      </p>
                      <button
                        className="mt-4 px-4 py-2 rounded-lg font-semibold text-sm"
                        style={{ 
                          backgroundColor: currentTheme.secondary.main,
                          color: currentTheme.white 
                        }}
                      >
                        詳細を見る
                      </button>
                    </div>

                    <div 
                      className="rounded-xl p-6 shadow-lg"
                      style={{ backgroundColor: currentTheme.primary.main }}
                    >
                      <div 
                        className="w-12 h-12 rounded-lg mb-4 flex items-center justify-center"
                        style={{ backgroundColor: currentTheme.white }}
                      >
                        <Check className="w-6 h-6" style={{ color: currentTheme.primary.main }} />
                      </div>
                      <h4 className="text-lg font-bold mb-2" style={{ color: currentTheme.white }}>
                        カード 3
                      </h4>
                      <p style={{ color: currentTheme.white + 'E6' }}>
                        プライマリカラー背景。強調したいコンテンツに最適なデザインです。
                      </p>
                      <button
                        className="mt-4 px-4 py-2 rounded-lg font-semibold text-sm"
                        style={{ 
                          backgroundColor: currentTheme.white,
                          color: currentTheme.primary.main 
                        }}
                      >
                        詳細を見る
                      </button>
                    </div>
                  </div>
                </div>

                {/* フォーム要素 */}
                <div>
                  <h3 className="text-lg font-semibold text-gray-800 mb-4">Form Elements</h3>
                  <div className="space-y-4 max-w-md">
                    <div>
                      <label className="block text-sm font-medium mb-2" style={{ color: currentTheme.gray.dark }}>
                        入力フィールド
                      </label>
                      <input
                        type="text"
                        placeholder="テキストを入力..."
                        className="w-full px-4 py-2 rounded-lg border-2 focus:outline-none transition-colors"
                        style={{ 
                          borderColor: currentTheme.gray.dark + '40',
                          backgroundColor: currentTheme.white
                        }}
                        onFocus={(e) => e.target.style.borderColor = currentTheme.primary.main}
                        onBlur={(e) => e.target.style.borderColor = currentTheme.gray.dark + '40'}
                      />
                    </div>
                    <div className="flex items-center gap-2">
                      <input
                        type="checkbox"
                        id="check"
                        className="w-5 h-5 rounded"
                        style={{ accentColor: currentTheme.primary.main }}
                      />
                      <label htmlFor="check" style={{ color: currentTheme.gray.dark }}>
                        チェックボックスのサンプル
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* CSSコード表示 */}
            <div className="mt-8 bg-gray-900 rounded-2xl shadow-xl p-8 text-white">
              <h2 className="text-2xl font-bold mb-4">CSS変数定義</h2>
              <pre className="text-sm overflow-x-auto">
{`:root {
  /* Primary Colors */
  --primary-main: ${currentTheme.primary.main};
  --primary-light: ${currentTheme.primary.light};
  --primary-dark: ${currentTheme.primary.dark};
  
  /* Secondary Colors */
  --secondary-main: ${currentTheme.secondary.main};
  --secondary-light: ${currentTheme.secondary.light};
  --secondary-dark: ${currentTheme.secondary.dark};
  
  /* Neutral Colors */
  --gray-light: ${currentTheme.gray.light};
  --gray-dark: ${currentTheme.gray.dark};
  --black: ${currentTheme.black};
  --white: ${currentTheme.white};
  
  /* Link Color */
  --link-color: ${currentTheme.link};
}`}
              </pre>
            </div>
          </div>
        </div>
      );
    };

    // Reactコンポーネントをマウント
    const root = ReactDOM.createRoot(document.getElementById('root'));
    root.render(<ColorThemes />);
  </script>
</body>
</html>