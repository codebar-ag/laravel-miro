<?php

namespace CodebarAg\Miro\Facades;

use CodebarAg\Miro\MiroConnector;
use Illuminate\Support\Facades\Facade;

/**
 * @see MiroConnector
 *
 * @method static \CodebarAg\Miro\Responses\Boards\BoardResponse getBoards(?\CodebarAg\Miro\Dto\Boards\GetBoardsDto $params = null)
 * @method static \CodebarAg\Miro\Responses\Boards\BoardResponse getBoard(string $boardId)
 * @method static \CodebarAg\Miro\Responses\Boards\BoardResponse createBoard(\CodebarAg\Miro\Dto\Boards\CreateBoardDto $data)
 * @method static \CodebarAg\Miro\Responses\Boards\BoardResponse updateBoard(string $boardId, \CodebarAg\Miro\Dto\Boards\UpdateBoardDto $data)
 * @method static \Saloon\Http\Response deleteBoard(string $boardId)
 * @method static \CodebarAg\Miro\Responses\Items\BoardItemResponse getBoardItems(string $boardId, ?\CodebarAg\Miro\Dto\BoardItems\GetBoardItemsDto $params = null)
 * @method static \CodebarAg\Miro\Responses\Items\BoardItemResponse getBoardItem(string $boardId, string $itemId)
 * @method static \CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse getStickyNotes(string $boardId, ?\CodebarAg\Miro\Dto\StickyNotes\GetStickyNotesDto $params = null)
 * @method static \CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse getStickyNote(string $boardId, string $itemId)
 * @method static \CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse createStickyNote(string $boardId, \CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto $data)
 * @method static \CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse updateStickyNote(string $boardId, string $itemId, \CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto $data)
 * @method static \Saloon\Http\Response deleteStickyNote(string $boardId, string $itemId)
 * @method static \CodebarAg\Miro\Responses\Frames\FrameResponse getFrames(string $boardId, ?\CodebarAg\Miro\Dto\Frames\GetFramesDto $params = null)
 * @method static \CodebarAg\Miro\Responses\Frames\FrameResponse getFrame(string $boardId, string $itemId)
 * @method static \CodebarAg\Miro\Responses\Frames\FrameResponse createFrame(string $boardId, \CodebarAg\Miro\Dto\Frames\CreateFrameDto $data)
 * @method static \CodebarAg\Miro\Responses\Frames\FrameResponse updateFrame(string $boardId, string $itemId, \CodebarAg\Miro\Dto\Frames\UpdateFrameDto $data)
 * @method static \Saloon\Http\Response deleteFrame(string $boardId, string $itemId)
 */
class Miro extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MiroConnector::class;
    }
}
