<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/10/25
 * Time: 17:40
 */
//websocket  全双工模式，可以做发送通知，接受消息的服务

//为什么要使用websocket?  http的通信只能由客户端发起。


/**
 websocket特点:
 1.建立在TCP协议之上；
 2.性能开销小通信高效；
 3.客户端可以与任意服务器通信segm
 4.协议标识符ws wss
 5. 持久化网络通信协议
 **/


//了解下websocket 服务端与客户端的流程，最好手绘出来
//bind -> listen -> read -> write ->close
$serv = new swoole_websocket_server('0.0.0.0',9501);

$serv->on('open',function($serv,$request){
    echo "server: handshake  success with fd= {$request->fd}\n";
});

$serv->on('message',function($serv,$frame){
    echo "receive from {$frame->fd}:{$frame->data}:{$frame->opcode},fin:{$frame->finish}\n";
    $serv->push($frame->fd,"this is websocker server!");
});

$serv->on('close',function($serv,$fd){
    echo "client {$fd} closed\n";
});

$serv->start();