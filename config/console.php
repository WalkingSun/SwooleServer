<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/1/22
 * Time: 11:10
 */

return [
    'log'  => __DIR__.'/runtime/logs/api.log',
    'swoole'    => [
        'host'  =>  '0.0.0.0',
        'port'  => '9501',
        'mode' => SWOOLE_PROCESS,
        'socketType' => SWOOLE_TCP,
        'document_root' => __DIR__.'/data',
        'log_file'   => __DIR__.'/runtime/logs/swoole.log',
    ],

];