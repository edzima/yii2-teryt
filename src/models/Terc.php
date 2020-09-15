<?php

namespace edzima\teryt\models;

use edzima\teryt\models\query\SimcQuery;
use edzima\teryt\models\query\TercQuery;
use edzima\teryt\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "teryt_terc".
 *
 * @property int $region_id
 * @property int|null $district_id
 * @property int|null $commune_id
 * @property int|null $commune_type
 * @property string $name
 * @property string $date
 *
 * @property-read string|null $communeTypeName
 * @property-read Region $region
 * @property-read Commune|null $commune
 * @property-read District|null $district
 * @property-read District[] $districts
 * @property-read Commune[] $communes
 * @property-read Simc[] $simc
 */
class Terc extends ActiveRecord {

	public function __toString(): string {
		return $this->name;
	}

	public function getAddress(): Address {
		return new Address([
			'region' => $this->region->name,
			'district' => $this->commune !== null ?: $this->district->name,
			'commune' => $this->commune !== null ?: $this->commune->name,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(): string {
		return '{{%teryt_terc}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[['region_id', 'name', 'date'], 'required'],
			[['region_id', 'district_id', 'commune_id', 'commune_type'], 'integer'],
			[['date'], 'safe'],
			[['name'], 'string', 'max' => 100],
			[['region_id', 'district_id', 'commune_id', 'commune_type'], 'unique', 'targetAttribute' => ['region_id', 'district_id', 'commune_id', 'commune_type']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(): array {
		return [
			'region_id' => Module::t('common', 'Region'),
			'district_id' => Module::t('common', 'District'),
			'commune_id' => Module::t('common', 'Commune'),
			'commune_type' => Module::t('common', 'Commune type'),
			'name' => Module::t('common', 'Name'),
			'date' => Module::t('common', 'Date at'),
		];
	}

	public function getCommuneTypeName(): ?string {
		return Commune::getTypesNames()[$this->commune_type] ?? null;
	}

	public function getRegion(): Region {
		return Region::getModel($this->region_id);
	}

	public function getDistricts(): TercQuery {
		return $this->hasMany(District::class, ['region_id' => 'region_id']);
	}

	public function getDistrict(): ?TercQuery {
		if ($this->hasDistrict()) {
			return $this->hasOne(District::class, [
				'region_id' => 'region_id',
				'district_id' => 'district_id',
			]);
		}
		return null;
	}

	public function hasDistrict(): bool {
		return !empty($this->district_id);
	}

	public function getCommunes(): TercQuery {
		return $this->hasMany(Commune::class, [
			'region_id' => 'region_id',
			'district_id' => 'district_id',
		]);
	}

	public function getCommune(): TercQuery {
		return $this->hasOne(Commune::class, [
			'region_id' => 'region_id',
			'district_id' => 'district_id',
			'commune_id' => 'commune_id',
			'commune_type' => 'commune_type',
		]);
	}

	public function getSimc(): ?SimcQuery {
		if ($this->hasDistrict()) {
			return $this->hasMany(Simc::class, [
				'region_id' => 'region_id',
				'district_id' => 'district_id',
			]);
		}
		return null;
	}

	public static function find(): TercQuery {
		return new TercQuery(static::class);
	}

}
