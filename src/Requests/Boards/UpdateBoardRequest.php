<?php

namespace CodebarAg\Miro\Requests\Boards;

use CodebarAg\Miro\Support\PathSegment;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateBoardRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /** @param array<string, mixed> $data */
    public function __construct(
        protected string $boardId,
        protected array $data
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/boards/'.PathSegment::encode($this->boardId);
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
