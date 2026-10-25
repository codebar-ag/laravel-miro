<?php

namespace CodebarAg\Miro\Requests\Frames;

use CodebarAg\Miro\Support\PathSegment;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteFrameRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $boardId,
        protected string $itemId
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/boards/'.PathSegment::encode($this->boardId).'/frames/'.PathSegment::encode($this->itemId);
    }
}
