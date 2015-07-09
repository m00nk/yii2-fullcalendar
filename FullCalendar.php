<?php
/**
 * @copyright (C) FIT-Media.com (fit-media.com), {@link http://tanitacms.net}
 * Date: 09.07.15, Time: 21:57
 *
 * @author        Dmitrij "m00nk" Sheremetjev <m00nk1975@gmail.com>
 * @package
 */

namespace m00nk\fullcalendar;

use yii\helpers\Html;
use yii\base\Widget;
use \Yii;


class FullCalendar extends Widget
{
	public function run()
	{
		$view = $this->getView();

		FullCalendarAssets::register($view);


		return '<h1>IT IS ME!!!</h1>';
	}
}
