<?php

namespace lukaszmakuch\RosmaroSf;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class RosmaroSfSessionStorageTest extends \PHPUnit_Framework_TestCase
{
    private $storage;

    protected function setUp()
    {
        $this->storage = new RosmaroSfSessionStorage(
            new Session(new MockArraySessionStorage),
            "prefix"
        );
    }

    public function testFetchingFirstTime()
    {
        $this->assertEquals(
            [['first state']],
            $this->storage->getAllStatesDataFor('id', ['first state'])
        );
    }

    public function testFetchingCurrent()
    {
        $this->assertEquals(
            ['first state'],
            $this->storage->getCurrentStateDataFor('id', ['first state'])
        );
    }

    public function testRemovingData()
    {
        $this->storage->storeFor("id", ["a"]);
        $this->storage->removeAllDataFor("id");
        $this->assertEquals(
            [["b"]],
            $this->storage->getAllStatesDataFor('id', ['b'])
        );
    }

    public function testReversion()
    {
        $this->storage->storeFor('id', ['id' => 'q', 'other']);
        $this->storage->storeFor('id', ['id' => 'w', 'other']);
        $this->storage->storeFor('id', ['id' => 'e', 'other']);

        $this->storage->revertFor('id', 'w');

        $this->assertEquals(
            [['id' => 'q', 'other'], ['id' => 'w', 'other']],
            $this->storage->getAllStatesDataFor("id", "not important")
        );
    }

    public function testStoryingStates()
    {
        $this->storage->storeFor("id1", ["data1"]);
        $this->storage->storeFor("id1", ["data2"]);
        $this->assertEquals(
            [["data1"], ["data2"]],
            $this->storage->getAllStatesDataFor("id1", "not important")
        );
    }


}
