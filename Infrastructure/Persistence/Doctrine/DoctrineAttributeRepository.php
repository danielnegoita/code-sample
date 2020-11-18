<?php

namespace Fleet\Infrastructure\Persistence\Doctrine;

use Common\Infrastructure\Doctrine\DoctrineBaseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fleet\Domain\Model\Tenant\TenantId;
use Fleet\Domain\Model\Vehicle\Attribute;
use Fleet\Domain\Model\Vehicle\AttributeRepository;
use Fleet\Domain\Model\Vehicle\AttributeUuid;

final class DoctrineAttributeRepository extends DoctrineBaseRepository implements AttributeRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attribute::class);
    }

    public function findByUuid(TenantId $tenantId, AttributeUuid $uuid): ?Attribute
    {
        return $this->findOneBy([
            'tenant_id' => $tenantId->toString(),
            'uuid' => $uuid->toString(),
        ]);
    }
}
