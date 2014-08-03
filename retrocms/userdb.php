<?php
/**
 * userdb.php - RetroCMS, a lightweight Content Management System.
 *
 * The user database in RetroCMS.
 *
 * This file handles user data stored in MySQL as well as user login/logout.
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

/**
 * Setup the user database in MySQL.
 *
 * This function is only called during installation of RetroCMS
 * and should not be used otherwise.
 *
 * @todo Handle errors and return value indicating error.
 *
 */
function create_userdb(){
    $db = open_db();

    /* Create database. */
/*
    $sql = "CREATE DATABASE 'test' DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
    if (mysqli_query($db,$sql)) {
        echo "Database my_db created successfully";
    } else {
        echo "Error creating database: " . mysqli_error($db;
    }
*/

    /* Create user table. */
    $table_name = setting('db-table-prefix') . "users";
    $sql="create table if not exists ${table_name}(
        userid smallint auto_increment primary key,
        username varchar(16) collate utf8_unicode_ci not null unique,
        password binary(60) not null,
        name varchar(32) collate utf8_unicode_ci,
        email varchar(32) collate utf8_unicode_ci);";

    /* Execute query. */
    if(mysqli_query($db,$sql)) {
        echo "Table ${table_name} created successfully.<br>";
    } else {
        echo "Error creating table: " . mysqli_error($db) . "<br>";
    }

    /* Create sessions table. */
/*
    $table_name = setting('db-table-prefix') . "sessions";
    $sql="create table if not exists ${table_name}(
        session_id smallint auto_increment primary key,
        userid smallint unique,
        created timestamp);";
*/
    // Execute query. */
/*
    if(mysqli_query($db,$sql)) {
        echo "Table ${table_name} created successfully.<br>";
    } else {
        echo "Error creating table: " . mysqli_error($db) . "<br>";
    }
*/

    /* Create auth_users table. */
    $table_name = setting('db-table-prefix') . "auth_users";
    $sql="create table if not exists ${table_name}(
        session_id varchar(26) primary key,
        userid smallint unique,
        last_active timestamp,
        ip_address varchar(45));";

    // Execute query
    if(mysqli_query($db,$sql)) {
        echo "Table ${table_name} created successfully.<br>";
    } else {
        echo "Error creating table: " . mysqli_error($con) . "<br>";
    }

    close_db($db);
}

/**
 * Delete the RetroCMS user database.
 *
 * This function should only be called during a complete uninstall.
 */
function delete_userdb(){
    $db = open_db();

    /* Delete user table. */
    $table_name = setting('db-table-prefix') . "users";
    $sql="drop table if exists ${table_name};";

    /* Execute query */
    if(mysqli_query($db,$sql)) {
        echo "Table ${table_name} deleted successfully.<br>";
    } else {
        echo "Error deleting table: " . mysqli_error($con) . "<br>";
    }

    /* Delete sessions table */
/*
    $table_name = setting('db-table-prefix') . "sessions";
    $sql="drop table if exists ${table_name};";
*/
    /* Execute query. */
/*
    if(mysqli_query($db,$sql)) {
        echo "Table ${table_name} deleted successfully.<br>";
    } else {
        echo "Error deleteing table: " . mysqli_error($con) . "<br>";
    }
*/

    /* Delete auth_users table. */
    $table_name = setting('db-table-prefix') . "auth_users";
    $sql="drop table if exists ${table_name}";

    /* Execute query. */
    if(mysqli_query($db,$sql)) {
        echo "Table ${table_name} deleted successfully.<br>";
    } else {
        echo "Error deleting table: " . mysqli_error($con) . "<br>";
    }
    
    close_db($db);
}

