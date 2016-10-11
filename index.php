<?php require("retrocms/retrocms.php");?>
<!DOCTYPE html>
<html lang="en">
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
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!--[if lt IE 9]>
  <!--      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> -->
  <!--      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> -->
  <!--[endif]-->
  <title>Example site using RetroCMS</title>
</head>
<body>
<?php if($authenticated_user){ ?>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Administration</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Logged in as <?php echo $username;?></a></li>
                    <li><a href="?ai=<?php actionid("LOGOUT");?>"><span class="glyphicon glyphicon-log-out"></span> logout</a></li>
                </ul>
            </div> <!-- class="navbar-collapse" -->
        </div> <!--  class="container" -->
    </nav>
<?php } ?>

<div class="container">
    <h1 class="page-header">Example site using RetroCMS</h1>
    <div class="col-md-2">
        <?php if(!$authenticated_user){ ?>
        <!-- Login Well -->
        <div class="well">
            <h4>Login</h4>
            <form action="?ai=<?php actionid("LOGIN");?>" method="post">
                <div class="form-group">
                    <label for="user">user</label><input type="text" class="form-control" name="user" id="user">
                </div>
                <div class="form-group">
                    <label for="password">password</label><input type="password" class="form-control" name="password" id="password">
                </div>
                <button class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-log-in"></span>
                </button>
            </form>
        </div> <!-- /Login Well -->
        <?php } else { ?>
        <!-- Admin tasks -->
        <div class="well">
            <h4>Admin tasks</h4>
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-unstyled">
                        <li><a href="?ai=<?php actionid("EDIT");?>&ti=<?php typeid("ARTICLE");?>">New article</a></li>
                    </ul>
                </div> <!-- /.col-lg-6 -->
            </div> <!-- /.row -->
        </div> <!-- /Admin tasks -->
        <?php } ?>
    
        <!-- Article list -->
        <div class="well">
            <h4>Articles</h4>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-unstyled">
                        <?php foreach(get_article_list() as $art){?>
                            <li><a href="?ai=<?php actionid("VIEW");?>&ti=<?php typeid("ARTICLE");?>&it=<?php echo $art['shortname'];?>"><?php echo $art['title']; ?></a></li>
                        <?php } ?>
                        <li><a href="?ai=<?php actionid("VIEW");?>&ti=<?php typeid("ARTICLE");?>">All articles</a></li>
                    </ul>
                </div>
            </div>
        </div> <!-- /Article list -->
    </div> <!-- class="col-md-4" sidebar -->
    <!-- Content column -->
    <div class="col-md-10">
        <?php
        if($typeid == ARTICLE){
            if(isset($item)){?>
                <div class="article" id="article-<?php echo $article['shortname'];?>">
                    <h2><?php echo $article['title']; ?></h2>
                    <p><span class="glyphicon glyphicon-time"></span> Posted <?php echo $article['save_time']; ?></p>
                    <?php if($authenticated_user){?>
                    <a class="btn btn-primary" href="?ai=<?php actionid("EDIT");?>&ti=<?php typeid("ARTICLE");?>&it=<?php echo $article['shortname'];?>"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                    <a class="btn btn-primary" href="?ai=<?php actionid("DELETE");?>&ti=<?php typeid("ARTICLE");?>&it=<?php echo $article['shortname'];?>"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                    <?php } ?>
                    <p><?php echo $article['text']; ?></p>
                </div> <!-- class="article" -->
            <?php } else {
                foreach(get_article_list() as $article){?>
                    <h2><?php echo $article['title']; ?></h2>
                    <p><span class="glyphicon glyphicon-time"></span> Posted <?php echo $article['save_time']; ?></p>
                    <a class="btn btn-primary" href="?ai=<?php actionid("VIEW");?>&ti=<?php typeid("ARTICLE");?>&it=<?php echo $article['shortname'];?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
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
    </div> <!-- /Content column -->
</div> <!-- class="container" -->
<div class="container">
    <hr>
    <footer>
        <p>Copyright &copy; 2016 J.Karlsson <a href="mailto:j.karlsson@retrocoder.se">&lt;j.karlsson@retrocoder.se&gt;</a></p>
    </footer>
</div> <!-- class="container" -->
</body>
<script src='https://code.jquery.com/jquery-2.1.4.min.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</html>
