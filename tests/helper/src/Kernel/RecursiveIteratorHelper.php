<?php
namespace Picamator\SteganographyKit2\Tests\Helper\Kernel;

use PHPUnit\Framework\TestCase;

/**
 * Help to mock objects implementing recursive iterator
 */
class RecursiveIteratorHelper
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
    public function getRecursiveIteratorMock(string $className, array $data): \PHPUnit_Framework_MockObject_MockObject
    {
        $recursiveIterator = $this->getRecursiveIterator($data);

        $iteratorMock = $this->getMockBuilder($className)
            ->getMock();

        $iteratorMock->method('current')
            ->willReturnCallback(function() use ($recursiveIterator) {
                return $recursiveIterator->current();
            });

        $iteratorMock->method('next')
            ->willReturnCallback(function() use ($recursiveIterator) {
                return $recursiveIterator->next();
            });

        $iteratorMock->method('key')
            ->willReturnCallback(function() use ($recursiveIterator) {
                return $recursiveIterator->key();
            });

        $iteratorMock->method('valid')
            ->willReturnCallback(function() use ($recursiveIterator) {
                return $recursiveIterator->valid();
            });

        $iteratorMock->method('rewind')
            ->willReturnCallback(function() use ($recursiveIterator) {
                $recursiveIterator->rewind();
            });

        $iteratorMock->method('hasChildren')
            ->willReturnCallback(function() use ($recursiveIterator) {
                return $recursiveIterator->hasChildren();
            });

        $iteratorMock->method('getChildren')
            ->willReturnCallback(function() use ($recursiveIterator) {
                return $recursiveIterator->getChildren();
            });

        return $iteratorMock;
    }

    /**
     * Gets recursive iterator
     *
     * @param array $data
     *
     * @return \RecursiveIterator
     */
    private function getRecursiveIterator(array $data): \RecursiveIterator
    {
        return new class($data) implements \RecursiveIterator
        {
            private $data;

            public function __construct(array $data)
            {
                $this->data = $data;
            }

            public function current()
            {
                return current($this->data);
            }

            public function next()
            {
                return next($this->data);
            }

            public function key()
            {
                return key($this->data);
            }

            public function valid()
            {
                return !is_null(key($this->data));
            }

            public function rewind()
            {
                reset($this->data);
            }

            public function hasChildren()
            {
                return (is_object($this->current()) && is_a($this->current(), 'IteratorAggregate'));
            }

            public function getChildren()
            {
                return $this->current()->getIterator();
            }
        };
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
