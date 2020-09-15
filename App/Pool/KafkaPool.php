<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/15
 * Time: 15:33
 */
namespace App\Pool;

use EasySwoole\Pool\Config;
use EasySwoole\Pool\AbstractPool;
use EasySwoole\Kafka\Config\ProducerConfig;
use EasySwoole\Kafka\Kafka;

class KafkaPool extends AbstractPool
{
    protected $kafkaConfig;

    /**
     * 重写构造函数,为了传入kafka配置 (kafka的生产者pool)
     * RedisPool constructor.
     * @param Config      $conf
     * @param RedisConfig $redisConfig
     * @throws \EasySwoole\Pool\Exception\Exception
     */
    public function __construct(Config $conf)
    {
        $config = new ProducerConfig();
        $config->setMetadataBrokerList('127.0.0.1:9092,127.0.0.1:9093');
        $config->setBrokerVersion('0.9.0');
        $config->setRequiredAck(1);
        parent::__construct($conf);
        $this->kafkaConfig = $config;
    }

    protected function createObject()
    {
        //根据传入的kafka配置进行new 一个kafka
        $kafka = new Kafka($this->kafkaConfig);
        return $kafka;
    }
}