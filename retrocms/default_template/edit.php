<?php global $article, $authenticated_user, $username, $userid; ?>
<!DOCTYPE html>
<html>
<!-----------------------------------------------------------------------------
 edit.php - RetroCMS, a lightweight Content Management System.

 The default edit page.
 
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
<head><title>RetroCMS - edit</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <h1>RetroCMS</h1>
        <div class="col-lg-12">
            <div class="well">
                <h2>Edit article</h2>
                <form action="?ai=<?php actionid("ADD");?>&ti=<?php typeid("ARTICLE");?>" method="post">
                    <div class="form-group">
                        <label for="title">title</label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $article['title'];?>">
                    </div>
<!--                <div class="form-group">
                        <label for="shortname">shortname</label>
                        <input type="text" class="form-control" name="shortname" id="shortname" value="<?php echo $article['shortname'];?>">
                    </div> -->
                    <div class="form-group">
                        <label for="text">text</label>
                        <textarea class="form-control" rows="5" name="text" id="text"><?php echo $article['text'];?></textarea>
                    </div>
<!--                <div class="form-group">
                        <label id="save time" for="save_time">save time</label>
                        <input type="text" class="form-control" name="save_time" id="save_time" value="<?php echo $article['save_time'];?>">
                    </div> -->
<!--                <div class="form-group">
                        <label id="status" for="status">status</label>
                        <input type="text" class="form-control" name="status" id="status" value="<?php echo $article['status'];?>">
                    </div> -->
<!--                <div class="form-group">
                        <input type="submit" class="form-control" id="submit" name="save" value="Save">
                        <input type="submit" class="form-control" id="button_save" name="status" value="Save">
                    </div>  -->
                    <div class="form-group">
                        <input type="submit" name="publish" value="Publish">
                    </div>
                    <input type="hidden" name="art_id" value="<?php echo $article['art_id'];?>">
                </form>
            </div>
        </div>
        <p><a href="<?php echo setting('site-protocol').setting('site-server').setting('site-root');?>">Back to start page.</a></p>
    </div>
</div>
</body>
</html>
