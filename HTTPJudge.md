# Introduction #

judged is supporting http connect to the web/mysql now.

with this new feature, any web space supported mysql+php can be used as the web site of OJs , no matter it's windows or linux ,remote mysql(3306) is supported or not .

and a side effect is by using the http mode a set of loadage is moved from the mysql server to the http server (apache) and share the pool-like pconnect system with php.

judge\_client will fork wget to access web/admin/problem\_judge.php,if you are trying to implement web UI with language and databases other than php/mysql, it's a good idea to implement problem\_judge.php with your JSP/.NET application and process all requests from wget.

Even more, the latest hustoj is now possible running on SAE(sina application Engine).

# Details #
  * apt-get install wget
  * update latest web code from svn
  * register a new user and add privilege of "http\_judge"
  * add/edit settings in /home/judge/etc/judge.conf
```
OJ_HTTP_JUDGE=1
OJ_HTTP_BASEURL=http://127.0.0.1/JudgeOnline
OJ_HTTP_USERNAME=admin
OJ_HTTP_PASSWORD=admin
```
OJ\_HTTP\_JUDGE for enable this feature

OJ\_HTTP\_BASEURL give the URL of the OJ-web

OJ\_HTTP\_USERNAME is the new user mentioned above with http\_judge authorize

OJ\_HTTP\_PASSWORD is the password

**disable vcode in db\_info.inc.php on SAE ,to let judge client login with http. you can enable it after the judge working, but need to disable it every time judged reboot or reinstall**