<!DOCTYPE HTML>
<html lang="ru">
<head>
	<meta charset="utf-8"/>
	<title>Axora</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/normalize.css/normalize.css" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery-ui-1.11.4/jquery-ui.min.css"
	      rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery.fancybox/jquery.fancybox.css"
	      rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery.formstyler/jquery.formstyler.css"
	      rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/login/css/style.css" rel="stylesheet" type="text/css"/>
	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/favicon.ico" type="image/x-icon"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/css/header.css" rel="stylesheet" type="text/css"/>
	
	<![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery/jquery-1.11.1.min.js"
	        type="text/javascript"></script>
</head>

<body>
<div class="wrapper">
	
	<header class="header">
		<div class="wrapper__header">
			<div class="header__content">
				<div class="header__logo">
					<a href="<?php echo $this->createUrl( 'redirectAxora' ); ?>" class="logo"><img
							src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/logo.png" alt=""
							class="logo__img"></a>
				</div>
				
				<div class="header__aside">
					<div id="dd" class="header__company" tabindex="1"><a href="javascript:void(0)"><?php
							
							if ( $clientInfo['Company_name'] != "" )
							{
								echo $clientInfo['Company_name'];
							}
							else
							{
								echo $clientInfo['Yandex_login'];
							}
							?></a> <span class="header__company-sup">+ <?php
							pr2( $statisticsSection['balance']['sum'] );
							echo ' ' . $statisticsSection['balance']['currency']; ?></span>
						<ul class="dropdown">
							<li><a href="<?php echo $this->createUrl( 'site/logout' ); ?>">Выйти</a></li>
						</ul>
					</div>
				</div>
				
				<div class="header__nav">
					<ul class="nav">
						<li class="nav__item"><a href="" class="nav__link is-active">Кампании</a></li>
						<li class="nav__item"><a href="showHistory" class="nav__link is-active">История счетов</a></li>
					
					</ul>
				</div>
			</div>
		</div>
	</header>
	
	<section class="content">
		<h1 class="billing-block-title">Формирование счета</h1>
		<div class="billing-block">
			<form action="<?php echo $this->createUrl( 'client/invoice' ) ?>" method="post">
				<div class="billing-block__content">
					<div class="billing-block__section">
						<h2 class="billing-block__section-title">Yandex</h2>
						<div class="billing-block__range js-range-block">
							<div class="billing-block__range-header">
								<span class="billing-block__range-header-cell">Сумма</span>
								<span
									class="billing-block__range-header-cell billing-block__range-header-cell_input"><input
										type="text" class="js-integar-input js-yd-s-input" id="yandex"></span>
								<span class="billing-block__range-header-cell">BYN</span>
								<input type=hidden id="sum" value="<?php  echo $averageSum;?>"/>
								<input type=hidden id="input_y"/>
							</div>
							<div class="js-range js-yd-s-range" data-range-min="0" data-range-max="100000"
							     data-range-value="50000" data-range-step="1000"></div>
						</div>
						
						<div class="billing-block__range js-range-block">
							<div class="billing-block__range-header">
								<span class="billing-block__range-header-cell">Период <span
										style="position: relative; top: 2px;">≈</span></span>
								<span
									class="billing-block__range-header-cell billing-block__range-header-cell_input"><input
										type="text" class="js-integar-input js-yd-d-input"></span>
								<span class="billing-block__range-header-cell">дней</span>
							</div>
							<div class="js-range js-yd-d-range" data-range-min="0" data-range-max="10000"
							     data-range-value="182" data-range-step="1"></div>
						</div>
					</div>
					
					<div class="billing-block__section">
						<h2 class="billing-block__section-title">Google</h2>
						<div class="billing-block__range js-range-block">
							<div class="billing-block__range-header">
								<span class="billing-block__range-header-cell">Сумма</span>
								<span
									class="billing-block__range-header-cell billing-block__range-header-cell_input"><input
										type="text" class="js-integar-input js-g-s-input" id="google"></span>
								<input type=hidden id="input_y"/>
								<span class="billing-block__range-header-cell">BYN</span>
							</div>
							<div class="js-range js-g-s-range" data-range-min="0" data-range-max="1000"
							     data-range-value="500" data-range-step="10"></div>
						</div>
						
						<div class="billing-block__range">
							<div class="billing-block__range-text">Точный период уточните у маркетолога</div>
						</div>
					</div>
				</div>
				<div class="billing-block__footer">
					<button type="submit" class="btn billing-block__btn" formtarget="_blank" id="bill">Сформировать счет</button>
				</div>
			</form>
		</div>
	</section>
	
	<footer class="footer">
		<div class="footer__copyright">© 2016, Частное предприятие «Аксора»</div>
		<div class="footer__contacts">
			<a href="tel:+375294134343">+375 29 413-43-43</a><br>
			<a href="mailto:info@axora.by">info@axora.by</a>
		</div>
		<div class="footer__content">Статистика автоматически связана со статистикой из Яндекс.Директа,<br> ваш аккаунт
			axora.243534@yandex.ru<br> пароль: 2546434
		</div>
	</footer>
</div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery-ui-1.11.4/jquery-ui.min.js"
        type="text/javascript"></script>
<script
	src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"
	type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery.fancybox/jquery.fancybox.pack.js"
        type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery.formstyler/jquery.formstyler.min.js"
        type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery.validate/jquery.validate.min.js"
        type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/js/scripts.js" type="text/javascript"></script>
</body>
</html>