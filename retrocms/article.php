<?php
/**
 * article.php - RetroCMS, a lightweight Content Management System.
 *
 * This file handles averything related to articles stored in RetroCMS.
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
require_once("sqldb.php");

/******************************************************************************
 * Article database
 */
/**
 * Create the article table in the RetroCMS SQL database.
 *
 * This function is only called during installation of RetroCMS
 * and should not be used otherwise.
 *
 * @return true
 * This function always return true.
 *
 * @todo Handle errors and return value indicating error.
 */
function create_article_db(){
    $db = open_db();

    /* Create article table. */
    $table_name = setting('db-table-prefix') . "articles";
    $sql="create table if not exists ${table_name}(
        art_id smallint not null auto_increment primary key,
        shortname varchar(16) unique collate utf8_unicode_ci,
        title varchar(32) collate utf8_unicode_ci,
        text text collate utf8_unicode_ci,
        save_time timestamp,
        status enum('draft', 'published', 'deleted'));";

    /* Execute query. */
    if(mysqli_query($db,$sql)) {
        echo "Table ${table_name} created successfully.<br>";
    } else {
        echo "Error creating table: " . mysqli_error($db) . "<br>";
    }

    close_db($db);
    return true;
}

/**
 * Delete the article table for the RetroCMS SQL database.
 *
 * This function should only be called during a complete uninstall.
 * 
 * @return true
 * This function always return true.
 *
 * @todo Handle errors and return value indicating error.
 */
function delete_article_db(){
    $db = open_db();

    /* Delete article table. */
    $table_name = setting('db-table-prefix') . "articles";
    $sql="drop table if exists ${table_name}";

    /* Execute query. */
    if(mysqli_query($db,$sql)) {
        echo "Table ${table_name} deleted successfully.<br>";
    } else {
        echo "Error deleting table: " . mysqli_error($db) . "<br>";
    }
    close_db($db);
    return true;
}

/**
 * Create new article with default values.
 *
 * The article must be saved in the database with add_article().
 * This function is only a convenience function to populate an html form
 * when the user creates a new article.
 *
 * @return associative array
 * The array contains the following keys with default values:
 * 'art_id' => "new",
 * 'shortname' => "",
 * 'title' => "Insert title of article",
 * 'text' => "Insert article text",
 * 'save_time' => "",
 * 'status' => "draft"
 * 
 */
function new_article(){
    $article = array("art_id" => "new","shortname" => "","title" => "Insert title of article","text" => "Insert article text","save_time" => "","status" => "draft");
    return $article;
}

/**
 * Save a new article in the RetroCMS SQL database.
 *
 * @param string $title
 * The title of the article. Max length 32 characters.
 *
 * @param string $text
 * The article text
 *
 * @param string $status
 * The status of the article, must be one of 'draft' or 'published'.
 * This parameter can be left empty and will then default to 'draft'.
 *
 * @param string $shortname
 * The shortname of the article. The short name can be used as identifier of
 * the article instead of the article id. This means that the short name has to
 * be a unique name. Max length 16 characters.
 * This parameter can be left empty, then a unique short name will be created from
 * the title.
 *
 * @param string $save_time
 * The time the article was saved.
 * This parameter can be left empty, and will then default to the current time.
 * The time should be the local time.
 *
 * @return string | false
 * Returns the shortname of the added article.
 * If the article could not be added false is returned.
 *
 * @todo: SECURITY_ISSUE! Strip html tags from article text, only leaving allowed tags.
 * Specifically the script tag should be removed to prevent cross site scripting.
 */
function add_article($title, $text, $status = 'draft', $shortname = null, $save_time = null){
    /* Check input parameters. */
    if(empty($title) || empty($text)) return false;
    if(empty($shortname)) $shortname = create_shortname($title); else $shortname = create_shortname($shortname);

    $db = open_db();

    /* Prepare input data. */
    $title = mysqli_real_escape_string($db, strip_tags(substr($title, 0, 32)));
    $text = mysqli_real_escape_string($db, $text);
    if($status != 'draft' && $status != 'published') $status = 'draft';
    $shortname = mysqli_real_escape_string($db, substr($shortname, 0, 16));
    if(!is_null($save_time)) $save_time = mysqli_real_escape_string($db, substr($save_time, 0, 30));

    /* Store query. */
    $table_name = setting('db-table-prefix') . "articles";
    if(is_null($save_time)){
        $sql="insert into ${table_name}(shortname, title, text, status)
            values('${shortname}', '${title}', '${text}', '${status}')";
    } else {
        $sql="insert into ${table_name}(shortname, title, text, status, save_time)
            values('${shortname}', '${title}', '${text}', '${status}', '${save_time}')";
    }

    /* Execute query. */
    if(!mysqli_query($db,$sql)) {
        echo "Error adding article: " . mysqli_error($db) . "<br>";
    }

    close_db($db);
    return $shortname;
}

