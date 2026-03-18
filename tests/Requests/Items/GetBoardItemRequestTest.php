<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Items\GetBoardItemRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new GetBoardItemRequest('uXjVKGmRXTo=', '3458764591589797401'))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/items/3458764591589797401');
});

it('uses the GET method', function () {
    expect((new GetBoardItemRequest('uXjVKGmRXTo=', '3458764591589797401'))->getMethod())->toBe(Method::GET);
});

it('can perform the request', function () {
    Saloon::fake([
        GetBoardItemRequest::class => MockResponse::fixture('Items/get-board-item'),
    ]);

    $connector = new MiroConnector;
    $response = $connector->send(new GetBoardItemRequest('uXjVKGmRXTo=', '3458764591589797401'));

    Saloon::assertSent(GetBoardItemRequest::class);

    expect($response->json('id'))->toBe('3458764591589797401')
        ->and($response->json('type'))->toBe('sticky_note');
});
