<?php

namespace Moltox\ColumnMultiFilter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \moltox\ColumnMultiFilter\ColumnMultiFilter
 */
class ColumnMultiFilterFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'column-multi-filter';
    }
}
