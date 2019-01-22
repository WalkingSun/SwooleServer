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
        } else {
            $this->stdout("server is not running!" . PHP_EOL);
            return;
        }
    }

    protected function stdout( $string ){
        return fwrite(\STDOUT, $string);
    }

}