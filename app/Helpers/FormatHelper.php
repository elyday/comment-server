<?php

namespace App\Helper;

/**
 * Class FormatHelper
 * @package App\Helper
 * @author Lars <me@elyday.net> Riße
 */
class FormatHelper
{
    public static function formatData($data, $success = true, $status = 200)
    {
        $content = array("success" => $success, "data" => $data);

        return response($content, $status);
    }
}