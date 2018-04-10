<?php

class ext_update {

	private $version;
	
	public function __construct() {
		$this->version = $this->getVersion();
	}
	
	public function main() {


	}

	public function access() {
	list($major, $minor, $fix) = $this->version;
		if ((int)$major == 2 && (int)$minor == 5) {
			return true;
		} else { 
			return false;
		}
	}

	private function getVersion() {
		$_EXTKEY = 'tp3_businessview';
		$path = PATH_site . 'typo3conf/ext/'.$_EXTKEY.'/ext_emconf.php';
		if (file_exists($path)) {
			$EM_CONF = NULL;
			include $path;
			if (is_array($EM_CONF[$_EXTKEY])) {
				return explode('.', $EM_CONF[$_EXTKEY]['version']);
			}
		}
		return false;
	}
}