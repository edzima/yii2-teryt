<?php

namespace edzima\teryt\models;

use yii\base\Model;

class TercRegion extends Model {

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

	private int $id;
	private Terc $terc;

	private static array $MODELS;

	public function getId(): int {
		return $this->getTerc()->region_id;
	}

	public function getName(): string {
		return $this->getTerc()->name;
	}

	public function getDisticts(): array {
		return $this->getTerc()->districts;
	}

	public function getCommunes(): array {
		return $this->getTerc()->communes;
	}

	protected function setId(int $id): void {
		$this->id = $id;
	}

	protected function setTerc(Terc $terc): void {
		$this->terc = $terc;
		$this->setId($terc->region_id);
	}

	private function getTerc(): Terc {
		if ($this->terc === null || $this->terc->region_id !== $this->id) {
			$this->terc = static::createTerc($this);
		}
		return $this->terc;
	}

	public static function createTerc(self $model): Terc {
		$terc = new Terc();
		$terc->region_id = $model->getId();
		$terc->name = $model->getName();
		return $terc;
	}

	public static function getModel(int $id): ?self {
		return static::getModels()[$id] ?? null;
	}

	/**
	 * @return static[]
	 */
	public static function getModels(): array {
		if (empty(static::$MODELS)) {
			$tercModels = Terc::find()
				->indexBy('region_id')
				->onlyRegions()
				->all();
			foreach ($tercModels as $id => $model) {
				static::$MODELS[$id] = new static(['terc' => $model]);
			}
		}
		return static::$MODELS;
	}

}
