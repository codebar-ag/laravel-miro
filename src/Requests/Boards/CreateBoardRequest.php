<?php

namespace CodebarAg\Miro\Requests\Boards;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateBoardRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /** @param array<string, mixed> $data */
    public function __construct(protected array $data) {}

    public function resolveEndpoint(): string
    {
        return '/v2/boards';
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
