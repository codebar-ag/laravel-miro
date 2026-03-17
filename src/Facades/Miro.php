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
 * @method static \CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto[] getStickyNotes(string $boardId, ?\CodebarAg\Miro\Dto\StickyNotes\GetStickyNotesDto $params = null)
 * @method static \CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto getStickyNote(string $boardId, string $itemId)
 * @method static \CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto createStickyNote(string $boardId, \CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto $data)
 * @method static \CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto updateStickyNote(string $boardId, string $itemId, \CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto $data)
 * @method static \Saloon\Http\Response deleteStickyNote(string $boardId, string $itemId)
 * @method static \CodebarAg\Miro\Dto\Frames\FrameDto[] getFrames(string $boardId, ?\CodebarAg\Miro\Dto\Frames\GetFramesDto $params = null)
 * @method static \CodebarAg\Miro\Dto\Frames\FrameDto getFrame(string $boardId, string $itemId)
 * @method static \CodebarAg\Miro\Dto\Frames\FrameDto createFrame(string $boardId, \CodebarAg\Miro\Dto\Frames\CreateFrameDto $data)
 * @method static \CodebarAg\Miro\Dto\Frames\FrameDto updateFrame(string $boardId, string $itemId, \CodebarAg\Miro\Dto\Frames\UpdateFrameDto $data)
 * @method static \Saloon\Http\Response deleteFrame(string $boardId, string $itemId)
 */
class Miro extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MiroConnector::class;
    }
}
