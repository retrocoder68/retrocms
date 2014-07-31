RetroCMS - A lightweight Content Management System.
Copyright (C) 2014 J.Karlsson <j.karlsson@retrocoder.se>

--- Welcome to RetroCMS ---
RetroCMS is a very small and ligthweight CMS. I started writing RetroCMS
to have a small CMS with good performance on my hobby website retrocoder.se.

--- Features ---
RetroCMS contains the following features that has been implemented so far.
These are the bare minimum for me to start using RetroCMS.

- Registered users and public users.
A registered user can login and write and edit articles.
A public user and can only read articles.

- Articles
New articles can be written and existing articles edited.
All articles are published as soon as they are saved.

- Cookies not used, except for registered users when logged in.
- Javascript is not used at the moment but will in the future
but it should be possible to use the site with javascript turned off.
- Using HTML5 and CSS3.

--- Fetures to be added (short term) ---
- List articles based on publication date and/or on category
At the moment articles can not be given any category.
- List articles based on tags.

- Article content.
An article can contain text and html links.
Articles can also contain images
Articles can also contain youtube videos which can be viewed directly on site.

- Installation description and script should be included.
- Set and show a global message
- Set site in maintenance mode, where a messsage is shown to all users and no content is available.

--- Fetures to be added (long term) ---
- Site content can be backed  up manually
- Backup can be setup to run regularly.
- Recreate site content from backup.

- Search for an article.
It should be possible to search based on category, tags, publication date and/or article text.

- Visitor comments
Public users should be allowed to comment on articles.

- The site should be search engine friendly, i.e. basic SEO.
- Website should support all screen sizes.

--- Installation ---
- Prerequisites
To run RetroCMS you need a webserver running php and MySQL.

Steps to install RetroCMS
1. Download latest RetroCMS from github, see https://github.com/retrocoder68/retrocms.
Either download zip file or clone repository with git.
To clone with git, create a new folder and open a command prompt,
cd to the new folder and run the following command:
git clone https://github.com/retrocoder68/retrocms.git
1. Edit settings.php in the retrocms folder.
1.1 The following values has to be set correctly.
$_SETTINGS['dbserver']
$_SETTINGS['dbname']
$_SETTINGS['dbuser']
$_SETTINGS['dbpassword']
$_SETTINGS['site-server']

The other values can mostly be left untouched.

2. Edit the installation script install.php
Edit the installation script to create a user.

3. Open your web browser, go to your site and run install.php.
Done!

--- End
Thanks for using RetroCMS. Check my site retrocoder.se for news and please
let me know what you think about RetroCMS and if you have any problems using it.

//retrocoder