<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/10/24
 * Time: 10:29
 */

$serv = new Swoole_server('0.0.0.0',9501,SWOOLE_PROCESS,SWOOLE_SOCK_UDP);

//$serv->set([
//    'worker_num'   =>  4,
//    'max_request'  => 1000,
//]);

//监听数据发送事件
$serv->on('Packet', function ($serv, $data, $clientInfo) {
    //发送给客户端 用sendto
    var_dump($clientInfo);
    $s = $serv->sendto($clientInfo['address'], $clientInfo['port'], "Server ".$data);
    var_dump($s);
});
//启动服务器
$serv->start();