/**
 * Add a new user to RetroCMS.
 *
 * Be aware that all users added will have full administrative rights.
 * Users who only need to view content, i.e. public users, should not be
 * added. Only add users who should be able to write content.
 *
 * @param string $username
 * The login name of the user. Max length 16 characters.
 *
 * @param sring $password
 * The password to be used when user login. Max length 32 characters.
 *
 * @param string $display_name
 * The name to be displayed on the website, e.g. like author of articles.
 * This parameter can be left emtpy and will then default to the user name.
 *
 * @param string $user_email
 * The email address of the user. Max length 32 characters.
 * Be aware that no check of any kind us done to verify that this is a
 * valid email address.
 * This is an optional parameter and defaults to an empty string.
 *
 * @return int|false
 * The user id of the new user or false if user could not be added.
 *
 * @todo Get the user id of the new user by querying with user name
 * instead of using the auto_increment of the table.
 */
function add_user($username, $password, $display_name = null, $user_email = ""){
    /* Check input parameters. */
    if(empty($username) || empty($password)) return false;
    if(empty($display_name)) $display_name = $username;

    /* Store user data. */
    $db = open_db();

    /* Prepare input data. */
    $username = mysqli_real_escape_string($db, strip_tags(substr($username, 0, 16)));
    $display_name = mysqli_real_escape_string($db, strip_tags(substr($display_name, 0, 32)));
    $user_email = mysqli_real_escape_string($db, strip_tags(substr($user_email, 0, 32)));
    $hash = hash_passwd($password);

    /* Add user query. */
    $table_name = setting('db-table-prefix') . "users";
    $sql="insert into ${table_name}(username, password, name, email) values(
            '${username}', '${hash}', '${display_name}', '${user_email}')";

    /* Execute query. */
    if(mysqli_query($db,$sql)) {
        echo "User ${username} added to ${table_name} successfully.<br>";
    } else {
        echo "Error adding user: " . mysqli_error($db) . "<br>";
    }

    /* Get the userid of the last added user. */
    $sql = "select auto_increment from information_schema.tables where
            table_schema = '".setting("dbname")."' and table_name = '${table_name}'";
    /* Execute query. */
    if($q_res = mysqli_query($db,$sql)) {
        $res = mysqli_fetch_array($q_res);
        mysqli_free_result($q_res);
        $userid = $res['auto_increment']-1;
    } else {
        echo "Error getting auto_increment: " . mysqli_error($db) . "<br>";
        $userid = false;
    }

    close_db($db);
    return $userid;
}

/**
 * Update the data of an existing user.
 *
 * @param int $userid
 * The user id of the user to update.
 * 
 * @param string $username
 * The login name of the user. Max length 16 characters.
 *
 * @param sring $password
 * The password to be used when user login. Max length 32 characters.
 *
 * @param string $display_name
 * The name to be displayed on the website, e.g. like author of articles.
 *
 * @param string $user_email
 * The email address of the user. Max length 32 characters.
 * Be aware that no check of any kind us done to verify that this is a
 * valid email address.
 *
 * @return int|false
 * The user id of the new user or false if user could not be added.
 *
 * @todo Handle empty values properly, i.e. no change if no value is
 * supplied.
 */
function update_user($userid, $username, $password, $display_name = null, $user_email = ""){
    /* Check input parameters. */
    if(empty($userid) || !is_numeric($userid) || intval($userid) < 1 ||
       empty($username) ||
       empty($password))
        return false;
    if(empty($display_name)) $display_name = $username;
    
    /* Update user data. */
    $db = open_db();

    /* Prepare input data. */
    $userid = intval($userid);
    $username = mysqli_real_escape_string($db, strip_tags(substr($username, 0, 16)));
    $display_name = mysqli_real_escape_string($db, strip_tags(substr($display_name, 0, 32)));
    $user_email = mysqli_real_escape_string($db, strip_tags(substr($user_email, 0, 32)));
    $hash = hash_passwd($password);

    /* Update user query. */
    $table_name = setting('db-table-prefix') . "users";
    $sql="update ${table_name} set username='${username}', password='${hash}', name='${display_name}' email='${user_email}' where userid = '${userid}'";

    /* Execute query. */
    if(mysqli_query($db,$sql)) {
        echo "User ${username} was update successfully.<br>";
    } else {
        echo "Error updating user: " . mysqli_error($db) . "<br>";
    }
    close_db($db);
    return true;
}

