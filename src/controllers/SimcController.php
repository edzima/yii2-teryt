<?php

namespace edzima\teryt\controllers;

use edzima\teryt\models\Simc;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class SimcController extends Controller {

	public const MIN_QUERY_LENGTH = 3;
	protected const CITY_LIST_LIMIT = 30;

	public function actionCityList(string $q = null, int $id = null): Response {
		$out = ['results' => ['id' => '', 'text' => '']];
		if (!is_null($q) && strlen($q) >= static::MIN_QUERY_LENGTH) {
			$models = Simc::find()
				->startWithName($q)
				->with(['terc.district'])
				->limit(static::CITY_LIST_LIMIT)
				->orderBy([
					'commune_type' => SORT_ASC,
				])
				->all();
			foreach ($this->sortModels($models, $q) as $model) {
				$city[] = $this->parseSimc($model);
			}
			$out['results'] = $city;
		} elseif ($id > 0) {
			$model = Simc::find()
				->with(['terc.district'])
				->andWhere(['id' => $id])
				->one();
			if ($model) {
				$out['results'] = $this->parseSimc($model);
			}
		}
		return $this->asJson($out);
	}

	protected function sortModels(array $models, string $search): array {
		ArrayHelper::multisort($models, ['commune_type', 'isIndependent'], [SORT_ASC, SORT_DESC]);

		$search = strtolower($search);

		usort($models, static function (Simc $a, Simc $b) use ($search) {
			$aName = strtolower($a->name);
			$bName = strtolower($b->name);
			if ($aName === $search && $bName === $search) {
				return 0;
			}
			if ($aName === $search) {
				return -1;
			}
			return 1;
		});
		return $models;
	}

	protected function parseSimc(Simc $model): array {
		return [
			'id' => $model->id,
			'text' => $model->nameWithRegionAndDistrict,
		];
	}

}
