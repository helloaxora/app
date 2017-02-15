<?php
/* @var $this ClientController */
/* @var $model Client */


$this->breadcrumbs = array(
	'Clients' => array( 'index' ),
	$model->Yandex_login,
);

$this->menu = array(
	array( 'label' => 'List Client', 'url' => array( 'index' ) ),
	//array('label'=>'Create Client', 'url'=>array('add')),
	array( 'label' => 'Add existing Client', 'url' => array( 'create' ) ),
	array( 'label' => 'Update Client', 'url' => array( 'update', 'id' => $model->Id ) ),
	array( 'label' => 'Delete Client', 'url' => '#', 'linkOptions' => array( 'submit' => array( 'delete', 'id' => $model->Id ), 'confirm' => 'Are you sure you want to delete this item?' ) ),
	array( 'label' => 'Manage Client', 'url' => array( 'admin' ) ),
);
?>
<?php $var=$link[0]; ?>
	<h1>View Client <a target="_blank" href="<?php echo URL_PATH . '/index.php/site/login?l=' . $var->username . '&p=' . $var->hash . '&redirect=statistics'; ?>"><?php echo $model->Yandex_login; ?></a></h1>

<?php $this->widget( 'zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'Yandex_login',
		'Password',
		'Email_for_notifications',
		'Phone_for_notifications',
		'Company_name',
		'Name_marketer',
		'Send_msg',
	),
) ); ?>
	<br><br><br>
	<ul>
		<?php
		foreach ( $models as $oneInvoice ):
			
			$link = URL_PATH . "/index.php/client/invoice?login=" . $oneInvoice->Yandex_login .
				"&yandex=" . str_replace( ' ', '', $oneInvoice->Sum_Yandex ) .
				"&google=" . str_replace( ' ', '', $oneInvoice->Sum_Google ) .
				"&item=" . 'K' . date( "d-my", strtotime( $oneInvoice->Date ) ) .
				"&date=" . date( "d.m.y", strtotime( $oneInvoice->Date ) );
			echo '<li>';
			echo "<a target=\"_blank\" href='" . $link . "'>Счет-фактура № " . 'K' . date( "d-my", strtotime( $oneInvoice->Date ) )
				. " от " . date( "d.m.y", strtotime( $oneInvoice->Date ) ) . " г." . "</a><br>";
			echo "Яндекс: " . $oneInvoice->Sum_Yandex . ' р.<br>';
			echo "Google: " . $oneInvoice->Sum_Google . ' р.<br><br>';
			
			echo '</li>';
			?>
		<?php endforeach;
		// ?>
	</ul>
<?php $this->widget( 'CLinkPager', array(
	'pages' => $pages,
) ) ?>