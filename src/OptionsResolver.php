<?php
declare(strict_types=1);

namespace Picamator\SteganographyKit2;

use Picamator\SteganographyKit2\Api\OptionsResolverInterface;
use Picamator\SteganographyKit2\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Exception\LogicException;

/**
 * Options with default values, data type and required validation
 *
 * It's a short version of `symfony/options-resolver`
 */
class OptionsResolver implements OptionsResolverInterface
{
    /**
     * @var array
     */
    private static $dataType = [
        'string' => 'is_string',
        'int' => 'is_int',
        'float' => 'is_float',
        'array' => 'is_array',
        'bool' => 'is_bool',
        'numeric' => 'is_numeric',
        'null' => 'is_null',
        'object' => 'is_object',
    ];

    /**
     * @var array
     */
    private $resolvedList;

    /**
     * @var array
     */
    private $defaultList = [];

    /**
     * @var array
     */
    private $requiredList = [];

    /**
     * @var array
     */
    private $definedList = [];

    /**
     * @var array
     */
    private $allowedList = [];

    /**
     * {@inheritdoc}
     */
    public function setDefault(string $optionName, $value) : OptionsResolverInterface
    {
        $this->hasResolved();
        $this->defaultList[$optionName] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequired(string $optionName) : OptionsResolverInterface
    {
        $this->hasResolved();
        $this->requiredList[] = $optionName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefined(string $optionName)
    {
        $this->hasResolved();
        $this->definedList[] = $optionName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAllowedType(string $optionName, string $allowedType) : OptionsResolverInterface
    {
        $this->hasResolved();
        $this->allowedList[$optionName] = $allowedType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array $options = []) : array
    {
        if (!is_null($this->resolvedList)) {
            return $this->resolvedList;
        }

        $optionsKeyList = array_keys($options);

        // defined
        $definedDiff = array_diff($optionsKeyList, $this->definedList);
        if (!empty($definedDiff)) {
            throw new InvalidArgumentException(
                sprintf('Invalid options. Options ["%s"] were not defined.', implode(',', $definedDiff))
            );
        }

        // required
        $requiredDiff = array_diff($this->requiredList, $optionsKeyList);
        if(!empty($requiredDiff)) {
            throw new InvalidArgumentException(
                sprintf('Invalid options. Options ["%s"] are required.', implode(',', $requiredDiff))
            );
        }

        // default
        $defaultDiff = array_diff(array_keys($this->defaultList), $optionsKeyList);
        foreach($defaultDiff as $item) {
            $options[$item] = $this->defaultList[$item];
        }

        // simple type
        $simpleType = array_filter($this->allowedList, function($item) {
           return  strpos($item, '\\') === false;
        });
        foreach ($simpleType as $key => $value) {
            if (!array_key_exists($value, self::$dataType)) {
                throw new InvalidArgumentException(
                    sprintf('Unsupported option type "%s"', $value)
                );
            }

            if (!call_user_func(self::$dataType[$value], $options[$key])) {
                throw new InvalidArgumentException(
                    sprintf('Invalid option value. It\'s supposed to be "%s".', $value)
                );
            }
        }

        // complex type
        $complexType = array_diff_assoc($this->allowedList, $simpleType);
        foreach ($complexType as $key => $value) {
            if (!is_a($options[$key], $value)) {
                throw new InvalidArgumentException(
                    sprintf('Invalid option value. It\'s supposed to be "%s".', $value)
                );
            }
        }

        // resolve
        $this->resolvedList = $options;

        return $this->resolvedList;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(string $optionName)
    {
        if (is_null($this->resolvedList)) {
            throw new LogicException('Option has not been resolved yet');
        }

        if(!array_key_exists($optionName, $this->resolvedList)) {
            throw new InvalidArgumentException(
                sprintf('Option "%s" was not found in container', $optionName)
            );
        }

        return $this->resolvedList[$optionName];
    }

    /**
     * Has resolved
     *
     * @return void
     *
     * @throws LogicException
     */
    private function hasResolved()
    {
        if (!is_null($this->resolvedList)) {
            throw new LogicException('Cannot modify resolved option');
        }
    }
}
