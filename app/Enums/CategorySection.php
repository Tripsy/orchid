<?php

declare(strict_types=1);

namespace App\Enums;

enum CategorySection: string
{
    use EnumTrait;

    case ARTICLE = 'article';
    case FACTION = 'faction';

    public function text(): string
    {
        return match ($this) {
            self::ARTICLE => __('Article'),
            self::FACTION => __('Faction'),
        };
    }
}
