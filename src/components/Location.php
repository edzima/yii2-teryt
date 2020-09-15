<?php

namespace edzima\teryt\components;

use edzima\teryt\models\Simc;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class Location extends Component {

	public int $minSearchNameLength = 3;
	public int $limit = 40;
	public array $with = ['terc.district'];

	public function findCities(string $name): array {
		if (strlen($name) < $this->minSearchNameLength) {
			return [];
		}
		return Simc::find()
			->withName($name)
			->with($this->with)
			->limit($this->limit)
			->orderBy([
				'commune_type' => SORT_ASC,
			])
			->all();
		ArrayHelper::multisort($models, ['commune_type', 'isIndependent'], [SORT_ASC, SORT_DESC]);
		return $models;
	}
}
