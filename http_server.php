<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/10/19
 * Time: 15:10
 */

//新起个http server   相当于nginx web server
//同步模式 等同于nginx+php-fpm/apache,它需要设置大量worker进程来完成并发请求处理。 worker进程内可以使用同步阻塞IO,编程方式和PHP WEB完全一致。与php-fpm/apache不同的是，客户端连接并不会独占进程，服务器依然可以应对大量并发连接。
//异步模式 这种模式下整个服务器是异步非阻塞的，服务器可以应对大规模的并发连接和并发请求。但编程方式需要完全使用异步API，如MySQL、redis、http_client、file_get_contents、sleep等阻塞IO操作必须切换为异步的方式，如异步swoole_client，swoole_event_add，swoole_timer，swoole_get_mysqli_sock等API。
$http = new swoole_http_server("0.0.0.0",9501);

$http->set([
    'enable_static_handler'=> true,     //启用静态资源处理
    'document_root' => '/data/app/data'   //静态资源地址
]);

$http->on('request',function ($request , $response){
    $data = array_merge($request->get?:[],$request->post?:[]);
    $response->header('Content-type','text/html;charser=utf-8');        //设置header
    $response->cookie("sun",random_int(1000,99999),time()+1800);        //设置cookie
    $response->end("<h1>Hello Swoole.#".json_encode($data)."</h1>");    //返回客户端
});

$http->start();