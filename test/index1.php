<?php
//页面输出字符串编码格式
header("content-type:text/html;charset=utf-8");
//引入类
require './sphinxapi.php';

//查询的关键词
$keyword = 'redis';
//查询的索引
$index = 'zhilian';

$s=new SphinxClient();
$s->SetServer('localhost',9312);
$s->SetConnectTimeout(3);
$s->SetArrayResult(true);
$s->SetMatchMode(SPH_MATCH_ANY);//搜集任何部分的检索结果
$s->SetLimits(0,20);//限制获取记录条数
$keyword=$_GET['key']?$_GET['key']:'redis';
$index='zhilian';
//$res=$s->Query($keyword,$index);
//var_dump($res);

$res = $s->Query ( $keyword, $index );
$arr=array();
foreach ($res['matches'] as $k=>$v){
    $arr[]=$v['id'];
//    echo
}
$ids=rtrim(implode(',',$arr));
//$ids=$res['matches'][0]['id'];
// var_dump($ids);die();
//获取到索引
//需要把索引里的id全部取出，然后到数据库里取出数据

// var_dump($ids);
//通过id进行数据库查询操作，查询到数据
$mysqli=mysqli_connect('127.0.0.1','root','root','qz','3306');
$mysqli->set_charset('utf8');
$sql = "select * from zhilian where id in ($ids)";
$res = $mysqli->query($sql);
//var_dump($res->fetch_array());die;
//遍历资源集
//$res=$res->fetch_array();
$rows=array();
while ($row=$res->fetch_array('1')){

    $r = $s->buildExcerpts($row,'zhilian',$keyword,array(
        'before_match' => '<strong><font color="red">',
        'after_match' => '</font></strong>'
    ));

    $rows[] = $r;
//    var_dump($row);
}
// var_dump($rows);die;
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<?php foreach ($rows as $key => $value) {
    foreach ($value as $v){
        echo $v."<br>";
    }
}
?>
</body>
</html>


