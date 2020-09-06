<?php

namespace tests\unit\importer;

use edzima\teryt\components\Importer;

abstract class ImporterTest extends \Codeception\Test\Unit {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before() {
	}

	protected function _after() {

	}

	public function testImport() {
		$importer = $this->getImporter();
		$importer->filename = $this->getCSVFile();
		$this->assertSame($this->getRowsCount(), $importer->import());
		$this->afterImport();
	}

	protected function afterImport(): void {

	}

	abstract protected function getCSVFile(): string;

	abstract protected function getImporter(): Importer;

	abstract protected function getRowsCount(): int;

}
