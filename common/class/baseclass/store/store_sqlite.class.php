<?php
/**
 * @sourcename sqlite.class.php
 * @desc 数据通用存储类 Sqlite库操作 该库一般用于持久化、日志存储操作（按照日期生成数据库文件）
 * @author leo(suwi.bin) - bin.yu@condenast.com.cn
 * @date 2012-05-8
 */

class Store_Sqlite
{
    /**
     * @desc 数据库连接
     * @var object
     */
    private $_connection;

    /**
     * @desc 配置
     * @var array
     */
    private $_config;

    /**
     * @desc 数据库连接
     * @author leo(suwi.bin)
     * @date 2012-05-8
     */
    private function _connect()
    {
        if(isset($this->_connection[$this->_config['key']])) return;
        
        $path = defined('WRITE_ROOT_PATH') ? WRITE_ROOT_PATH : PROJECT_ROOT_PATH;

        $path = $this->_config['store']->createPath($this->_config['store']->createPath($path . 'store_sqlite' . DIRECTORY_SEPARATOR) . $this->_config['table'] . DIRECTORY_SEPARATOR);

        $time = '';

        if($this->_config['config']['path'] == 'memory')
        {
            //sqlite的内存库只能用于单机系统。。。所以就不要用了。
            $file = ':memory:';

            $memory = $path . $this->_config['table'] . '-memory' . '.db';

            $state  = is_file($memory);

            if($state == false)
            {
                //file_put_contents($memory, 'cteate by record');
            }
        }
        else
        {
            if($this->_config['config']['path'])
            {
                $date = time();
                if(isset($this->_config['where']['sqlitepath']))
                {
                    $date = $this->_config['where']['sqlitepath'];
                }
                elseif(isset($this->_config['where']['vdate']))
                {
                    $date = $this->_config['where']['vdate'];
                }
                elseif(isset($this->_config['where']['vdate^>']))
                {
                    $date = $this->_config['where']['vdate^>'];
                }
                elseif(isset($this->_config['where']['vdate^>*']))
                {
                    $date = $this->_config['where']['vdate^>*'];
                }
                elseif(isset($this->_config['where']['vdate^<']))
                {
                    $date = $this->_config['where']['vdate^<'];
                }
                elseif(isset($this->_config['where']['vdate^<*']))
                {
                    $date = $this->_config['where']['vdate^<*'];
                }
                
                if(strstr($date, '-'))
                {
                    $date = $this->_config['score']->parseTime('vdate', $date);
                }

                $date = date($this->_config['config']['path'], $date);

                $time = explode('-', $date);
                foreach($time as $k => $v)
                {
                    $path = $this->_config['store']->createPath($path . $v . DIRECTORY_SEPARATOR);
                }
            }

            $file   =  $path . $this->_config['table'] . '-' . $date . '.db';

            $state  = file_exists($file);

            if(isset($this->_config['where']) && $state != false)
            {
                $this->_error('sqlite_exists:' . $file);
            }
        }

        $this->_connection[$this->_config['key']] = new PDO('sqlite:' . $file);

        $this->_connection[$this->_config['key']]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //$this->_connection[$this->_config['key']]->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        $this->_connection[$this->_config['key']]->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);

        $this->_connection[$this->_config['key']]->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        if($state == false) $this->_create($file);
    }


    /**
     * @desc 插入数据
     * @param data(array) 传输的数据
     * @author leo(suwi.bin)
     * @date 2012-05-8
     */
    public function insert($data)
    {
        $this->_config = $data;

        $value = $data['store']->loadClass('value');

        $this->_connect();

        if(isset($data['data'][0]))
        {
            $this->_connection[$this->_config['key']]->beginTransaction();

            $insert['db'] = $data['db'];

            foreach($data['data'] as $k => $v)
            {
                foreach($data['table']['col'] as $i => $j)
                {
                    if(!$v[$i])
                    {
                        $v[$i] = $value->get($i, $v[$i]);
                    }
                }

                $insert['data'] = $v;
                $this->_connection[$this->_config['key']]->exec($data['store']->loadClass('sql')->config('insert', $insert)->get());
            }

            return $this->_connection[$this->_config['key']]->commit();
        }
        else
        {
            foreach($data['table']['col'] as $k => $v)
            {
                if(!$data['data'][$k])
                {
                    $data['data'][$k] = $value->get($k, $data['data'][$k]);
                }
            }

            $this->_connection[$this->_config['key']]->exec($data['store']->loadClass('sql')->config('insert', $data)->get());

            return $this->_connection[$this->_config['key']]->lastInsertId();
        }
    }

    /**
     * function select
     */
    public function select($data)
    {
        if(isset($data['where']['count']))
        {
            $count = $data['where']['count'];

            unset($data['where']['count']);
        }

        $this->_config = $data;

        unset($data['where']['sqlitepath']);
        
        $sql = $data['store']->loadClass('sql')->config('select', $data)->get();

        $data = $this->_prepare($sql)->fetchAll();

        return (isset($count) && $count) ? count($data) : $data;
    }

    
    /**
     * function update
     */
    public function update($data)
    {
        $sql = $data['store']->loadClass('sql')->config('update', $data)->get();

        $this->_config = $data;

        $this->_connect();

        $this->_connection[$this->_config['key']]->exec($sql);

        return $this->_connection[$this->_config['key']]->lastInsertId();
    }

    /**
     * function delete
     */
    public function delete($data)
    {
        $sql = $data['store']->loadClass('sql')->config('delete', $data)->get();

        $this->_config = $data;

        return $this->_prepare($sql);
    }

    /**
     * function _delete
     */
    public function query($sql, $method = 'fetchAll')
    {
        $this->_config = $data;

        return $this->_prepare($sql)->$method();
    }

    public function row()
    {
        return $this->query('SELECT found_rows()',  'fetchColumn');
    }

    /**
     * function _create
     */
    private function _create($file)
    {
        system("chmod 777 ". $file);

        $data['table'] = $this->_config['table'];

        $data['data'] = $this->_config['config']['col'];

        $sql = $this->_config['store']->loadClass('sql')->config('create', $data)->get();

        return $this->_connection[$this->_config['key']]->exec($sql);
    }

    /**
     * function _prepare
     */
    private function _prepare($sql)
    {
        $this->_connect();

        $stmt = $this->_connection[$this->_config['key']]->prepare($sql);

        $stmt->execute();

        return $stmt;
    }

    /**
     * @desc 错误记录
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _error($error)
    {
        Debug::log("store_sqlite error", $error, "store_sqlite");
    }

    /**
     * @desc 日志记录
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _log($msg)
    {
        Debug::log("store_sqlite log", $msg, "store_sqlite");
    }
}
