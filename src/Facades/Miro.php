<?php

namespace CodebarAg\Miro\Facades;

use CodebarAg\Miro\MiroConnector;
use Illuminate\Support\Facades\Facade;

/**
 * @see MiroConnector
 *
 * @method static \CodebarAg\Miro\Dto\BoardDto[] getBoards(array<string, mixed> $params = [])
 * @method static \CodebarAg\Miro\Dto\BoardDto getBoard(string $boardId)
 * @method static \CodebarAg\Miro\Dto\BoardDto createBoard(array<string, mixed> $data)
 * @method static \CodebarAg\Miro\Dto\BoardDto updateBoard(string $boardId, array<string, mixed> $data)
 * @method static \Saloon\Http\Response deleteBoard(string $boardId)
 * @method static \CodebarAg\Miro\Dto\BoardItemDto[] getBoardItems(string $boardId, array<string, mixed> $params = [])
 */
class Miro extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MiroConnector::class;
    }
}
