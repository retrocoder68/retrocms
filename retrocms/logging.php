<?php
/**
 * logging.php - RetroCMS, a lightweight Content Management System.
 *
 * Logging functionality used by the RetroCMS for debugging,
 * security analysis, etc.
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

/* Include library files. */
require_once("settingsdb.php");

/**
 *
 */
function write_log($log_name, $message){
    /* Check path to log file, create if necessary. */
    $path = "${_SERVER['DOCUMENT_ROOT']}".setting('site-root')."retrocms/logs";
    if(!file_exists($path)) mkdir($path, 0700); /* u+rwx */

    /* Create full path and name of log file. */
    $logfile = "${path}/${log_name}-log.txt";
    
    /* Form data to write to logfile, one row containg time stamp,
     * ip address and message. */
    date_default_timezone_set("UTC");
    $time_utc = date("Y-m-d H:i:s T");
    
    $data = "[${time_utc}] ${_SERVER['REMOTE_ADDR']} \"${message}\"\n";

    if(file_put_contents($logfile, $data, FILE_APPEND|LOCK_EX) === false){
        /* Log file could not be written */
        error_log("Unable to write retroCMS log file.");
    }
}
?>