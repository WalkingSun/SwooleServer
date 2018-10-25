<?php
//起TCP服务
//创建Server对象，监听 0.0.0.0:9501端口
$serv = new swoole_server("0.0.0.0", 9501);

$serv->set([
    'worker_num' => 4,   //worker进程数  cpu 1-4倍
    'max_request' =>  1000,  //worker进程在处理完n次请求后结束运行。manager会重新创建一个worker进程。此选项用来防止worker进程内存溢出。
]);

//监听连接进入事件
/**
 * $fd 客户端连接的唯一标识
 * $reactor_id 线程id
 */
$serv->on('connect', function ($serv, $fd , $reactor_id ) {
    echo "Client: {$reactor_id} - {$fd}- Connect.\n";
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    $serv->send($fd, "Server: {$reactor_id} - {$fd} -".$data);   //向客户端发送数据
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();


//ps aft | grep server.php   查看进程  ,会看到子进程数就是上面的设置

//问题：增加进程数，需关闭现有tcp服务，实际生产不可用，会关闭很多服务，如何不影响现有流程实现增加新的进程呢？