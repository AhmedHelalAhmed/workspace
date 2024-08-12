<?php

namespace App\Traits;

trait FixtureTrait
{
    protected static function getJSONFixture($fileName): array
    {
        return json_decode(static::getFixture($fileName), true);
    }

    protected static function getFixture($fileName): bool|string
    {
        return file_get_contents(static::getFixturePath($fileName));
    }

    public static function getFixturePath($fileName): string
    {
        return __DIR__.'/../../tests/Fixtures/'.$fileName;
    }
}
