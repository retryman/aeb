<?php
/**
 * @file ini.php
 * @desc 处理基本类的操作信息，只要包含此函数，就可使用此目录下面的所有类
 *
 * @author alfa 2011-2-17
 **/
 
/// 一定要定义项目名称
if(!defined("PROJECT_NAME"))
{
    exit("Undefind Project Name / 末定义项目名称!");
}
/// 一定要定义项目路径
if(!defined("PROJECT_ROOT_PATH"))
{
    exit("Undefined Project Root Path / 末定义项目路径!");
}


/**
 * @desc MMPF(condenastPhpFrameWork) 核心功能
 * 主要处理类的加载功能
 * @author alfa
 *
 */
class MMPFCore {

    /**
     * @desc 保存加载函数有没有被调用过，此函数如果被调 用过，就不会再次被调用
     * @var string
     */
    static private $isLoaded;
    /**
     *
     * @desc 注册函数，调用自身的类函数，用来加载所有MMPF的基本类
     * @author alfa  2011-2-17
     */
    static public function registerAutoload()
    {
        if(self::$isLoaded == "MMPF_LOADED" )
        {
            return true;
        }
        /// 调用加载函数
        spl_autoload_register(array("MMPFCore", 'loadClass'));
        self::$isLoaded = "MMPF_LOADED";
        return true;
    }
    
    /**
     *
     * @desc 加载函数，加载所有的类
     * @param $classname 类的名称
     * @author alfa  2011-2-17
     */
    static public function loadClass($classname)
    {        
        $classpath = dirname(__FILE__);

        /// 第三方类文件
        $thirdClassArr = array("FirePHP","BluePage","PHPMailer", "Smarty" );
        /// 基本类
        $baseClassArr = array("Mysql","DB","Cache","Debug","Input","Config","ErrorLog","String","Security","Page", 'Http', 'Img', 'Upload', 'Qips', 'Oauth', 'SecCode');

        /// 实用类
        $entityClassArr = array("CondeMail", 'CondeSmarty', 'CondeForumAPI', 'CondeSayAPI', 'ClearCache', 'CondePermApi','CondeSMS', 'CondSecCode', 'CondeWeibo','CondeAdminUser', 'CondeCMSAPI');

        /// 存储工具 add by yubin
        $storeClassArr = array("Store", 'Store_Mysql', 'Store_Sqlite', 'Store_Sql', 'Store_Value', 'Store_Stat', 'Store_Ttable');

        /// 统计工具 add by yubin
        $appenderClassArr = array('Appender_Stowage', 'Appender_Form');
        
        /// 包含第三方类
        if(in_array($classname, $thirdClassArr))
        {
            return include $classpath . "/class/baseclass/third/" . strtolower($classname) . "/" . strtolower($classname) .".class.php";
        } 
        
        /// 包含基本类
        if(in_array($classname, $baseClassArr))
        {
            return include $classpath . "/class/baseclass/" . strtolower($classname) . ".class.php";
        }
        /// 包含实用类
        if(in_array($classname, $entityClassArr))
        {
            
            return include $classpath . "/class/condenast/" . strtolower($classname) . ".class.php";
        }

        /// 包含存储工具类  add by yubin
        if(in_array($classname, $storeClassArr))
        {
            return include $classpath . "/class/baseclass/store/" . strtolower($classname) . ".class.php";
        }

        /// 包含统计工具类  add by yubin
        if(in_array($classname, $appenderClassArr))
        {
            return include $classpath . "/class/baseclass/appender/" . strtolower($classname) . ".class.php";
        }
        
        //按照一定规则生成的类名，可以与目录名称对应
        $classpath = str_replace('_', DIRECTORY_SEPARATOR, strtolower($classname));
        $path = PROJECT_ROOT_PATH.'/class/'.$classpath.'.class.php';
        
        if (file_exists($path))
        {
            return include $path;
        }    
        else
        {
            $path = PROJECT_ROOT_PATH . DIRECTORY_SEPARATOR . $classpath . '.class.php';
            if (file_exists($path))
            {
                return include $path;
            }    
            else
            {
                return false;
            }        
        }        
    } 
}
/// 自动加载此目录下面的所有文件
MMPFCore::registerAutoload();

//输入信息初始化，所有的信息都可以通过Input提供的方法来获取
Input::Init();

Input::GetClientIP();
/// Debug初始化
/// 打开规则：
/// 1、配置文件里面打开
/// 2、输入参数里面加上：debug=condenast_inc 同时 debug里面请允许调试的IP之内 
if(Config::get("debug") || (Input::getInput("debug") == "condenast_inc" && (Config::get("debugip")=="ALL"||    (is_array(Config::get("debugip"))&&in_array(Input::GetClientIP(), Config::get("debugip"))))))
{
    /// 打开PHP本身的错误及警告信息
    ini_set("display_errors", true);
    error_reporting(E_ALL);
    
    /// 启动Debug 记录
    ob_start();
    Debug::start();
    Debug::log("Begin", "Program Begin ","Progran");
    register_shutdown_function(array('Debug', 'show'));
}
else 
{
    /// 关闭PHP警告信息
    ini_set("display_errors", false);
    ini_set('error_reporting', false);
    error_reporting(0);
    
}
 ?>