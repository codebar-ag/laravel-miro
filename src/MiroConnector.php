<?php

namespace CodebarAg\Miro;

use CodebarAg\Miro\Dto\BoardDto;
use CodebarAg\Miro\Dto\BoardItemDto;
use CodebarAg\Miro\Requests\Boards\CreateBoardRequest;
use CodebarAg\Miro\Requests\Boards\DeleteBoardRequest;
use CodebarAg\Miro\Requests\Boards\GetBoardRequest;
use CodebarAg\Miro\Requests\Boards\GetBoardsRequest;
use CodebarAg\Miro\Requests\Boards\UpdateBoardRequest;
use CodebarAg\Miro\Requests\Items\GetBoardItemsRequest;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;

class MiroConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://api.miro.com';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator(config('miro.access_token'));
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

        return array_map(
            fn (array $board) => BoardDto::fromResponse($board),
            $response->json('data') ?? []
        );
    }

    /**
     * Get a specific board by ID.
     */
    public function getBoard(string $boardId): BoardDto
    {
        $response = $this->send(new GetBoardRequest($boardId));

        return BoardDto::fromResponse($response->json());
    }

    /**
     * Create a new board.
     *
     * @param  array{name?: string, description?: string, teamId?: string, sharingPolicy?: array}  $data
     */
    public function createBoard(array $data): BoardDto
    {
        $response = $this->send(new CreateBoardRequest($data));

        return BoardDto::fromResponse($response->json());
    }

    /**
     * Update an existing board.
     *
     * @param  array{name?: string, description?: string, sharingPolicy?: array}  $data
     */
    public function updateBoard(string $boardId, array $data): BoardDto
    {
        $response = $this->send(new UpdateBoardRequest($boardId, $data));

        return BoardDto::fromResponse($response->json());
    }

    /**
     * Delete a board.
     */
    public function deleteBoard(string $boardId): Response
    {
        return $this->send(new DeleteBoardRequest($boardId));
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

        return array_map(
            fn (array $item) => BoardItemDto::fromResponse($item),
            $response->json('data') ?? []
        );
    }
}
