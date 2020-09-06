<?php

namespace edzima\teryt\components;

use edzima\teryt\models\Simc;

class SimcImporter extends Importer {

	public function init() {
		parent::init();
		$this->tableName = Simc::tableName();
		$this->strategyConfigs = [
			[
				'attribute' => 'region_id',
				'value' => static function (array $line): int {
					return $line[0];
				},
			],
			[
				'attribute' => 'district_id',
				'value' => static function (array $line): int {
					return $line[1];
				},
			],
			[
				'attribute' => 'commune_id',
				'value' => static function (array $line): int {
					return $line[2];
				},
			],
			[
				'attribute' => 'commune_type',
				'value' => static function (array $line): int {
					return $line[3];
				},
			],
			[
				'attribute' => 'city_type',
				'value' => static function (array $line): int {
					return $line[4];
				},
			],
			[
				'attribute' => 'is_common_name',
				'value' => static function (array $line): bool {
					return $line[5];
				},
			],
			[
				'attribute' => 'name',
				'value' => static function (array $line): string {
					return $line[6];
				},
			],
			[
				'attribute' => 'id',
				'value' => static function (array $line): int {
					return $line[7];
				},
			],
			[
				'attribute' => 'base_id',
				'value' => static function (array $line): int {
					return $line[8];
				},
			],
			[
				'attribute' => 'date',
				'value' => static function (array $line): string {
					return $line[9];
				},
			],
		];
	}
}
