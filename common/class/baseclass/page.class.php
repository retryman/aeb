<?php
/**
 * @filename page.class.php
 * @desc 分页类 快速创建分页的程序 SQL_CALC_FOUND_ROWS 这个东西非常棒哦
 * @author leo(suwi.bin) - bin.yu@condenast.com.cn
 * @date 2012-03-23
 */

class Page
{
    /**
     * @desc 设置访问的类
     * @var array
     */
    private static $_instance = null;

    /**
     * @desc 保存配置数据
     * @var array
     */
    private static $_config = null;

    /**
     * @desc 个性加载 加载本类
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public static function getInstance()
    {
        if(null === self::$_instance) 
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * @desc 配置函数
     * @param config(array)
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public static function config($config)
    {
        self::$_config = $config;
        self::$_config['pagename']    = (isset($config['pagename']) && $config['pagename']) ? $config['pagename'] : 'pageturn';
        self::$_config['maxpage']     = (isset($config['maxpage']) && $config['maxpage']) ? $config['maxpage'] : 10;//显示的页数
        self::$_config['maxnum']      = (isset($config['maxnum']) && $config['maxnum']) ? $config['maxnum'] : 20;//每页的记录数
        self::$_config['curpage']     = self::$_config['current'] = (isset($config['current']) && $config['current']) ? intval($config['current']) : 1;//当前页数
        self::$_config['path']        = (isset($config['path']) && $config['path']) ? $config['path'] : '';
        self::$_config['smarty']      = true;
        self::$_config['template']    = isset($config['template']) && strstr($config['template'], 'turn') ? $config['template'].'.html' : 'turn/' . $config['template'].'.html';
        self::$_config['id']          = (isset($config['id']) && $config['id']) ? $config['id'] : false;
        self::$_config['totalpage']   = 1;
        self::$_config['suffix']      = (isset($config['suffix']) && $config['suffix']) ? $config['suffix'] : '';
        self::$_config['pageturn']    = (isset($config['pageturn']) && $config['pageturn']) ? $config['pageturn'] : '&' . self::$_config['pagename'] . '=';
        self::$_config['return']      = (isset(self::$_config['return']) && isset(self::$_config['return'])) ? self::$_config['return'] : 'string';
        self::$_config['sql']         = isset(self::$_config['sql']) ? self::$_config['sql'] : '';
        return self::$_instance;
    }

    /**
     * @desc 获取数据
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public static function get()
    {
        return array('data' => self::_handle(),'page' => self::_turn(),'total' => self::$_config['totalnum'],'maxpage'=>self::$_config['totalpage'],'sql' => self::$_config['sql']);
    }

    /**
     * @desc 分页处理机制
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private static function _handle()
    {
        self::_load();
        self::_write();

        self::$_config['offsetnum']   = self::$_config['maxnum'] * (self::$_config['current']-1);
        self::$_config['offsetpage']  = self::$_config['maxnum']+self::$_config['offsetnum'];
        if(isset(self::$_config['dbtype']) && self::$_config['dbtype'] == 'data')
        {
            self::$_config['sql'] = '*';
            $data = array(self::$_config['offsetnum'], self::$_config['maxnum']);
            self::$_config['totalnum'] = self::$_config['dbCount'];

            if(isset(self::$_config['dbData']))
            {
                self::$_config['dbData'] = array_values(self::$_config['dbData']);
                $data = array();
                # 分页数据处理
                if(self::$_config['totalnum'] > self::$_config['maxnum'])
                {
                    $total = self::$_config['maxnum']+self::$_config['offsetnum'];
                    for($i=self::$_config['offsetnum']; $i<$total; $i++)
                    {
                        if(isset(self::$_config['dbData'][$i]) && self::$_config['dbData'][$i])$data[] = self::$_config['dbData'][$i];
                    }
                }
                else
                {
                    if(self::$_config['current'] == 1)
                    {
                        $data = self::$_config['dbData'];
                    }
                    
                }
            }
        }
        else
        {
            self::$_config['sql'] = str_ireplace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', self::$_config['sql']).' LIMIT '.self::$_config['offsetnum'].', '.self::$_config['maxnum'].'';
            $data = self::$_config['db']->fetchAll(self::$_config['sql'], self::$_config['id']);
            self::$_config['totalnum'] = self::$_config['db']->fetchSclare('SELECT found_rows()');
        }
        return $data;
    }

    /**
     * @desc 计算分页
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private static function _turn()
    {
        if(self::$_config['totalnum'] < 1)
        {
            return;
        }
        self::$_config['totalpage']    = ceil(self::$_config['totalnum']/self::$_config['maxnum']);
        self::$_config['curpage']      = (self::$_config['totalpage'] < self::$_config['curpage']) ? self::$_config['totalpage'] : self::$_config['curpage'];
        self::$_config['offsetpage']   = (self::$_config['offsetpage']-self::$_config['totalnum']>0) ? self::$_config['totalnum'] : self::$_config['offsetpage'];
        self::$_config['turnnext']     = self::$_config['totalpage'];

        //开始计算分页
        if(self::$_config['totalpage'] <= 1)
        {
            if(self::$_config['maxnum'] == self::$_config['totalnum'])
            {
                $totalpage = self::getTurn((self::$_config['totalpage']));
            }
            else
            {
                $totalpage = self::getTurn(self::$_config['totalpage']);
            }
            return $totalpage;
        }
        if(self::$_config['totalnum'] > self::$_config['maxnum'])
        {
            //当前总页数小于等于定义的最大页数
            if(self::$_config['totalpage'] <= self::$_config['maxpage'])
            {
                self::$_config['start'] = 1;
                self::$_config['end']   = self::$_config['totalpage'];
            }
            else
            {
                if(self::$_config['current'] < intval(self::$_config['maxpage']/2))
                {
                    self::$_config['start'] = 1;
                }
                else if(self::$_config['current'] <= self::$_config['totalpage']-self::$_config['maxpage'])
                {
                    self::$_config['start'] = self::$_config['current']-intval(self::$_config['maxpage']/2);
                }
                else if(self::$_config['current'] > self::$_config['totalpage']-self::$_config['maxpage'] && self::$_config['current'] <= self::$_config['totalpage']-intval(self::$_config['maxpage']/2))
                {
                    self::$_config['start'] = self::$_config['current']-intval(self::$_config['maxpage']/2);
                }
                else if(self::$_config['current'] > self::$_config['totalpage']-intval(self::$_config['maxpage']/2))
                {
                    self::$_config['start'] = self::$_config['totalpage']-self::$_config['maxpage']+1;
                }
                self::$_config['end'] = self::$_config['start'] + self::$_config['maxpage']-1;
                if(self::$_config['start'] < 1)
                {
                    self::$_config['end'] = self::$_config['current']+1-self::$_config['start'];
                    self::$_config['start'] = 1;
                    if((self::$_config['end'] - self::$_config['start']) < self::$_config['maxpage'])
                    {
                        self::$_config['end'] = self::$_config['maxpage'];
                    }
                }
                elseif(self::$_config['end'] > self::$_config['totalpage'])
                {
                    self::$_config['start'] = self::$_config['totalpage']-self::$_config['maxpage']+1;
                    self::$_config['end']      = self::$_config['totalpage'];
                }
            }
            if(intval(self::$_config['totalnum']%self::$_config['maxnum']) == 0)
            {
                self::$_config['turnnext'] = self::$_config['turnnext']+1;
            }
        }

        if(self::$_config['return'] == 'array')
        {
            return self::$_config;
        }

        if(isset(self::$_config['smarty']) && self::$_config['smarty'] == true)
        {
            $smarty = self::_value('smarty') ? self::_value('smarty') : new CondeSmarty();
            $smarty->assign('template', self::$_config);
            self::$_config['turnpage'] = $smarty->fetch(self::$_config['template']);
           
            return self::$_config['turnpage'];
        }
        else
        {
            self::$_config['template'] = PROJECT_ROOT_PATH . '/templates/' . (defined('PROJECT_ENTRY_NAME') ? PROJECT_ENTRY_NAME : PROJECT_NAME) . '/' . self::$_config['template'];
            ob_start();
            $template = self::$_config;
            include(self::$_config['template']);
            self::$_config['turnpage'] = ob_get_contents();
            ob_end_clean();
            return self::$_config['turnpage'];
        }
    }

    private static function _value($key, $value = false)
    {
        return $GLOBALS[$key] = $value == false ? (isset($GLOBALS[$key]) ? $GLOBALS[$key] : false) : $value;
    }

    /**
     * @desc 写入session
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private static function _write()
    {
        if(defined('AJAX') && AJAX != 1) return;
        $_SESSION['pageMemory'][md5(self::$_config['sql'])] = self::$_config['current'];
        return;
    }

    /**
     * @desc 根据规则确定当前页,非ajax模式下可取回记忆数据
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private static function _load()
    {
        if((isset($_GET[self::$_config['pagename']]) && $_GET[self::$_config['pagename']]) && $_GET[self::$_config['pagename']] > 0) return self::$_config['current'] = $_GET[self::$_config['pagename']];
        
        if(defined('AJAX') && AJAX != 1) 
        {
            //当刷新页面时(非ajax)取回记忆数据
            $key = md5(self::$_config['sql']);
            if($_SESSION['pageMemory'][$key] > 0) {
                return self::$_config['current'] = $_SESSION['pageMemory'][$key];
            }
        }
        
        return self::$_config['current'];
    }

    public static function getTurn($value)
    {
        return '<!--maxpage:'.$value.':maxpage-->';
        return '<input type="hidden" id="maxpage" name="maxpage" value="'.$value.'">';
    }
}
