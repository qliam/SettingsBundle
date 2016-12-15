<?php

/**
 * This file is part of the DmishhSettingsBundle package.
 *
 * (c) 2013 Dmitriy Scherbina <http://dmishh.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dmishh\SettingsBundle\Tests;

use Dmishh\SettingsBundle\Serializer\SerializerFactory;

class SerializerTest extends AbstractTest
{
    public static $testData = array('abc' => '123', 123, 5.0);

    public function testPhpSerializer()
    {
        $serializer = SerializerFactory::create('php');
        $this->assertEquals(serialize(self::$testData), $serializer->serialize(self::$testData));
        $this->assertEquals(self::$testData, $serializer->unserialize($serializer->serialize(self::$testData)));
    }

    public function testJsonSerializer()
    {
        $serializer = SerializerFactory::create('json');
        $this->assertEquals(json_encode(self::$testData), $serializer->serialize(self::$testData));
        $this->assertEquals(self::$testData, $serializer->unserialize($serializer->serialize(self::$testData)));
    }

    public function testCustomSerializer()
    {
        $serializer = SerializerFactory::create('Dmishh\SettingsBundle\Tests\Serializer\CustomSerializer');
        $this->assertEquals(self::$testData, $serializer->unserialize($serializer->serialize(self::$testData)));
    }

    /**
     * @expectedException \Dmishh\SettingsBundle\Exception\UnknownSerializerException
     */
    public function testUnknownSerializer()
    {
        $serializer = SerializerFactory::create('unknown_serializer');
    }
}
