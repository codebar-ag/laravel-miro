<?php

declare(strict_types=1);

namespace CodebarAg\Miro\Responses\Boards;

use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\Responses\MiroResponse;
use Saloon\Http\Response;

final class BoardResponse extends MiroResponse
{
    /** @var BoardDto|BoardDto[]|null */
    private BoardDto|array|null $dto = null;

    private function __construct(Response $response)
    {
        parent::__construct($response);
    }

    public static function fromResponse(Response $response): self
    {
        $instance = new self($response);

        if ($response->successful()) {
            $instance->dto = BoardDto::fromResponse((array) $response->json());
        }

        return $instance;
    }

    public static function collectionFromResponse(Response $response): self
    {
        $instance = new self($response);

        if ($response->successful()) {
            /** @var array<int, array<string, mixed>> $data */
            $data = is_array($r = $response->json('data')) ? $r : [];
            $instance->dto = array_map(fn (array $board) => BoardDto::fromResponse($board), $data);
        }

        return $instance;
    }

    /** @return BoardDto|BoardDto[]|null */
    public function dto(): BoardDto|array|null
    {
        return $this->dto;
    }
}
