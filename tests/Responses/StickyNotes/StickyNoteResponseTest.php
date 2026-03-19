<?php

use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\StickyNotes\CreateStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNotesRequest;
use CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('fromResponse returns a StickyNoteDto on success', function () {
    $connector = new MiroConnector();
    $connector->withMockClient(new MockClient([
        GetStickyNoteRequest::class => MockResponse::make([
            'id' => '3458764591589797401',
            'type' => 'sticky_note',
            'data' => ['content' => 'Hello Miro!', 'shape' => 'square'],
            'style' => ['fillColor' => 'light_yellow', 'textAlign' => 'center', 'textAlignVertical' => 'top'],
            'position' => ['x' => 10.0, 'y' => 20.0],
            'geometry' => ['width' => 199.0, 'height' => 199.0],
        ], 200),
    ]));

    $response = StickyNoteResponse::fromResponse(
        $connector->send(new GetStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401'))
    );

    expect($response->successful())->toBeTrue()
        ->and($response->dto())->toBeInstanceOf(StickyNoteDto::class)
        ->and($response->dto()->id)->toBe('3458764591589797401')
        ->and($response->dto()->content)->toBe('Hello Miro!')
        ->and($response->dto()->shape)->toBe('square')
        ->and($response->dto()->fillColor)->toBe('light_yellow')
        ->and($response->dto()->positionX)->toBe(10.0)
        ->and($response->dto()->positionY)->toBe(20.0)
        ->and($response->dto()->width)->toBe(199.0);
});

it('collectionFromResponse returns an array of StickyNoteDto on success', function () {
    $connector = new MiroConnector();
    $connector->withMockClient(new MockClient([
        GetStickyNotesRequest::class => MockResponse::make([
            'data' => [
                [
                    'id' => 'note_1', 'type' => 'sticky_note',
                    'data' => ['content' => 'Note 1', 'shape' => 'square'],
                    'style' => ['fillColor' => 'light_yellow'],
                    'position' => ['x' => 0.0, 'y' => 0.0],
                    'geometry' => ['width' => 199.0, 'height' => 199.0],
                ],
                [
                    'id' => 'note_2', 'type' => 'sticky_note',
                    'data' => ['content' => 'Note 2', 'shape' => 'rectangle'],
                    'style' => ['fillColor' => 'light_pink'],
                    'position' => ['x' => 5.0, 'y' => 5.0],
                    'geometry' => ['width' => 199.0, 'height' => 199.0],
                ],
            ],
        ], 200),
    ]));

    $response = StickyNoteResponse::collectionFromResponse(
        $connector->send(new GetStickyNotesRequest('uXjVKGmRXTo='))
    );

    expect($response->successful())->toBeTrue()
        ->and($response->dto())->toBeArray()->toHaveCount(2)
        ->and($response->dto()[0])->toBeInstanceOf(StickyNoteDto::class)
        ->and($response->dto()[0]->id)->toBe('note_1')
        ->and($response->dto()[1]->id)->toBe('note_2');
});

it('fromResponse returns null dto on failure', function () {
    $connector = new MiroConnector();
    $connector->withMockClient(new MockClient([
        CreateStickyNoteRequest::class => MockResponse::make([
            'status' => 400,
            'code' => 'invalid_request',
            'message' => 'Invalid sticky note data',
            'type' => 'error',
        ], 400),
    ]));

    $response = StickyNoteResponse::fromResponse(
        $connector->send(new CreateStickyNoteRequest('uXjVKGmRXTo=', []))
    );

    expect($response->successful())->toBeFalse()
        ->and($response->status())->toBe(400)
        ->and($response->dto())->toBeNull()
        ->and($response->error())->toBe('Invalid sticky note data')
        ->and($response->errorCode())->toBe('invalid_request');
});
