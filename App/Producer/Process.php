<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/14
 * Time: 16:50
 */
namespace App\Producer;

use EasySwoole\Component\Process\AbstractProcess;
use EasySwoole\Kafka\Config\ProducerConfig;
use EasySwoole\Kafka\Kafka;

class Process extends AbstractProcess
{
    protected function run($arg)
    {
        var_dump(22222);

        go(function () {
            $config = new ProducerConfig();
            $config->setMetadataBrokerList('127.0.0.1:9092,127.0.0.1:9093');
            $config->setBrokerVersion('0.9.0');
            $config->setRequiredAck(1);

            $kafka = new Kafka($config);
            $result = $kafka->producer()->send([
                [
                    'topic' => 'test',
                    'value' => 'message--',
                    'key'   => 'key--',
                ],
            ]);
            
            var_dump($result);
            var_dump('ok');
        });
    }
}