<?php
/**
 * @sourcename store.class.php
 * @desc 数据统计类
 * @author leo(suwi.bin) - bin.yu@condenast.com.cn
 * @date 2012-05-8
 */

class Appender_Stowage
{
    /**
     * @desc 统计的模式，以后增加图表吧
     * @var string
     */
    private $_mode = array('form');

    /**
     * @desc 配置的数据
     * @var string
     */
    private $_config;

    /**
     * @desc 生成的数据
     * @var string
     */
    private $_data;

    /**
     * @desc 构造函数
     * @param config(array) 传过来的数据
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function __construct($config)
    {
        $this->_config = $config;

        $this->_check();
    }

    /**
     * @desc 检测模式
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    private function _check()
    {
        if(isset($this->_config['mode']))
        {
            if(is_array($this->_config['mode']))
            {
                foreach($this->_config['mode'] as $k => $v)
                {
                    $this->_appender($v);
                }
            }
            else
            {
                $this->_appender($this->_config['mode']);
            }
        }
    }
    
    /**
     * @desc 调用统计类
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    private function _appender($mode)
    {
        $send['data']       = $this->_config['data'];
        $send['request']    = $this->_config['request'];
        $send['col']        = $this->_config['col'];
        $send['key']        = $this->_config['key'];

        if(in_array($mode, $this->_mode))
        {
            $send['method'] = '';
            if(strstr($mode, '-'))
            {
                $array  = explode('-', $mode);
                $mode   = $array[0];
                $send['method'] = $array[1];
            }
            $class = 'Appender_' . ucwords($mode);
            $this->_config[$mode] = new $class($send);

            $this->_data[] = $this->_config[$mode]->get();
        }
    }

    /**
     * @desc 输出成html模式
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function html()
    {
        $html = '';
        foreach($this->_data as $k => $v)
        {
            $html .= $v . '<br >';
        }
        return $html;
    }
}