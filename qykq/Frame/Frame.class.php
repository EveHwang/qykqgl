<?php
//声明命名空间：目录名称
namespace Frame;

final class Frame
{
    //初始化方法：
    public static function run()
    {
        self::initConfig();		//引入配置信息
        self::initRoute();		//初始化路由参数
        self::initConst();		//初始化目录常量
        self::initAutoLoad();	//初始化类的自动加载
        self::initDispatch();	//请求分发
    }

    //引入配置信息
    private static function initConfig()
    {
        session_start();
        $GLOBALS['config']=require_once(APP_PATH.'Conf'.DS.'Config.php');
    }

    //初始化路由参数
    private static function initRoute()
    {
        $p = $GLOBALS['config']['default_paltform'];
        //获取控制器名称和用户动作
        $c = isset($_GET['c'])?$_GET['c']:$GLOBALS['config']['default_controller'];
        $a = isset($_GET['a'])?$_GET['a']:$GLOBALS['config']['default_action'];
        define("PLAT",$p);
        define("CONTROLLER",$c);
        define("ACTION",$a);
    }

    //初始化目录常量
    private static function initConst()
    {
        define("VIEW_PATH",APP_PATH."View".DS.CONTROLLER.DS);//View目录常量
    }

    // 初始化类的自动加载
    private static function initAutoLoad()
    {
        spl_autoload_register(function($className){
            $fileName = ROOT_PATH.str_replace("\\",DS,$className).".class.php";
            if(file_exists($fileName))
            {
                // echo $fileName."<br>";
                require_once($fileName);
            }
        });
    }

    // 请求分发
    private static function initDispatch()
    {

        $controllerClaseName = PLAT.'\\'.'Controller' .'\\'.CONTROLLER .'Controller';
        //创建类对象
        $controllerObj = new $controllerClaseName();
        $action_name = ACTION;
        $controllerObj->$action_name();
    }
}
