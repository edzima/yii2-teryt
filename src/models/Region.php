<?php

namespace edzima\teryt\models;

use edzima\teryt\models\query\TercQuery;
use yii\base\InvalidCallException;
use yii\base\NotSupportedException;

/**
 * Class Region
 *
 * @author Łukasz Wojda <lukasz.wojda@protonmail.com>
 *
 * @property-read int $region_id
 * @property-read null $district_id
 * @property-read null $commune_id
 * @property-read null $commune_type
 * @property-read null $region
 * @property-read null $district
 * @property-read null $commune
 */
class Region extends Terc {

	public const REGION_DOLNOSLASKIE = 2;
	public const REGION_KUJAWSKO_POMORSKIE = 4;
	public const REGION_LUBELSKIE = 6;
	public const REGION_LUBUSKIE = 8;
	public const REGION_LODZKIE = 10;
	public const REGION_MALOPOLSKIE = 12;
	public const REGION_MAZOWIECKIE = 14;
	public const REGION_OPOLSKIE = 16;
	public const REGION_PODKARPACKIE = 18;
	public const REGION_PODLASKIE = 20;
	public const REGION_POMORSKIE = 22;
	public const REGION_SLASKIE = 24;
	public const REGION_SWIETOKRZYSKIE = 26;
	public const REGION_WARMINSKO_MAZURSKIE = 28;
	public const REGION_WIELKOPOLSKIE = 30;
	public const REGION_ZACHODNIOPOMORSKIE = 32;

	private static array $MODELS;

	public function getDistricts(): TercQuery {
		return $this->hasMany(District::class, ['region_id' => 'region_id']);
	}

	public function getCommunes(): TercQuery {
		return $this->hasMany(Commune::class, ['region_id' => 'region_id']);
	}

	public function getCommune(): TercQuery {
		throw new InvalidCallException(__METHOD__ . ' is not supported.');
	}

	public static function getModel(int $id): ?self {
		return static::getModels()[$id] ?? null;
	}

	/**
	 * @return static[]
	 */
	public static function getModels(): array {
		if (empty(static::$MODELS)) {
			static::$MODELS = static::find()
				->all();
		}
		return static::$MODELS;
	}

	public static function find(): TercQuery {
		return parent::find()
			->indexBy('region_id')
			->onlyRegions();
	}

}
