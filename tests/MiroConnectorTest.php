<?php

use CodebarAg\Miro\Dto\BoardItems\BoardItemDto;
use CodebarAg\Miro\Dto\BoardItems\GetBoardItemsDto;
use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Boards\GetBoardsDto;
use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\FrameDto;
use CodebarAg\Miro\Dto\Frames\GetFramesDto;
use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\GetStickyNotesDto;
use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\CreateBoardRequest;
use CodebarAg\Miro\Requests\Boards\DeleteBoardRequest;
use CodebarAg\Miro\Requests\Boards\GetBoardRequest;
use CodebarAg\Miro\Requests\Boards\GetBoardsRequest;
use CodebarAg\Miro\Requests\Boards\UpdateBoardRequest;
use CodebarAg\Miro\Requests\Frames\CreateFrameRequest;
use CodebarAg\Miro\Requests\Frames\DeleteFrameRequest;
use CodebarAg\Miro\Requests\Frames\GetFrameRequest;
use CodebarAg\Miro\Requests\Frames\GetFramesRequest;
use CodebarAg\Miro\Requests\Frames\UpdateFrameRequest;
use CodebarAg\Miro\Requests\Items\GetBoardItemsRequest;
use CodebarAg\Miro\Requests\StickyNotes\CreateStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\DeleteStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetBoardStickyNotesRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNotesRequest;
use CodebarAg\Miro\Requests\StickyNotes\UpdateStickyNoteRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('can instantiate the connector', function () {
    $connector = new MiroConnector();

    expect($connector)->toBeInstanceOf(MiroConnector::class);
});

it('resolves base url correctly', function () {
    $connector = new MiroConnector();

    expect($connector->resolveBaseUrl())->toBe('https://api.miro.com');
});

