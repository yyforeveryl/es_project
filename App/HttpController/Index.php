<?php
namespace App\HttpController;
use EasySwoole\Http\AbstractInterface\Controller;
use App\Model\User;
use EasySwoole\Kafka\Config\ProducerConfig;
use EasySwoole\Kafka\kafka;
use App\Producer\Process as ProducerProcess;


class Index extends Controller
{

    public function index()
    {
        //dev1的修改
        // TODO: Implement index() method.

        $config = new ProducerConfig();
        $config->setMetadataBrokerList('127.0.0.1:9092,127.0.0.1:9093');
        $config->setBrokerVersion('0.9.0');
        $config->setRequiredAck(1);

        $kafka = new kafka($config);
        $result = $kafka->producer()->send([
            [
                'topic' => 'test',
                'value' => 'message--',
                'key'   => 'key--',
            ],
        ]);

        var_dump($result);
        var_dump('ok');

        $a = 1;
        $b = $a ++ + $a;   //$a ++ + $a ++ + ++ $a
        $this->writeJson(400,[$b],'success');
      //  $this->response()->write('hello world!!222');

    }

    //kafka生成者pool测试
    public function kafkaPool(){
        go(function (){
            $kafka1 = \EasySwoole\Pool\Manager::getInstance()->get('kafka1')->getObj();

            $result = $kafka1->producer()->send([
                [
                    'topic' => 'test',
                    'value' => 'bbbb1121',
                    'key'   => 'aaaa1112',
                ],
            ]);
            var_dump($result);
            var_dump('ok');




            //回收对象
            \EasySwoole\Pool\Manager::getInstance()->get('kafka1')->recycleObj($kafka1);


        });


        $this->writeJson(200,[],'success');
    }


    public function test(){
        $request = $this->request();

        $data = $request->getRequestParam();
        //var_dump($request['a']);

        go(function (){
            $csp = new \EasySwoole\Component\Csp();
            $csp->add('t1',function (){
                \co::sleep(6);
                return 't1 result';
            });
            $csp->add('t2',function (){
                \co::sleep(6);
                return 't2 result';
            });

            print_r($csp->exec());
        });

         $aa = new ProducerProcess();


        $data = User::aaa();
        $this->writeJson(200,$data,'success');
    }
}
