<?php

namespace App\Enums;

enum ArticleCategoryEnum: int
{
    case TECHNOLOGY = 0;
    case BUSINESS = 1;
    case ENTERTAINMENT = 2;
    case GENERAL = 3;
    case HEALTH = 4;
    case SCIENCE = 5;
    case SPORTS = 6;
    case POLITICS = 7;


    public function label(): string
    {
        return match ($this) {
            self::TECHNOLOGY => 'technology',
            self::BUSINESS => 'business',
            self::ENTERTAINMENT => 'entertainment',
            self::GENERAL => 'general',
            self::HEALTH => 'health',
            self::SCIENCE => 'science',
            self::SPORTS => 'sports',
            self::POLITICS => 'politics',
        };
    }


    public function value(): int
    {
        return match ($this) {
            self::TECHNOLOGY => 0,
            self::BUSINESS => 1,
            self::ENTERTAINMENT => 2,
            self::GENERAL => 3,
            self::HEALTH => 4,
            self::SCIENCE => 5,
            self::SPORTS => 6,
            self::POLITICS => 7,
        };
    }

    public static function stringToInt(string $string): int
    {
        return match ($string) {
            'technology' => self::TECHNOLOGY->value,
            'business' => self::BUSINESS->value,
            'entertainment' => self::ENTERTAINMENT->value,
            'general' => self::GENERAL->value,
            'health' => self::HEALTH->value,
            'science' => self::SCIENCE->value,
            'sports' => self::SPORTS->value,
            'politics' => self::POLITICS->value,
            default => throw new \InvalidArgumentException("Invalid category: $string"),
        };
    }
}
