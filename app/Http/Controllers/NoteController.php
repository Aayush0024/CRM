<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content'      => 'required|string',
            'notable_type' => 'required|string',
            'notable_id'   => 'required|integer',
        ]);

        Note::create([
            'content'      => $request->content,
            'notable_type' => $request->notable_type,
            'notable_id'   => $request->notable_id,
            'created_by'   => Auth::id(),
        ]);

        return back()->with('success', __('messages.note_added'));
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();
        return back()->with('success', __('messages.note_deleted'));
    }

    public function togglePin(Note $note)
    {
        // Only the note owner or admin can pin/unpin
        if (Auth::id() !== $note->created_by && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $note->update(['is_pinned' => !$note->is_pinned]);
        return back();
    }
}
