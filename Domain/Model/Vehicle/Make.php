<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\ValueObject;

final class Make implements ValueObject
{
    private string $make;

    private function __construct(string $make)
    {
        if (!$this->isValid($make)) {
            throw new \InvalidArgumentException('Invalid vehicle make.');
        }

        $this->make = $make;
    }

    public static function fromString(string $make): self
    {
        return new self($make);
    }

    public function toString(): string
    {
        return $this->make;
    }

    public function equals(ValueObject $anObject): bool
    {
        return $anObject instanceof self &&
            $this->toString() === $anObject->toString();
    }

    private function isValid($make): bool
    {
        // TODO: implement validation
        return true;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
