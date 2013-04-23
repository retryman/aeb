<?php
/**
 * @sourcename store.class.php
 * @desc 数据通用类
 * @author leo(suwi.bin) - bin.yu@condenast.com.cn
 * @date 2012-05-8
 */

class Store
{
    /**
     * @desc key的配置
     * @var string
     */
    private $_key = '';

    /**
     * @desc 配置
     * @var config
     */
    private $_config = array();

    /**
     * @desc 类的实例化存储
     * @var array
     */
    static private $_intance = false;

    /**
     * @desc 实例化本类
     * @param key(string) 本次实例化的key，也是当前通用存储的目录地址
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    static public function getInstance($key)
    {
        if(!self::$_intance)
        {
            self::$_intance = new self();
        }

        self::$_intance->setKey($key);
        self::$_intance->initialize();
        return self::$_intance;
    }

    /**
     * @desc 设置key
     * @param key(string) 当前通用存储的目录地址
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function setKey($key)
    {
        $this->_key = md5($key);
        $this->_config['key'][$this->_key] = $key;
        $this->_config[$this->_key] = array();
        $this->_config[$this->_key]['file'] = $key . DIRECTORY_SEPARATOR . 'cfg' . DIRECTORY_SEPARATOR . 'store.cfg.php';
    }

    /**
     * @desc 初始化，获取配置
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function initialize()
    {
        if(!isset($this->_config[$this->_key]['config']) && file_exists($this->_config[$this->_key]['file']))
        {
            # 判断是否存在可写型配置
            $this->_config[$this->_key]['writeFile'] = $this->createPath($this->createPath(PROJECT_ROOT_PATH . '/write/') . 'store_config/') . str_replace('/', '_', $this->_config['key'][$this->_key]) . '.cfg.php';
            if(file_exists($this->_config[$this->_key]['writeFile']))
            {
                include($this->_config[$this->_key]['writeFile']);
            }
            else
            {
                include($this->_config[$this->_key]['file']);
                file_put_contents($this->_config[$this->_key]['writeFile'], '<?php $_STORE = ' . var_export($_STORE, true) . ';?>');
            }
            $this->_config[$this->_key]['config'] = $_STORE;
        }
    }

    /**
     * @desc 载入通用存储类，并直接载入方法
     * @param method(string) 通用存储类开放的方法
     * @param table(string) 要使用的表名
     * @param data(array) 传输的数据
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function load($method, $table, $data = array())
    {
        if($method == 'stat')
        {
            //主动统计功能
            $array = $this->load('select', $table, $data);

            //主动统计功能
            $config['request'] = $_REQUEST;
            $config['mode'] = $data['stat']['mode'] ? $data['stat']['mode'] : array('form','chart-sweep','chart-cake');
            $config['col'] = $data['stat']['col'];
            $config['key'] = $data['stat']['key'];
            $data['stat']['value'] = isset($data['stat']['value']) ? $data['stat']['value'] : array();
            $stat = new Store_Stat(array('', $array, $data['stat']['value']));
            $config['data'] = $stat->data();
            $stowage = new Appender_Stowage($config);
            print_r($stowage->html());die;
        }
        $array = array('select', 'update', 'insert', 'delete', 'selectOne', 'add');
        if(in_array($method, $array))
        {
            $data['table']  = $table;
            $data['config'] = $this->_key($table);
            $data['key']    = md5($table);
            $data['store']  = $this;
            $return = $this->loadClass($this->_config[$this->_key]['config'][$table]['type'])->$method($data);
        }
        else
        {
            $return = array();
        }
        return $return;
    }

    private function _key($table)
    {
        if(isset($this->_config[$this->_key]['config'][$table]))
        {
            return $this->_config[$this->_key]['config'][$table];
        }
        else
        {
            unset($this->_config['key'][$this->_key]);
            foreach($this->_config['key'] as $k => $v)
            {
                $this->_key = $k;
            }
            return $this->_key($table);
        }
    }

    /**
     * @desc 获取通用存储下的类
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function loadClass($name)
    {
        if(!isset($this->_config[$this->_key]['class'][$name]))
        {
            $className = 'Store_' . ucwords($name);

            $this->_config[$this->_key]['class'][$name] = new $className();
        }

        return $this->_config[$this->_key]['class'][$name];
    }

    /**
     * @desc 建立目录
     * @param path(string) 目录名称
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function createPath($path)
    {
        if(!is_dir($path))
        {
            mkdir($path, 0775);
            exec('chmod 777 ' . $path);
        }
        return $path;
    }


    /**
     * @desc 对字符串进行结构化解析（批量）
     * @param struct(string) 字符串
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function loopStruct($struct)
    {
        //$struct = base64_decode($struct);
        $list = array('where', 'data');
        if(strstr($struct, '*'))
        {
            $data = explode('*', $struct);
            foreach($list as $k => $v)
            {
                $return[$v] = $this->struct($data[$k]);
            }
        }
        else
        {
            $return = $this->struct($struct);
        }
        return $return;
    }

    /**
     * @desc 对字符串进行结构化解析（单独）
     * @param struct(string) 字符串
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function struct($struct)
    {
        $array = explode('%%', $struct);
        $return = '';
        foreach($array as $k => $v)
        {
            if(isset($v) && $v != '')
            {
                if(strstr($v, '^'))
                {
                    $i = explode('^', $v);
                    if(strstr($i[0], '-'))
                    {
                        $i[0] = str_replace('-', '^', $i[0]);
                    }
                    if(strstr($i[0], '>'))
                    {
                        $i[0] = str_replace('>', '^>', $i[0]);
                    }
                    if(strstr($i[0], '<'))
                    {
                        $i[0] = str_replace('<', '^<', $i[0]);
                    }
                    if(strstr($i[0], 'like'))
                    {
                        $i[0] = str_replace('like', '^like', $i[0]);
                    }
                    $i[1] = $this->parseTime($v, $i[1]);
                    $return[$i[0]] = $i[1];
                }
                else
                {
                    $return[$k] = $v;
                }
            }
        }
        return $return;
    }

    /**
     * @desc 对数组进行结构化反解析（批量）
     * @param array(array) 数组
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function loopUnstruct($array)
    {
        if(isset($array['where']) && isset($array['data']))
        {
            $struct = $this->unstruct($array['where']) . '*' . $this->unstruct($array['data']);
        }
        else
        {
            $struct = $this->unstruct($array);
        }

        return $struct;
    }

    /**
     * @desc 对数组进行结构化反解析（单独）
     * @param array(array) 数组
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function unstruct($array)
    {
        $struct = '';
        foreach($array as $k => $v)
        {
            if(strstr($k, '>') || strstr($k, '<'))
            {
                $k = str_replace('^', '', $k);
            }
            if(strstr($k, '^'))
            {
                $k = str_replace('^', '-', $k);
            }
            $struct .= $k . '^' . $v . '%%';
        }
        
        $struct = ereg_replace('\%%$', '', $struct);
        return $struct;
    }

    /**
     * @desc 解析数据
     * @param array(array) 数组
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function parse($data)
    {
        foreach($data as $k => $v)
        {
            if(strstr($v, '^'))
            {
                $array = explode('^', $v);
                switch($array[0])
                {
                    case 'date':
                        $array[2] = $array[2] == 'time' ? time() : $array[2];
                        $array[3] = isset($array[3]) ? $array[3] : 0;
                        $data[$k] = date($array[1], $array[2]+$array[3]);
                        break;
                    case 'time':
                        break;
                }
            }
        }
        return $data;
    }

    /**
     * @desc 解析时间
     * @param col(string) 字段
     * @param value(string) 值
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function parseTime($col, $value)
    {
        if(strstr($col,'cdate') && strstr($value, ' '))
        {
            $t = explode(' ', $value);
            $k = explode('-', $t[0]);
            $v = explode(':', $t[1]);
            $value = mktime($v[0], $v[1], $v[2], $k[1], $k[2], $k[0]);
        }
        elseif(strstr($col,'cdate') && strstr($value, '-'))
        {
            $t = explode('-', $value);
            $value = mktime($t[3], $t[4], $t[5], $t[1], $t[2], $t[0]);
        }
        return $value;
    }

    /**
     * @desc 错误记录
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _error($error)
    {
        Debug::log("store error", $error, "store");
    }

    /**
     * @desc 日志记录
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _log($msg)
    {
        Debug::log("store log", $msg, "store");
    }
}
