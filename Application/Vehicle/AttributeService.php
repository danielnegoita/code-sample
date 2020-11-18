<?php

namespace Fleet\Application\Vehicle;

use Fleet\Application\Vehicle\Command\CreateAttributeCommand;
use Fleet\Application\Vehicle\Command\DeleteAttributeCommand;
use Fleet\Application\Vehicle\Command\UpdateAttributeCommand;
use Fleet\Domain\Model\Tenant\TenantId;
use Fleet\Domain\Model\Vehicle\Attribute;
use Fleet\Domain\Model\Vehicle\AttributeRepository;
use Fleet\Domain\Model\Vehicle\AttributeUuid;

final class AttributeService
{
    private AttributeRepository $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function createAttribute(CreateAttributeCommand $command)
    {
        $tenantId = TenantId::fromString($command->getTenantId());
        $attributeUuid = AttributeUuid::generate();

        $attribute = Attribute::create(
            $tenantId,
            $attributeUuid,
            $command->getName(),
            $command->getDescription(),
            $command->getType()
        );

        $this->attributeRepository->save($attribute);
    }

    public function updateAttribute(UpdateAttributeCommand $command)
    {
        $attribute = $this->attributeRepository->findByUuid(
            TenantId::fromString($command->getTenantId()),
            AttributeUuid::fromString($command->getAttributeUuid())
        );

        if (null === $attribute) {
            throw new \InvalidArgumentException("Unknown attribute of tenant id: {$command->getTenantId()} and attribute id: {$command->getAttributeUuid()}");
        }

        $attribute->update(
            $command->getName(),
            $command->getDescription(),
            $command->getType()
        );

        $this->attributeRepository->save($attribute);
    }

    public function deleteAttribute(DeleteAttributeCommand $command)
    {
        $attribute = $this->attributeRepository->findByUuid(
            TenantId::fromString($command->getTenantId()),
            AttributeUuid::fromString($command->getAttributeUuid())
        );

        if (null === $attribute) {
            throw new \InvalidArgumentException("Unknown attribute of tenant id: {$command->getTenantId()} and attribute id: {$command->getAttributeUuid()}");
        }

        $this->attributeRepository->remove($attribute);
    }
}