/**
 * Delete a user from the RetroCMS database.
 *
 * Attention: The user data will be completely removed from the SQL
 * database and can not be restored again.
 * 
 * @param int $userid
 * The user id of the user to delete.
 *
 * @return boolean
 * This function return true if successfull and false otherwise.
 *
 * @todo Handle errors and return value to indicate error.
 */
function delete_user($userid){
    /*  Check input parameters. */
    if(empty($userid) || !is_numeric($userid) || intval($userid) < 1) return false;

    $db = open_db();

    /* Prepare input data. */
    $userid = intval($userid);

    /* Delete user query. */
    $table_name = setting('db-table-prefix') . "users";
    $sql="delete from ${table_name} where userid = '${userid}'";

    /* Execute query. */
    if(mysqli_query($db,$sql)) {
        echo "User ${username} deleted from ${table_name} successfully.<br>";
    } else {
        echo "Error deleting user: " . mysqli_error($db) . "<br>";
    }
    close_db($db);
    return true;
}

/**
 * Get user data from RetroCMS database.
 *
 * @param int $userid
 * The user id of the user to retreive from the database.
 *
 * @return associative array | false
 * An associative array (map) with the users data.
 * The array contain the following keys:
 * 'userid', 'username', 'password', 'name', 'email'
 * False will be returned if user was not found.
 *
 * @todo SECURITY-ISSUE! Do not return password hash in the return array.
 */
function get_user($userid){
    /* Check input parameters. */
    if(empty($userid) || !is_numeric($userid) || intval($userid) < 1) return false;

    $db = open_db();
    
    /* Prepare input data. */
    $userid = intval($userid);

    /* Select user query. */
    $table_name = setting('db-table-prefix') . "users";
    $sql="select * from ${table_name} where userid = '${userid}'";

    /* Execute query. */
    if($q_res = mysqli_query($db,$sql)) {
        $user = mysqli_fetch_array($q_res);
        mysqli_free_result($q_res);
    } else {
        echo "Error selecting user: " . mysqli_error($db) . "<br>";
        $user = false;
    }

    close_db($db);
    return $user;
}

/**
 * Get user and check correct password.
 *
 * @param string $username
 * The user name of the user.
 *
 * @param string $password
 * The users password.
 *
 * @return associative array | false
 * An associative array (map) with the users data.
 * The array contain the following keys:
 * 'userid', 'username', 'password', 'name', 'email'
 * False will be returned if user was not found or incorrect password.
 *
 * @todo SECURITY-ISSUE! Do not return password hash in the return array.
 */
function get_user_with_name($username, $password){
    # Check input parameters.
    if(empty($username) || empty($password)) return false;

    $db = open_db();

    /* Prepare input data. */
    $username = mysqli_real_escape_string($db, substr($username, 0, 16));

    /* Select user query. */
    $table_name = setting('db-table-prefix') . "users";
    $sql="select * from ${table_name} where username = '${username}';";

    /* Return value. */
    $user = false;

    /* Execute query. */
    if($q_res = mysqli_query($db,$sql)) {
        $tmp_user = mysqli_fetch_array($q_res);
        if(check_passwd($password, $tmp_user['password'])){
            $user = $tmp_user;
        }
        mysqli_free_result($q_res);
    } else {
        echo "Error selecting user: " . mysqli_error($db) . "<br>";
        $user = false;
    }

    close_db($db);
    return $user;
}

/**
 * Get currently logged in user.
 *
 * @return associative array | false
 * An associative array (map) with the users data.
 * The array contain the following keys:
 * 'userid', 'username', 'password', 'name', 'email'
 * False will be returned if user was not found.
 *
 * @todo SECURITY-ISSUE! Do not return password hash in the return array.
 * @todo Handle error cases.
 */
