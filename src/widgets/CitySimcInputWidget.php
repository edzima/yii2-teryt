<?php

namespace edzima\teryt\widgets;

use edzima\teryt\models\Simc;
use edzima\teryt\Module;
use kartik\select2\Select2;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Class CitySimcInputWidget
 *
 * @author Łukasz Wojda <lukasz.wojda@protonmail.com>
 */
class CitySimcInputWidget extends Select2 {

	public string $cityProperty = 'city';
	public array $cityListRoute = ['/teryt/simc/city-list'];

	public function init() {
		$module = Module::getInstance();
		if ($module === null) {
			throw new InvalidConfigException('Teryt Module must be configured.');
		}
		$minLength = $module->minLengthCityListQuery;

		if (!isset($this->options['placeholder'])) {
			$this->options['placeholder'] = Module::t('common', 'Search for a city...');
		}
		if (!isset($this->initValueText) && $this->model->{$this->attribute} !== null) {
			$city = $this->model->{$this->cityProperty};
			if ($city instanceof Simc) {
				$this->initValueText = $city->nameWithRegionAndDistrict;
			}
		}
		if (empty($this->pluginOptions)) {
			$this->pluginOptions = [
				'allowClear' => true,
				'minimumInputLength' => $minLength,
				'language' => [
					'errorLoading' => new JsExpression("function () { return '"
						. Module::t('common', 'Waiting for results...')
						. "'; }"),
				],
				'ajax' => [
					'url' => Url::to($this->cityListRoute),
					'dataType' => 'json',
					'data' => new JsExpression('function(params) { return {q:params.term}; }'),
				],
				'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
				'templateResult' => new JsExpression('function(city) { return city.text; }'),
				'templateSelection' => new JsExpression('function (city) { return city.text; }'),
			];
		}

		parent::init();
	}
}
