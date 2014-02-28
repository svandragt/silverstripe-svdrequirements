<?php
/**
 * This is a convenience module enforcing best practices for using Requirements.
 */
class SvdRequirements extends Requirements {

	/**
	 * combine list of mixed assets
	 * @param  [mixed] $files array or string containing one or more JS/CSS asset filenames
	 * @param  [string] $media see Requirements class
	 */
	static public function combine( $files, $media = null) {
		if (is_string($files)) {
			$files = array($files);
		}
		$class = self::backtrace_class();
		$assets = self::populate_assets($files);

		foreach (array_keys($assets) as $ext) {
			if (!isset($assets[$ext])) {
				continue;
			}
			self::combine_files(strtolower($class . '.' . $ext), $assets[$ext]);
		}		
	}

	/**
	 * Get the page controller class that is combining the assets
	 * @return [string] ClassName
	 */
	static private function backtrace_class() {
		$backtrace = debug_backtrace();
		$class = $backtrace[2]['class'];
		return $class;
	}

	/**
	 * return the extension from a filename
	 * @param  [string] $file filename
	 * @return [string] extension of the file
	 */
	static private function extension_from_filename($file) {
		$pi  = pathinfo($file);
		$ext = $pi['extension'];
		return strtolower($ext);
	}

	/**
	 * return the asset list seperated by extension
	 * @param  [array] $files list of filenames
	 * @return [array] list of assets seperated by extension
	 */
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

}