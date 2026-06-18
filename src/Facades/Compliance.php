<?php

namespace Parallel\Compliance\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Parallel\Compliance\Compliance
 */
class Compliance extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Parallel\Compliance\Compliance::class;
    }
}
