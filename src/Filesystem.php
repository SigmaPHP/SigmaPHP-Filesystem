<?php

namespace SigmaPHP\Filesystem;

use SigmaPHP\Filesystem\Interfaces\FilesystemInterface;
use SigmaPHP\Filesystem\Exceptions\PathNotFoundException;

/**
 * Filesystem Class.
 */
class Filesystem implements FilesystemInterface
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
    public function list(
        $path,
        $includeFullPath = false,
        $withExtension = true,
        $filesOnly = false,
    ) {
        if (!file_exists($path)) {
            throw new PathNotFoundException("The path {$path} doesn't exist!");
        }

        if (!is_dir($path)) {
            return [$path];
        }

        $files = [];

        $directoryIterator = new \RecursiveDirectoryIterator(
            $path,
            \RecursiveDirectoryIterator::SKIP_DOTS
        );

        foreach (new \RecursiveIteratorIterator(
            $directoryIterator,
            \RecursiveIteratorIterator::CHILD_FIRST
        ) as $file) {
            $_file = $file->getRealPath();

            if ($filesOnly && $this->isDir($_file)) {
                continue;
            }

            if (!$includeFullPath) {
                $_file = $this->getFileName($_file);
            }

            if (!$withExtension) {
                $_file = $this->removeExtension($_file);
            }

            $files[] = $_file;
        }

        natcasesort($files);

        return $files;
    }

    /**
     * Check if a path exists.
     *
     * @param string $path
     * @return bool
     */
    public function exists($path)
    {
        return file_exists($path);
    }

    /**
     * Check if a directory has a file or sub-directory.
     *
     * @param string $path
     * @param string $target
     * @return bool
     */
    public function dirHas($path, $target)
    {
        foreach ($this->list($path) as $file) {
            if (strpos($file, $target) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create file.
     *
     * @param string $path
     * @param string $content
     * @param int $permission
     * @return bool
     */
    public function create($path, $content = '', $permission = 0755)
    {
        return touch($path) & chmod($path, $permission) &
            (bool) file_put_contents($path, $content);
    }

    /**
     * Rename files and directories.
     *
     * @param string $old
     * @param string $new
     * @return bool
     */
    public function rename($old, $new)
    {
        return rename($old, $new);
    }

    /**
     * Copy files and directories.
     *
     * @param string $src
     * @param string $dest
     * @return bool
     */
    public function copy($src, $dest)
    {
        return copy($src, $dest);
    }

    /**
     * Move file.
     *
     * @param string $src
     * @param string $dest
     * @return bool
     */
    public function move($src, $dest)
    {
        return $this->rename($src, $dest);
    }

    /**
     * Remove file.
     *
     * @param string $path
     * @return bool
     */
    public function remove($path)
    {
        return unlink($path);
    }

    /**
     * Write content to file.
     *
     * @param string $path
     * @param mixed $content
     * @return bool
     */
    public function write($path, $content)
    {
        return file_put_contents($path, $content) !== false;
    }

    /**
     * Append content to file.
     *
     * @param string $path
     * @param mixed $content
     * @return bool
     */
    public function append($path, $content)
    {
        return file_put_contents($path, $content, FILE_APPEND) !== false;
    }

    /**
     * Read file's content.
     *
     * @param string $path
     * @param int $offset
     * @param int $length
     * @return string
     */
    public function read($path, $offset = 0, $length = null)
    {
        return file_get_contents($path, false, null, $offset, $length);
    }

    /**
     * Create directory.
     *
     * @param string $path
     * @param int $permission
     * @param bool $recursive
     * @return bool
     */
    public function createDir($path, $permission = 0755, $recursive = true)
    {
        return mkdir($path, $permission, $recursive);
    }

    /**
     * Remove directory and its content.
     *
     * @param string $path
     * @return bool
     */
    public function removeDir($path)
    {
        // delete content
        $files = $this->list($path, true);

        foreach ($files as $key => $file) {
            if (is_dir($file)) {
                rmdir($file);
            } else {
                unlink($file);
            }
        }

        // delete the dir
        return rmdir($path);
    }

    /**
     * Create a symlink for a file.
     *
     * @param string $src
     * @param string $dest
     * @return bool
     */
    public function symlink($src, $dest)
    {
        return symlink($src, $dest);
    }

    /**
     * Concatenate paths.
     *
     * @param string ...$paths
     * @return string
     */
    public function concatPath(...$paths)
    {
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    /**
     * Add extension to file's name.
     *
     * @param string $filename
     * @param string $extension
     * @return string
     */
    public function addExtension($filename, $extension)
    {
        if ($this->isDir($filename)) {
            return $filename;
        }

        return $filename . '.' . $extension;
    }

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
    public function removeExtension($filename, $extension = '')
    {
        if ($this->isDir($filename)) {
            return $filename;
        }

        $_filename = $filename;

        // handle first DS
        $startWithDS = false;
        if ($filename[0] == DIRECTORY_SEPARATOR) {
            $startWithDS = true;
        }

        $path = $this->getPath($filename);
        $filename = $this->getFileName($filename);

        // if dot-file, skip
        if ($filename[0] == '.') {
            return $_filename;
        }

        // in case no path, only filename
        if ($path == $filename) {
            $path = '';
        }

        if (!empty($extension)) {
            return rtrim(str_replace($extension, '', $filename), '.');
        }

        if (strpos($filename, '.') !== false) {
            $parts = explode('.', $filename);
            unset($parts[count($parts) - 1]);

            $filename = implode('.', $parts);
        }

        return $startWithDS ?
            $this->concatPath($path, $filename) :
            ltrim($this->concatPath($path, $filename), DIRECTORY_SEPARATOR);
    }

    /**
     * Get file's name from path.
     *
     * @param string $path
     * @return string
     */
    public function getFileName($path)
    {
        if (
            strpos(trim($path, DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR)
            !== false
        ) {
            $parts = explode(
                DIRECTORY_SEPARATOR,
                trim($path, DIRECTORY_SEPARATOR)
            );

            return $parts[count($parts) - 1];
        }

        return $path;
    }

    /**
     * Get path only from a full file path.
     *
     * @param string $path
     * @return string
     */
    public function getPath($path)
    {
        if (
            strpos(trim($path, DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR)
            !== false
        ) {
            // handle first DS
            $startWithDS = false;
            if ($path[0] == DIRECTORY_SEPARATOR) {
                $startWithDS = true;
            }

            $parts = explode(DIRECTORY_SEPARATOR, $path);

            unset($parts[count($parts) - 1]);

            return $startWithDS ?
                $this->concatPath(...$parts) :
                ltrim($this->concatPath(...$parts), DIRECTORY_SEPARATOR);
        }

        return $path;
    }

    /**
     * Change file's mode.
     *
     * @param string $path
     * @param int $permissions octal value
     * @return bool
     */
    public function changeMode($path, $permissions)
    {
        return chmod($path, $permissions);
    }

    /**
     * Change file's group.
     *
     * @param string $path
     * @param string|int $group
     * @return bool
     */
    public function changeGroup($path, $group)
    {
        return chgrp($path, $group);
    }

    /**
     * Change file's owner.
     *
     * @param string $path
     * @param string|int $user
     * @return bool
     */
    public function changeOwner($path, $user)
    {
        return chown($path, $user);
    }

    /**
     * Check if a path is a directory.
     *
     * @param string $path
     * @return bool
     */
    public function isDir($path)
    {
        return is_dir($path);
    }
}
