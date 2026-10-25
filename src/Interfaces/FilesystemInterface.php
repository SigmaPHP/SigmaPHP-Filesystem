<?php

namespace SigmaPHP\Filesystem\Interfaces;

/**
 * Filesystem Interface.
 */
interface FilesystemInterface
{
    /**
     * List all files inside a path and its sub-directories.
     *
     * @param string $path
     * @param bool $includeFullPath
     * @param bool $withExtension
     * @param bool $filesOnly
     * @return array<string>
     */
    public function list($path, $includeFullPath, $withExtension, $filesOnly);

    /**
     * Check if a path exists.
     *
     * @param string $path
     * @return bool
     */
    public function exists($path);

    /**
     * Check if a directory has a file or subdirectory.
     *
     * @param string $path
     * @param string $target
     * @return bool
     */
    public function dirHas($path, $target);

    /**
     * Create file.
     *
     * @param string $path
     * @param string $content
     * @param int $permission
     * @return bool
     */
    public function create($path, $content, $permission);

    /**
     * Rename files and directories.
     *
     * @param string $old
     * @param string $new
     * @return bool
     */
    public function rename($old, $new);

    /**
     * Copy file.
     *
     * @param string $src
     * @param string $dest
     * @return bool
     */
    public function copy($src, $dest);

    /**
     * Move file.
     *
     * @param string $src
     * @param string $dest
     * @return bool
     */
    public function move($src, $dest);

    /**
     * Remove file.
     *
     * @param string $path
     * @return bool
     */
    public function remove($path);

    /**
     * Write content to file.
     *
     * @param string $path
     * @param mixed $content
     * @return bool
     */
    public function write($path, $content);

    /**
     * Append content to file.
     *
     * @param string $path
     * @param mixed $content
     * @return bool
     */
    public function append($path, $content);

    /**
     * Read file's content.
     *
     * @param string $path
     * @param int $offset
     * @param int $length
     * @return string
     */
    public function read($path, $offset, $length);

    /**
     * Create directory.
     *
     * @param string $path
     * @param int $permission
     * @param bool $recursive
     * @return bool
     */
    public function createDir($path, $permission, $recursive);

    /**
     * Remove directory and its content.
     *
     * @param string $path
     * @return bool
     */
    public function removeDir($path);

    /**
     * Create a symlink for a file.
     *
     * @param string $src
     * @param string $dest
     * @return bool
     */
    public function symlink($src, $dest);

    /**
     * Concatenate paths.
     *
     * @param string ...$paths
     * @return string
     */
    public function concatPath(...$paths);

    /**
     * Add extension to file's name.
     *
     * @param string $filename
     * @param string $extension
     * @return string
     */
    public function addExtension($filename, $extension);

    /**
     * Remove extension from file's name.
     *
     * Please Note: for files with sub types like script.min.js, unless you
     * clearly specify that 'min.js' is a whole extension, this method will only
     * remove the '.js' part!
     *
     * @param string $filename
     * @param string $extension
     * @return string
     */
    public function removeExtension($filename, $extension = '');

    /**
     * Get file's name from path.
     *
     * @param string $path
     * @return string
     */
    public function getFileName($path);

    /**
     * Get path only from a full file path.
     *
     * @param string $path
     * @return string
     */
    public function getPath($path);

    /**
     * Change file's mode.
     *
     * @param string $path
     * @param int $permissions octal value
     * @return bool
     */
    public function changeMode($path, $permissions);

    /**
     * Change file's group.
     *
     * @param string $path
     * @param string|int $group
     * @return bool
     */
    public function changeGroup($path, $group);

    /**
     * Change file's owner.
     *
     * @param string $path
     * @param string|int $user
     * @return bool
     */
    public function changeOwner($path, $user);

    /**
     * Check if a path is a directory.
     *
     * @param string $path
     * @return bool
     */
    public function isDir($path);
}
