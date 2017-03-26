<?php
namespace Picamator\SteganographyKit2\Tests\Integration\LsbImage\StegoSystem;

use Picamator\SteganographyKit2\Kernel\CoverText\CoverText;
use Picamator\SteganographyKit2\Kernel\Entity\PixelFactory;
use Picamator\SteganographyKit2\Kernel\Entity\PixelRepositoryFactory;
use Picamator\SteganographyKit2\Kernel\File\Data\WritablePath;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\PrefixTime;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\SourceIdentical;
use Picamator\SteganographyKit2\Kernel\Image\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Image\Converter\BinaryToPaletteConverter;
use Picamator\SteganographyKit2\Kernel\Image\Data\Channel;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegFile;
use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Kernel\Image\InfoFactory;
use Picamator\SteganographyKit2\Kernel\Image\RepositoryFactory;
use Picamator\SteganographyKit2\Kernel\Image\Resource\JpegResource;
use Picamator\SteganographyKit2\Kernel\Image\Resource\PaletteResource;
use Picamator\SteganographyKit2\Kernel\Image\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\Data\NullByte;
use Picamator\SteganographyKit2\Kernel\Primitive\PointFactory;
use Picamator\SteganographyKit2\Kernel\SecretText\EndMark;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Decode;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Encode;
use Picamator\SteganographyKit2\Kernel\StegoSystem\StegoSystem;
use Picamator\SteganographyKit2\Kernel\StegoText\StegoTextFactory;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\IteratorFactory as ImageIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Entity\Iterator\IteratorFactory as PixelIteratoryFactory;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;
use Picamator\SteganographyKit2\Lsb\StegoSystem\DecodeBit;
use Picamator\SteganographyKit2\Lsb\StegoSystem\EncodeBit;
use Picamator\SteganographyKit2\LsbImage\SecretText\SecretText;
use Picamator\SteganographyKit2\LsbImage\SecretText\SecretTextFactory;
use Picamator\SteganographyKit2\Tests\Integration\LsbText\BaseTest;

class StegoSystemTest extends BaseTest
{
    /**
     * @var array of ['stegoSystem'=> ..., 'stegoText' => ..., 'secretText' => ...]
     */
    private static $stegoTextContainer = [];

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
     * @var ColorFactory
     */
    private $colorFactory;

    /**
     * @var StegoTextFactory
     */
    private $stegoTextFactory;

    /**
     * @var Encode
     */
    private $encode;

    /**
     * @var EndMark
     */
    private $endMark;

    /**
     * @var DecodeBit
     */
    private $decodeBit;

    /**
     * @var PointFactory
     */
    private $pointFactory;

    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var ColorIndex
     */
    private $colorIndex;

    /**
     * @var RepositoryFactory
     */
    private $repositoryFactory;

    /**
     * @var ImageIteratorFactory
     */
    private $imageIteratorFactory;

    /**
     * @var SizeFactory
     */
    private $sizeFactory;

    /**
     * @var InfoFactory
     */
    private $infoFactory;

    /**
     * @var SourceIdentical
     */
    private $nameGenerator;

    /**
     * @var BinaryToPaletteConverter
     */
    private $converter;

    protected function setUp()
    {
        parent::setUp();

        // util
        $this->objectManager = new ObjectManager();

        // encode
        $this->byteFactory = new ByteFactory($this->objectManager);

        $this->encodeBit = new EncodeBit( $this->byteFactory);

        $nullByte = new NullByte();
        $this->colorFactory = new ColorFactory($this->objectManager, $nullByte);

        $this->stegoTextFactory = new StegoTextFactory($this->objectManager);

        $this->colorIndex = new ColorIndex($this->byteFactory, $this->colorFactory);

        $this->repositoryFactory = new PixelRepositoryFactory($this->objectManager, $this->colorIndex, $this->colorFactory);

        $this->encode = new Encode($this->encodeBit, $this->repositoryFactory, $this->stegoTextFactory);

        // decode
        $this->endMark = new EndMark();

        $this->decodeBit = new DecodeBit();

        // encode arguments
        $this->pointFactory = new PointFactory($this->objectManager);

        $this->channel = new Channel(['red', 'green', 'blue']);

        $iteratorFactory = new PixelIteratoryFactory($this->objectManager, $this->channel);

        $pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        $this->imageIteratorFactory = new ImageIteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $pixelFactory
        );

        $this->sizeFactory = new SizeFactory($this->objectManager);

        $this->infoFactory = new InfoFactory($this->objectManager, $this->sizeFactory);

        // export
        $this->nameGenerator = new PrefixTime('lsb-image');

