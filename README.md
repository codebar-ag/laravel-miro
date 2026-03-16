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
use CodebarAg\Miro\Dto\CreateBoardDto;
use CodebarAg\Miro\Dto\GetBoardsDto;
use CodebarAg\Miro\Dto\UpdateBoardDto;
use CodebarAg\Miro\Facades\Miro;

// List all boards
$boards = Miro::getBoards();

// List boards with filters
$boards = Miro::getBoards(new GetBoardsDto(
    teamId: 'team_123',
    limit: 10,
));

// Get a specific board
$board = Miro::getBoard('uXjVK_board_id=');

// Create a board
$board = Miro::createBoard(new CreateBoardDto(
    name: 'My Sprint Board',
    description: 'Q1 planning board',
));

// Update a board
$board = Miro::updateBoard('uXjVK_board_id=', new UpdateBoardDto(
    name: 'Q1 Planning',
));

// Delete a board
Miro::deleteBoard('uXjVK_board_id=');
```

### Board Items

```php
use CodebarAg\Miro\Dto\GetBoardItemsDto;
use CodebarAg\Miro\Facades\Miro;

// Get all items on a board
$items = Miro::getBoardItems('uXjVK_board_id=');

// Filter by item type
$items = Miro::getBoardItems('uXjVK_board_id=', new GetBoardItemsDto(
    type: 'sticky_note',
));

// Paginate using cursor
$items = Miro::getBoardItems('uXjVK_board_id=', new GetBoardItemsDto(
    limit: 50,
    cursor: 'next_page_cursor',
));
```

### Sticky Notes

```php
use CodebarAg\Miro\Dto\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\GetStickyNotesDto;
use CodebarAg\Miro\Dto\UpdateStickyNoteDto;
use CodebarAg\Miro\Facades\Miro;

// Get all sticky notes on a board
$notes = Miro::getStickyNotes('uXjVK_board_id=');

// Get sticky notes with filters
$notes = Miro::getStickyNotes('uXjVK_board_id=', new GetStickyNotesDto(
    limit: 20,
));

// Get a specific sticky note
$note = Miro::getStickyNote('uXjVK_board_id=', 'note_id');

// Create a sticky note
$note = Miro::createStickyNote('uXjVK_board_id=', new CreateStickyNoteDto(
    content: 'Hello from Miro!',
    shape: 'square',
    fillColor: 'light_yellow',
    textAlign: 'center',
    textAlignVertical: 'top',
    positionX: 0.0,
    positionY: 0.0,
));

// Update a sticky note
$note = Miro::updateStickyNote('uXjVK_board_id=', 'note_id', new UpdateStickyNoteDto(
    content: 'Updated content',
    fillColor: 'light_pink',
));

// Delete a sticky note
Miro::deleteStickyNote('uXjVK_board_id=', 'note_id');
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
| `getStickyNotes()` | `StickyNoteDto[]` |
| `getStickyNote()` | `StickyNoteDto` |
| `createStickyNote()` | `StickyNoteDto` |
| `updateStickyNote()` | `StickyNoteDto` |
| `deleteStickyNote()` | `Saloon\Http\Response` |

#### BoardDto

```php
$board->id;           // string
$board->name;         // string
$board->description;  // ?string
$board->type;         // string
$board->viewLink;     // string  (direct URL to open the board)
$board->teamId;       // ?string
$board->projectId;    // ?string
$board->createdAt;    // ?string (ISO 8601)
$board->modifiedAt;   // ?string (ISO 8601)
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

#### StickyNoteDto

```php
$note->id;                 // string
$note->type;               // string
$note->content;            // ?string
$note->shape;              // ?string  (square, rectangle)
$note->fillColor;          // ?string  (light_yellow, light_pink, dark_blue, ...)
$note->textAlign;          // ?string  (left, center, right)
$note->textAlignVertical;  // ?string  (top, middle, bottom)
$note->positionX;          // ?float
$note->positionY;          // ?float
$note->width;              // ?float
$note->height;             // ?float
$note->parentId;           // ?string  (frame ID if inside a frame)
$note->createdAt;          // ?string  (ISO 8601)
$note->modifiedAt;         // ?string  (ISO 8601)
```

### Input DTOs

All write and filter operations use typed DTOs:

| DTO | Used for |
|-----|----------|
| `CreateBoardDto` | `createBoard()` |
| `UpdateBoardDto` | `updateBoard()` |
| `GetBoardsDto` | `getBoards()` filter params |
| `GetBoardItemsDto` | `getBoardItems()` filter params |
| `CreateStickyNoteDto` | `createStickyNote()` |
| `UpdateStickyNoteDto` | `updateStickyNote()` |
| `GetStickyNotesDto` | `getStickyNotes()` filter params |

### Using the connector directly

Each request class implements `createDtoFromResponse()`, so you can use Saloon's `->dto()` directly:

```php
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\GetBoardsRequest;
use CodebarAg\Miro\Requests\StickyNotes\CreateStickyNoteRequest;

$connector = new MiroConnector();

// ->dto() returns the typed DTO directly
$boards = $connector->send(new GetBoardsRequest())->dto();

$note = $connector->send(new CreateStickyNoteRequest('uXjVK_board_id=', [
    'data' => ['content' => 'Hello!', 'shape' => 'square'],
]))->dto();
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
