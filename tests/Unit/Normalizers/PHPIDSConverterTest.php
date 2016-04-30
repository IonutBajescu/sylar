<?php

namespace Ionut\Sylar\Tests\Unit\Normalizers;


use Ionut\Sylar\Normalizers\PHPIDSConverter;
use Ionut\Sylar\Tests\TestCase;

class PHPIDSConverterTest extends TestCase
{
    /**
     * @var PHPIDSConverter
     */
    protected $converter;

    public function setUp()
    {
        $this->converter = new PHPIDSConverter();
    }

    public function testConversion()
    {
        $exploits = [
            "<IMG SRC=&#x6A&#x61&#x76&#x61&#x73&#x63&#x72&#x69&#x70&#x74&#x3A&#x61&#x6C&#x65&#x72&#x74&#x28&#x27&#x58&#x53&#x53&#x27&#x29>" => '<IMG SRC=javascript:alert("XSS")>',

            "<IMG SRC=\"jav	ascript:alert('XSS');\">" => '<IMG SRC="javascript:alert("XSS");',

            "<IMG SRC=\"jav&#x09;ascript:alert('XSS');\">" => '<IMG SRC="javascript:alert("XSS");">',

            "\ntest\n" => '  test  ',

            "\\ntest\\n" => ';test;',

            "t--damn-est" => "t;est",

            "damn#test\na" => 'damna'
        ];

        foreach ($exploits as $exploit => $converted) {
            $this->assertContains(
                $converted,
                $this->converter->normalize([$exploit])[0]->variants[PHPIDSConverter::class]->getValue()
            );
        }
    }
}