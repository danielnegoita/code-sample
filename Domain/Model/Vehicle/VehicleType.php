<?php

namespace Fleet\Domain\Model\Vehicle;

use Common\Domain\EnumType;

class VehicleType extends EnumType
{
    public const SMALL = 'small';
    public const MEDIUM = 'medium';
    public const LARGE = 'large';
    public const SUV = 'suv';
    public const VAN = 'van';
    public const CONVERTIBLE = 'convertible';
    public const COMMERCIAL = 'commercial';

    protected static string $name = 'vehicle_type';
    protected static array $values = [
        self::SMALL,
        self::MEDIUM,
        self::LARGE,
        self::SUV,
        self::VAN,
        self::CONVERTIBLE,
        self::COMMERCIAL,
    ];
}
