<!DOCTYPE html>
<html>
<!-----------------------------------------------------------------------------
 login.php - RetroCMS, a lightweight Content Management System.

 The default login page.
 
 Author: J.Karlsson <j.karlsson@retrocoder.se>
 Copyright (C) 2016 J.Karlsson. All rights reserved.

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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <h1>Login to RetroCMS</h1>
        <div class="col-lg-6">
            <div class="well">
                <form action="index.php?ai=<?php actionid("LOGIN");?>" method="post">
                    <div class="form-group">
                        <label for="user">user</label><input type="text" class="form-control" name="user" id="user">
                    </div>
                    <div class="form-group">
                        <label for="password">password</label><input type="password" class="form-control" name="password" id="password">
                    </div>
                    <input type="submit" id="submit" value="login">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
