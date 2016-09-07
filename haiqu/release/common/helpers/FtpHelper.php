<?php

namespace common\helpers;

/**
 * FTP 类
 * @author wxn
 *
 */
class FtpHelper
{
	private static $return_status;
	private static $connector;
	private static $ftp_host;
	private static $ftp_port;
	/**
	 * 初始化
	 * @param unknown $ftp_host
	 * @param number $ftp_port
	 */
    public static function init($ftp_host, $ftp_port = 21)
    {
    	if (!extension_loaded('ftp')) {
    		die("FTP extension does not exist! \n");
    	} else if (empty($ftp_host)) {
    		die("FTP server not empty! \n");
    	}
       self::$connector = null;
       self::$return_status = true;
       self::$ftp_host = $ftp_host;
       self::$ftp_port = $ftp_port;
    }
    /**
     * FTP Connect
     * @param unknown $uname
     * @param unknown $passwd
     */
	public static function connect($uname, $passwd)
	{
		if (extension_loaded('openssl')) {
			//在Windows集成环境有问题，需要重新编译php，暂时注释掉
			//self::$connector = @ftp_ssl_connect(self::$ftp_host, self::$ftp_port) or die("FTP connection has failed! \n");
			self::$connector = @ftp_connect(self::$ftp_host, self::$ftp_port) or die("FTP connection has failed! \n");
		} else {
			self::$connector = @ftp_connect(self::$ftp_host, self::$ftp_port) or die("FTP connection has failed! \n");
		}
		$login_result = @ftp_login(self::$connector, $uname, $passwd) or die("Attempted to connect to ".self::$ftp_host." for user $uname \n");
    }
    /**
     * 返回指定文件的最后修改时间
     * @param String $file
     * @return number
     */
	public static function lastModtime($file)
	{
		$time_stamp = ftp_mdtm(self::$connector,$file);
		return $time_stamp;
	}
	/**
	 * 更改当前目录
	 * @param unknown $targetdir
	 * @return boolean
	 */
	public static function changeDir($targetdir)
	{
		self::$return_status = ftp_chdir(self::$connector, $targetdir);
		return self::$return_status;
	}
	/**
	 * 获取当前目录
	 * @return string
	 */
	public static function getDir()
	{
		$current_dir = ftp_pwd(self::$connector);
		return $current_dir;
	}
	/**
     * 获取文件列表
     * @param unknown $directory
     * @return multitype:
     */
	public static function getFileList($directory)
	{
        $file_list = ftp_nlist(self::$connector, $directory);
		return $file_list;
	}
	/**
	 * 获取文件
	 * @param unknown $file_to_get
	 * @param unknown $mode
	 * @param unknown $mode2
	 * @return boolean
	 */
	public static function getFile($remote_file, $local_file, $mode = FTP_ASCII)
	{
		self::$return_status = @ftp_get(self::$connector, $local_file, $remote_file, $mode);
		return self::$return_status;
	}
	/**
	 * 被动模式设置为打开或关闭
	 * @param unknown $pasvmode
	 */
	public static function mode($pasvmode)
	{
		self::$return_status = ftp_pasv(self::$connector, $pasvmode);
		return self::$return_status;
	}
	/**
	 * 关闭连接
	 * @return unknown
	 */
	public static function ftpClose()
	{
		ftp_close(self::$connector);
	}
	/**
     * [getFileListAll]
     * 获取文件列表
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public static function getFileListAll($url)
    {
      	$dir = @opendir($url);
      	if(!$dir){
           return false;
      	}
      	$file_list = '';
      	while (($file = readdir($dir)) !== false)
      	{
           $file_list .= $file.",";
           // echo "filename: " . $file . "<br />";
      	}
      	closedir($dir);
      	return $file_list;
    }


	/**
	 * fopen函数实现下载文件
	 * @param unknown $url
	 * @param string $folder
	 * @return boolean
	 */
	public static function fopenDownloadFile($url, $local_path, $path = "./")
	{
		$path = $local_path.$path.'/';
		// 判断目录是否存在
		if (!is_dir($path)) {
			// 如果没有就建立目录
			self::_createDir($path);
		}
		// 取得文件的名称
		$new_fname = $path . basename($url);
		// 打开远程文件，二进制模式
		$file = @fopen($url, "rb");
		if (!$file) {
			return true;
		}
		//文件大小
		$file_size = @filesize($url);
		$file_size = $file_size ? $file_size : 1024*1024;
		// 本地文件
		$newf = @fopen($new_fname, "wb");
		chmod($new_fname, 0777);//更改文件权限
		if (!$newf) {
			// 关闭远程文件
			fclose($file);
			return false;
		}
		$start_time = time();
        $max_time = 30; //time in seconds
        // 没有写完就继续 十秒强制跳出循环
        while (!feof($file)) {
            fwrite($newf, fread($file, $file_size), $file_size);
            if((time()-$start_time) > $max_time) break;
        }
		// 关闭本地文件
		fclose($newf);
		// 关闭远程文件
		fclose($file);
		return true;
	}
	/**
	 * 创建目录
	 * @param unknown $path
	 */  
	private static function _createDir($path) 
	{
        if (!file_exists($path)) {
            self::_createDir(dirname($path));
            mkdir($path, 0777);
            chmod($path, 0777);
        }
    }
}
