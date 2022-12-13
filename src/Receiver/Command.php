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

    /**
     * Volume
     */
    const VOLUME_UP = 'VU';
    const VOLUME_DOWN = 'VD';
    const VOLUME_REQUEST_STATE = '?V';

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
        self::CHANNEL_REQUEST_STATE,
    ];

}
