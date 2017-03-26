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
        $generator = new PrefixTime($prefix);
        $actual = $generator->generate(__FILE__);

        $expected = pathinfo(__FILE__, PATHINFO_BASENAME);

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
