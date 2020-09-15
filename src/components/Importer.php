<?php

namespace edzima\teryt\components;

use ruskid\csvimporter\CSVImporter;
use ruskid\csvimporter\CSVReader;
use ruskid\csvimporter\ImportInterface;
use ruskid\csvimporter\MultipleImportStrategy;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Importer extends Component {

	public string $filename;
	public array $fgetcsvOptions = [
		'delimiter' => ';',
	];

	public string $tableName;
	public array $strategyConfigs = [];
	public bool $clearTable = true;

	public function import(): int {
		$importer = $this->getImporter();
		$importer->setData($this->getCSVReader());
		if ($this->clearTable) {
			Yii::$app->db->createCommand()->delete($this->tableName)->execute();
		}
		return $importer->import($this->importStrategy());
	}

	protected function getCSVReader(): CSVReader {
		if (empty($this->filename)) {
			throw new InvalidConfigException('filename must be set.');
		}
		return (new CSVReader([
			'filename' => $this->filename,
			'fgetcsvOptions' => $this->fgetcsvOptions,
		]));
	}

	protected function getImporter(): CSVImporter {
		return new CSVImporter();
	}

	protected function importStrategy(): ImportInterface {
		return new MultipleImportStrategy([
			'tableName' => $this->tableName,
			'configs' => $this->strategyConfigs,
			'skipImport' => static function (array $line): bool {
				return empty($line) || empty(reset($line));
			},
		]);
	}

}
