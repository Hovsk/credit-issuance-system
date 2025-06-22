<?php

namespace App\Enum;

enum Region: string
{
    case PRAGUE = 'PR';
    case BRNO = 'BR';
    case OSTRAVA = 'OS';

    public static function values(): array
    {
        return array_map(fn (self $r) => $r->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::PRAGUE => 'Prague',
            self::BRNO => 'Brno',
            self::OSTRAVA => 'Ostrava',
        };
    }
}
