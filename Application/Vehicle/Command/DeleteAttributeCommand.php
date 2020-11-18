<?php

namespace Fleet\Application\Vehicle\Command;

class DeleteAttributeCommand
{
    private string $tenantId;

    private string $attributeUuid;

    public function __construct(string $tenantId, string $attributeUuid)
    {
        $this->tenantId = $tenantId;
        $this->attributeUuid = $attributeUuid;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function getAttributeUuid(): string
    {
        return $this->attributeUuid;
    }
}
