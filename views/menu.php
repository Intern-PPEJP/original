<?php

namespace PHPMaker2021\ppejp_web;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
$topMenu->addMenuItem(2, "mi_home", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "home", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}home.php'), false, false, "", "", true);
$topMenu->addMenuItem(41, "mi_w_berita", $MenuLanguage->MenuPhrase("41", "MenuText"), $MenuRelativePath . "wberitalist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_berita'), false, false, "", "", true);
$topMenu->addMenuItem(42, "mi_w_kat_berita", $MenuLanguage->MenuPhrase("42", "MenuText"), $MenuRelativePath . "wkatberitalist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_kat_berita'), false, false, "", "", true);
$topMenu->addMenuItem(16, "mi_w_pelatihan", $MenuLanguage->MenuPhrase("16", "MenuText"), $MenuRelativePath . "wpelatihanlist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_pelatihan'), false, false, "", "", true);
$topMenu->addMenuItem(53, "mi_w_testimoni", $MenuLanguage->MenuPhrase("53", "MenuText"), $MenuRelativePath . "wtestimonilist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_testimoni'), false, false, "", "", true);
$topMenu->addMenuItem(1, "mi_w_users", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "wuserslist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_users'), false, false, "", "", true);
$topMenu->addMenuItem(50, "mi_w_userlevels", $MenuLanguage->MenuPhrase("50", "MenuText"), $MenuRelativePath . "wuserlevelslist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_userlevels'), false, false, "", "", true);
$topMenu->addMenuItem(48, "mi_w_settings", $MenuLanguage->MenuPhrase("48", "MenuText"), $MenuRelativePath . "wsettingslist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_settings'), false, false, "", "", true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(2, "mi_home", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "home", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}home.php'), false, false, "", "", false);
$sideMenu->addMenuItem(41, "mi_w_berita", $MenuLanguage->MenuPhrase("41", "MenuText"), $MenuRelativePath . "wberitalist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_berita'), false, false, "", "", false);
$sideMenu->addMenuItem(42, "mi_w_kat_berita", $MenuLanguage->MenuPhrase("42", "MenuText"), $MenuRelativePath . "wkatberitalist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_kat_berita'), false, false, "", "", false);
$sideMenu->addMenuItem(16, "mi_w_pelatihan", $MenuLanguage->MenuPhrase("16", "MenuText"), $MenuRelativePath . "wpelatihanlist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_pelatihan'), false, false, "", "", false);
$sideMenu->addMenuItem(53, "mi_w_testimoni", $MenuLanguage->MenuPhrase("53", "MenuText"), $MenuRelativePath . "wtestimonilist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_testimoni'), false, false, "", "", false);
$sideMenu->addMenuItem(1, "mi_w_users", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "wuserslist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_users'), false, false, "", "", false);
$sideMenu->addMenuItem(50, "mi_w_userlevels", $MenuLanguage->MenuPhrase("50", "MenuText"), $MenuRelativePath . "wuserlevelslist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_userlevels'), false, false, "", "", false);
$sideMenu->addMenuItem(48, "mi_w_settings", $MenuLanguage->MenuPhrase("48", "MenuText"), $MenuRelativePath . "wsettingslist", -1, "", AllowListMenu('{2A80FFCB-6B57-4C56-9758-B76A3BD45EAD}w_settings'), false, false, "", "", false);
echo $sideMenu->toScript();
