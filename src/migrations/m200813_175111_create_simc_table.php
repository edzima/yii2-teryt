<?php

use edzima\teryt\migrations\Migration;

class m200813_175111_create_simc_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable('{{%teryt_simc}}', [
			'id' => $this->primaryKey(),
			'base_id' => $this->integer()->notNull(),
			'region_id' => $this->smallInteger()->notNull(),
			'district_id' => $this->smallInteger()->notNull(),
			'commune_id' => $this->smallInteger()->notNull(),
			'commune_type' => $this->smallInteger()->notNull(),
			'city_type' => $this->smallInteger()->notNull(),
			'is_common_name' => $this->boolean()->notNull(),
			'name' => $this->string(100)->notNull(),
			'date' => $this->date()->notNull(),
		]);

		$this->createIndex('{{%fk_teryt_simc_region}}', '{{%teryt_simc}}', 'region_id');
		$this->createIndex('{{%fk_teryt_simc_district}}', '{{%teryt_simc}}', 'district_id');
		$this->createIndex('{{%fk_teryt_simc_commune}}', '{{%teryt_simc}}', 'commune_id');

		$this->createIndex('{{%fk_teryt_simc_name}}', '{{%teryt_simc}}', 'name');
		$this->createIndex('{{%fk_teryt_simc_commune_type}}', '{{%teryt_simc}}', 'commune_type');
		$this->createIndex('{{%fk_teryt_simc_city_type}}', '{{%teryt_simc}}', 'city_type');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable('{{%teryt_simc}}');
	}
}
