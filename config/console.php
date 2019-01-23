<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2019/1/22
 * Time: 11:10
 */
define( 'RootPath',__DIR__.'/../' );

return [
    'defaultRoute' => 'im/index',
    'log'  => __DIR__.'/../runtime/logs/api.log',
    'swoole'    => [
        'host'  =>  '0.0.0.0',
        'port'  => '91',
        'mode' => SWOOLE_PROCESS,
        'socketType' => SWOOLE_TCP,
        'document_root' => __DIR__.'/../web',
        'log_file'   => __DIR__.'/../runtime/logs/swoole.log',
        'pid_file' => __DIR__.'/../server.pid',
    ],

];