<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use App\Producer\Process as ProducerProcess;
use App\Consumer\Process as ConsumerProcess;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        // 生产者
       /* \EasySwoole\Component\Process\Manager::getInstance()->addProcess(new ProducerProcess());*/
        // 消费者
        \EasySwoole\Component\Process\Manager::getInstance()->addProcess(new ConsumerProcess());



        //定义kafka生成者的pool
        $config = new \EasySwoole\Pool\Config();
        \EasySwoole\Pool\Manager::getInstance()->register(new \App\Pool\KafkaPool($config),'kafka1');
        \EasySwoole\Pool\Manager::getInstance()->register(new \App\Pool\KafkaPool($config),'kafka2');
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}