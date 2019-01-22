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
        $log = __DIR__ . '/../runtime/logs/'.$file;

        error_log( var_export($data,1),3,$log );
    }


}