<?php
namespace Picamator\SteganographyKit2\Util\Api;

use Picamator\SteganographyKit2\Exception\InvalidArgumentException;
use Picamator\SteganographyKit2\Exception\LogicException;

/**
 * Options with default values, data type and required validation
 *
 * It's a short version of `symfony/options-resolver`
 */
interface OptionsResolverInterface
{
    /**
     * Sets default value
     *
     * @param string $optionName
     * @param mixed $value
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setDefault(string $optionName, $value) : OptionsResolverInterface;

    /**
     * Sets option required
     *
     * @param string $optionName
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setRequired(string $optionName) : OptionsResolverInterface;

    /**
     * Defines option name
     *
     * @param string $optionName
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setDefined(string $optionName);

    /**
     * Sets allowed types for an option
     *
     * @param string $optionName
     * @param string $allowedType
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setAllowedType(string $optionName, string $allowedType) : OptionsResolverInterface;

    /**
     * Merges options with the default values stored in the container and validates them
     *
     * @param array $options
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function resolve(array $options = []) : array;

    /**
     * Gets value
     *
     * @param string $optionName
     *
     * @return mixed
     *
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function getValue(string $optionName);
}
