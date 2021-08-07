<?php
//use Frame\Frame;//目录+类名;
define("DS",DIRECTORY_SEPARATOR);
define("ROOT_PATH",getcwd().DS);//当前目录，网站根目录
define("APP_PATH",ROOT_PATH."Admin".DS);
//首先要引入框架类
require_once(ROOT_PATH."Frame".DS."Frame.class.php");
//调用框架初始化方法
Frame\Frame::run();

