<?php
/**
 * @sourcename store.class.php
 * @desc 数据统计类
 * @author leo(suwi.bin) - bin.yu@condenast.com.cn
 * @date 2012-05-8
 */

class Store_Stat
{
    /**
     * @desc 数据
     * @var object
     */
    private $_data;

    /**
     * @desc 时间
     * @var int
     */
    private $_time;

    /**
     * @desc ip类
     * @var object
     */
    private $_ip;

    /**
     * stat::__construct()
     *
     * @access public
     * @param array $data
     */
    public function __construct($data)
    {
        if(!$data[1])
        {
            echo '暂无数据，无法统计';die;
        }
        $this->_data['source'] = $data[1];

        $this->_data['value'] = $data[2] ? $data[2] : array();

        $this->_setup();
    }

    /**
     * stat::data()
     *
     * @access public
     * @param $
     */
    public function data()
    {
        //print_r($this->_data);die;
        if(isset($this->_data['ip']))
        {
            arsort($this->_data['ip']);
        }
        return $this->_data;
    }

    /**
     * stat::_setup()
     *
     * @access private
     * @param $
     */
    private function _setup()
    {
        $method = array_unique(array_merge(array('Y', 'Y-m','Y-m-d','Y-m-d H'), $this->_data['value']));

        foreach($this->_data['source'] as $k => $v)
        {
            foreach($method as $i => $j)
            {
                $this->_total($j, $v);
            }
        }
    }

    /**
     * stat::_total()
     *
     * @access private
     * @param string $name
     */
    private function _total($name, $data, $method = false, $key = false)
    {
        if($method == false)
        {
            if(strstr($name, 'Y') && isset($data['cdate']))
            {
                $cdate = date($name, $data['cdate']);
                if(!isset($this->_data[$name][$cdate]['volume']))
                {
                    $this->_data[$name][$cdate]['volume'] = 0;
                }
                $this->_data[$name][$cdate]['volume']++;
                foreach($this->_data['value'] as $k => $v)
                {
                    if(!isset($data[$v])) $data[$v] = '';
                    $this->_total($v, $data[$v], $name, $cdate);
                }
            }
            else
            {   if($name == 'cdate')
                {
                    $data[$name] = date('Y-m-d H:i:s', $data[$name]);
                }
                if($name == 'ip')
                {
                    $this->_ip();
                    $ipdata = $this->_ip->getaddress($data[$name]);
                    $data[$name] = $ipdata['area1'];
                    if($data[$name] == '0')
                    {
                        $data[$name] = '未知';
                    }

                    $data[$name] = $this->_local($data[$name]);
                }
                if(!isset($this->_data[$name][$data[$name]]['volume'])) $this->_data[$name][$data[$name]]['volume'] = 0;
                $this->_data[$name][$data[$name]]['volume']++;
                if(isset($data['cdate']) && $data['cdate'])
                {
                    if(!isset($this->_data[$name][$data[$name]]['vtime'])) $this->_data[$name][$data[$name]]['vtime'] = array();
                    @array_push($this->_data[$name][$data[$name]]['vtime'], date('Y-m-d H:i:s', $data['cdate']));
                }
                if(isset($data['totals']))
                {
                    $this->_data[$name][$data[$name]]['totals'] += $data['totals'];
                }
            }
        }
        else
        {
            if(!isset($this->_data[$method][$key][$name][$data]))
            {
                if($name == 'totals')
                {
                    $this->_data[$method][$key][$name]['volume'] += $data;
                }
                else
                {
                    if(!isset($this->_data[$method][$key][$name]['volume'])) $this->_data[$method][$key][$name]['volume'] = 0;
                    $this->_data[$method][$key][$name]['volume']++;
                }
            }
            $this->_data[$method][$key][$name][$data] = $data;
        }
    }

    private function _ip()
    {
        if(!$this->_ip)
        {
            $this->_ip = new Qips();
        }
    }

    private function _local($name)
    {
        $array = array('省', '北京', '上海', '西藏', '天津', '重庆', '宁夏', '新疆', '内蒙古', '广西', '市');

        foreach($array as $k => $v)
        {
            if(strstr($name, $v))
            {
                $a = explode($v, $name);
                $name = $a[0] . $v;
                break;
            }
        }
        return $name;
    }
}