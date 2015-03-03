<?php
namespace femike\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class ScheduleWeekTimeSelect extends Widget
{
	public $model;
	public $attribute;
	public $options;

	public function init()
	{
		if (empty($this->options['id'])) {
			$this->options['id'] = Html::getInputId($this->model, $this->attribute);
		}
	}

	public function renderTime($day, $data, $options = [])
	{
		$return = '';
		for ($i = 0; $i < 24; $i++) {
			$return .= Html::tag('td', $data, array_merge([
				'class' => 'schedule',
				'data' => ['time' => $i, 'day' => $day, 'value' => $day . '_' . $i]
			], $options));
		}

		return $return;
	}

	public function renderTable()
	{
		$second_day = 24 * 60 * 60;
		$weekday = (int)date('N', time());
		$monday = time() - ($weekday - 1) * $second_day;
		$data = '';

		if ($this->model && $this->attribute) {
			$options = isset($this->options['inputOptions']) ? $this->options['inputOptions'] : [];
			$data = Html::activeInput('hidden', $this->model, $this->attribute, $options);
		}

		for ($i = 0; $i < 7; $i++) {
			$weekday = Yii::$app->getFormatter()->asDate($monday + $i * $second_day, 'php:D');
			$data .= Html::beginTag('tr', ['data' => ['day' => $i, 'title' => $weekday]]);
			$data .= Html::tag('td', $weekday, ['class' => 'weekday']);
			$data .= $this->renderTime($i, '-');
			$data .= Html::endTag('tr');
		}
		$data .= Html::beginTag('tr');
		$data .= Html::tag('td', '', ['class' => 'weekday']);
		for ($i = 0; $i < 24; $i++):
			$data .= Html::tag('td', (($i <= 9) ? '&nbsp;' . $i : $i) . ':00 ' . ((($i + 1) <= 9) ? '&nbsp;' . ($i + 1) : ($i + 1)) . ':00', ['class' => 'time']);
		endfor;
		$data .= Html::endTag('tr');

		$return = Html::tag('div', '', ['class' => 'clearfix']);
		$return .= $this->renderButtons();
		$return .= Html::tag('div', Html::tag('table', $data, ['id' => 'schedule-week-time']), ['class' => 'col-sm-10']);
		unset($data);

		return $return;
	}

	private function renderButtons()
	{
		$data = Html::beginTag('div', ['class' => 'col-sm-12', 'id' => 'schedule-buttons']);

		$data .= Html::a('Круглосуточно', '#schedule-week-time', ['id' => 'around-the-clock']);
		$data .= Html::a('Будни', '#schedule-week-time', ['id' => 'weekdays']);
		$data .= Html::a('Рабочее время', '#schedule-week-time', ['id' => 'working-hours']);
		$data .= Html::a('Выходные', '#schedule-week-time', ['id' => 'weekend']);

		$data .= Html::endTag('div');

		return $data;
	}

	public function run()
	{
		$this->registerAssets();

		return $this->renderTable();
	}

	protected function registerAssetBundle()
	{
		ScheduleWeekTimeAsset::register($this->getView());
	}

	public function registerAssets()
	{
		$view = $this->getView();
		$js = 'jQuery("#schedule-week-time").data({attribute: "#' . $this->options['id'] . '"});';
		$view->registerJs($js);
		$js = 'jQuery("#' . $this->options['id'] . '").shchedule().setSelection();';
		$view->registerJs($js);
		$this->registerAssetBundle();
	}
}