<?php

namespace OrangeJuice\Flysystem\WebDAV\Test;

use League\Flysystem\Config;
use League\Flysystem\Filesystem;
use OrangeJuice\Flysystem\WebDAV\WebDAVAdapter;
use PHPUnit\Framework\TestCase;
use LogicException;

class WebDAVTests extends TestCase
{
    protected function getClient()
    {
        return \Mockery::mock('\Sabre\DAV\Client');
    }

    public function testHas()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->once()->andReturn([
            'statusCode' => 200,
        ]);
        $adapter = new Filesystem(new WebDAVAdapter($mock));
        $this->assertTrue($adapter->has('something'));
    }

    public function testHasFail()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->once()->andThrow('\Sabre\DAV\Exception\FileNotFound');
        $adapter = new WebDAVAdapter($mock);
        $this->assertFalse($adapter->has('something'));
    }

    public function testWrite()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->once();
        $adapter = new WebDAVAdapter($mock);
        $this->assertIsArray($adapter->write('something', 'something', new Config()));
    }

    public function testUpdate()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->once();
        $adapter = new WebDAVAdapter($mock);
        $this->assertIsArray($adapter->update('something', 'something', new Config()));
    }

    /**
     * @expectedException LogicException
     */
    public function testWriteVisibility()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->once();
        $adapter = new WebDAVAdapter($mock);
        $this->expectException(LogicException::class);
        $adapter->write('something', 'something', new Config([
            'visibility' => 'private',
        ]));
    }

    public function testReadStream()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->andReturn([
            'statusCode' => 200,
            'body' => 'contents',
            'headers' => [
                'last-modified' => date('Y-m-d H:i:s'),
            ],
        ]);
        $adapter = new WebDAVAdapter($mock, 'bucketname', 'prefix');
        $result = $adapter->readStream('file.txt');
        $this->assertIsResource($result['stream']);
    }

    public function testRename()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->once()->andReturn([
            'statusCode' => 200,
        ]);
        $adapter = new WebDAVAdapter($mock, 'bucketname');
        $result = $adapter->rename('old', 'new');
        $this->assertTrue($result);
    }

    public function testRenameFail()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->once()->andReturn([
            'statusCode' => 404,
        ]);
        $adapter = new WebDAVAdapter($mock, 'bucketname');
        $result = $adapter->rename('old', 'new');
        $this->assertFalse($result);
    }

    public function testRenameFailException()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->once()->andThrow('\Sabre\DAV\Exception\FileNotFound');
        $adapter = new WebDAVAdapter($mock, 'bucketname');
        $result = $adapter->rename('old', 'new');
        $this->assertFalse($result);
    }

    public function testDeleteDir()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->with('DELETE', 'some/dirname')->once()->andReturn(true);
        $adapter = new WebDAVAdapter($mock);
        $result = $adapter->deleteDir('some/dirname');
        $this->assertTrue($result);
    }

    public function testDeleteDirFail()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->with('DELETE', 'some/dirname')->once()->andThrow('\Sabre\DAV\Exception\FileNotFound');
        $adapter = new WebDAVAdapter($mock);
        $result = $adapter->deleteDir('some/dirname');
        $this->assertFalse($result);
    }

    public function testListContents()
    {
        $mock = $this->getClient();
        $first = [
            [],
            'filename' => [
                '{DAV:}getcontentlength' => 20,
            ],
            'dirname' => [
                // '{DAV:}getcontentlength' => 20,
            ],
        ];

        $second = [
            [],
            'deeper_filename.ext' => [
                '{DAV:}getcontentlength' => 20,
            ],
        ];
        $mock->shouldReceive('propFind')->twice()->andReturn($first, $second);
        $adapter = new WebDAVAdapter($mock, 'bucketname');
        $listing = $adapter->listContents('', true);
        $this->assertIsArray($listing);
    }

    public static function methodProvider()
    {
        return [
            ['getMetadata'],
            ['getTimestamp'],
            ['getMimetype'],
            ['getSize'],
        ];
    }

    /**
     * @dataProvider  methodProvider
     */
    public function testMetaMethods($method)
    {
        $mock = $this->getClient();
        $mock->shouldReceive('propFind')->once()->andReturn([
            '{DAV:}displayname' => 'object.ext',
            '{DAV:}getcontentlength' => 30,
            '{DAV:}getcontenttype' => 'plain/text',
            '{DAV:}getlastmodified' => date('Y-m-d H:i:s'),
        ]);
        $adapter = new WebDAVAdapter($mock);
        $result = $adapter->{$method}('object.ext');
        $this->assertIsArray($result);
    }

    public function testCreateDir()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->with('MKCOL', 'dirname')->once()->andReturn([
            'statusCode' => 201,
        ]);
        $adapter = new WebDAVAdapter($mock);
        $result = $adapter->createDir('dirname', new Config());
        $this->assertIsArray($result);
    }

    public function testCreateDirFail()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->with('MKCOL', 'dirname')->once()->andReturn([
            'statusCode' => 500,
        ]);
        $adapter = new WebDAVAdapter($mock);
        $result = $adapter->createDir('dirname', new Config());
        $this->assertFalse($result);
    }

    public function testRead()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->andReturn([
            'statusCode' => 200,
            'body' => 'contents',
            'headers' => [
                'last-modified' => [date('Y-m-d H:i:s')],
            ],
        ]);
        $adapter = new WebDAVAdapter($mock, 'bucketname', 'prefix');
        $result = $adapter->read('file.txt');
        $this->assertIsArray($result);
    }

    public function testReadFail()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->andReturn([
            'statusCode' => 404,
            'body' => 'contents',
            'headers' => [
                'last-modified' => [date('Y-m-d H:i:s')],
            ],
        ]);
        $adapter = new WebDAVAdapter($mock, 'bucketname', 'prefix');
        $result = $adapter->read('file.txt');
        $this->assertFalse($result);
    }

    public function testReadStreamFail()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->andReturn([
            'statusCode' => 404,
            'body' => 'contents',
            'headers' => [
                'last-modified' => [date('Y-m-d H:i:s')],
            ],
        ]);
        $adapter = new WebDAVAdapter($mock, 'bucketname', 'prefix');
        $result = $adapter->readStream('file.txt');
        $this->assertFalse($result);
    }

    public function testReadException()
    {
        $mock = $this->getClient();
        $mock->shouldReceive('request')->andThrow('\Sabre\DAV\Exception\FileNotFound');
        $adapter = new WebDAVAdapter($mock, 'bucketname', 'prefix');
        $result = $adapter->read('file.txt');
        $this->assertFalse($result);
    }
}
