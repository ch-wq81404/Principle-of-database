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
/*$tNo = $_GET['username'];
$sm = $_GET['semester'];*/
$tNo = "10003906";
$sm = "2018-2019春季";
$sm = (iconv('UTF-8','GBK',$sm));//牛逼转码
header("Access-Control-Allow-Origin:*");
$sql = "select courseMessage.couNo, couName, couAddr, couAns from courseRelease, courseMessage where teaNo = '$tNo' and semester = '$sm' and courseMessage.couNo = courseRelease.couNo";
//echo($sql);
$course = array();
$result=sqlsrv_query($conn,$sql);
$ret = array();
$ret1 = array();
$ret2 = array();
$time = array(20, 0, 20, 0, 20, 0, 20, 0, 20, 0, 20, 0, 20, 0);
$day = array_pad($input, 7, 0);
$dday = array("星期一", "星期二", "星期三", "星期四" ,"星期五", "星期六", "星期日");
if(sqlsrv_has_rows($result)){
	while($row=sqlsrv_fetch_array ($result)) {
		$fileType = mb_detect_encoding($row['couName'], array('UTF-8','GBK','LATIN1','BIG5'));//自动获取编码函数牛逼
		if( $fileType != 'UTF-8') {
			$row = mb_convert_encoding($row,'UTF-8' , $fileType);
		}
		//print_r($row);
		$cNo = $row['couNo'];
		$sql = "select couDay, couTime from courseTime where couNo = '$cNo' and semester = '$sm' and teaNo = '$tNo'";
		$date = sqlsrv_query($conn, $sql);
		while($datetmp = sqlsrv_fetch_array ($date)) {
			$fileType1 = mb_detect_encoding($datetmp['couDay'], array('UTF-8','GBK','LATIN1','BIG5'));//自动获取编码函数牛逼
			if( $fileType1 != 'UTF-8') {
				$datetmp = mb_convert_encoding($datetmp,'UTF-8' , $fileType1);
			}
			
			if($datetmp['couDay'] == '星期一') {
				$day[1] = 1;
				$time[0] = min($time[0], $datetmp['couTime']);
				$time[1] = max($time[1], $datetmp['couTime']);
			}
			else if($datetmp['couDay'] == '星期二') {
				$day[2] = 1;
				$time[2] = min($time[2], $datetmp['couTime']);
				$time[3] = max($time[3], $datetmp['couTime']);
			}
			else if($datetmp['couDay'] == '星期三') {
				$day[3] = 1;
				$time[4] = min($time[4], $datetmp['couTime']);
				$time[5] = max($time[5], $datetmp['couTime']);
			}
			else if($datetmp['couDay'] == '星期四') {
				$day[4] = 1;
				$time[6] = min($time[6], $datetmp['couTime']);
				$time[7] = max($time[7], $datetmp['couTime']);
			}
			else if($datetmp['couDay'] == '星期五') {
				$day[5] = 1;
				$time[8] = min($time[8], $datetmp['couTime']);
				$time[9] = max($time[9], $datetmp['couTime']);
			}
			else if($datetmp['couDay'] == '星期六') {
				$day[6] = 1;
				$time[10] = min($time[10], $datetmp['couTime']);
				$time[11] = max($time[11], $datetmp['couTime']);
			}
			else if($datetmp['couDay'] == '星期日') {
				$day[7] = 1;
				$time[12] = min($time[12], $datetmp['couTime']);
				$time[13] = max($time[13], $datetmp['couTime']);
			}
		}
		$finDate = "";
		foreach ($day as $key => $value) {
			if($value == 1) {
				$tmp = $dday[$key - 1];
				$time1 = $time[($key - 1) * 2];
				$time2 = $time[($key - 1) * 2 + 1];
				if($time1 == $time2) {
					$finDate = $finDate." $tmp $time1";
				}
				else {
					$finDate = $finDate." $tmp $time1 - $time2";
				}
			}
		}
		array_push($row, "$finDate");
		$tmpa = array("couDayTime"=>"$finDate");
		$row = array_merge($row, $tmpa);

		echo JSON_encode($row,JSON_UNESCAPED_UNICODE);
	}
}
else {
	echo "无查询结果";
}
?>