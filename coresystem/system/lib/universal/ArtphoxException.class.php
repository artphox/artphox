<?php
namespace lib\universal;

use lib\manager\FrontendManager;

class ArtphoxException extends \Exception {

	private $errorcode;
	private $errorinfo;

	function __construct ($errorcode, $errorinfo=null) {
		$this->errorcode = $errorcode;
		$this->errorinfo = $errorinfo;
		if ($this->errorcode == 'ERR_404') {
			header('HTTP/1.1 404 Not Found');
		}
	}

	function getErrorcode() {
		return $this->errorcode;
	}

	function getErrorinfo() {
		return $this->errorinfo;
	}

	function __toString() {
		if ($this->errorcode == 'ERR_DBXXX') {
			$errormessage = ERROR_DATABASE;
		}
		else {
			$errormessage = FrontendManager::getLanguageText($this->errorcode);
			if ($errormessage === false && $this->errorcode != 'ERR_DEFAULT') {
				$errormessage = FrontendManager::getLanguageText('ERR_DEFAULT');
				if (is_array($this->errorinfo)) $this->errorinfo[] = $this->errorcode;
				else $this->errorinfo = array($this->errorinfo, $this->errorcode);
			}
			if ($errormessage === false) {
				$errormessage = ERROR_DEFAULT;
			}
		}

		//Prüfen, ob keine, eines oder mehrere Error-Elemente vorhanden sind
		if (!isset($this->errorinfo)) {
			//Kein Element -> Alle Platzhalter mit ' ' ersetzen
			$errormessage = preg_replace('/{[^}]*}/', ' ', $errormessage);
		}
		else if (!is_array($this->errorinfo)) {
			//Ein Element -> Platzhalter {0} und {all} mit Element ersetzen, Rest mit ' '
			$errormessage = str_replace('{0}', $this->errorinfo, $errormessage);
			$errormessage = str_replace('{all}', $this->errorinfo, $errormessage);
			$errormessage = preg_replace('/{[^}]*}/', ' ', $errormessage);
		}
		else {
			//Mehrere Elemente -> Platzhalter {0-n} ersetzen und {all} ebenfalls ersetzen. Rest mit ' '
			for ($i = 0; $i < count($this->errorinfo); $i++) {
				$errormessage = str_replace('{'.$i.'}', $this->errorinfo[$i], $errormessage);
			}
			$errormessage = str_replace('{all}', print_r($this->errorinfo, true), $errormessage);
			$errormessage = preg_replace('/{[^}]*}/', ' ', $errormessage);
		}
		return '<p>'.$errormessage . '<br>' . $this->getFile() . ':' . $this->getLine().'</p>';
	}

}

?>