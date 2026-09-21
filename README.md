# SigmaPHP-Filesystem

The `SigmaPHP-Filesystem` package provides a simple and consistent interface for working with files and directories. It abstracts common filesystem operations such as creating, reading, writing, copying, moving, renaming, and removing files and directories.

The package is designed to keep filesystem operations straightforward while providing a reusable interface that can be integrated into SigmaPHP applications and other PHP projects.

## Installation

``` 
composer require sigmaphp/sigmaphp-filesystem
```

## Documentation

### Basic Usage

The `Filesystem` class provides the implementation of `FilesystemInterface` and can be instantiated directly when filesystem operations are required.

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

## License
(SigmaPHP-Filesystem) released under the terms of the MIT license.
