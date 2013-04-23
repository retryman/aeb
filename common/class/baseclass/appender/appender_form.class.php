<?php
/**
 * @sourcename appender_form.class.php
 * @desc 数据统计类 表格格式
 * @author leo(suwi.bin) - bin.yu@condenast.com.cn
 * @date 2012-05-8
 */

class Appender_Form
{
    /**
     * @desc 统计的数据
     * @var string
     */
    private $_data;

    /**
     * @desc 统计的key
     * @var string
     */
    private $_key;

    /**
     * @desc 生成的字符串
     * @var string
     */
    private $_string;

    /**
     * @desc 构造函数
     * @param config(array) 传过来的数据
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function __construct($data)
    {
        $this->_data = $data['data'];

        $this->_key = $data['key'];

        //$this->_source();

        $this->_stat();
    }

    /**
     * @desc 拼接表格
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    private function _source()
    {
        $this->_string = '<div class="appender_div"><table class="appender_form">';

        $key = $this->_key($this->_data['source'][0]);

        $this->_string .= $key[1];
        foreach($this->_data['source'] as $k => $v)
        {
            $this->_string .= '<tr class="appender_form_tr">';
            
            foreach($key[0] as $i => $j)
            {
                $this->_string .= '<td  class="appender_form_td appender_' . $j . '"> ' . $v[$j] . ' </td>';
            }

            $this->_string .= '</tr>';
        }
        $this->_string .= '</table></div>';
    }

    /**
     * @desc 统计数据
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    private function _stat()
    {
        $data = $this->_data;
        unset($data['source']);
        unset($data['value']);

        $value = array_flip(array_merge(array('date','volume'), $this->_data['value']));
        $key = $this->_key($value);
        foreach($data as $k => $v)
        {
            if($this->_key != false && !in_array($k, $this->_key))
            {
                continue;
            }
            $this->_string .= '<div class="appender_div"><table class="appender_form">';

            if(!in_array($k, $this->_data['value']))
            {
                $this->_string .= $key[1];

                foreach($v as $i => $j)
                {
                    $this->_string .= '<tr class="appender_form_tr">';
                    
                    $this->_string .= '<td  class="appender_form_td appender_' . $i . '"> ' . $i . ' </td>';

                    $this->_string .= '<td  class="appender_form_td appender_' . $i . '"> ' . $j['volume'] . ' </td>';

                    foreach($j as $a => $b)
                    {
                        if($a != 'volume')
                        {
                            $this->_string .= '<td  class="appender_form_td appender_' . $a . '"> ' . $b['volume'] . ' </td>';
                        }
                    }

                    $this->_string .= '</tr>';
                }
            }
            else
            {
                $n[$k] = array($k, 'volume');
                if(isset($this->_data['source'][0]['totals'])) $n[$k] = array_merge($n[$k], array('totals'));
                $m[$k] = $this->_key(array_flip($n[$k]));
                
                $this->_string .= $m[$k][1];

                foreach($v as $i => $j)
                {
                    $this->_string .= '<tr class="appender_form_tr">';
                    
                    $this->_string .= '<td  class="appender_form_td appender_' . $i . '"><a href="javascript:;" onclick="alert($(this).children(\'.show\').html());" style="cursor:pointer;text-decoration:none;"><span class="show" style="display:none;">'.$i.'</span> ' . $i . ' </a></td>';

                    $this->_string .= '<td  class="appender_form_td appender_' . $i . '"> ' . $j['volume'] . ' </td>';

                    if(count($m[$k][0]) > 2 && isset($j['totals'])) $this->_string .= '<td  class="appender_form_td appender_' . $i . '"> ' . $j['totals'] . ' </td>';

                    $this->_string .= '</tr>';
                }
            }

            $this->_string .= '</table></div>';
        }
    }

    /**
     * @desc 表格的key
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    private function _key($array)
    {
        $string = '<tr class="appender_form_tr">';
        foreach($array as $k => $v)
        {
            $key[] = $k;
            $string .= '<td class="appender_form_td appender_' . $k . '">' . lang($k, 'table') . '</td>';
        }
        $string .= '</tr>';
        return array($key, $string);
    }

    /**
     * @desc 获取数据
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function get()
    {
        return '<style>
                .appender_div
                {
                    margin:10px;
                }

                .appender_form
                {
                    border:1px solid #bababa;
                }

                .appender_form tr
                {
                    border:1px solid #bababa;
                }

                .appender_form td
                {
                    width:600px;
                    border:1px solid #bababa;
                }</style>' . $this->_string;

        return $this->_string;
    }
}