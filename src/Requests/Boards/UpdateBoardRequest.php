<?php

namespace CodebarAg\Miro\Requests\Boards;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateBoardRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $boardId,
        protected array $data
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}";
    }

    protected function defaultBody(): array
    {
        return $this->data;
    }
}
