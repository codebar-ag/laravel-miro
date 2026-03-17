<?php

use CodebarAg\Miro\Dto\BoardItems\BoardItemDto;
use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\FrameDto;
use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto;
use CodebarAg\Miro\MiroConnector;

// ─────────────────────────────────────────────
// Boards
// ─────────────────────────────────────────────
describe('Miro Boards', function () {
    it('can get boards', function () {
        $connector = new MiroConnector;

        $boards = $connector->getBoards();

        expect($boards)->toBeArray()
            ->each->toBeInstanceOf(BoardDto::class);
    });

    it('can create a board', function () {
        $connector = new MiroConnector;

        $board = $connector->createBoard(new CreateBoardDto(
            name: 'Live Test Board '.time(),
        ));

        expect($board)->toBeInstanceOf(BoardDto::class)
            ->and($board->id)->not->toBeEmpty()
            ->and($board->name)->toContain('Live Test Board');

        $connector->deleteBoard($board->id);
    });

    it('can get a specific board', function () {
        $connector = new MiroConnector;

        $created = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board '.time()));
        $board = $connector->getBoard($created->id);

        expect($board)->toBeInstanceOf(BoardDto::class)
            ->and($board->id)->toBe($created->id)
            ->and($board->name)->toBe($created->name);

        $connector->deleteBoard($created->id);
    });

    it('can update a board', function () {
        $connector = new MiroConnector;

        $created = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board '.time()));
        $updated = $connector->updateBoard($created->id, new UpdateBoardDto(name: 'Updated Board'));

        expect($updated)->toBeInstanceOf(BoardDto::class)
            ->and($updated->name)->toBe('Updated Board');

        $connector->deleteBoard($created->id);
    });

    it('can delete a board', function () {
        $connector = new MiroConnector;

        $created = $connector->createBoard(new CreateBoardDto(name: 'Board to Delete '.time()));
        $response = $connector->deleteBoard($created->id);

        expect($response->status())->toBe(204);
    });
})->group('live')->skip();

// ─────────────────────────────────────────────
// Sticky Notes
// ─────────────────────────────────────────────
describe('Miro Sticky Notes', function () {
    it('can get sticky notes from a board', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board StickyNotes '.time()));

        $notes = $connector->getStickyNotes($board->id);

        expect($notes)->toBeArray()
            ->each->toBeInstanceOf(StickyNoteDto::class);

        $connector->deleteBoard($board->id);
    });

    it('can create a sticky note', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board StickyNotes '.time()));

        $note = $connector->createStickyNote($board->id, new CreateStickyNoteDto(
            content: 'Hello from live test!',
            shape: 'square',
            fillColor: 'light_yellow',
            textAlign: 'center',
            textAlignVertical: 'top',
            positionX: 0.0,
            positionY: 0.0,
            positionOrigin: 'center',
        ));

        expect($note)->toBeInstanceOf(StickyNoteDto::class)
            ->and($note->id)->not->toBeEmpty()
            ->and($note->content)->toBe('Hello from live test!')
            ->and($note->shape)->toBe('square')
            ->and($note->fillColor)->toBe('light_yellow');

        $connector->deleteBoard($board->id);
    });

    it('can get a specific sticky note', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board StickyNotes '.time()));

        $created = $connector->createStickyNote($board->id, new CreateStickyNoteDto(
            content: 'Fetch me!',
            shape: 'square',
        ));

        $note = $connector->getStickyNote($board->id, $created->id);

        expect($note)->toBeInstanceOf(StickyNoteDto::class)
            ->and($note->id)->toBe($created->id)
            ->and($note->content)->toBe('Fetch me!');

        $connector->deleteBoard($board->id);
    });

    it('can update a sticky note', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board StickyNotes '.time()));

        $created = $connector->createStickyNote($board->id, new CreateStickyNoteDto(
            content: 'Original content',
            shape: 'square',
            fillColor: 'light_yellow',
        ));

        $updated = $connector->updateStickyNote($board->id, $created->id, new UpdateStickyNoteDto(
            content: 'Updated content',
            fillColor: 'light_pink',
        ));

        expect($updated)->toBeInstanceOf(StickyNoteDto::class)
            ->and($updated->content)->toBe('Updated content')
            ->and($updated->fillColor)->toBe('light_pink');

        $connector->deleteBoard($board->id);
    });

    it('can delete a sticky note', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board StickyNotes '.time()));

        $created = $connector->createStickyNote($board->id, new CreateStickyNoteDto(
            content: 'Delete me!',
            shape: 'square',
        ));

        $response = $connector->deleteStickyNote($board->id, $created->id);

        expect($response->status())->toBe(204);

        $connector->deleteBoard($board->id);
    });
})->group('live')->skip();

