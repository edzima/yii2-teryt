<?php

use edzima\teryt\models\Commune;
use edzima\teryt\models\District;
use edzima\teryt\models\Region;

class RegionTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	public function testGetDistrict(): void {
		foreach (Region::getModels() as $region) {
			$this->tester->assertNull($region->district);
			$this->tester->assertNull($region->getDistrict());
		}
	}

	/**
	 * @dataProvider regionsDataProvider
	 * @param int $regionId
	 * @param int $districtCount
	 * @param int $districtCityCount
	 * @param int $communesCount
	 * @param int $urbanCommuneCount
	 */
	public function testRegionsStats(int $regionId, int $districtCount, int $districtCityCount, int $communesCount, int $urbanCommuneCount) {
		$region = Region::getModel($regionId);
		$this->tester->assertCount($districtCount, $region->districts);
		$this->tester->assertSame($districtCityCount, (int) $region->getDistricts()->onlyDistrictType(District::TYPE_CITY_WITH_DISTRICT_RIGHTS)->count());
		$this->tester->assertCount($communesCount, $region->communes);
		$this->tester->assertSame($urbanCommuneCount, (int) $region->getCommunes()->onlyCommuneTypes([Commune::TYPE_URBAN_COMMUNE])->count());
	}

	public function regionsDataProvider() {
		return [
			'Mazowieckie' => [
				Region::REGION_MAZOWIECKIE,
				42,
				5,
				314,
				35,
			],
			'Pomorskie' => [
				Region::REGION_POMORSKIE,
				20,
				4,
				123,
				22,
			],
		];
	}
}
