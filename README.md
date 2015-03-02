yii2-schedule-week-time-select
===================

## Installation

```
$ php composer.phar require femike/yii2-schedule-week-time-select "*"
```

or add

```
"femike/yii2-schedule-week-time-select": "*"
```

to the ```require``` section of your `composer.json` file.

## Usage

```php
use femike\widgets\ScheduleWeekTimeSelect;

// Select with ActiveForm & model
echo $form->field($model, 'param_name')->widget(ScheduleWeekTimeSelect::className());

```