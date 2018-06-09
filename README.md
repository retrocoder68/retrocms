# RetroCMS - A lightweight Content Management System.

## Welcome to RetroCMS
RetroCMS is a very small and ligthweight CMS. I started writing RetroCMS
to have a small CMS with good performance on my hobby website retrocoder.se.

## Features
RetroCMS contains the following features that has been implemented so far.
These are the bare minimum for me to start using RetroCMS.

### Registered users and public users.
- A registered user can login, write and edit articles.
- A public user can only read articles.


### Articles
- New articles can be written and existing articles can be edited or deleted.
- All articles are published as soon as they are saved.
- Deleted articles are removed from the database and cannot not be retreived.

### Installation
- Installation script vith a step-by-step guide.

### Other features or prerequisites
  - Cookies not used, except for registered users when logged in.
  - Jquery is used and also bootstrap uses some javascript,
  but it should be possible to use the site with javascript turned off.
  - Bootstrap is used for formating.
  - Using HTML5 and CSS3.

## Fetures to be added
- List articles based on publication date and/or on category
At the moment articles can not be given any category.
- List articles based on tags.

- Article content.
  - An article can contain text and html links.
  - Articles can also contain images
  - Articles can also contain youtube videos which can be viewed directly on site.

## Fetures to be added (long term)
- Misc. features
  - Set and show a global message
  - Set site in maintenance mode, where a messsage is shown to all users and no content is available.


- Site content can be backed  up manually
  - Backup can be setup to run regularly.
  - Recreate site content from backup.


- Search for an article.
  - It should be possible to search based on category, tags, publication date and/or article text.


- Visitor comments
  - Public users should be allowed to comment on articles.


- The site should be search engine friendly, i.e. basic SEO.
- Website should support all screen sizes.

## Installation
### Prerequisites
To run RetroCMS you need a webserver running php and MySQL.

### Steps to install RetroCMS
1. Download latest RetroCMS from github, see https://github.com/retrocoder68/retrocms.
Either download zip file or clone repository with git.
To clone with git, create a new folder and open a command prompt,
cd to the new folder and run the following command:
git clone https://github.com/retrocoder68/retrocms.git
2. Open your web browser, go to your site and run install.php.
3. The installation script will guide you through a few steps to fill
in the values stored in settings.php and create the database and tables needed.
  - The installation script will fill in the following values that 
has to be set correctly.
```
$_SETTINGS['dbserver']
$_SETTINGS['dbname']
$_SETTINGS['dbuser']
$_SETTINGS['dbpassword']
$_SETTINGS['site-server']
```

Done!

## End
Thanks for using RetroCMS. Check my site [retrocoder.se](https://retrocoder.se) for news and please
let me know what you think about RetroCMS and if you have any problems using it.

//retrocoder

Copyright (C) 2014 J.Karlsson <j.karlsson@retrocoder.se>
