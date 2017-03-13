<?php
namespace Picamator\SteganographyKit2\Tests\Helper\Util;

use PHPUnit\Framework\TestCase;
use Picamator\SteganographyKit2\Exception\InvalidArgumentException;

/**
 * Help to mock objects through OptionsResolver
 */
class OptionsResolverHelper
{
    /**
     * @var TestCase
     */
    private $testCase;

    /**
     * @param TestCase $testCase
     */
    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * Stub options resolver
     *
     * @param array $options
     *
     * @return \Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface | \PHPUnit_Framework_MockObject_MockObject
     *
     * @throws InvalidArgumentException
     */
    public function stubOptionsResolver(array $options) : \PHPUnit_Framework_MockObject_MockObject
    {
        // options resolver mock
        $optionsResolverMock = $this->getMockBuilder('Picamator\SteganographyKit2\Util\Api\OptionsResolverInterface')
            ->getMock();

        $optionsResolverMock->method('setDefined')
            ->willReturnSelf();

        $optionsResolverMock->method('setRequired')
            ->willReturnSelf();

        $optionsResolverMock->method('setDefault')
            ->willReturnSelf();

        $optionsResolverMock->method('setAllowedType')
            ->willReturnSelf();

        $optionsResolverMock->method('resolve')
            ->willReturn([]);

        $optionsResolverMock
            ->method('getValue')
            ->willReturnCallback(function($name) use ($options) {
                if (!isset($options[$name])) {
                    throw new InvalidArgumentException(
                        sprintf('Undefined option "%s"', $name)
                    );
                }

                return $options[$name];
            });

        return $optionsResolverMock;
    }

    /**
     * Gets mock builder
     *
     * @param string $className
     *
     * @return \PHPUnit_Framework_MockObject_MockBuilder
     */
    private function getMockBuilder(string $className) : \PHPUnit_Framework_MockObject_MockBuilder
    {
        return $this->testCase->getMockBuilder($className);
    }
}
