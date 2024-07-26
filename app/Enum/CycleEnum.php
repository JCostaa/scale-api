<?php

namespace App\Enum;

enum CycleEnum : int
{
    case c0 = 0;
    case c1 = 1;
    case c2 = 2;
    case c3 = 3;


    public static function fromName(string $name): string
    {
        foreach (self::cases() as $status) {
            if( $name === $status->name ){
                return $status->value;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum " . self::class );
    }
}
