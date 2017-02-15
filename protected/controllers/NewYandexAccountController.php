<?php

/**
 * Created by PhpStorm.
 * User: Axora
 * Date: 07.10.2016
 * Time: 15:58
 */
class NewYandexAccountController extends Controller
{
	public $layout='//layouts/column2';
	
	/**
	 * Performs the AJAX validation.
	 * @param Client $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='newYandexAccount-form')
		{
			echo CFormModel::validate($model);
			Yii::app()->end();
		}
	}
}