function get_current_user2(){
    $auth_user = get_auth_user(session_id());
    return get_user($auth_user['userid']);
}

# Session functions
#function create_session_db(){
#    $db = open_db();    
#    close_db($db);
#    return true;
#}

#function delete_session_db(){
#    $db = open_db();
#    close_db($db);
#    return true;
#}

/**
 * Create new session for specified user.
 *
 * Uses only php session functionality.
 *
 * @param int $userid
 * The user id to associate with the session.
 *
 * @return string | false
 * The session id of the new session.
 * Return false if session could not be created.
 */
function create_session($userid){
    /* Check input parameters. */
    if(empty($userid)) return false;

    /* Create session. */
    $session_id = session_id();
    if(empty($session_id)) {
        session_start();
        $session_id = session_id();
    }
#    $db = open_db();

    # Prepare input data.
#    $userid = intval($userid);

    // Add session query.
#    $table_name = setting('db-table-prefix') . "sessions";
#    $sql="insert into ${table_name}(session_id, userid) values('$session_id', '$userid');";

    // Execute query
#    echo "SQL = ${sql} <br>";
#    if(mysqli_query($db,$sql)) {
#        echo "Session for userid ${userid} added to ${table_name} successfully.<br>";
#    } else {
#        echo "Error adding session: " . mysqli_error($db) . "<br>";
#    }

    // Get the session id of the last added session.
#    $sql = "select auto_increment from information_schema.tables where
#            table_schema = '".setting("dbname")."' and table_name = '${table_name}'";
    // Execute query
#    echo "SQL = ${sql} <br>";
#    if($q_res = mysqli_query($db,$sql)) {
#        $res = mysqli_fetch_array($q_res);
#        mysqli_free_result($q_res);
#        echo "Got auto_increment ${res} from ${table_name} successfully.<br>";
#        print_r($res);
#        echo "<br>";
#        $session_id = $res['auto_increment']-1;
#        $_SESSION['session_id'] = $session_id;
#    } else {
#        echo "Error getting auto_increment: " . mysqli_error($db) . "<br>";
#        $session_id = false;
#    }

#    close_db($db);
    return $session_id;
}

/**
 * Delete a session
 *
 * @param int $session_id
 * The id for the session to delete.
 *
 * @return boolean
 * True it successfull, false in case of error.
 */
function delete_session($session_id){
    # Check input parameters.
    if(!isset($session_id)) return false;
    
    # Delete session data.
#    $db = open_db();

    # Prepare input data.
#    $session_id = intval($session_id);

    // Delete session query
#    $table_name = setting('db-table-prefix') . "sessions";
#    $sql="delete from ${table_name} where session_id = '${session_id}';";

    // Execute query
#    if(!mysqli_query($db,$sql)) {
#    if(mysqli_query($db,$sql)) {
#        echo "Session ${session_id} deleted from ${table_name} successfully.<br>";
#        unset($_SESSION['session_id']);
#    } else {
#        echo "Error deleting session: " . mysqli_error($db) . "<br>";
#    }
    
    /* Remove session cookies.*/
    session_unset();
    session_destroy();

#    close_db($db);
    return true;
}

/**
 * Get session. Not implemented.
 */
function get_session($session_id){
    # Check input parameters.
#    if($session_id == null) return false;
    
    # Get session.
#    $db = open_db();
    
    # Prepare input data.
#    $session_id = intval($session_id);

    // Get session query
#    $table_name = setting('db-table-prefix') . "sessions";
#    $sql="select * from ${table_name} where session_id = '${session_id}';";

    // Execute query
#    echo "SQL = ${sql} <br>";
#    if($q_res = mysqli_query($db,$sql)) {
#        $session = mysqli_fetch_array($q_res);
#        mysqli_free_result($q_res);
#        echo "Got session successfully.<br>";
#        print_r($session);
#        echo "<br>";
#    } else {
#        echo "Error getting session: " . mysqli_error($db) . "<br>";
#        $session = false;
#    }

#    close_db($db);
#    return $session;
    return false;
}

