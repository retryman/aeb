readme.txt
本文件里面全部为文字说明，用来保存文件的基本介绍
所有文件名称全部小写

目录介绍
class/
   类文件存放地方
class/base
 基本类文件存放，包括Sql的调用，Memcache的使用
class/base/third
 第三方类的，如Smarty，PHPFIRE等，对原文件可能进行一下基本的处理
class/condenast/
 专属目录 

config/
 配置文件存放目录,公存放本地和服务器不一样的配置
 如：condenast.config.php
 

log/
存放日志目录，
  以：日期/项目名称/服务器IP/日志名称.log 
  如：20110701/condenast/192.168.1.11/default.log 默认日志
     20110701/condenast/192.168.1.11/pdomm.log 数据库错误日志
 