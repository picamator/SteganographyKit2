<?php
namespace Picamator\SteganographyKit2\Tests\Unit;

use Picamator\SteganographyKit2\OptionsResolver;

class OptionsResolverTest extends BaseTest
{
    public function testSetDefault()
    {
        $expected = 1;

        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->setDefault('testOption', $expected)
            ->resolve();

        $actual = $optionsResolver->getValue('testOption');
        $this->assertEquals($expected, $actual);
    }

    public function testValueSetDefault()
    {
        $expected = 2;

        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->setDefault('testOption', 1)
            ->resolve(['testOption' => $expected]);

        $actual = $optionsResolver->getValue('testOption');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function testFailSetDefault()
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->setDefault('testOption', 1)
            ->resolve();

        $optionsResolver->setDefined('testOption');
    }

    public function testSetRequired()
    {
        $expected = 1;

        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->setRequired('testOption')
            ->resolve(['testOption' => $expected]);

        $actual = $optionsResolver->getValue('testOption');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function testFailSetRequired()
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->setRequired('testOption')
            ->resolve(['testOption' => 1]);

        $optionsResolver->setDefined('testOption');
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     */
    public function testUnSetRequired()
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->setRequired('testOption')
            ->resolve();
    }

    public function testSetDefined()
    {
        $expected = 1;

        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->resolve(['testOption' => $expected]);

        $actual = $optionsResolver->getValue('testOption');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function testFailSetDefined()
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->resolve(['testOption' => 1]);

        $optionsResolver->setDefined('testOption');
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     */
    public function testUnSetDefined()
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->resolve(['testOption' => 1]);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\LogicException
     */
    public function testFailGetValue()
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->getValue('testOption');
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     */
    public function testNotExistGetValue()
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->resolve(['testOption' => 1]);

        $optionsResolver->getValue('anotherTestOption');
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
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined($optionName)
            ->setAllowedType($optionName, $allowedType)
            ->resolve([$optionName => $optionValue]);

        $this->assertEquals($optionValue, $optionsResolver->getValue($optionName));
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
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined($optionName)
            ->setAllowedType($optionName, $allowedType)
            ->resolve([$optionName => $optionValue]);
    }

    public function testResolve()
    {
        $expected = 1;

        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefined('testOption')
            ->resolve(['testOption' => $expected]);

        // double resolve
        $optionsResolver->resolve();

        $actual = $optionsResolver->getValue('testOption');
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
