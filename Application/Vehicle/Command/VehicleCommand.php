<?php

namespace Fleet\Application\Vehicle\Command;

abstract class VehicleCommand
{
    private string $tenantId;

    private string $make;

    private string $model;

    private ?string $registrationPlate;

    private ?string $manufacturedAt;

    private ?string $type;

    public function __construct(
        string $tenantId,
        string $make,
        string $model,
        ?string $registrationPlate = null,
        ?string $manufacturedAt = null,
        ?string $type = null
    ) {
        $this->tenantId = $tenantId;
        $this->make = $make;
        $this->model = $model;
        $this->manufacturedAt = $manufacturedAt;
        $this->registrationPlate = $registrationPlate;
        $this->type = $type;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function getMake(): string
    {
        return $this->make;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getRegistrationPlate(): ?string
    {
        return $this->registrationPlate;
    }

    public function getManufacturedAt(): ?string
    {
        return $this->manufacturedAt;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
