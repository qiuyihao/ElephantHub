<?php

namespace ElephantHub\Api;

class ApiRequest
{
	public static function paramsFilter($params)
	{
		$paramsFilter = array();
		while (list ($key, $value) = each ($params)) {
			if ($key == "r" || $key == "sign" || $value == "") {
				continue;
			} else {
				$paramsFilter[$key] = $params[$key];
			}
		}
		return $paramsFilter;
	}

	public static function paramsSort($params)
	{
		ksort($params);
		reset($params);
		return $params;
	}

	public static function createLinkString($params)
	{
		$string = "";
		while (list ($key, $val) = each($params)) {
			$string .= $key . "=" . $val . "&";
		}

		// 去掉最后一个&字符
		$string = substr($string, 0, count($string) - 2);

		// 如果存在转义字符，那么去掉转义
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}

		return $string;
	}

    public static function calculateSignature($formData, $salt)
    {
        $filterParams = self::paramsFilter($formData);
        $sortParams = self::paramsSort($filterParams);
	    $prepareParams = self::createLinkString($sortParams);
        return md5($prepareParams . $formData['timestamp'] . $salt);
	}
}