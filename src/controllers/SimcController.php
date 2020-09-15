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
				->withName($q)
				->with(['terc.district'])
				->limit(static::CITY_LIST_LIMIT)
				->orderBy([
					'commune_type' => SORT_ASC,
				])
				->all();
			ArrayHelper::multisort($models, ['commune_type', 'isIndependent'], [SORT_ASC, SORT_DESC]);
			foreach ($models as $model) {
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

	protected function parseSimc(Simc $model): array {
		return [
			'id' => $model->id,
			'text' => $model->nameWithRegionAndDistrict,
		];
	}

}
