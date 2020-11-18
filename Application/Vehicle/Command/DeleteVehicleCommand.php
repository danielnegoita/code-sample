<?php

namespace Fleet\Application\Vehicle\Command;

class DeleteVehicleCommand
{
    private string $tenantId;

    private string $vehicleUuid;

    public function __construct(string $tenantId, string $vehicleUuid)
    {
        $this->tenantId = $tenantId;
        $this->vehicleUuid = $vehicleUuid;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function getVehicleUuid(): string
    {
        return $this->vehicleUuid;
    }
}
