<?php
namespace Picamator\SteganographyKit2\Tests\Unit\File\NameGenerator;

use Picamator\SteganographyKit2\File\NameGenerator\SourceIdentical;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class SourceIdenticalTest extends BaseTest
{
    /**
     * @var SourceIdentical
     */
    private $sourceIdentical;

    protected function setUp()
    {
        parent::setUp();

        $this->sourceIdentical = new SourceIdentical();
    }

    public function testGenerate()
    {
        $actual = $this->sourceIdentical->generate(__FILE__);
        $expected = pathinfo(__FILE__, PATHINFO_BASENAME);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\InvalidArgumentException
     */
    public function testFailGenerate()
    {
        $this->sourceIdentical->generate('test');
    }
}
