<?php
namespace Workflow\Facades;

use Illuminate\Support\Facades\Facade;

class Workflow extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'workflow'; }
}