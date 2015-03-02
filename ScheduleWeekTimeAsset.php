<?php
namespace femike\widgets;

use yii\web\AssetBundle;

/**
 * Class ScheduleWeekTimeAsset
 * @package femike\widgets
 */
class ScheduleWeekTimeAsset extends AssetBundle
{
	public $sourcePath;
	public $css = [
		'schedule.css',
	];
	public $js = [
		'jquery.schedule.js'
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];

	public function init()
	{
		$this->sourcePath = __DIR__ .'/lib';
	}
}
