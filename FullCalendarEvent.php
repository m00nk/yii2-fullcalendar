<?php
/**
 * @copyright (C) FIT-Media.com (fit-media.com), {@link http://tanitacms.net}
 * Date: 09.07.15, Time: 23:26
 *
 * @author        Dmitrij "m00nk" Sheremetjev <m00nk1975@gmail.com>
 * @package
 */

namespace m00nk\fullcalendar;

/**
 * Class FullCalendarEvent
 *
 * Класс данных ивентов для fullCalendar. Документация: http://fullcalendar.io/docs/event_data/Event_Object/
 */
class FullCalendarEvent
{
	public $id = 0;
	public $title = '';

	public $start = '';
	public $end = '';
	public $allDay = false;

	public $url = '';
	public $code = '';

	public $className = '';

	public $editable = false;

	public $overlap = true;

	public $color = null;
	public $backgroudColor = null;
	public $borderColor = null;
	public $textColor = null;
}