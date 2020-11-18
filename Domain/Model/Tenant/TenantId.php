<?php

namespace Fleet\Domain\Model\Tenant;

use Common\Domain\ValueObject;
use Ramsey\Uuid\Uuid;

final class TenantId implements ValueObject
{
    protected string $id;

    private function __construct(string $id)
    {
        if (!$this->isValid($id)) {
            throw new \InvalidArgumentException('Invalid tenant id.');
        }

        $this->id = $id;
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function equals(ValueObject $anObject): bool
    {
        return $anObject instanceof self &&
            $this->toString() === $anObject->toString();
    }

    /**
     * Check if this is a valid UUID
     *
     * @param string $id
     * @return bool
     */
    private function isValid(string $id): bool
    {
        return Uuid::isValid($id);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
