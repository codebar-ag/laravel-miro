<?php

use CodebarAg\Miro\Dto\BoardDto;
use CodebarAg\Miro\Dto\StickyNoteDto;
use CodebarAg\Miro\MiroConnector;

// ─────────────────────────────────────────────
// Boards
// ─────────────────────────────────────────────

it('live: can get boards', function () {
    $connector = new MiroConnector;

    $boards = $connector->getBoards();

    expect($boards)->toBeArray();
    dump($boards);
})->group('live');

it('live: can create a board', function () {
    $connector = new MiroConnector;

    $board = $connector->createBoard(['name' => 'Live Test Board '.time()]);

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->id)->not->toBeEmpty()
        ->and($board->name)->toContain('Live Test Board');

    $connector->deleteBoard($board->id);
})->group('live');

it('live: can get a specific board', function () {
    $connector = new MiroConnector;

    $created = $connector->createBoard(['name' => 'Live Test Board '.time()]);
    $board = $connector->getBoard($created->id);

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->id)->toBe($created->id);

    $connector->deleteBoard($created->id);
})->group('live');

it('live: can update a board', function () {
    $connector = new MiroConnector;

    $created = $connector->createBoard(['name' => 'Live Test Board '.time()]);
    $updated = $connector->updateBoard($created->id, ['name' => 'Updated Board']);

    expect($updated->name)->toBe('Updated Board');

    $connector->deleteBoard($created->id);
})->group('live');

it('live: can delete a board', function () {
    $connector = new MiroConnector;

    $created = $connector->createBoard(['name' => 'Board to Delete '.time()]);
    $response = $connector->deleteBoard($created->id);

    expect($response->status())->toBe(204);
})->group('live');

// ─────────────────────────────────────────────
// Sticky Notes
// ─────────────────────────────────────────────

describe('Sticky Notes', function () {
    beforeEach(function () {
        $this->connector = new MiroConnector;
        $this->board = $this->connector->createBoard(['name' => 'Live Test Board StickyNotes'.time()]);
    });

    afterEach(function () {
        $this->connector->deleteBoard($this->board->id);
    });

    it('live: can get sticky notes from a board', function () {
        $notes = $this->connector->getStickyNotes($this->board->id);

        expect($notes)->toBeArray();
        dump($notes);
    });

    it('live: can create a sticky note', function () {
        $note = $this->connector->createStickyNote($this->board->id, [
            'data' => [
                'content' => 'Hello from live test!',
                'shape' => 'square',
            ],
            'style' => [
                'fillColor' => 'light_yellow',
                'textAlign' => 'center',
                'textAlignVertical' => 'top',
            ],
            'position' => [
                'x' => 0.0,
                'y' => 0.0,
                'origin' => 'center',
                'relativeTo' => 'canvas_center',
            ],
        ]);

        expect($note)->toBeInstanceOf(StickyNoteDto::class)
            ->and($note->id)->not->toBeEmpty()
            ->and($note->content)->toBe('Hello from live test!')
            ->and($note->shape)->toBe('square')
            ->and($note->fillColor)->toBe('light_yellow');

        dump($note);
    });

    it('live: can get a specific sticky note', function () {
        $created = $this->connector->createStickyNote($this->board->id, [
            'data' => ['content' => 'Fetch me!', 'shape' => 'square'],
        ]);

        $note = $this->connector->getStickyNote($this->board->id, $created->id);

        expect($note)->toBeInstanceOf(StickyNoteDto::class)
            ->and($note->id)->toBe($created->id)
            ->and($note->content)->toBe('Fetch me!');

        dump($note);
    });

    it('live: can update a sticky note', function () {
        $created = $this->connector->createStickyNote($this->board->id, [
            'data' => ['content' => 'Original content', 'shape' => 'square'],
            'style' => ['fillColor' => 'light_yellow'],
        ]);

        $updated = $this->connector->updateStickyNote($this->board->id, $created->id, [
            'data' => ['content' => 'Updated content'],
            'style' => ['fillColor' => 'light_pink'],
        ]);

        expect($updated)->toBeInstanceOf(StickyNoteDto::class)
            ->and($updated->content)->toBe('Updated content')
            ->and($updated->fillColor)->toBe('light_pink');

        dump($updated);
    });

    it('live: can delete a sticky note', function () {
        $created = $this->connector->createStickyNote($this->board->id, [
            'data' => ['content' => 'Delete me!', 'shape' => 'square'],
        ]);

        $response = $this->connector->deleteStickyNote($this->board->id, $created->id);

        expect($response->status())->toBe(204);
    });
})->group('live');
