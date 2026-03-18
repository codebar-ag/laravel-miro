<?php

use CodebarAg\Miro\Dto\Frames\FrameDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Frames\GetFrameRequest;
use CodebarAg\Miro\Requests\Frames\GetFramesRequest;
use CodebarAg\Miro\Responses\Frames\FrameResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('fromResponse returns a FrameDto on success', function () {
    $connector = new MiroConnector;
    $connector->withMockClient(new MockClient([
        GetFrameRequest::class => MockResponse::make([
            'id' => '3458764591589797501',
            'type' => 'frame',
            'data' => ['title' => 'Sprint 1'],
            'style' => ['fillColor' => '#ffffff'],
            'position' => ['x' => 10.0, 'y' => 20.0],
            'geometry' => ['width' => 800.0, 'height' => 600.0],
        ], 200),
    ]));

    $response = FrameResponse::fromResponse(
        $connector->send(new GetFrameRequest('uXjVKGmRXTo=', '3458764591589797501'))
    );

    expect($response->successful())->toBeTrue()
        ->and($response->dto())->toBeInstanceOf(FrameDto::class)
        ->and($response->dto()->id)->toBe('3458764591589797501')
        ->and($response->dto()->title)->toBe('Sprint 1')
        ->and($response->dto()->fillColor)->toBe('#ffffff')
        ->and($response->dto()->positionX)->toBe(10.0)
        ->and($response->dto()->positionY)->toBe(20.0)
        ->and($response->dto()->width)->toBe(800.0)
        ->and($response->dto()->height)->toBe(600.0);
});

it('collectionFromResponse returns an array of FrameDto on success', function () {
    $connector = new MiroConnector;
    $connector->withMockClient(new MockClient([
        GetFramesRequest::class => MockResponse::make([
            'data' => [
                [
                    'id' => 'frame_1', 'type' => 'frame',
                    'data' => ['title' => 'Sprint 1'],
                    'style' => ['fillColor' => '#ffffff'],
                    'position' => ['x' => 0.0, 'y' => 0.0],
                    'geometry' => ['width' => 800.0, 'height' => 600.0],
                ],
                [
                    'id' => 'frame_2', 'type' => 'frame',
                    'data' => ['title' => 'Sprint 2'],
                    'style' => ['fillColor' => '#f2f2f2'],
                    'position' => ['x' => 900.0, 'y' => 0.0],
                    'geometry' => ['width' => 800.0, 'height' => 600.0],
                ],
            ],
        ], 200),
    ]));

    $response = FrameResponse::collectionFromResponse(
        $connector->send(new GetFramesRequest('uXjVKGmRXTo='))
    );

    expect($response->successful())->toBeTrue()
        ->and($response->dto())->toBeArray()->toHaveCount(2)
        ->and($response->dto()[0])->toBeInstanceOf(FrameDto::class)
        ->and($response->dto()[0]->id)->toBe('frame_1')
        ->and($response->dto()[1]->id)->toBe('frame_2');
});

it('fromResponse returns null dto on failure', function () {
    $connector = new MiroConnector;
    $connector->withMockClient(new MockClient([
        GetFrameRequest::class => MockResponse::make([
            'status' => 404,
            'code' => 'frame_not_found',
            'message' => 'Frame not found',
            'type' => 'error',
        ], 404),
    ]));

    $response = FrameResponse::fromResponse(
        $connector->send(new GetFrameRequest('uXjVKGmRXTo=', 'nonexistent'))
    );

    expect($response->successful())->toBeFalse()
        ->and($response->status())->toBe(404)
        ->and($response->dto())->toBeNull()
        ->and($response->error())->toBe('Frame not found')
        ->and($response->errorCode())->toBe('frame_not_found');
});
