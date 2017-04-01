<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\File\NameGenerator;

use Picamator\SteganographyKit2\Kernel\File\NameGenerator\PrefixTime;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\SourceIdentical;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class PrefixTimeTest extends BaseTest
{
    /**
     * @dataProvider providerGenerate
     *
     * @param string $prefix
     */
    public function testGenerate(string $prefix = '')
    {
        $extension = 'jpg';

        $generator = new PrefixTime($prefix);
        $actual = $generator->generate(__FILE__, $extension);

        $expected = pathinfo(__FILE__, PATHINFO_FILENAME) . '.' . $extension;

        $this->assertContains($expected, $actual);
        if (!empty(trim($prefix))) {
            $this->assertContains($prefix, $actual);
        }
    }

    public function providerGenerate()
    {
        return [
            [],
            [' '],
            ['lsb-image']
        ];
    }
}
