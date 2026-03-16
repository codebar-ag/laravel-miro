---
name: laravel-miro
description: Interact with the Miro REST API v2 — manage boards, sticky notes, and board items using typed DTOs and the Miro facade or connector.
---

# Laravel Miro

## When to use this skill

Use this skill when working with Miro boards, sticky notes, or board items via the `codebar-ag/laravel-miro` package.

## Setup

Requires `MIRO_ACCESS_TOKEN` in `.env`. Generate a personal access token at miro.com/app/settings/user-profile/apps.

## Key concepts

- All methods are available via the `Miro` facade or the `MiroConnector` directly.
- **Input** always uses typed DTOs — never plain arrays.
- **Output** is always a typed DTO or `Saloon\Http\Response` (for deletes).
- Each request class implements `createDtoFromResponse()`, so `->dto()` works directly on the response.

## Boards

```php
use CodebarAg\Miro\Dto\CreateBoardDto;
use CodebarAg\Miro\Dto\GetBoardsDto;
use CodebarAg\Miro\Dto\UpdateBoardDto;
use CodebarAg\Miro\Facades\Miro;

// List — returns BoardDto[]
$boards = Miro::getBoards();
$boards = Miro::getBoards(new GetBoardsDto(teamId: 'team_123', limit: 10));

// Single — returns BoardDto
$board = Miro::getBoard('board_id');

// Create — returns BoardDto
$board = Miro::createBoard(new CreateBoardDto(name: 'My Board', description: 'Optional'));

// Update — returns BoardDto
$board = Miro::updateBoard('board_id', new UpdateBoardDto(name: 'Renamed'));

// Delete — returns Saloon\Http\Response (status 204)
Miro::deleteBoard('board_id');
```

### BoardDto properties

```php
$board->id;           // string
$board->name;         // string
$board->description;  // ?string
$board->type;         // string
$board->viewLink;     // string
$board->teamId;       // ?string
$board->projectId;    // ?string
$board->createdAt;    // ?string (ISO 8601)
$board->modifiedAt;   // ?string (ISO 8601)
```

## Sticky Notes

```php
use CodebarAg\Miro\Dto\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\GetStickyNotesDto;
use CodebarAg\Miro\Dto\UpdateStickyNoteDto;
use CodebarAg\Miro\Facades\Miro;

// List — returns StickyNoteDto[]
$notes = Miro::getStickyNotes('board_id');
$notes = Miro::getStickyNotes('board_id', new GetStickyNotesDto(limit: 20));

// Single — returns StickyNoteDto
$note = Miro::getStickyNote('board_id', 'note_id');

// Create — returns StickyNoteDto
$note = Miro::createStickyNote('board_id', new CreateStickyNoteDto(
    content: 'Hello!',
    shape: 'square',          // square | rectangle
    fillColor: 'light_yellow',
    textAlign: 'center',      // left | center | right
    textAlignVertical: 'top', // top | middle | bottom
    positionX: 0.0,
    positionY: 0.0,
    positionOrigin: 'center',
    width: 199.0,
    parentId: 'frame_id',     // optional, place inside a frame
));

// Update — returns StickyNoteDto
$note = Miro::updateStickyNote('board_id', 'note_id', new UpdateStickyNoteDto(
    content: 'Updated',
    fillColor: 'light_pink',
));

// Delete — returns Saloon\Http\Response (status 204)
Miro::deleteStickyNote('board_id', 'note_id');
```

### StickyNoteDto properties

```php
$note->id;                 // string
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

## Board Items

```php
use CodebarAg\Miro\Dto\GetBoardItemsDto;
use CodebarAg\Miro\Facades\Miro;

// List all items — returns BoardItemDto[]
$items = Miro::getBoardItems('board_id');
$items = Miro::getBoardItems('board_id', new GetBoardItemsDto(
    type: 'sticky_note',
    limit: 50,
    cursor: 'next_page_cursor',
));
```

## Using the connector directly

```php
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\GetBoardsRequest;

$connector = new MiroConnector();

// ->dto() returns the typed DTO via createDtoFromResponse()
$boards = $connector->send(new GetBoardsRequest())->dto();
```

## Input DTOs reference

| DTO | Fields |
|-----|--------|
| `CreateBoardDto` | `name` (required), `description`, `teamId` |
| `UpdateBoardDto` | `name`, `description` (all optional) |
| `GetBoardsDto` | `teamId`, `projectId`, `query`, `owner`, `limit`, `offset`, `sort` |
| `GetBoardItemsDto` | `limit`, `cursor`, `type` |
| `CreateStickyNoteDto` | `content`, `shape`, `fillColor`, `textAlign`, `textAlignVertical`, `positionX`, `positionY`, `positionOrigin`, `width`, `parentId` |
| `UpdateStickyNoteDto` | same as Create, all optional |
| `GetStickyNotesDto` | `limit`, `cursor` |
