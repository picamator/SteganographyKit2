<?php
namespace Picamator\SteganographyKit2\Tests\Integration;

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    /**
     * Gets path
     *
     * @param string $subPath
     *
     * @return string
     */
    protected function getPath(string $subPath = '') : string
    {
        return  __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, ['..', '..', 'data', $subPath]);
    }
}
