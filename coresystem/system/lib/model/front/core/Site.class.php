<?php
namespace lib\model\front\core;

use lib\universal\DataAccess;
use lib\manager\FrontendManager;

class Site {
	
	private $displaytitle;
	private $adaption;
	private $page;
	private $style;
	private $styleobjid;
	private $slug;
	
	function __construct($params) {
		if (is_array($params)) {
			foreach ($params as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	function getFrontendCode() {
		$smarty = FrontendManager::createSmarty();
		if ($this->style != null && $this->style instanceof Style) {
			$smarty->assign('das_headcode', $this->style->getHeadCode());
			$smarty->assign('das_bodycode', $this->style->getBodyCode());
			$smarty->assign('das_styleobjid', $this->styleobjid);
			$smarty->assign('das_styletimestamp', @filemtime('../styles/'.$this->styleobjid.'.css'));
		} else {
			$smarty->assign('das_headcode', '');
			$smarty->assign('das_bodycode', '');
			$smarty->assign('das_styleobjid', -1);
			$smarty->assign('das_styletimestamp', '');
		}
		if ($this->adaption == '1') {
			$smarty->assign('das_adaption', true);
			$smarty->assign('das_sitetitle', $this->displaytitle);
			$smarty->assign('das_slug', $this->slug);
		} else {
			$smarty->assign('das_adaption', false);
		}
		$sptitle = '';
		if (isset($this->page) && $this->page instanceof Page) {
			$sptitle = $this->page->getDisplayTitle();
			$completetitle = str_replace('%site%', $this->displaytitle, str_replace('%page%', $sptitle, DAS_TITLE_PATTERN_NORMAL));
		}
		else {
			$completetitle = str_replace('%site%', $this->displaytitle, DAS_TITLE_PATTERN_SITEONLY);
		}
		$smarty->assign('das_completetitle', $completetitle);
		$smarty->assign('das_baseurl', DataAccess::getBaseURL($this->slug));
		return $smarty->fetch(DAS_TPL);
	}
	
	function getDisplayTitle() {
		return $this->displaytitle;
	}

	function getSlug() {
		return $this->slug;
	}

	function usesAdaption() {
		return $this->adaption;
	}

	function getPage() {
		return $this->page;
	}

	function setPage($page) {
		$this->page = $page;
	}

	function getStyle() {
		return $this->style;
	}

	function getOrder() {
		return $this->order;
	}

	function getAdminTitle() {
		return $this->admintitle;
	}

}

?>