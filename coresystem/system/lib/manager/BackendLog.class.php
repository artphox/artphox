<?php

//Currently not in use.
class BackendLog {

	private static $output = '';

	static function log($string) {
		$output .= $string . '\r\n';
	}

	static function flush() {
		if ($output != '') {
			$head = 'Log file craeted on '.date('Y-m-d - H:i:s'). '\r\n';
			$output = $head . $output;
			return file_put_contents('log/'.microtime().'.log', $output);
		}
	}
	
}

?>