<?php global $article, $authenticated_user, $username, $userid; ?>
<!DOCTYPE html>
<html>
<!-----------------------------------------------------------------------------
 edit.php - RetroCMS, a lightweight Content Management System.

 The default edit page.
 
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
<head><title>RetroCMS - edit</title>
<link rel="stylesheet" type="text/css" href="retrocms/default_template/css/dark-x.css">
</head>
<body>
<div id="main">
    <div id="content">
        <h1>RetroCMS</h1>
        <div class="edit-box "id="article-edit">
            <form class="edit" action="?ai=<?php actionid("ADD");?>&ti=<?php typeid("ARTICLE");?>" method="post">
                <h2>Edit article</h2>
                <label id="title" for="title">title</label>
                <input type="text" name="title" id="title" value="<?php echo $article['title'];?>">
<!--                <label id="shortname" for="shortname">shortname</label>
                <input type="text" name="shortname" id="shortname" value="<?php echo $article['shortname'];?>"> -->
                <label id="text" for="text">text</label>
                <textarea name="text" id="text"><?php echo $article['text'];?></textarea>
<!--                <input type="text" name="text" id="text" value="<?php echo $article['text'];?>"> -->
<!--                <label id="save time" for="save_time">save time</label>
                <input type="text" name="save_time" id="save_time" value="<?php echo $article['save_time'];?>"> -->
<!--                <label id="status" for="status">status</label>
                <input type="text" name="status" id="status" value="<?php echo $article['status'];?>"> -->
<!--                <input type="submit" id="submit" name="save" value="Save"> -->
                <input type="submit" id="submit" name="publish" value="Publish">
                <input type="hidden" name="art_id" value="<?php echo $article['art_id'];?>">
            </form>
        </div> <!-- id="article-edit" -->
        <p><a href="<?php echo setting('site-protocol').setting('site-server').setting('site-root');?>">Back to start page.</a></p>
    </div> <!-- id="content" -->
</div> <!-- id="main" -->
<footer>
    Copyright (C) 2014 J.Karlsson (j.karlsson@retrocoder.se)
</footer>
</body>
</html>
