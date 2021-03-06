<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.5
 *
 * @copyright 2010-2015 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\ApiReference;

use Mockery as m;
use phpDocumentor\DocumentGroupFormat;
use phpDocumentor\Reflection\Element;
use phpDocumentor\Reflection\Fqsen;

/**
 * Test case for Api
 * @coversDefaultClass phpDocumentor\ApiReference\Api
 */
class ApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getFormat
     */
    public function testGetFormat()
    {
        $documentGroupFormat = new DocumentGroupFormat('api');
        $api = new Api($documentGroupFormat);

        $this->assertSame($documentGroupFormat, $api->getFormat());
    }

    /**
     * @covers ::__construct
     * @covers ::findElementByFqsen
     */
    public function testFindNotExistingElementByFqsen()
    {
        $documentGroupFormat = new DocumentGroupFormat('api');
        $api = new Api($documentGroupFormat);

        $this->assertNull($api->findElementByFqsen(new Fqsen('\My\Class')));
    }

    /**
     * @covers ::__construct
     * @covers ::findElementByFqsen
     * @covers ::addElement
     */
    public function testFindElementByFqsen()
    {
        $fqsen = new Fqsen('\My\Class');

        $elementMock = m::mock(Element::class);
        $elementMock
            ->shouldReceive('getFqsen')
            ->andReturn($fqsen);

        $documentGroupFormat = new DocumentGroupFormat('api');
        $api = new Api($documentGroupFormat);

        $api->addElement($elementMock);

        $this->assertSame($elementMock, $api->findElementByFqsen($fqsen));
    }

    /**
     * @covers ::__construct
     * @covers ::getElements
     * @covers ::addElement
     */
    public function testGetElements()
    {
        $fqsen = new Fqsen('\My\Class');

        $elementMock = m::mock(Element::class);
        $elementMock
            ->shouldReceive('getFqsen')
            ->andReturn($fqsen);

        $documentGroupFormat = new DocumentGroupFormat('api');
        $api = new Api($documentGroupFormat);

        $api->addElement($elementMock);

        $this->assertEquals(
            [
                '\My\Class' => $elementMock,
            ],
            $api->getElements()
        );
    }
}
