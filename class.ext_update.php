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
        if ($major == '2' && $minor == '1') {
            $db = $GLOBALS['TYPO3_DB'];


            // copy column 'category' to column 'corporate_division' in tx_diehlcompanydatabase_domain_model_company
            // uses sql_query since exec_UPDATEquery escapes values with single quotes
            $db->sql_query('UPDATE tx_diehlcompanydatabase_domain_model_company SET corporate_division=category');

            // migrate data from tx_rggooglemaps_cat to tx_diehlcompanydatabase_domain_model_corporatedivision
            $res = $db->exec_SELECTquery('uid,pid,title,descr', 'tx_rggooglemap_cat', '');
            $data = array();
            while ($row = $db->sql_fetch_row($res)) {
                list($uid, $pid, $title, $descr) = $row;
                $newRow = [
                    'uid' => $uid,
                    'pid' => $pid,
                    'name' => $title,
                    'description' => $descr,
                    'icon' => $uid
                ];
                array_push($data, $newRow);
            }

            $db->exec_INSERTmultipleRows('tx_diehlcompanydatabase_domain_model_corporatedivision', ['uid', 'pid', 'name', 'description', 'icon'], $data);

        }
        else if ($major == '2' && $minor == '2') {
            /*
             *

             */
            $db->sql_query('Update  tx_diehlcompanydatabase_domain_model_company
								inner Join static_countries on tx_diehlcompanydatabase_domain_model_company.country like static_countries.cn_iso_2 
								set tx_diehlcompanydatabase_domain_model_company.country = static_countries.uid, tx_diehlcompanydatabase_domain_model_company.countrycode = static_countries.cn_iso_2 ');
            return $db->sql_fetch_row();

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