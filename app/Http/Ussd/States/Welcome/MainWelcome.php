<?php

namespace App\Http\Ussd\States\Welcome;

use Sparors\Ussd\State;

class MainWelcome extends State
{
    protected $action = self::INPUT;
    
    protected function beforeRendering(): void
    {
        //
    }

    protected function afterRendering(string $argument): void
    {
        //
    }
}
