<?php

namespace CodebarAg\Miro;

use CodebarAg\Miro\Dto\BoardDto;
use CodebarAg\Miro\Dto\BoardItemDto;
use CodebarAg\Miro\Dto\CreateBoardDto;
use CodebarAg\Miro\Dto\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\GetBoardItemsDto;
use CodebarAg\Miro\Dto\GetBoardsDto;
use CodebarAg\Miro\Dto\GetStickyNotesDto;
use CodebarAg\Miro\Dto\StickyNoteDto;
use CodebarAg\Miro\Dto\UpdateBoardDto;
use CodebarAg\Miro\Dto\UpdateStickyNoteDto;
use CodebarAg\Miro\Requests\Boards\CreateBoardRequest;
use CodebarAg\Miro\Requests\Boards\DeleteBoardRequest;
use CodebarAg\Miro\Requests\Boards\GetBoardRequest;
use CodebarAg\Miro\Requests\Boards\GetBoardsRequest;
use CodebarAg\Miro\Requests\Boards\UpdateBoardRequest;
use CodebarAg\Miro\Requests\Items\GetBoardItemsRequest;
use CodebarAg\Miro\Requests\StickyNotes\CreateStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\DeleteStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNotesRequest;
use CodebarAg\Miro\Requests\StickyNotes\UpdateStickyNoteRequest;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;

class MiroConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://api.miro.com';
    }

    /** @return array<string, string> */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        $token = config('miro.access_token');

        return new TokenAuthenticator(is_string($token) ? $token : '');
    }

    /** @return BoardDto[] */
    public function getBoards(?GetBoardsDto $params = null): array
    {
        /** @var BoardDto[] */
        return $this->send(new GetBoardsRequest($params?->toArray() ?? []))->dto();
    }

    public function getBoard(string $boardId): BoardDto
    {
        /** @var BoardDto */
        return $this->send(new GetBoardRequest($boardId))->dto();
    }

    public function createBoard(CreateBoardDto $data): BoardDto
    {
        /** @var BoardDto */
        return $this->send(new CreateBoardRequest($data->toArray()))->dto();
    }

    public function updateBoard(string $boardId, UpdateBoardDto $data): BoardDto
    {
        /** @var BoardDto */
        return $this->send(new UpdateBoardRequest($boardId, $data->toArray()))->dto();
    }

    public function deleteBoard(string $boardId): Response
    {
        return $this->send(new DeleteBoardRequest($boardId));
    }

    /** @return BoardItemDto[] */
    public function getBoardItems(string $boardId, ?GetBoardItemsDto $params = null): array
    {
        /** @var BoardItemDto[] */
        return $this->send(new GetBoardItemsRequest($boardId, $params?->toArray() ?? []))->dto();
    }

    /** @return StickyNoteDto[] */
    public function getStickyNotes(string $boardId, ?GetStickyNotesDto $params = null): array
    {
        /** @var StickyNoteDto[] */
        return $this->send(new GetStickyNotesRequest($boardId, $params?->toArray() ?? []))->dto();
    }

    public function getStickyNote(string $boardId, string $itemId): StickyNoteDto
    {
        /** @var StickyNoteDto */
        return $this->send(new GetStickyNoteRequest($boardId, $itemId))->dto();
    }

    public function createStickyNote(string $boardId, CreateStickyNoteDto $data): StickyNoteDto
    {
        /** @var StickyNoteDto */
        return $this->send(new CreateStickyNoteRequest($boardId, $data->toArray()))->dto();
    }

    public function updateStickyNote(string $boardId, string $itemId, UpdateStickyNoteDto $data): StickyNoteDto
    {
        /** @var StickyNoteDto */
        return $this->send(new UpdateStickyNoteRequest($boardId, $itemId, $data->toArray()))->dto();
    }

    public function deleteStickyNote(string $boardId, string $itemId): Response
    {
        return $this->send(new DeleteStickyNoteRequest($boardId, $itemId));
    }
}
