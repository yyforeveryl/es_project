<?php
/**
 * 批量插入、更新
 * User: Siam
 * Date: 2019/12/5
 * Time: 17:22
 */

namespace EasySwoole\ORM\Tests;


use EasySwoole\Mysqli\Exception\Exception;
use EasySwoole\ORM\Db\Config;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\DbManager;
use PHPUnit\Framework\TestCase;



use EasySwoole\ORM\Tests\models\TestUserListModel;

class SaveAllTest extends TestCase
{

    /**
     * @var $connection Connection
     */
    protected $connection;
    protected $tableName = 'user_test_list';
    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $config = new Config(MYSQL_CONFIG);
        $this->connection = new Connection($config);
        // DbManager::getInstance()->addConnection($this->connection);
        DbManager::getInstance()->addConnection($this->connection,'siam');
        $connection = DbManager::getInstance()->getConnection('siam');
        $this->assertTrue($connection === $this->connection);
    }


    public function testSaveAllUseConnectName()
    {
        $data = [
            [
                'name' => 'siam,你好',
                'age'  => 21,
                'addTime' => "2019-11-22 20:19:16",
                'state' => 1
            ],
            [
                'name' => 'siam,你好',
                'age'  => 21,
                'addTime' => "2019-11-22 20:19:16",
                'state' => 2
            ]
        ];
        $res =  TestUserListModel::create()->connection('siam')->saveAll($data);

        $this->assertEquals(count($res), 2);
        $this->assertIsInt($res[1]['id']);
    }

    public function testSaveAll()
    {
        $data = [
            [
                'name' => 'siam,你好',
                'age'  => 21,
                'addTime' => "2019-11-22 20:19:16",
                'state' => 1
            ],
            [
                'name' => 'siam,你好',
                'age'  => 21,
                'addTime' => "2019-11-22 20:19:16",
                'state' => 2
            ]
        ];

        $res = TestUserListModel::create()->connection('siam')->saveAll($data);
        $this->assertEquals(count($res), 2);
        $this->assertIsInt($res[1]['id']);

        return [
            $res[0]['id'],
            $res[1]['id'],
        ];
    }

    /**
     * @depends testSaveAll
     */
    public function testUpdateAll($ids)
    {
        $data = [
            [
                'id'   => $ids[0],
                'name' => 'siam,你好',
                'age'  => 21,
                'addTime' => "error",
                'state' => 127,
            ],
            [
                'id'   => $ids[1],
                'name' => 'siam,你好',
                'age'  => 21,
                'addTime' => "2019-11-22 20:19:16",
                'state' => 127
            ]
        ];

        try {
            $res = TestUserListModel::create()->connection('siam')->saveAll($data);

            $this->assertEquals(count($res), 2);
            $this->assertEquals($res[0]['id'], $ids[0]);
            $this->assertEquals($res[0]['state'], 127);
            $this->assertIsInt($res[1]['id']);
        } catch (Exception $e) {
        } catch (\EasySwoole\ORM\Exception\Exception $e) {
            $res = strpos($e->getMessage(), "SQLSTATE[22007] [1292] Incorrect datetime value: 'error' for column 'addTime' at row 1") !== false;
            $this->assertTrue($res);
        } catch (\Throwable $e) {
        }

    }

    /**
     * @depends testSaveAll
     */
    public function testSaveAllNotReplace($ids)
    {
        $data = [
            [
                'id'   => $ids[0],
                'name' => 'siam,你好',
                'age'  => 21,
                'addTime' => "2019-11-22 20:19:16",
                'state' => 127,
            ],
            [
                'id'   => $ids[1],
                'name' => 'siam,你好',
                'age'  => 21,
                'addTime' => "2019-11-22 20:19:16",
                'state' => 127
            ]
        ];

        try {
            $res = TestUserListModel::create()->connection('siam')->saveAll($data, FALSE);
        } catch (Exception $e) {
        } catch (\EasySwoole\ORM\Exception\Exception $e) {
            $this->assertNotFalse(strpos($e->getMessage(),"SQLSTATE[23000] [1062] Duplicate entry '{$ids[0]}' for key 'PRIMARY'" ));
        } catch (\Throwable $e) {
        }
    }


    public function testDeleteAll()
    {
        $res = TestUserListModel::create()->connection('siam')->destroy(null, true);
        $this->assertIsInt($res);
    }
}