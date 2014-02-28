<?php

class SvdRequirements extends Requirements {

	static private function backtrace_class() {
		$backtrace = debug_backtrace();
		$class = $backtrace[2]['class'];
		return $class;
	}

	static private function extension_from_filename($file) {
		$pi  = pathinfo($file);
		$ext = $pi['extension'];
		return $ext;
	}

	static private function populate_assets($files) {
			$assets = array();

			foreach ($files as $file) {
			$ext = self::extension_from_filename($file);

			if (!array_key_exists($ext, $assets)) {
				$assets[$ext] = array();	
			} 
			array_push($assets[$ext], $file);
		}
		return $assets;

	}


	static public function combine( $files, $media = null) {
		$class = self::backtrace_class();
		$assets = self::populate_assets($files);
	
		foreach (array_keys($assets) as $ext) {
			if (!isset($assets[$ext])) {
				continue;
			}
			self::combine_files(strtolower($class . '.' . $ext), $assets[$ext]);
		}		


	}
}