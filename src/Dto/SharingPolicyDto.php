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

    /** @param array<string, mixed> $data */
    public static function fromResponse(array $data): self
    {
        return new self(
            access: is_string($v = Arr::get($data, 'access', '')) ? $v : '',
            inviteToAccountAndBoardLinkAccess: is_string($v = Arr::get($data, 'inviteToAccountAndBoardLinkAccess', '')) ? $v : '',
            organizationAccess: is_string($v = Arr::get($data, 'organizationAccess', '')) ? $v : '',
            teamAccess: is_string($v = Arr::get($data, 'teamAccess', '')) ? $v : '',
        );
    }
}
