<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/14
 * Time: 16:50
 */
namespace App\Consumer;

use EasySwoole\Component\Process\AbstractProcess;
use EasySwoole\Kafka\Config\ConsumerConfig;
use EasySwoole\Kafka\Kafka;

class Process extends AbstractProcess
{
    protected function run($arg)
    {
        go(function () {
            $config = new ConsumerConfig();
            $config->setRefreshIntervalMs(1000);
            $config->setMetadataBrokerList('127.0.0.1:9092,127.0.0.1:9093');
            $config->setBrokerVersion('0.9.0');
            $config->setGroupId('test');

            $config->setTopics(['test']);
            $config->setOffsetReset('earliest');

            $kafka = new Kafka($config);
            // 设置消费回调
            $func = function ($topic, $partition, $message) {
                /*var_dump($topic);
                var_dump($partition);*/
                var_dump($message);
            };
            $kafka->consumer()->subscribe($func);
        });
    }
}