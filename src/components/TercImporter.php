<?php

namespace edzima\teryt\components;

use edzima\teryt\models\Terc;

class TercImporter extends Importer {

	public function init(): void {
		parent::init();
		$this->tableName = Terc::tableName();
		$this->strategyConfigs = [
			[
				'attribute' => 'region_id',
				'value' => static function (array $line): int {
					return $line[0];
				},
			],
			[
				'attribute' => 'district_id',
				'value' => static function (array $line): ?int {
					return $line[1] ? (int) $line[1] : null;
				},
			],
			[
				'attribute' => 'commune_id',
				'value' => static function (array $line): ?int {
					return $line[2] ? (int) $line[2] : null;
				},
			],
			[
				'attribute' => 'commune_type',
				'value' => static function (array $line): ?int {
					return $line[3] ? (int) $line[3] : null;
				},
			],
			[
				'attribute' => 'name',
				'value' => static function (array $line): string {
					return $line[4];
				},
			],
			[
				'attribute' => 'date',
				'value' => static function (array $line): string {
					return $line[6];
				},
			],
		];
	}
}
