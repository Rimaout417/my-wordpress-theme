class ScreenWidthRedirect {
	constructor() {
		this.screenWidth = window.innerWidth;
		this.init();
	}

	handleMobileView() {
		if (
			!window.location.href.includes("view=mobile") &&
			sessionStorage.getItem("redirected") !== "true"
		) {
			window.location.href = `${window.location.href}?view=mobile`;
			sessionStorage.setItem("redirected", "true"); // リダイレクト済みとしてフラグをセット
		}
	}

	handleDesktopView() {
		if (window.location.href.includes("view=mobile")) {
			window.location.href = window.location.href.replace("?view=mobile", "");
			sessionStorage.setItem("redirected", "true"); // リダイレクト済みとしてフラグをセット
		}
	}

	init() {
		if (this.screenWidth <= 768) {
			this.handleMobileView();
		} else {
			this.handleDesktopView();
		}
	}
}

export default ScreenWidthRedirect;
