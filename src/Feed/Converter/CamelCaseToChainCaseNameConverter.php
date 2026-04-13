<?php


namespace App\Feed\Converter;


use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class CamelCaseToChainCaseNameConverter implements NameConverterInterface
{
    private $attributes;
    private $lowerCamelCase;

    /**
     * @param array|null $attributes     The list of attributes to rename or null for all attributes
     * @param bool       $lowerCamelCase Use lowerCamelCase style
     */
    public function __construct(array $attributes = null, bool $lowerCamelCase = true)
    {
        $this->attributes = $attributes;
        $this->lowerCamelCase = $lowerCamelCase;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(string $propertyName)
    {
        if (null === $this->attributes || \in_array($propertyName, $this->attributes)) {
            return strtolower(preg_replace('/[A-Z]/', '-\\0', lcfirst($propertyName)));
        }

        return $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize(string $propertyName)
    {
        $camelCasedName = preg_replace_callback('/(^|-|\.)+(.)/', function ($match) {
            return ('.' === $match[1] ? '_' : '').strtoupper($match[2]);
        }, $propertyName);

        if ($this->lowerCamelCase) {
            $camelCasedName = lcfirst($camelCasedName);
        }

        if (null === $this->attributes || \in_array($camelCasedName, $this->attributes)) {
            return $camelCasedName;
        }

        return $propertyName;
    }
}