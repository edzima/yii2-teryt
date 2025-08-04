<?php

namespace edzima\teryt\models;

use edzima\teryt\models\query\TercQuery;
use edzima\teryt\Module;
use yii\base\InvalidCallException;
use yii\helpers\ArrayHelper;

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

	public const REGION_DOLNOSLASKIE = '02';
	public const REGION_KUJAWSKO_POMORSKIE = '04';
	public const REGION_LUBELSKIE = '06';
	public const REGION_LUBUSKIE = '08';
	public const REGION_LODZKIE = '10';
	public const REGION_MALOPOLSKIE = '12';
	public const REGION_MAZOWIECKIE = '14';
	public const REGION_OPOLSKIE = '16';
	public const REGION_PODKARPACKIE = '18';
	public const REGION_PODLASKIE = '20';
	public const REGION_POMORSKIE = '22';
	public const REGION_SLASKIE = '24';
	public const REGION_SWIETOKRZYSKIE = '26';
	public const REGION_WARMINSKO_MAZURSKIE = '28';
	public const REGION_WIELKOPOLSKIE = '30';
	public const REGION_ZACHODNIOPOMORSKIE = '32';

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

	public static function getNames(): array {
		return [
			static::REGION_DOLNOSLASKIE => Module::t('region', 'Lower Silesia'),
			static::REGION_KUJAWSKO_POMORSKIE => Module::t('region', 'Kuyavia-Pomerania'),
			static::REGION_LUBELSKIE => Module::t('region', 'Lublin'),
			static::REGION_LUBUSKIE => Module::t('region', 'Lubusz'),
			static::REGION_LODZKIE => Module::t('region', 'Lodz'),
			static::REGION_MALOPOLSKIE => Module::t('region', 'Lesser Poland'),
			static::REGION_MAZOWIECKIE => Module::t('region', 'Masovia'),
			static::REGION_OPOLSKIE => Module::t('region', 'Opole'),
			static::REGION_PODKARPACKIE => Module::t('region', 'Subcarpathia'),
			static::REGION_PODLASKIE => Module::t('region', 'Podlaskie'),
			static::REGION_POMORSKIE => Module::t('region', 'Pomerania'),
			static::REGION_SLASKIE => Module::t('region', 'Silesia'),
			static::REGION_SWIETOKRZYSKIE => Module::t('region', 'Holy Cross'),
			static::REGION_WARMINSKO_MAZURSKIE => Module::t('region', 'Warmia-Masuria'),
			static::REGION_WIELKOPOLSKIE => Module::t('region', 'Greater Poland'),
			static::REGION_ZACHODNIOPOMORSKIE => Module::t('region', 'West Pomerania'),
		];
	}

	public static function find(): TercQuery {
		return parent::find()
			->indexBy('region_id')
			->onlyRegions();
	}

}
