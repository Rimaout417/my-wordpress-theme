class HamburgerMenu {
	constructor(selector, navSelector) {
		this.hamburger = document.querySelector(selector); // ハンバーガーボタン
		this.nav = document.querySelector(navSelector); // ナビゲーションメニュー
		if (this.hamburger && this.nav) {
			this.init();
		} else {
			console.error(
				"Hamburger or nav element not found:",
				selector,
				navSelector,
			);
		}
	}

	toggleMenu() {
		// ハンバーガーメニューとナビゲーションのactiveクラスを切り替える
		this.hamburger.classList.toggle("active");
		this.nav.classList.toggle("active");

		// ハンバーガーとクローズアイコンの切り替え
		const menuIcon = this.hamburger.querySelector(".menu");
		const closeIcon = this.hamburger.querySelector(".close");

		if (this.hamburger.classList.contains("active")) {
			menuIcon.style.display = "none";
			closeIcon.style.display = "inline-block";
		} else {
			menuIcon.style.display = "inline-block";
			closeIcon.style.display = "none";
		}
	}

	init() {
		this.hamburger.addEventListener("click", () => this.toggleMenu());
	}
}

export default HamburgerMenu;