        // converter
        $this->converter = new BinaryToPaletteConverter(
            $this->channel,
            $this->byteFactory,
            $this->colorFactory,
            $this->repositoryFactory
        );
    }

    /**
     * @dataProvider providerEncode
     *
     * @param string $secretPath
     * @param string $coverPath
     */
    public function testEncode(string $secretPath, string $coverPath)
    {
        $this->markTestIncomplete();

        $coverPath = $this->getPath($coverPath);
        $secretPath = $this->getPath($secretPath);
        $exportPath = $this->getPath('tmp');

        // export
        $writablePath = new WritablePath($exportPath);
        $jpegFileExport = new JpegFile($writablePath, $this->nameGenerator);

        // secret text
        $secretText = $this->getSecretText($secretPath);

        // cover text
        $coverText = $this->getCoverText($coverPath);

        // decode
        $secretInfo = $this->infoFactory->create($secretPath);

        $name = $this->nameGenerator->generate($secretPath);
        $resource = new PaletteResource($secretInfo->getSize(), $name);

        $iteratorFactory = new PixelIteratoryFactory(
            $this->objectManager,
            $this->channel,
            'Picamator\SteganographyKit2\Kernel\Entity\Iterator\SerialBitwiseIterator'
        );
        $pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        $imageIteratorFactory = new ImageIteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $pixelFactory
        );

        $image = new Image($resource, $imageIteratorFactory, $jpegFileExport);

        $converter = new BinaryToPaletteConverter(
            $this->channel,
            $this->byteFactory,
            $this->colorFactory,
            $this->repositoryFactory
        );

        $secretTextFactory = new SecretTextFactory($this->objectManager, $image, $this->channel, $converter);
        $decode = new Decode($this->decodeBit, $this->endMark, $secretTextFactory);

        // stego system
        $stegoSystem = new StegoSystem($this->encode, $decode);

        // encode
        $stegoText = $stegoSystem->encode($secretText, $coverText);

//        $exportFilePath = $image->export();
//        $this->assertFileExists($exportFilePath);

        self::$stegoTextContainer[] = [
            'stegoSystem' => $stegoSystem,
            'secretText' => $secretText,
            'stegoText' => $stegoText,
        ];
    }

    /**
     * @depends testEncode
     */
    public function testDecode()
    {
        $this->markTestIncomplete();

        $exportPath = $this->getPath('tmp');

        foreach (self::$stegoTextContainer as $item) {
            /** @var SecretText $secretText */
            $secretText = $item['stegoSystem']->decode($item['stegoText']);

            $writablePath = new WritablePath($exportPath);
            $jpegFileExport = new JpegFile($writablePath, $this->nameGenerator);

            $path = $jpegFileExport->export($secretText->getResource());

            $this->assertFileExists($path);
        }
    }

    public function providerEncode()
    {
        return [
            [
                'secret' . DIRECTORY_SEPARATOR . 'black-white-horizontal-stripe-25x1px.jpg',
                'cover' . DIRECTORY_SEPARATOR . 'oleksandr-murashko-girl-in-a-red-нat-521x700px.jpg'
            ]
        ];
    }

    /**
     * Gets secret text
     *
     * @param string $secretPath
     *
     * @return SecretText
     */
    private function getSecretText(string $secretPath) : SecretText
    {
        $info = $this->infoFactory->create($secretPath);

        $resource = new JpegResource($info->getSize(), $secretPath);

        $iteratorFactory = new PixelIteratoryFactory(
            $this->objectManager,
            $this->channel,
            'Picamator\SteganographyKit2\Kernel\Entity\Iterator\SerialBitwiseIterator'
        );
        $pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        $imageIteratorFactory = new ImageIteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $this->pointFactory,
            $pixelFactory
        );

        $jpegFileExport = $this->getJpegExport();

        $secretImage = new Image($resource, $imageIteratorFactory, $jpegFileExport);

        return new SecretText($secretImage, $this->channel);
    }

    /**
     * Gets cover text
     *
     * @param string $coverPath
     *
     * @return CoverText
     */
    private function getCoverText(string $coverPath) : CoverText
    {
        $info = $this->infoFactory->create($coverPath);

        $resource = new JpegResource($info->getSize(), $coverPath);

        $jpegFileExport = $this->getJpegExport();

        $coverImage = new Image($resource, $this->imageIteratorFactory, $jpegFileExport);

       return new CoverText($coverImage);
    }

    /**
     * Gets Jpeg export
     *
     * @return JpegFile
     */
    private function getJpegExport() : JpegFile
    {
        $exportPath = $this->getPath('tmp');

        // export
        $writablePath = new WritablePath($exportPath);

        return new JpegFile($writablePath, $this->nameGenerator);
    }
}
