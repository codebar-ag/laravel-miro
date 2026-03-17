<?php

namespace CodebarAg\Miro\Dto\Boards;

class GetBoardsDto
{
    public function __construct(
        public readonly ?string $teamId = null,
        public readonly ?string $projectId = null,
        public readonly ?string $query = null,
        public readonly ?string $owner = null,
        public readonly ?int $limit = null,
        public readonly ?int $offset = null,
        public readonly ?string $sort = null,
    ) {}

    /** @return array<string, string|int> */
    public function toArray(): array
    {
        return array_filter([
            'team_id' => $this->teamId,
            'project_id' => $this->projectId,
            'query' => $this->query,
            'owner' => $this->owner,
            'limit' => $this->limit,
            'offset' => $this->offset,
            'sort' => $this->sort,
        ], fn ($v) => $v !== null);
    }
}
