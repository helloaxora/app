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
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/css/header.css" rel="stylesheet"
	      type="text/css"/>
	
	<![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery/jquery-1.11.1.min.js"
	        type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/js/dropDown.js"
	        type="text/javascript"></script>
</head>

<body>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/metrika.js"></script>
<noscript><div><img src="https://mc.yandex.ru/watch/42443694" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<div class="wrapper">
	<header class="header">
		<a href="<?php echo $this->createUrl( 'redirectAxora' ); ?>" class="logo"><img
				src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/logo.png"
				alt=""></a>
		
		<nav class="nav">
			<ul class="nav__list">
				<li class="nav__item"><a href="<?php echo $this->createUrl( 'client/statistics' ); ?>"
				                         class="nav__link">Кампании</a></li>
			</ul>
		</nav>
		
		<!--		<div class="account-field">-->
		<!--			<a href="#" class="account-link">ooopanki@mail.com</a>-->
		<!--		</div>-->
		
		<div class="header__aside">
			<div id="dd" class="header__company"><a href="javascript:void(0)"><?php
					
					if ( $clientInfo['Company_name'] != "" )
					{
						echo $clientInfo['Company_name'];
					}
					else
					{
						echo $clientInfo['Yandex_login'];
					}
					
					?></a> <span
					class="header__company-sup <?php if ( $balance['sum'] == 0 )
					{
						echo 'cl-red';
					} ?>"><?php
					if ( $balance['sum'] != 0 )
					{
						echo "+ ";
					}
					pr2( $balance['sum'] );
					echo ' ' . $balance['currency']; ?></span>
				<ul class="dropdown">
					<li><a href="<?php echo $this->createUrl( 'site/logout' ); ?>">Выйти</a></li>
				</ul>
			</div>
		</div>
	</header>
	
	<?php $form = $this->beginWidget( 'CActiveForm', array(
		'id' => 'invoice-form',
		'enableAjaxValidation' => false,
	) ); ?>
	<?php echo $form->hiddenField( $model, 'Yandex_login', array( 'value' => $clientInfo['Yandex_login'] ) ); ?>
	<section class="content">
		<h1 class="billing-block-title">Формирование счета для&nbsp;контекстной рекламы</h1>
		
		<div class="billing-block">
			<form action="<?php echo $this->createUrl( 'client/invoice' ) ?>" method="post" target="_blank">
				<div class="billing-block__content">
					<div class="billing-block__section">
						<h2 class="billing-block__section-title">Yandex</h2>
						<div class="billing-block__range_sum js-range-block">
							<div class="billing-block__range-header">
								<span class="billing-block__range-header-cell">Сумма</span>
								<span class="billing-block__range-header-cell billing-block__range-header-cell_input">
										<input type="text" class="js-integar-input js-yd-s-input" id="yandex"
										       value="876">
									<?php echo $form->hiddenField( $model, 'Sum_Yandex', array( 'id' => 'yandex_hidden' ) ); ?>
									<input id="last_yandex"
									       value="<?php echo str_replace( ' ', '', $lastInvoice[0]->Sum_Yandex ); ?>"
									       type="hidden">
								</span>
								<?php echo str_replace( ' ', '', $lastInvoice->Sum_Yandex ); ?>
								<span class="billing-block__range-header-cell">р.</span>
								<input type=hidden id="sum" value="<?php echo $averageSum; ?>"/>
							</div>
							<div class="js-range js-yd-s-range" data-range-min="0" data-range-max="100000"
							     data-range-value="50000" data-range-step="1000"></div>
						</div>
						<?php if ( $statisticsDays < 7 )
						{
							?>
							<div class="billing-block__range">
								<div class="billing-block__range-text">Период уточните <br>у маркетолога</div>
							</div>
						<?php }
						else
						{
							?>
							<div class="billing-block__range_period js-range-block">
								<div class="billing-block__range-header">
								<span class="billing-block__range-header-cell">Период<span
										style="position: relative; top: 2px;">≈</span></span>
									<span
										class="billing-block__range-header-cell billing-block__range-header-cell_input"><input
											type="text" class="js-integar-input js-yd-d-input"></span>
									<div class="hint_image">
										<div class="hint_hint">
											<div class="hint_rect"></div>
											<div class="hint_msg">Период может быть не точным</div>
										</div>
									</div>
									
									<span class="billing-block__range-header-cell">дней</span>
								</div>
								<div class="js-range js-yd-d-range" data-range-min="0" data-range-max="10000"
								     data-range-value="182" data-range-step="1"></div>
							</div>
						<?php } ?>
					
					
					</div>
					
					<div class="billing-block__section">
						<h2 class="billing-block__section-title">Google</h2>
						<div class="billing-block__range js-range-block">
							<div class="billing-block__range-header">
								<span class="billing-block__range-header-cell">Сумма</span>
								<span class="billing-block__range-header-cell billing-block__range-header-cell_input">
									<input type="text" class="js-integar-input js-g-s-input" id="google">
									<?php echo $form->hiddenField( $model, 'Sum_Google', array( 'id' => 'google_hidden' ) ); ?>
									<input id="last_google"
									       value="<?php echo str_replace( ' ', '', $lastInvoice[0]->Sum_Google ); ?>"
									       type="hidden">
								</span>
								<span class="billing-block__range-header-cell">p.</span>
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
					<button type="submit" class="btn billing-block__btn" id="bill" formtarget="_blank">Сформировать
						счет
					</button>
					<div id="msg_sum" class="msg_sum_hidden">Укажите сумму оплаты</div>
				</div>
			</form>
		</div>
	</section>
	<?php $this->endWidget(); ?>
	<footer class="footer">
		<div class="footer__copyright">© 2016, Частное предприятие «Аксора»</div>
		<div class="footer__contacts">
			<a href="tel:<?php echo $marketerInfo['Phone']; ?>"><?php echo $marketerInfo['Phone']; ?></a><br>
			<a href="mailto:<?php echo $marketerInfo['Email']; ?>"><?php echo $marketerInfo['Email']; ?></a>
		</div>
		<div class="footer__content">Статистика автоматически связана со статистикой из Яндекс.Директа,<br> ваш аккаунт
			<?php echo $clientInfo['Yandex_login']; ?><br> пароль: <?php echo $clientInfo['Password']; ?>
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