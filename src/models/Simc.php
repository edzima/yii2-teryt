<?php

namespace edzima\teryt\models;

use edzima\teryt\models\query\SimcQuery;
use edzima\teryt\models\query\TercQuery;
use edzima\teryt\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "teryt_simc".
 *
 * @property int $id
 * @property int $base_id
 * @property int $region_id
 * @property int $district_id
 * @property int $commune_id
 * @property int $commune_type
 * @property int $city_type
 * @property int $is_common_name
 * @property string $name
 * @property string $date
 *
 * @property-read string $typeName
 * @property-read Terc $terc
 * @property-read Region $region
 * @property-read bool $isIndependent
 *
 * @property-read Address
 * @property-read string $nameWithRegionAndDistrict
 */
class Simc extends ActiveRecord {

	public const TYPE_TOWN_PART = 00;
	public const TYPE_VILLAGE = 01;
	public const TYPE_COLOGNE = 02;
	public const TYPE_HAMLET = 03;
	public const TYPE_SETTLEMENT = 04;
	public const TYPE_FOREST_SETTLEMENT = 05;
	public const TYPE_ESTATE = 06;
	public const TYPE_TOURIST_HOSTEL = 07;
	public const TYPE_DISTRICT_OF_WARSAW = 95;
	public const TYPE_CITY = 96;
	public const TYPE_DELEGATION = 98;
	public const TYPE_CITY_PART = 99;

	public function getAddress(): Address {
		$address = $this->terc->getAddress();
		$address->cityId = $this->id;
		$address->name = $this->name;
		return $address;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string {
		return '{{%teryt_simc}}';
	}

	public function getNameWithRegionAndDistrict(): string {
		return $this->name . ' (' . $this->terc->region . ', ' . $this->terc->district->name . ')';
	}

	public function getTypeName(): string {
		return static::getTypesNames()[$this->city_type];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['id', 'region_id', 'district_id', 'commune_id', 'commune_type', 'city_type', 'is_common_name', 'name', 'date'], 'required'],
			[['id', 'region_id', 'district_id', 'commune_id', 'commune_type', 'city_type', 'is_common_name'], 'integer'],
			[['date'], 'safe'],
			[['name'], 'string', 'max' => 100],
			['type']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array {
		return [
			'id' => 'Id',
			'base_id' => Module::t('common', 'Base ID'),
			'region_id' => Module::t('common', 'Region'),
			'district_id' => Module::t('common', 'District'),
			'commune_id' => Module::t('common', 'Commune'),
			'commune_type' => Module::t('common', 'Commune type'),
			'city_type' => Module::t('common', 'City type'),
			'is_common_name' => Module::t('common', 'Is common name'),
			'name' => Module::t('common', 'Commune'),
			'date' => Module::t('common', 'Date at'),
		];
	}

	public function getIsIndependent(): bool {
		return $this->id === $this->base_id;
	}

	public function getTerc(): TercQuery {
		return $this->hasOne(Terc::class, [
			'region_id' => 'region_id',
			'district_id' => 'district_id',
			'commune_id' => 'commune_id',
			'commune_type' => 'commune_type',
		]);
	}

	public function getRegion(): Region {
		return Region::getModel($this->region_id);
	}

	/**
	 * {@inheritdoc}
	 * @return SimcQuery
	 */
	public static function find(): SimcQuery {
		return new SimcQuery(static::class);
	}

	public static function getTypesNames(): array {
		return [
			static::TYPE_TOWN_PART => Module::t('simc', 'Town part'),
			static::TYPE_VILLAGE => Module::t('simc', 'Village'),
			static::TYPE_COLOGNE => Module::t('simc', 'Cologne'),
			static::TYPE_HAMLET => Module::t('simc', 'Hamlet'),
			static::TYPE_SETTLEMENT => Module::t('simc', 'Settlement'),
			static::TYPE_FOREST_SETTLEMENT => Module::t('simc', 'Forest settlement'),
			static::TYPE_ESTATE => Module::t('simc', 'Estate'),
			static::TYPE_TOURIST_HOSTEL => Module::t('simc', 'Tourist hostel'),
			static::TYPE_DISTRICT_OF_WARSAW => Module::t('simc', 'District of Warsaw'),
			static::TYPE_CITY => Module::t('simc', 'City'),
			static::TYPE_DELEGATION => Module::t('simc', 'Delegation'),
			static::TYPE_CITY_PART => Module::t('simc', 'City part'),
		];
	}

}
