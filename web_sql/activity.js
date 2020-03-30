
var xmlHttp;
xmlhttp=GetXmlHttpObject();

if(xmlhttp!=null)
{
  xmlhttp.onreadystatechange=function()
  {
    if(xmlhttp.readyState==4&&xmlhttp.status==200)
    { 
      var data = xmlhttp.responseText;
      var str=data.split('}');
      for(var i=0;i<str.length;i++)
     {  
      str[i]+='}';
      
      s=JSON.parse(str[i]);
       tb = document.getElementByClassName("tbody")
        var row = tb.insertRow(i+1);
        var c1 = row.insertCell(0);
        c1.innerHTML = i+1;
        var c2 = row.insertCell(1);
        c2.innerHTML = s.title;
        var c3 = row.insertCell(2);
        c3.innerHTML = "083500"+i+1;
        var c4 = row.insertCell(3);
        c4.innerHTML = "某某";
        var c5 = row.insertCell(4);
        c5.innerHTML = s.date;
        var c6 = row.insertCell(5);
        c6.innerHTML = s.addr;
        var c7 = row.insertCell(6);
        c7.innerHTML = "招募中";
        var c8 = row.insertCell(7);
        c8.innerHTML = "<a href='act-details.html'>查看详情</a>";


    }

    }
  }
}
var url="http://localhost:8080/php/getact.php";
xmlhttp.open("GET",url,true);
xmlhttp.send(null);



function GetXmlHttpObject()
{
var xmlhttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlhttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlhttp;
}

