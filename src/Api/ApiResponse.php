<?php

namespace ElephantHub\Api;

use Yii;
use yii\helpers\Json;

class ApiResponse
{
	public static function response($code, $message, $data = null, $isExit = true)
	{
		$response = array(
			'code' => $code,
			'message' => $message,
		);
		if ($data !== null) {
			$response['data'] = $data;
		}
		echo json_encode($response);
        if ($isExit) exit;
	}
}