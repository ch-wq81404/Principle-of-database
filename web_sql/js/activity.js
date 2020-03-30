    //使用live绑定数据，因为checkAll还没有加载好
    $("#checkAll").die().live("click", function () {
        if (this.checked) {
            $(this).attr('checked', 'checked')
            $("input[name='ckb-jobid']").each(function () {
                this.checked = true;
				
            });

           
        } else {
            $(this).removeAttr('checked')
            $("input[name='ckb-jobid']").each(function () {
                this.checked = false;
               
            });
        }
    });

    $("input[name='ckb-jobid']").die().live("click", function () {
        if ($(this).is(":checked") == false) {
            $("#checkAll").prop("checked", false);
        } else {
            var flag = true;
            $("#checkAll").prop("checked", true);
//			console.log(this);
            $("input[name='ckb-jobid']").each(function () {
                if (this.checked == false) {
                    $("#checkAll").prop("checked", false);
                    flag = false;
                    return;
                }
            });
        }


    });


//获取活动
//xmlhttp=GetXmlHttpObject();
//
//if(xmlhttp!=null)
//{
//  xmlhttp.onreadystatechange=function()
//  {
//    if(xmlhttp.readyState==4&&xmlhttp.status==200)
//    { 
//      var data = xmlhttp.responseText;
//      var str=data.split('}');
//	 var no=1;
//	var table = $('#tb').DataTable();
//      for(var i=0;i<str.length;i++)
//     {  
//      str[i]+='}';
//      
//      s=JSON.parse(str[i]);
//
//table.rows.add( [ {
//        "title":  s.title,
//        "date":   s.date,
//        "addr":    s.addr,
//		"id":   	 "082500"+no,
//		"person":	"某某",
//		"state":	"招募中",
//		"detail":"查看详情",
//	"no":no,
//    } ] )
//    .draw();
//		 no=no+1;
//
//
//    }
//
//    }
//  }
//}
//var url="http://localhost:8080/php/getact.php";
//xmlhttp.open("GET",url,true);
//xmlhttp.send(null);
//
//
//
//function GetXmlHttpObject()
//{
//var xmlhttp=null;
//try
// {
// // Firefox, Opera 8.0+, Safari
// xmlhttp=new XMLHttpRequest();
// }
//catch (e)
// {
// // Internet Explorer
// try
//  {
//  xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
//  }
// catch (e)
//  {
//  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//  }
// }
//return xmlhttp;
//}


//function submit()
////Button选课事件
//{var tb = document.getElementById("tb-selected");
// tb.innerHTML = "";
//	
//        var Tabobj = $("#tb");
//        var Check = $("table input[type=checkbox]:checked");//在table中找input下类型为checkbox属性为选中状态的数据
//		var SelectedDatas=[];
//		
//
//        Check.each(function () {//遍历
//			var data = {};
//			data["title"] = $(this).parent().parent().find("td:eq(2)").text();
//			data["id"] = $(this).parent().parent().find("td:eq(3)").text();
//			data["date"] = $(this).parent().parent().find("td:eq(5)").text();
//			data["addr"] = $(this).parent().parent().find("td:eq(6)").text();
//			SelectedDatas.push(data);
//        })
//	
//	
//        var count=0;
//	for(var i=0;i<SelectedDatas.length;i++)
//		{ 
//		
//		var s=SelectedDatas[i];
//			console.log(s);
//		if(s.id!="")
//		{
//		var row = tb.insertRow(count);
//        var c1 = row.insertCell(0);
//        c1.innerHTML = count+1;
//        var c2 = row.insertCell(1);
//        c2.innerHTML = s.title;
//        var c3 = row.insertCell(2);
//        c3.innerHTML = s.id
//        var c4 = row.insertCell(3);
//        c4.innerHTML = "某某";
//        var c5 = row.insertCell(4);
//        c5.innerHTML = s.date;
//        var c6 = row.insertCell(5);
//        c6.innerHTML = s.addr;
//			count++;
//		}
//		}
//	
//	
//};


