<?php
//页面输出字符串编码格式
header("content-type:text/html;charset=utf-8");
//引入类方法文件
require ( "sphinxapi.php" );
//实列化
$cl = new SphinxClient ();
$cl->SetServer ( '127.0.0.1', 9312); //连接sphinx服务
$cl->SetConnectTimeout ( 3 ); //超时时间
$cl->SetArrayResult ( true );  //以数组形式返回获得的结果
$cl->SetMatchMode ( SPH_MATCH_ANY);  //分词，收集分词任何部分检索的结果

$cl->setLimits(0,20); //限制获取记录条数
                        //（前12个记录信息）
//索引源名称
$index_name = "dizhi";
$key = "北京西二旗";
//$res = $cl->Query ( '被检索的关键字', "索引名称" );
$res = $cl->Query ( $key, $index_name );
//格式输出
echo '<pre>';
var_dump($res);
//拼接id字符串
// $ids = '';
// foreach ($res['matches'] as $key => $value) {
//   $ids .= $value['id'].',';
// }
// echo rtrim($ids,',');


