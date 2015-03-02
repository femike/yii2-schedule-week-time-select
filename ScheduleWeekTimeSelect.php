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

	public function renderTime($day, $data, $options = [])
	{
		$return = '';
		for ($i = 0; $i < 24; $i++) {
			$return .= Html::tag('td', $data, array_merge(['data' => ['time' => $i, 'day' => $day]], $options));
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
			$options = $this->options ?: [];
			$data = Html::input('hidden', $this->attribute, $this->model->getAttribute($this->attribute), $options);
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

	protected function registerAssetBundle() {
		ScheduleWeekTimeAsset::register($this->getView());
	}

	public function registerAssets()
	{
		$this->registerAssetBundle();
	}
}