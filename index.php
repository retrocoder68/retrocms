<?php require("retrocms/retrocms.php");?>
<!DOCTYPE html>
<html>
<!-----------------------------------------------------------------------------
 index.php - Example using RetroCMS, a lightweight Content Management System.

 The main content page.
 
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
<head><title>Example site using RetroCMS</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php if($authenticated_user){ ?>
    <div id="topbar">
        <div id="admin-menu">
            <ul>
                <li>Logged in as <?php echo $username;?></a></li>
                <li><a href="?ai=<?php actionid("LOGOUT");?>">logout</a></li>
            </ul>
        </div> <!-- id="admin_menu" -->
    </div>
<?php } ?>

<div id="main">
    <div id="sidebar">
        <?php if(!$authenticated_user){ ?>
        <form class="login" action="?ai=<?php actionid("LOGIN");?>" method="post">
            <label id="user" for="user">user</label><input type="text" name="user" id="user">
            <label id="password" for="password">password</label><input type="password" name="password" id="password">
            <input type="submit" id="submit" value="login">
        </form>
        <?php } else { ?>
        <div id="admin-tasks">
            <ul>
                <li><a href="?ai=<?php actionid("EDIT");?>&ti=<?php typeid("ARTICLE");?>">New article</a></li>
            </ul>
        </div>
        <?php } ?>
    
        <div id="links">
            <ul>
            <?php foreach(get_article_list() as $art){?>
                <li><a href="?ai=<?php actionid("VIEW");?>&ti=<?php typeid("ARTICLE");?>&it=<?php echo $art['shortname'];?>"><?php echo $art['title']; ?></a></li>
            <?php } ?>
                <li><a href="?ai=<?php actionid("VIEW");?>&ti=<?php typeid("ARTICLE");?>">All articles</a></li>
            </ul>
        </div> <!-- id="links" -->
    </div> <!-- id="sidebar" -->

    <div id="content">
        <h1>Welcome to an example site using RetroCMS</h1>
        <?php
        if($typeid == ARTICLE){
            if(isset($item)){?>
                <div class="article" id="article-<?php echo $article['shortname'];?>">
                    <h2><?php echo $article['title']; ?></h2>
                    <p><?php echo $article['text']; ?></p>
                    <p>
                        Published: <?php echo $article['save_time']; ?>
                        <?php if($authenticated_user){?>
                            <a href="?ai=<?php actionid("EDIT");?>&ti=<?php typeid("ARTICLE");?>&it=<?php echo $article['shortname'];?>">Edit</a>
                            <a href="?ai=<?php actionid("DELETE");?>&ti=<?php typeid("ARTICLE");?>&it=<?php echo $article['shortname'];?>">Delete</a>
                        <?php } ?>
                    </p>
                </div> <!-- class="article" -->
            <?php } else {
                foreach(get_article_list() as $article){?>
                    <p class="article-list-item" id="article-item-<?php echo $article['shortname'];?>">
                        Title: <?php echo $article['title']; ?><br>
                        <a href="?ai=<?php actionid("VIEW");?>&ti=<?php typeid("ARTICLE");?>&it=<?php echo $article['shortname'];?>">Read more...</a>
                    </p>
                <?php }
            } ?>
        <?php } elseif($typeid == CATEGORY){?>
        <div class="category" id="category-1">
<!--            <h2>Title: <?php echo $category['title']; ?></h2>
            <p>Short: <?php echo $category['shortname']; ?></p>
            <p>Text: <?php echo $category['text']; ?></p>
            <p>Status: <?php echo $category['status']; ?></p> -->
        </div> <!-- class="category" -->
        <?php } elseif($typeid == TAG){?>
        <div class="tag" id="tag-1">
<!--            <h2>Title: <?php echo $tag['title']; ?></h2>
            <p>Short: <?php echo $tag['shortname']; ?></p>
            <p>Text: <?php echo $tag['text']; ?></p>
            <p>Status: <?php echo $tag['status']; ?></p> -->
        </div> <!-- class="tag" -->
        <?php } elseif($typeid == USER){?>
        <div class="user" id="user-1">
<!--            <h2>Title: <?php echo $user['title']; ?></h2>
            <p>Short: <?php echo $user['shortname']; ?></p>
            <p>Text: <?php echo $user['text']; ?></p>
            <p>Status: <?php echo $user['status']; ?></p> -->
        </div> <!-- class="user" -->
        <?php } ?>
    </div> <!-- id="content" -->
</div> <!-- id="main" -->

<footer>
    Copyright (C) 2014 J.Karlsson <a href="mailto:j.karlsson@retrocoder.se">&lt;j.karlsson@retrocoder.se&gt;</a>
</footer>
</body>
</html>
