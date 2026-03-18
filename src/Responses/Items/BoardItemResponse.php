<?php

declare(strict_types=1);

namespace CodebarAg\Miro\Responses\Items;

use CodebarAg\Miro\Dto\BoardItems\BoardItemDto;
use CodebarAg\Miro\Responses\MiroResponse;
use Saloon\Http\Response;

final class BoardItemResponse extends MiroResponse
{
    /** @var BoardItemDto|BoardItemDto[]|null */
    private BoardItemDto|array|null $dto = null;

    private function __construct(Response $response)
    {
        parent::__construct($response);
    }

    public static function fromResponse(Response $response): self
    {
        $instance = new self($response);

        if ($response->successful()) {
            $instance->dto = BoardItemDto::fromResponse((array) $response->json());
        }

        return $instance;
    }

    public static function collectionFromResponse(Response $response): self
    {
        $instance = new self($response);

        if ($response->successful()) {
            /** @var array<int, array<string, mixed>> $data */
            $data = is_array($r = $response->json('data')) ? $r : [];
            $instance->dto = array_map(fn (array $item) => BoardItemDto::fromResponse($item), $data);
        }

        return $instance;
    }

    /** @return BoardItemDto|BoardItemDto[]|null */
    public function dto(): BoardItemDto|array|null
    {
        return $this->dto;
    }
}
