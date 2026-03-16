<?php

use CodebarAg\Miro\Dto\BoardDto;
use CodebarAg\Miro\Dto\StickyNoteDto;
use CodebarAg\Miro\MiroConnector;

// ─────────────────────────────────────────────
// Boards
// ─────────────────────────────────────────────

it('can get boards', function () {
    $connector = new MiroConnector;

    $boards = $connector->getBoards();

    expect($boards)->toBeArray();
    dump($boards);
})->group('live');

it('can create a board', function () {
    $connector = new MiroConnector;

    $board = $connector->createBoard(['name' => 'Live Test Board '.time()]);

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->id)->not->toBeEmpty()
        ->and($board->name)->toContain('Live Test Board');

    $connector->deleteBoard($board->id);
})->group('live');

it('can get a specific board', function () {
    $connector = new MiroConnector;

    $created = $connector->createBoard(['name' => 'Live Test Board '.time()]);
    $board = $connector->getBoard($created->id);

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->id)->toBe($created->id);

    $connector->deleteBoard($created->id);
})->group('live');

it('can update a board', function () {
    $connector = new MiroConnector;

    $created = $connector->createBoard(['name' => 'Live Test Board '.time()]);
    $updated = $connector->updateBoard($created->id, ['name' => 'Updated Board']);

    expect($updated->name)->toBe('Updated Board');

    $connector->deleteBoard($created->id);
})->group('live');

it('can delete a board', function () {
    $connector = new MiroConnector;

    $created = $connector->createBoard(['name' => 'Board to Delete '.time()]);
    $response = $connector->deleteBoard($created->id);

    expect($response->status())->toBe(204);
})->group('live');

// ─────────────────────────────────────────────
// Sticky Notes
// ─────────────────────────────────────────────

it('can get sticky notes from a board', function () {
    $connector = new MiroConnector;
    $board = $connector->createBoard(['name' => 'Live Test Board StickyNotes '.time()]);

    $notes = $connector->getStickyNotes($board->id);

    expect($notes)->toBeArray();
    dump($notes);

    $connector->deleteBoard($board->id);
})->group('live');

it('can create a sticky note', function () {
    $connector = new MiroConnector;
    $board = $connector->createBoard(['name' => 'Live Test Board StickyNotes '.time()]);

    $note = $connector->createStickyNote($board->id, [
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

    $connector->deleteBoard($board->id);
})->group('live');

it('can get a specific sticky note', function () {
    $connector = new MiroConnector;
    $board = $connector->createBoard(['name' => 'Live Test Board StickyNotes '.time()]);

    $created = $connector->createStickyNote($board->id, [
        'data' => ['content' => 'Fetch me!', 'shape' => 'square'],
    ]);

    $note = $connector->getStickyNote($board->id, $created->id);

    expect($note)->toBeInstanceOf(StickyNoteDto::class)
        ->and($note->id)->toBe($created->id)
        ->and($note->content)->toBe('Fetch me!');

    dump($note);

    $connector->deleteBoard($board->id);
})->group('live');

it('can update a sticky note', function () {
    $connector = new MiroConnector;
    $board = $connector->createBoard(['name' => 'Live Test Board StickyNotes '.time()]);

    $created = $connector->createStickyNote($board->id, [
        'data' => ['content' => 'Original content', 'shape' => 'square'],
        'style' => ['fillColor' => 'light_yellow'],
    ]);

    $updated = $connector->updateStickyNote($board->id, $created->id, [
        'data' => ['content' => 'Updated content'],
        'style' => ['fillColor' => 'light_pink'],
    ]);

    expect($updated)->toBeInstanceOf(StickyNoteDto::class)
        ->and($updated->content)->toBe('Updated content')
        ->and($updated->fillColor)->toBe('light_pink');

    dump($updated);

    $connector->deleteBoard($board->id);
})->group('live');

it('can delete a sticky note', function () {
    $connector = new MiroConnector;
    $board = $connector->createBoard(['name' => 'Live Test Board StickyNotes '.time()]);

    $created = $connector->createStickyNote($board->id, [
        'data' => ['content' => 'Delete me!', 'shape' => 'square'],
    ]);

    $response = $connector->deleteStickyNote($board->id, $created->id);

    expect($response->status())->toBe(204);

    $connector->deleteBoard($board->id);
})->group('live');
