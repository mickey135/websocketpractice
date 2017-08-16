<?php
//创建websocket服务器对象,监听0.0.0.0:9501端口
$ws = new swoole_websocket_server("0.0.0.0",9501);

//监听websocket连接打开事件
$ws->ffff = [];
$ws->on('open',function ($ws,$request){
    $ws->ffff[] = $request->fd;
});

//监听websocket消息事件
$ws->on('message',function ($ws,$f) {
    $msg = '来自'.$f->fd.":".$f->data."<br>";
    foreach($ws->ffff as $v){
        $ws->push($v,$msg);
    }
});

//监听websocket关闭事件
$ws->on('close',function($ws,$fd){
    unset($ws->ffff[$fd-1]);
});

$ws->start();
