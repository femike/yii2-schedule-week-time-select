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

		return Html::tag('table', $data, ['id' => 'schedule-week-time']);
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