// ─────────────────────────────────────────────
// Frames
// ─────────────────────────────────────────────
describe('Miro Frames', function () {
    it('can get frames from a board', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board Frames '.time()));

        $frames = $connector->getFrames($board->id);

        expect($frames)->toBeArray()
            ->each->toBeInstanceOf(FrameDto::class);

        $connector->deleteBoard($board->id);
    });

    it('can create a frame', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board Frames '.time()));

        $frame = $connector->createFrame($board->id, new CreateFrameDto(
            title: 'Live Test Frame',
            positionX: 0.0,
            positionY: 0.0,
            width: 1920.0,
            height: 1080.0,
        ));

        expect($frame)->toBeInstanceOf(FrameDto::class)
            ->and($frame->id)->not->toBeEmpty()
            ->and($frame->title)->toBe('Live Test Frame')
            ->and($frame->width)->toBe(1920.0)
            ->and($frame->height)->toBe(1080.0);

        $connector->deleteBoard($board->id);
    });

    it('can get a specific frame', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board Frames '.time()));

        $created = $connector->createFrame($board->id, new CreateFrameDto(title: 'Fetch me!'));
        $frame = $connector->getFrame($board->id, $created->id);

        expect($frame)->toBeInstanceOf(FrameDto::class)
            ->and($frame->id)->toBe($created->id)
            ->and($frame->title)->toBe('Fetch me!');

        $connector->deleteBoard($board->id);
    });

    it('can update a frame', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board Frames '.time()));

        $created = $connector->createFrame($board->id, new CreateFrameDto(title: 'Original Title'));
        $updated = $connector->updateFrame($board->id, $created->id, new UpdateFrameDto(title: 'Updated Title'));

        expect($updated)->toBeInstanceOf(FrameDto::class)
            ->and($updated->title)->toBe('Updated Title');

        $connector->deleteBoard($board->id);
    });

    it('can delete a frame', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board Frames '.time()));

        $created = $connector->createFrame($board->id, new CreateFrameDto(title: 'Delete me!'));
        $response = $connector->deleteFrame($board->id, $created->id);

        expect($response->status())->toBe(204);

        $connector->deleteBoard($board->id);
    });
})->group('live')->skip();

// ─────────────────────────────────────────────
// Board Items
// ─────────────────────────────────────────────
describe('Miro Board Items', function () {
    it('can get board items from a board', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board BoardItems '.time()));

        $connector->createStickyNote($board->id, new CreateStickyNoteDto(content: 'Item 1'));
        $connector->createStickyNote($board->id, new CreateStickyNoteDto(content: 'Item 2'));

        $items = $connector->getBoardItems($board->id);

        expect($items)->toBeArray()
            ->toHaveCount(2)
            ->each->toBeInstanceOf(BoardItemDto::class);

        $connector->deleteBoard($board->id);
    });

    it('can get a specific board item', function () {
        $connector = new MiroConnector;
        $board = $connector->createBoard(new CreateBoardDto(name: 'Live Test Board BoardItems '.time()));

        $note = $connector->createStickyNote($board->id, new CreateStickyNoteDto(content: 'Fetch me!'));
        $item = $connector->getBoardItem($board->id, $note->id);

        expect($item)->toBeInstanceOf(BoardItemDto::class)
            ->and($item->id)->toBe($note->id)
            ->and($item->type)->toBe('sticky_note');

        $connector->deleteBoard($board->id);
    });
})->group('live')->skip();
