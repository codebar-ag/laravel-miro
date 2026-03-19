---
name: laravel-miro
description: Interact with the Miro REST API v2 — manage boards, sticky notes, frames, and board items using typed DTOs and Response objects via the Miro facade or connector.
---

# Laravel Miro

## When to use this skill

Use this skill when working with Miro boards, sticky notes, frames, or board items via the `codebar-ag/laravel-miro` package.

## Setup

Requires `MIRO_ACCESS_TOKEN` in `.env`. Generate a personal access token at miro.com/app/settings/user-profile/apps.

## Key concepts

- All methods are available via the `Miro` facade or the `MiroConnector` directly.
- **Input** always uses typed DTOs — never plain arrays.
- **Output** is always a typed `*Response` object (wraps the Saloon response) or `Saloon\Http\Response` (for deletes).
- Call `->dto()` on the response to get the typed DTO or array of DTOs. Returns `null` on failure.
- Always check `->successful()` before calling `->dto()`.

## Response Handling

```php
$response = Miro::getBoard('board_id');

if ($response->successful()) {
    $board = $response->dto(); // BoardDto
} else {
    $response->status();     // int    (e.g. 404)
    $response->error();      // ?string
    $response->errorCode();  // ?string
}
```

All `*Response` objects expose: `successful()`, `failed()`, `status()`, `error()`, `errorCode()`, `dto()`.

## Boards

```php
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Boards\GetBoardsDto;
use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;
use CodebarAg\Miro\Facades\Miro;

// List — returns BoardResponse, ->dto() is BoardDto[]
$response = Miro::getBoards();
$response = Miro::getBoards(new GetBoardsDto(teamId: 'team_123', limit: 10));

// Single — returns BoardResponse, ->dto() is BoardDto
$response = Miro::getBoard('board_id');

// Create — returns BoardResponse, ->dto() is BoardDto
$response = Miro::createBoard(new CreateBoardDto(name: 'My Board', description: 'Optional'));

// Update — returns BoardResponse, ->dto() is BoardDto
$response = Miro::updateBoard('board_id', new UpdateBoardDto(name: 'Renamed'));

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
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\GetStickyNotesDto;
use CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto;
use CodebarAg\Miro\Facades\Miro;

// List — returns StickyNoteResponse, ->dto() is StickyNoteDto[]
$response = Miro::getStickyNotes('board_id');
$response = Miro::getStickyNotes('board_id', new GetStickyNotesDto(limit: 20));

// Single — returns StickyNoteResponse, ->dto() is StickyNoteDto
$response = Miro::getStickyNote('board_id', 'note_id');

// Create — returns StickyNoteResponse, ->dto() is StickyNoteDto
$response = Miro::createStickyNote('board_id', new CreateStickyNoteDto(
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

// Update — returns StickyNoteResponse, ->dto() is StickyNoteDto
$response = Miro::updateStickyNote('board_id', 'note_id', new UpdateStickyNoteDto(
    content: 'Updated',
    fillColor: 'light_pink',
));

// Delete — returns Saloon\Http\Response (status 204)
Miro::deleteStickyNote('board_id', 'note_id');
```

### StickyNoteDto properties

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

## Frames

```php
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\GetFramesDto;
use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;
use CodebarAg\Miro\Facades\Miro;

// List — returns FrameResponse, ->dto() is FrameDto[]
$response = Miro::getFrames('board_id');
$response = Miro::getFrames('board_id', new GetFramesDto(limit: 20));

// Single — returns FrameResponse, ->dto() is FrameDto
$response = Miro::getFrame('board_id', 'frame_id');

// Create — returns FrameResponse, ->dto() is FrameDto
$response = Miro::createFrame('board_id', new CreateFrameDto(
    title: 'Sprint 1',
    positionX: 0.0,
    positionY: 0.0,
    width: 1920.0,
    height: 1080.0,
    fillColor: '#ffffff',
));

// Update — returns FrameResponse, ->dto() is FrameDto
$response = Miro::updateFrame('board_id', 'frame_id', new UpdateFrameDto(
    title: 'Sprint 1 – Updated',
));

// Delete — returns Saloon\Http\Response (status 204)
Miro::deleteFrame('board_id', 'frame_id');
```

### FrameDto properties

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

## Board Items

```php
use CodebarAg\Miro\Dto\BoardItems\GetBoardItemsDto;
use CodebarAg\Miro\Facades\Miro;

// List — returns BoardItemResponse, ->dto() is BoardItemDto[]
$response = Miro::getBoardItems('board_id');
$response = Miro::getBoardItems('board_id', new GetBoardItemsDto(
    type: 'sticky_note',
    limit: 50,
    cursor: 'next_page_cursor',
));

// Single — returns BoardItemResponse, ->dto() is BoardItemDto
$response = Miro::getBoardItem('board_id', 'item_id');
```

### BoardItemDto properties

```php
$item->id;          // string
$item->type;        // string (e.g. sticky_note, card, shape, text, frame)
$item->data;        // ?array (type-specific content)
$item->position;    // ?array (x, y, origin, relativeTo)
$item->geometry;    // ?array (width, height, rotation)
$item->createdAt;   // ?string (ISO 8601)
$item->modifiedAt;  // ?string (ISO 8601)
$item->parentId;    // ?string
```

## Using the connector directly

Use the connector methods (not `->send()`) to get typed `*Response` objects:

```php
use CodebarAg\Miro\MiroConnector;

$connector = new MiroConnector();

$response = $connector->getBoards();
$boards = $response->dto(); // BoardDto[]

$response = $connector->getBoard('board_id');
$board = $response->dto(); // BoardDto
```

## Input DTOs reference

| DTO | Namespace | Fields |
|-----|-----------|--------|
| `CreateBoardDto` | `Dto\Boards` | `name` (required), `description`, `teamId` |
| `UpdateBoardDto` | `Dto\Boards` | `name`, `description` (all optional) |
| `GetBoardsDto` | `Dto\Boards` | `teamId`, `projectId`, `query`, `owner`, `limit`, `offset`, `sort` |
| `GetBoardItemsDto` | `Dto\BoardItems` | `limit`, `cursor`, `type` |
| `CreateStickyNoteDto` | `Dto\StickyNotes` | `content`, `shape`, `fillColor`, `textAlign`, `textAlignVertical`, `positionX`, `positionY`, `positionOrigin`, `width`, `parentId` |
| `UpdateStickyNoteDto` | `Dto\StickyNotes` | same as Create, all optional |
| `GetStickyNotesDto` | `Dto\StickyNotes` | `limit`, `cursor` |
| `CreateFrameDto` | `Dto\Frames` | `title` (required), `fillColor`, `positionX`, `positionY`, `positionOrigin`, `width`, `height`, `parentId` |
| `UpdateFrameDto` | `Dto\Frames` | same as Create, all optional |
| `GetFramesDto` | `Dto\Frames` | `limit`, `cursor` |
