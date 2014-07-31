<!DOCTYPE html>
<html>
<!-----------------------------------------------------------------------------
 login.php - RetroCMS, a lightweight Content Management System.

 The default login page.
 
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
<head><title>RetroCMS - login</title>
<link rel="stylesheet" type="text/css" href="retrocms/default_template/css/dark-x.css">
</head>
<body>
<div id="main">
    <div id="content">
        <h1>Welcome to RetroCMS</h1>
        <form class="login" action="index.php?ai=<?php actionid("LOGIN");?>" method="post">
            <label id="user" for="user">user</label><input type="text" name="user" id="user">
            <label id="password" for="password">password</label><input type="password" name="password" id="password">
            <input type="submit" id="submit" value="login">
        </form>
    </div> <!-- id="content" -->
</div> <!-- id="main" -->
<footer>
    Copyright (C) 2014 J.Karlsson (j.karlsson@retrocoder.se)
</footer>
</body>
</html>
