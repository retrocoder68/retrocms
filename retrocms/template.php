<?php
/**
 * template.php - RetroCMS, a lightweight Content Management System.
 *
 * Handles html template files used when performing actions other then
 * viewing content. This is every thing from writing new articles to
 * administrative tasks.
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
 * Find the requested template and return full path to the php file.
 *
 * The template php will be looked for in two different places, first in the web site
 * template folder or if not found there in RetroCMS default templates folder.
 * If the template can not be found a 404 error template will be returned. 
 *
 * @param string
 * The name of the template. The file which is looked for has to be named
 * $template.php
 *
 * @return string
 * The full path to the php template file.
 */
function find_template($template){
    /* Check if user template exists. */
    $template_path = "${_SERVER['DOCUMENT_ROOT']}".setting("site-root")."template/$template.php";
    if(!file_exists($template_path)){
        /* If not return default template. */
        $template_path = "${_SERVER['DOCUMENT_ROOT']}".setting("site-root")."retrocms/default-template/$template.php";
        if(!file_exists($template_path)){
            /* Or 404 error page. */
            $template_path = "${_SERVER['DOCUMENT_ROOT']}".setting("site-root")."template/404.php";
            if(!file_exists($template_path)){
                $template_path = "${_SERVER['DOCUMENT_ROOT']}".setting("site-root")."retrocms/default-template/404.php";
            }
        }
    }

    return $template_path;
}

/**
 * Insert the requested php template in the execution output flow.
 *
 * The template will replace the main site file, e.g. index.php.
 * Execution stops after inclusion of the template file.
 *
 * @param string
 * The name of the template. The file which is looked for has to be named
 * $template.php
 */
function insert_template($template){
    require(find_template($template));
    die();
}
?>