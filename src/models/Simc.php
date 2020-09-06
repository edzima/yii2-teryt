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
 * @property-read string $communeTypeName
 * @property-read Terc $terc
 * @property-read Region $region
 * @property-read bool $isIndependent
 *
 * @property-read Address
 */
class Simc extends ActiveRecord {

	public const TYPE_TOWN_PART = 00;// część miejscowości
	public const TYPE_VILLAGE = 01;// wieś
	public const TYPE_COLOGNE = 02;// kolonia
	public const TYPE_HAMLET = 03;// przysiółek
	public const TYPE_SETTLEMENT = 04; //osada
	public const TYPE_FOREST_SETTLEMENT = 05;// osada leśna
	public const TYPE_ESTATE = 06;//osiedle
	public const TYPE_TOURIST_HOSTEL = 07;//schronisko turystyczne
	public const TYPE_DISTRICT_OF_WARSAW = 95;//dzielnica m. st. Warszawy
	public const TYPE_CITY = 96;//miasto
	public const TYPE_DELEGATION = 98;//delegatura
	public const TYPE_CITY_PART = 99;// część miasta

	public function getAddress(): Address {
		$address = $this->terc->getAddress();
		$address->name = $this->name;
		return $address;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string {
		return '{{%teryt_simc}}';
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

	public static function find(): SimcQuery {
		return new SimcQuery(static::class);
	}

}
