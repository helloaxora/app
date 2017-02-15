<?php
if ( $_POST )
{
	//$data['sum'] = number_format( $info[0]['Sum_search'], 2, ',', ' ' );
	require 'sendMail.php';
}


$mainDates = "";
$numberDays = 0;
if ( count( $apiStatistics ) !== 0 && $zeroDays + 30 > count( $apiStatistics ) )
{
	if ( count( $apiStatistics ) != 1 )
	{
		$firstDay = date_parse( date( 'Y-m-d', strtotime( $apiStatistics['0']['Date'] ) ) );
		$lastDay = date_parse( date( 'Y-m-d', strtotime( $apiStatistics[count( $apiStatistics ) - 1]['Date'] ) ) );
		$mainDates = $lastDay['day'] . ' ' . month( $lastDay['month'] ) . ' &#8212 ' . $firstDay['day'] . ' ' . month( $firstDay['month'] ) . ' ' . $firstDay['year'];
		$numberDays = count( $apiStatistics );
	}
	else
	{
		$firstDay = date_parse( date( 'Y-m-d', strtotime( $apiStatistics['0']['Date'] ) ) );
		$mainDates = $firstDay['day'] . ' ' . month( $firstDay['month'] ) . ' ' . $firstDay['year'];
		$numberDays = count( $apiStatistics );
	}
	
	
}
elseif ( count( $apiStatistics ) !== 0 )
{
	$firstDay = date_parse( date( 'Y-m-d', strtotime( $apiStatistics['0']['Date'] ) ) );
	$lastDay = date_parse( date( 'Y-m-d', strtotime( $apiStatistics[$zeroDays + 29]['Date'] ) ) );
	$mainDates = $lastDay['day'] . ' ' . month( $lastDay['month'] ) . ' &#8212 ' . $firstDay['day'] . ' ' . month( $firstDay['month'] ) . ' ' . $firstDay['year'];
	$numberDays = $zeroDays + 30;
}
else
{
	$firstDay = date_parse( date( 'Y-m-d', strtotime( "-1 days" ) ) );
	$lastDay = date_parse( date( 'Y-m-d', strtotime( "-30 days" ) ) );
	$mainDates = $lastDay['day'] . ' ' . month( $lastDay['month'] ) . ' &#8212 ' . $firstDay['day'] . ' ' . month( $firstDay['month'] ) . ' ' . $firstDay['year'];
	$numberDays = 0;
}
require_once Yii::app()->basePath . '/../../app.axora_configuration.php';
?>

