<?php
require __DIR__. '/../vendor/autoload.php';
use luffyzhao\db\Db;


/**
 * 测试读写分离和分布式
 */
$database = [
    // 数据库类型
    'type' => 'mysql',
    // 服务器地址
    'hostname' => 'localhost,localhost',
    // 数据库名
    'database' => 'test,test1',
    // 用户名
    'username' => 'root',
    // 密码
    'password' => '123456',
    // 端口
    'hostport' => '3306',
    // 分布式
    'deploy' => 1,
    // 读写分享
    'rw_separate' => true
];
$db = Db::connect($database);

$res = $db->table('test_db')->data('name', '战非')->data('phone', '15215214578')->insert();

print "添加成功,ID:" . $res . "\n";

$res = $db->table('test_db')->findAll();
// 没有数据
print_r($res);

// 有数据 (事务开始之后拿主库里的数据)
$db->startTrans();
$res = $db->table('test_db')->findAll();
$db->commit();
print_r($res);