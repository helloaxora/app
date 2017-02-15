<?php
include_once 'num2str.php';
$ndc_y = $_GET['yandex'] - $_GET['yandex']/1.3;
$ndc_g = $_GET['google'] - $_GET['google']/1.3;
?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
	<meta charset="utf-8" lang="ru"/>
	<title>Счет-фактура</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/login/css/style.css" rel="stylesheet" type="text/css"/>
	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/favicon.ico" type="image/x-icon"/>
</head>

<body>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/metrika.js"></script>
<noscript><div><img src="https://mc.yandex.ru/watch/42443694" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<style>
	.no-print {
		width: 630px;
		position: fixed;
		margin-left: 945px;
		margin-top: -123px;
	}
	
	a img {
		border: 0 none;
	}
	
	.image-link {
		position: relative;
		Text-decoration: none;
		outline: none;
		border: 0 none transparent;
	}
	
	.note {
		float: left;
		clear: left;
	}
	
	.note span {
		background-color: yellow;
	}
	
	@page {
		size: A4;
		margin: 0;
	}
	
	@media print {
		body {
			margin: 0;
			background: none;
			-webkit-print-color-adjust: exact;
		}
		
		.no-print {
			display: none;
		}
	}
</style>

	<div class="wrapper" style="padding: 25px 0">
		
		<div class="invoice">
			<div class="invoice__header">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/images/invoice-logo.png" alt=""
				     class="invoice__logo">
				
				<div class="invoice__header-col invoice__header-col_1">Исполнитель:<br> Частное унитарное
					предприятие<br> по
					оказанию услуг «Аксора»<br> (ЧП «Аксора») УНП 192491124
				</div>
				
				<div class="invoice__header-col invoice__header-col_2">Юр. адрес: 220005, г. Минск, <br> ул. В.Хоружей
					д. 1А
					пом. 644 <br> р/с 3012109141009 в ЗАО «ИдеяБанк»<br> г. Минск З.Бядули 11 МФО: 153001755
				</div>
				
				<div class="invoice__header-col invoice__header-col_3">Тел.:&nbsp;+375&nbsp;44&nbsp;514-95-57<br>
					E-mail:&nbsp;info@axora.by
				</div>
				<div class="no-print" id="no-print">
					<a href="javascript:void(0);" onclick="print()" class="image-link">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/images/printer.png" width="10%"
						     height="10%">
					</a>
					<br>
					<a href="javascript:void(0);" onclick="print()"> Распечатать </a>
					<br>
					<br>
					<br>
					<div class="note"><span>Деньги зачислятся<br>на рекламный счет<br>
		в течении двух дней<br>после оплаты</span></div>
				</div>
			</div>
			
			<h1 class="invoice__title">Счет-фактура № <?php echo $_GET['item'] ?> от <?php echo $_GET['date'] ?>
				г.</h1>
			
			<div class="invoice__subtitle">На основании публичного договора № 1-06/2016 опубликованного 27 июня
				2016г.<br>
				<a href="<?php echo $this->createUrl( 'client/redirectDogovor' ) ?>">axora.by/assets/dogovor.pdf</a>
			</div>
			
			<table class="invoice__table">
				<thead>
				<tr>
					<th>Услуга</th>
					<th>Сумма, руб</th>
					<th>20% НДС ,руб.</th>
					<th>Сумма c НДС, руб.</th>
				</tr>
				</thead>
				<tbody>
				<?php if ( $_GET['yandex'] != '0' )
				{
					?>
					<tr>
						<td>Размещение рекламно-информационных материалов в сети Интернет (Яндекс)</td>
						<td><?php echo number_format( $_GET['yandex'] - $ndc_y, 2, ',', ' ' ) ?></td>
						<td><?php echo number_format( $ndc_y, 2, ',', ' ' ); ?></td>
						<td><?php echo number_format( $_GET['yandex'], 2, ',', ' ' ) ?></td>
					</tr>
					<?php
				}
				if ( $_GET['google'] != '0' )
				{
					?>
					<tr>
						<td>Размещение рекламно-информационных материалов в сети Интернет (Google)</td>
						<td><?php echo number_format( $_GET['google'] - $ndc_g, 2, ',', ' ' ) ?></td>
						<td><?php echo number_format( $ndc_g, 2, ',', ' ' ); ?></td>
						<td><?php echo number_format( $_GET['google'], 2, ',', ' ' ) ?></td>
					</tr>
					<?php
				}
				?>
				
				</tbody>
			</table>
			
			<div class="invoice__table-total">Итого к оплате
				<strong><?php echo number_format( $_GET['google'] + $_GET['yandex'], 2, ',', ' ' ); ?></strong></div>
			
			<div class="invoice__total">Сумма НДС <?php
				echo number_format( $ndc_g + $ndc_y, 2, ',', ' ' )
				?>(<?php
				echo num2str( $ndc_g + $ndc_y );
				?>)<br> Итого к оплате
				с НДС <?php echo number_format( $_GET['google'] + $_GET['yandex'], 2, ',', ' ' ); ?> (<?php
				echo num2str( $_GET['google'] + $_GET['yandex'] );
				?>)
			</div>
			
			<div class="invoice__signature">
				<div class="invoice__signature-text">
					<div class="invoice__signature-text-title">Директор</div>
					<div class="invoice__signature-text-description">В.В. Гришман</div>
				</div>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/images/invoice-stamp.png" alt=""
				     class="invoice__signature-stamp">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/images/invoice-signature.png" alt=""
				     class="invoice__signature-signature">
			</div>
		</div>
	</div>
</body>
<!--<script type="text/javascript">-->
<!--	function hscrollbar() {-->
<!--		/* First, we need the horizontal scroll position of the viewer's display,-->
<!--		 but there are different ways to call it in JS depending on browser.-->
<!--		 I'm using the if/else shorthand notation to detect if a call is legit:-->
<!--		 somevar = (statement) ? statement_true_value : statement_false_value */-->
<!--		var left =-->
<!--			/* window.pageXOffset should work for most recent browsers: */-->
<!--			window.pageXOffset ? window.pageXOffset :-->
<!--				/* If it DOESN'T, let's try this: */-->
<!--				document.documentElement.scrollLeft ? document.documentElement.scrollLeft :-->
<!--					/* And if THAT didn't work: */-->
<!--					document.body.scrollLeft;-->
<!--		-->
<!--		/* Now that we have the horizontal scroll position, set #footpanel's left-->
<!--		 position to NEGATIVE the value, so it APPEARS to follow the scroll: */-->
<!--		document.getElementById('no-print').style.left = -left;-->
<!--	}-->
<!--	window.onscroll = hscrollbar; /* Call the function when the user scrolls */-->
<!--	window.onresize = hscrollbar; /* Call the function when the window resizes */-->
<!--</script>-->
<script>
	//	window.onresize = function () {
	//		$("#no-print").css("", "fixed");
	//	}
</script>
</html>