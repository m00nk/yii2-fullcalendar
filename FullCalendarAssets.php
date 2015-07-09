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
	public $css = [
//		'jsk.css',
	];

	public $js = [
//		'jsk.js'
	];

	public $depends = [
//		'yii\bootstrap\BootstrapAsset',
//		'yii\web\JqueryAsset',
//		'yii\jui\JuiAsset',
//		'm00nk\jsk\SweetAlertAsset'
	];

	public $publishOptions = [
		'forceCopy' => YII_ENV_DEV
	];

	public function init()
	{
		$this->sourcePath = __DIR__.'/assets';
		parent::init();
	}
}
