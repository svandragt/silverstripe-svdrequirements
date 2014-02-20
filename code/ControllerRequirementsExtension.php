<?php
/**
 * For each extension type, create a combined file for each class that has requirements.
 * This optimizes performance as on subsequent pages the requirement for the base class have
 * already been cached, but still benefits from minimal http requests using combined_files.
 *
 * We can also pass requirements to a specific class
 */
class ControllerRequirementsExtension extends Extension {

	private $js = array();
	private $css = array();

	/**
	 * For each extension type, create a combined file for each class that has requirements.
	 * Note: If this is not late enough we can consider using Object->afterExtending()
	 *       or onAfterInit() { $this->owner->afterExtending('onAfterInit', function(){...} ); }
	 */
	public function onAfterInit() {
		foreach (array('js','css') as $ext) {
			foreach (array_keys($this->$ext) as $classname) {
				$e = $this->$ext;
				Requirements::combine_files(strtolower($classname . '.' . $ext), $e[$classname]);
			}
		}
	}

	/**
	 * Add the  file to the list of Controller Requirements, seperated by extension
	 * @param String $class class name
	 * @param String $file  requirement filename
	 */
	public function AddRequirement(String $class, String $file) {
		$pi  = pathinfo($file);
		$ext = $pi['extension'];
		$e   = &$this->$ext;

		if (!isset($e["$class"])) $e[$class] = array();
		array_push($e[$class], $file);
	}

	/**
	 * Convenience wrapper around AddRequirement to quickly add a bunch of requirements
	 * @param String $class class name
	 * @param Array $files  requirement filenames in array format
	 */
	public function AddRequirements(String $class, Array $files) {
		foreach ($files as $file) {
			$this->AddRequirement($class, $file);
		}
	}

}