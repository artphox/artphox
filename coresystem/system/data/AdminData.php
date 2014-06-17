<?php

use lib\manager\BackendManager;

if (isset($need_navbar) && $need_navbar) {

	//Set Navbar-Items
	BackendManager::addNavbarItem('ACP_NAVBAR_NEW', 'imgs/new.png', array(
			array('ACP_NAVBAR_NEW_IMAGE', 'imgs/image.png', '#'),
			array('ACP_NAVBAR_NEW_GALLERY', 'imgs/gallery.png', '#'),
			array('ACP_NAVBAR_NEW_PAGE', 'imgs/page.png', '#'),
			array('ACP_NAVBAR_NEW_BLOGENTRY', 'imgs/blogentry.png', '#')
		));
	BackendManager::addNavbarItem('ACP_NAVBAR_STYLE', 'imgs/style.png', '#');
	BackendManager::addNavbarItem('ACP_NAVBAR_SETTINGS', 'imgs/settings.png', '#');

}

if (isset($need_sidebar) && $need_sidebar) {

	//Set Sitebar-Tabs
	BackendManager::addSidebarTab(0, 'gallery', 'ACP_SIDEBAR_GALLERY', 'GallerySidebarController');
	BackendManager::addSidebarTab(1, 'pages', 'ACP_SIDEBAR_PAGES', 'PagesSidebarController');
	BackendManager::addSidebarTab(2, 'blog', 'ACP_SIDEBAR_BLOG', 'BlogSidebarController');
	BackendManager::addHiddenSidebarTab(3, 'style', 'StyleSidebarController');
	BackendManager::addHiddenSidebarTab(4, 'settings', 'SettingsSidebarController');
	BackendManager::setDefaultSidebarTab(0);

}

if (isset($need_pages) && $need_pages) {

	//Set Pages
	BackendManager::addPage('start', 'StartPage');
	//etc.
}

?>