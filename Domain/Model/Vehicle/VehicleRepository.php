<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\Repository;
use Fleet\Domain\Model\Tenant\TenantId;

interface VehicleRepository extends Repository
{
    public function findByUuid(TenantId $tenantId, VehicleUuid $uuid): ?Vehicle;
}
