<?php echo 1; ?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Axora</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<link href="lib/normalize.css/normalize.css" rel="stylesheet" type="text/css" />
	<link href="lib/jquery-ui-1.11.4/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	<link href="lib/jquery.fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
	<link href="lib/jquery.formstyler/jquery.formstyler.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/login/lib/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
</head>

<body>
<div class="wrapper">
	<header class="header">
		<a href="index.html" class="logo"><img src="images/logo.png" alt=""></a>
	</header>
	
	<section class="content">
		<div class="login-block">
			<form action="billing.html" method="post" class="js-validation-form">
				<div class="login-block__content">
					<h1 class="login-block__title">Вход в личный кабинет</h1>
					<div class="login-block__inputs">
						<div class="form-row">
							<label class="form-label">Логин</label>
							<input type="text" name="login" required>
						</div>
						<div class="form-row">
							<label class="form-label">Пароль</label>
							<input type="password" name="password" required>
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
	
	<footer class="footer">
		<div class="footer__copyright">© 2016, Частное предприятие «Аксора»</div>
		<div class="footer__contacts">
			<a href="tel:+375294134343">+375 29 413-43-43</a><br>
			<a href="mailto:info@axora.by">info@axora.by</a>
		</div>
	</footer>
	
	<div class="popup-window" id="recovery-window">
		<form class="js-recovery-form">
			<div class="popup-window__content">
				<div class="popup-window__title h1">Восстановление пароля</div>
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
			<div class="popup-window__title h3 align-center">Пароль отправлен на Вашу почту.</div>
		</div>
		<div class="popup-window__footer align-center">
			<button type="button" class="btn js-popup-close" style="min-width: 150px;">ОК</button>
		</div>
	</div>
</div>

<script src="lib/jquery-ui-1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="lib/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
<script src="lib/jquery.fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="lib/jquery.formstyler/jquery.formstyler.min.js" type="text/javascript"></script>
<script src="lib/jquery.validate/jquery.validate.min.js" type="text/javascript"></script>
<script src="js/scripts.js" type="text/javascript"></script>
</body>
</html>