it('can get boards', function () {
    $mockClient = new MockClient([
        GetBoardsRequest::class => MockResponse::make([
            'data' => [
                [
                    'id' => 'board_1',
                    'name' => 'Test Board',
                    'description' => 'A test board',
                    'type' => 'board',
                    'viewLink' => 'https://miro.com/app/board/board_1/',
                    'createdAt' => '2024-01-01T00:00:00Z',
                    'modifiedAt' => '2024-01-02T00:00:00Z',
                ],
            ],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $boards = $connector->getBoards();

    expect($boards)->toBeArray()
        ->toHaveCount(1)
        ->and($boards[0])->toBeInstanceOf(BoardDto::class)
        ->and($boards[0]->id)->toBe('board_1')
        ->and($boards[0]->name)->toBe('Test Board');
});

it('can get boards with filter dto', function () {
    $mockClient = new MockClient([
        GetBoardsRequest::class => MockResponse::make(['data' => []], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $boards = $connector->getBoards(new GetBoardsDto(limit: 10, query: 'test'));

    expect($boards)->toBeArray();
});

it('can get a specific board', function () {
    $mockClient = new MockClient([
        GetBoardRequest::class => MockResponse::make([
            'id' => 'board_1',
            'name' => 'Test Board',
            'description' => 'A test board',
            'type' => 'board',
            'viewLink' => 'https://miro.com/app/board/board_1/',
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $board = $connector->getBoard('board_1');

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->id)->toBe('board_1')
        ->and($board->name)->toBe('Test Board');
});

it('can create a board', function () {
    $mockClient = new MockClient([
        CreateBoardRequest::class => MockResponse::make([
            'id' => 'board_new',
            'name' => 'New Board',
            'description' => null,
            'type' => 'board',
            'viewLink' => 'https://miro.com/app/board/board_new/',
        ], 201),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $board = $connector->createBoard(new CreateBoardDto(name: 'New Board'));

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->id)->toBe('board_new')
        ->and($board->name)->toBe('New Board');
});

it('can update a board', function () {
    $mockClient = new MockClient([
        UpdateBoardRequest::class => MockResponse::make([
            'id' => 'board_1',
            'name' => 'Renamed Board',
            'description' => null,
            'type' => 'board',
            'viewLink' => 'https://miro.com/app/board/board_1/',
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $board = $connector->updateBoard('board_1', new UpdateBoardDto(name: 'Renamed Board'));

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->name)->toBe('Renamed Board');
});

it('can delete a board', function () {
    $mockClient = new MockClient([
        DeleteBoardRequest::class => MockResponse::make([], 204),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $response = $connector->deleteBoard('board_1');

    expect($response->status())->toBe(204);
});

it('can get board items', function () {
    $mockClient = new MockClient([
        GetBoardItemsRequest::class => MockResponse::make([
            'data' => [
                [
                    'id' => 'item_1',
                    'type' => 'sticky_note',
                    'data' => ['content' => 'Hello Miro!'],
                    'position' => ['x' => 0.0, 'y' => 0.0, 'origin' => 'center'],
                    'geometry' => ['width' => 199.0, 'height' => 199.0],
                    'createdAt' => '2024-01-01T00:00:00Z',
                    'modifiedAt' => '2024-01-01T00:00:00Z',
                ],
            ],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $items = $connector->getBoardItems('board_1');

    expect($items)->toBeArray()
        ->toHaveCount(1)
        ->and($items[0])->toBeInstanceOf(BoardItemDto::class)
        ->and($items[0]->id)->toBe('item_1')
        ->and($items[0]->type)->toBe('sticky_note');
});

it('can get board items with filter dto', function () {
    $mockClient = new MockClient([
        GetBoardItemsRequest::class => MockResponse::make(['data' => []], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $items = $connector->getBoardItems('board_1', new GetBoardItemsDto(limit: 5, type: 'sticky_note'));

    expect($items)->toBeArray();
});

it('can get sticky notes', function () {
    $mockClient = new MockClient([
        GetStickyNotesRequest::class => MockResponse::make([
            'data' => [
                [
                    'id' => 'note_1',
                    'type' => 'sticky_note',
                    'data' => ['content' => 'Hello Miro!', 'shape' => 'square'],
                    'style' => ['fillColor' => 'light_yellow', 'textAlign' => 'center', 'textAlignVertical' => 'top'],
                    'position' => ['x' => 10.0, 'y' => 20.0],
                    'geometry' => ['width' => 199.0, 'height' => 199.0],
                    'createdAt' => '2024-01-01T00:00:00Z',
                    'modifiedAt' => '2024-01-01T00:00:00Z',
                ],
            ],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $notes = $connector->getStickyNotes('board_1');

    expect($notes)->toBeArray()
        ->toHaveCount(1)
        ->and($notes[0])->toBeInstanceOf(StickyNoteDto::class)
        ->and($notes[0]->id)->toBe('note_1')
        ->and($notes[0]->content)->toBe('Hello Miro!')
        ->and($notes[0]->shape)->toBe('square')
        ->and($notes[0]->fillColor)->toBe('light_yellow');
});

it('can get sticky notes with filter dto', function () {
    $mockClient = new MockClient([
        GetStickyNotesRequest::class => MockResponse::make(['data' => []], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $notes = $connector->getStickyNotes('board_1', new GetStickyNotesDto(limit: 20));

    expect($notes)->toBeArray();
});

it('can get a specific sticky note', function () {
    $mockClient = new MockClient([
        GetStickyNoteRequest::class => MockResponse::make([
            'id' => 'note_1',
            'type' => 'sticky_note',
            'data' => ['content' => 'Hello Miro!', 'shape' => 'square'],
            'style' => ['fillColor' => 'light_yellow', 'textAlign' => 'center', 'textAlignVertical' => 'top'],
            'position' => ['x' => 10.0, 'y' => 20.0],
            'geometry' => ['width' => 199.0, 'height' => 199.0],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $note = $connector->getStickyNote('board_1', 'note_1');

    expect($note)->toBeInstanceOf(StickyNoteDto::class)
        ->and($note->id)->toBe('note_1')
        ->and($note->content)->toBe('Hello Miro!')
        ->and($note->positionX)->toBe(10.0)
        ->and($note->positionY)->toBe(20.0)
        ->and($note->width)->toBe(199.0);
});

it('can create a sticky note', function () {
    $mockClient = new MockClient([
        CreateStickyNoteRequest::class => MockResponse::make([
            'id' => 'note_new',
            'type' => 'sticky_note',
            'data' => ['content' => 'New Note', 'shape' => 'square'],
            'style' => ['fillColor' => 'light_yellow'],
            'position' => ['x' => 0.0, 'y' => 0.0],
            'geometry' => ['width' => 199.0, 'height' => 199.0],
        ], 201),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $note = $connector->createStickyNote('board_1', new CreateStickyNoteDto(
        content: 'New Note',
        shape: 'square',
        fillColor: 'light_yellow',
    ));

    expect($note)->toBeInstanceOf(StickyNoteDto::class)
        ->and($note->id)->toBe('note_new')
        ->and($note->content)->toBe('New Note');
});

it('can update a sticky note', function () {
    $mockClient = new MockClient([
        UpdateStickyNoteRequest::class => MockResponse::make([
            'id' => 'note_1',
            'type' => 'sticky_note',
            'data' => ['content' => 'Updated Note', 'shape' => 'square'],
            'style' => ['fillColor' => 'light_pink'],
            'position' => ['x' => 0.0, 'y' => 0.0],
            'geometry' => ['width' => 199.0, 'height' => 199.0],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $note = $connector->updateStickyNote('board_1', 'note_1', new UpdateStickyNoteDto(
        content: 'Updated Note',
        fillColor: 'light_pink',
    ));

    expect($note)->toBeInstanceOf(StickyNoteDto::class)
        ->and($note->content)->toBe('Updated Note')
        ->and($note->fillColor)->toBe('light_pink');
});

it('can delete a sticky note', function () {
    $mockClient = new MockClient([
        DeleteStickyNoteRequest::class => MockResponse::make([], 204),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $response = $connector->deleteStickyNote('board_1', 'note_1');

    expect($response->status())->toBe(204);
});

it('maps sticky note dto fields correctly', function () {
    $note = StickyNoteDto::fromResponse([
        'id' => 'note_123',
        'type' => 'sticky_note',
        'data' => ['content' => 'Test content', 'shape' => 'rectangle'],
        'style' => ['fillColor' => 'dark_blue', 'textAlign' => 'left', 'textAlignVertical' => 'middle'],
        'position' => ['x' => 5.0, 'y' => 15.0],
        'geometry' => ['width' => 320.0, 'height' => 320.0],
        'parent' => ['id' => 'frame_1'],
        'createdAt' => '2024-01-01T00:00:00Z',
        'modifiedAt' => '2024-06-01T00:00:00Z',
    ]);

    expect($note->id)->toBe('note_123')
        ->and($note->content)->toBe('Test content')
        ->and($note->shape)->toBe('rectangle')
        ->and($note->fillColor)->toBe('dark_blue')
        ->and($note->textAlign)->toBe('left')
        ->and($note->textAlignVertical)->toBe('middle')
        ->and($note->positionX)->toBe(5.0)
        ->and($note->positionY)->toBe(15.0)
        ->and($note->width)->toBe(320.0)
        ->and($note->parentId)->toBe('frame_1');
});

it('resolves GetBoardStickyNotesRequest endpoint correctly', function () {
    $request = new GetBoardStickyNotesRequest('board_1');

    expect($request->resolveEndpoint())->toBe('/v2/boards/board_1/sticky_notes');
});

it('can get frames', function () {
    $mockClient = new MockClient([
        GetFramesRequest::class => MockResponse::make([
            'data' => [
                [
                    'id' => 'frame_1',
                    'type' => 'frame',
                    'data' => ['title' => 'My Frame'],
                    'style' => ['fillColor' => '#ffffff'],
                    'position' => ['x' => 0.0, 'y' => 0.0],
                    'geometry' => ['width' => 800.0, 'height' => 600.0],
                    'createdAt' => '2024-01-01T00:00:00Z',
                    'modifiedAt' => '2024-01-02T00:00:00Z',
                ],
            ],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $frames = $connector->getFrames('board_1');

    expect($frames)->toBeArray()
        ->toHaveCount(1)
        ->and($frames[0])->toBeInstanceOf(FrameDto::class)
        ->and($frames[0]->id)->toBe('frame_1')
        ->and($frames[0]->title)->toBe('My Frame')
        ->and($frames[0]->fillColor)->toBe('#ffffff');
});

it('can get frames with filter dto', function () {
    $mockClient = new MockClient([
        GetFramesRequest::class => MockResponse::make(['data' => []], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $frames = $connector->getFrames('board_1', new GetFramesDto(limit: 10));

    expect($frames)->toBeArray();
});

it('can get a specific frame', function () {
    $mockClient = new MockClient([
        GetFrameRequest::class => MockResponse::make([
            'id' => 'frame_1',
            'type' => 'frame',
            'data' => ['title' => 'My Frame'],
            'style' => ['fillColor' => '#ffffff'],
            'position' => ['x' => 10.0, 'y' => 20.0],
            'geometry' => ['width' => 800.0, 'height' => 600.0],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $frame = $connector->getFrame('board_1', 'frame_1');

    expect($frame)->toBeInstanceOf(FrameDto::class)
        ->and($frame->id)->toBe('frame_1')
        ->and($frame->title)->toBe('My Frame')
        ->and($frame->positionX)->toBe(10.0)
        ->and($frame->positionY)->toBe(20.0)
        ->and($frame->width)->toBe(800.0)
        ->and($frame->height)->toBe(600.0);
});

it('can create a frame', function () {
    $mockClient = new MockClient([
        CreateFrameRequest::class => MockResponse::make([
            'id' => 'frame_new',
            'type' => 'frame',
            'data' => ['title' => 'New Frame'],
            'style' => ['fillColor' => '#e6e6e6'],
            'position' => ['x' => 0.0, 'y' => 0.0],
            'geometry' => ['width' => 800.0, 'height' => 600.0],
        ], 201),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $frame = $connector->createFrame('board_1', new CreateFrameDto(
        title: 'New Frame',
        fillColor: '#e6e6e6',
        width: 800.0,
        height: 600.0,
    ));

    expect($frame)->toBeInstanceOf(FrameDto::class)
        ->and($frame->id)->toBe('frame_new')
        ->and($frame->title)->toBe('New Frame')
        ->and($frame->fillColor)->toBe('#e6e6e6');
});

it('can update a frame', function () {
    $mockClient = new MockClient([
        UpdateFrameRequest::class => MockResponse::make([
            'id' => 'frame_1',
            'type' => 'frame',
            'data' => ['title' => 'Renamed Frame'],
            'style' => ['fillColor' => '#cccccc'],
            'position' => ['x' => 0.0, 'y' => 0.0],
            'geometry' => ['width' => 800.0, 'height' => 600.0],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $frame = $connector->updateFrame('board_1', 'frame_1', new UpdateFrameDto(
        title: 'Renamed Frame',
        fillColor: '#cccccc',
    ));

    expect($frame)->toBeInstanceOf(FrameDto::class)
        ->and($frame->title)->toBe('Renamed Frame')
        ->and($frame->fillColor)->toBe('#cccccc');
});

it('can delete a frame', function () {
    $mockClient = new MockClient([
        DeleteFrameRequest::class => MockResponse::make([], 204),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $response = $connector->deleteFrame('board_1', 'frame_1');

    expect($response->status())->toBe(204);
});

it('maps frame dto fields correctly', function () {
    $frame = FrameDto::fromResponse([
        'id' => 'frame_123',
        'type' => 'frame',
        'data' => ['title' => 'Sprint 1'],
        'style' => ['fillColor' => '#f2f2f2'],
        'position' => ['x' => 5.0, 'y' => 15.0],
        'geometry' => ['width' => 1024.0, 'height' => 768.0],
        'parent' => ['id' => 'parent_frame_1'],
        'createdAt' => '2024-01-01T00:00:00Z',
        'modifiedAt' => '2024-06-01T00:00:00Z',
    ]);

    expect($frame->id)->toBe('frame_123')
        ->and($frame->type)->toBe('frame')
        ->and($frame->title)->toBe('Sprint 1')
        ->and($frame->fillColor)->toBe('#f2f2f2')
        ->and($frame->positionX)->toBe(5.0)
        ->and($frame->positionY)->toBe(15.0)
        ->and($frame->width)->toBe(1024.0)
        ->and($frame->height)->toBe(768.0)
        ->and($frame->parentId)->toBe('parent_frame_1')
        ->and($frame->createdAt)->toBe('2024-01-01T00:00:00Z')
        ->and($frame->modifiedAt)->toBe('2024-06-01T00:00:00Z');
});

it('CreateFrameDto serializes to correct nested array', function () {
    $dto = new CreateFrameDto(
        title: 'My Frame',
        fillColor: '#ffffff',
        positionX: 10.0,
        positionY: 20.0,
        width: 800.0,
        height: 600.0,
        parentId: 'parent_1',
    );

    expect($dto->toArray())->toBe([
        'data' => ['title' => 'My Frame'],
        'style' => ['fillColor' => '#ffffff'],
        'position' => ['x' => 10.0, 'y' => 20.0],
        'geometry' => ['width' => 800.0, 'height' => 600.0],
        'parent' => ['id' => 'parent_1'],
    ]);
});

it('UpdateFrameDto omits null fields', function () {
    $dto = new UpdateFrameDto(title: 'Renamed');

    expect($dto->toArray())->toBe(['data' => ['title' => 'Renamed']]);
});

it('GetFramesDto serializes filter params correctly', function () {
    $dto = new GetFramesDto(limit: 10, cursor: 'abc123');

    expect($dto->toArray())->toBe(['limit' => 10, 'cursor' => 'abc123']);
});

it('GetFramesDto omits null fields', function () {
    $dto = new GetFramesDto();

    expect($dto->toArray())->toBe([]);
});

it('GetFrameRequest resolves endpoint correctly', function () {
    $request = new GetFrameRequest('board_1', 'frame_1');

    expect($request->resolveEndpoint())->toBe('/v2/boards/board_1/frames/frame_1');
});

it('GetFramesRequest resolves endpoint correctly', function () {
    $request = new GetFramesRequest('board_1');

    expect($request->resolveEndpoint())->toBe('/v2/boards/board_1/frames');
});

it('GetBoardStickyNotesRequest sends query params via mock client', function () {
    $mockClient = new MockClient([
        GetBoardStickyNotesRequest::class => MockResponse::make([
            'data' => [
                [
                    'id' => 'note_1',
                    'type' => 'sticky_note',
                    'data' => ['content' => 'Board note', 'shape' => 'square'],
                    'style' => ['fillColor' => 'light_yellow'],
                    'position' => ['x' => 0.0, 'y' => 0.0],
                    'geometry' => ['width' => 199.0, 'height' => 199.0],
                ],
            ],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);

    $request = new GetBoardStickyNotesRequest('board_1', ['limit' => 10]);
    $response = $connector->send($request);

    expect($response->status())->toBe(200)
        ->and($response->json('data.0.id'))->toBe('note_1');
});

it('can get boards via facade', function () {
    $mockClient = new MockClient([
        GetBoardsRequest::class => MockResponse::make([
            'data' => [
                [
                    'id' => 'board_1',
                    'name' => 'Facade Board',
                    'description' => null,
                    'type' => 'board',
                    'viewLink' => 'https://miro.com/app/board/board_1/',
                ],
            ],
        ], 200),
    ]);

    $connector = new MiroConnector();
    $connector->withMockClient($mockClient);
    app()->instance(MiroConnector::class, $connector);

    $boards = Miro::getBoards();

    expect($boards)->toBeArray()
        ->toHaveCount(1)
        ->and($boards[0])->toBeInstanceOf(BoardDto::class)
        ->and($boards[0]->id)->toBe('board_1')
        ->and($boards[0]->name)->toBe('Facade Board');
});

it('maps board dto fields correctly', function () {
    $board = BoardDto::fromResponse([
        'id' => 'board_123',
        'name' => 'My Board',
        'description' => 'Board description',
        'type' => 'board',
        'viewLink' => 'https://miro.com/app/board/board_123/',
        'team' => ['id' => 'team_1'],
        'project' => ['id' => 'project_1'],
        'createdAt' => '2024-01-01T00:00:00Z',
        'modifiedAt' => '2024-06-01T00:00:00Z',
    ]);

    expect($board->id)->toBe('board_123')
        ->and($board->name)->toBe('My Board')
        ->and($board->description)->toBe('Board description')
        ->and($board->teamId)->toBe('team_1')
        ->and($board->projectId)->toBe('project_1');
});

it('CreateStickyNoteDto serializes to correct nested array', function () {
    $dto = new CreateStickyNoteDto(
        content: 'Hello',
        shape: 'square',
        fillColor: 'light_yellow',
        positionX: 10.0,
        positionY: 20.0,
        width: 199.0,
        parentId: 'frame_1',
    );

    expect($dto->toArray())->toBe([
        'data' => ['content' => 'Hello', 'shape' => 'square'],
        'style' => ['fillColor' => 'light_yellow'],
        'position' => ['x' => 10.0, 'y' => 20.0],
        'geometry' => ['width' => 199.0],
        'parent' => ['id' => 'frame_1'],
    ]);
});

it('CreateBoardDto serializes to correct array', function () {
    $dto = new CreateBoardDto(name: 'My Board', description: 'A description');

    expect($dto->toArray())->toBe([
        'name' => 'My Board',
        'description' => 'A description',
    ]);
});

it('UpdateBoardDto omits null fields', function () {
    $dto = new UpdateBoardDto(name: 'Renamed');

    expect($dto->toArray())->toBe(['name' => 'Renamed']);
});

it('GetBoardsDto serializes filter params correctly', function () {
    $dto = new GetBoardsDto(limit: 10, query: 'test');

    expect($dto->toArray())->toMatchArray(['limit' => 10, 'query' => 'test']);
});
