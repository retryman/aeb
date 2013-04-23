<?php
/**
 * @filename upload.class.php
 * @desc 上传类
 * @author leo(suwi.bin) - bin.yu@condenast.com.cn
 * @date 2012-04-18
 */
/**
 * 用法：
 *
        //第一种用法 uploadname为表单的名称，可以自动生成文件名
        $upload = new Upload('uploadname');
        $data = $upload->getData();

        //第二种用法
        $upload = new Upload();
        $config['name'] = 'uploadname';
        $config['filename'] = $_FILES['upload']['name'];//文件名可以为空则自动生成
        $config['filepath'] = '';//filepath如果包含'/'，则会认为是绝对路径，如果不包含/，则是WRITE_ROOT_PATH或者PROJECT_ROOT_PATH的相对路径，可以为空，为空则默认值是upload
        $config['filetype'] = 'all';//文件上传类型，all为所有文件 img 为图片 res 为资源（js/css/img） excel(excel文档)、stream(文件流)
        
        //图片上传之后进行处理
        $config['thumb'] = '600_100,100_200';//缩略图，这里生成两个图，生成之后的名称为文件名+600_100_thumb.jpg
        $config['crop'] = '380_227';//从左上角开始截图，生成之后的名称为文件名+600_100_crop.jpg
        $config['mark'] = array('water' => 'water.jpg', 'position' => 1)//添加水印图片

        $data = $upload->save($config);
 *
 */

class Upload
{
    /**
     * @desc 保存配置数据
     * @var array
     */
    private $_config = array();

    /**
     * @desc 处理之后的数据
     * @var array
     */
    private $_data = array();

    /**
     * @desc 上传
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function __construct($name = false)
    {
        if($name) $this->save(array('name' => $name));
    }

    /**
     * @desc 设置配置
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function save($config)
    {
        $this->_config  = $config;
        $this->_file();
        return $this->_save();
    }

    /**
     * @desc 获取处理后的数据
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @desc 创建随机数
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _make()
    {
        return md5(microtime()+rand()*100);
    }

    /**
     * @desc 创建文件名和路径
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _file()
    {
        $this->_checkConfig();

        $this->_data['tmp']     = $this->_post($this->_config['name']);

        $file = (isset($this->_config['filename']) && $this->_config['filename']) ? $this->_config['filename'] : $this->_make() . '.jpg';

        if(strstr($this->_config['filepath'], '/'))
        {
            $path = $this->_config['filepath'];
        }
        else
        {
            $root = defined('WRITE_ROOT_PATH') ? WRITE_ROOT_PATH : PROJECT_ROOT_PATH . '/';
            $path = $this->_path($this->_path($this->_path($this->_path($root . $this->_config['filepath'] . '/') . date("Y") . '/') . date("Ym") . '/') . date("Ymd") . '/');
        }

        $this->_data['file']    = $path . $file;
    }

    /**
     * @desc 创建路径
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _path($path)
    {
        if(!is_dir($path))
        {
            mkdir($path,0777);
            exec("chmod 777 ".$path);
        }
        return $path;
    }

    /**
     * @desc 开始上传
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function _save()
    {
        if(isset($this->_config['filesize']) && $this->_config['filesize'] > 0 && $this->_data['tmp']['size'] > $this->_config['filesize'])
        {
            $this->_error('file size error -1');
            return -1;
        }
        if(isset($this->_config['filelimit']) && strstr($this->_config['filelimit'], '*'))
        {
            $imgstream = file_get_contents($this->_data['tmp']['tmp_name']);
            $im = imagecreatefromstring($imgstream);

            $width = imagesx($im);
            $height = imagesy($im);

            @imagedestroy($im);
            $attribute = explode(',', $this->_config['filelimit']);
            $array = explode('*', $attribute[0]);

            if($width > $array[0])
            {
                $this->_error('file max width error -2');
                return -2;
            }
            if($height > $array[1])
            {
                $this->_error('file max height error -3');
                return -3;
            }

            if(isset($attribute[1]))
            {
                $array = explode('*', $attribute[1]);
                if($width < $array[0])
                {
                    $this->_error('file min width error -4');
                    return -4;
                }
                if($height < $array[1])
                {
                    $this->_error('file min height error -5');
                    return -5;
                }
            }
            
        }
        
        if($this->_data['type'] && !strstr($this->_data['type'], $this->_data['tmp']['type']))
        {
            $this->_error('upload type error -6');
            return -6;
        }
        if(!copy($this->_data['tmp']['tmp_name'], $this->_data['file']))
        {
            $this->_error('upload error -7');
            return -7;
        }
        else
        {
            $this->_data['name'] = $this->_data['tmp']['name'];
            $this->_data['type'] = $this->_data['tmp']['type'];

            if(isset($this->_config['width']))
            {
                $imgstream = file_get_contents($this->_data['file']);
                $im = imagecreatefromstring($imgstream);

                $this->_data['width'] = imagesx($im);
                $this->_data['height'] = imagesy($im);

                @imagedestroy($im);
            }
            $img = false;
            //添加水印
            if(isset($this->_config['mark']))
            {
                $img = new Img();
                $img->mark($this->_data['file'], $this->_config['mark']);
            }

            //建立小图
            if(isset($this->_config['thumb']))
            {
                if(!$img)
                {
                    $img = new Img();
                }
                $img->thumb($this->_data['file'], $this->_config['thumb']);
            }
            //建立小图
            if(isset($this->_config['crop']))
            {
                if(!$img)
                {
                    $img = new Img();
                }
                $img->crop($this->_data['file'], $this->_config['crop']);
            }

            return $this->_data;
        }
    }

    /**
     * @desc 检测是否设置了配置
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _checkConfig()
    {
        if(!$this->_config)
        {
            $this->_error('config error');
        }
        if(!isset($this->_config['name']))
        {
            $this->_error('name error');
        }
        if(!isset($this->_config['filetype']))
        {
            $this->_config['filetype'] = 'file';
        }
        if(!isset($this->_config['filepath']))
        {
            $this->_config['filepath'] = 'upload';
        }

        $this->_data['type'] = false;
        switch($this->_config['filetype'])
        {
            case 'file':
                $this->_data['type'] = 'image/png,image/x-png,image/jpeg,image/pjpeg,image/gif,image/bmp,application/javascript,text/css,application/octet-stream';
                break;
            case 'img':
                $this->_data['type'] = 'image/png,image/x-png,image/jpeg,image/pjpeg,image/gif,image/bmp,application/octet-stream';
                break;
            case 'excel':
                $this->_data['type'] = 'application/vnd.ms-excel';
                break;
            case 'stream':
                $this->_data['type'] = 'application/octet-stream';
                break;
        }
    }

    /**
     * @desc 获取post数据
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _post($name)
    {
        if(isset($_POST[$name]) && $_POST[$name])
        {
            return $this->_data['post'][$name] = $_POST[$name];
        }

        if(isset($_GET[$name]) && $_GET[$name])
        {
            return $this->_data['post'][$name] = $_GET[$name];
        }

        if(isset($_FILES[$name]) && $_FILES[$name])
        {
            return $this->_data['post'][$name] = $_FILES[$name];
        }

        return false;
    }

    /**
     * @desc 匹配错误
     * @param *
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _error($string, $type = 1)
    {
        $errstr = '' ;
        $errstr .= "Upload Error:" . $string . "\n";
        Debug::log("uploaderror", $errstr, "UPLOAD");
        ErrorLog::addLog($errstr);
    }
}
?>
