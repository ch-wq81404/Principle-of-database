<?php
error_reporting(E_ALL || ~E_NOTICE);
header("Access-Control-Allow-Origin:*");
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"school");
$conn = sqlsrv_connect($serverName, $connectionInfo);
$value=$_GET["value"];
$postData=$_GET["array"];
$table=$_GET["table"];
$user=$_GET["stuNo"];
$array=json_decode($postData,true);

$count_json=count($array);
$in_value_arr="";
$in_value_arrs="";
if($table=='studentMessage') //存到学生信息表
{
	$stuIn=$array[0]['stuIn'];
	$stuIn=substr($stuIn,2,2);
	$fileType = mb_detect_encoding($stuIn, array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'GBK')
			$stuIn = mb_convert_encoding($stuIn,'GBK' , $fileType);
	$query="select max(stuNo) as stuNo from studentMessage where stuNo like '$stuIn%'";
	$result=sqlsrv_query($conn,$query,array());
	if(sqlsrv_has_rows($result))
	{
		$row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
		$stuNo=intval($row['stuNo']);
	}
	sqlsrv_free_stmt( $result);
	foreach($array as $key=>$info){
		$stuNo++;
		$in_value_arr=$in_value_arr."'".$stuNo."',";
		foreach($info as $k=>$v){
			if(is_int($v))
				$in_value_arr=$in_value_arr.$v.",";
			else
				$in_value_arr=$in_value_arr."'".$v."',";
		}
		$new_value=substr($in_value_arr,0,strlen($in_value_arr)-1);
		$in_value_arr="";
		$fileType = mb_detect_encoding($new_value, array('UTF-8','GBK','LATIN1','BIG5')) ;
			if( $fileType != 'GBK')
				$new_value = mb_convert_encoding($new_value,'GBK' , $fileType);
		$in_value_arrs=$in_value_arrs."insert into $table values(".$new_value.");";
	}
	save($in_value_arrs,$conn);
}
else if($table=='teacherMessage')//存到教师信息表
{
	$query="select max(teaNo) as teaNo from teacherMessage";
		$result=sqlsrv_query($conn,$query,array());
		if(sqlsrv_has_rows($result))
		{
			$row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
			$teaNo=intval($row['teaNo']);
		}
		sqlsrv_free_stmt($result);
	foreach($array as $key=>$info){
		$teaNo++;
		$in_value_arr=$in_value_arr."'".$teaNo."',";
		foreach($info as $k=>$v){
			if(is_int($v))
				$in_value_arr=$in_value_arr.$v.",";
			else
				$in_value_arr=$in_value_arr."'".$v."',";
		}	
			$new_value=substr($in_value_arr,0,strlen($in_value_arr)-1);
			$in_value_arr="";
			$fileType = mb_detect_encoding($new_value, array('UTF-8','GBK','LATIN1','BIG5')) ;
			if( $fileType != 'GBK')
				$new_value = mb_convert_encoding($new_value,'GBK' , $fileType);
			$in_value_arrs=$in_value_arrs."insert into $table values(".$new_value.");";
	}
	// echo $in_value_arrs;
	save($in_value_arrs,$conn);
}
// .$value["couTime1"]."','".$value["couTime2"]."','".$value["couTime3"]."','"
else if($table=="courseRelease") //存到开课表
{
	foreach ($array as $key => $value) {
		$in_value_arr=$in_value_arr."'".$value["semester"]."','".$value["couNo"]."','".$value["teaNo"]."','".$value["couAddr"]."','".$value["couAns"]."',".$value["couCnt"].",0";
		$in_value_arrs=$in_value_arrs."insert into $table values(".$in_value_arr.");";
		$in_value_arr="";
	}
	$fileType = mb_detect_encoding($in_value_arrs, array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'GBK')
			$in_value_arrs = mb_convert_encoding($in_value_arrs,'GBK' , $fileType);
		// echo $in_value_arrs;
	save($in_value_arrs,$conn);
	$in_value_arrs="";
	foreach ($array as $key => $value) {
		for($x=intval($value["couTime2"]);$x<=intval($value["couTime3"]);$x++){
			$in_value_arr=$in_value_arr."'".$value["semester"]."','".$value["couNo"]."','".$value["teaNo"]."','".$value["couTime1"]."',".$x;
			$in_value_arrs=$in_value_arrs."insert into courseTime(semester,couNo,teaNo,couDay,couTime) values(".$in_value_arr.");";
			$in_value_arr="";
		}
	}
	$fileType = mb_detect_encoding($in_value_arrs, array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'GBK')
			$in_value_arrs = mb_convert_encoding($in_value_arrs,'GBK' , $fileType);
	// echo $in_value_arrs;
	save($in_value_arrs,$conn);
}
// else if($table=='testMessage')   //存到考试信息表
// {
// 	foreach ($array as $key => $value) {
// 		$in_value_arr=$in_value_arr."'".$value["semester"]."','".$value["couNo"]."','".$value["teaNo"]."','".$value["testTimeBegin"]."','".$value["testTimeEnd"]."','".$value["testAdd"]."','".$value["ps"]."'";
// 		$in_value_arrs=$in_value_arrs."insert into $table values(".$in_value_arr.");";
// 		$in_value_arr="";
// 	}
// 	echo "<script>console.log(".$in_value_arrs.");</script>";
// 	// $fileType = mb_detect_encoding($in_value_arr, array('UTF-8','GBK','LATIN1','BIG5')) ;
// 	// 	if( $fileType != 'GBK')
// 	// 		$in_value_arr = mb_convert_encoding($in_value_arr,'GBK' , $fileType);
// 	// save($in_value_arrs,$conn);

