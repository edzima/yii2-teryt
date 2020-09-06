<?php

namespace edzima\teryt\commands\actions;

use edzima\teryt\components\Importer;
use yii\base\Action;
use yii\console\ExitCode;
use yii\helpers\Console;

class ImporterAction extends Action {

	/**
	 * @var Importer
	 */
	public $importer;

	public function run(string $fileName): int {
		$this->importer->filename = $fileName;
		Console::output('Imported ' . $this->importer->import() . ' models.');
		return ExitCode::OK;
	}
}
