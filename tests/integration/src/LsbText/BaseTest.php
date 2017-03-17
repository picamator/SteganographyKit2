<?php
namespace Picamator\SteganographyKit2\Tests\Integration\LsbText;

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
        return  __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, ['..', '..', '..', 'data', $subPath]);
    }

    /**
     * Gets file contents
     *
     * @param string $subPath
     *
     * @return string
     */
    protected function getFileContents(string $subPath)
    {
        return file_get_contents($this->getPath($subPath));
    }
}
