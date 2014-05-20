<?php

use lib\manager\BackendManager;

if (isset($need_navbar) && $need_navbar) {

	//Set Navbar-Items
	BackendManager::addNavbarItem('ACP_NAVBAR_NEW', 'icons/new.png', array(
			array('ACP_NAVBAR_NEW_IMAGE', 'icons/image.png', '#'),
			array('ACP_NAVBAR_NEW_GALLERY', 'icons/gallery.png', '#'),
			array('ACP_NAVBAR_NEW_PAGE', 'icons/page.png', '#'),
			array('ACP_NAVBAR_NEW_BLOGENTRY', 'icons/blogentry.png', '#')
		));
	BackendManager::addNavbarItem('ACP_NAVBAR_STYLE', 'icons/style.png', '#');
	BackendManager::addNavbarItem('ACP_NAVBAR_SETTINGS', 'icons/settings.png', '#');

}

if (isset($need_sidebar) && $need_sidebar) {

	//Set Sitebar-Tabs
	BackendManager::addSidebarTab(0, 'ACP_SIDEBAR_GALLERY', 'GallerySidebarController');
	BackendManager::addSidebarTab(1, 'ACP_SIDEBAR_PAGES', 'PagesSidebarController');
	BackendManager::addSidebarTab(2, 'ACP_SIDEBAR_BLOG', 'BlogSidebarController');
	BackendManager::addHiddenSidebarTab(3, 'StyleSidebarController');
	BackendManager::addHiddenSidebarTab(4, 'SettingsSidebarController');

}

if (isset($need_pages) && $need_pages) {

	//Set Pages
	BackendManager::addPage('start', 'StartPage.class.php');
	BackendManager::addPage('gallery', 'GalleryPage.class.php');
	//etc.
}

?>