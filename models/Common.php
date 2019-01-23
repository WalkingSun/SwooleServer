<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/1/22
 * Time: 15:26
 */

class Common
{

    public static function addLog( $file, $data ){

        error_log( print_r($data,1),3,$file );
    }


}