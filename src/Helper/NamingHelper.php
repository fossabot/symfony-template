<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helper;

class NamingHelper
{
    /**
     * produces my_class_name from Famoser\Class\MyClassName.
     *
     * @param $classWithNamespace
     *
     * @return string
     */
    public static function classToTranslationDomain($classWithNamespace)
    {
        $className = mb_substr($classWithNamespace, mb_strrpos($classWithNamespace, '\\') + 1);

        return static::camelCaseToTranslation($className);
    }

    /**
     * makes from camelCase => camel_case.
     *
     * @param $camelCase
     *
     * @return string
     */
    private static function camelCaseToTranslation($camelCase)
    {
    }

    /**
     * produces my_constant from MY_CONSTANT.
     *
     * @param $constant
     *
     * @return string
     */
    public static function constantToTranslation($constant)
    {
        return mb_strtolower($constant);
    }

    /**
     * the property to be converted to a array for the builder including the label member.
     *
     * @param $propertyName
     *
     * @return array
     */
    public static function propertyToTranslationForBuilder($propertyName)
    {
        return ['label' => static::propertyToTranslation($propertyName)];
    }

    /**
     * the property to be converted to a label.
     *
     * @param $propertyName
     *
     * @return string
     */
    public static function propertyToTranslation($propertyName)
    {
        return static::camelCaseToTranslation($propertyName);
    }

    /**
     * the name of the trait to be converted to a array for the builder including the label member.
     *
     * @param $trait
     *
     * @return string[]
     */
    public static function traitNameToTranslationForBuilder($trait)
    {
        return ['label' => 'trait.name', 'translation_domain' => static::traitToTranslationDomain($trait)];
    }
}
