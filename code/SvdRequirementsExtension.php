<?php
class SvdRequirementsExtension extends DataExtension {

	public function onBeforeInit() {
		$this->owner->theme_dir = SSViewer::get_theme_folder();
	}

}