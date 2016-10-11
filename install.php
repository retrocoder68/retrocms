<?php require_once("retrocms/install/setup.php");?>
<!DOCTYPE html>
<html lang="en">
<!-----------------------------------------------------------------------------
 install.php - RetroCMS, a lightweight Content Management System.

 The installation script to install RetroCMS on your webserver.
 Read the readme.txt for installation instructions.
 
 This file should be the first to be run after downloading.
 
 Author: J.Karlsson <j.karlsson@retrocoder.se>
 Copyright: 2014 J.Karlsson. All rights reserved.

 License:
 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.
------------------------------------------------------------------------------>
<head><title>RetroCMS Installation script</title>
  <meta charset="UTF-8">
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php //print_r($_setup); ?>
<div class="container">
    <div>
        <h1 class="page-header">Welcome to RetroCMS</h1>
        <h2>This guide will help you install RetroCMS on your webserver.</h2>
            <?php
//                $_setup->get_step_data();
                switch($_setup->step) {
                    case 0: ?>
                        <div class="well">
                            <h2>MySQL server</h2>
                            <form method="post" action="install.php">
                                <div class="form-group">
                                    <label for="server">Server name</label><input type="text" class="form-control" name="dbserver" id="server" value="<?php echo $_setup->dbserver;?>">
                                </div>
<!--                                <div class="form-group">
                                    <label for="port">MySQL port</label><input type="text" class="form-control" name="port" id="port" value="3306">
                                </div> -->
                                <div class="form-group">
                                    <label for="database">Database to use</label><input type="text" class="form-control" name="dbname" id="database" value="<?php echo $_setup->dbname;?>">
                                </div>
                                <div class="form-group">
                                    <label for="prefix">Prefix for tables in the database</label><input type="text" class="form-control" name="db-table-prefix" id="prefix" value="<?php echo $_setup->{"db-table-prefix"};?>">
                                </div>
                                <button class="btn btn-default" type="submit" name="step" value="0" disabled>
                                    <span class="glyphicon glyphicon-chevron-left"></span> Back
                                </button>
                                <button class="btn btn-default" type="submit" name="step" value="1">
                                    Forward <span class="glyphicon glyphicon-chevron-right"></span>
                                </button>
                            </form>
                        </div>
            <?php       break;
                    case 1: ?>
                        <div class="well">
                            <h2>MySQL user</h2>
                            <form method="post" action="install.php">
                                <div class="form-group">
                                    <label for="user">MySQL username</label><input type="text" class="form-control" name="dbuser" id="user" value="<?php echo $_setup->dbuser;?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">MySQL password</label><input type="password" class="form-control" name="dbpassword" id="password" value="<?php echo $_setup->dbpassword;?>">
                                </div>
                                <button class="btn btn-default" type="submit" name="step" value="0">
                                    <span class="glyphicon glyphicon-chevron-left"></span> Back
                                </button>
                                <button class="btn btn-default" type="submit" name="step" value="2">
                                    Forward <span class="glyphicon glyphicon-chevron-right"></span>
                                </button>
                            </form>
                        </div>
            <?php       break;
                    case 2: ?>
                        <div class="well">
                            <h2>Website data</h2>
                            <form method="post" action="install.php">
                                <div class="form-group">
                                    <label for="protocol">Website protocol</label><input type="text" class="form-control" name="site-protocol" id="protocol" value="<?php echo $_setup->{"site-protocol"};?>">
                                </div>
                                <div class="form-group">
                                    <label for="server">Webserver url</label><input type="text" class="form-control" name="site-server" id="server" value="<?php echo $_setup->{"site-server"};?>">
                                </div>
                                <div class="form-group">
                                    <label for="root">Server root</label><input type="text" class="form-control" name="site-root" id="root" value="<?php echo $_setup->{"site-root"};?>">
                                </div>
                                <button class="btn btn-default" type="submit" name="step" value="1">
                                    <span class="glyphicon glyphicon-chevron-left"></span> Back
                                </button>
                                <button class="btn btn-default" type="submit" name="step" value="3">
                                    Forward <span class="glyphicon glyphicon-chevron-right"></span>
                                </button>
                            </form>
                        </div>
            <?php       break;
                    case 3:
                        $_setup->create_database();
                        ?>
                        <div class="well">
                            <h2>Create admin user</h2>
                            <form method="post" action="install.php">
                                <div class="form-group">
                                    <label for="user">Username</label><input type="text" class="form-control" name="user" id="user" value="admin">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label><input type="password" class="form-control" name="password" id="password" value="">
                                </div>
                                <button class="btn btn-default" type="submit" name="step" value="2">
                                    <span class="glyphicon glyphicon-chevron-left"></span> Back
                                </button>
                                <button class="btn btn-default" type="submit" name="step" value="4">
                                    Forward <span class="glyphicon glyphicon-chevron-right"></span>
                                </button>
                            </form>
                        </div>
            <?php       break;
                    case 4:
                        require("retrocms/userdb.php");
                        $userid = add_user($_setup->user, $_setup->password);
                        if(!$userid){
                            echo "Unable to create user: ".$_setup->user."<br>";
                        } else {
                            $user = get_user($userid); ?>
                            Created new user <?php echo $user['name'];?>
            <?php       }
                        ?>
                        <div class="well">
                            <h2>Insert example content</h2>
                            <form method="post" action="install.php">
                                <div class="checkbox">
                                    <label for="enable"><input type="checkbox" name="enable" id="enable" checked>Add first article</label>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label><input type="text" class="form-control" name="title" id="user" value="Example article">
                                </div>
                                <div class="form-group">
                                    <label for="text">Text</label><input type="text" class="form-control" name="text" id="text" value="This is an example article in RetroCMS.">
                                </div>
                                <button class="btn btn-default" type="submit" name="step" value="3">
                                    <span class="glyphicon glyphicon-chevron-left"></span> Back
                                </button>
                                <button class="btn btn-default" type="submit" name="step" value="5">
                                    Finish <span class="glyphicon glyphicon-chevron-right"></span>
                                </button>
                            </form>
                        </div>
            <?php       break;
                    case 5:
                        if(isset($_setup->enable)) {
                            require "retrocms/html.php";
                            require("retrocms/article.php");
                            add_article($_setup->title, $_setup->title, 'published');
                            echo "Added example article.<br>";
                        }
                        ?>
                        <div class="well">
                            <h2>Congratulations! RetroCMS has been succesfully installed.</h2>
                            <p><a href="<?php echo setting("site-protocol").setting("site-server").setting("site-root");?>">
                            Click here to start using your site.</a></p>
                        </div>
            <?php       break;
                    default:
                        echo "Default:<br>";
                        break;
                }
            ?>
    </div> <!-- id="content" -->
</div> <!-- class="container" -->
<div class="container">
    <hr>
    <footer>
        <p>Copyright &copy; 2016 J.Karlsson <a href="mailto:j.karlsson@retrocoder.se">&lt;j.karlsson@retrocoder.se&gt;</a></p>
    </footer>
</div> <!-- class="container" -->
</body>
</html>
