<?php 
/*
	template name: 下載頁面
*/
$pid = $_GET['pid'];
$values = get_post_custom_values('xiazai',$pid);
if(empty($values)){
	Header('Location:/');
}else{
	foreach($values as $value){
		$theCode = $value;
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>文件下載：<?php echo get_the_title($pid); ?> - 君子不器</title>
<style type="text/css">
.xzym{width:1201px;margin:0 auto;min-height:300px;}	

.xzymdd {
display: block;
font: normal 32px/60px 'MicroSoft Yahei';
text-align: center;
width: 600px;
height: 60px;
text-decoration: none;
background: #fff;
border: 1px solid #1161ba;
color: #1161ba;
margin: 20px auto 10px auto;
border-radius: 5px;
}


.xzymdd:hover {
font-size: 32px;
background: #f90;
color: #fff;
border: 1px solid #f90;
}


.down-info {
line-height: 2;
padding: 10px;
margin-bottom: 20px;
background: #fff;
width: 600px;
margin: 0 auto;
}


.down-info li {
list-style: decimal;
margin-left: 35px;
line-height: 28px;
font-size: 12px;
}


.down-info h3 {
font-size: 18px;
margin: 5px 0 10px 5px;
font-family: 'Trebuchet MS',微軟雅黑,"Microsoft Yahei",Tahoma,Helvetica,Arial,"mingliu",sans-serif;
font-weight: normal;
border-left: 5px solid #11692E;
padding: 0px 0px 0px 10px;
color: #11692E;
background: #F3F2F2;
}

.xzljsb {
background: #fff;
width: 600px;
margin: 0 auto;
}
.xzljsb a{float: left;}

.clear {
clear: both;
padding: 0!important;
margin: 0!important;
}
@charset "utf-8";
body,h1,h2,h3,h4,p,ul,li,ol,dl,dt,dd,input,textarea,figure,form{margin:0;padding:0}
body,input,textarea{font-size:12px;font-family:microsoft yahei}
body{text-align:center;color:#33383D;background:#f1f1f1}
ul,ol{list-style:none}
img{border:0}
button,input {line-height:normal;*overflow:visible}
input,textarea{outline:none}
a{color:#3B8DD1;text-decoration:none}
a:hover{color:#8CAC52}
.demo-header{position:relative;height:22px;background-color:#33363B;line-height:22px;padding:2px 10px;text-align: left;}
.demo-name{color: #ccc;}
.demo-title{display: none;}
.demo-container{clear: both;padding:40px 10px 20px;text-align:left;margin:0 auto;line-height: 18px;}
.demo h2{font-size: 15px;padding-bottom: 6px;margin-bottom: 20px;border-bottom: solid 1px #ddd;}
</style>
</head>
<body>

<h1 class="demo-title">下載頁面 - <?php echo get_the_title($pid); ?> - 君子不器</h1>
<div class="demo-header">
	<a class="demo-name" href="<?php echo get_permalink($pid); ?>">&laquo; <?php echo get_the_title($pid); ?></a>
</div>
<div class="demo-container demo">
<div class="xzym">


<div class="xzljsb">
<a href="http://junzibuqi.com/wordpressdaqianduandux12.html" rel="nofollow" target="_blank"><img src="http://junzibuqi.com/wp-content/uploads/2015/08/2015082221112536.png" width="300" height="250" alt="君子不器推薦wordpress主題"></a>
<a href="http://junzibuqi.com/pinpubuliuzhuti.html" rel="nofollow" target="_blank"><img src="http://junzibuqi.com/wp-content/uploads/2015/07/201507261420243-280x205.gif" width="300" height="250" alt="君子不器推薦wordpress主題"></a>
<div class="clear"></div>
</div>


<div class="xzymaaaa">
<a class="xzymdd" href='<?php echo $theCode; ?>' rel="nofollow" target="_blank">下載地址</a>
</div>

<ul class="down-info">
<h3>君子不器分享的WordPress主題使用說明</h3>
<li>君子不器(Junzibuqi.Com)提供主題中，一般都包含了說明文檔等文件，所以請將主題文件夾單獨解壓出來，然後以ZIP格式壓縮文件並通過wordpress後台主題安裝上傳至服務器，如果wordpress後台無法上傳，可以嘗試使用FTP上傳至主題目錄：/wp-content/themes/</li>
<li>WordPress後台上傳出現缺少style.css樣式表，則很可能是由於您直接將下載的壓縮包上傳，未按說明提示1操作</li>
<li>大部分主題，壓縮包內包含了主題的詳細使用說明，使用前請認真閱讀（英語不好的，可以借助谷歌翻譯等翻譯工具）</li>
<li>如果你覺得君子不器分享的資源還不錯的話，歡迎加入君子不器QQ群：479928584</li>
</ul>
</div>
</div>
</body>
</html>