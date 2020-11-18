<?php

namespace Fleet\Application\Vehicle\Command;

class UpdateAttributeCommand extends AttributeCommand
{
    private string $attributeUuid;

    public function __construct(string $attributeUuid, string $tenantId, string $name, ?string $description = null, ?string $type = null)
    {
        parent::__construct($tenantId, $name, $description, $type);

        $this->attributeUuid = $attributeUuid;
    }

    public function getAttributeUuid(): string
    {
        return $this->attributeUuid;
    }
}
