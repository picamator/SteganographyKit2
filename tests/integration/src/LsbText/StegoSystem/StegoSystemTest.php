<?php
namespace Picamator\SteganographyKit2\Tests\Integration\LsbText\StegoSystem;

use Picamator\SteganographyKit2\Kernel\CoverText\CoverText;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\PrefixTime;
use Picamator\SteganographyKit2\Kernel\File\Data\WritablePath;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegFile;
use Picamator\SteganographyKit2\Kernel\SecretText\InfoMarkFactory;
use Picamator\SteganographyKit2\Kernel\SecretText\SecretTextFactory;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Decode;
use Picamator\SteganographyKit2\LsbText\SecretText\Decode as SecretDecode;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Encode;
use Picamator\SteganographyKit2\LsbText\SecretText\Encode as SecretEncode;
use Picamator\SteganographyKit2\Kernel\StegoSystem\StegoSystem;
use Picamator\SteganographyKit2\Kernel\StegoText\StegoTextFactory;
use Picamator\SteganographyKit2\Kernel\Text\Builder\AsciiFactory;
use Picamator\SteganographyKit2\Kernel\Text\Filter\BinaryToTextFilter;
use Picamator\SteganographyKit2\Kernel\Text\Filter\TextToBinaryFilter;
use Picamator\SteganographyKit2\Kernel\Text\FilterManager;
use Picamator\SteganographyKit2\Kernel\SecretText\Iterator\SerialIteratorFactory as SecretIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;
use Picamator\SteganographyKit2\Lsb\StegoSystem\DecodeBit;
use Picamator\SteganographyKit2\Lsb\StegoSystem\EncodeBit;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Image\ImageHelper;
use Picamator\SteganographyKit2\Tests\Integration\LsbText\BaseTest;

class StegoSystemTest extends BaseTest
{
    /**
     * @var array [['textToEncode' => ..., 'stegoText' => ...], ...]
     */
    private static $stegoTextContainer = [];

    /**
     * @var ImageHelper
     */
    private $imageHelper;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var EncodeBit
     */
    private $encodeBit;
    /**
     * @var StegoTextFactory
     */
    private $stegoTextFactory;

    /**
     * @var Encode
     */
    private $encode;

    /**
     * @var DecodeBit
     */
    private $decodeBit;

    /**
     * @var InfoMarkFactory
     */
    private $infoMarkFactory;

    /**
     * @var SecretIteratorFactory
     */
    private $secretIteratorFactory;

    /**
     * @var SecretTextFactory
     */
    private $secretTextFactory;

    /**
     * @var Decode
     */
    private $decode;

    /**
     * @var FilterManager
     */
    private $filterManager;

    /**
     * @var AsciiFactory
     */
    private $asciiFactory;

    /**
     * @var TextToBinaryFilter
     */
    private $textToBinaryFilter;

    /**
     * @var SecretEncode
     */
    private $secretEncode;

    /**
     * @var PrefixTime
     */
    private $nameGenerator;

    /**
     * @var BinaryToTextFilter
     */
    private $binaryToTextFilter;

    /**
     * @var SecretDecode
     */
    private $secretDecode;

    /**
     * @var StegoSystem
     */
    private $stegoSystem;

    protected function setUp()
    {
        parent::setUp();

        // helper
        $this->imageHelper = new ImageHelper();

        // util
        $this->objectManager = new ObjectManager();

        // encode
        $this->encodeBit = new EncodeBit();

        $this->stegoTextFactory = new StegoTextFactory($this->objectManager);

        $this->encode = new Encode($this->encodeBit, $this->stegoTextFactory);

        // decode
        $this->decodeBit = new DecodeBit();

        $this->infoMarkFactory = new InfoMarkFactory($this->objectManager);

        $this->secretIteratorFactory = new SecretIteratorFactory($this->objectManager);

        $this->secretTextFactory = new SecretTextFactory($this->objectManager, $this->secretIteratorFactory);

        $this->decode = new Decode($this->decodeBit,  $this->infoMarkFactory, $this->secretTextFactory);

        // encode arguments
        $this->filterManager = new FilterManager();

        $this->asciiFactory = new AsciiFactory($this->objectManager);

        $this->textToBinaryFilter = new TextToBinaryFilter($this->asciiFactory);

        $this->secretEncode = new SecretEncode($this->filterManager, $this->infoMarkFactory, $this->secretTextFactory);

        $this->nameGenerator = new PrefixTime('lsb-text');

        // decode arguments
        $this->binaryToTextFilter = new BinaryToTextFilter();

        $this->secretDecode = new SecretDecode($this->filterManager);

        $this->stegoSystem = new StegoSystem($this->encode, $this->decode);
    }

    /**
     * @dataProvider providerEncode
     *
     * @param string $textToEncode
     * @param string $coverPath
     */
    public function testEncode(string $textToEncode, string $coverPath)
    {
        $coverPath = $this->getPath($coverPath);
        $exportPath = $this->getPath('tmp');

        // secret text
        $this->filterManager->attach($this->textToBinaryFilter);
        $secretText = $this->secretEncode->encode($textToEncode);

        // image
        $image = $this->imageHelper->getJpegImage($coverPath);

        // cover text
        $coverText = new CoverText($image);

        // encode
        $stegoText = $this->stegoSystem->encode($secretText, $coverText);

        // export
        $writablePath = new WritablePath($exportPath);
        $jpegFileExport = new JpegFile($writablePath, $this->nameGenerator);

        $exportFilePath = $jpegFileExport->export($coverText->getImage()->getResource());
        $this->assertFileExists($exportFilePath);

        self::$stegoTextContainer[] = [
            'textToEncode' => $textToEncode,
            'stegoText' => $stegoText,
        ];
    }

    /**
     * @depends testEncode
     */
    public function testDecode()
    {
        $this->filterManager->attach($this->binaryToTextFilter);

        foreach (self::$stegoTextContainer as $item) {
            $secretText = $this->stegoSystem->decode($item['stegoText']);
            $actualText = $this->secretDecode->decode($secretText);

            $this->assertEquals($item['textToEncode'], $actualText);
        }
    }

    public function providerEncode()
    {
        return [
            [
                'Hello Steganography!',
                'cover' . DIRECTORY_SEPARATOR . 'ukranian-stamp-1994-ivan-kotliarevsky-150-107px.jpg'
            ], [
                $this->getFileContents('secret' . DIRECTORY_SEPARATOR . 'ivan-kotliarevsky.txt'),
                'cover' . DIRECTORY_SEPARATOR . 'oleksandr-murashko-annunciation-388x481px.jpg'
            ],
        ];
    }
}
