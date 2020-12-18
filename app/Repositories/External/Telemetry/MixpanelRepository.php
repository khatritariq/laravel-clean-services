<?php

namespace App\Repositories\External\Telemetry;

use App\Repositories\External\Telemetry\Contracts\TelemetryContract;

class MixpanelRepository implements TelemetryContract
{
    public function saveUser($aUser)
    {
        // saves User in Mixpanel
    }
}
