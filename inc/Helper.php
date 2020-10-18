<?php
class Helper
{
    public static function dump($data)
    {
        echo '<pre>' . print_r($data, true) . '</pre>';
    }
}
