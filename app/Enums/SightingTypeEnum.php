<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum SightingTypeEnum: string implements HasColor
{
    case WHALE = 'Whale';
    case TURTLE = 'Turtle';
    case DOLPHIN = 'Dolphin';
    case MARINE_LIFE = 'Marine Life';
    case SUSPECTED_POACHER = 'Suspected Poacher';
    case UAP = 'UAP';

    /**
     * @return string[]
     */
    public static function selectable(): array
    {
        // used by Filament table/form for filter/select
        return [
            self::WHALE->value => 'Whale',
            self::TURTLE->value => 'Turtle',
            self::DOLPHIN->value => 'Dolpin',
            self::MARINE_LIFE->value => 'Marine Life',
            self::SUSPECTED_POACHER->value => 'Suspected Poacher',
            self::UAP->value => 'UAP',
        ];
    }

    public function displayName(): string
    {
        return self::selectable()[$this->value];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::WHALE => 'info',
            self::TURTLE => 'success',
            self::DOLPHIN => 'gray',
            self::MARINE_LIFE => 'primary',
            self::SUSPECTED_POACHER => 'danger',
            self::UAP => 'danger',
        };
    }
}
