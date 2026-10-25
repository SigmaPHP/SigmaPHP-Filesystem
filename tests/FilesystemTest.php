<?php

namespace SigmaPHP\Filesystem\Tests;

use PHPUnit\Framework\TestCase;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Filesystem\Exceptions\PathNotFoundException;

/**
 * Filesystem Test
 */
class FilesystemTest extends TestCase
{
    /**
     * @var Filesystem $filesystem
     */
    private $filesystem;

    /**
     * @var string $path
     */
    private $path;

    /**
     * @var string $newPath
     */
    private $newPath;

    /**
     * @var string $dirPath
     */
    private $dirPath;

    /**
     * FilesystemTest SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->filesystem = new Filesystem();

        $this->path = __DIR__ . '/testing.txt';

        $this->newPath = __DIR__ . '/dump.txt';

        $this->dirPath = __DIR__ . '/examples';

        // create the dummy files and directories
        if (!file_exists($this->path)) {
            touch($this->path);
        }

        if (!file_exists($this->newPath)) {
            touch($this->newPath);
        }

        if (!file_exists($this->dirPath)) {
            mkdir($this->dirPath);
        }
    }

    /**
     * FilesystemTest TearDown
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();

        // remove the dummy files and directories
        if (file_exists($this->path)) {
            unlink($this->path);
        }

        if (file_exists($this->newPath)) {
            unlink($this->newPath);
        }

        if (file_exists($this->dirPath)) {
            rmdir($this->dirPath);
        }
    }

    /**
     * Test list files.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testListFiles()
    {
        $this->assertEquals([
            '2.txt',
            '3.txt',
            '1.txt',
        ], $this->filesystem->list(__DIR__ . '/test_dir'));

        $this->assertEquals([
            __DIR__ . '/test_dir/2.txt',
            __DIR__ . '/test_dir/3.txt',
            __DIR__ . '/test_dir/1.txt',
        ], $this->filesystem->list(__DIR__ . '/test_dir', true));

        $this->assertEquals([
            '2',
            '3',
            '1',
        ], $this->filesystem->list(__DIR__ . '/test_dir', false, false));

        $this->assertEquals(
            [__DIR__ . '/test_dir/1.txt'],
            $this->filesystem->list(__DIR__ . '/test_dir/1.txt')
        );
    }

    /**
     * Test will throw exception if the provided path doesn't exist.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testWillThrowExceptionIfTheProvidedPathDoesNotExist()
    {
        $this->expectException(PathNotFoundException::class);

        $this->filesystem->list(__DIR__ . '/nowhere');
    }

    /**
     * Test file exists.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testFileExists()
    {
        $this->assertTrue(
            $this->filesystem->exists(__DIR__ . '/FilesystemTest.php')
        );
    }

    /**
     * Test directory has a file.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testDirectoryHasAFile()
    {
        $this->assertTrue(
            $this->filesystem->dirHas(__DIR__, 'test_dir')
        );
    }

    /**
     * Test create file.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCreateFile()
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }

        $this->filesystem->create($this->path);

        $this->assertTrue(file_exists($this->path));

        $this->assertEquals(
            '0755',
            substr(sprintf('%o', fileperms($this->path)), -4)
        );
    }

    /**
     * Test create file with content.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCreateFileWithContent()
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }

        $this->filesystem->create($this->path, 'test');

        $this->assertEquals('test', file_get_contents($this->path));
    }

    /**
     * Test rename file.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testRenameFile()
    {
        $this->filesystem->rename($this->path, $this->newPath);

        $this->assertTrue(file_exists($this->newPath));
        $this->assertFalse(file_exists($this->path));
    }

    /**
     * Test copy file.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCopyFile()
    {
        $this->filesystem->copy($this->path, $this->newPath);

        $this->assertTrue(file_exists($this->newPath));
        $this->assertTrue(file_exists($this->path));
    }

    /**
     * Test move file.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testMoveFile()
    {
        $this->filesystem->move($this->path, $this->newPath);

        $this->assertTrue(file_exists($this->newPath));
        $this->assertFalse(file_exists($this->path));
    }

    /**
     * Test remove file.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testRemoveFile()
    {
        $this->filesystem->remove($this->path);

        $this->assertFalse(file_exists($this->path));
    }

    /**
     * Test write to file.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testWriteToFile()
    {
        $this->filesystem->write($this->path, 'Hello SigmaPHP!');

        $this->assertEquals('Hello SigmaPHP!', file_get_contents($this->path));
    }

    /**
     * Test append to file.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testAppendToFile()
    {
        file_put_contents($this->path, 'Hello ');

        $this->filesystem->append($this->path, 'SigmaPHP!');

        $this->assertEquals('Hello SigmaPHP!', file_get_contents($this->path));
    }

    /**
     * Test read from file.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testReadFromFile()
    {
        file_put_contents($this->path, 'Hello SigmaPHP!');

        $this->assertEquals(
            'Hello SigmaPHP!',
            $this->filesystem->read($this->path)
        );
    }

    /**
     * Test create directory.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCreateDirectory()
    {
        if (file_exists($this->dirPath)) {
            rmdir($this->dirPath);
        }

        $this->filesystem->createDir($this->dirPath);

        $this->assertTrue(file_exists($this->dirPath));
        $this->assertTrue(is_dir($this->dirPath));
    }

    /**
     * Test remove directory.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testRemoveDirectory()
    {
        $this->filesystem->removeDir($this->dirPath);

        $this->assertFalse(file_exists($this->dirPath));
    }

    /**
     * Test remove non-empty directory.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testRemoveNonEmptyDirectory()
    {
        $this->filesystem->move($this->path, $this->dirPath . '/testing.txt');

        $this->filesystem->removeDir($this->dirPath);

        $this->assertFalse(file_exists($this->dirPath));
    }

    /**
     * Test symlink.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testSymlink()
    {
        $link = 'my_link';

        $this->filesystem->symlink($this->path, $link);

        $this->assertTrue(file_exists($link));
        $this->assertTrue(is_link($link));

        if (file_exists($link)) {
            unlink($link);
        }
    }

    /**
     * Test concatenate paths.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testConcatenatePaths()
    {
        $this->assertEquals(
            __DIR__ . DIRECTORY_SEPARATOR .
            'path' . DIRECTORY_SEPARATOR .
            'to' . DIRECTORY_SEPARATOR .
            'somewhere',
            $this->filesystem->concatPath(
                __DIR__,
                'path',
                'to',
                'somewhere'
            )
        );
    }

    /**
     * Test add extension.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testAddExtension()
    {
        $this->assertEquals(
            'script.min.js',
            $this->filesystem->addExtension('script', 'min.js')
        );
    }

    /**
     * Test remove extension.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testRemoveExtension()
    {
        $this->assertEquals(
            'script',
            $this->filesystem->removeExtension('script.min.js')
        );
    }

    /**
     * Test get file name.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testGetFileName()
    {
        $this->assertEquals(
            'script.min.js',
            $this->filesystem->getFileName('/path/to/assets/js/script.min.js')
        );
    }

    /**
     * Test change file's mode.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testChangeFileMode()
    {
        $this->filesystem->changeMode($this->path, 0666);

        $this->assertEquals(
            '0666',
            substr(sprintf('%o', fileperms($this->path)), -4)
        );
    }

    /**
     * Test change file's group.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testChangeFileGroup()
    {
        $this->assertTrue(
            $this->filesystem->changeGroup($this->path, getmygid())
        );
    }

    /**
     * Test change file's owner.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testChangeFileOwner()
    {
        $this->assertTrue(
            $this->filesystem->changeOwner($this->path, getmyuid())
        );
    }

    /**
     * Test check is directory.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCheckIsDirectory()
    {
        $this->assertFalse($this->filesystem->isDir($this->path));
        $this->assertTrue($this->filesystem->isDir($this->dirPath));
    }
}
