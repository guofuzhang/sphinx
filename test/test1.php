<?php
//页面输出字符串编码格式
header("content-type:text/html;charset=utf-8");
//引入类
require './sphinxapi.php';
//实列化
$spinx = new SphinxClient();
//设置连接sohinx
$sphinx = new SphinxClient ();
$sphinx->SetServer ( '127.0.0.1', 9312); //连接sphinx服务
$sphinx->SetConnectTimeout ( 3 ); //超时时间
$sphinx->setLimits(0,5); //限制获取记录条数
$sphinx->SetMatchMode (SPH_MATCH_ANY);  //分词，收集分词任何部分检索的结果
$sphinx->SetArrayResult ( true );  //以数组形式返回获得的结果
//查询
//查询的关键词
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : 'redis';
//查询的索引
$index = 'zhilian';

$res = $sphinx->Query ( $keyword, $index );
// var_dump($res);die;
$time = $res['time'];
// var_dump($res);die();
//获取到索引
//需要把索引里的id全部取出，然后到数据库里取出数据
$ids_array = array();
if(isset($res['matches'])){
    foreach ($res['matches'] as $key => $value) {
      $id = $value['id'];
      // var_dump($id);die();
      $ids_array[] = $id;
    }
    //通过in查询
    $ids = implode($ids_array , ',');
    // var_dump($ids);
    //通过id进行数据库查询操作，查询到数据
    mysql_connect('127.0.0.1','root','root');
    mysql_select_db('quanzhan1');
    mysql_query('set names utf8');
    $sql = "select * from zhilian where id in ($ids)";
    $res = mysql_query($sql);
    //遍历资源集
    $rows = array();
    while ($row = mysql_fetch_assoc($res)) {
      $row = $sphinx->buildExcerpts($row,'zhilian',$keyword,array(
      'before_match' => '<strong><font color="red">',
      'after_match' => '</font></strong>'
      ));
      $rows[] = $row;
    }
}
// var_dump($rows);
// var_dump($res);die();
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<form>
  搜索框：<input type="text" name="keyword" value="<?php echo $_GET['keyword']?>">
  <input type="submit" name="" value="搜索">
<hr>
本次搜索时间：<?php echo $time?>s<br />
<hr>
</form>
  <?php
  if(isset($rows)){
    foreach ($rows as $key => $value) {
    foreach ($value as $k => $v) {
      # code...
  ?>
  <p><?php echo $v?></p>
<?php
  }
    }
  }
?>
</body>
</html>


