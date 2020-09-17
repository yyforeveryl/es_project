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
use EasySwoole\ORM\DbManager;
use EasySwoole\ORM\Db\Connection;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
        $config = new \EasySwoole\ORM\Db\Config(Config::getInstance()->getConf('MYSQL'));
        //连接池配置
        $config->setGetObjectTimeout(3.0); //设置获取连接池对象超时时间
        $config->setIntervalCheckTime(30*1000); //设置检测连接存活执行回收和创建的周期
        $config->setMaxIdleTime(15); //连接池对象最大闲置时间(秒)
        $config->setMaxObjectNum(20); //设置最大连接池存在连接对象数量
        $config->setMinObjectNum(5); //设置最小连接池存在连接对象数量
        $config->setAutoPing(5); //设置自动ping客户端链接的间隔
        DbManager::getInstance()->addConnection(new Connection($config));
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