<?php

use Codeception\Util\Debug;
use edzima\teryt\models\Commune;

class CommuneTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	public function testExistedCommune() {
		$model = Commune::find()->withName('Lębork')->one();
		$this->tester->assertSame(Commune::getTypesNames()[Commune::TYPE_URBAN_COMMUNE], $model->getCommuneTypeName());
		$this->tester->assertNotNull($model);
		$this->tester->assertSame('POMORSKIE', $model->region->name);
		$this->tester->assertSame('lęborski', $model->district->name);
		foreach ($model->communes as $commune) {
			Debug::debug($commune->attributes);
		}

		$this->tester->assertSame(0, (int) $model->getCommunes()->count());
		$this->tester->assertSame(2, (int) $model->getSimc()->onlyCities()->count());
	}

}
