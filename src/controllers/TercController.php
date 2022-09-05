<?php

namespace edzima\teryt\controllers;

use edzima\teryt\models\Terc;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class TercController extends Controller {

	public function actionDistrictList() {
		Yii::$app->response->format = Response::FORMAT_JSON;
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			$region_id = (int) reset($parents);
			if ($region_id > 0) {
				$output = $this->parseModels(
					Terc::find()->onlyDistricts($region_id)->all(),
					'district_id');
				return [
					'output' => $output,
					'selected' => array_key_first($output),
				];
			}
		}

		return ['output' => '', 'selected' => ''];
	}

	public function actionCommuneList() {
		Yii::$app->response->format = Response::FORMAT_JSON;
		if (isset($_POST['depdrop_parents'])) {
			$ids = $_POST['depdrop_parents'];
			$region_id = $ids[0] ? (int) $ids[0] : null;
			$district_id = $ids[1] ? (int) $ids[1] : null;
			if ($district_id <= 0) {
				$district_id = null;
			}
			if ($region_id > 0) {
				$output = $this->parseModels(
					Terc::find()->onlyCommunes($region_id, $district_id)->all(),
					'commune_id');
				return [
					'output' => $output,
					'selected' => array_key_first($output),
				];
			}
		}

		return ['output' => '', 'selected' => ''];
	}

	private function parseModels(array $models, string $key) {
		$data = [];
		foreach ($models as $model) {
			$id = $model->{$key};
			$data[$id] = [
				'id' => $id,
				'name' => $model->name,
			];
		}
		return $data;
	}

}
