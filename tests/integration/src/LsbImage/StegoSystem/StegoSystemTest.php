<?php
namespace Picamator\SteganographyKit2\Tests\Integration\LsbImage\StegoSystem;

use Picamator\SteganographyKit2\Kernel\CoverText\CoverText;
use Picamator\SteganographyKit2\Kernel\File\Builder\InfoFactory;
use Picamator\SteganographyKit2\Kernel\File\Builder\InfoPaletteFactory;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\PrefixTime;
use Picamator\SteganographyKit2\Kernel\File\Data\WritablePath;
use Picamator\SteganographyKit2\Kernel\Image\Converter\BinaryToImage;
use Picamator\SteganographyKit2\Kernel\Image\Converter\ImageToBinary;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegFile;
use Picamator\SteganographyKit2\Kernel\Image\ImageFactory;
use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;
use Picamator\SteganographyKit2\Kernel\SecretText\InfoMarkFactory;
use Picamator\SteganographyKit2\Kernel\SecretText\SecretTextFactory;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Decode;
use Picamator\SteganographyKit2\LsbImage\SecretText\Decode as SecretDecode;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Encode;
use Picamator\SteganographyKit2\LsbImage\SecretText\Encode as SecretEncode;
use Picamator\SteganographyKit2\Kernel\StegoSystem\StegoSystem;
use Picamator\SteganographyKit2\Kernel\StegoText\StegoTextFactory;
use Picamator\SteganographyKit2\Kernel\SecretText\Iterator\SerialIteratorFactory as SecretIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;
use Picamator\SteganographyKit2\Lsb\StegoSystem\DecodeBit;
use Picamator\SteganographyKit2\Lsb\StegoSystem\EncodeBit;
use Picamator\SteganographyKit2\Tests\Helper\Kernel\Image\ImageHelper;
use Picamator\SteganographyKit2\Tests\Integration\LsbImage\BaseTest;

class StegoSystemTest extends BaseTest
{
    /**
     * @var array [['secretPath' => ..., 'stegoText' => ...], ...]
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
     * @var ByteFactory
     */
    private $byteFactory;

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
     * @var SizeFactory
     */
    private $sizeFactory;

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
     * @var ImageToBinary
     */
    private $imageToBinary;

    /**
     * @var SecretEncode
     */
    private $secretEncode;

    /**
     * @var ColorFactory
     */
    private $colorFactory;

    /**
     * @var InfoPaletteFactory
     */
    private $infoPaletteFactory;

    /**
     * @var ImageFactory
     */
    private $imageFactory;

    /**
     * @var BinaryToImage
     */
    private $binaryToImage;

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
        $this->byteFactory = new ByteFactory($this->objectManager);

        $this->encodeBit = new EncodeBit($this->byteFactory);

        $this->stegoTextFactory = new StegoTextFactory($this->objectManager);

        $this->encode = new Encode($this->encodeBit, $this->stegoTextFactory);

        // decode
        $this->decodeBit = new DecodeBit();

        $this->sizeFactory = new SizeFactory($this->objectManager);

        $this->infoMarkFactory = new InfoMarkFactory($this->objectManager, $this->sizeFactory);

        $this->secretIteratorFactory = new SecretIteratorFactory($this->objectManager);

        $this->secretTextFactory = new SecretTextFactory($this->objectManager, $this->secretIteratorFactory);

        $this->decode = new Decode($this->decodeBit,  $this->infoMarkFactory, $this->secretTextFactory);

        // encode arguments
        $this->imageToBinary = new ImageToBinary($this->imageHelper->getChannel());

        $this->secretEncode = new SecretEncode($this->imageToBinary, $this->infoMarkFactory, $this->secretTextFactory);

        // decode arguments
        $nullByte = new NullByte();
        $this->colorFactory = new ColorFactory($this->objectManager, $nullByte);

        $this->infoPaletteFactory = new InfoPaletteFactory($this->objectManager);

        $this->imageFactory = $this->imageHelper->getPaletteImageFactory();

        $this->binaryToImage = new BinaryToImage(
            $this->imageHelper->getChannel(),
            $this->byteFactory,
            $this->colorFactory,
            $this->infoPaletteFactory,
            $this->imageFactory
        );

        $this->secretDecode = new SecretDecode($this->binaryToImage);

        $this->stegoSystem = new StegoSystem($this->encode, $this->decode);
    }

    /**
     * @dataProvider providerEncode
     *
     * @param string $secretPath
     * @param string $coverPath
     */
    public function testEncode(string $secretPath, string $coverPath)
    {
        $secretPath = $this->getPath($secretPath);
        $coverPath = $this->getPath($coverPath);
        $exportPath = $this->getPath('tmp');

        // secret text
        $secretImage = $this->imageHelper->getJpegImage($secretPath);
        $secretText = $this->secretEncode->encode($secretImage);

        // image
        $image = $this->imageHelper->getJpegImage($coverPath);

        // cover text
        $coverText = new CoverText($image);

        // encode
        $stegoText = $this->stegoSystem->encode($secretText, $coverText);

        // export
        $writablePath = new WritablePath($exportPath);
        $nameGenerator = new PrefixTime('lsb-image-stego');

        $jpegFileExport = new JpegFile($writablePath, $nameGenerator);

        $exportFilePath = $jpegFileExport->export($coverText->getImage()->getResource());
        $this->assertFileExists($exportFilePath);

        self::$stegoTextContainer[] = [
            'secretPath' => $secretPath,
            'stegoText' => $stegoText,
        ];
    }

    /**
     * @depends testEncode
     */
    public function testDecode()
    {
        $exportPath = $this->getPath('tmp');

        // info
        $infoFactory = new InfoFactory($this->objectManager, $this->sizeFactory);

        // export
        $writablePath = new WritablePath($exportPath);
        $nameGenerator = new PrefixTime('lsb-image-secret');

        $jpegFileExport = new JpegFile($writablePath, $nameGenerator);

        foreach (self::$stegoTextContainer as $item) {
            $secretText = $this->stegoSystem->decode($item['stegoText']);
            $actualText = $this->secretDecode->decode($secretText);

            $exportFilePath = $jpegFileExport->export($actualText->getResource());
            $this->assertFileExists($exportFilePath);

            // size
            $expectedInfo = $infoFactory->create($item['secretPath']);
            $actualInfo = $actualText->getInfo();

            $this->assertEquals($expectedInfo->getSize()->getWidth(), $actualInfo->getSize()->getWidth());
            $this->assertEquals($expectedInfo->getSize()->getHeight(), $actualInfo->getSize()->getHeight());
        }
    }

    public function providerEncode()
    {
        return [
            [
                'secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg',
                'cover' . DIRECTORY_SEPARATOR . 'oleksandr-murashko-annunciation-388x481px.jpg'
            ],
        ];
    }
}
