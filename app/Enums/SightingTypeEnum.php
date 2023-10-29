<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum SightingTypeEnum: string implements HasColor
{
    case WHALE = 'Whale';
    case SEA_TURTLE = 'Sea Turtle';
    case DOLPHIN = 'Dolphin';
    case MARINE_MAMMAL = 'Marine Mammal';
    case DEAD_DISTRESSED_WHALE = 'Dead/Distressed Whale';
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
            self::SEA_TURTLE->value => 'Sea Turtle',
            self::DOLPHIN->value => 'Dolpin',
            self::MARINE_MAMMAL->value => 'Marine Mammal',
            self::DEAD_DISTRESSED_WHALE->value => 'Dead/Distressed Whale',
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
            self::SEA_TURTLE => 'success',
            self::DOLPHIN => 'gray',
            self::MARINE_MAMMAL => 'primary',
            self::DEAD_DISTRESSED_WHALE => 'danger',
            self::SUSPECTED_POACHER => 'danger',
            self::UAP => 'danger',
        };
    }
}