// }



	else if($table=='courseSelecequit')//存到教师信息表
{	
	foreach ($array as $key => $value) {
		
		
		$in_value_arr="delete from courseSelect where couNo='{$value[1]}'AND stuNo='{$user}'AND semester='2018-2019春季' AND teaNo='{$value[2]}' ";
		
		$fileType = mb_detect_encoding($in_value_arr, array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'GBK')
			$in_value_arr = mb_convert_encoding($in_value_arr,'GBK' , $fileType);
	$n_value_arr = sqlsrv_prepare($conn, $in_value_arr, array());
	$stmt=sqlsrv_prepare($conn,$in_value_arr,array());
	sqlsrv_execute($stmt);
		

	}}

else if($table=='courseSelect')//存到教师信息表
{	
	foreach ($array as $key => $value) {

		$in_value_arr=$in_value_arr."'".$value[1]."','".$user."','"."2018-2019春季"."','".$value[2]."'";
		
		$in_value_arrs=$in_value_arrs."insert into courseSelect values(".$in_value_arr.");";
		
		$in_value_arr="";

}
// echo $in
		$fileType = mb_detect_encoding($in_value_arrs, array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'GBK')
			$in_value_arrs = mb_convert_encoding($in_value_arrs,'GBK' , $fileType);
	save($in_value_arrs,$conn);
		// echo $in_value_arrs;
		// echo JSON_encode($in_value_arrs,JSON_UNESCAPED_UNICODE);

	}

	else if($table=='courseSelecequit')//存到教师信息表
{	
	foreach ($array as $key => $value) {
		
		$in_value_arrs="delete from courseSelect where couNo='{$value[1]} AND stuNo='{$user}' AND semester='2018-2019春季' AND teaNo='{$value[2]}'";

		$fileType = mb_detect_encoding($in_value_arrs, array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'GBK')
			$in_value_arrs = mb_convert_encoding($in_value_arrs,'GBK' , $fileType);
		$query = sqlsrv_query($conn,$in_value_arrs , array());}
		

	}
	// save($in_value_arrs,$conn);
else if($table=="offsetCredits")
{

		$date=date("Y-m-d H:i:s");
		
		$in_value_arr="insert into offsetCredits values('{$user}','{$date}','{$value}',4,'待审核');";
		
	

		$fileType = mb_detect_encoding($in_value_arr, array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'GBK')
			$in_value_arr = mb_convert_encoding($in_value_arr,'GBK' , $fileType);
	save($in_value_arr,$conn);
}

else if($table=="stutestDelay")
{		
		
	
		$in_value_arr="insert into testDelay values('{$user}','{$value}','待审核');";
		// echo $in_value_arr;
		$fileType = mb_detect_encoding($in_value_arr, array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'GBK')
			$in_value_arr = mb_convert_encoding($in_value_arr,'GBK' , $fileType);
	save($in_value_arr,$conn);
}

else if($table=='testMessage')  //存到考试信息表
{
	foreach($array as $key=>$info){
		foreach($info as $k=>$v){
			if(is_int($v))
				$in_value_arr=$in_value_arr.$v.",";
			else
				$in_value_arr=$in_value_arr."'".$v."',";
		}
			$new_value=substr($in_value_arr,0,strlen($in_value_arr)-1);
			$in_value_arr="";
			
			$in_value_arrs=$in_value_arrs."insert into $table values(".$new_value.");";		
	}
	$fileType = mb_detect_encoding($in_value_arrs, array('UTF-8','GBK','LATIN1','BIG5')) ;
			if( $fileType != 'GBK')
				$in_value_arrs = mb_convert_encoding($in_value_arrs,'GBK' , $fileType);
	// echo $in_value_arrs;
	save($in_value_arrs,$conn);  
}
echo "提交成功!";
sqlsrv_close($conn);

function save($info,$conn)      //实际的存储操作
{
	$result=sqlsrv_query($conn,$info);
	if(empty($result))
	{
		echo "提交失败!";
		die( print_r( sqlsrv_errors(), true));
		return ;
	}
	sqlsrv_free_stmt( $result);
}
?>