/**
 * Save an update to an existing article in the RetroCMS SQL database.
 *
 * @param int $art_id
 * The article id of the article to update.
 * 
 * @param string $title
 * The title of the article. Max length 32 characters.
 *
 * @param string $text
 * The article text
 *
 * @param string $status
 * The status of the article, must be one of 'draft' or 'published'.
 * This parameter can be left empty and will then default to 'draft'.
 *
 * @param string $shortname
 * The shortname of the article. The short name can be used as identifier of
 * the article instead of the article id. This means that the short name has to
 * be a unique name. Max length 16 characters.
 * Since the short name of an already existing article may have been saved in a
 * bookmark by a visitor, it is recommended that the shortname is not changed
 * after publication, to avoid broken links.
 * This parameter can be left empty, then the short name will not be changed.
 *
 * @param string $save_time
 * The time the article was saved.
 * This parameter can be left empty, and will then default to the current time.
 * The time should be the local time.
 *
 * @return boolean
 * Returns true if successful.
 * If the article could not be added false is returned.
 * 
 * @todo: SECURITY_ISSUE! Strip html tags from article text, only leaving allowed tags.
 * Specifically the script tag should be removed to prevent cross site scripting.
 */
function update_article($art_id, $title, $text, $status ='draft', $shortname = null, $save_time = null){
    /* Check input data. */
    if(empty($art_id) || empty($title) || empty($text)) return false;

    $db = open_db();

    /* Prepare input data. */
    $art_id = intval($art_id);
    $title = mysqli_real_escape_string($db, strip_tags(substr($title, 0, 32)));
    $text = mysqli_real_escape_string($db, $text);
    if($status != 'draft' && $status != 'published') $status = 'draft';
    if(!empty($shortname)) $shortname = mysqli_real_escape_string($db, strip_tags(substr($shortname, 0, 16)));
    if(!is_null($save_time)) $save_time = mysqli_real_escape_string($db, substr($save_time, 0, 30));

    /* Update query. */
    $table_name = setting('db-table-prefix') . "articles";
    if(is_null($save_time)){
        if(empty($shortname)){
            $sql="update ${table_name} set title='${title}', text='${text}', status='${status}' where art_id='${art_id}';";
        } else {
            $sql="update ${table_name} set shortname='${shortname}', title='${title}', text='${text}', status='${status}' where art_id='${art_id}';";
        }
    } else {
        if(empty($shortname)){
            $sql="update ${table_name} set title='${title}', text='${text}', save_time = '${save_time}', status='${status}' where art_id='${art_id}';";
        } else {
            $sql="update ${table_name} set shortname='${shortname}', title='${title}', text='${text}', save_time = '${save_time}', status='${status}' where art_id='${art_id}';";
        }
    }

    /* Execute query. */
    if(!mysqli_query($db,$sql)) {
        echo "Error updating article: " . mysqli_error($db) . "<br>";
    }

    close_db($db);
    return true;
}

/*
 * Delete an article from the RetroCMS SQL database.
 * Attention: The article data will be completely removed from the SQL
 * database and can not be restored again.
 * It does not set the status to 'deleted'. The usage of 'deleted' status
 * has not been implemented yet.
 *
 * @param string $shortname
 * The shortname of the article to be deleted.
 *
 * @return boolean
 * Returns true if successful, false otherwise.
 */
function delete_article($shortname){
    /* Check input parameters. */
    if(!isset($shortname)) return false;

    $db = open_db();

    /* Prepare input data. */
    $shortname = mysqli_real_escape_string($db, strip_tags(substr($shortname, 0, 16)));

    /* Delete query. */
    $table_name = setting('db-table-prefix') . "articles";
    $sql="delete from ${table_name} where shortname = '${shortname}';";

    /* Execute query. */
    if(!mysqli_query($db,$sql)) {
        echo "Error deleting article: " . mysqli_error($db) . "<br>";
    }

    close_db($db);
    return true;
}

