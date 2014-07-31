<?php
/**
 * action.php - RetroCMS, a lightweight Content Management System.
 *
 * Parse the request values and perform necessary actions including
 * setting up some global variables that can be used by the website.
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
 * Action id definitions.
 * 
 * index.php?ai=[INT]&ti=[INT]&it=[INT or STRING]
 * ai = action id = Integer 1-9
 * action = view|edit|add|delete|search|login|logout|backup|restore
 */
define('VIEW',    1);
define('EDIT',    2);
define('ADD',     3);
define('DELETE',  4);
define('SEARCH',  5);
define('LOGIN',   6);
define('LOGOUT',  7);
define('BACKUP',  8);
define('RESTORE', 9);

/**
 * Parse the 'ai' value in the http get request.
 *
 * @return int
 * The requested action id or default action, i.e. VIEW.
 */
function get_action(){
    if(isset($_GET['ai']) && is_numeric($_GET['ai'])){
        $actionid = intval($_GET['ai']);
    } else {
        $actionid = VIEW;
    }
    if($actionid < VIEW || $actionid > RESTORE) $actionid = VIEW;
    
    return $actionid;
}
?>