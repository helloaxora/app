<?php

class ClientController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	
	/**
	 * @return array action filters
	 */
	public function filters ()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules ()
	{
		return array(
			array( 'allow',
			       'actions' => array( 'admin', 'delete', 'index', 'view', 'create', 'update', 'add', 'invoice' ),
			       'users' => array( 'admin' ),
			),
			array( 'allow',
			       'actions' => array( 'statistics', 'bill', 'invoice' ),
			       'users' => array( '@' ),
			),
			array( 'allow',
			       'actions' => array( 'redirectAxora', 'redirectDogovor' ),
			       'users' => array( '*' ),
			),
			array( 'deny',  // deny all users
			       'users' => array( '*' ),
			),
		);
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView ($id)
	{
		$criteria = new CDbCriteria();
		$criteria->compare( 'Yandex_login', $this->loadModel( $id )->Yandex_login );
		$criteria->order = 'Date DESC';
		
		$count = Invoice::model()->count( $criteria );
		$pages = new CPagination( $count );
		
		$pages->pageSize = 10;
		$pages->applyLimit( $criteria );
		$models = Invoice::model()->findAll( $criteria );
		
		$criteria1 = new CDbCriteria();
		$criteria1->compare( 'username', $this->loadModel( $id )->Yandex_login );
		$link = Users::model()->findAll( $criteria1 );
		$this->render( 'view', array(
			'models' => $models,
			'pages' => $pages,
			'model' => $this->loadModel( $id ),
			'link'=>$link
		) );
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd ()//доюавление новго клиента в яндекс
	{
		echo "add";
		$model = new Client();
		$model->setScenario( 'create' );
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation( $model );
		
		if ( isset( $_POST['Client'] ) )
		{
			$model->attributes = $_POST['Client'];
			
			$model1 = new NewYandexAccount();
			$model1->login = $_POST['Client']['login'];
			$model1->name = $_POST['Client']['name'];
			$model1->surname = $_POST['Client']['surname'];
			$model1->currency = $_POST['Client']['currency'];
			
			$data = $model1->save();
			if ( !isset( $data['error_code'] ) )
			{
				$model->Yandex_login = $data['data']['Email'];
				$model->Password = $data['data']['Password'];
				$model->hash = MD5( $data['data']['Password'] );
				
				if ( $model->save() )
				{
					$this->redirect( array( 'view', 'id' => $model->Id ) );
				}
			}
			else
			{
				echo 'код ошибки=' . $data['error_code'] . '<br>';
				echo 'error_str=' . $data['error_str'] . '<br>';
				echo 'error_detail=' . $data['error_detail'] . '<br>';
				$this->render( 'add', array(
					'model' => $model,
				) );
			}
		}
		else
		{
			$this->render( 'add', array(
				'model' => $model,
			) );
		}
	}
	
	public function actionCreate ()
	{
		$model = new Client;
		$model->setScenario( 'add/update' );
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation( $model );
		
		if ( isset( $_POST['Client'] ) )
		{
			if($_POST['Client']['Send_msg']=='1')
				$_POST['Client']['Send_msg']='Да';
			else
				$_POST['Client']['Send_msg']='Нет';
			$model->attributes = $_POST['Client'];
			$model->sendMsg = 1;
			if ( $model->save() )
			{
				$modelUser = new Users;//добавление нового аккаунта в личн кабинет
				$modelUser->username = $_POST['Client']['Yandex_login'];
				$modelUser->password = $_POST['Client']['Password'];
				$modelUser->hash = MD5( $_POST['Client']['Password'] );
				$modelUser->save();
				
				{
					define( "DIRECT", 'dirdir' );
					define( "YII", 'dirdir' );
					$_POST['currentLogin'] = $_POST['Client']['Yandex_login'];
					require_once Yii::app()->basePath . '/../cron/Functions.php';
					require_once Yii::app()->basePath . '/../cron/AddStatistics.php';
				}
				$this->redirect( array( 'view', 'id' => $model->Id ) );
			}
		}
		
		$this->render( 'create', array(
			'model' => $model,
		) );
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate ($id)
	{
		$model = $this->loadModel( $id );
		$model->setScenario( 'add/update' );
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation( $model );
		
		if ( isset( $_POST['Client'] ) )
		{
			if($_POST['Client']['Send_msg']=='1')
				$_POST['Client']['Send_msg']='Да';
			else
				$_POST['Client']['Send_msg']='Нет';
			$model->attributes = $_POST['Client'];
			$model->attributes = $_POST['Client'];
			if ( $model->save() )
			{
				
				Yii::app()->db->createCommand()->update( 'users', array(
					'Username' => $model['Yandex_login'],'Password' => $model['Password'], 'hash' => MD5( $model['Password'] ) ),
				     'username=:username', array( ':username' => $model['Yandex_login'] ));
				
				
				$this->redirect( array( 'view', 'id' => $model->Id ) );
			}
		}
		
		$this->render( 'update', array(
			'model' => $model,
		) );
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete ($id)
	{
		$data = $this->loadModel( $id );
		Yii::app()->db->createCommand()->delete( 'users', 'username=:username', array( ':username' => $data['Yandex_login'] ) );
		
		$this->loadModel( $id )->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if ( !isset( $_GET['ajax'] ) )
		{
			$this->redirect( isset( $_POST['returnUrl'] ) ? $_POST['returnUrl'] : array( 'admin' ) );
		}
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex ()
	{
		$dataProvider = new CActiveDataProvider( 'Client' );
		$this->render( 'index', array(
			'dataProvider' => $dataProvider,
		) );
	}
	
	/**
	 *Shows statisticts to client
	 */
	public function actionStatistics ()
	{
		if ( Yii::app()->user->isGuest )
		{
			$this->redirect( array( 'site/login' ) );
		}
		elseif ( Yii::app()->user->name == 'admin' )
		{
			$this->redirect( array( 'client/admin' ) );
		}
		
		$currentClient = Yii::app()->user->name;
		require "functions.php";
		$balance = getBalance();
		
		
		$sql = "INSERT INTO balance ( Yandex_login, Balance)  VALUES ('" . $currentClient . "','" . $balance['sum'] . "')";
		Yii::app()->db->createCommand( $sql )->execute();
		
		//{подсчет солько дней осталось
		$arr = getAvCampaign( $currentClient );
		$averageSum=$arr['sum'];
		if ( $averageSum != 0 )
		{
			$daysLeft = round( $balance['sum']/$averageSum );
			if ( $daysLeft == 0 && $balance['sum'] != 0 )
			{
				$daysLeft = 'хватит менее чем на 1 день';
			}
			elseif ( $daysLeft == 0 )
			{
				$daysLeft = 'реклама приостановлена';
			}
			else
			{
				$daysLeft = $daysLeft = 'хватит на ' . $daysLeft . " " . getDayWord( $daysLeft );
			}
		}
		else
		{
			$daysLeft = '';
		}
		//}подсчет солько дней осталось
		
		$clientInfo = Yii::app()->db->createCommand()->select( '*' )->from( 'client' )
			->where( 'Yandex_login=:login', array( ':login' => $currentClient ) )->queryRow();
		$marketerInfo = Yii::app()->db->createCommand()->select( '*' )->from( 'marketer' )
			->where( 'name=:name', array( ':name' => $clientInfo['Name_marketer'] ) )->queryRow();
		$allCampaigns = Yii::app()->db->createCommand()->select( '*' )->from( 'campaigns' )
			->where( 'Yandex_login=:login', array( ':login' => $currentClient ) )->queryAll();
		
		
		$statisticsSection['balance'] = $balance;
		$statisticsSection['daysLeft'] = $daysLeft;
		if ( !isset( $_GET['id'] ) )
		{
			$_GET['id'] = $allCampaigns[0]['Id_campaign'];
		}
		
		$info = date_parse( date( 'Y-m-d', strtotime( "-1 days" ) ) );
		$statisticsSection['period']['day'] = $info['day'] . ' ' . month( $info['month'] ) . ' ' . $info['year'];
		
		$info = date_parse( date( 'Y-m-d', strtotime( "-1 days" ) ) );
		$info1 = date_parse( date( 'Y-m-d', strtotime( "-7 days" ) ) );
		$statisticsSection['period']['week'] = $info1['day'] . ' ' . month( $info1['month'] ) . ' &#8212 ' . $info['day'] . ' ' . month( $info['month'] ) . ' ' . $info['year'];
		
		$info = date_parse( date( 'Y-m-d', strtotime( "-1 days" ) ) );
		$info1 = date_parse( date( 'Y-m-d', strtotime( "-30 days" ) ) );
		$statisticsSection['period']['month'] = $info1['day'] . ' ' . month( $info1['month'] ) . ' &#8212 ' . $info['day'] . ' ' . month( $info['month'] ) . ' ' . $info['year'];
		
		
		$statisticsCurrentCampaign = Yii::app()->db->createCommand()->select( '*' )->from( 'api' )
			->where( 'Id_campaign=:id', array( ':id' => $_GET['id'] ) )->order( 'Date DESC' )->queryAll();
		
		$zeroDays = countZeroDays( $statisticsCurrentCampaign );
		
		
		$stat = statPerDay( $statisticsCurrentCampaign );
		$statisticsSection['st'] = $stat;
		$this->renderPartial( 'statistics', array( 'clientInfo' => $clientInfo, 'marketerInfo' => $marketerInfo,
		                                           'campaigns' => $allCampaigns, 'apiStatistics' => $statisticsCurrentCampaign,
		                                           'statisticsSection' => $statisticsSection, 'zeroDays' => $zeroDays ), '' );
		
	}
	
	public function actionBill ()
	{
		$model = new Invoice;
		$currentClient = Yii::app()->user->name;
		require "functions.php";
		$averageSum = getAvCampaign( $currentClient );
		$clientInfo = Yii::app()->db->createCommand()->select( '*' )->from( 'client' )
			->where( 'Yandex_login=:login', array( ':login' => $currentClient ) )->queryRow();
		
		$marketerInfo = Yii::app()->db->createCommand()->select( '*' )->from( 'marketer' )
			->where( 'name=:name', array( ':name' => $clientInfo['Name_marketer'] ) )->queryRow();
		$balance = getBalance();
		
		if ( isset( $_POST['Invoice'] ) )
		{
			
			require_once "SendMailSmtpClass.php";
			require_once Yii::app()->basePath . '/../../app.axora_configuration.php';
			$mailSMTP = new SendMailSmtpClass( EMAIL_LOGIN, EMAIL_PASSWORD, 'ssl://smtp.yandex.ru', 'Axora', 465 );

// заголовок письма
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
			$headers .= "From: Axora <".EMAIL_LOGIN.">\r\n"; // от кого письмо
			$model->attributes = $_POST['Invoice'];
			if ( $model->save() )
			{
				$link = URL_PATH."/index.php/client/invoice?login=" . $model->Yandex_login .
					"&yandex=" . str_replace( ' ', '', $model->Sum_Yandex ) .
					"&google=" . str_replace( ' ', '', $model->Sum_Google ) .
					"&item=" . 'K' . date( "d-my" ) .
					"&date=" . date( "d.m.y" );
				$msg =
					"Клиент : " . $model->Yandex_login . "<br>" .
					"<a href='" . $link . "'>Счет-фактура № " . 'K' . date( "d-my" ) . " от " . date( "d.m.y" ) . " г." . "</a><br>" .
					"Яндекс: " . $model->Sum_Yandex . " р." . "<br>" .
					"Google: " . $model->Sum_Google . " р." . "<br>";
				
				$result = $mailSMTP->send( $marketerInfo['Email'], $model->Yandex_login . ' - формирование счета', $msg, $headers ); // отправляем письмо
				
				$this->redirect( array( 'client/invoice', 'login' => $model->Yandex_login,
				                        'yandex' => str_replace( ' ', '', $model->Sum_Yandex ),
				                        'google' => str_replace( ' ', '', $model->Sum_Google ),
				                        'item' => 'K' . date( "d-my" ), 'date' => date( "d.m.y" ) ) );
			}
		}
		
		
		$criteria = new CDbCriteria();
		$criteria->compare( 'Yandex_login', $currentClient );
		$criteria->order = 'Date DESC';
		$criteria->limit = '1';
		$lastInvoice = Invoice::model()->findAll( $criteria );
		
		$this->renderPartial( 'bill', array( 'model' => $model, 'clientInfo' => $clientInfo, 'averageSum' => $averageSum['sum'],
		                                     'lastInvoice' => $lastInvoice, 'marketerInfo' => $marketerInfo,
		                                     'balance' => $balance, 'statisticsDays' => $averageSum['days'] ) );
	}
	
	public function actionInvoice ($login, $yandex, $google, $item, $date)
	{
		
		$this->renderPartial( 'invoice' );
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin ()
	{
		if ( Yii::app()->user->name == 'admin' )
		{
			/*if ( !isset( $_SESSION['token'] ) )
			{
				require 'connection.php';
			}*/
		}
		/*if ( isset( $_SESSION['token'] ) )
		{
			echo 'connection established='.$_SESSION['token'];
		}*/
		
		
		$model = new Client( 'search' );
		$model->unsetAttributes();  // clear any default values
		if ( isset( $_GET['Client'] ) )
		{
			$model->attributes = $_GET['Client'];
		}
		
		$this->render( 'admin', array(
			'model' => $model,
		) );
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Client the loaded model
	 * @throws CHttpException
	 */
	public function loadModel ($id)
	{
		$model = Client::model()->findByPk( $id );
		if ( $model === null )
		{
			throw new CHttpException( 404, 'The requested page does not exist.' );
		}
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param Client $model the model to be validated
	 */
	protected function performAjaxValidation ($model)
	{
		if ( isset( $_POST['ajax'] ) && $_POST['ajax'] === 'client-form' )
		{
			echo CActiveForm::validate( $model );
			Yii::app()->end();
		}
	}
	
	public function actionredirectAxora ()
	{
		Yii::app()->request->redirect( 'https://www.axora.by/' );
	}
	
	public function actionredirectDogovor ()
	{
		Yii::app()->request->redirect( 'https://axora.by/assets/dogovor.pdf' );
	}
	
}
