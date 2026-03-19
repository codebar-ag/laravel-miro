<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
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
use CodebarAg\Miro\Requests\Items\GetBoardItemRequest;
use CodebarAg\Miro\Requests\Items\GetBoardItemsRequest;
use CodebarAg\Miro\Requests\StickyNotes\CreateStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\DeleteStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNotesRequest;
use CodebarAg\Miro\Requests\StickyNotes\UpdateStickyNoteRequest;
use CodebarAg\Miro\Responses\Boards\BoardResponse;
use CodebarAg\Miro\Responses\Frames\FrameResponse;
use CodebarAg\Miro\Responses\Items\BoardItemResponse;
use CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves to MiroConnector', function () {
    expect(Miro::getFacadeRoot())->toBeInstanceOf(MiroConnector::class);
});

// Boards

it('getBoards proxies to connector and returns BoardResponse', function () {
    Saloon::fake([GetBoardsRequest::class => MockResponse::fixture('Boards/get-boards')]);

    expect(Miro::getBoards())->toBeInstanceOf(BoardResponse::class);
});

it('getBoard proxies to connector and returns BoardResponse', function () {
    Saloon::fake([GetBoardRequest::class => MockResponse::fixture('Boards/get-board')]);

    $response = Miro::getBoard('uXjVKGmRXTo=');

    expect($response)->toBeInstanceOf(BoardResponse::class)
        ->and($response->dto()->id)->toBe('uXjVKGmRXTo=');
});

it('createBoard proxies to connector and returns BoardResponse', function () {
    Saloon::fake([CreateBoardRequest::class => MockResponse::fixture('Boards/create-board')]);

    $response = Miro::createBoard(new CreateBoardDto(name: 'New Board'));

    expect($response)->toBeInstanceOf(BoardResponse::class)
        ->and($response->dto()->name)->toBe('New Board');
});

it('updateBoard proxies to connector and returns BoardResponse', function () {
    Saloon::fake([UpdateBoardRequest::class => MockResponse::fixture('Boards/update-board')]);

    $response = Miro::updateBoard('uXjVKGmRXTo=', new UpdateBoardDto(name: 'Renamed Board'));

    expect($response)->toBeInstanceOf(BoardResponse::class)
        ->and($response->dto()->name)->toBe('Renamed Board');
});

it('deleteBoard proxies to connector and returns raw response', function () {
    Saloon::fake([DeleteBoardRequest::class => MockResponse::fixture('Boards/delete-board')]);

    expect(Miro::deleteBoard('uXjVKGmRXTo=')->status())->toBe(204);
});

// Board Items

it('getBoardItems proxies to connector and returns BoardItemResponse', function () {
    Saloon::fake([GetBoardItemsRequest::class => MockResponse::fixture('Items/get-board-items')]);

    expect(Miro::getBoardItems('uXjVKGmRXTo='))->toBeInstanceOf(BoardItemResponse::class);
});

it('getBoardItem proxies to connector and returns BoardItemResponse', function () {
    Saloon::fake([GetBoardItemRequest::class => MockResponse::fixture('Items/get-board-item')]);

    $response = Miro::getBoardItem('uXjVKGmRXTo=', '3458764591589797401');

    expect($response)->toBeInstanceOf(BoardItemResponse::class)
        ->and($response->dto()->id)->toBe('3458764591589797401');
});

// Sticky Notes

it('getStickyNotes proxies to connector and returns StickyNoteResponse', function () {
    Saloon::fake([GetStickyNotesRequest::class => MockResponse::fixture('StickyNotes/get-sticky-notes')]);

    expect(Miro::getStickyNotes('uXjVKGmRXTo='))->toBeInstanceOf(StickyNoteResponse::class);
});

it('getStickyNote proxies to connector and returns StickyNoteResponse', function () {
    Saloon::fake([GetStickyNoteRequest::class => MockResponse::fixture('StickyNotes/get-sticky-note')]);

    $response = Miro::getStickyNote('uXjVKGmRXTo=', '3458764591589797401');

    expect($response)->toBeInstanceOf(StickyNoteResponse::class)
        ->and($response->dto()->id)->toBe('3458764591589797401');
});

it('createStickyNote proxies to connector and returns StickyNoteResponse', function () {
    Saloon::fake([CreateStickyNoteRequest::class => MockResponse::fixture('StickyNotes/create-sticky-note')]);

    $response = Miro::createStickyNote('uXjVKGmRXTo=', new CreateStickyNoteDto(
        content: 'New Note',
        shape: 'square',
    ));

    expect($response)->toBeInstanceOf(StickyNoteResponse::class)
        ->and($response->dto()->content)->toBe('New Note');
});

it('updateStickyNote proxies to connector and returns StickyNoteResponse', function () {
    Saloon::fake([UpdateStickyNoteRequest::class => MockResponse::fixture('StickyNotes/update-sticky-note')]);

    $response = Miro::updateStickyNote('uXjVKGmRXTo=', '3458764591589797401', new UpdateStickyNoteDto(
        content: 'Updated Note',
    ));

    expect($response)->toBeInstanceOf(StickyNoteResponse::class)
        ->and($response->dto()->content)->toBe('Updated Note');
});

it('deleteStickyNote proxies to connector and returns raw response', function () {
    Saloon::fake([DeleteStickyNoteRequest::class => MockResponse::fixture('StickyNotes/delete-sticky-note')]);

    expect(Miro::deleteStickyNote('uXjVKGmRXTo=', '3458764591589797401')->status())->toBe(204);
});

// Frames

it('getFrames proxies to connector and returns FrameResponse', function () {
    Saloon::fake([GetFramesRequest::class => MockResponse::fixture('Frames/get-frames')]);

    expect(Miro::getFrames('uXjVKGmRXTo='))->toBeInstanceOf(FrameResponse::class);
});

it('getFrame proxies to connector and returns FrameResponse', function () {
    Saloon::fake([GetFrameRequest::class => MockResponse::fixture('Frames/get-frame')]);

    $response = Miro::getFrame('uXjVKGmRXTo=', '3458764591589797501');

    expect($response)->toBeInstanceOf(FrameResponse::class)
        ->and($response->dto()->id)->toBe('3458764591589797501');
});

it('createFrame proxies to connector and returns FrameResponse', function () {
    Saloon::fake([CreateFrameRequest::class => MockResponse::fixture('Frames/create-frame')]);

    $response = Miro::createFrame('uXjVKGmRXTo=', new CreateFrameDto(title: 'New Frame'));

    expect($response)->toBeInstanceOf(FrameResponse::class)
        ->and($response->dto()->title)->toBe('New Frame');
});

it('updateFrame proxies to connector and returns FrameResponse', function () {
    Saloon::fake([UpdateFrameRequest::class => MockResponse::fixture('Frames/update-frame')]);

    $response = Miro::updateFrame('uXjVKGmRXTo=', '3458764591589797501', new UpdateFrameDto(title: 'Renamed Frame'));

    expect($response)->toBeInstanceOf(FrameResponse::class)
        ->and($response->dto()->title)->toBe('Renamed Frame');
});

it('deleteFrame proxies to connector and returns raw response', function () {
    Saloon::fake([DeleteFrameRequest::class => MockResponse::fixture('Frames/delete-frame')]);

    expect(Miro::deleteFrame('uXjVKGmRXTo=', '3458764591589797501')->status())->toBe(204);
});
