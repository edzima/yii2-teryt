<?php

use edzima\teryt\models\Simc;

class SimcTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	public function testTerc() {
		$models = Simc::find()->onlyCities()->withName('Lębork')->all();
		$this->tester->assertCount(1, $models);
		/** @var Simc $model */
		$model = reset($models);
		$terc = $model->terc;
		$this->tester->assertSame('Lębork', $terc->commune->name);
		$this->tester->assertSame('lęborski', $terc->district->name);
	}

}
