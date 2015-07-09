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
	public $sourcePath = '@vendor/bower/fullcalendar';

	public function init()
	{
		parent::init();
		$this->js[] = YII_DEBUG ? 'tinymce.js' : 'tinymce.min.js';
	}
}
