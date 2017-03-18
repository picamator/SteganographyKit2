<?php
namespace Picamator\SteganographyKit2\Tests\Integration\LsbText\Text;

use Picamator\SteganographyKit2\Kernel\CoverText\CoverText;
use Picamator\SteganographyKit2\Kernel\Entity\PixelFactory;
use Picamator\SteganographyKit2\Kernel\File\NameGenerator\SourceIdentical;
use Picamator\SteganographyKit2\Kernel\Image\ColorFactory;
use Picamator\SteganographyKit2\Kernel\Image\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Image\Data\Channel;
use Picamator\SteganographyKit2\Kernel\Image\Export\JpegFile;
use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Kernel\Image\RepositoryFactory;
use Picamator\SteganographyKit2\Kernel\Image\Resource\JpegResource;
use Picamator\SteganographyKit2\Kernel\Image\SizeFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\ByteFactory;
use Picamator\SteganographyKit2\Kernel\Primitive\PointFactory;
use Picamator\SteganographyKit2\Kernel\SecretText\EndMark;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Decode;
use Picamator\SteganographyKit2\Kernel\StegoSystem\Encode;
use Picamator\SteganographyKit2\Kernel\StegoSystem\StegoSystem;
use Picamator\SteganographyKit2\Kernel\StegoText\StegoTextFactory;
use Picamator\SteganographyKit2\Kernel\Text\AsciiFactory;
use Picamator\SteganographyKit2\Kernel\Text\Filter\BinaryToTextFilter;
use Picamator\SteganographyKit2\Kernel\Text\FilterManager;
use Picamator\SteganographyKit2\Kernel\Text\Iterator\IteratorFactory as TextIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Image\Iterator\IteratorFactory as ImageIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Entity\Iterator\IteratorFactory as PixelIteratorFactory;
use Picamator\SteganographyKit2\Kernel\Text\LengthFactory;
use Picamator\SteganographyKit2\Kernel\Text\TextFactory;
use Picamator\SteganographyKit2\Kernel\Util\ObjectManager;
use Picamator\SteganographyKit2\Lsb\StegoSystem\DecodeBit;
use Picamator\SteganographyKit2\Lsb\StegoSystem\EncodeBit;
use Picamator\SteganographyKit2\LsbText\SecretText\SecretTextFactory;
use Picamator\SteganographyKit2\Tests\Integration\LsbText\BaseTest;

class StegoSystemTest extends BaseTest
{
    /**
     * @var array of ['stegoText' => ..., 'secretText' => ...]
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
     * @var FilterManager
     */
    private $filterManager;

    /**
     * @var AsciiFactory
     */
    private $asciiFactory;

    /**
     * @var TextIteratorFactory
     */
    private $textIteratorFactory;

    /**
     * @var LengthFactory
     */
    private $lengthFactory;

    /**
     * @var TextFactory
     */
    private $textFactory;

    /**
     * @var EndMark
     */
    private $endMark;

    /**
     * @var SecretTextFactory
     */
    private $secretTextFactory;

    /**
     * @var DecodeBit
     */
    private $decodeBit;

    /**
     * @var Decode
     */
    private $decode;

    /**
     * @var StegoSystem
     */
    private $stegoSystem;

    /**
     * @var ColorIndex
     */
    private $colorIndex;

    /**
     * @var ImageIteratorFactory
     */
    private $imageIteratorFactory;

    /**
     * @var SizeFactory
     */
    private $sizeFactory;

    /**
     * @var SourceIdentical
     */
    private $nameGenerator;

    protected function setUp()
    {
        parent::setUp();

        // util
        $this->objectManager = new ObjectManager();

        // encode
        $this->byteFactory = new ByteFactory($this->objectManager);

        $this->encodeBit = new EncodeBit( $this->byteFactory);

        $this->colorFactory = new ColorFactory($this->objectManager);

        $this->stegoTextFactory = new StegoTextFactory($this->objectManager);

        $this->colorIndex = new ColorIndex($this->byteFactory, $this->colorFactory);

        $repositoryFactory = new RepositoryFactory($this->objectManager, $this->colorIndex, $this->colorFactory);

        $this->encode = new Encode($this->encodeBit, $repositoryFactory, $this->stegoTextFactory);

        // decode
        $this->filterManager = new FilterManager();

        $this->asciiFactory = new AsciiFactory($this->objectManager, $this->byteFactory);

        $this->textIteratorFactory = new TextIteratorFactory($this->objectManager, $this->asciiFactory);

        $this->lengthFactory = new LengthFactory($this->objectManager);

        $this->textFactory = new TextFactory(
            $this->objectManager,
            $this->filterManager,
            $this->textIteratorFactory,
            $this->lengthFactory
        );

        $this->endMark = new EndMark();

        $this->secretTextFactory = new SecretTextFactory($this->objectManager, $this->textFactory, $this->endMark);

        $this->decodeBit = new DecodeBit();

        $this->decode = new Decode($this->secretTextFactory, $this->decodeBit, $this->endMark);

        // stego system
        $this->stegoSystem = new StegoSystem($this->encode, $this->decode);

        // encode arguments
        $pointFactory = new PointFactory($this->objectManager);

        $channel = new Channel();

        $iteratorFactory = new PixelIteratorFactory($this->objectManager, $channel);

        $pixelFactory = new PixelFactory($this->objectManager, $iteratorFactory);

        $this->imageIteratorFactory = new ImageIteratorFactory(
            $this->objectManager,
            $this->colorIndex,
            $pointFactory,
            $pixelFactory
        );

        $this->sizeFactory = new SizeFactory($this->objectManager);

        // export
        $this->nameGenerator = new SourceIdentical();
    }

    /**
     * @dataProvider providerEncode
     *
     * @param string $testToEncode
     * @param string $imagePath
     */
    public function testEncode(string $testToEncode, string $imagePath)
    {
        // secret text
        $secretText = $this->secretTextFactory->create($testToEncode);

        // image
        $imagePath = $this->getPath($imagePath);
        $resource = new JpegResource($this->sizeFactory, $imagePath);

        $image = new Image($resource, $this->imageIteratorFactory, $this->sizeFactory);

        // stego text
        $coverText = new CoverText($image);

        // encode
        $stegoText = $this->stegoSystem->encode($secretText, $coverText);

        // export
        $exportPath = $this->getPath('tmp');
        $jpegFileExport = new JpegFile(
            $stegoText->getImage(),
            $this->nameGenerator,
            $exportPath
        );

        $exportFilePath = $jpegFileExport->export();
        $this->assertFileExists($exportFilePath);

        self::$stegoTextContainer[] = [
            'secretText' => $secretText,
            'stegoText' => $stegoText,
        ];
    }

    /**
     * @depends testEncode
     */
    public function testDecode()
    {
        foreach (self::$stegoTextContainer as $item) {
            $secretText = $this->stegoSystem->decode($item['stegoText']);

            $binaryToTextFilter = new BinaryToTextFilter();
            $actualText = $binaryToTextFilter->filter($secretText->getResource());

            $this->assertEquals($item['secretText']->getResource(), $actualText);
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
