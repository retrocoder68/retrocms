<?php
/**
 * sqldb.php - RetroCMS, a lightweight Content Management System.
 *
 * This file handle any access to the MySQL database.
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
 * Create the RetroCMS databse.
 *
 * @return true | false
 * True if the RetroCMS database was created or false if unsuccessful.
 */
function create_db(){
    $con = mysqli_connect(setting('dbserver'),setting('dbuser'),setting('dbpassword'));

    /* Check connection. */
    if(mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    /* Create database */
    $db_name = setting('dbname');
    $sql="CREATE DATABASE IF NOT EXISTS ${db_name} DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
    if (mysqli_query($con,$sql)) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . mysqli_error($con);
        return false;
    }
    mysqli_close($con);
    return true;
}


/**
 * Open a connection to the RetroCMS databse.
 *
 * @return connection | false
 * A connection to the RetroCMS database or false if unsuccessful.
 */
function open_db(){
    $con = mysqli_connect(setting('dbserver'),setting('dbuser'),setting('dbpassword'),setting('dbname'));

    /* Check connection. */
    if(mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    return $con;
}

/**
 * Close connection to the RetroCMS database.
 *
 * @param connection $db
 * A connection to the RetroCMS database.
 *
 * @see open_db()
 */
function close_db($db){
    mysqli_close($db);
}

/**
 * Create a secure password hash for storage in db.
 *
 * This function requires the blowfish enryption to be available.
 * 
 * @param string $password
 * The password to create hash value from
 *
 * @param int $cost
 * A value to set the required effort to crack the password hash.
 * Higher value means higher effort. A value between 11 - 15 is normal.
 * This parameter can be left blank to use the value in the settings db.
 *
 * @return string | false
 * Returns the password hash or false if blowfish encryption suite is not
 * available.
 *
 * @todo SECURITY_ISSUE! Change and test to $2y$ bcrypt due to vuln. in $2a$ version.
 */
function hash_passwd($password, $cost = null){
    /* Check availability of the blowfish cipher. */
    if(!(defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)){
        echo "CRYPT_BLOWFISH is not available<br>";
        return false;
    }
    
    /* Check input parameters. */
    if(empty($cost)){
        $cost = intval(setting("pwhash-cost"));
    }

    /* Character set used in salt. */
    $chars = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /* Build the beginning of the salt. */
    # TODO: Changed and test to $2y$ bcrypt due to vuln. in $2a$ version.
    $salt = sprintf('$2a$%02d$', $cost);

    /* Seed the random generator. */
    mt_srand();

    /* Generate a random salt. */
    for($i=0; $i<22; $i++) $salt .= $chars[mt_rand(0, 63)];

    /* Return the hash. */
    return crypt($password, $salt);
}

/**
 * Check if password match hash
 *
 * This function require the blowfish encryption to be available.
 *
 * @param string $password
 * The password to check
 *
 * @param string $hash
 * The hash value to check against
 *
 * @return boolean
 * Returns true of the password match the hash values.
 * False if password does not match or the blowfish encryption suite
 * is not available.
 */
function check_passwd($password, $hash){
    /* Check availability of the blowfish cipher. */
    if(!(defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH)){
        echo "CRYPT_BLOWFISH is not available<br>";
        return false;
    }

    return($hash == crypt($password, $hash));
}
?>