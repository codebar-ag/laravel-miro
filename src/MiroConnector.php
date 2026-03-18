<?php

namespace CodebarAg\Miro;

use CodebarAg\Miro\Dto\BoardItems\GetBoardItemsDto;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Boards\GetBoardsDto;
use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\GetFramesDto;
use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\GetStickyNotesDto;
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
use CodebarAg\Miro\Responses\Boards\BoardResponse;
use CodebarAg\Miro\Responses\Frames\FrameResponse;
use CodebarAg\Miro\Responses\Items\BoardItemResponse;
use CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse;
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

    public function getBoards(?GetBoardsDto $params = null): BoardResponse
    {
        return BoardResponse::collectionFromResponse(
            $this->send(new GetBoardsRequest($params?->toArray() ?? []))
        );
    }

    public function getBoard(string $boardId): BoardResponse
    {
        return BoardResponse::fromResponse(
            $this->send(new GetBoardRequest($boardId))
        );
    }

    public function createBoard(CreateBoardDto $data): BoardResponse
    {
        return BoardResponse::fromResponse(
            $this->send(new CreateBoardRequest($data->toArray()))
        );
    }

    public function updateBoard(string $boardId, UpdateBoardDto $data): BoardResponse
    {
        return BoardResponse::fromResponse(
            $this->send(new UpdateBoardRequest($boardId, $data->toArray()))
        );
    }

    public function deleteBoard(string $boardId): Response
    {
        return $this->send(new DeleteBoardRequest($boardId));
    }

    public function getBoardItems(string $boardId, ?GetBoardItemsDto $params = null): BoardItemResponse
    {
        return BoardItemResponse::collectionFromResponse(
            $this->send(new GetBoardItemsRequest($boardId, $params?->toArray() ?? []))
        );
    }

    public function getBoardItem(string $boardId, string $itemId): BoardItemResponse
    {
        return BoardItemResponse::fromResponse(
            $this->send(new GetBoardItemRequest($boardId, $itemId))
        );
    }

    public function getStickyNotes(string $boardId, ?GetStickyNotesDto $params = null): StickyNoteResponse
    {
        return StickyNoteResponse::collectionFromResponse(
            $this->send(new GetStickyNotesRequest($boardId, $params?->toArray() ?? []))
        );
    }

    public function getStickyNote(string $boardId, string $itemId): StickyNoteResponse
    {
        return StickyNoteResponse::fromResponse(
            $this->send(new GetStickyNoteRequest($boardId, $itemId))
        );
    }

    public function createStickyNote(string $boardId, CreateStickyNoteDto $data): StickyNoteResponse
    {
        return StickyNoteResponse::fromResponse(
            $this->send(new CreateStickyNoteRequest($boardId, $data->toArray()))
        );
    }

    public function updateStickyNote(string $boardId, string $itemId, UpdateStickyNoteDto $data): StickyNoteResponse
    {
        return StickyNoteResponse::fromResponse(
            $this->send(new UpdateStickyNoteRequest($boardId, $itemId, $data->toArray()))
        );
    }

    public function deleteStickyNote(string $boardId, string $itemId): Response
    {
        return $this->send(new DeleteStickyNoteRequest($boardId, $itemId));
    }

    public function getFrames(string $boardId, ?GetFramesDto $params = null): FrameResponse
    {
        return FrameResponse::collectionFromResponse(
            $this->send(new GetFramesRequest($boardId, $params?->toArray() ?? []))
        );
    }

    public function getFrame(string $boardId, string $itemId): FrameResponse
    {
        return FrameResponse::fromResponse(
            $this->send(new GetFrameRequest($boardId, $itemId))
        );
    }

    public function createFrame(string $boardId, CreateFrameDto $data): FrameResponse
    {
        return FrameResponse::fromResponse(
            $this->send(new CreateFrameRequest($boardId, $data->toArray()))
        );
    }

    public function updateFrame(string $boardId, string $itemId, UpdateFrameDto $data): FrameResponse
    {
        return FrameResponse::fromResponse(
            $this->send(new UpdateFrameRequest($boardId, $itemId, $data->toArray()))
        );
    }

    public function deleteFrame(string $boardId, string $itemId): Response
    {
        return $this->send(new DeleteFrameRequest($boardId, $itemId));
    }
}
