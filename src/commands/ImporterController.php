<?php

namespace edzima\teryt\commands;

use edzima\teryt\commands\actions\ImporterAction;
use edzima\teryt\components\SimcImporter;
use edzima\teryt\components\TercImporter;
use yii\console\Controller;

/**
 * Importer for TERYT parts from CSV.
 *
 * @author Łukasz Wojda <lukasz.wojda@protonmail.com>
 */
class ImporterController extends Controller {

	public function actions(): array {
		return [
			'terc' => [
				'class' => ImporterAction::class,
				'importer' => (new TercImporter()),
			],
			'simc' => [
				'class' => ImporterAction::class,
				'importer' => (new SimcImporter()),
			],
		];
	}
}