/**
 * Get session. Not implemented.
 */
function get_session_for_user($userid){
    # Check input data.
#    if($userid == null) return false;

    # Get session.
#    $db = open_db();
    
    # Prepare input data.
#    $userid = intval($userid);

    // Get session query
#    $table_name = setting('db-table-prefix') . "sessions";
#    $sql="select * from ${table_name} where userid = '${userid}';";

    // Execute query
#    echo "SQL = ${sql} <br>";
#    if($q_res = mysqli_query($db,$sql)) {
#        $session = mysqli_fetch_array($q_res);
#        mysqli_free_result($q_res);
#        echo "Got session for userid ${userid} successfully.<br>";
#        print_r($session);
#        echo "<br>";
#    } else {
#        echo "Error getting session: " . mysqli_error($db) . "<br>";
#        $session = false;
#    }
    
#    close_db($db);
#    return $session;
    return false;
}

/*function session_expired($session_id, $datetime = null){
    # Get session.
    if($session = get_session($session_id)){
        # Use now as default time.
        if($datetime == null) $datetime = new DateTime();

        # Expires after 1 day (24 hours).
        $expires = new DateTime($session['created']);
        $expires->add(new DateInterval("P1D"));
        return $datetime > $expires;
    } else {
        return true;
    }
}*/

/******************************************************************************
 * User authorization functions
 */
/**
 * Add authorized, i.e. logged in, user.
 *
 * @param string $session_id
 * The session id of the login session.
 *
 * @param int $userid
 * The user id of the logged in user.
 *
 * @param string $ip_address
 * The ip address of the remote host. The login session is only valid from this
 * ip address.
 *
 * @return boolean
 * Returns true if successfull, false otherwise.
 * 
 * @todo Check for missing input data.
 */
function add_auth_user($session_id, $userid, $ip_address){
    /* Check input parameters. */
    if(empty($userid) || !is_numeric($userid) || intval($userid) < 1) return false;

    $db = open_db();

    /* Prepare input data. */
    $session_id = mysqli_real_escape_string($db, strip_tags(substr($session_id, 0, 26)));
    $userid = intval($userid);
    $ip_address = mysqli_real_escape_string($db, strip_tags(substr($ip_address, 0, 45)));
    
    /* Delete left over record from previous login, if exists. */
    $table_name = setting('db-table-prefix') . "auth_users";
    $sql="delete from ${table_name} where userid = '${userid}';";
    if(!mysqli_query($db,$sql)) {
        echo "Error deleting old auth user: " . mysqli_error($db) . "<br>";
    }

    /* Add auth_users. */
    $sql="insert into ${table_name}(session_id, userid, ip_address) values('${session_id}', '${userid}', '${ip_address}');";

    /* Execute query. */
    if(!mysqli_query($db,$sql)) {
        echo "Error adding auth user: " . mysqli_error($db) . "<br>";
    }

    close_db($db);
    return true;
}

/**
 * Delete record of authorized, i.e. logged in, user.
 *
 * @param string $session_id
 * The id of the login session.
 *
 * @return boolean
 * Returns true if successfull, false otherwise.
 */
function delete_auth_user($session_id){
    /* Check input parameters. */
    if(empty($session_id)) return false;

    $db = open_db();

    /* Prepare input data. */
    $session_id = mysqli_real_escape_string($db, substr($session_id, 0, 26));

    /* Delete auth_users. */
    $table_name = setting('db-table-prefix') . "auth_users";
    $sql="delete from ${table_name} where session_id = '${session_id}';";

    /* Execute query. */
    if(!mysqli_query($db,$sql)) {
        echo "Error deleting auth user: " . mysqli_error($db) . "<br>";
    }

    close_db($db);
    return true;
}

