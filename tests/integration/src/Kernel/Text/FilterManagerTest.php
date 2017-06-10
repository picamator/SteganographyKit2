<?php
namespace Picamator\SteganographyKit2\Tests\Integration\Kernel\Text;

use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Text\Builder\AsciiFactory;
use Picamator\SteganographyKit2\Kernel\Text\Filter\Base64decodeFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\Base64encodeFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\BinaryToTextFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\TextToBinaryFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\ZipCompressFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\ZipDecompressFilter;
use Picamator\SteganographyKit2\Kernel\Text\FilterManager;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;
use Picamator\SteganographyKit2\Tests\Integration\Kernel\BaseTest;

class FilterManagerTest extends BaseTest
{
    /**
     * @var array [['binaryText' => ..., 'text' => ...], ...]
     */
    private static $dataContainer;

    /**
     * @var FilterManager
     */
    private $filterManager;

    protected function setUp()
    {
        parent::setUp();

        $this->filterManager = new FilterManager();
    }

    /**
     * @dataProvider providerApply
     *
     * @param string $data
     */
    public function testApply(string $data)
    {
        $objectManager = new ObjectManager();

        $asciiFactory = new AsciiFactory($objectManager);

        $filterList = [
            new ZipCompressFilter(),
            new Base64encodeFilter(),
            new TextToBinaryFilter($asciiFactory),
        ];

        $this->filterManager->attachAll($filterList);
        $binaryText = $this->filterManager->apply($data);

        $this->assertNotRegExp('/[^01]+/', $binaryText);

        self:: $dataContainer[] = ['binaryText' => $binaryText, 'text' => $data];
    }

    /**
     * @depends testApply
     */
    public function testReverseApply()
    {
        $filterList = [
            new BinaryToTextFilter(),
            new Base64decodeFilter(),
            new ZipDecompressFilter(),
        ];

        $this->filterManager->attachAll($filterList);
        foreach (self:: $dataContainer as $item) {
            $actual = $this->filterManager->apply($item['binaryText']);

            $this->assertEquals($item['text'], $actual);
        }
    }

    public function providerApply()
    {
        return [
            ['Hello Steganography!'],
            ['Cześć Steganography!'],
            ['Привіт Steganography!'],
            ['Félicitations Steganography!'],
            ['Glückwünsche Steganography!'],
        ];
    }
}
