<?php
error_reporting(0);
header("Access-Control-Allow-Origin:*");
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"school");
$conn = sqlsrv_connect($serverName, $connectionInfo);

$couNo=$_GET["couNo"];
$semester=$_GET["semester"];
$query="select distinct(teaName),avg(totalPer) average from teacherMessage,courseGrade where semester='".$semester."' and couNo='".$couNo."' and teacherMessage.teaNo=courseGrade.teaNo group by teaName; 
		select * from gradeInfo(0,60,'".$couNo."','".$semester."');
		select * from gradeInfo(60,70,'".$couNo."','".$semester."');
		select * from gradeInfo(70,80,'".$couNo."','".$semester."');
		select * from gradeInfo(80,90,'".$couNo."','".$semester."');
		select * from gradeInfo(90,100,'".$couNo."','".$semester."');";
$fileType = mb_detect_encoding($query, array('UTF-8','GBK','LATIN1','BIG5')) ;
	if( $fileType != 'GBK')
		$query = mb_convert_encoding($query,'GBK' , $fileType);
$result=sqlsrv_query($conn,$query);
$xx=array(); //教师名称 形如['aaa','bbb','ccc','ddd','eee']
$yy=array(); //形如 ：{（name: '0-60',）data: [49.9, 71.5, 106.4, 129.2, 144.0]},
        		//  {（name: '60-70',）data: [83.6, 78.8, 98.5, 93.4, 106.0]},
				// ...
$zz=array();//每个教师的学生均分
if(!empty($result))
{
	while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
		$fileType = mb_detect_encoding($row['teaName'], array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'UTF-8')
			$row = mb_convert_encoding($row,'UTF-8' , $fileType);
		array_push($xx,$row['teaName']);
		array_push($zz,$row['average']);
	}
	$flag=false;
	$num=[0,0,0];
	while($next_result=sqlsrv_next_result($result)){
		while($row=sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
			$flag=true;
			$fileType = mb_detect_encoding($row['teaName'], array('UTF-8','GBK','LATIN1','BIG5')) ;
			if( $fileType != 'UTF-8')
				$row = mb_convert_encoding($row,'UTF-8' , $fileType);
			for($x=0;$x<5;$x++) {  //记录每个data的内容
				if($row['teaName']==$xx[$x]){
					// if($row['num'])
					$num[$x]=intval($row['num']);
				}
			}
		}
		if($flag){
			array_push($yy,$num);//将每个data push进yy，最终yy会有五个data
			$num=[0,0,0];
			$flag=false;
		}
		else
			array_push($yy,$num);
	}
	
	$data=array();
	array_push($data,$xx);
	array_push($data,$yy);
	array_push($data,$zz);
	echo json_encode($data);
}
else
{
	echo "该课程无成绩信息";
}
sqlsrv_free_stmt($result);
?>