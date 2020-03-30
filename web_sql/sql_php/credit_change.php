<?php
header("Access-Control-Allow-Origin:*");
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"school");
$conn = sqlsrv_connect($serverName, $connectionInfo);
$Changerows=$_GET["Changerows"];
$Changerows=json_decode($Changerows,true);
$flag=$_GET["flag"];
$in_value_arr=array();  //每条要修改的元组
$in_value_arrs="";  //所有的修改语句
if($flag){
	foreach ($Changerows as $key => $value) {
		$new_value="update offsetCredits set statu='".$flag."' where stuNo='".$value["0"]."' and appTime='".$value["1"]."' and appCouNo='".$value["2"]."';";
		$in_value_arrs=$in_value_arrs.$new_value;
	}
	$fileType = mb_detect_encoding($in_value_arrs, array('UTF-8','GBK','LATIN1','BIG5')) ;
			if( $fileType != 'GBK')
				$in_value_arrs = mb_convert_encoding($in_value_arrs,'GBK' , $fileType);
	$result=sqlsrv_query($conn,$in_value_arrs);
	if(!empty($result))
	{
		echo "提交成功!";
	}
	else{
		die( print_r( sqlsrv_errors(), true));
	}
	sqlsrv_free_stmt( $result);
	
}
else{
	
}
// sqlsrv_free_stmt($result);




?>