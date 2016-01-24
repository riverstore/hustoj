# Introduction #

SAE is Sina App Engine


# Details #

enable storage service
  * add public storage domain "web" in your app
  * add dir "upload" in "web" domain
  * add private storage domain "data" in your app

edit web/include/db\_info.inc.php :
  * $OJ\_SAE=true;
  * $SAE\_STORAGE\_ROOT="http://hustoj-web.stor.sinaapp.com/"; replace "http://hustoj-web.stor.sinaapp.com/" with your storage web root

edit /web/fckeditor/editor/filemanager/connectors/php/config.php
  * $OJ\_SAE=true;
  * $SAE\_STORAGE\_ROOT="http://hustoj-web.stor.sinaapp.com/"; replace "http://hustoj-web.stor.sinaapp.com/" with your storage web root