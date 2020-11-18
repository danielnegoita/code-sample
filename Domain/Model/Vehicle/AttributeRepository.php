<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\Repository;
use Fleet\Domain\Model\Tenant\TenantId;

interface AttributeRepository extends Repository
{
    public function findByUuid(TenantId $tenantId, AttributeUuid $uuid): ?Attribute;
}
