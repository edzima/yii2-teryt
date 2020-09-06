<?php

declare(strict_types=1);

namespace edzima\teryt\migrations;

use yii\db\Migration as BaseMigration;

/**
 * Class Migration
 *
 * @author Łukasz Wojda <lukasz.wojda@protonmail.com>
 */
class Migration extends BaseMigration {

	/**
	 * {@inheritDoc}
	 */
	public function createTable($table, $columns, $options = null): void {
		if ($this->db->driverName === 'mysql') {
			$options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		parent::createTable($table, $columns, $options);
	}
}
