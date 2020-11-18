<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\ValueObject;

final class VehicleStatus implements ValueObject
{
    public const NEW = 'NEW';
    public const AVAILABLE = 'AVAILABLE';
    public const MAINTENANCE = 'MAINTENANCE';

    private string $status;

    private function __construct(string $status)
    {
        $this->status = $status;
    }

    public static function new(): self
    {
        return new self(self::NEW);
    }

    public static function available(): self
    {
        return new self(self::AVAILABLE);
    }

    public static function maintenance(): self
    {
        return new self(self::MAINTENANCE);
    }

    public static function fromString(string $status): self
    {
        try {
            $const = new \ReflectionClassConstant(self::class, $status);

            return new self($const->getValue());
        } catch (\ReflectionException $exception) {
            throw new \InvalidArgumentException("Invalid vehicle status {$status}");
        }
    }

    public function equals(ValueObject $anObject): bool
    {
        return $anObject instanceof self &&
            $this->toString() === $anObject->toString();
    }

    public function toString(): string
    {
        return $this->status;
    }

    /**
     * Return the identifier as a string.
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
