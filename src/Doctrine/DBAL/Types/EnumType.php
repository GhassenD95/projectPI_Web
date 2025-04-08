<?php

namespace App\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EnumType extends Type
{
    private const ENUM_DEFINITIONS = [
        'equipe.division' => ['JEUNES', 'AMATEUR', 'PRO'],
        'equipe.sport' => ['FOOTBALL', 'BASKETBALL', 'HANDBALL'],
        'utilisateur.role' => ['ADMIN', 'MANAGER', 'COACH', 'ATHLETE'],
        'utilisateur.status' => ['ACTIVE', 'INACTIVE'],
        'installationsportive.typeInstallation' => ['STADE', 'SALLE_GYM', 'TERRAIN', 'PISCINE'],
        'equipement.etat' => ['BONETAT', 'ENDOMMAGE'],
        'equipement.typeEquipement' => ['BALLON', 'FILET', 'HALTERE', 'PROTECTIONS', 'CONES',
            'MACHINE_DE_MUSCULATION', 'CHRONOMETRE', 'TABLE_DE_MARQUE', 'AUTRE'],
        'tournois.sport' => ['FOOTBALL', 'BASKETBALL', 'HANDBALL'],
        'exercice.type' => [
            'MUSCULATION', 'CARDIO', 'YOGA', 'PILATES', 'NATATION', 'HIIT', 'ZUMBA'
        ]
    ];

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $enumKey = $this->getEnumKey($column);
        $values = self::ENUM_DEFINITIONS[$enumKey] ?? [];

        if (!empty($values)) {
            return sprintf("ENUM('%s')", implode("','", $values));
        }

        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return 'enum';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $enumKey = $this->getEnumKey($this->getColumnDefinition());
        $allowedValues = self::ENUM_DEFINITIONS[$enumKey] ?? [];

        if (!empty($allowedValues) && !in_array($value, $allowedValues)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid value "%s" for ENUM type %s. Allowed values: %s',
                $value,
                $enumKey,
                implode(', ', $allowedValues)
            ));
        }

        return $value;
    }

    private function getEnumKey(array $column): string
    {
        return $column['table_name'] . '.' . $column['field_name'];
    }
}