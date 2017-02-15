<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.
		</p>
	</div>
	
	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>
	
	<?php $this->endWidget(); ?>
</div><!-- form -->




<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

if ( !Yii::app()->user->isGuest && Yii::app()->user->name == 'admin' )
{
	$this->redirect( array( 'client/admin' ) );
}
elseif ( !Yii::app()->user->isGuest )
{
	$this->redirect( array( 'client/statistics' ) );
}
define( 'ANTI_DIRECT', TRUE );

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
	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
</head>

<body>
<div class="wrapper">
	<header class="header">
		<a href="index.html" class="logo"><img
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
				<form action="billing.html" method="post" class="js-validation-form">
					<div class="login-block__content">
						<h1 class="login-block__title">Вход в личный кабинет</h1>
						<div class="login-block__inputs">
							<div class="form-row">
								<label class="form-label">Логин</label>
								<?php echo $form->textField( $model, 'username' ); ?>
								<?php echo $form->error( $model, 'username', array( 'style' => 'display: block;color: #ff0000; font-size: 13px;line-height: 18px; margin-bottom: -18px;' ) ); ?>
							</div>
							<div class="form-row">
								<label class="form-label">Пароль</label>
								<?php echo $form->passwordField( $model, 'password' ); ?>
								<?php echo $form->error( $model, 'password', array( 'style' => 'display: block;color: #ff0000; font-size: 13px;line-height: 18px; margin-bottom: -18px;' ) ); ?>
							</div>
							<div class="check-row">
								<label><input type="checkbox" name="remember" class="js-styler"> Запомнить меня</label>
							</div>
						</div>
					</div>
					<div class="login-block__footer">
						<button type="submit" class="btn login-block__btn">Войти</button>
						<br>
						<a href="#recovery-window" class="login-block__recovery-link js-popup-link">Забыли пароль?</a>
					</div>
				</form>
			</div>
		</section>
		<?php $this->endWidget(); ?>
	</div>
	
	
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