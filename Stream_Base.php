<?php
abstract class Stream_Base
{
    
    protected 
        $positon,
        $data,
        $key;

    public function  __construct()
    {

    }

    public static function register()
    {
    }

    

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $this->position = 0;
        return true;
    }
 
    function stream_read($count)
    {
        $ret = substr($this->data, $this->position, $count);
        $this->position += strlen($ret);
        return $ret;
    }

    function stream_write($data)
    {
        $left = substr($this->data, 0, $this->position);
        $right = substr($this->data, $this->position + strlen($data));
        $this->data = $left . $data . $right;
        $this->position += strlen($data);
        $this->tt->put($this->key, $this->data);
        return strlen($data);
    }

    function stream_tell()
    {
        return $this->position;
    }

    function stream_eof()
    {
        return $this->position >= strlen($this->data);
    }

    function stream_seek($offset, $whence)
    {
        switch ($whence) {
            case SEEK_SET:
                if ($offset < strlen($this->data) && $offset >= 0) {
                     $this->position = $offset;
                     return true;
                } else {
                     return false;
                }
                break;

            case SEEK_CUR:
                if ($offset >= 0) {
                     $this->position += $offset;
                     return true;
                } else {
                     return false;
                }
                break;

            case SEEK_END:
                if (strlen($this->data) + $offset >= 0) {
                     $this->position = strlen($this->data) + $offset;
                     return true;
                } else {
                     return false;
                }
                break;

            default:
                return false;
        }
    }
    public function stream_stat()
    {
        //
        return array();
    }
 }
