<?php

namespace tests\unit\importer;

use edzima\teryt\components\Importer;
use edzima\teryt\components\SimcImporter;
use edzima\teryt\models\Simc;
use Yii;

class SimcImporterTest extends ImporterTest {

	protected function getCSVFile(): string {
		return Yii::getAlias('@tests/_data/SIMC.csv');
	}

	protected function getImporter(): Importer {
		return new SimcImporter();
	}

	public function afterImport(): void {
		parent::afterImport();
		$this->tester->assertSame(944, (int) Simc::find()->onlyCities()->count());
	}

	protected function getRowsCount(): int {
		return 102913;
	}
}

