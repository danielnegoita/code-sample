<?php

namespace Fleet\Infrastructure\Persistence\Doctrine;

use Common\Infrastructure\Doctrine\DoctrineBaseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fleet\Domain\Model\Tenant\TenantId;
use Fleet\Domain\Model\Vehicle\Vehicle;
use Fleet\Domain\Model\Vehicle\VehicleRepository;
use Fleet\Domain\Model\Vehicle\VehicleUuid;

final class DoctrineVehicleRepository extends DoctrineBaseRepository implements VehicleRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findByUuid(TenantId $tenantId, VehicleUuid $uuid): ?Vehicle
    {
        return $this->findOneBy([
            'tenant_id' => $tenantId->toString(),
            'uuid' => $uuid->toString(),
        ]);
    }
}
