<?php

namespace CodebarAg\Miro\Facades;

use CodebarAg\Miro\MiroConnector;
use Illuminate\Support\Facades\Facade;

/**
 * @see MiroConnector
 *
 * @method static \CodebarAg\Miro\Dto\Boards\BoardDto[] getBoards(array<string, mixed> $params = [])
 * @method static \CodebarAg\Miro\Dto\Boards\BoardDto getBoard(string $boardId)
 * @method static \CodebarAg\Miro\Dto\Boards\BoardDto createBoard(array<string, mixed> $data)
 * @method static \CodebarAg\Miro\Dto\Boards\BoardDto updateBoard(string $boardId, array<string, mixed> $data)
 * @method static \Saloon\Http\Response deleteBoard(string $boardId)
 * @method static \CodebarAg\Miro\Dto\BoardItems\BoardItemDto[] getBoardItems(string $boardId, array<string, mixed> $params = [])
 * @method static \CodebarAg\Miro\Dto\BoardItems\BoardItemDto getBoardItem(string $boardId, string $itemId)
 */
class Miro extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MiroConnector::class;
    }
}
