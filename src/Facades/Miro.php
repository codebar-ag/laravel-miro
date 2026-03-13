<?php

namespace CodebarAg\Miro\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodebarAg\Miro\MiroConnector
 *
 * @method static \CodebarAg\Miro\Dto\BoardDto[] getBoards(array $params = [])
 * @method static \CodebarAg\Miro\Dto\BoardDto getBoard(string $boardId)
 * @method static \CodebarAg\Miro\Dto\BoardDto createBoard(array $data)
 * @method static \CodebarAg\Miro\Dto\BoardDto updateBoard(string $boardId, array $data)
 * @method static void deleteBoard(string $boardId)
 * @method static \CodebarAg\Miro\Dto\BoardItemDto[] getBoardItems(string $boardId, array $params = [])
 */
class Miro extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \CodebarAg\Miro\MiroConnector::class;
    }
}
