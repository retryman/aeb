<?php
/**
 * @filename oauth.class.php
 * @desc 统一的oauth协议类，可以说支持所有网站的oauth通信 需要客户端（前端页面）支持 客户端建立方法可以参考feature的oauth
 * @author leo(suwi.bin) - bin.yu@condenast.com.cn
 * @date 2012-06-27
 */

class Oauth
{
    /**
     * @desc 配置数据
     * @var string
     */
    private $_config = array();

    /**
     * @desc 设置配置
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function setConfig($config)
    {
        $this->_config = $config;
        return $this;
    }

    /**
     * @desc 获取返回值
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function getReturn()
    {
        return $this->_config['return'];
    }

    /**
     * @desc 检测配置的数据
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function check($type = 'oauth')
    {
        return $this->_valid($type);
    }

    /**
     * @desc 执行
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    public function setup()
    {
        if(isset($this->_config['return'])) unset($this->_config['return']);
        if($this->_config['method'] == 'access_token')
        {
            $this->_nonce();
        }
        if(empty($this->_config[$this->_config['method']]))
        {
            //$this->_error(-203, '无法请求数据，你的传值有误:' . $this->_config['method']);
            $this->_config[$this->_config['method']] = $this->_config['method'];
        }
        $url = $this->_config['url'] . $this->_config[$this->_config['method']];
        $str = $this->_config['request_method'] . "&" . rawurlencode($url) . "&";

        $send['oauth_consumer_key']      = $this->_config['id'];
        $send['oauth_version']           = '1.0';
        $send['oauth_signature_method']  = 'HMAC-SHA1';
        $send['oauth_timestamp']         = time();
        $send['oauth_nonce']             = mt_rand();

        isset($this->_config['token'])      && $send['oauth_token']                 = $this->_config['token'];
        isset($this->_config['openid'])     && $send['openid']                      = $this->_config['openid'];
        if(isset($this->_config['vericode']))
        {
            $send['oauth_verifier']              = $this->_config['vericode'];
            $send['oauth_vericode']              = $this->_config['vericode'];
        }
        else
        {
            if($this->_config['method'] == 'request_token' || $this->_config['method'] == 'authorize')
            {
                $send['oauth_callback']          = $this->_config['callback'];
            }
        }

        if(isset($this->_config['send']) && is_array($this->_config['send']))
        {
            $send += $this->_config['send'];
        }

        $send = $this->_compatible($send);


        uksort($send, 'strcmp');

        //ksort($send);

        $normal  = http_build_query($send);

        $str .= rawurlencode($normal);

        $this->_config['secret'] = isset($this->_config['secret']) ? $this->_config['secret'] : '';

        $key = $this->_config['key'] . '&' . $this->_config['secret'];

        $signature = $this->_signature($str, $key);

        if($this->_config['request_method'] == 'POST')
        {
            $this->_config['send'] = $normal . '&oauth_signature=' . rawurlencode($signature);
        }
        else
        {
            $url .= '?' . $normal . '&oauth_signature=' . rawurlencode($signature);
        }
        if(isset($this->_config['gone']) && $this->_config['gone'] == true)
        {
            $this->_config['return']['url'] = $url;
            $this->_config['return']['send'] = $this->_config['send'];
            return $this->_config['return'];
        }

        $return = $this->_curl($url);

        if(is_bool($return) && $return === true)
        {
            return $this->_config['return'] = $return;
        }

        if(!strstr($this->_config['method'], '_token'))
        {
            return $this->_config['return'] = json_decode($return, true);
        }

        $token = array();
        
        parse_str($return, $token);

        if(isset($token['error_code']))
        {
            $this->_error(-200, $token['error_code']);
        }

        if(empty($token['oauth_token'])) $this->_error(-202, '第三方网站返回有错误');
        if(isset($send['oauth_token']))
        {
            $name = 'openid';
            if(isset($this->_config['com']['openid']))
            {
                $name = $this->_config['com']['openid'];
            }
            $token['openid']            = isset($token[$name]) ? $token[$name] : $token['oauth_token'];
            $token['timestamp']         = isset($token['timestamp']) ? $token['timestamp'] : $send['oauth_timestamp'];
            $token['oauth_signature']   = isset($token['oauth_signature']) ? $token['oauth_signature'] : $this->_signature($token['openid'] . $token['timestamp'], $this->_config['key']);

            $this->_config['openid']    = $token['openid'];
            $this->_config['timestamp'] = $token['timestamp'];
            $type = 'oauth';
            $token['oauth_signature']   = md5($token['oauth_signature'] . '_' . $this->_config[$type . 'key']);
            $this->_config['sig']       = $token['oauth_signature'];
            if($this->_valid($type) == false)
            {
                $this->_error(-203, '第三方网站返回有错误');
            }

            $this->_config['return']        = $token;
        }
        else
        {
            $this->_config['token']         = $token['oauth_token'];
            $this->_config['secret']        = $token['oauth_token_secret'];
            isset($send['oauth_callback']) && $this->_config['callback'] = $send['oauth_callback'];

            $this->_callback();
        }
    }

    /**
     * @desc 得到callback的地址
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _callback()
    {
        $url = $this->_config['url'] . $this->_config['authorize'] . '?oauth_consumer_key=' . $this->_config['id'] . '&oauth_token=' . $this->_config['token'] . '&oauth_callback=' . rawurlencode($this->_config['callback']);

        $this->_config['return'] = array($url, $this->_config['secret']);
    }

    /**
     * @desc 进行签名
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _signature($str, $key)
    {
        $signature = "";
        if (function_exists('hash_hmac'))
        {
            $signature = base64_encode(hash_hmac("sha1", $str, $key, true));
        }
        else
        {
            $blocksize	= 64;
            $hashfunc	= 'sha1';
            if (strlen($key) > $blocksize)
            {
                $key = pack('H*', $hashfunc($key));
            }
            $key	= str_pad($key,$blocksize,chr(0x00));
            $ipad	= str_repeat(chr(0x36),$blocksize);
            $opad	= str_repeat(chr(0x5c),$blocksize);
            $hmac 	= pack(
                'H*',$hashfunc(
                    ($key^$opad).pack(
                        'H*',$hashfunc(
                            ($key^$ipad).$str
                        )
                    )
                )
            );
            $signature = base64_encode($hmac);
        }

        return $signature;
    }

    /**
     * @desc 检测合法性
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _valid($type = 'oauth')
    {
        $key = $this->_config['key'];

        /*
        if($this->_config['tpid'] == 100)
        {
            $key = $this->_config['key'];
        }
        else
        {
            $key = $this->_config['key'] . '&' . $this->_config['secret'];
        }
        */
        $str = $this->_config['openid'] . $this->_config['timestamp'];