<!DOCTYPE HTML>
<html lang="ru">
<head>
	<meta charset="utf-8"/>
	<title>Axora</title>
	<meta content="telephone=no" name="format-detection"/>
	<meta http-equiv="x-rim-auto-match" content="none">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport"
	      content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1, minimum-scale=1">
	
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/favicon.ico"
	      type="image/x-icon"/>
	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/favicon.ico" type="image/x-icon"/>
	
	
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/lib/normalize.css/normalize.css" rel="stylesheet"
	      type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/lib/owl.carousel/owl.carousel.css"
	      rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/lib/jquery.fancybox/jquery.fancybox.css"
	      rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/lib/likely/likely.css" rel="stylesheet"
	      type="text/css"/>
	
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/css/media.css" rel="stylesheet" type="text/css"/>
	
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	
	<![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	
	
	<!--	календарь-->
	<!--	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
	<!--	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">-->
	<!--	календарь-->
	<script>
		var url_path = "<?php echo URL_PATH; ?>";
	</script>
	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/lib/jquery/jquery-1.11.1.min.js"
	        type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/lib/jquery.validate/jquery.validate.min.js"
	        type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/lib/owl.carousel/owl.carousel.min.js"
	        type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/lib/jquery.fancybox/jquery.fancybox.pack.js"
	        type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/lib/likely/likely.js"
	        type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/js/dropDown.js"
	        type="text/javascript"></script>
	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/js/scripts.js" type="text/javascript"></script>
	<script>
		function funcBefore() {
			$("#change").css('color', 'rgb(0, 0, 0)');
			$("#change").text('Отправка сообщения...');
		}
		
		function funcSuccess() {
			$("#change").css('color', 'rgb(10, 107, 3)');
			$("#change").text('Спасибо, ваше сообщение отправлено.');
			$("#message").val('');
		}
		
		$(document).ready(function () {
			$("#load").bind("click", function () {
				
				if ($("textarea#message").val() != '') {
					$.ajax({
						type: "POST",
						data: ({message: $("textarea#message").val(), email: '<?php echo $marketerInfo['Email']; ?>'}),
						dataType: 'html',
						beforeSend: funcBefore,
						success: funcSuccess
					})
				}
			})
		})
	</script>

</head>

<body>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/metrika.js"></script>
<noscript><div><img src="https://mc.yandex.ru/watch/42443694" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!--[if lt IE 10]>
<div class="browse-happy">
	<div class="container">
		<p class="browse-happy__notice">Мы обнаружили, что вы используете <strong>устаревшую версию</strong> браузера
			Internet Explorer</p>
		<p class="browse-happy__security">Из соображений безопасности этот сайт поддерживает Internet Explorer версии 10
			и выше <br>Кроме того, этот и многие другие сайты могут отображаться <strong>некорректно</strong></p>
		<p class="browse-happy__update">Пожалуйста, обновите свой браузер по этой <a href="http://browsehappy.com/"
		                                                                             target="_blank">ссылке</a></p>
		<p class="browse-happy__recommend">(мы рекомендуем <a href="http://www.google.com/chrome" target="_blank">Google
			Chrome</a>)</p>
	</div>
</div>
<![endif]-->

<div class="page-wrapper">
	<header class="header">
		<div class="wrapper__header">
			<input type=hidden id="campaign" value="<?php echo $_GET['id']; ?>"/>
			<div class="header__content">
				<div class="header__logo">
					<a href="<?php echo $this->createUrl( 'redirectAxora' ); ?>" class="logo"><img
							src="<?php echo Yii::app()->request->baseUrl; ?>/css/styles/logo.png" alt=""
							class="logo__img"></a>
				</div>
				
				
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
							class="header__company-sup <?php if ( $statisticsSection['balance']['sum'] == 0 )
							{
								echo 'cl-red';
							} ?>"><?php
							if ( $statisticsSection['balance']['sum'] != 0 )
							{
								echo "+ ";
							}
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
					</ul>
				</div>
			
			
			</div>
		</div>
	</header>
	<?php
	if ( count( $campaigns ) > 4 ):
		?>
		<span class="side-panel-target"><span><?php echo count( $campaigns ) - 4; ?></span></span>
		
		<div class="side-panel">
			<span class="side-panel__close"></span>
			<div class="side-panel__content">
				<ul class="side-panel-nav">
					<?php
					for ( $i = 4; $i < count( $campaigns ); $i++ )
					{
						?>
						<li class="side-panel-nav__item">
							<a href='
						<?php
							echo $this->createUrl( 'client/statistics', array(
								'id' => $campaigns[$i]['Id_campaign']
							) );
							?>' title="<?php echo $campaigns[$i]['Campaign_name'] ?>"
							   class="campaign-nav__link <?php
							   if ( $campaigns[$i]['Id_campaign'] == $_GET['id'] )
							   {
								   echo 'is-active';
							   }
							   ?>"><?php echo $campaigns[$i]['Campaign_name'] ?></a>
						</li>
						
						<?php
					}
					?>
				</ul>
			</div>
		</div>
		<?php
	endif;
	?>
	
	<div class="wrapper">
		<ul class="campaign-nav">
			<?php
			$i = 1;
			foreach ( $campaigns as $oneCampaignData )
			{
				?>
				<li class="campaign-nav__item">
					<a href='<?php echo $this->createUrl( 'client/statistics', array(
						'id' => $oneCampaignData['Id_campaign']
					) );
					?>' title="<?php echo $oneCampaignData['Campaign_name'] ?>"
					   class="campaign-nav__link <?php
					   if ( $oneCampaignData['Id_campaign'] == $_GET['id'] ) echo ' is-active'
					   ?>"><?php echo $oneCampaignData['Campaign_name'] ?></a>
				</li>
				<?php
				if ( $i > 3 )
				{
					break;
				}
				$i++;
			}
			?>
		</ul>
		
		<div class="campaign-score">
			<div class="campaign-score__content">
				<div class="campaign-score__balance">
					Осталось: <?php pr2( $statisticsSection['balance']['sum'] );
					echo ' ' . $statisticsSection['balance']['currency']; ?>
					<span
						class="campaign-score__balance-sup"><?php echo $statisticsSection['daysLeft']; ?></span>
				</div>
				
				<div class="campaign-score__footer">
					<a href="<?php echo $this->createUrl( 'client/bill' ) ?>" class="btn campaign-score__btn">Пополнить
						счет</a>
					<div>по карточке, безналом или наличными через банк</div>
				</div>
			</div>
			
			<div class="campaign-score__aside">Самостоятельно пополняйте счет, смотрите статистику, спрашивайте
				интернет-маркетолога об эффективности ваших рекламных кампаний
			</div>
		</div>
		
		<div class="campaign-main-statistics-section">
			<div class="campaign-main-statistics-section__period">
				<div class="period-select-block">
					<div class="period-select-block__head">Выберите период статистики</div>
