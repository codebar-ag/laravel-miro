# Laravel Miro

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codebar-ag/laravel-miro.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-miro)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/codebar-ag/laravel-miro/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/codebar-ag/laravel-miro/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/codebar-ag/laravel-miro.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-miro)

A simple Laravel package for interacting with the [Miro REST API v2](https://developers.miro.com/reference/api-reference).

## Requirements

- PHP 8.2+
- Laravel 10, 11, or 12

## Installation

Install the package via Composer:

```bash
composer require codebar-ag/laravel-miro
```

Publish the config file:

```bash
php artisan vendor:publish --tag="laravel-miro-config"
```

Add your Miro access token to your `.env` file:

```dotenv
MIRO_ACCESS_TOKEN=your_token_here
```

You can generate a personal access token at [miro.com/app/settings/user-profile/apps](https://miro.com/app/settings/user-profile/apps).

## Usage

### Boards

```php
use CodebarAg\Miro\Facades\Miro;

// List all boards
$boards = Miro::getBoards();

// List boards with filters
$boards = Miro::getBoards([
    'team_id' => 'team_123',
    'limit'   => 10,
]);

// Get a specific board
$board = Miro::getBoard('uXjVK_board_id=');

// Create a board
$board = Miro::createBoard([
    'name'        => 'My Sprint Board',
    'description' => 'Q1 planning board',
]);

// Update a board
$board = Miro::updateBoard('uXjVK_board_id=', [
    'name' => 'Q1 Planning',
]);

// Delete a board
Miro::deleteBoard('uXjVK_board_id=');
```

### Board Items

```php
// Get all items on a board
$items = Miro::getBoardItems('uXjVK_board_id=');

// Filter by item type
$items = Miro::getBoardItems('uXjVK_board_id=', [
    'type' => 'sticky_note',
]);

// Paginate using cursor
$items = Miro::getBoardItems('uXjVK_board_id=', [
    'limit'  => 50,
    'cursor' => 'next_page_cursor',
]);
```

### Return Types

All methods return typed DTOs:

| Method | Return type |
|--------|-------------|
| `getBoards()` | `BoardDto[]` |
| `getBoard()` | `BoardDto` |
| `createBoard()` | `BoardDto` |
| `updateBoard()` | `BoardDto` |
| `deleteBoard()` | `Saloon\Http\Response` |
| `getBoardItems()` | `BoardItemDto[]` |

#### BoardDto

```php
$board->id;             // string
$board->name;           // string
$board->description;    // ?string
$board->type;           // string
$board->viewLink;       // string  (direct URL to open the board)
$board->sharingPolicy;  // ?SharingPolicyDto
$board->teamId;         // ?string
$board->projectId;      // ?string
$board->createdAt;      // ?string (ISO 8601)
$board->modifiedAt;     // ?string (ISO 8601)
```

#### BoardItemDto

```php
$item->id;          // string
$item->type;        // string (e.g. sticky_note, card, shape, text, frame, ...)
$item->data;        // ?array (type-specific content)
$item->position;    // ?array (x, y, origin, relativeTo)
$item->geometry;    // ?array (width, height, rotation)
$item->createdAt;   // ?string
$item->modifiedAt;  // ?string
$item->parentId;    // ?string
```

### Using the connector directly

If you need more control you can use the connector directly instead of the facade:

```php
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\GetBoardsRequest;

$connector = new MiroConnector();
$response  = $connector->send(new GetBoardsRequest(['limit' => 5]));

$data = $response->json();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/codebar-ag/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [codebar AG](https://github.com/codebar-ag)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
