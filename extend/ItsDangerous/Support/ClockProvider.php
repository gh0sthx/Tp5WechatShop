<?php

namespace ItsDangerous\Support;

use DateTime;

class ClockProvider
{
    /**
     * EPOCH - we don't want or need to cover the entire span
     * of time since any real epoch, so this is the base time
     * stamp we'll support from.
     */
    public static $EPOCH = 1293840000;
    protected static $now = null;

    public static function getDateTime()
    {
        if(static::$now === null) {
            return new DateTime();
        }
        return static::$now;
    }

    public static function getTimestamp()
    {
        $dt = static::getDateTime();
        $dtnow = $dt->getTimestamp();
        return $dtnow - self::$EPOCH;
    }

    public static function setTestNow(DateTime $dt = null)
    {
        static::$now = $dt;
    }

    public static function timestampToDate($ts)
    {
        return \DateTime::createFromFormat("U", $ts + self::$EPOCH, new \DateTimeZone("UTC"));
    }
}
