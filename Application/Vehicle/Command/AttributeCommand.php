<?php

namespace Fleet\Application\Vehicle\Command;

abstract class AttributeCommand
{
    private string $tenantId;

    private string $name;

    private ?string $description;

    private ?string $type;

    public function __construct(
        string $tenantId,
        string $name,
        ?string $description = null,
        ?string $type = null
    ) {
        $this->tenantId = $tenantId;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
