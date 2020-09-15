<?php

declare(strict_types=1);

namespace edzima\teryt;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\console\Application as ConsoleApplication;

/**
 * Class Module
 *
 * @author Łukasz Wojda <lukasz.wojda@protonmail.com>
 */
class Module extends BaseModule implements BootstrapInterface {

	public $controllerNamespace = 'edzima\teryt\controllers';

	public function bootstrap($app) {
		Yii::setAlias('@edzima/teryt', __DIR__);
		if ($app instanceof ConsoleApplication) {
			$this->controllerNamespace = 'edzima\teryt\commands';
		}
	}

	public function init() {
		parent::init();
		$this->registerTranslations();
	}

	public function registerTranslations(): void {
		Yii::$app->i18n->translations['edzima/teryt/*'] = [
			'class' => 'yii\i18n\PhpMessageSource',
			'sourceLanguage' => 'en-US',
			'basePath' => '@edzima/teryt/messages',
			'fileMap' => [
				'edzima\teryt\commune' => 'commune.php',
				'edzima\teryt\common' => 'common.php',
				'edzima\teryt\simc' => 'simc.php',
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function t($category, $message, $params = [], $language = null) {
		return Yii::t('edzima/teryt/' . $category, $message, $params, $language);
	}

}
