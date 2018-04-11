<?php


$mysqli = new mysqli("127.0.0.1", "root", "root",'test');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//
//if (!$mysqli->query("DROP TABLE IF EXISTS test") ||
//    !$mysqli->query("CREATE TABLE test(id INT)") ||
//    !$mysqli->query("INSERT INTO test(id) VALUES (1)")) {
//    echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
//}

//mysql_connect('192.128.199.109','root','root');
//mysql_select_db('test');
$name=$_POST['name'];
$mobile=$_POST['mobile'];
$sql="insert into member VALUES (NULL ,$name,$mobile)";
var_dump($sql);
$res=$mysqli->query($sql);
var_dump($res);die;
//二分查找法
function binary($arr,$v){
    $len=count($arr);
    $end=$len-1;
    $start=0;
    $mid=ceil(($end+$start)/2);
    while($start<$end){
        if($v<$arr[$mid]){
            $end=$mid-1;
        }else if($v>$arr[$mid]){
            $start=$mid+1;
        }else{
            return $mid;
        }

    }
}

$arr=array(1,2,3,4,5,6,7,8,9);
$v=5;
$res=binary($arr,$v);
echo $res;


//冒泡排序
function bubble($arr=array()){
    $len=count($arr)-1;
for($i=0;$i<$len;$i++){
    for ($j=0;$j<$len-$i;$j++){
        if($arr[$j]>$arr[$j+1]){
            $tmp=$arr[$j];
            $arr[$j]=$arr[$j+1];
            $arr[$j+1]=$tmp;
        }

    }
}
print_r($arr);
}
$arr=array(5,1,9,6,8,11,56,74,21,3);
$res=bubble($arr);


function read_dir($dir){
    $handle=opendir($dir);
    echo "<ul>";
    while($line=readdir($handle)){
        if($line=='.' || $line=='..'){
            continue;
        }else{
            echo "<li>$line</li>";
        }

        if(is_dir("$dir/$line")){
            read_dir("$dir/$line");
        }
    }
    echo "</ul>";
    closedir($handle);
}

read_dir("./resources");

//快速排序法

function quick_sort($arr){

    $len =count($arr);
    if($len<=1){
        return $arr;
    }
    $param=$arr[0];
    $leftarr=array();
    $rightarr=array();
    for($i=1;$i<$len;$i++){
        if($arr[$i]>$param){
            $rightarr[]=$arr[$i];
        }else{
            $leftarr[]=$arr[$i];
        }
    }
//
//    var_dump($rightarr);die;
    $leftarr=quick_sort($leftarr);
    $rightarr=quick_sort($rightarr);
    return array_merge($leftarr,array($param),$rightarr);
}

$arr=array(5,8,1,3,9,6);
$res=quick_sort($arr);
var_dump($res);



//猴子称王


function  king($n,$q){
    $arr=range(1,$n);
    $i=0;
//    var_dump(count($arr));
    echo "<hr>";
    while (count($arr)>1){
//        var_dump(count($arr));
        if(($i)%$q==0){
//            echo $i;die;
            unset($arr[$i-1]);

        }else{
//            $arr[]=$arr[$i];
            array_push($arr,$arr[$i-1]);
//            var_dump($arr);

            unset($arr[$i-1]);
//
        }
        $i++;
    }
    return $arr;
}

function king1($n,$count){
    $arr=range(1,$n);
    $i = 0;//从1开始
    while(count($arr) > 1){
        if($i%$count == 0){//用求余，计算数到的位，如果求余为0，所数到的位消除，压出数组中
            unset($arr[$i-1]);
        }else{//数到的位不是结束，把这一位放到数组末尾，并消掉这个位
            array_push($arr,$arr[$i-1]);
            unset($arr[$i-1]);
        }
        $i++;//转移到下一个数组元素
    }
    return $arr;
}


$res=king(5,4);
var_dump($res);

//递推  波菲那齐
function  ditui($n){
    echo "<hr>";
    $a=1;$b=1;
    $c=0;
    for($i=3;$i<=$n;$i++){
        $c=$a+$b;
        var_dump($c);
        $a=$b;
        $b=$c;
    }
    return $c;
}

echo  ditui(5);
$a=1;
echo $a++ + ++$a;


function get_rand($proArr) {
    $result = '';
//概率数组的总概率精度
    $proSum = array_sum($proArr);
//概率数组循环
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
//            0-100
            $result = $key;
            break;
        } else {
            $proSum =$proSum - $proCur;
        }
    }
    unset ($proArr);
return $result;
}
$res = get_rand([100,200,300,400]);//相当于抽中这个 key 的几率分别为 100,200,300，400
print_r($res);


function niu($n){
    static $num=1;
    for($i=1;$i<$n;$i++){
        if($i>=4 && $i<15){
            $num++;
            niu($n-$i);
        }
        if($i==20){
            $num--;
        }
    }

    return $num;
}

echo "<hr>";
$str='192.168.1.24';
echo ip2long($str.PHP_EOL);
