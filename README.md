# SigmaPHP-Filesystem

The `SigmaPHP-Filesystem` package provides a simple and consistent interface for working with files and directories. It abstracts common filesystem operations such as creating, reading, writing, copying, moving, renaming, and removing files and directories.

The package is designed to keep filesystem operations straightforward while providing a reusable interface that can be integrated into SigmaPHP applications and other PHP projects.

## Installation

``` 
composer require sigmaphp/sigmaphp-filesystem
```

## Documentation

### Basic Usage

The `Filesystem` class can be instantiated directly when filesystem operations are required.

```php
<?php

$filesystem = new Filesystem();
```

Once the filesystem instance has been created, it can be used to perform common file and directory operations.

For example, a file can be created and written to using the following:

```php
<?php

$filesystem = new Filesystem();

$filesystem->create(
    '/var/www/project/example.txt',
    0644
);

$filesystem->write(
    '/var/www/project/example.txt',
    'Hello, SigmaPHP!'
);
```

The same instance can then be used to read the file:

```php
<?php

$content = $filesystem->read(
    '/var/www/project/example.txt',
    0,
    1000
);

echo $content;
```

### Available Methods

### `list()`

Lists all files inside a directory and its sub-directories.

```php
$files = $filesystem->list(
    '/var/www/project',
    true,
    true
);
```

| Parameter          | Type     | Description                                     |
| ------------------ | -------- | ----------------------------------------------- |
| `$path`            | `string` | The directory path to search.                   |
| `$includeFullPath` | `bool`   | Whether to include the full path for each file. |
| `$withExtension`   | `bool`   | Whether to include file extensions.             |

Returns an array of file paths or file names.

### `exists()`

Checks whether a file or directory exists.

```php
if ($filesystem->exists('/var/www/project/config.php')) {
    echo 'File exists.';
}
```

| Parameter | Type     | Description                 |
| --------- | -------- | --------------------------- |
| `$path`   | `string` | The file or directory path. |

Returns `true` when the path exists, otherwise `false`.

### `dirHas()`

Checks whether a directory contains a specific file or subdirectory.

```php
if ($filesystem->dirHas('/var/www/project', 'config.php')) {
    echo 'config.php exists.';
}
```

| Parameter | Type     | Description                           |
| --------- | -------- | ------------------------------------- |
| `$path`   | `string` | The directory to search.              |
| `$target` | `string` | The file or subdirectory to look for. |

Returns `true` when the target exists inside the directory.

### `create()`

Creates a new file with the specified permissions.

```php
$filesystem->create(
    '/var/www/project/example.txt',
    0644
);
```

| Parameter     | Type     | Description                            |
| ------------- | -------- | -------------------------------------- |
| `$path`       | `string` | The path of the file to create.        |
| `$permission` | `int`    | The permissions to assign to the file. |

Returns `true` when the file is created successfully.

### `rename()`

Renames a file or directory.

```php
$filesystem->rename(
    '/var/www/project/old.txt',
    '/var/www/project/new.txt'
);
```

| Parameter | Type     | Description       |
| --------- | -------- | ----------------- |
| `$old`    | `string` | The current path. |
| `$new`    | `string` | The new path.     |

Returns `true` when the operation succeeds.

### `copy()`

Copies a file to another location.

```php
$filesystem->copy(
    '/var/www/project/source.txt',
    '/var/www/project/backup/source.txt'
);
```

| Parameter | Type     | Description           |
| --------- | -------- | --------------------- |
| `$src`    | `string` | The source file path. |
| `$dest`   | `string` | The destination path. |

Returns `true` when the file is copied successfully.

### `move()`

Moves a file to another location.

```php
$filesystem->move(
    '/var/www/project/source.txt',
    '/var/www/project/archive/source.txt'
);
```

| Parameter | Type     | Description           |
| --------- | -------- | --------------------- |
| `$src`    | `string` | The source file path. |
| `$dest`   | `string` | The destination path. |

Returns `true` when the file is moved successfully.

### `remove()`

Removes a file.

```php
$filesystem->remove(
    '/var/www/project/example.txt'
);
```

| Parameter | Type     | Description              |
| --------- | -------- | ------------------------ |
| `$path`   | `string` | The file path to remove. |

Returns `true` when the file is removed successfully.

### `write()`

Writes content to a file. Existing content may be replaced.

```php
$filesystem->write(
    '/var/www/project/example.txt',
    'Hello, SigmaPHP!'
);
```

| Parameter  | Type     | Description           |
| ---------- | -------- | --------------------- |
| `$path`    | `string` | The file path.        |
| `$content` | `mixed`  | The content to write. |

Returns `true` when the content is written successfully.

### `append()`

Appends content to the end of an existing file.

```php
$filesystem->append(
    '/var/www/project/example.txt',
    "\nAdditional content."
);
```

