<?php
namespace lib\universal;

use \PDO as PDO;
use \PDOException as PDOException;

class DataAccess {
	
	private static $pdo;

	//Gibt die komplette aktuelle URL, die vom User aufgerufen wurde, zurück
	static function getCurrentURL() {
		return 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}

	//Liefert die URL abzüglich des States
	static function getBaseURL($slug) {
		$url = self::getCurrentURL();
		if ($slug == null || strlen($slug) == 0) return $url;
		$urlslugpos = strpos(strtolower($url), $slug);
		if ($urlslugpos != false) {
			$url = substr($url, 0, $urlslugpos);
		}
		return $url;
	}

	static function getPDO() {
		if (!isset(self::$pdo)) {
			try {
				self::$pdo = new PDO(DB_CONNECTION_STRING, DB_USER,DB_PASS, \ObjectConfigData::DB_OPTIONS);
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				throw new ArtphoxException('ERR_DB_XXX', $e->getMessage());
			}
		}
		return self::$pdo;
	}

}

?>