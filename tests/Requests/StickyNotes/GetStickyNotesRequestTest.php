<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNotesRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new GetStickyNotesRequest('uXjVKGmRXTo='))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/items');
});

it('uses the GET method', function () {
    expect((new GetStickyNotesRequest('uXjVKGmRXTo='))->getMethod())->toBe(Method::GET);
});

it('always includes type=sticky_note in query params', function () {
    expect((new GetStickyNotesRequest('uXjVKGmRXTo='))->query()->all())
        ->toBe(['type' => 'sticky_note']);
});

it('merges additional params with type=sticky_note', function () {
    expect((new GetStickyNotesRequest('uXjVKGmRXTo=', ['limit' => 10]))->query()->all())
        ->toBe(['type' => 'sticky_note', 'limit' => 10]);
});

it('can perform the request', function () {
    Saloon::fake([
        GetStickyNotesRequest::class => MockResponse::fixture('StickyNotes/get-sticky-notes'),
    ]);

    $connector = new MiroConnector;
    $response = $connector->send(new GetStickyNotesRequest('uXjVKGmRXTo='));

    Saloon::assertSent(GetStickyNotesRequest::class);

    expect($response->json('data'))->toBeArray()->toHaveCount(1)
        ->and($response->json('data.0.id'))->toBe('3458764591589797401')
        ->and($response->json('data.0.data.content'))->toBe('Hello Miro!');
});
