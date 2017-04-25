<?php

//
// Open Web Analytics - An Open Source Web Analytics Framework
//
// Copyright 2006 Peter Adams. All rights reserved.
//
// Licensed under GPL v2.0 http://www.gnu.org/copyleft/gpl.html
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// $Id$
//

require_once(OWA_BASE_DIR.'/owa_view.php');

/**
 * Installer Configuration Entry View
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    owa
 * @package     owa
 * @version		$Revision$	      
 * @since		owa 1.0.0
 */

class owa_installConfigEntryView extends owa_view {
			
	function render($data) {

        $connectstr_dbhost = '';
        $connectstr_dbname = '';
        $connectstr_dbusername = '';
        $connectstr_dbpassword = '';
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, "MYSQLCONNSTR_") !== 0) {
                continue;
            }
            
            $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
            $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
            $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
            $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
        }
		
		//page title
		$this->t->set('page_title', 'Configuration File Generator');
		// load body template
		
		$config = $this->get('config');
		if ( ! defined( $config['db_host'] ) ) {
			$config['db_host'] =  $connectstr_dbhost;
		}
		if ( ! defined( $config['db_name'] ) ) {
			$config['db_name'] =  $connectstr_dbname;
		}
		if ( ! defined( $config['db_user'] ) ) {
			$config['db_user'] =  $connectstr_dbusername;
		}
		if ( ! defined( $config['db_password'] ) ) {
			$config['db_password'] =  $connectstr_dbpassword;
		}
		$this->body->set('config', $config);
		
		$this->body->set_template('install_config_entry.php');
		// prepopulate the public url based on the current url.
		$public_url = owa_lib::get_current_url();
		$pos = strpos($public_url, 'install.php');
		$public_url = substr($public_url, 0, $pos);
		$this->body->set('public_url', $public_url);
	}
}

?>
