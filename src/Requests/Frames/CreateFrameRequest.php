<?php

namespace CodebarAg\Miro\Requests\Frames;

use CodebarAg\Miro\Dto\Frames\FrameDto;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateFrameRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /** @param array<string, mixed> $data */
    public function __construct(
        protected string $boardId,
        protected array $data
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/frames";
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data;
    }

    public function createDtoFromResponse(Response $response): FrameDto
    {
        return FrameDto::fromResponse((array) $response->json());
    }
}
