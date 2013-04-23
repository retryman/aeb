<?php
/**
 * @sourcename store_ttable.class.php
 * @desc 数据通用存储类 tt库的table结构操作 该库一般用于大数据量结构化存储、半即时分析操作
 * @author leo(suwi.bin) - bin.yu@condenast.com.cn
 * @date 2012-05-8
 */
class Store_Ttable
{
    /**
     * @desc 数据库连接
     * @var string
     */
    private $_connection;

    /**
     * @desc 数据库配置
     * @var string
     */
    public $_config;

    /**
     * @desc 数据库连接操作（可以进行多机互备操作）
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function _connect()
    {
        if(isset($this->_connection[$this->_config['key']])) return;

        $this->_connection[$this->_config['key']] = new TokyoTyrantTable();

        if(method_exists($this->_connection[$this->_config['key']], 'addsess'))
        {
            $server = "tcp://" . $this->_config['config']['host'] . ":" . $this->_config['config']['port']. "";

            if(isset($this->_config['config']['rhost']) && $this->_config['config']['rhost'])
            {
                $server .= ",tcp://" . $this->_config['config']['rhost'] . ":" . $this->_config['config']['rport']. "";
            }
            
            $key = explode('-', session_id());
            $this->_connection[$this->_config['key']]->addsess($server,$key[0]);
        }
        else
        {
            $this->_connection[$this->_config['key']]->addserver($this->_config['config']['host'], $this->_config['config']['port']);
        }
    }

    /**
     * @desc 获取数据
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function _kvget($data)
    {
        $this->_config = $data;

        $this->_connect();

        $i = 0;

        $query = $limit = $order = array();

        $rdbqc = TokyoTyrant::RDBQC_STROR;//字符串等于

        $data['where'] = isset($data['where']) ? $data['where'] : array();

        $com = array();

        if($data['project'] != 'outer')
        {
            //$com['table'] = $data['db'];
        }


        $data['where'] = $com + $data['where'];

        if(isset($data['where']))
        {
            foreach($data['where'] as $u => $d)
            {
                if(isset($d))
                {
                    if(is_string($d))
                    {
                        $rdbqc = TokyoTyrant::RDBQC_STREQ;//字符串等于
                    }
                    elseif(is_numeric($d))
                    {
                        $rdbqc = TokyoTyrant::RDBQC_NUMEQ;//数等于
                    }
                    if(strstr($u, '^'))
                    {
                        $type = explode('^', $u);
                        if($type[0] == 'limit')
                        {
                            $limit = array($d, $type[1]);
                            continue;
                        }
                        if($type[0] == 'order')
                        {
                            if(isset($data['table']['col'][$type[1]]) && strstr($data['table']['col'][$type[1]], 'int'))
                            {
                                if($d == 'desc')
                                {
                                    $asc = TokyoTyrant::RDBQO_NUMDESC;
                                }
                                else
                                {
                                    $asc = TokyoTyrant::RDBQO_NUMASC;
                                }
                            }
                            else
                            {
                                if($d == 'desc')
                                {
                                    $asc = TokyoTyrant::RDBQO_STRDESC;
                                }
                                else
                                {
                                    $asc = TokyoTyrant::RDBQO_STRASC;
                                }
                            }

                            if(isset($query[($i-1)]))
                            {
                                $query[($i-1)]->setOrder($type[1], $asc);//order
                            }
                            elseif(isset($query[$i]))
                            {
                                $query[$i]->setOrder($type[1], $asc);//order
                            }
                            else
                            {
                                $query[$i] = $this->_connection[$this->_config['key']]->getQuery();
                                $query[$i]->setOrder($type[1], $asc);//order
                            }
                            continue;
                        }
 
                        $d =  $data['store']->parseTime($type[0], $d);
                        //print_r($type[1]);
                        //echo '<br />';
                        switch($type[1])
                        {
                            case 'and':
                                $rdbqc = TokyoTyrant::RDBQC_STRAND;//字符串并且
                                break;
                            case 'or':
                                $rdbqc = TokyoTyrant::RDBQC_STROR;//字符串或者
                                break;
                            case 'start':
                                $rdbqc = TokyoTyrant::RDBQC_STRBW;//字符串开头
                                break;
                            case 'end':
                                $rdbqc = TokyoTyrant::RDBQC_STREW;//字符串结尾
                                break;
                            case 'like':
                                $rdbqc = TokyoTyrant::RDBQC_STRINC;//字符串包含所有的标记
                                break;
                            case 'in':
                                $rdbqc = TokyoTyrant::RDBQC_STROR;//字符串包含所有的标记
                                break;
                            case 'req':
                                $rdbqc = TokyoTyrant::RDBQC_STROREQ;//字符串至少等于一个
                            case 'rx':
                                $rdbqc = TokyoTyrant::RDBQC_STRRX;//字符串正则匹配
                                break;

                            case '>':
                                $rdbqc = TokyoTyrant::RDBQC_NUMGT;//数大于
                                break;
                            case '<':
                                $rdbqc = TokyoTyrant::RDBQC_NUMLT;//数小于
                                break;
                            case '>*':
                                $rdbqc = TokyoTyrant::RDBQC_NUMGE;//数大于等于
                                break;
                            case '>=':
                                $rdbqc = TokyoTyrant::RDBQC_NUMGE;//数大于等于
                                break;
                            case '<*':
                                $rdbqc = TokyoTyrant::RDBQC_NUMLE;//数小于等于
                                break;
                            case '<=':
                                $rdbqc = TokyoTyrant::RDBQC_NUMLE;//数小于等于
                                break;
                        }
                        if(!isset($query[$i])) $query[$i] = $this->_connection[$this->_config['key']]->getQuery();
                        $query[$i]->addCond($type[0], $rdbqc, $d);
                    }
                    else
                    {
                        if(!isset($query[$i]))$query[$i] = $this->_connection[$this->_config['key']]->getQuery();
                        $query[$i]->addCond($u, $rdbqc, $d);
                    }

                    $i++;
                }
            }
        }

        $data['data'] = isset($data['data']) ? $data['data'] : array();

        return array($query, $data['data'], $limit);

    }

    /**
     * @desc 获取数据
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function select($data, $key = false)
    {
        if(isset($data['where']['count']))
        {
            $count = $data['where']['count'];
            unset($data['where']['count']);
        }

        $pageData = array();

        //print_r($data);

        $value = $key != false ? $key : $this->_kvget($data);

        $rdata = array();
        if(!isset($value[0][1]) && isset($value[0][0]))
        {
            if(isset($data['page']) && $data['page'])
            {
                if($value[2])
                {
                    $value[0][0]->setLimit($value[2][0], $value[2][1]);//limit
                }
                $page = $data['page'];
                $page['db'] = $this;
                $page['dbtype'] = 'data';
                $page['dbCount'] = $value[0][0]->count();
                $class = Page::getInstance();
                $pageData = $class->config($page)->get();

                $value[0][0]->setLimit($pageData['data'][1], $pageData['data'][0]);//limit
                if(isset($count) && $count)
                {
                    return $value[0][0]->count();
                }
            }
            else
            {
                if($value[2])
                {
                    $value[0][0]->setLimit($value[2][0], $value[2][1]);//limit
                }
                if(isset($count) && $count)
                {
                    return $value[0][0]->count();
                }
            }

            $rdata = $value[0][0]->search();

            if($key == false)
            {
                $rdata = array_values($rdata);
            }

            if(isset($pageData['page']))
            {
                $return['data'] = $rdata;
                $return['page'] = $pageData['page'];
                $return['total'] = $pageData['total'];
                $return['maxpage'] = $pageData['maxpage'];
            }
            else
            {
                $return = $rdata;
            }

            return $return;
        }
        else
        {
            $query = $this->_connection[$this->_config['key']]->getQuery();
            if(isset($data['page']) && $data['page'])
            {
                if($value[2])
                {
                    $query->setLimit($value[2][0], $value[2][1]);//limit
                }
                $search = $query->metaSearch($value[0], TokyoTyrant::RDBMS_ISECT);
                $num = count($search);
                if(isset($count) && $count)
                {
                    return $num;
                }
                $page = $data['page'];
                $page['db'] = $this;
                $page['dbtype'] = 'data';
                $page['dbCount'] = $num;
                $page['dbData'] = $search;
                $class = Page::getInstance();
                $pageData = $class->config($page)->get();

                $rdata = $pageData;

                //$query->setLimit($pageData['data'][1], $pageData['data'][0]);//limit
            }
            else
            {
                if($value[2])
                {
                    $query->setLimit($value[2][0], $value[2][1]);//limit
                }
                

                $rdata = $query->metaSearch($value[0], TokyoTyrant::RDBMS_ISECT);
                if($key == false)
                {
                    $rdata = array_values($rdata);
                }

                if(isset($count) && $count)
                {
                    return count($rdata);
                }
            }

            return $rdata;
        }

        /*
        $return = array();

        if($key == false)
        {
            if(isset($counts) && $counts)
            {
                $return = count($rdata);
            }
            elseif($rdata)
            {
                foreach($rdata as $k => $v)
                {
                    if(isset($rdata[$k]['table']))
                    {
                        unset($rdata[$k]['table']);
                    }
                    $return[] = $rdata[$k];
                }
            }
        }
        else
        {
            $return = $rdata;
        }
        */
    }

    /**
     * @desc 查询数据
     * @param sql(string) sql语句
     * @author leo(suwi.bin)
     * @date 2012-05-8
     */
    public function selectOne($data)
    {
        $return = $this->select($data);
        return isset($return[0]) ? $return[0] : array();
    }

    /**
     * @desc 插入数据
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function insert($data)
    {
        $this->_config = $data;

        $this->_connect();

        $value = $data['store']->loadClass('value');
        
        if(isset($data['data'][0]))
        {
            $num = 0;
            $all = $this->_connection[$this->_config['key']]->num();
            foreach($data['data'] as $k => $v)
            {
                $num++;
                foreach($data['config']['col'] as $i => $j)
                {
                    if($i == 'id')
                    {
                        $v[$i] = $all+$num;
                    }
                    elseif(!isset($v[$i]) || (isset($v[$i]) && !$v[$i]))
                    {
                        $v[$i] = $value->get($i, $v[$i]);
                    }
                }
                $batch[$k] = $v;

                $return[] = $this->_connection[$this->_config['key']]->put(null, $batch[$k]);
            }
            

            return $return;
        }
        else
        {
            $num = 1;
            $all = $this->_connection[$this->_config['key']]->num();
            foreach($data['config']['col'] as $k => $v)
            {
                if($k == 'id')
                {
                    $data['data'][$k] = $all+$num;
                }
                elseif(!isset($data['data'][$k]) || (isset($data['data'][$k]) && !$data['data'][$k]))
                {
                    $data['data'][$k] = $value->get($k, '');
                }
            }

            $insert = $data['data'];

            return $this->_connection[$this->_config['key']]->put(null, $insert);
        }
    }

    /**
     * @desc 更新数据
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function update($data)
    {
        $this->_config = $data;

        $this->_connect();

        $send = $this->_kvget($data);

        $value = $this->select($data, $send);

        $state = false;
        
        foreach($value as $k => $v)
        {
            foreach($data['where'] as $i => $j)
            {
                //unset($v[$i]);
            }
            foreach($data['data'] as $a => $b)
            {
                $v[$a] = $b;
            }
            $state = $this->_connection[$this->_config['key']]->put($k, $v);
        }

        return $state;
    }

    /**
     * @desc 删除数据
     * @author leo(suwi.bin)
     * @date 2012-06-7
     */
    public function delete($data)
    {
        $this->_config = $data;

        $this->_connect();

        $value = $this->select($data, $this->_kvget($data));

        $state = false;

        foreach($value as $k => $v)
        {
            $state = $this->_connection[$this->_config['key']]->out($k);
        }
        
        return $state;
    }
}