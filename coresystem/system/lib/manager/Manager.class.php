<?php
namespace lib\manager;

use lib\universal\DataAccess;
use lib\universal\ArtphoxException;
use \PDO as PDO;
use \PDOException as PDOException;

class Manager {

	protected static $systemproperties = array();
	protected static $langitems = array();

	/*Ladet die angegebenen SystemProperties in den Cache.
	Parameter $keys: Einzelner Propertyname oder Array von Propertynamen. 
	*/
	static function loadSystemProperties($keys) {
		try {
			$statement = FrontendLoader::loadSystemProperties($keys, self::$systemproperties);
			if ($statement === false) return;
			while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
				self::$systemproperties[$result['sp_key']] = $result['sp_value'];
			}
		} catch (PDOException $e) {
			throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
		}
	}

	/*Ladet Sprachinhalte in den Cache.
	Parameter $keys: LangItemCode oder Languagecodes.
	*/
	static function loadLanguageTexts($keys) {
		try {
			$statement = FrontendLoader::loadLanguageTexts($keys, self::$langitems);
			if ($statement === false) return;
			while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
				self::$langitems[$result['lait_code']] = $result['lait_text'];
			}
		} catch (PDOException $e) {
			throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
		}
	}

	static function getSystemProperty($key) {
		try {
			$pdo = DataAccess::getPDO();				
			if (array_key_exists($key, self::$systemproperties)) {
				return self::$systemproperties[$key];
			} else {
				self::loadSystemProperties($key);
			}
			if (array_key_exists($key, self::$systemproperties)) {
				return self::$systemproperties[$key];
			} else {
				return false;
			}
		} catch (PDOException $e) {
			throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
		}
	}

	static function getConfigData($name) {
		if (defined($name)) {
			return constant($name);
		} else {
			throw new ArtphoxException('ERR_CONSTANT_NOT_DEFINED', $name);
		}
	}

	static function getLanguageText($key) {
		try {
			if (array_key_exists($key, self::$langitems)) {
				return self::$langitems[$key];
			} else {
				self::loadLanguageTexts($key);
			}
			if (array_key_exists($key, self::$langitems)) {
				return self::$langitems[$key];
			} else {
				return false;
			}
		} catch (PDOException $e) {
			throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
		}
	}


}
?>