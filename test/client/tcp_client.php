<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/10/23
 * Time: 19:51
 */

//连接swoole TCP 服务
$client = new swoole_client(SWOOLE_SOCK_TCP);

if( !$client->connect('59.110.225.118',9501)){
    echo '连接失败';
    exit;
}

//php cli常量
fwrite(STDOUT,"请输入消息：");
$msg = trim(fgets(STDIN));

//发送消息 tcp server
$client->send($msg);

//接受来自server的数据
$result = $client->recv();
echo $result;
