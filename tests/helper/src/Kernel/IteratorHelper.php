<?php
namespace Picamator\SteganographyKit2\Tests\Helper\Kernel;

use PHPUnit\Framework\TestCase;

/**
 * Help to mock objects implementing iterator
 */
class IteratorHelper
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
     * Gets recursive iterator mock
     *
     * @param string $className
     * @param array $data
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getIteratorMock(string $className, array $data): \PHPUnit_Framework_MockObject_MockObject
    {

        $iterator = new \ArrayIterator($data);

        $iteratorMock = $this->getMockBuilder($className)
            ->getMock();

        $iteratorMock->method('current')
            ->willReturnCallback(function() use ($iterator) {
                return $iterator->current();
            });

        $iteratorMock->method('next')
            ->willReturnCallback(function() use ($iterator) {
                return $iterator->next();
            });

        $iteratorMock->method('key')
            ->willReturnCallback(function() use ($iterator) {
                return $iterator->key();
            });

        $iteratorMock->method('valid')
            ->willReturnCallback(function() use ($iterator) {
                return $iterator->valid();
            });

        $iteratorMock->method('rewind')
            ->willReturnCallback(function() use ($iterator) {
                $iterator->rewind();
            });

        return $iteratorMock;
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
