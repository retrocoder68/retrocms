<?php
/**
 * settings.php - RetroCMS, a lightweight Content Management System.
 * 
 * Contains global constants used by the RetroCMS site.
 * These constants are set at installation time.
 * Please see readme file for detailed installation instructions.
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

/* Check that file is included from a valid place. */
if(!defined('retrocms')) die("Unauthorized access.");

/******************************************************************************
 * RetroCMS status settings
 */
/* RetroCMS is installed or not. Set to true when installation has been done.*/
$_SETTINGS['installed'] = 'false';

/******************************************************************************
 * SQL Database settings
 */
/* The MySQL server name. */
$_SETTINGS['dbserver'] = 'localhost';

/* The MySQL database to use. */
$_SETTINGS['dbname'] = 'retrocoder';

/* The prefix to be used for the db tables.
 * Allows for multiple installations of RetroCMS on the same server.
 */
$_SETTINGS['db-table-prefix'] = 'ret_';

/* The version of the RetroCMS database.
 * This value is not used as of July 2014, but is added to prepare for
 * future database upgrades.
 */
$_SETTINGS['db-version'] = '1';

/******************************************************************************
 * SQL server user settings
 */
/* The MySQL user to be used by RetroCMS.
 * Do not use root!
 */
$_SETTINGS['dbuser'] = 'retrocoder';

/* The MySQL password of the user above.
 * Do not forget to change to a good password!
 */
$_SETTINGS['dbpassword'] = 'qNci5#rVpX8!lGIz';

/******************************************************************************
 * The RetroCMS site settings
 */
/* Web site protocol. */
$_SETTINGS['site-protocol'] = 'http://';

/* Web site server name. */
$_SETTINGS['site-server'] = 'retrocoder.se';

/* Web site root location. */
$_SETTINGS['site-root'] = '/';

/******************************************************************************
 * The RetroCMS security settings
 */
/* Password hashing effort. */
$_SETTINGS['pwhash-cost'] = '14';
?>