| Parameter  | Type     | Description            |
| ---------- | -------- | ---------------------- |
| `$path`    | `string` | The file path.         |
| `$content` | `mixed`  | The content to append. |

Returns `true` when the content is appended successfully.

### `read()`

Reads content from a file.

```php
$content = $filesystem->read(
    '/var/www/project/example.txt',
    0,
    100
);

echo $content;
```

| Parameter | Type     | Description                               |
| --------- | -------- | ----------------------------------------- |
| `$path`   | `string` | The file path.                            |
| `$offset` | `int`    | The position from which to start reading. |
| `$length` | `int`    | The maximum amount of content to read.    |

Returns the file content as a string.

### `createDir()`

Creates a directory.

```php
$filesystem->createDir(
    '/var/www/project/storage',
    0755,
    true
);
```

| Parameter     | Type     | Description                                        |
| ------------- | -------- | -------------------------------------------------- |
| `$path`       | `string` | The directory path to create.                      |
| `$permission` | `int`    | The permissions to assign to the directory.        |
| `$recursive`  | `bool`   | Whether parent directories should also be created. |

Returns `true` when the directory is created successfully.

### `removeDir()`

Removes a directory and its contents.

```php
$filesystem->removeDir(
    '/var/www/project/storage/cache'
);
```

| Parameter | Type     | Description                   |
| --------- | -------- | ----------------------------- |
| `$path`   | `string` | The directory path to remove. |

Returns `true` when the directory and its contents are removed successfully.
### `symlink()`

Creates a symbolic link to a file.

```php
$filesystem->symlink(
    '/var/www/project/config.php',
    '/var/www/project/config-link.php'
);
```

| Parameter | Type | Description |
| --- | --- | --- |
| `$src` | `string` | The path to the source file. |
| `$dest` | `string` | The destination path where the symbolic link will be created. |

Returns `true` if the symbolic link is created successfully, or `false` otherwise.

### `concatPath()`

Concatenates multiple path segments into a single path string.

```php
$path = $filesystem->concatPath(
    '/var/www/project',
    'storage',
    'logs',
    'app.log'
);
```

| Parameter | Type | Description |
| --- | --- | --- |
| `$paths` | `string ...` | A variable number of path segments to concatenate. |

Returns the concatenated path as a string.

### `addExtension()`

Adds an extension to a file's name.

```php
$filename = $filesystem->addExtension(
    'document',
    'pdf'
);

// Result: document.pdf
```

| Parameter | Type | Description |
| --- | --- | --- |
| `$filename` | `string` | The file name to which the extension will be added. |
| `$extension` | `string` | The extension to add. |

Returns the file name with the specified extension.

### `removeExtension()`

Removes the extension from a file's name.

```php
$filename = $filesystem->removeExtension(
    'document.pdf'
);

// Result: document
```

| Parameter | Type | Description |
| --- | --- | --- |
| `$filename` | `string` | The file name from which the extension will be removed. |

Returns the file name without its extension.

### `getFileName()`

Extracts the file name from a path.

```php
$filename = $filesystem->getFileName(
    '/var/www/project/config.php'
);

// Result: config.php
```

| Parameter | Type | Description |
| --- | --- | --- |
| `$path` | `string` | The file path from which to extract the file name. |

Returns the extracted file name as a string.

### `changeMode()`

Changes the permissions of a file or directory using an octal permission value.

```php
$filesystem->changeMode(
    '/var/www/project/storage',
    0755
);
```

| Parameter | Type | Description |
| --- | --- | --- |
| `$path` | `string` | The path to the file or directory. |
| `$permissions` | `int` | The permissions to assign, specified as an octal value. |

Returns `true` if the permissions are changed successfully, or `false` otherwise.

In this example, `0755` grants the owner read, write, and execute permissions, while the group and other users receive read and execute permissions.

### `changeGroup()`

Changes the group ownership of a file or directory.

```php
$filesystem->changeGroup(
    '/var/www/project/storage',
    'www-data'
);
```

| Parameter | Type | Description |
| --- | --- | --- |
| `$path` | `string` | The path to the file or directory. |
| `$group` | `string\|int` | The group name or group ID to assign. |

Returns `true` if the group is changed successfully, or `false` otherwise.

### `changeOwner()`

Changes the owner of a file or directory.

```php
$filesystem->changeOwner(
    '/var/www/project/storage',
    'www-data'
);
```

| Parameter | Type | Description |
| --- | --- | --- |
| `$path` | `string` | The path to the file or directory. |
| `$user` | `string\|int` | The user name or user ID to assign as the owner. |

Returns `true` if the owner is changed successfully, or `false` otherwise.

**Note:** Changing file permissions, group ownership, or owner depends on the operating system and the privileges of the executing user. These operations may fail if the process does not have sufficient permissions.

## License
(SigmaPHP-Filesystem) released under the terms of the MIT license.
