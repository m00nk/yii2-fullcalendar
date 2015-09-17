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
use yii\helpers\Json;
use yii\web\JsExpression;


class FullCalendar extends Widget
{
	const VIEW_MONTH = 'month';
	const VIEW_WEEK = 'basicWeek';
	const VIEW_DAY = 'basicDay';
	const VIEW_AGENDA_WEEK = 'agendaWeek';
	const VIEW_AGENDA_DAY = 'agendaDay';

	//======================================================
	// Параметры
	//======================================================

	public $options = [];

	/** @var array опции JS-скрипта. Имеют приоритет над всеми остальными параметрами. */
	public $jsOptions = [];

	/** @var FullCalendarEvent[] массив ивентов для отображения */
	public $events = [];

	/** @var bool|string URL для скачивания данных о событиях. */
	public $ajaxUrl = false;

	/** @var array дополнительные параметры AJAX-запросов */
	public $ajaxData = [];

	/** @var bool|string "начальная" дата. Формат: YYYY-MM-DD. Если указать 2015-11-08, то в режиме месяца будет показан ноябрь 2015, в режиме недели - та неделя, на которую попадает указанная дата.  */
	public $defaultDate = false;

	/** @var int максимальное количество ивентов в одном дне */
	public $eventLimit = 5;

	/** @var string дефолтовый вид. */
	public $defaultView = self::VIEW_MONTH;

	/** @var array объекты в заголовке. Документация: http://fullcalendar.io/docs/display/header/ */
	public $header = [
		'left' => 'title',
		'center' => '',
		'right' => 'today prev,next, month, basicWeek, basicDay, agendaWeek, agendaDay'
	];

	/** @var string|int Высота "окна" виджета в точках. Этот размер не влияет на размер виджета, если не влезет, он будет скроллиться внутри "окна". */
	public $height = 'auto';

	/** @var string|int Высота, к которой будет стремиться виджет. В доке сказано, что при невлезании появятся скроллы, у меня не появились... */
	public $contentHeight = 'auto';

	/** @var bool|string часовой пояс.
	 * Если "local", то используется часовой пояс броузера.
	 * Если не задан (FALSE), то будет использован часовой пояс приложения (не пользователя!!!)
	 * Документация: http://fullcalendar.io/docs/timezone/timezone/
	 */
	public $timezone = 'UTC';

	/** @var bool|string формат отображения времени. Документация: http://fullcalendar.io/docs/text/timeFormat/ */
	public $timeFormat = false;

	/** @var bool показывать ли область событий c флагом "Целый день". Актуально только для видов VIEW_AGENDA_WEEK и VIEW_AGENDA_DAY */
	public $allDaySlot = false;

	/** @var bool Включатель "перекрытия" блоков событий. Актуально только для видов VIEW_AGENDA_WEEK и VIEW_AGENDA_DAY */
	public $slotEventOverlap = true;

	//======================================================
	// Рендерер
	//======================================================

	/** @var \yii\web\JsExpression|bool кастомный рендерер ивентов. Документация: http://fullcalendar.io/docs/event_rendering/eventRender/  */
	public $eventRender = false;

	//======================================================
	// Обработчики событий
	//======================================================

	/**
	 * Обработчик клика по ивенту. Документация: http://fullcalendar.io/docs/mouse/eventClick/
	 *
	 * Использование: 'eventClick' => new \yii\web\JsExpression('function(event, jsEvent, view) { alert(event.title);}')
	 *
	 * @var bool
	 */
	public $eventClick = false;

	/** @var bool Обработчик начала ховера (вход мыши) */
	public $eventMouseover = false;

	/** @var bool Обработчик завершения ховера (выход мыши) */
	public $eventMouseout = false;

	//======================================================
	//======================================================
	//======================================================

	public function run()
	{
		$view = $this->getView();

		$bundle = FullCalendarAssets::register($view);

		if(!array_key_exists('id', $this->options)) $this->options['id'] = $this->getId();

		//-----------------------------------------
		if(!array_key_exists('events', $this->jsOptions))
		{
			if($this->ajaxUrl === false)
				$this->jsOptions['events'] = $this->events;
			else
			{
				$this->jsOptions['events'] = [
					'url' => $this->ajaxUrl,
					'data' => $this->ajaxData
				];
			}
		}

		if(!array_key_exists('eventLimit', $this->jsOptions)) $this->jsOptions['eventLimit'] = $this->eventLimit;
		if(!array_key_exists('defaultView', $this->jsOptions)) $this->jsOptions['defaultView'] = $this->defaultView;

		if(!array_key_exists('header', $this->jsOptions)) $this->jsOptions['header'] = $this->header;
		if(!array_key_exists('height', $this->jsOptions)) $this->jsOptions['height'] = $this->height;
		if(!array_key_exists('contentHeight', $this->jsOptions)) $this->jsOptions['contentHeight'] = $this->contentHeight;

		if(!array_key_exists('timezone', $this->jsOptions))
			$this->jsOptions['timezone'] = $this->timezone !== false ? $this->timezone : Yii::$app->timeZone;

		if(!array_key_exists('allDaySlot', $this->jsOptions)) $this->jsOptions['allDaySlot'] = $this->allDaySlot;
		if(!array_key_exists('slotEventOverlap', $this->jsOptions)) $this->jsOptions['slotEventOverlap'] = $this->slotEventOverlap;

		if(!array_key_exists('timeFormat', $this->jsOptions) && $this->timeFormat !== false) $this->jsOptions['timeFormat'] = $this->timeFormat;
		if(!array_key_exists('defaultDate', $this->jsOptions) && $this->defaultDate !== false) $this->jsOptions['defaultDate'] = $this->defaultDate;

		//-----------------------------------------
		if(!array_key_exists('eventRender', $this->jsOptions) && $this->eventRender !== false) $this->jsOptions['eventRender'] = $this->eventRender;

		//-----------------------------------------
		if(!array_key_exists('eventClick', $this->jsOptions) && $this->eventClick !== false) $this->jsOptions['eventClick'] = $this->eventClick;
		if(!array_key_exists('eventMouseover', $this->jsOptions) && $this->eventMouseover !== false) $this->jsOptions['eventMouseover'] = $this->eventMouseover;
		if(!array_key_exists('eventMouseout', $this->jsOptions) && $this->eventMouseout !== false) $this->jsOptions['eventMouseout'] = $this->eventMouseout;

		$this->jsOptions['loading'] = new JsExpression('function(isLoading, view) {
			if(isLoading)
				$("#'.$this->id.'").find("h2").append($("<img style=\"margin: 0 0 6px 10px\" src=\"'.$bundle->baseUrl.'/loading-indicator.gif\" id=fullcalloadimg />"));
			else
				$("#'.$this->id.'").find("#fullcalloadimg").remove();
		}');

		echo Html::tag('div', '', $this->options);
		$view->registerJs('$("#'.$this->id.'").fullCalendar('.Json::encode($this->jsOptions).');');
	}
}
