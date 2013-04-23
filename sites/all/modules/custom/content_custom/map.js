
window.onload=pageInit;


var mapObjSearch;
function pageInit() { //地图初始化过程
  var mapoption = new MMapOptions();
  mapoption.zoom=10;
  mapoption.center=new MLngLat(116.4,39.9);
  mapoption.toolbar=ROUND; //设置工具条
  //mapoption.toolbarPos=new MPoint(20,20);
  //mapoption.overviewMap=SHOW; //设置鹰眼
  mapObjSearch = new MMap("icenter",mapoption);
}
var startX = null;
var startY = null;
var endX = null;
var endY = null;
function  getStartXY() {    //以起点为关键字进行查询
  var citycode = document.getElementById("routSearchByStartXYAndEndXY_citycode").value;
  var startName = document.getElementById("routSearchByStartXYAndEndXY_startName").value;
  var mls =new MLocalSearch();
  var mlsp= new MLocalSearchOptions();
   mlsp.recordsPerPage=1;
   mls.setCallbackFunction(myfunc);
   mls.poiSearchByKeywords(startName,citycode,mlsp);
}
var markerOptions = new MMarkerOptions();
var pointsearch;
function myfunc(data){//关键字查询的回调函数
  if(data.error_message != undefined ){
   alert(data.error_message);
  }else{
	    	for (var i = 0; i <1; i++) {
			  startX = data.poilist[i].x;
		      startY = data.poilist[i].y;
		  }
   getEndXY();
   }
}
function  getEndXY() {//以终点为关键字进行查询
  var citycode = document.getElementById("routSearchByStartXYAndEndXY_citycode").value;
  var endName = document.getElementById("routSearchByStartXYAndEndXY_endName").value;
  var mls =new MLocalSearch();
  var mlsp= new MLocalSearchOptions();
   mlsp.recordsPerPage=1;
   mls.setCallbackFunction(myfunc1);
   mls.poiSearchByKeywords(endName,citycode,mlsp);
}
var pointsearch1;
function myfunc1(data){//终点查询的回调函数
  if(data.error_message != undefined ){
   alert(data.error_message);
   }else{
	for (var i = 0; i < data.poilist.length; i++) {
		    endX = data.poilist[i].x;
			 endY = data.poilist[i].y;
     }
  }
  routSearchByStartXYAndEndXY();
}
function searchShow_busRoute() { //用于显示查询层
  document.getElementById("searchresult").style.display='none';
  mapObjSearch.removeAllOverlays();
  var temp="城市编号：  <input type='hidden' value='010' style='width:100px;' id='routSearchByStartXYAndEndXY_citycode' /><br>";
  temp+="起点名称：  <input type='text' value='西直门'  style='width:100px;' id='routSearchByStartXYAndEndXY_startName' /><br>";
  temp+="终点名称：  <input type='text' value='大恒科技大厦'  style='width:100px;' id='routSearchByStartXYAndEndXY_endName' /><br>";
  temp+="<input type='button' id='poiSearchByCenterXY_searchbutton' value='查询' onclick='getStartXY()' /><br>"
  document.getElementById("searchbus").innerHTML = temp;
}
function routSearchByStartXYAndEndXY() {//查询方法开始
  document.getElementById("searchbus").style.display='block';
  document.getElementById("searchresult").style.display='block';
  var citycode = document.getElementById("routSearchByStartXYAndEndXY_citycode").value;
  var mrs =new MRoutSearch();
  var rsoption = new MRoutSearchOptions();
   mrs.setCallbackFunction(myfunc3);
   mrs.routSearchByStartXYAndEndXY("bus",new MLngLat(startX,startY),new MLngLat(endX,endY),citycode,rsoption);
}
var xy_array = new Array();
var	xy_c_array = new Array();
function myfunc3(data)  {//用于查询的回调函数
  var temp = "约有<b>"+data.count +"<\/b>条位置信息　（搜索用时 <b>"+(data.searchtime/1000)+"<\/b> 秒）<br/>";
  var rs = data;
  for(var i=0;i<rs.busList.length;i++){
   var busxy = "";var busCHxy="";
   var bus_text="";
   var str_list = rs.busList[i].segmentList.length;//每次线路的换乘次数.
   for(var k=0;k<str_list;k++){
	var startName=rs.busList[i].segmentList[k].startName;
	var busName=rs.busList[i].segmentList[k].busName;
	var driverLength=rs.busList[i].segmentList[k].driverLength;
	var coordinateList=rs.busList[i].segmentList[k].coordinateList;
    var footLength=rs.busList[i].segmentList[k].footLength;
    var passDepotName=rs.busList[i].segmentList[k].passDepotName;
    var endName=rs.busList[i].segmentList[k].endName;
	var passDepotName=(data.busList[i].segmentList[k].passDepotName).split(" ");
	var passDepotNum = passDepotName.length+1;
	bus_text+="步行"+Getdistance(data.busList[i].segmentList[k].footLength)+"到"+data.busList[i].segmentList[k].startName+"，在车站乘坐"+rs.busList[i].segmentList[k].busName+"途经"+passDepotNum+"站，在"+data.busList[i].segmentList[k].endName+"下车。";
	
	var xy1=data.busList[i].segmentList[k].coordinateList;

	var changdu=xy1.length-1;
	
	if(xy1.charAt(changdu)==","){  //判断坐标串的最后一位是否有逗号，如果有将最后一位的逗号去掉
		xy1 = xy1.substring(0,changdu);
	  }
	 var xy = xy1.split(",");
	if(k==0){
		busCHxy +=  xy[xy.length-2]+","+xy[xy.length-1]+",";
	}else if ((k+1) != str_list){
		busCHxy += xy[0]+","+xy[1]+","+xy[xy.length-2]+","+xy[xy.length-1]+",";
	}else{
		busCHxy +=  xy[0]+","+xy[1]+",";
	}
	 
	busxy += xy1+",";
	if(str_list==1){busCHxy="";}//如果换乘次数为"1",没有换乘XY.此次线路可以直达.
    }
	xy_c_array[i]=busCHxy;
	xy_array[i]=busxy;
	temp += "<div id="+i+" onmouseover=\"openbusTipById1("+(i+1)+",this)\"  onclick=\"drawline2('"+i+"')\" onmouseout=\"onmouseout_busStyle("+i+",this)\">"+bus_text+"<br \/><br \/></div>";
   }
  document.getElementById("searchresult").innerHTML = temp;
  drawline2(0);
}
function Getdistance(le){
  if(le<=1000){
   var s = le;
   return s+"米";
  }else{
   var s = Math.round(le/1000);
   return "约"+s+"公里";
	}
}
function openbusTipById1(busline,thiss){
  thiss.style.background='#CFD6E8';
  mapObjSearch.openOverlayTip(busline);
}
function onmouseout_busStyle(busline,thiss){//当div mouseout时div变色方法方法
  thiss.style.background='';
}
function drawline2(n){//画驾车路线方法
  mapObjSearch.removeAllOverlays();
  //alert(xy_array[num]+"--"+xy_c_array[num]);
  var allover = new Array();
  var busxy = xy_array[n].split(",");var busxy_n = busxy.length-1;
  var busCHxy = xy_c_array[n].split(",");var busCHxy_n = busCHxy.length-1;
  var arr = new Array();
  for(var e=0;e<busxy_n;e=e+2){
   arr.push(new MLngLat(busxy[e],busxy[e+1]));
  }
  var lineopt = new MLineOptions();
   lineopt.lineStyle.thickness=3;
   lineopt.lineStyle.color=0x005cb5;
   lineopt.lineStyle.alpha=0.8;
  var line = new MPolyline(arr,lineopt);
   line.id="buschange";
   allover.push(line);
  /*换乘点*/
  var changemarkerOption = new MMarkerOptions();
   changemarkerOption.imageUrl ="http://code.mapabc.com/images/bx11.png";
   changemarkerOption.isDraggable=false;//是否可以拖动
   changemarkerOption.canShowTip=false;
  var temp = "";
  for(var r=0;r<busCHxy_n;r=r+2){
   var change = new MLngLat(busCHxy[r],busCHxy[r+1]);
   var changetmarker= new MMarker(change,changemarkerOption);
   changetmarker.id="chxy"+r;
   allover.push(changetmarker);
  }	
  /*1起点到线的起点 2线的终点到终点*/
  var arr1 = new Array();
   arr1.push(new MLngLat(startX,startY));
   arr1.push(new MLngLat(busxy[0],busxy[1]));
  var lineopt1 = new MLineOptions();
   lineopt1.lineStyle.thickness=3;
   lineopt1.lineStyle.color=0x6EB034;
   lineopt1.lineStyle.alpha=0.8;
  var line1 = new MPolyline(arr1,lineopt1);
  var arr2 = new Array();
   arr2.push(new MLngLat(endX,endY));
   arr2.push(new MLngLat(busxy[busxy_n-2],busxy[busxy_n-1]));
  var line2 = new MPolyline(arr2,lineopt1);
  allover.push(line1);
  allover.push(line2);
  /*添加步行点*/
  var stepmarkerOption = new MMarkerOptions();
   stepmarkerOption.imageUrl ="http://code.mapabc.com/images/bx.png";
   stepmarkerOption.isDraggable=false;//是否可以拖动
   stepmarkerOption.canShowTip=false;
  var step = new MLngLat(busxy[0],busxy[1]);
  var steptmarker= new MMarker(step,stepmarkerOption);
   steptmarker.id="bx1";
  allover.push(steptmarker);
  var step1 = new MLngLat(busxy[busxy_n-2],busxy[busxy_n-1]);
  var steptmarker1= new MMarker(step1,stepmarkerOption);
   steptmarker1.id="bx2";
  allover.push(steptmarker1);
  /*起点,终点*/
  var startmarkerOption = new MMarkerOptions();
   startmarkerOption.imageUrl ="http://code.mapabc.com/images/qd.png";
   startmarkerOption.picAgent=true;
   startmarkerOption.isDraggable=false;//是否可以拖动
  var tipOption = new MTipOptions();
  startmarkerOption.tipOption = tipOption;
  var start = new MLngLat(startX,startY);
  var startmarker= new MMarker(start,startmarkerOption);
   startmarker.id="startid";
  allover.push(startmarker);

  var endmarkerOption = new MMarkerOptions();
   endmarkerOption.imageUrl ="http://code.mapabc.com/images/zd.png";
   endmarkerOption.picAgent=true;
   endmarkerOption.isDraggable=false;//是否可以拖动
  var tipOption = new MTipOptions();
  endmarkerOption.tipOption = tipOption;
  var end = new MLngLat(endX,endY);
  var endmarker= new MMarker(end,endmarkerOption);
   endmarker.id="endid";
  allover.push(endmarker);
  mapObjSearch.addOverlays(allover,true);
  /*添加小车*/
  var lnglat = new MLngLat(busxy[0],busxy[1]);
  var busmarkerOption = new MMarkerOptions();
   busmarkerOption.imageUrl ="http://code.mapabc.com/images/car_03.png";
   busmarkerOption.imageAlign=5;
  var busmarker = new MMarker(lnglat,busmarkerOption);
  busmarker.id="bus1";
  mapObjSearch.addOverlay(busmarker);
  //使图标在第一段路线移动
  mapObjSearch.markerMoveAlong("bus1",arr);
  mapObjSearch.startMoveAlong('bus1',true);
}


 function searchShow_driveRoute()  {//用于显示查询层  
   document.getElementById("searchresult").style.display='none';  
   mapObjSearch.removeAllOverlays();  
   var temp="城市编号：  <input type='hidden' value='010' style='width:100px;' id='routSearchCarByStartXYAndEndXY_citycode' /><br>";  
   temp+="起点名称：  <input type='text' value='西直门'  style='width:100px;' id='routSearchCarByStartXYAndEndXY_startName' /><br>";  
   temp+="终点名称：  <input type='text' value='大恒科技大厦'  style='width:100px;' id='routSearchCarByStartXYAndEndXY_endName' /><br>";  
   temp+="<input type='button' id='poiSearchByCenterXY_searchbutton' value='查询' onclick='getcarStartXY()' /><br>"  
   document.getElementById("searchcar").innerHTML = temp;  
 }

 function  getcarStartXY() {//驾车线路查询代码开始  
   var citycode = document.getElementById("routSearchByStartXYAndEndXY_citycode").value;  
   var startName = document.getElementById("routSearchByStartXYAndEndXY_startName").value;  
   var mls =new MLocalSearch();  
  var mlsp= new MLocalSearchOptions();  
    mlsp.recordsPerPage=1;  
    mls.setCallbackFunction(mycarfunc);  
    mls.poiSearchByKeywords(startName,citycode,mlsp);  
 }

 function mycarfunc(data){
  if(data.error_message != undefined ){
   alert(data.error_message);
  }else{
    for (var i = 0; i < data.poilist.length; i++) {
	  startX = data.poilist[i].x;
	  startY = data.poilist[i].y;
	  markerOptions = new MMarkerOptions();
	  markerOptions.isDraggable=false;//是否可以拖动 	
	  markerOptions.canShowTip= true;
	  markerOptions.imageUrl ="http://code.mapabc.com/images/qd.png";
	  var ll=new MLngLat(startX,startY);
	  pointsearch =  new MMarker(ll,markerOptions);
	  pointsearch.id="start";
	  mapObjSearch.addOverlay(pointsearch,true);
	  }
	getcarEndXY();
  }		
}
function  getcarEndXY() {
  var citycode = document.getElementById("routSearchByStartXYAndEndXY_citycode").value;
  var endName = document.getElementById("routSearchByStartXYAndEndXY_endName").value;
  var mls =new MLocalSearch();
  var mlsp= new MLocalSearchOptions();
   mlsp.recordsPerPage=1;
   mls.setCallbackFunction(mycarfunc1);
   mls.poiSearchByKeywords(endName,citycode,mlsp);
}