        $sig = $this->_config['sig'];

        $this->_config['return'] = $this->_signature($str, $key);

        return md5($this->_config['return'] . '_' . $this->_config[$type . 'key']) == $sig;
    }

    /**
     * @desc 数据兼容（对各个站进行兼容）
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _compatible($send)
    {
        if(isset($this->_config['com'][$this->_config['method']]))
        {
            foreach($this->_config['com'][$this->_config['method']] as $k => $v)
            {
                if(isset($send[$k]))
                {
                    if($v != false) $send[$v] = $send[$k];
                    unset($send[$k]);
                }
            }
        }

        return $send;
    }

    /**
     * @desc curl
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _curl($url)
    {
        $state = false;
        if(isset($this->_config['queue']) && in_array($this->_config['method'], $this->_config['queue']))
        {
            $state = $this->_record($url);
        }
        
        if($state == false)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if(isset($this->_config['send']) && is_string($this->_config['send']) && strstr($this->_config['send'], 'oauth_signature'))
            {
                curl_setopt($ch, CURLOPT_POST, TRUE); 
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_config['send']); 
            }
            if(strstr($url, 'https'))
            {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            }

            curl_setopt($ch, CURLOPT_URL, $url);
            $return = curl_exec($ch);
            curl_close($ch);

            if(!$return)
            {
                $this->_error(-201, '第三方网站返回有错误');
            }
        }
        else
        {
            $return = true;
        }
        return $return;
    }

    /**
     * @desc 防重放（暂未开通）
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _nonce()
    {
        return;
    }

    /**
     * @desc 数据记录（暂未开通）
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _record()
    {
        return;
    }

    /**
     * @desc 错误记录
     * @author leo(suwi.bin)
     * @date 2012-03-23
     */
    private function _error($number, $msg)
    {
        error($msg, $number);
    }
}