<?php

namespace edzima\teryt\controllers;

use edzima\teryt\models\Region;
use yii\rest\Controller;

class RegionController extends Controller {

	public function actionIndex(): array {
		return Region::find()
			->select(['region_id', 'name'])
			->indexBy('region_id')
			->asArray()
			->all();
	}
}
