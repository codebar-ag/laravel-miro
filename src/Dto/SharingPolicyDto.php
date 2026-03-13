<?php

namespace CodebarAg\Miro\Dto;

use Illuminate\Support\Arr;

class SharingPolicyDto
{
    public function __construct(
        public readonly string $access,
        public readonly string $inviteToAccountAndBoardLinkAccess,
        public readonly string $organizationAccess,
        public readonly string $teamAccess,
    ) {}

    public static function fromResponse(array $data): static
    {
        return new static(
            access: Arr::get($data, 'access', ''),
            inviteToAccountAndBoardLinkAccess: Arr::get($data, 'inviteToAccountAndBoardLinkAccess', ''),
            organizationAccess: Arr::get($data, 'organizationAccess', ''),
            teamAccess: Arr::get($data, 'teamAccess', ''),
        );
    }
}
