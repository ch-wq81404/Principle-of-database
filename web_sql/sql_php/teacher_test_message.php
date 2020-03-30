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
$tNo = $_GET['username'];
#$tNo = "10003906";
$sm = $_GET['semester'];
#$sm = "2018-2019春季";
$sm = (iconv('UTF-8','GBK',$sm));//牛逼转码
header("Access-Control-Allow-Origin:*");
$sql = "select courseMessage.couNo, couName, convert(char,testTimeBegin,120) testTimeBegin, convert(char,testTimeEnd,120) testTimeEnd, testAddr, ps from  testMessage, courseMessage where teaNo = '$tNo' and semester = '$sm' and courseMessage.couNo = testMessage.couNo";
//echo($sql);
$course = array();
$result=sqlsrv_query($conn,$sql);
if(sqlsrv_has_rows($result)){
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
}
?>