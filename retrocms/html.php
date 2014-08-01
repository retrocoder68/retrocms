<?php
/**
 * html.php - RetroCMS, a lightweight Content Management System.
 *
 * HTML helper function for  RetroCMS. This file contains functions
 * to assist in creating html for the website.
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

/* HTML helper functions */
/**
 * Output HTML for the given RetroCMS action.
 * This function will print to the stdout the integer value of the given
 * RetroCMS action.
 * Example of usage: <a href="/?ai=<?php actionid('VIEW');?>">link<a/>
 * 
 * @see get_actionid()
 *
 * @param string
 * The text representation of a RetroCMS action.
 */
function actionid($action){
    echo get_actionid($action);
}

/**
 * Return the action id for the given RetroCMS action.
 *
 * @param string
 * The text representation of a RetroCMS action.
 *
 * @return int
 * The integer value, action id, for a RetroCMS action.
 */
function get_actionid($action){
    switch(strtoupper($action)){
        case 'VIEW':
            $ai = VIEW;
            break;
        case 'EDIT':
            $ai = EDIT;
            break;
        case 'ADD':
            $ai = ADD;
            break;
        case 'DELETE':
            $ai = DELETE;
            break;
        case 'SEARCH':
            $ai = SEARCH;
            break;
        case 'LOGIN':
            $ai = LOGIN;
            break;
        case 'LOGOUT':
            $ai = LOGOUT;
            break;
        case 'BACKUP':
            $ai = BACKUP;
            break;
        case 'RESTORE':
            $ai = RESTORE;
            break;
        default:
            throw new expection();
    };
    return $ai;
}

/**
 * Output HTML for the given RetroCMS content type.
 * This function will print to the stdout the integer value of the given
 * RetroCMS content type.
 * Example of usage: <a href="/?ai=1&ti=<?php typeid('ARTICLE');?>">link<a/>
 * 
 * @see get_typeid()
 *
 * @param string
 * The text representation of a RetroCMS content type.
 */
function typeid($type){
    echo get_typeid($type);
}

/**
 * Return the type id for the given RetroCMS content type.
 *
 * @param string
 * The text representation of a RetroCMS content type.
 *
 * @return int
 * The integer value, type id, for a RetroCMS content type.
 */
function get_typeid($type){
    switch(strtoupper($type)){
        case 'ARTICLE':
            $ti = ARTICLE;
            break;
        case 'CATEGORY':
            $ti = CATEGORY;
            break;
        case 'TAG':
            $ti = TAG;
            break;
        case 'USER':
            $ti = USER;
            break;
        case 'CONFIG':
            $ti = CONFIG;
            break;
        default:
            throw new expection();
    };
    return $ti;
}

/**
 * Create a shortname from the given name.
 *
 * The short name is used as identifier for the content in RetroCMS.
 * The short name has to be unique within the different content types.
 *
 * @param string $name
 * The text, e.g. title of an article, to create a short name from.
 *
 * @return sring
 * The short name. Max 16 characters long, space replaced with '-' and only
 * readable ascii letters.
 */
function create_shortname($name){
    $search =  array(" ", "å", "ä", "ö");
    $replace = array("-", "a", "a", "o");
    $shortname = urlencode(str_replace($search, $replace, strtolower(substr(strip_tags($name), 0, 16))));
    return $shortname;
}
?>