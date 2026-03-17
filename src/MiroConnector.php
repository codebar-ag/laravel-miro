<?php

namespace CodebarAg\Miro;

use CodebarAg\Miro\Dto\BoardItems\BoardItemDto;
use CodebarAg\Miro\Dto\BoardItems\GetBoardItemsDto;
use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Boards\GetBoardsDto;
use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\FrameDto;
use CodebarAg\Miro\Dto\Frames\GetFramesDto;
use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\GetStickyNotesDto;
use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto;
use CodebarAg\Miro\Requests\Boards\CreateBoardRequest;
use CodebarAg\Miro\Requests\Boards\DeleteBoardRequest;
use CodebarAg\Miro\Requests\Boards\GetBoardRequest;
use CodebarAg\Miro\Requests\Boards\GetBoardsRequest;
use CodebarAg\Miro\Requests\Boards\UpdateBoardRequest;
use CodebarAg\Miro\Requests\Frames\CreateFrameRequest;
use CodebarAg\Miro\Requests\Frames\DeleteFrameRequest;
use CodebarAg\Miro\Requests\Frames\GetFrameRequest;
use CodebarAg\Miro\Requests\Frames\GetFramesRequest;
use CodebarAg\Miro\Requests\Frames\UpdateFrameRequest;
use CodebarAg\Miro\Requests\Items\GetBoardItemRequest;
use CodebarAg\Miro\Requests\Items\GetBoardItemsRequest;
use CodebarAg\Miro\Requests\StickyNotes\CreateStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\DeleteStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNoteRequest;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNotesRequest;
use CodebarAg\Miro\Requests\StickyNotes\UpdateStickyNoteRequest;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class MiroConnector extends Connector
{
    use AlwaysThrowOnErrors;

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

    public function getBoardItem(string $boardId, string $itemId): BoardItemDto
    {
        /** @var BoardItemDto */
        return $this->send(new GetBoardItemRequest($boardId, $itemId))->dto();
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

    /** @return FrameDto[] */
    public function getFrames(string $boardId, ?GetFramesDto $params = null): array
    {
        /** @var FrameDto[] */
        return $this->send(new GetFramesRequest($boardId, $params?->toArray() ?? []))->dto();
    }

    public function getFrame(string $boardId, string $itemId): FrameDto
    {
        /** @var FrameDto */
        return $this->send(new GetFrameRequest($boardId, $itemId))->dto();
    }

    public function createFrame(string $boardId, CreateFrameDto $data): FrameDto
    {
        /** @var FrameDto */
        return $this->send(new CreateFrameRequest($boardId, $data->toArray()))->dto();
    }

    public function updateFrame(string $boardId, string $itemId, UpdateFrameDto $data): FrameDto
    {
        /** @var FrameDto */
        return $this->send(new UpdateFrameRequest($boardId, $itemId, $data->toArray()))->dto();
    }

    public function deleteFrame(string $boardId, string $itemId): Response
    {
        return $this->send(new DeleteFrameRequest($boardId, $itemId));
    }
}
