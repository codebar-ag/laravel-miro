<?php

use CodebarAg\Miro\Requests\Boards\GetBoardRequest;
use CodebarAg\Miro\Requests\Frames\DeleteFrameRequest;
use CodebarAg\Miro\Requests\Items\GetBoardItemsRequest;
use CodebarAg\Miro\Requests\StickyNotes\UpdateStickyNoteRequest;
use CodebarAg\Miro\Support\PathSegment;

it('leaves regular miro ids untouched', function (string $id) {
    expect(PathSegment::encode($id))->toBe($id);
})->with([
    'uXjVKGmRXTo=',
    'uXjVK-mR_To=',
    '3458764591589797501',
]);

it('escapes characters that would leave the path segment', function (string $id, string $expected) {
    expect(PathSegment::encode($id))->toBe($expected);
})->with([
    ['abc/def', 'abc%2Fdef'],
    ['abc\\def', 'abc%5Cdef'],
    ['abc?limit=1', 'abc%3Flimit=1'],
    ['abc#fragment', 'abc%23fragment'],
    ['.', '%2E'],
    ['..', '%2E%2E'],
    ['a.b', 'a.b'],
]);

it('keeps ids inside their own path segment when building endpoints', function () {
    expect((new DeleteFrameRequest('uXjVKGmRXTo=', '../../other-board'))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/frames/..%2F..%2Fother-board')
        ->and((new DeleteFrameRequest('uXjVKGmRXTo=', '..'))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/frames/%2E%2E')
        ->and((new GetBoardRequest('uXjVKGmRXTo=?team_id=1'))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=%3Fteam_id=1')
        ->and((new GetBoardItemsRequest('a/b'))->resolveEndpoint())
        ->toBe('/v2/boards/a%2Fb/items')
        ->and((new UpdateStickyNoteRequest('a#b', '1/2', []))->resolveEndpoint())
        ->toBe('/v2/boards/a%23b/sticky_notes/1%2F2');
});
