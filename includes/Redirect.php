<?php
class Redirect {
	public static function to($location, $status = null) {
		if( is_int($status) ) {
			switch ($status) {
				case 301:
					header("HTTP/1.1 301 Moved Permanently");
					break;
			}
		}
		header('Location: ' . $location);
		exit;
	}
}