<!--					<div class="period-select-block__title">30 Декабря 2015 — 31 Января 2016</div>-->
					<div class="period-select-block__nav" id="stat_section">
						<a href="javascript:void(0)" class="period-select-block__nav-link is-active" id="day">вчера</a>
						<a href="javascript:void(0)" class="period-select-block__nav-link" id="week">7 дней</a>
						<a href="javascript:void(0)" class="period-select-block__nav-link" id="month"">месяц</a>
						<input type="hidden" id="period" value="day">
						<input type="hidden" id="type" value="search">
					</div>
				</div>
			</div>
			
			<div class="campaign-main-statistics-section__content">
				<div class="campaign-main-statistics-table" id="stat-section">
					<div class="campaign-main-statistics-table__title" id="period_day">Краткая статистика :
						<?php echo $statisticsSection['period']['day']; ?>
						<li class="search-context">
							<a href="javascript:void(0)" class="search-context-link is-active" id="search_section1">по
								поиску</a> <a
								href="javascript:void(0)" id="context_section1" class="search-context-link">по РСЯ</a>
						</li>
					</div>
					<div class="campaign-main-statistics-table__title hide" id="period_week">Краткая статистика :
						<?php echo $statisticsSection['period']['week']; ?>
						<li class="search-context">
							<a href="javascript:void(0)" class="search-context-link is-active" id="search_section2">по
								поиску</a> <a
								href="javascript:void(0)" id="context_section2" class="search-context-link">по РСЯ</a>
						</li>
					</div>
					<div class="campaign-main-statistics-table__title hide" id="period_month">Краткая статистика :
						<?php echo $statisticsSection['period']['month']; ?>
						<li class="search-context">
							<a href="javascript:void(0)" class="search-context-link is-active" id="search_section3">по
								поиску</a> <a
								href="javascript:void(0)" id="context_section3" class="search-context-link">по РСЯ</a>
						</li>
					</div>
					<div class="campaign-main-statistics-table__content">
						<div class="campaign-main-statistics-table__content-cell" style="color: #00e016;">
							<div class="campaign-main-statistics-table__content-cell-title">Показов:</div>
							<div
								class="campaign-main-statistics-table__content-cell-value"
								id="shows"><?php pr0( $statisticsSection['st']['shows'] ); ?></div>
						</div>
						<div class="campaign-main-statistics-table__content-cell" style="color: #db7e11;">
							<div class="campaign-main-statistics-table__content-cell-title">Кликов:</div>
							<div
								class="campaign-main-statistics-table__content-cell-value"
								id="clicks"><?php pr0( $statisticsSection['st']['clicks'] ); ?></div>
						</div>
						<div class="campaign-main-statistics-table__content-cell" style="color: #703ef3;">
							<div class="campaign-main-statistics-table__content-cell-title">CTR:</div>
							<div
								class="campaign-main-statistics-table__content-cell-value"
								id="ctr"><?php pr2( $statisticsSection['st']['ctr'] ); ?>
								<small>%</small>
							</div>
						</div>
						<div class="campaign-main-statistics-table__content-cell" style="color: #1fabec;">
							<div class="campaign-main-statistics-table__content-cell-title">Ср. цена клика:</div>
							<div
								class="campaign-main-statistics-table__content-cell-value"
								id="avPrice"><?php pr2( $statisticsSection['st']['avPrice'] ); ?>
								<small><?php echo $statisticsSection['balance']['currency']; ?></small>
							</div>
						</div>
						<div class="campaign-main-statistics-table__content-cell" style="color: #ed3c4c;">
							<div class="campaign-main-statistics-table__content-cell-title">Потрачено:</div>
							<div
								class="campaign-main-statistics-table__content-cell-value"
								id="sum"><?php pr2( $statisticsSection['st']['sum'] ); ?>
								<small><?php echo $statisticsSection['balance']['currency']; ?></small>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="currency" id="currency"
		       value="<?php echo $statisticsSection['balance']['currency']; ?>">
		<input type="hidden" name="numberOfDays" id="numberOfDays" value="<?php echo $numberDays; ?>">
		<div class="campaign-statistics-section">
			<div class="campaign-statistics-section__content" id="bottom_point">
				<div class="campaign-statistics-section__title" id="date">Подробная
					статистика: <?php echo $mainDates; ?>
					<li class="search-context">
						<a href="javascript:void(0)" class="search-context-link is-active" id="search">по поиску</a><a
							href="javascript:void(0)" id="context" class="search-context-link">по РСЯ</a>
					</li>
				</div>
				<div class="responsive-table__wrapper" id="table">
					<table class="responsive-table campaign-statistics-table">
						<tr>
							
							<th>Дата</th>
							<th>Показы</th>
							<th>Клики</th>
							<th>CTR, %</th>
							<th>Средняя цена клика</th>
							<th>Дневной расход, <?php echo $statisticsSection['balance']['currency']; ?></th>
						</tr>
						<tbody>
						<?php
						for ( $i = 0; $i < $numberDays; $i++ )
						{
							if ( ( isZeroDay( $apiStatistics[$i] ) && $i == $numberDays - 1 )
								||
								( isZeroDay( $apiStatistics[$i] ) && !isZeroDay( $apiStatistics[$i + 1] ) )
							)
							{
								require( 'zeroCell.php' );
							}
							elseif ( isZeroDay( $apiStatistics[$i] ) && isZeroDay( $apiStatistics[$i + 1] ) )
							{
								$lastDay = $apiStatistics[$i]['Date'];
								while ( isZeroDay( $apiStatistics[$i] ) && $i < $numberDays )
								{
									$i++;
								}
								$i -= 1;
								$firstDay = $apiStatistics[$i]['Date'];
								$firstDay = date_parse( date( 'Y-m-d', strtotime( $firstDay ) ) );
								$lastDay = date_parse( date( 'Y-m-d', strtotime( $lastDay ) ) );
								$period = $firstDay['day'] . ' ' . month( $firstDay['month'] ) . ' &#8212 ' . $lastDay['day'] . ' ' . month( $lastDay['month'] );
								
								require 'fewZeroCells.php';
							}
							else
							{
								require( 'cell.php' );
							}
						}
						if ( $numberDays == 0 )
						{
							?>
							<tr class="zeroCell">
								<td><font align="center">. . .</font></td>
								<td colspan="5">
									<div class="row">
										<div class="side_l">
											<hr class="zeroCell">
										</div>
										<div class="middle"><?php echo ' ' . $mainDates . ' показов не было '; ?></div>
										<div class="side_r">
											<hr class="zeroCell">
										</div>
								</td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="campaign-statistics-section__aside" id="aside">
				<div class="form-block form-block_manager">
					<form class="js-validation-form">
						<div class="form-block__content">
							<div class="manager-info">
								<?php echo CHtml::image( Yii::app()->request->baseUrl . '/images/' . $marketerInfo['Photo'], "Photo", array( "height" => '87px', "width" => '87px' ) ); ?>
								<div class="manager-info__name"><?php
									echo $marketerInfo['Name'];
									?></div>
								<div class="manager-info__content">
									ваш интернет-маркетолог<br>
									<?php
									echo $marketerInfo['Phone'];
									?>
								</div>
							</div>
							
							<div class="form-block__desc">Задайте мне вопрос, например,<br> Добавьте, пожалуйста, новые
								запросы: железобетонные изделия и двери в рассрочку
							</div>
							
							<div class="form-block__form">
								<textarea name="message" id="message" required></textarea>
							</div>
						
						</div>
						<div class="form-block__footer">
							<button type="button" class="btn form-block__btn" id="load">Отправить</button>
							<div class="form-block__note" id="change">Отвечу
								на <?php echo $clientInfo['Email_for_notifications'] ?>
								<br> или позвоню
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<footer class="footer">
		<div class="wrapper">
			<div class="footer__inner">
				<div class="footer__social">
					© 2016, Частное предприятие «Аксора»
				</div>
				<div class="footer__content">
					<div class="footer__content-col">
						Статистика автоматически связана со статистикой из Яндекс.Директа,<br>
						ваш аккаунт<br>
						<?php echo $clientInfo['Yandex_login']; ?><br>
						пароль: <?php echo $clientInfo['Password']; ?>
					</div>
					<div class="footer__content-col">
						<?php echo $marketerInfo['Phone']; ?><br>
						<a href="mailto:<?php echo $clientInfo['Email_for_notifications']; ?>"><?php echo $marketerInfo['Email']; ?></a>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>

<script>
	
	var mq = window.matchMedia("(min-width: 767px)");
	
	if (mq.matches) {
		var w = document.getElementById('aside').getBoundingClientRect().width;
		var l = document.getElementById('aside').getBoundingClientRect().left;
		var body = document.body,
			html = document.documentElement;
		var margTop = 0;
		
		
		window.onresize = function () {
			w = document.getElementById('aside').getBoundingClientRect().width;
			l = document.getElementById('aside').getBoundingClientRect().left;
			$("#aside").css("left", l);
			$("#aside").css("width", w);
			mq = window.matchMedia("(min-width: 767px)");
		}
		window.onscroll = function () {
			if (
				$('#bottom_point').height() > $('#aside').height()
				&&
				document.getElementById("aside").style.position !== "fixed"
				&&
				(
					(document.getElementById('aside').getBoundingClientRect().bottom < document.getElementById('bottom_point').getBoundingClientRect().bottom
					&&
					document.getElementById('aside').getBoundingClientRect().top < 23)
					||
					(document.getElementById('aside').getBoundingClientRect().bottom > document.getElementById('bottom_point').getBoundingClientRect().bottom
					&&
					document.getElementById('aside').getBoundingClientRect().top > 17)
				)
			) {
				$("#aside").css("position", "fixed");
				$("#aside").css("top", 20);
				$("#aside").css("left", l);
				$("#aside").css("width", w);
				$("#aside").css("margin-top", "inherit");
			}
			else if (document.getElementById('aside').getBoundingClientRect().top < document.getElementById('bottom_point').getBoundingClientRect().top) {
				$("#aside").css("position", "inherit");
				$("#aside").css("top", "inherit");
				$("#aside").css("margin-top", "inherit");
				$("#aside").css("left", l);
				$("#aside").css("width", w);
			}
			if (
				document.getElementById('aside').getBoundingClientRect().bottom > document.getElementById('bottom_point').getBoundingClientRect().bottom
				&&
				document.getElementById("aside").style.position === "fixed"
			) {
				$("#aside").css("position", "inherit");
				$("#aside").css("top", "inherit");
				if (margTop != 0 && margTop < $(window).scrollTop() - 1035) {
					$("#aside").css("margin-top", margTop);
				}
				else {
					margTop = $(window).scrollTop() - 1035;
					$("#aside").css("margin-top", margTop);
				}
				$("#aside").css("left", l);
				$("#aside").css("width", w);
//				alert(document.getElementById('aside').getBoundingClientRect().bottom+
//					".............."+
//					document.getElementById('bottom_point').getBoundingClientRect().bottom);
			}
		}
	}


</script>
</body>
</html>