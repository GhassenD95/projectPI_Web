<?php

namespace App\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EnumType extends StringType
{
    public function getName(): string
    {
        return 'enum';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        // For schema operations, treat ENUM as a regular string
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}