<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */
if ( isset( $_GET['redirect'] ) && $_GET['redirect'] == 'bill' )
{
	$this->redirect( $this->createUrl( 'client/bill' ) );
}
if (  !Yii::app()->user->isGuest )
{
	$this->redirect( array( 'client/statistics' ) );
}
require_once Yii::app()->basePath . '/../../app.axora_configuration.php';
?>
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
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery/jquery-1.11.1.min.js"
	        type="text/javascript"></script>
</head>

<body>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/metrika.js"></script>
<noscript><div><img src="https://mc.yandex.ru/watch/42443694" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

<div class="wrapper">
	<header class="header">
		<a href="<?php echo $this->createUrl( 'client/redirectAxora' ); ?>" class="logo"><img
				src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/images/logo.png" alt=""></a>
	</header>
	<div class="form">
		<?php $form = $this->beginWidget( 'CActiveForm', array(
			'id' => 'login-form',
			'enableClientValidation' => true,
			'clientOptions' => array(
				'validateOnSubmit' => true,
			),
		) ); ?>
		<section class="content">
			<div class="login-block">
				<form action="#" method="post" class="js-validation-form">
					<div class="login-block__content">
						<h1 class="login-block__title">Вход в личный кабинет</h1>
						<div class="login-block__inputs">
							<div class="form-row">
								<label class="form-label">Логин</label>
								<?php echo $form->textField( $model, 'username', array( 'id' => 'l', 'value' => $_GET['l'] ) ); ?>
								<div id="errorr_l">
									<?php echo $form->error( $model, 'username', array( 'style' => 'display: block;color: #ff0000; font-size: 13px;line-height: 18px; margin-bottom: -18px;', ) ); ?>
								</div>
							</div>
							<div class="form-row">
								<label class="form-label">Пароль</label>
								<?php echo $form->passwordField( $model, 'password', array( 'id' => 'p', 'value' => $_GET['p'] ) ); ?>
								<div id="errorr_p">
									<?php echo $form->error( $model, 'password', array( 'id' => 'err', 'style' => 'display: block;color: #ff0000; font-size: 13px;line-height: 18px; margin-bottom: -18px;' ) ); ?>
								</div>
							</div>
							<div class="check-row">
								<label><?php echo $form->checkBox( $model, 'rememberMe', array( 'checked' => 'true', 'class' => 'js-styler' ) );
									?>Запомнить меня</label>
								<?php echo $form->error( $model, 'rememberMe' ); ?>
							</div>
						</div>
					</div>
					<div class="login-block__footer">
						<button type="submit" class="btn login-block__btn">Войти</button>
						<input type="hidden" name="true" id="check">
						<br>
						<a href="#recovery-window" class="login-block__recovery-link js-popup-link">Забыли пароль?</a>
					</div>
				</form>
			</div>
		</section>
		<?php $this->endWidget();
		?>
	</div><!-- form -->
	
	
	<footer class="footer">
		<div class="footer__copyright">© 2016, Частное предприятие «Аксора»</div>
	</footer>
	
	<div class="popup-window" id="recovery-window">
		<form class="js-recovery-form">
			<div class="popup-window__content">
				<div class="popup-window__title h1" id="change">Восстановление пароля</div>
				<div class="pass-recovery-input-row">
					<label class="form-label">Введите email</label>
					<input type="email" name="email" required>
				</div>
			</div>
			<div class="popup-window__footer">
				<button type="submit" class="btn pass-recovery-btn">Отправить</button>
			</div>
		</form>
	</div>
	
	<div class="popup-window" id="recovery-send-window">
		<div class="popup-window__content">
			<div class="popup-window__title h3 align-center" id="change1">Пароль отправлен на Вашу почту.</div>
		</div>
		<div class="popup-window__footer align-center">
			<button type="button" class="btn js-popup-close" style="min-width: 150px;">ОК</button>
		</div>
	</div>
</div>
<script>
	var url_path="<?php echo URL_PATH ?>";
</script>
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