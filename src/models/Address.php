<?php

namespace edzima\teryt\models;

use yii\base\Model;

/**
 * Class Address
 *
 * @property-read string $fullName
 *
 * @author Łukasz Wojda <lukasz.wojda@protonmail.com>
 */
class Address extends Model {

	public string $name;

	public string $region;

	public string $district;

	public string $commune;

	public static array $defaultRequiredFields = ['name', 'region', 'district', 'commune'];

	public array $requiredFields = [];

	public string $fullNameTemplate = '{name} ({region}, {district}, {commune}';

	/**
	 * {@inheritdoc}
	 */
	public function init(): void {
		parent::init();
		if (empty($this->requiredFields)) {
			$this->requiredFields = static::$defaultRequiredFields;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(): array {
		return [
			[$this->requiredFields, 'required'],
			[['name', 'region', 'district', 'commune'], 'string', 'max' => 128],
			[['name'], 'string', 'min' => 2],
		];
	}

	public function getFullName(): string {
		$parts = [];
		foreach ($this->attributes as $name => $value) {
			$parts['{' . $name . '}'] = $value;
		}
		return strtr($this->fullNameTemplate, $parts);
	}

}
