<?php require("retrocms/retrocms.php");?>
<!DOCTYPE html>
<html>
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
<link rel="stylesheet" type="text/css" href="retrocms/default_template/css/dark-x.css">
</head>
<body>
<div id="main">
    <div id="content">
        <h1>Welcome to RetroCMS</h1>
        <p>
        <?php
            create_userdb();
            echo "User database created.<br>";
            /* Edit the row below before running the installation script. */
            add_user('admin', 'password', 'Admin', 'admin@yoursite.com');
            echo "User added.<br>";
        
            create_article_db();
            echo "Article database created.<br>";
            /* Uncomment the row below, to add an example article. */
            // add_article("Example article", "This is an example article in RetroCMS.");
        ?>
        RetroCMS has been succesfully installed.<br>
        </p>
        <p><a href="<?php echo setting("site-protocol").setting("site-server").setting("site-root");?>">
            Click here to start using your site.
        </a></p>

    </div> <!-- id="content" -->
</div> <!-- id="main" -->
<footer>
Copyright (C) 2014 J.Karlsson (j.karlsson@retrocoder.se)
</footer>
</body>
</html>
