<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\ValueObject;

final class Type implements ValueObject
{
    protected ?string $vehicleType;

    private function __construct(?string $vehicleType = null)
    {
        if (null !== $vehicleType && !$this->isValid($vehicleType)) {
            throw new \InvalidArgumentException("Invalid {$vehicleType} vehicle type.");
        }

        $this->vehicleType = $vehicleType;
    }

    public static function fromString(?string $vehicleType): self
    {
        return new self($vehicleType);
    }

    public function toString(): ?string
    {
        return $this->vehicleType;
    }

    public function equals(ValueObject $anObject): bool
    {
        return $anObject instanceof self &&
            $this->toString() === $anObject->toString();
    }

    private function isValid($vehicleType): bool
    {
        return VehicleType::isValueExist($vehicleType);
    }

    public function __toString(): ?string
    {
        return $this->toString();
    }
}