/**
 * Retreive article data from RetroCMS SQL database.
 *
 * @param string | int $shortname_or_id
 * The id, short name or integer, of the article to retreive.
 *
 * @return associate array
 * Returns an associate array (map) with the following keys:
 * 'art_id', 'shortname', 'title', 'text', 'save_time', 'status'.
 *
 * @see get_article_by_id()
 * @see get_article_by_name()
 */
function get_article($shortname_or_id){
    # Check input parameters.
    if(!isset($shortname_or_id) || $shortname_or_id == null) return false;

    if(is_numeric($shortname_or_id)){
        $article = get_article_by_id($shortname_or_id);
    } else {
        $article = get_article_by_name($shortname_or_id);
    }
    return $article;
}

/**
 * Retreive article data from RetroCMS SQL database.
 *
 * @param string $shortname
 * The short name of the article to retreive.
 *
 * @return associate array
 * Returns an associate array (map) with the following keys:
 * 'art_id', 'shortname', 'title', 'text', 'save_time', 'status'.
 *
 * @see get_article()
 * @see get_article_by_id()
 */
function get_article_by_name($shortname){
    /* Check input parameters. */
    if(!isset($shortname)) return false;

    $db = open_db();
    
    /* Prepare input data. */
    $shortname = mysqli_real_escape_string($db, substr($shortname, 0, 16));

    /* Select query. */
    $table_name = setting('db-table-prefix') . "articles";
    $sql="select * from ${table_name} where shortname = '${shortname}';";

    // Execute query
    if($q_res = mysqli_query($db,$sql)) {
        $article = mysqli_fetch_array($q_res);
        mysqli_free_result($q_res);
    } else {
        echo "Error retrieving article: " . mysqli_error($db) . "<br>";
    }

    close_db($db);
    return $article;
}

/**
 * Retreive article data from RetroCMS SQL database.
 *
 * @param int $id
 * The id of the article to retreive.
 *
 * @return associate array
 * Returns an associate array (map) with the following keys:
 * 'art_id', 'shortname', 'title', 'text', 'save_time', 'status'.
 *
 * @see get_article()
 * @see get_article_by_name()
 */
function get_article_by_id($id){
    /* Check input parameters. */
    if($id == null) return false;

    $db = open_db();
    
    /* Prepare input data. */
    $id = intval($id);

    /* Select query. */
    $table_name = setting('db-table-prefix') . "articles";
    $sql="select * from ${table_name} where art_id = '${id}';";

    /* Execute query. */
    if($q_res = mysqli_query($db,$sql)) {
#        echo "Article ${shortname} retrieved from ${table_name} successfully.<br>";
        $article = mysqli_fetch_array($q_res);
        mysqli_free_result($q_res);
    } else {
        echo "Error retrieving article: " . mysqli_error($db) . "<br>";
    }

    close_db($db);
    return $article;
}


/**
 * Retreive all article data from RetroCMS SQL database.
 *
 * @return array of associate arrays
 * Returns an array with on associate array (map) for each article
 * in the database.
 * The associate array has the following keys:
 * 'art_id', 'shortname', 'title', 'text', 'save_time', 'status'.
 * Returns false if an error occured.
 *
 * @see get_article()
 * @see get_article_by_name()
 * @see get_article_by_id()
 *
 * @todo Return article in time order, latest article first.
 * @todo Add parameter to set sort order.
 * @todo Return only published articles.
 * @todo Add parameter to select status of articles to retrieve.
 */
function get_article_list(){
    $db = open_db();
    
    /* Select query */
    $table_name = setting('db-table-prefix') . "articles";
    $sql="select * from ${table_name};";

    /* Execute query. */
    $articles = false;
    if($q_res = mysqli_query($db,$sql)) {
        $articles = mysqli_fetch_all($q_res, MYSQLI_ASSOC);
        mysqli_free_result($q_res);
    } else {
        echo "Error retrieving article list: " . mysqli_error($db) . "<br>";
    }

    close_db($db);
    return $articles;
}
?>