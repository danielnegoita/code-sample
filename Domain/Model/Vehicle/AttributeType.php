<?php

namespace Fleet\Domain\Model\Vehicle;


use Common\Domain\EnumType;

class AttributeType extends EnumType
{
    const SIZE = 'size';
    const OTHER = 'other';

    protected static string $name = 'vehicle_attribute_type';
    protected static array $values = [
        self::SIZE,
        self::OTHER,
    ];
}