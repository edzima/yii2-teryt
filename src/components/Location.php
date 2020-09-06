<?php

namespace edzima\teryt\components;

use edzima\teryt\models\Simc;
use yii\base\Component;

class Location extends Component {

	public function findCities(string $name): array {
		return Simc::find()->withName($name)->all();
	}
}