var pointsearch1;
function mycarfunc1(data){
  if(data.error_message != undefined ){
   alert(data.error_message);
  }else{
	for (var i = 0; i < data.poilist.length; i++) {
     endX = data.poilist[i].x;
	 endY = data.poilist[i].y;
	 var ll=new MLngLat(endX,endY);
	 var  markerOptions1=new MMarkerOptions();
      markerOptions1.imageUrl ="http://code.mapabc.com/images/zd.png";
	 pointsearch1 =  new MMarker(ll,markerOptions1);
     pointsearch1.id="end";
	 mapObjSearch.addOverlay(pointsearch1,true);
	 }
  }	
  routSearchcarByStartXYAndEndXY();
}

function routSearchcarByStartXYAndEndXY() {   //查询方法开始
  document.getElementById("searchcar").style.display='block';
  document.getElementById("searchresult").style.display='block';
  var citycode = document.getElementById("routSearchByStartXYAndEndXY_citycode").value;
  var mrs =new MRoutSearch();
  var rsoption = new MRoutSearchOptions();
	mrs.setCallbackFunction(myfunc4); 
    mrs.routSearchByStartXYAndEndXY("drive",new MLngLat(startX,startY),new MLngLat(endX,endY),citycode,rsoption);
}

var route_segment=new Array(); 
function myfunc4(data) {//用于驾车查询的回调函数
  var temp = "约有<b>"+data.count +"<\/b>条位置信息　（搜索用时 <b>"+(data.searchtime/1000)+"<\/b> 秒）<br/>";
  var rs = data;
  var coors=rs.bounds;
  coors=coors.split(';');
  temp += "<div style=\"font-size: 13px; cursor:hand;cursor:pointer;\">";
  temp += "　 起点坐标："+coors[0] + ","+coors[1]+"<br \/>";
  temp += "　 终点坐标："+coors[2] + ","+coors[3]+"<br \/>　 行驶信息：";
  for(var i=0;i<rs.segmengList.length;i++){
   route_segment[i] =rs.segmengList[i].coor;
   var dtextInfo=rs.segmengList[i].textInfo;
   var daction=rs.segmengList[i].action;
   var droadName=rs.segmengList[i].roadName;
   var ddirection=rs.segmengList[i].direction;
   var ddriveTime=rs.segmengList[i].driveTime;
   var dgrade=rs.segmengList[i].grade;	
   var daccessorialInfo=rs.segmengList[i].accessorialInfo;
   var droadLength=rs.segmengList[i].roadLength;
   drawcarline2(rs.coors,startX,startY);
   temp += "<div id="+i+" onmouseover='openbusTipById1("+(i+1)+",this)' onclick='drawline1("+i+","+data.count+")'  onmouseout='onmouseout_busStyle("+i+",this)'>";
   temp += dtextInfo + "<br \/><br \/></div>";
    }
  document.getElementById("searchresult").innerHTML = temp;
}

function drawcarline2(coors,startX,startY){ //画驾车路线方法
  var arrline = new Array();
  var linexy =coors.split(',');
  var line_l = (linexy.length-1)/2;
  for(var i=0;i<line_l;i++){
   arrline.push(new MLngLat(linexy[2*i],linexy[2*i+1]));
  }
  var lineS=new MLineStyle();
   lineS.thickness = 3;
   lineS.color = 0xff230b;
   lineS.alpha = 1;
  var lineoption  = new MLineOptions();
   lineoption.lineStyle = lineS;
  var line = new MPolyline(arrline,lineoption);
  mapObjSearch.addOverlay(line,true);

  var lnglat = new MLngLat( startX, startY);
  var markerOption = new MMarkerOptions();
   markerOption.imageUrl ="http://code.mapabc.com/images/car_03.png";//
  var Mmarker1 = new MMarker(lnglat,markerOption);
   Mmarker1.id="bus1";
  mapObjSearch.addOverlay(Mmarker1);
  mapObjSearch.markerMoveAlong("bus1",arrline,3);
  mapObjSearch.startMoveAlong('bus1',true);
}