/**
 * Get authorized user session.
 *
 * @param string $session_id
 * The id of the session to retrieve.
 *
 * @return associative array | false
 * An associative array (map) with the session data.
 * The array contains the following keys:
 * 'session_id', 'userid', 'last_active', 'ip_address'
 *
 * @todo SECURITY-ISSUE! Do not return ip address.
 * @todo SECURITY-ISSUE! Do not return last active timestamp.
 */
function get_auth_user($session_id){
    /* Check input parameters. */
    if(empty($session_id)) return false;

    $db = open_db();

    /* Prepare input data. */
    $session_id = mysqli_real_escape_string($db, substr($session_id, 0, 26));

    /* Get auth_users. */
    $table_name = setting('db-table-prefix') . "auth_users";
    $sql="select * from ${table_name} where session_id = '${session_id}';";

    /* Execute query. */
    if($q_res = mysqli_query($db,$sql)) {
        $auth_user = mysqli_fetch_array($q_res);
        mysqli_free_result($q_res);
    } else {
        echo "Error getting auth_user: " . mysqli_error($db) . "<br>";
        $auth_user = false;
    }

    close_db($db);
    return $auth_user;
}

/*
 * Update the last active timestamp of an authorized user.
 *
 * This timestamp is used to expire the session after a time of
 * user inactivity.
 *
 * @param int $userid
 * The user id of the logged in user.
 *
 * @return boolean
 * Returns true if successful otherwise false.
 */
function update_last_active($userid){
    /* Check input parameters. */
    if(empty($userid) || !is_numeric($userid) || intval($userid) < 1) return false;

    $db = open_db();

    /* Prepare input data. */
    $userid = intval($userid);

    /* Update auth_users. */
    $table_name = setting('db-table-prefix') . "auth_users";
    $sql="update ${table_name} set last_active = current_timestamp where userid = '${userid}';";

    /* Execute query. */
    if(!mysqli_query($db,$sql)) {
        echo "Error updating last_active auth user: " . mysqli_error($db) . "<br>";
    }
    
    close_db($db);
    return true;
}

/******************************************************************************
 * User login/logout functions
 */
/**
 * Login user with the supplied credentials.
 *
 * @param string $username
 * The username
 *
 * @param string $password
 * The password
 *
 * @return int | false
 * Return the session id of the login session or false if
 * unsuccessful.
 */
function user_login($username, $password){
    $user = get_user_with_name($username, $password);
    if($user){
        $session_id = create_session($user['userid']);
        if($session_id){
            add_auth_user($session_id, $user['userid'], $_SERVER['REMOTE_ADDR']);
        }
        return $session_id;
    } else {
        return false;
    }
}

/**
 * Logout the logged in user.
 *
 * @return true
 * This function always return true.
 */
function user_logout(){
    $session_id = session_id();
    if($session_id){
        delete_auth_user($session_id);
        delete_session($session_id);
    }
    return true;
}

/**
 * Check if the current user is logged in.
 *
 * A check is made that the access is made from the same ip address as
 * when the user logged in and that the session has not expired through user
 * inactivity. The session will expire if the user is not active within
 * 15 minutes.
 *
 * If the user is logged in, this function also updates the last active
 * timestamp for the user.
 *
 * @return boolean
 * Returns true if the user is logged in, false otherwise.
 */
function user_authenticated(){
    # Get active session or return false if none exists.
    $session_id = session_id();
    if(empty($session_id)) return false;

    $authenticated = false;
    if($auth_user = get_auth_user($session_id)){
        $authenticated = ($_SERVER['REMOTE_ADDR'] == $auth_user['ip_address']);
        $expires = new DateTime();
        $expires->sub(new DateInterval("P15M")); // Subtract 15 minutes.
        $authenticated &= $expires < new DateTime($auth_user['last_active']);
    };

    # Update last active time.
    if($authenticated)
        update_last_active($auth_user['userid']);

    return $authenticated;
}
?>