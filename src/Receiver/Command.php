<?php

namespace App\Receiver;

class Command
{
    /**
     * Power
     */
    const POWER_ON = 'PO';
    const POWER_OFF = 'PF';
    const POWER_REQUEST_STATE = '?P';
    const POWER_REQUEST_STATE_NAME = 'status';

    /**
     * Volume
     */
    const VOLUME_UP = 'VU';
    const VOLUME_DOWN = 'VD';
    const VOLUME_REQUEST_STATE = '?V';

    const MAX_VOLUME_RECEIVER = 161;
    const MAX_VOLUME_READABLE = 80;

    /**
     * Mute
     */
    const MUTE_ON = 'MO';
    const MUTE_OFF = 'MF';
    const MUTE_REQUEST_STATE = '?M';

    /**
     * Channels
     */
    const CHANNEL_GAME = '49FN';
    const CHANNEL_DVD = '04FN';
    const CHANNEL_TV = '05FN';
    const CHANNEL_REQUEST_STATE = '?F';

    const ALLOWED = [
        self::POWER_ON,
        self::POWER_OFF,
        self::POWER_REQUEST_STATE,
        self::VOLUME_UP,
        self::VOLUME_DOWN,
        self::VOLUME_REQUEST_STATE,
        self::MUTE_ON,
        self::MUTE_OFF,
        self::MUTE_REQUEST_STATE,
        self::CHANNEL_GAME,
        self::CHANNEL_DVD,
        self::CHANNEL_TV,
        self::CHANNEL_REQUEST_STATE,
        self::POWER_REQUEST_STATE_NAME,
    ];

}
