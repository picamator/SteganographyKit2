<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Util;

use Picamator\SteganographyKit2\Tests\Unit\BaseTest;
use Picamator\SteganographyKit2\Util\OptionsResolver;

class OptionsResolverTest extends BaseTest
{
    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    protected function setUp()
    {
        parent::setUp();

        $this->optionsResolver = new OptionsResolver();
    }

    public function testSetDefault()
    {
        $expected = 1;

        $this->optionsResolver->setDefined('testOption')
            ->setDefault('testOption', $expected)
            ->resolve();

        $actual = $this->optionsResolver->getValue('testOption');
        $this->assertEquals($expected, $actual);
    }

    public function testValueSetDefault()
    {
        $expected = 2;

        $this->optionsResolver->setDefined('testOption')
            ->setDefault('testOption', 1)
            ->resolve(['testOption' => $expected]);

        $actual = $this->optionsResolver->getValue('testOption');
        $this->assertEquals($expected, $actual);
    }

    public function testSetRequired()
    {
        $expected = 1;

        $this->optionsResolver->setDefined('testOption')
            ->setRequired('testOption')
            ->resolve(['testOption' => $expected]);

        $actual = $this->optionsResolver->getValue('testOption');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     */
    public function testUnSetRequired()
    {
        $this->optionsResolver->setDefined('testOption')
            ->setRequired('testOption')
            ->resolve();
    }

    public function testSetDefined()
    {
        $expected = 1;

        $this->optionsResolver->setDefined('testOption')
            ->resolve(['testOption' => $expected]);

        $actual = $this->optionsResolver->getValue('testOption');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     */
    public function testUnSetDefined()
    {
        $this->optionsResolver->resolve(['testOption' => 1]);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function testFailGetValue()
    {
        $this->optionsResolver->resolve();
        $this->optionsResolver->getValue('testOption');
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     */
    public function testNotExistGetValue()
    {
        $this->optionsResolver->setDefined('testOption')
            ->resolve(['testOption' => 1]);

        $this->optionsResolver->getValue('anotherTestOption');
    }

    /**
     * @dataProvider providerSetAllowedType
     *
     * @param string $optionName
     * @param mixed $optionValue
     * @param string $allowedType
     */
    public function testSetAllowedType(string $optionName, $optionValue, string $allowedType)
    {
        $this->optionsResolver->setDefined($optionName)
            ->setAllowedType($optionName, $allowedType)
            ->resolve([$optionName => $optionValue]);

        $this->assertEquals($optionValue, $this->optionsResolver->getValue($optionName));
    }

    /**
     * @dataProvider providerFailSetAllowedType
     *
     * @expectedException \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     *
     * @param string $optionName
     * @param mixed $optionValue
     * @param string $allowedType
     */
    public function testFailSetAllowedType(string $optionName, $optionValue, string $allowedType)
    {
        $this->optionsResolver->setDefined($optionName)
            ->setAllowedType($optionName, $allowedType)
            ->resolve([$optionName => $optionValue]);
    }

    public function testResolve()
    {
        $expected = 1;

        $this->optionsResolver->setDefined('testOption')
            ->resolve(['testOption' => $expected]);

        $actual = $this->optionsResolver->getValue('testOption');
        $this->assertEquals($expected, $actual);
    }

    public function providerSetAllowedType()
    {
        return [
            ['stringOption', 'test', 'string'],
            ['intOption', 10, 'int'],
            ['floatOption', 10.5, 'float'],
            ['arrayOption', [], 'array'],
            ['boolOption', true, 'bool'],
            ['numericOption', 45, 'numeric'],
            ['nullOption', null, 'null'],
            ['objectOption', (object)[], 'object'],
            ['objectDataType', new \DateTime(), '\DateTime'],
        ];
    }

    public function providerFailSetAllowedType()
    {
        return [
            ['stringOption', 10, 'string'],
            ['intOption', 10.5, 'int'],
            ['floatOption', '10.5', 'float'],
            ['arrayOption', 'Array', 'array'],
            ['boolOption', [], 'bool'],
            ['numericOption', 'numeric', 'numeric'],
            ['nullOption', 'null', 'null'],
            ['objectOption', [], 'object'],
            ['objectDataType', new \stdClass(), '\DateTime'],
            ['stringOption', 10, 'unknown'],
        ];
    }
}
