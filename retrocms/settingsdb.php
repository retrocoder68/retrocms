<?php
/**
 * settingsdb.php - RetroCMS, a lightweight Content Management System.
 * 
 * Database for global constants used by the RetroCMS site.
 * Attention:
 * settingsdb.php should be included first of all in all internal php files,
 * since unauthorized access is checked in settingsdb.php.
 * 
 * @author J.Karlsson <j.karlsson@retrocoder.se>
 * @copyright 2014 J.Karlsson. All rights reserved.
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

# Include settings array.
require_once("settings.php");

/**
 * Retrieve a value from the settings database.
 *
 * @param string $key
 * The name (key) of the setting to retrieve.
 *
 * @return string
 * The value stored in the settings database.
 */
function setting($key) {
    global $_SETTINGS;
    return $_SETTINGS[$key];
}

/**
 * Lock the settings database before change.
 * Not implemented.
 */
function lock_settingsdb(){
    return true;
}

/**
 * Unlock the setting database after change.
 * Not implemented.
 */
function unlock_settingsdb(){
    return true;
}

/**
 * Save a value in the settings database.
 * Not implemented.
 */
function store_setting($key, $value) {
    global $_SETTINGS;
    $_SETTINGS[$key] = $value;
    $changed = false;
    $settings_array = file("settings.php", FILE_IGNORE_NEW_LINES);
    if($settings_array){
        foreach($settings_array as $lineno => $row) {
            if(strpos($row, $key)){
                $settings_array[$lineno] = "\$_SETTINGS['$key'] = '$value';";
                $changed = true;
            }
        }
        if($changed){
            $settings_file = fopen("settings.php", "w+");
            if($settings_file){
                foreach($settings_array as $row) {
                    fwrite($settings_, $row."\r\n");
                }
            }
        }
    }
    return $value;
}

/**
 * Save the settings database.
 * Not implemented.
 */
function save_all_settings() {
    global $_SETTINGS;
    $changed = false;
    $settings_array = file("settings.php", FILE_IGNORE_NEW_LINES);
    if($settings_array){
        foreach($settings_array as $lineno => $row) {
            if(strpos($row, $key)){
                $settings_array[$lineno] = "\$_SETTINGS['$key'] = '$value';";
                $changed = true;
            }
        }
        if($changed){
            $settings_file = fopen("settings.php", "w+");
            if($settings_file){
                foreach($settings_array as $row) {
                    echo $row."<br>\r\n";
//                    fwrite($settings_, $row."\r\n");
                }
            }
        }
    }
    return $changed;
}
?>