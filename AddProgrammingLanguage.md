# Introduction #



Python for example


# Details #

  * write A+B problem solution in this language.
```
#!/usr/bin/python
a=input()
b=input()
print a+b
```

  * strace to check minimal syscalls,if you want 32-bits do it under 32-bits ,if you want a 64-bits do it under 64-bits too.
```
strace -ff python Main.py 2>&1|awk -F\( '{print $1}'|sort -u
```
output like:
```
access
......
write
```
  * copy the calls names to add new arrays in to okcalls.h,remember to add twice for both 32-bits and 64-bits, like [r747](https://code.google.com/p/hustoj/source/detail?r=747)
```
int LANG_YV[256]={SYS_access,SYS_write.....};
int LANG_YC[256]={-1,-1,......,0};
#else
int LANG_YV[256]={};
int LANG_YC[256]={0};
```
  * new way**update judge\_client to [r2122](https://code.google.com/p/hustoj/source/detail?r=2122)+
```
do follow steps first then run command line like
sudo judge_client 2028 0 /home/judge/ debug Y
```
> will get
```
int LANG_YV[256]={3,4,5,6,11,33,45,54,85,91,122,125,140,174,175,183,191,192,195,196,197,199,200,201,202,220,240,243,252,258,295,311,0};
int LANG_YC[256]={HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,HOJ_MAX_LIMIT,0};
```
> use these lines for corresponding section (i386/x\_64)**


  * edit judge\_client.cc
    * lang\_ext add new ext for lang , "py" for python,[r749](https://code.google.com/p/hustoj/source/detail?r=749)
    * init\_syscalls\_limits add new route for python,[r750](https://code.google.com/p/hustoj/source/detail?r=750)
    * compile or chmod for python, [r751](https://code.google.com/p/hustoj/source/detail?r=751)
    * add void copy\_python\_runtime(char **work\_dir),if there is a vm or runtime libs needed to copy into chroot dir. use "whereis python" "ldd /usr/bin/python" to locate the files,[r752](https://code.google.com/p/hustoj/source/detail?r=752),[r761](https://code.google.com/p/hustoj/source/detail?r=761)
    * add python run command in run\_solution(),[r753](https://code.google.com/p/hustoj/source/detail?r=753)-[r756](https://code.google.com/p/hustoj/source/detail?r=756)
  * recompile core using make.sh
  * add a new problem to test new language
  * submit the solution with an exist language
  * modify database to set language=6 and rejudge
```
update solution set language=6,result=0 where solution_id=2028;
```
  * if encounted CE or RE debug with
```
judge_client 2028 0 /home/judge debug
```
  * if you finally get AC on the A+B problem showed "Other Language", continue for web.**

  * web/include/const.inc.php add "Python" before "Other Language",[r764](https://code.google.com/p/hustoj/source/detail?r=764)

  * web/submitpage.php, add Python select option, [r765](https://code.google.com/p/hustoj/source/detail?r=765)
  * web/showsource.php, add Python high lighten , [r766](https://code.google.com/p/hustoj/source/detail?r=766)
  * web/conteststatistics.php, add Python statistic , [r767](https://code.google.com/p/hustoj/source/detail?r=767)
  * web/admin/contest\_add.php, add Python langmask option,[r769](https://code.google.com/p/hustoj/source/detail?r=769)
  * web/admin/contest\_edit.php, add Python langmask edit option,[r770](https://code.google.com/p/hustoj/source/detail?r=770)