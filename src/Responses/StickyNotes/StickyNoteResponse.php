<?php

declare(strict_types=1);

namespace CodebarAg\Miro\Responses\StickyNotes;

use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\Responses\MiroResponse;
use Saloon\Http\Response;

final class StickyNoteResponse extends MiroResponse
{
    /** @var StickyNoteDto|StickyNoteDto[]|null */
    private StickyNoteDto|array|null $dto = null;

    private function __construct(Response $response)
    {
        parent::__construct($response);
    }

    public static function fromResponse(Response $response): self
    {
        $instance = new self($response);

        if ($response->successful()) {
            $instance->dto = StickyNoteDto::fromResponse((array) $response->json());
        }

        return $instance;
    }

    public static function collectionFromResponse(Response $response): self
    {
        $instance = new self($response);

        if ($response->successful()) {
            /** @var array<int, array<string, mixed>> $data */
            $data = is_array($r = $response->json('data')) ? $r : [];
            $instance->dto = array_map(fn (array $note) => StickyNoteDto::fromResponse($note), $data);
        }

        return $instance;
    }

    /** @return StickyNoteDto|StickyNoteDto[]|null */
    public function dto(): StickyNoteDto|array|null
    {
        return $this->dto;
    }
}
