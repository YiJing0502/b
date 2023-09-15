<?php

/**
 * 回傳給前端固定格式的物件
 * @param mixed $rt_data 要回傳給前端的資料
 * @param integer $rt_code 要回傳給前端的結果代碼(0:失敗；1:成功)
 * @param string $rt_message 要回傳給前端的結果訊息
 * @return object 回傳固定格式的物件
 */
function rtFormat($data = [], $code = 1, $message = '執行成功')
{
    $status = [0, 1];
    if (!is_int($code) || !in_array($code, $status) || !is_string($message)) {
        throw new Exception('rt_format函式傳入參數錯誤');
    }

    $format = (object)[
        'rt_code' => $code,
        'rt_message' => $message,
        'rt_data' => $data,
    ];

    return $format;
}
