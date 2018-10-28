<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/10/21
 * Time: 20:35
 */
////创建websocket服务
//$ws = new swoole_websocket_server("0.0.0.0",9501);
//
////监听websocket连接并打开事件
//$ws->on('open',function ($ws,$request){
//    var_dump($request->fd,$request->get,$request->server);
//    $ws->push($request->fd,"hello welcome\n");
//});
//
////监听websocket消息事件
//$ws->on('message',function($ws,$frame){
//    echo "Message:{$frame->data}";
//    $ws->push($frame->fd,"server:{$frame->data}");
//});
//
////监听websocket连接关闭事件
//$ws->on('close',function ($ws,$fd){
//    echo "client-{$fd} is closed";
//});
//
//$ws->start();

//面向对象
include  __DIR__.'/models/WsServer.php';
$ws = new WsServer();

