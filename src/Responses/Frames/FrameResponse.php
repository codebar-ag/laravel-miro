<?php

declare(strict_types=1);

namespace CodebarAg\Miro\Responses\Frames;

use CodebarAg\Miro\Dto\Frames\FrameDto;
use CodebarAg\Miro\Responses\MiroResponse;
use Saloon\Http\Response;

final class FrameResponse extends MiroResponse
{
    /** @var FrameDto|FrameDto[]|null */
    private FrameDto|array|null $dto = null;

    private function __construct(Response $response)
    {
        parent::__construct($response);
    }

    public static function fromResponse(Response $response): self
    {
        $instance = new self($response);

        if ($response->successful()) {
            $instance->dto = FrameDto::fromResponse((array) $response->json());
        }

        return $instance;
    }

    public static function collectionFromResponse(Response $response): self
    {
        $instance = new self($response);

        if ($response->successful()) {
            /** @var array<int, array<string, mixed>> $data */
            $data = is_array($r = $response->json('data')) ? $r : [];
            $instance->dto = array_map(fn (array $frame) => FrameDto::fromResponse($frame), $data);
        }

        return $instance;
    }

    /** @return FrameDto|FrameDto[]|null */
    public function dto(): FrameDto|array|null
    {
        return $this->dto;
    }
}
