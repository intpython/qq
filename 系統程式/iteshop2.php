<?php
session_start();
$user=$_SESSION["user"];
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>ITE 會員系統</title>
	</head>
	<body background="http://s3.amazonaws.com/caself/products/photos/000/001/413/original/concretia_6.jpg?1509412229">
		<div class="header-l" data-user="0" style="text-align:center;">
			<B><font size="10"><?php echo $user ?>，您好！</font></B>

		<a href="/otp/two" style="font-size:44px;" style="text-align:center;">兩階段驗證</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp	; <a href="/otp/iteshop" style="font-size:44px;">登出</a> </div>
		<div  style="text-align:center">
		<img src="https://fakeimg.pl/1500x400/0000EB,150/255,000/?text=Welcome to ITE member system">
		</div>
		<!--<center><table width="1200" border="0">
			<tr style="text-align:center;">
			<td width="400"><h1>電通一乙</h3>	</td>
			<td width="400"><h1>電通二乙</h3></td>
			<td width="400"><h1>電通三乙</h3></td>
			</tr>
			<tr style="text-align:left;" valign="top">
				<td width="400"><LI>基本電學<LI>微積分(一)<LI>程式設計(一)<LI>英文(一)<LI>中國文學(一)<LI>數位系統</td>
				<td width="400"><LI>電子電路<LI>電子電路實驗<LI>工程數學<LI>資料結構<LI>線性代數<LI>資料結構</td>
				<td width="400"><LI>嵌入式系統<LI>廣域網路<LI>網路規劃<LI>進階微處理機<LI>JAVA程式設計<LI>WEB程式設計</td>
			</tr>
		</table></center>
		<center><table width="1200" border="0">
			<tr style="text-align:center;">
			<td width="400"><h1>電通一甲</h3>	</td>
			<td width="400"><h1>電通二甲</h3></td>
			<td width="400"><h1>電通三甲</h3></td>
			</tr>
			<tr style="text-align:left;" valign="top">
				<td width="400"><LI>基本電學<LI>微積分(一)<LI>程式設計(一)<LI>英文(一)<LI>中國文學(一)<LI>數位系統</td>
				<td width="400"><LI>電子電路<LI>電子電路實驗<LI>工程數學<LI>資料結構<LI>線性代數<LI>資料結構</td>
				<td width="400"><LI>嵌入式系統<LI>廣域網路<LI>網路規劃<LI>進階微處理機<LI>JAVA程式設計<LI>WEB程式設計</td>
			</tr>
		</table></center>
		<center><table width="1200" border="0">
			<tr style="text-align:center;">
			<td width="400"><h1>中文書</h3>	</td>
			<td width="400"><h1>楓之谷</h3></td>
			<td width="400"><h1>RO仙境傳說</h3></td>
			</tr>
			<tr style="text-align:left;" valign="top">
				<td width="400"><LI>文學小說<LI>商業理財<LI>藝術設計<LI>人文史地<LI>社會科學<LI>心理勵志</td>
				<td width="400"><LI>+10大劍<LI>+15鍋蓋<LI>雪吉拉寵物<LI>齊天大聖<LI>綠水靈珠<LI>菇菇寶貝傘</td>
				<td width="400"><LI>妖精耳朵<LI>詛咒之弓<LI>波利<LI>回憶寶石<LI>玩具士兵劍<LI>聖天使波利</td>
			</tr>
		</table></center>-->

	
	</body>
</html>
