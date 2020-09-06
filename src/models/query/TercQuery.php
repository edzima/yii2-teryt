<?php

namespace edzima\teryt\models\query;

use edzima\teryt\models\District;
use yii\db\ActiveQuery;
use yii\db\conditions\LikeCondition;

class TercQuery extends ActiveQuery {

	public function withName(string $name): self {
		$this->andWhere((new LikeCondition('name', 'LIKE', $name)));
		return $this;
	}

	public function onlyRegion(int $id): self {
		$this->andWhere(['region_id' => $id]);
		return $this;
	}

	public function onlyRegions(): self {
		$this->andWhere([
			'district_id' => null,
			'commune_id' => null,
		]);
		return $this;
	}

	public function onlyDistrict(int $region, int $district): self {
		$this->onlyRegion($region);
		$this->andWhere(['district_id' => $district]);
		return $this;
	}

	public function onlyDistricts(int $region = null): self {
		if ($region !== null) {
			$this->onlyRegion($region);
		}
		$this->andWhere(['IS NOT', 'district_id', null]);
		$this->andWhere([
			'commune_id' => null,
		]);
		return $this;
	}

	public function onlyDistrictType(string $type): self {
		switch ($type) {
			case District::TYPE_DISTRICT:
				$this->andWhere(['<', 'district_id', District::MIN_CITY_WITH_DISTRICT_RIGHTS_ID]);
				break;
			case District::TYPE_CITY_WITH_DISTRICT_RIGHTS:
				$this->andWhere(['>=', 'district_id', District::MIN_CITY_WITH_DISTRICT_RIGHTS_ID]);
				break;
		}
		return $this;
	}

	public function onlyCommune(int $region, int $district, int $type = null): self {
		$this->onlyDistrict($region, $district);
		$this->andFilterWhere(['commune_type' => $type]);
		return $this;
	}

	public function onlyCommunes(int $region = null, int $district = null): self {
		if ($region !== null) {
			$this->onlyRegion($region);
			if ($district !== null) {
				$this->onlyDistrict($region, $district);
			}
		}
		$this->andWhere(['IS NOT', 'commune_id', null]);
		$this->andWhere(['IS NOT', 'commune_type', null]);

		return $this;
	}

	public function onlyCommuneTypes(array $types): self {
		$this->andWhere(['commune_type' => $types]);
		return $this;
	}

	protected function createModels($rows): array {
		if ($this->asArray) {
			return $rows;
		}
		return $rows;
	}
}
