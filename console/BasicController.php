<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/1/22
 * Time: 15:39
 */

class BasicController
{

    protected function globalParam( $request ){
        $_GET = $_POST = $_SERVER = $_COOKIE = [];
        if( isset($request->get) ){
            foreach ( $request->get as $k=>$v){
                $_GET[$k] = $v;
            }
        }

        if( isset($request->post) ){
            foreach ( $request->post as $k=>$v){
                $_POST[$k] = $v;
            }
        }

        if( isset( $request->server) ){
            foreach ( $request->server  as $k=>$v){
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        if( isset( $request->cookie) ){
            foreach ( $request->cookie  as $k=>$v){
                $_COOKIE[$k] = $v;
            }
        }

        if( isset( $request->files) ){
            foreach ( $request->files  as $k=>$v){
                $_FILES[$k] = $v;
            }
        }

    }

    protected function sendSignal($sig)
    {
        if ($pid = $this->getPid()) {
            posix_kill($pid, $sig);
            return true;
        } else {
            $this->stdout("server is not running!" . PHP_EOL);
            return false;
        }
    }

    protected function stdout( $string ){
        return fwrite(\STDOUT, $string);
    }

    public  function getpid(){
        $config = include __DIR__ . '/../config/console.php';
        $pid_file = $config['swoole']['pid_file'];
        if (file_exists($pid_file)) {
            $pid = file_get_contents($pid_file);
            if (posix_getpgid($pid)) {
                return $pid;
            } else {
                unlink($pid_file);
            }
        }
        return false;
    }
}