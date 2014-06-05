<?php
namespace lib\model\front\modules;

use lib\model\front\core\Widget;

class RandomTextWidget extends Widget {

	private static $sentencearray = array(
		"Ein Ast schaut aus, als wäre er betrunken.",
		"Die Katze ist schwarz.",
		"Leider ist das Glas leer.",
		"Mein Kugelschreiber riecht nach Eierbären."
		);

	function getFrontendCode() {
		$sentence = self::$sentencearray[rand(0, count(self::$sentencearray)-1)];
		echo '<span style="border: 1px solid black; padding: 3px;">'.utf8_decode($sentence).'</span>';
	}
}
?>