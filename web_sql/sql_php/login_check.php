<?php
$username=$_POST["username"];
$password1=$_POST["password1"];
$checkbox=$_POST["checkbox"];
header("Access-Control-Allow-Origin:*");
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"school");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if($checkbox=="管理")
{
	$query="select pass,pow from Account where acc='$username'";
}
else if($checkbox=="学生")
{
	$query="select pass,pow,stuName from Account,studentMessage where acc='$username' and stuNo='$username'";
}
else if($checkbox=="教师")
{
	$query="select pass,pow,teaName from Account,teacherMessage where acc='$username' and teaNo='$username'";
}
$result=sqlsrv_query($conn,$query,array());
	if(sqlsrv_has_rows($result)){
		$row=sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
		$fileType = mb_detect_encoding($row['pow'], array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'UTF-8')
			$row = mb_convert_encoding($row,'UTF-8' , $fileType);
		if($row['pass']==$password1 && $row['pow']==$checkbox){
			if($checkbox=="管理")
				echo "<script>window.location.href='http://localhost:8090/sys-class.html?username=$username';</script>";
			else if($checkbox=="学生")
			{
				$name=$row['stuName'];
				// $href='http://localhost:8090/class-table.html?username=$username&name=$name';
				echo "<script>window.location.href='http://localhost:8090/class-table.html?username=$username&name=$name';</script>";
			}
			else if($checkbox=="教师")
			{
				$name=$row['teaName'];
				// $href='';
				echo "<script>window.location.href='http://localhost:8090/teacher-master.html?username=$username&name=$name';</script>";
			}
			
		}
		else 
			{echo "<script>alert(\"用户名或密码或权限错误\");history.back(-1);</script>";}
	}
	else{
		echo "<script>alert(\"用户名不存在\");history.back(-1);</script>";
	}
?>