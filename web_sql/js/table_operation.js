// JavaScript Document
/** 
 * 获取表格行数
 * @param  Int id 表格id
 * @return Int
 */
function getTableRowsLength(id){
    var mytable = document.getElementById(id);
    return mytable.rows.length;
}
	/** 
 * 获取表格某一行列数
 * @param  Int id    表格id
 * @param  Int index 行数
 * @return Int
 */
function getTableRowCellsLength(id, index){
    var mytable = document.getElementById(id);
    if(index<mytable.rows.length){
        return mytable.rows[index].cells.length;
    }else{
        return 0;
    }
}
	/** 
 * 遍历表格内容返回数组
 * @param  Int   id 表格id
 * @return Array
 */
function getTableContent(id){
    var mytable = document.getElementById(id);
    var data = [];
    for(var i=0,rows=mytable.rows.length-1; i<rows; i++){
        for(var j=0,cells=mytable.rows[i].cells.length-1; j<cells; j++){
            if(!data[i]){
                data[i] = new Array();
            }
            data[i][j] = mytable.rows[i+1].cells[j+1].innerHTML;
        }
    }
    return data;
}
/** 
 * 返回指定行数内容的数组
 * @param  Int   id 表格id  array change 记录行数的数组
 * @return Array
 */
function getTableRowsContent(id,change){
	var mytable = document.getElementById(id);
    var data = [];
	for(var i=0;i<change.length;i++){
		for(var j=0;j<mytable.rows[change[i]].cells.length-1;j++){
			if(!data[i])
				data[i]=new Array();
			data[i][j]=mytable.rows[change[i]].cells[j+1].innerHTML;
		}
	}
	return data;
}
function DeleteCheckedRows(id){
	var checkall=$('#checkAll').attr("checked");
	if(checkall)
	{
		$('#tbody').html("");
		console.log("清空表格");
	}
								
	else{
		var checkArry = document.getElementsByName("ckb-jobid");
		var mytable=document.getElementById(id);
		for (var i = 0; i < checkArry.length; i++) { 
			if(checkArry[i].checked == true){
			//选中的操作
				mytable.deleteRow(i+1);
			}
		}
	}
}
function DeleteAll(){
	$('#tbody').html("");
}