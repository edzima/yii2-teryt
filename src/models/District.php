<?php

namespace edzima\teryt\models;

use edzima\teryt\models\query\TercQuery;
use edzima\teryt\Module;

/**
 * Class District
 *
 * @author Łukasz Wojda <lukasz.wojda@protonmail.com>
 *
 * @property-read string $typeName
 * @property-read int $id
 *
 * @property-read int $region_id
 * @property-read int $district_id
 * @property-read null $commune_id
 * @property-read null $commune_type
 *
 * @property-read null $district
 * @property-read null $commune
 */
class District extends Terc {

	public const MIN_CITY_WITH_DISTRICT_RIGHTS_ID = 61;
	public const TYPE_DISTRICT = 'district';
	public const TYPE_CITY_WITH_DISTRICT_RIGHTS = 'city-with-district-rights';

	public function getId(): int {
		return $this->district_id;
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
		return parent::find()
			->onlyDistricts()
			->indexBy('district_id');
	}

}
