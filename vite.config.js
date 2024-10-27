import { defineConfig } from "vite";

export default defineConfig({
	build: {
		rollupOptions: {
			input: "src/index.js", // エントリーポイントの指定
			output: {
				// 出力ディレクトリの指定
				dir: "dist",
				// エントリーポイントとなるファイルの名前を指定
				entryFileNames: "index.js",
				assetFileNames: (assetInfo) => {
					if (assetInfo.name.endsWith(".css")) {
						return "style.css"; // CSSファイル名を指定
					}
					return assetInfo.name;
				},
			},
		},
	},
});
