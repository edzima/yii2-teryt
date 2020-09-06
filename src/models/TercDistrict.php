<?php

namespace edzima\teryt\models;

use edzima\teryt\models\query\TercQuery;
use edzima\teryt\Module;

class TercDistrict extends Model {

	public const MIN_CITY_WITH_DISTRICT_RIGHTS_ID = 61;
	public const TYPE_DISTRICT = 'district';
	public const TYPE_CITY_WITH_DISTRICT_RIGHTS = 'city-with-district-rights';

	private Terc $terc;

	public function getId(): int {
		return $this->terc->district_id;
	}

	public function getName(): string {
		return $this->terc->name;
	}

	public function getRegion(): Region {
		return Region::getModel($this->terc->region_id);
	}

	public function getCommunes(): array {
		return $this->getTerc()->communes;
	}

	public function getTypeName(): string {
		if ($this->getId() < static::MIN_CITY_WITH_DISTRICT_RIGHTS_ID) {
			return static::getTypesNames()[static::TYPE_DISTRICT];
		}
		return static::getTypesNames()[static::TYPE_CITY_WITH_DISTRICT_RIGHTS];
	}

	public static function getTypesNames(): array {
		return [
			static::TYPE_DISTRICT => Module::t('district', 'District'),
			static::TYPE_CITY_WITH_DISTRICT_RIGHTS => Module::t('district', 'City with district rights'),
		];
	}

	public static function find(): TercQuery {
		return Terc::find()
			->onlyDistricts()
			->indexBy('district_id');
	}

}
