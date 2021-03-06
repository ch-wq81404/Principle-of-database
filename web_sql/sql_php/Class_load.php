<?php
header("Access-Control-Allow-Origin:*");
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"school");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if($conn==false){
	die( print_r( sqlsrv_errors(), true));
	return ;
}
$query="select a.couName,a.couNo,a.couCredit,b.teaNo,b.teaName,c.couCnt,d.couDay,d.couTime from 
courseMessage as a ,teacherMessage as b, courseRelease as c,courseTime as d
where a.couNo= c.couNo And a.couNo=d.couNo AND c.couNo=d.couNo AND c.teaNo=b.teaNo";

$fileType = mb_detect_encoding($query, array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'GBK')
			$query= mb_convert_encoding($query,'GBK' , $fileType);
// echo $query;
$result=sqlsrv_query($conn,$query,array());
if(sqlsrv_has_rows($result)){
	while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC))
	{
		$fileType = mb_detect_encoding($row['couName'], array('UTF-8','GBK','LATIN1','BIG5')) ;//找原来数据的编码方式
		if( $fileType != 'UTF-8')//json只能识别utf-8编码，不是的话要换
		{
			$row = mb_convert_encoding($row,'UTF-8' , $fileType);//换成utf-8	
		}
		echo JSON_encode($row,JSON_UNESCAPED_UNICODE);
	}
}
else
	echo "无结果";
sqlsrv_free_stmt($result);

?>