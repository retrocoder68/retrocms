<?php
/**
 * setup.php - RetroCMS, a lightweight Content Management System.
 * 
 * Helper class to setup the global constants used by the RetroCMS site.
 * Please see readme file for detailed installation instructions.
 * 
 * @author J.Karlsson <j.karlsson@retrocoder.se>
 * @copyright 2016 J.Karlsson. All rights reserved.
 *
 * @license http://www.gnu.org/licenses/ GNU General Public License, version 3
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Setup class with helper functions used when retrocms is installed.
 * Installation is started from install.php in the root directory.
 *
 * @author j.karlsson@retrocoder.se
 */
class Setup {
  /*--- Default settings ---*/
    /* The MySQL server name. */
//    public $dbserver = 'localhost';

    /* The MySQL database to use. */
//    public $dbname = 'retrocms';

    /* The prefix to be used for the db tables.
     * Allows for multiple installations of RetroCMS on the same server.
     */
//    public $db_table_prefix = 'ret_';

    /* The version of the RetroCMS database.
     * This value is not used as of July 2014, but is added to prepare for
     * future database upgrades.
     */
//    public $db_version = '1';

    /******************************************************************************
     * SQL server user settings
     */
    /* The MySQL user to be used by RetroCMS.
     */
//    public $dbuser = 'retrocms-user';

    /* The MySQL password of the user above.
     * Do not forget to change to a good password!
     */
//    public $dbpassword = '';

    /******************************************************************************
     * The RetroCMS site settings
     */
    /* Web site protocol. */
//    public $site_protocol = 'http://';

    /* Web site server name. */
//    public $site_server = 'www.your-site.com';

    /* Web site root location. */
//    public $site_root = '/';

    /******************************************************************************
     * The RetroCMS security settings
     */
    /* Password hashing effort. */
//    public $pwhash_cost = '12';

    function __construct(){
        $this->read_settings();
        if($this->get_step_data()){
            $this->save_all_settings();
        }
    }
    
    function set($key, $value){
        $this->{"$key"} = $value;
    }
    function get($key){
        $value = NULL;
        if(isset($this->{"$key"})) $value = $this->{"$key"};
        return $value;
    }

    function read_settings(){
        define("retrocms", 1);
        global $_SETTINGS;
        $_SETTINGS = Array();
        include(dirname(__DIR__)."/settingsdb.php");
        foreach($_SETTINGS as $key => $value) {
//            echo "$key = $value<br>";
            $this->set($key, $value);
        }
    }

    function get_step_data(){
        $data_exist = false;
        if(isset($_POST['step'])){
            foreach($_POST as $key => $value) {
                $this->set($key, $value);
            }
            $data_exist = true;
        } else {
            $this->set('step', '0');
        }
        return $data_exist;
    }
    
    function save_all_settings() {
        $changed = false;
//        echo getcwd()."<br>";
        $settings_array = file("retrocms/settings.php", FILE_IGNORE_NEW_LINES);
        if($settings_array){
            foreach((array) $this as $key => $value){
                foreach($settings_array as $lineno => $row) {
                    if(strpos($row, "\$_SETTINGS['$key']")){
                        $settings_array[$lineno] = "\$_SETTINGS['$key'] = '$value';";
                        $changed = true;
                    }
                }
            }
            if($changed){
                $settings_file = fopen("retrocms/settings.php", "w+");
                if($settings_file){
                    foreach($settings_array as $row) {
//                        echo $row."<br>\r\n";
                        fwrite($settings_file, $row."\r\n");
                    }
                    fclose($settings_file);
                }
            }
        }
        return $changed;
    }
    
    function create_database(){
//        define("retrocms", 1);
//        include(dirname(__DIR__)."/settingsdb.php");
//        include(dirname(__DIR__)."/logging.php");
//        include(dirname(__DIR__)."/action.php");
//        include(dirname(__DIR__)."/template.php");
        include(dirname(__DIR__)."/userdb.php");
        include(dirname(__DIR__)."/article.php");
//        include(dirname(__DIR__)."/html.php");

        create_db() || die("<br>Cannot create RetroCMS database.");
        create_userdb();
        create_article_db();
    }
}

$_setup = new Setup();
?>