<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\ValueObject;

final class RegistrationPlate implements ValueObject
{
    private ?string $registrationPlate;

    private function __construct(?string $registrationPlate = null)
    {
        $this->registrationPlate = $registrationPlate;
    }

    public static function fromString(?string $registrationPlate): self
    {
        //TODO: add validation - @see https://medium.com/swlh/value-objects-to-the-rescue-28c563ad97c6
        return new self($registrationPlate);
    }

    public function toString(): ?string
    {
        return $this->registrationPlate;
    }

    public function equals(ValueObject $anObject): bool
    {
        return $anObject instanceof self &&
            $this->toString() === $anObject->toString();
    }

    public function __toString(): ?string
    {
        return $this->toString();
    }
}
