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
$sm = $_GET['semester'];
$couNo = $_GET['couNo'];
/*$tNo = "10003906";
$sm = "2018-2019春季";
$couNo = "01002145";*/
$sm = (iconv('UTF-8','GBK',$sm));//牛逼转码
header("Access-Control-Allow-Origin:*");
$sql = "select courseSelect.stuNo, stuName from  studentMessage, courseSelect where teaNo = '$tNo' and semester = '$sm' and courseSelect.couNo = '$couNo' and courseSelect.stuNo = studentMessage.stuNo";
//echo($sql);
// and courseGrade.couNo = '$couNo' and courseGrade.stuNo = courseSelect.stuNo 
$course = array();
$result = sqlsrv_query($conn,$sql);
if(sqlsrv_has_rows($result)){
	while($row=sqlsrv_fetch_array ($result)) {
		$fileType = mb_detect_encoding($row['stuName'], array('UTF-8','GBK','LATIN1','BIG5'));//自动获取编码函数牛逼
		if( $fileType != 'UTF-8') {
			$row = mb_convert_encoding($row,'UTF-8' , $fileType);
		}
		$tmp1 = $row['stuNo'];
		$sql = "select usPer, testPer, totalPer from courseGrade where couNo = '$couNo' and stuNo = '$tmp1' and teaNo = '$tNo' and semester = '$sm'";
		$grade = sqlsrv_query($conn,$sql);
		$row1=sqlsrv_fetch_array ($grade);
		if(sqlsrv_has_rows($grade)) {
			$row = array_merge($row, $row1);
		}
		else {
			array_push($row, "null");
			$tmp = array("usPer"=>"null");
			$row = array_merge($row, $tmp);
			array_push($row, "null");
			$tmp = array("testPer"=>"null");
			$row = array_merge($row, $tmp);
			array_push($row, "null");
			$tmp = array("totalPer"=>"null");
			$row = array_merge($row, $tmp);
		}
		array_push($course, $row);

		echo JSON_encode($row,JSON_UNESCAPED_UNICODE);
	}
}
else {
	echo "无查询结果";
}
?>