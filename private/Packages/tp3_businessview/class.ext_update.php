<?php

class ext_update {

	private $version;
	
	public function __construct() {
		$this->version = $this->getVersion();
	}

    public function main() {
        list($major, $minor, $fix) = $this->version;
        if ($major == '2' ) {
            return $this->migrate();
        } else {
            return "Version mismatch, expected 2.1.x";
        }
    }

    public function access() {
        // allow access to update script only for version 2.1.x
        list($major, $minor, $fix) = $this->version;
        if ($major == '2')
            return true;
        else
            return false;
    }

    private function migrate() {
        list($major, $minor, $fix) = $this->version;
        if ($major < '2' && $minor > '0') {
            $db = $GLOBALS['TYPO3_DB'];
            return "no update";
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