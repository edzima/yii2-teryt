<?php

namespace edzima\teryt\models\query;

use edzima\teryt\models\Simc;
use yii\db\ActiveQuery;
use yii\db\conditions\LikeCondition;

class SimcQuery extends ActiveQuery {

	public function withName(string $name): self {
		$this->andWhere((new LikeCondition(Simc::tableName() . '.name', 'LIKE', $name)));
		return $this;
	}

	public function startWithName(string $name): self {
		$value = $name . '%';
		$this->andWhere(['like', Simc::tableName() . '.name', $value, false]);
		return $this;
	}

	public function onlyCities(): self {
		return $this->onlyTypes([Simc::TYPE_CITY]);
	}

	public function onlyTypes(array $types) {
		$this->andWhere(['city_type' => $types]);
		return $this;
	}

	public function withoutTypes(array $types): self {
		$this->andWhere(['not in', 'city_type', $types]);
		return $this;
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @return Simc|null
	 */
	public function one($db = null): ?Simc {
		return parent::one($db); // TODO: Change the autogenerated stub
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 * @return Simc[]
	 */
	public function all($db = null): array {
		return parent::all($db); // TODO: Change the autogenerated stub
	}

}
