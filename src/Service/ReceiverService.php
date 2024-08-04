<?php

namespace App\Service;

use App\Receiver\Command;
use App\Receiver\Value;

class ReceiverService
{
    public static function parseTelnetResponse(string $response)
    {
        $outputArray = [];
        preg_match('/([A-Z]{3})([0-9]{3})/', $response, $outputArray);

        if (count($outputArray) < 3) {
            return null;
        }
        return match ($outputArray[1]) {
            'VOL' => self::responseVolume($outputArray),
            default => [],
        };

    }

    public static function responseVolume(array $data)
    {
        return [
            'type' => $data[1],
            'volume' => floor(Value::MAX_VOLUME_READABLE * $data[2] / Value::MAX_VOLUME_RECEIVER)
        ];
    }

}