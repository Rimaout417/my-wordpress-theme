// src/index.js
import "./style.css";
// Our modules / classes
import Darkmode from "./modules/darkmode";
import ScreenWidthRedirect from "./modules/screenWidthRedirect";
import HamburgerMenu from "./modules/hamburger";

// Instantiate a new object using our modules/classes
const darkmode = new Darkmode();
const screenWidthRedirect = new ScreenWidthRedirect();
const hamburgerMenu = new HamburgerMenu(".hamburger", "nav"); // セレクタを正しく渡す
