<?php
/**
 * retrocms.php - RetroCMS, a lightweight Content Management System.
 *
 * The main execution file to RetroCMS. This file will load all other internal
 * files, parse the request values and perform necessary actions including
 * setting up some global variables that can be used by the website.
 *
 * This file should be included at the top of any website php file,
 * e.g. index.php.
 * It has to be included before any output is made from the file since
 * RetroCMS needs to send header information, like setting cookie etc.
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
define("retrocms", 1);
require_once("settingsdb.php");
require_once("action.php");
require_once("template.php");
require_once("userdb.php");
require_once("article.php");
require_once("html.php");

/* Initialize RetroCMS global vars.
 * index.php?ai=[INT]&ti=[INT]&it=[INT or STRING]
 * ai = action id = Integer 1-9
 * action = view|edit|add|delete|search|login|logout|backup|restore
 */
$actionid = get_action();

/* Start session if a valid session exists. */
if(isset($_COOKIE['PHPSESSID'])) session_start();

/* Check if user is logged in. */
$authenticated_user = user_authenticated();
$user = get_current_user2();
$username = $user['username'];
$userid = $user['userid'];

/* ti = type id = Integer 1-5
 * type = article|category|tag|user|config
 */
define('ARTICLE',     1);
define('CATEGORY',    2);
define('TAG',         3);
define('USER',        4);
define('CONFIG',      5);

if(isset($_GET['ti']) && is_numeric($_GET['ti'])){
    $typeid = intval($_GET['ti']);
} else {
    $typeid = ARTICLE;
}
if($typeid < ARTICLE || $typeid > CONFIG) $typeid = ARTICLE;

/* it = item id = INT|STRING. if INT = itemid, if STRING=item
 * if type = article, item id = articleid | shortname
 * if type = category, item id = categoryid | category name
 * if type = tag, item id = tag id | tag name
 * if type = user, item id = userid | user name
 * if type = config, item = tbd?
 */
if(isset($_GET['it'])){
    $item = $_GET['it'];
} else {
    $item = null;
}

/* Handle user request */
switch($actionid){
    case VIEW:
	if(isset($item)){
	    if($typeid == ARTICLE){
		$article = get_article($item);
		}
	    elseif($typeid == CATEGORY){/*$category = get_category($item);*/}
	    elseif($typeid == TAG){/*$tag = get_tag($item);*/}
	    elseif($typeid == USER){/*$user = get_user($item);*/}
	    elseif($typeid == CONFIG){/*$config = get_config($item);*/}
	}
        break;
    case EDIT:
	if($authenticated_user){
	    if(isset($item)){ /* Edit existing */
		if($typeid == ARTICLE){
		    $article = get_article($item);
		    insert_template("edit");
		    die();
		} elseif($typeid == CATEGORY){/*$category = get_category($item);*/}
		elseif($typeid == TAG){/*$tag = get_tag($item);*/}
		elseif($typeid == USER){/*$user = get_user($item);*/}
		elseif($typeid == CONFIG){/*$config = get_config($item);*/}
	    } else { /* Create new */
		if($typeid == ARTICLE){
		    $article = new_article();
		    insert_template("edit");
		    die();
		} elseif($typeid == CATEGORY){/*$category = get_category($item);*/}
		elseif($typeid == TAG){/*$tag = get_tag($item);*/}
		elseif($typeid == USER){/*$user = get_user($item);*/}
		elseif($typeid == CONFIG){/*$config = get_config($item);*/}
	    }
	}
        break;
    case ADD:
	if($authenticated_user){
	    if($typeid == ARTICLE){
                $art_id = $_POST["art_id"];
                $title = $_POST["title"];
		$text = $_POST["text"];
		$status = "draft";
		if(isset($_POST["publish"])){
		    $status = "published";
		}
		if($art_id == "new"){ /* Save new article */
		    $art_id = add_article($title, $text, $status);
		} else { /* Save existing article */
		    update_article($art_id, $title, $text, $status);
		}
		$go = setting("site-protocol").setting("site-server").setting("site-root")."?ai=1&ti=1&it=$art_id";
		header("location:$go");
		die();
	    } elseif($typeid == CATEGORY){/*$category = get_category($item);*/}
	    elseif($typeid == TAG){/*$tag = get_tag($item);*/}
	    elseif($typeid == USER){/*$user = get_user($item);*/}
	    elseif($typeid == CONFIG){/*$config = get_config($item);*/}
	}
        break;
    case DELETE:
        break;
    case SEARCH:
	break;
    case LOGIN:
        if(!$authenticated_user){
	    if(empty($_POST['user']) || empty($_POST['password'])){
                /* Show login page. */
                insert_template("login");
		die();
            } else {
                /* Try to login. */
                if(user_login($_POST['user'], $_POST['password'])){
                    # Login successful. Continue to start page.
                    $message = "You are logged in.";
		    $go = setting("site-protocol").setting("site-server").setting("site-root");
		    header("location:${go}");
		    die();
                } else {
                    /* Login failed. */
                    $message = "Wrong user name or password.";
                    /* Show login page. */
                    insert_template("login");
		    die();
                }
            }
	} else {
            /* Already logged in, continue to start page. */
            $message = "You are already logged in.";
	    $go = setting("site-protocol").setting("site-server").setting("site-root");
	    header("location:$go");
	    die();
	}
	break;
    case LOGOUT:
	user_logout();
        $message = "You have been logged out.";
	$go = setting("site-protocol").setting("site-server").setting("site-root");
	header("location:$go");
	die();
	break;
    case BACKUP:
	break;
    case RESTORE:
	break;
    default:
	$actionid = VIEW;
	$typeid = ARTICLE;
	$item = null;
	break;
};
?>