# Laravel Miro

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codebar-ag/laravel-miro.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-miro)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/codebar-ag/laravel-miro/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/codebar-ag/laravel-miro/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/codebar-ag/laravel-miro.svg?style=flat-square)](https://packagist.org/packages/codebar-ag/laravel-miro)

A simple Laravel package for interacting with the [Miro REST API v2](https://developers.miro.com/reference/api-reference).

## Requirements

- PHP 8.2+
- Laravel 10, 11, or 12

## Installation


> **Not yet on Packagist!** Add the repository to your `composer.json` first:
> clone the Project on your Pc and then link the path to it
>
> ```json
> "repositories": [
>     {
>         "type": "path",
>         "url": "/User/maxmustermann/projects/laravel-miro"
>     }
> ]
> ```


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
MIRO_ACCESS_TOKEN="your_token_here"
```

You can generate a personal access token at [miro.com/app/settings/user-profile/apps](https://miro.com/app/settings/user-profile/apps).

## Usage

All methods return a typed Response object. Check `successful()` before accessing the DTO — no try/catch needed for API errors like 404, 429, or 400.

```php
$response = Miro::getBoard('board_id');

if ($response->successful()) {
    $board = $response->dto(); // BoardDto
} else {
    $response->status();     // e.g. 404
    $response->error();      // e.g. "Board not found"
    $response->errorCode();  // e.g. "board_not_found"
}
```

### Boards

```php
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Boards\GetBoardsDto;
use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;

// List all boards
$response = Miro::getBoards();
$boards = $response->dto(); // BoardDto[]

// List boards with filters
$response = Miro::getBoards(new GetBoardsDto(
    teamId: 'team_123',
    limit: 10,
));

// Get a specific board
$response = Miro::getBoard('board_id');
$board = $response->dto(); // BoardDto

// Create a board
$response = Miro::createBoard(new CreateBoardDto(
    name: 'My Sprint Board',
    description: 'Q1 planning board',
));

// Update a board
$response = Miro::updateBoard('board_id', new UpdateBoardDto(
    name: 'Q1 Planning',
));

// Delete a board (returns raw Saloon Response)
Miro::deleteBoard('board_id');
```

### Board Items

```php
use CodebarAg\Miro\Dto\BoardItems\GetBoardItemsDto;

// Get all items on a board
$response = Miro::getBoardItems('board_id');
$items = $response->dto(); // BoardItemDto[]

// Filter by item type
$response = Miro::getBoardItems('board_id', new GetBoardItemsDto(
    type: 'sticky_note',
));

// Get a single item by ID
$response = Miro::getBoardItem('board_id', 'item_id');
$item = $response->dto(); // BoardItemDto
```

### Sticky Notes

```php
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\GetStickyNotesDto;
use CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto;

// Get all sticky notes on a board
$response = Miro::getStickyNotes('board_id');
$notes = $response->dto(); // StickyNoteDto[]

// Get a single sticky note
$response = Miro::getStickyNote('board_id', 'item_id');
$note = $response->dto(); // StickyNoteDto

// Create a sticky note
$response = Miro::createStickyNote('board_id', new CreateStickyNoteDto(
    content: 'Hello World',
    shape: 'square',
    fillColor: 'yellow',
    positionX: 100.0,
    positionY: 200.0,
));

// Update a sticky note
$response = Miro::updateStickyNote('board_id', 'item_id', new UpdateStickyNoteDto(
    content: 'Updated content',
));

// Delete a sticky note (returns raw Saloon Response)
Miro::deleteStickyNote('board_id', 'item_id');
```

### Frames

```php
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;

// Get all frames on a board
$response = Miro::getFrames('board_id');
$frames = $response->dto(); // FrameDto[]

// Get a single frame
$response = Miro::getFrame('board_id', 'item_id');
$frame = $response->dto(); // FrameDto

// Create a frame
$response = Miro::createFrame('board_id', new CreateFrameDto(
    title: 'Sprint 1',
    positionX: 0.0,
    positionY: 0.0,
    width: 1920.0,
    height: 1080.0,
));

// Update a frame
$response = Miro::updateFrame('board_id', 'item_id', new UpdateFrameDto(
    title: 'Sprint 1 – Updated',
));

// Delete a frame (returns raw Saloon Response)
Miro::deleteFrame('board_id', 'item_id');
```

### Return Types

| Method | Return type | `->dto()` type |
|--------|-------------|----------------|
| `getBoards()` | `BoardResponse` | `BoardDto[]` |
| `getBoard()` | `BoardResponse` | `BoardDto` |
| `createBoard()` | `BoardResponse` | `BoardDto` |
| `updateBoard()` | `BoardResponse` | `BoardDto` |
| `deleteBoard()` | `Saloon\Http\Response` | — |
| `getBoardItems()` | `BoardItemResponse` | `BoardItemDto[]` |
| `getBoardItem()` | `BoardItemResponse` | `BoardItemDto` |
| `getStickyNotes()` | `StickyNoteResponse` | `StickyNoteDto[]` |
| `getStickyNote()` | `StickyNoteResponse` | `StickyNoteDto` |
| `createStickyNote()` | `StickyNoteResponse` | `StickyNoteDto` |
| `updateStickyNote()` | `StickyNoteResponse` | `StickyNoteDto` |
| `deleteStickyNote()` | `Saloon\Http\Response` | — |
| `getFrames()` | `FrameResponse` | `FrameDto[]` |
| `getFrame()` | `FrameResponse` | `FrameDto` |
| `createFrame()` | `FrameResponse` | `FrameDto` |
| `updateFrame()` | `FrameResponse` | `FrameDto` |
| `deleteFrame()` | `Saloon\Http\Response` | — |

All `*Response` objects expose:

```php
$response->successful();  // bool
$response->failed();      // bool
$response->status();      // int  (e.g. 200, 404, 429)
$response->error();       // ?string — null on success
$response->errorCode();   // ?string — null on success
$response->dto();         // typed DTO or null on failure
```

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
$note->shape;              // ?string
$note->fillColor;          // ?string
$note->textAlign;          // ?string
$note->textAlignVertical;  // ?string
$note->positionX;          // ?float
$note->positionY;          // ?float
$note->width;              // ?float
$note->height;             // ?float
$note->parentId;           // ?string
$note->createdAt;          // ?string (ISO 8601)
$note->modifiedAt;         // ?string (ISO 8601)
```

#### FrameDto

```php
$frame->id;          // string
$frame->type;        // string
$frame->title;       // ?string
$frame->fillColor;   // ?string
$frame->positionX;   // ?float
$frame->positionY;   // ?float
$frame->width;       // ?float
$frame->height;      // ?float
$frame->parentId;    // ?string
$frame->createdAt;   // ?string (ISO 8601)
$frame->modifiedAt;  // ?string (ISO 8601)
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
