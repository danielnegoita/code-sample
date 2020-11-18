<?php

namespace Fleet\Application\Vehicle\Command;

final class UpdateVehicleCommand extends VehicleCommand
{
    private string $vehicleUuid;

    public function __construct(string $vehicleUuid, string $tenantId, string $make, string $model, ?string $registrationPlate = null, ?string $manufacturedAt = null, ?string $type = null)
    {
        parent::__construct($tenantId, $make, $model, $registrationPlate, $manufacturedAt, $type);
        $this->vehicleUuid = $vehicleUuid;
    }

    public function getVehicleUuid(): string
    {
        return $this->vehicleUuid;
    }
}
