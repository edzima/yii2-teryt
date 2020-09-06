<?php

namespace edzima\teryt\models;

use edzima\teryt\models\query\TercQuery;
use edzima\teryt\Module;
use yii\base\InvalidCallException;

/**
 * Class Commune
 *
 * @property-read int $region_id
 * @property-read int $district_id
 * @property-read int $commune_id
 * @property-read string $commune_type
 *
 * @property-read District $district
 * @property-read null $commune
 * @property-read null $communes
 *
 * @property-read string $communeTypeName
 *
 * @author Łukasz Wojda <lukasz.wojda@protonmail.com>
 */
class Commune extends Terc {

	public const TYPE_URBAN_COMMUNE = 1;
	public const TYPE_RURAL_COMMUNE = 2;
	public const TYPE_URBAN_RURAL_COMMUNE = 3;
	public const TYPE_CITY_IN_AN_URBAN_RURAL_COMMUNE = 4;
	public const TYPE_RURAL_AREA_IN_AN_URBAN_RURAL_COMMUNE = 5;
	public const TYPE_WARSAW_DISTRICT = 8;
	public const TYPE_CITY_DELEGATION = 9;

	public const COMMUNE_TYPES = [
		self::TYPE_URBAN_COMMUNE,
		self::TYPE_RURAL_COMMUNE,
		self::TYPE_URBAN_RURAL_COMMUNE,
	];

	public function getCommune(): TercQuery {
		throw new InvalidCallException(__METHOD__ . ' is not supported.');
	}

	public function getCommunes(): TercQuery {
		throw new InvalidCallException(__METHOD__ . ' is not supported.');
	}

	public function getDistricts(): TercQuery {
		throw new InvalidCallException(__METHOD__ . ' is not supported.');
	}

	public static function getTypesNames(): array {
		return [
			static::TYPE_URBAN_COMMUNE => Module::t('commune', 'Urban commune'),
			static::TYPE_RURAL_COMMUNE => Module::t('commune', 'Rural commune'),
			static::TYPE_URBAN_RURAL_COMMUNE => Module::t('commune', 'Urban-rural commune'),
			static::TYPE_CITY_IN_AN_URBAN_RURAL_COMMUNE => Module::t('commune', 'City in an urban-rural commune'),
			static::TYPE_RURAL_AREA_IN_AN_URBAN_RURAL_COMMUNE => Module::t('commune', 'Rural area in an urban-rural commune'),
			static::TYPE_WARSAW_DISTRICT => Module::t('commune', 'Warsaw district'),
			static::TYPE_CITY_DELEGATION => Module::t('commune', 'City delegation'),
		];
	}

	public static function find(array $types = self::COMMUNE_TYPES): TercQuery {
		return parent::find()
			->onlyCommunes()
			->andFilterWhere(['commune_type' => $types]);
	}

}
