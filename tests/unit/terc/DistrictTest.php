<?php

use edzima\teryt\models\District;

class DistrictTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	public function testExistedDistrict() {
		$district = District::find()->withName('Leborski')->one();
		$this->tester->assertNotNull($district);
		$this->tester->assertSame('POMORSKIE', $district->region->name);
		$this->tester->assertSame(5, (int) $district->getCommunes()->count());
		$this->tester->assertSame(2, (int) $district->getSimc()->onlyCities()->count());
	}

}
