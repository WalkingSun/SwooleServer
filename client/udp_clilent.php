<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/10/24
 * Time: 10:53
 */

$client = new swoole_client(SWOOLE_SOCK_UDP);

//连接udp server ，控制台输入信息，发送到 server
if(!$client->connect('59.110.225.118',9501,1) ){
    echo "client connect fail";
    exit;
}

$i = 0;
while ($i < 10) {
    $client->send($i."\n");
    $message = $client->recv();
    echo "Get Message From Server:{$message}\n";
    $i++;
}
//fwrite(STDOUT,"请输入信息");
//$msg = trim(fgets(STDIN));
//$client->send($msg);
//$message = $client->recv();
//echo "Get Message From Server:{$message}\n";
