<?php
namespace Picamator\SteganographyKit2\Tests\Unit;

use Picamator\SteganographyKit2\ObjectManager;

class ObjectManagerTest extends BaseTest
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManager = new ObjectManager();
    }

    /**
     * @dataProvider providerCreate
     *
     * @param array $arguments
     */
    public function testCreate(array $arguments)
    {
        $className = '\DateTime';

        $actual = $this->objectManager->create($className, $arguments);
        $this->assertInstanceOf($className, $actual);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function testFailCreate()
    {
        $this->objectManager->create('Picamator\SteganographyKit2\ObjectManager', [1, 2]);
    }

    public function providerCreate()
    {
        return [
            [['now']],
            [[]]
        ];
    }
}
