// ダークモード処理をクラス化
class Darkmode {
	constructor() {
		this.osDark = window.matchMedia("(prefers-color-scheme: dark)");
		this.init();
	}

	// ダークモードがオンのときに実行する処理
	darkModeOn() {
		document.documentElement.classList.add("dark");
	}

	// ダークモードがオフのときに実行する処理
	darkModeOff() {
		document.documentElement.classList.remove("dark");
	}

	// 初期化とイベントリスナー設定
	init() {
		// ロード時の状況に応じて切り替え
		if (this.osDark.matches) {
			this.darkModeOn();
		} else {
			this.darkModeOff();
		}

		// OSの設定変更に応じて切り替え
		this.osDark.addEventListener("change", () => {
			if (this.osDark.matches) {
				this.darkModeOn();
			} else {
				this.darkModeOff();
			}
		});
	}
}

// Darkmodeクラスをデフォルトエクスポート
export default Darkmode;
