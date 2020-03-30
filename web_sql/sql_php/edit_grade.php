<?php
error_reporting(0);
ini_set('mssql.charset', 'utf-8');
header("Content-Type:text/html;charset=utf-8");
/*$str = $_POST['username'];
$str1 = $_POST['semester'];
echo $str;
echo $str1;*/
$serverName = "127.0.0.1"; //数据库服务器地址
$uid = "sa";     //数据库用户名
$pwd = "123456"; //数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"school");
$conn = sqlsrv_connect($serverName, $connectionInfo);
$sNo = $_GET['stuNo'];
$cNo = $_GET['couNo'];
$pscj = $_GET['pscj'];
$pscj = (int)$pscj;
$kscj = $_GET['kscj'];
$kscj = (int)$kscj;
$tNo = $_GET['username'];
$semester = $_GET['semester'];
echo $sNo;
echo $cNo;
echo $pscj;
echo $kscj;
echo $tNo;
echo $semester;
/*$sNo = "16009056";
$cNo = "00568913";
$pscj = "100";
$kscj = "90";
$pscj = (int)$pscj;
$kscj = (int)$kscj;*/
$zpcj = 0;
header("Access-Control-Allow-Origin:*");
if($pscj > 100 || $kscj > 100) {
	echo("插入错误");
}
else {
	$sql = "insert into courseGrade (couNo, stuNo, usPer, testPer, teaNo, semester) values ('$cNo', '$sNo', $pscj, $kscj, '$tNo', '$semester')";
	echo $sql;
	$result=sqlsrv_query($conn,$sql);
	if($result)
		echo "true";
	else
		echo"false";
}
/*if(sqlsrv_has_rows($result)){
	while($row=sqlsrv_fetch_array ($result)) {
		$fileType = mb_detect_encoding($row['couName'], array('UTF-8','GBK','LATIN1','BIG5'));//自动获取编码函数牛逼
		if( $fileType != 'UTF-8') {
			$row = mb_convert_encoding($row,'UTF-8' , $fileType);
		}
		echo JSON_encode($row,JSON_UNESCAPED_UNICODE);
	}
}
else {
	echo "无查询结果";
}*/
?>