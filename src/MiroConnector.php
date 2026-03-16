<?php

namespace CodebarAg\Miro;

use CodebarAg\Miro\Dto\BoardDto;
use CodebarAg\Miro\Dto\BoardItemDto;
use CodebarAg\Miro\Dto\StickyNoteDto;
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

    /**
     * Get a list of boards.
     *
     * @param  array{team_id?: string, project_id?: string, query?: string, owner?: string, limit?: int, offset?: int, sort?: string}  $params
     * @return BoardDto[]
     */
    public function getBoards(array $params = []): array
    {
        $response = $this->send(new GetBoardsRequest($params));

        /** @var array<int, array<string, mixed>> $data */
        $data = is_array($r = $response->json('data')) ? $r : [];

        return array_map(fn (array $board) => BoardDto::fromResponse($board), $data);
    }

    /**
     * Get a specific board by ID.
     */
    public function getBoard(string $boardId): BoardDto
    {
        $response = $this->send(new GetBoardRequest($boardId));

        return BoardDto::fromResponse((array) $response->json());
    }

    /**
     * Create a new board.
     *
     * @param  array{name?: string, description?: string, teamId?: string, sharingPolicy?: array<string, mixed>}  $data
     */
    public function createBoard(array $data): BoardDto
    {
        $response = $this->send(new CreateBoardRequest($data));

        return BoardDto::fromResponse((array) $response->json());
    }

    /**
     * Update an existing board.
     *
     * @param  array{name?: string, description?: string, sharingPolicy?: array<string, mixed>}  $data
     */
    public function updateBoard(string $boardId, array $data): BoardDto
    {
        $response = $this->send(new UpdateBoardRequest($boardId, $data));

        return BoardDto::fromResponse((array) $response->json());
    }

    /**
     * Delete a board.
     */
    public function deleteBoard(string $boardId): Response
    {
        return $this->send(new DeleteBoardRequest($boardId));
    }

    /**
     * Get all sticky notes on a board.
     *
     * @param  array{limit?: int, cursor?: string}  $params
     * @return StickyNoteDto[]
     */
    public function getStickyNotes(string $boardId, array $params = []): array
    {
        $response = $this->send(new GetStickyNotesRequest($boardId, $params));

        /** @var array<int, array<string, mixed>> $data */
        $data = is_array($r = $response->json('data')) ? $r : [];

        return array_map(fn (array $item) => StickyNoteDto::fromResponse($item), $data);
    }

    /**
     * Get a specific sticky note by ID.
     */
    public function getStickyNote(string $boardId, string $itemId): StickyNoteDto
    {
        $response = $this->send(new GetStickyNoteRequest($boardId, $itemId));

        return StickyNoteDto::fromResponse((array) $response->json());
    }

    /**
     * Create a sticky note on a board.
     *
     * @param  array{data?: array{content?: string, shape?: string}, style?: array{fillColor?: string, textAlign?: string, textAlignVertical?: string}, position?: array{x?: float, y?: float, origin?: string, relativeTo?: string}, geometry?: array{width?: float}, parent?: array{id?: string}}  $data
     */
    public function createStickyNote(string $boardId, array $data): StickyNoteDto
    {
        $response = $this->send(new CreateStickyNoteRequest($boardId, $data));

        return StickyNoteDto::fromResponse((array) $response->json());
    }

    /**
     * Update a sticky note on a board.
     *
     * @param  array{data?: array{content?: string, shape?: string}, style?: array{fillColor?: string, textAlign?: string, textAlignVertical?: string}, position?: array{x?: float, y?: float, origin?: string, relativeTo?: string}, geometry?: array{width?: float}, parent?: array{id?: string}}  $data
     */
    public function updateStickyNote(string $boardId, string $itemId, array $data): StickyNoteDto
    {
        $response = $this->send(new UpdateStickyNoteRequest($boardId, $itemId, $data));

        return StickyNoteDto::fromResponse((array) $response->json());
    }

    /**
     * Delete a sticky note from a board.
     */
    public function deleteStickyNote(string $boardId, string $itemId): Response
    {
        return $this->send(new DeleteStickyNoteRequest($boardId, $itemId));
    }

    /**
     * Get items on a board.
     *
     * @param  array{limit?: int, cursor?: string, type?: string}  $params
     * @return BoardItemDto[]
     */
    public function getBoardItems(string $boardId, array $params = []): array
    {
        $response = $this->send(new GetBoardItemsRequest($boardId, $params));

        /** @var array<int, array<string, mixed>> $data */
        $data = is_array($r = $response->json('data')) ? $r : [];

        return array_map(fn (array $item) => BoardItemDto::fromResponse($item), $data);
    }
}
