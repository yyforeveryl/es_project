<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/11
 * Time: 11:59
 */
namespace App\Model;
use EasySwoole\ORM\AbstractModel;
use EasySwoole\Mysqli\QueryBuilder;

class User extends AbstractModel{

    /**
     * @var string
     */
    protected $tableName = 'clur_user';


    public static  function aaa(){
        // 通过主键
        return self::create()->get(1);
    }




}
