<?php
/**
 * @copyright (C) FIT-Media.com (fit-media.com), {@link http://tanitacms.net}
 * Date: 09.07.15, Time: 22:18
 *
 * @author        Dmitrij "m00nk" Sheremetjev <m00nk1975@gmail.com>
 * @package
 */

namespace m00nk\fullcalendar;

use yii\jui\Dialog;
use yii\web\AssetBundle;

class FullCalendarAssets extends AssetBundle
{
	public $depends = [
		'yii\web\JqueryAsset',
	];

	public $publishOptions = [
		'forceCopy' => YII_ENV_DEV
	];

	public function init()
	{
		$this->sourcePath = __DIR__.'/assets';

		$this->css = [
			YII_DEBUG ? 'fullcalendar.min.css' : 'fullcalendar.css'
		];

		$this->js = [
			'lib/moment.min.js',
			YII_DEBUG ? 'fullcalendar.min.js' : 'fullcalendar.js'
		];

		parent::init();
	}

//	public function registerAssetFiles($view)
//	{
//		foreach($this->css as &$c)
//			$c = \Yii::$app->params['widget']['baseUrl'].$this->baseUrl.'/'.$c;
//
//		foreach($this->js as &$c)
//			$c = \Yii::$app->params['widget']['baseUrl'].$this->baseUrl.'/'.$c;
//
//		parent::registerAssetFiles($view);
//	}
}
