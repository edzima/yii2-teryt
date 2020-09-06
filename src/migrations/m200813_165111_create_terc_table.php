<?php

use edzima\teryt\migrations\Migration;

class m200813_165111_create_terc_table extends Migration {

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {

		$this->createTable('{{%teryt_terc}}', [
			'region_id' => $this->smallInteger()->notNull(),
			'district_id' => $this->smallInteger(),
			'commune_id' => $this->smallInteger(),
			'commune_type' => $this->smallInteger(),
			'name' => $this->string(100)->notNull(),
			'date' => $this->date()->notNull(),
		]);

		$this->createIndex('{{%fk_teryt_terc_region}}', '{{%teryt_terc}}', 'region_id');
		$this->createIndex('{{%fk_teryt_terc_district}}', '{{%teryt_terc}}', 'district_id');
		$this->createIndex('{{%fk_teryt_terc_commune}}', '{{%teryt_terc}}', 'commune_id');

		$this->createIndex('{{%fk_teryt_terc_commune_type}}', '{{%teryt_terc}}', 'commune_type');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable('{{%teryt_terc}}');
	}
}
