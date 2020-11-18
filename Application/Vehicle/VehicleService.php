<?php

namespace Fleet\Application\Vehicle;

use DateTimeImmutable;
use Fleet\Application\Vehicle\Command\CreateVehicleCommand;
use Fleet\Application\Vehicle\Command\DeleteVehicleCommand;
use Fleet\Application\Vehicle\Command\UpdateVehicleCommand;
use Fleet\Domain\Model\Tenant\TenantId;
use Fleet\Domain\Model\Vehicle\Make;
use Fleet\Domain\Model\Vehicle\Model;
use Fleet\Domain\Model\Vehicle\RegistrationPlate;
use Fleet\Domain\Model\Vehicle\Type;
use Fleet\Domain\Model\Vehicle\Vehicle;
use Fleet\Domain\Model\Vehicle\VehicleRepository;
use Fleet\Domain\Model\Vehicle\VehicleUuid;

class VehicleService
{
    private VehicleRepository $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function createVehicle(CreateVehicleCommand $command)
    {
        $tenantId = TenantId::fromString($command->getTenantId());
        $vehicleUuid = VehicleUuid::generate();

        $vehicle = Vehicle::create(
            $tenantId,
            $vehicleUuid,
            Make::fromString($command->getMake()),
            Model::fromString($command->getModel()),
            RegistrationPlate::fromString($command->getRegistrationPlate()),
            new DateTimeImmutable($command->getManufacturedAt()),
            Type::fromString($command->getType())
        );

        $this->vehicleRepository->save($vehicle);
    }

    public function updateVehicle(UpdateVehicleCommand $command)
    {
        $vehicle = $this->vehicleRepository->findByUuid(
            TenantId::fromString($command->getTenantId()),
            VehicleUuid::fromString($command->getVehicleUuid())
        );

        if (null === $vehicle) {
            throw new \InvalidArgumentException("Unknown vehicle of tenant id: {$command->getTenantId()} and vehicle id: {$command->getVehicleUuid()}");
        }

        $vehicle->update(
            Make::fromString($command->getMake()),
            Model::fromString($command->getModel()),
            RegistrationPlate::fromString($command->getRegistrationPlate()),
            new DateTimeImmutable($command->getManufacturedAt()),
            Type::fromString($command->getType())
        );

        $this->vehicleRepository->save($vehicle);
    }

    public function deleteVehicle(DeleteVehicleCommand $command)
    {
        $vehicle = $this->vehicleRepository->findByUuid(
            TenantId::fromString($command->getTenantId()),
            VehicleUuid::fromString($command->getVehicleUuid())
        );

        if (null === $vehicle) {
            throw new \InvalidArgumentException("Unknown vehicle of tenant id: {$command->getTenantId()} and vehicle id: {$command->getVehicleUuid()}");
        }

        $this->vehicleRepository->remove($vehicle);
    }
}
