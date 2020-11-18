<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\ValueObject;

final class Model implements ValueObject
{
    private string $model;

    private function __construct(string $model)
    {
        if (!$this->isValid()) {
            throw new \InvalidArgumentException('Invalid vehicle model.');
        }

        $this->model = $model;
    }

    public static function fromString(string $model): self
    {
        return new self($model);
    }

    public function toString(): string
    {
        return $this->model;
    }

    public function equals(ValueObject $anObject): bool
    {
        return $anObject instanceof self &&
            $this->toString() === $anObject->toString();
    }

    private function isValid()
    {
        // TODO: implement validation
        return true;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
