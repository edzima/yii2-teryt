<?php

namespace tests\unit\importer;

use edzima\teryt\components\Importer;
use edzima\teryt\components\TercImporter;
use edzima\teryt\models\Commune;
use edzima\teryt\models\District;
use edzima\teryt\models\Region;
use Yii;

class TercImporterTest extends ImporterTest {

	protected function getCSVFile(): string {
		return Yii::getAlias('@tests/_data/TERC.csv');
	}

	protected function getImporter(): Importer {
		return new TercImporter();
	}

	protected function getRowsCount(): int {
		return 4194;
	}

	protected function afterImport(): void {
		parent::afterImport();
		$this->tester->assertSame(16, (int) Region::find()->count());
		$this->tester->assertSame(380, (int) District::find()->count());
		$this->tester->assertSame(314, (int) District::find()->onlyDistrictType(District::TYPE_DISTRICT)->count());
		$this->tester->assertSame(66, (int) District::find()->onlyDistrictType(District::TYPE_CITY_WITH_DISTRICT_RIGHTS)->count());
		$this->tester->assertSame(2477, (int) Commune::find()->count());
		$this->tester->assertSame(302, (int) Commune::find()->onlyCommuneTypes([Commune::TYPE_URBAN_COMMUNE])->count());
		$this->tester->assertSame(642, (int) Commune::find()->onlyCommuneTypes([Commune::TYPE_URBAN_RURAL_COMMUNE])->count());
		$this->tester->assertSame(1533, (int) Commune::find()->onlyCommuneTypes([Commune::TYPE_RURAL_COMMUNE])->count());
	}
}
