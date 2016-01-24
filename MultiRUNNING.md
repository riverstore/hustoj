# Introduction #

judge.conf can set OJ\_RUNNING to run multi-judger on one machine


# Details #

to improve OJ speed
  * edit /home/judge/etc/judge.conf to set OJ\_RUNNING=N (N>1)
  * mkdirs run0,run1,run2.....run(N-1) make sure the chown judge and chmod 755
  * sudo pkill -9 judged && sudo judged

