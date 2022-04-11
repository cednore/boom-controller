# boom-controller

> Booming server control interface for Laravel

| :exclamation: IMPORTANT: This project is not actively maintained. |
| ----------------------------------------------------------------- |

`boom-controller` is a [composer package](https://packagist.org/packages/cednore/boom-controller) for Laravel
applications to control [`boom-server`](https://www.npmjs.com/package/boom-server) microservice.

See [`boom-demo`](https://github.com/cednore/boom-demo) for example usage of this project.

> Currently, this project supports only `socket.io:^2.2.0`, `laravel:^5.7|^6.0` and `php:^7|^8`.

## Features

1. Expose endpoints to listen `socket.io` events coming from frontend clients
2. PHP class to provide same interface as `socket.io`'s Node.js server (for easy porting of legacy applications)
3. Facade for smooth syntax
4. Authentication of traffic between `boom-server` and API
5. State machine over MySQL table to share list of sockets

## Installation

```bash
# Install cednore/boom-controller package
composer require cednore/boom-controller

# Create config, route and default controller for root namespace
php artisan boom:init

# Start development server
php artisan serve
```

## Emit cheatsheet (comparison between legacy JavaScript syntax and new PHP syntax)

### Basic emit

```js
socket.emit(/* ... */);
```

```php
$request->socket->emit(/* ... */);
```

### To all clients in the current namespace except the sender

```js
socket.broadcast.emit(/* ... */);
```

```php
$request->socket->broadcast->emit(/* ... */);
```

### To all clients in room1 except the sender

```js
socket.to('room1').emit(/* ... */);
```

```php
$request->socket->to('room1')->emit(/* ... */);
```

### To all clients in room1 and/or room2 except the sender

```js
socket.to('room1').to('room2').emit(/* ... */);
```

```php
$request->socket->to('room1')->to('room2')->emit(/* ... */);
```

### To all clients in room1

```js
io.in('room1').emit(/* ... */);
```

```php
use Boom\Facades\Boom as IO;
IO::in('room1')->emit(/* ... */);
```

### To all clients in namespace "myNamespace"

```js
io.of('myNamespace').emit(/* ... */);
```

```php
use Boom\Facades\Boom as IO;
IO::of('myNamespace')->emit(/* ... */);
```

### To all clients in room1 in namespace "myNamespace"

```js
io.of('myNamespace').to('room1').emit(/* ... */);
```

```php
use Boom\Facades\Boom as IO;
IO::of('myNamespace')->to('room1')->emit(/* ... */);
```

### To individual socketid (private message)

```js
io.to(socketId).emit(/* ... */);
```

```php
use Boom\Facades\Boom as IO;
IO::to($socketId)->emit(/* ... */);
```

### To all clients on this node (when using multiple nodes)

```js
io.local.emit(/* ... */);
```

```php
use Boom\Facades\Boom as IO;
IO::$local->emit(/* ... */);
```

### To all connected clients

```js
io.emit(/* ... */);
```

```php
use Boom\Facades\Boom as IO;
IO::emit(/* ... */);
```

### Without compression

```js
socket.compress(false).emit(/* ... */);
```

```php
$request->socket->compress(false)->emit(/* ... */);
```

### A message that might be dropped if the low-level transport is not writable

```js
socket.volatile.emit(/* ... */);
```

```php
$request->socket->volatile->emit(/* ... */);
```

## Configuration

The file `config/boom.php` contains an array of configurations. See code comments inside this file for detailed
explanations.

## Artisan commands

### Command: `boom:init`

Initialize boom controller.

Usage:

```bash
php artisan boom:init [options]
```

Options:

```bash
--force  Overwrite any existing files.
```

### Command: `boom:make:nsp`

Make a new socket.io namespace handler.

Usage:

```bash
php artisan boom:make:nsp [options] [--] <name>
```

Arguments:

```bash
name  Name of new namespace to create.
```

Options:

```bash
--force  Overwrite any existing files.
```

## Cloning

These instructions will get you a copy of the project up and running on your local machine for development and testing
purposes. See [Installation](#installation) chapter for notes on how to use this project on a live system.

```bash
# Clone this repo
git clone git@github.com:cednore/boom-controller.git
cd boom-controller
```

## Project roadmaps

1. Testing desperately needed ;-)
2. Resourceful documentation; Changelog, contribution guide, issue/PR templates, GitHub releases, dedicated
   documentation website
3. Version compatibility check between `boom-controller` and `boom-server`
4. CI/CD pipelines for building, testing and publishing
5. Support higher `socket.io` and `laravel` versions
6. More smooth controller syntax
7. Detailed error handling
8. Memcached driver
9. More stable db connection
10. Dockerization of microservice
11. Combine `boom-server` and `boom-controller` in a single monorepo

## License

This project is licensed under the MIT license. See full contents at [`LICENSE`](LICENSE) file.
