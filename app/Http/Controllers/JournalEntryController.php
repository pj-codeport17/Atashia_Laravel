<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalEntryRequest;
use App\Models\JournalEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalEntryController extends Controller
{
    public function index(Request $request): View
    {
        $entries = $this->authenticatedUser()
            ->journalEntries()
            ->search($request->get('search'))
            ->when($request->get('mood'), fn ($q, $mood) => $q->where('mood', $mood))
            ->latest('entry_date')
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        return view('journal.index', compact('entries'));
    }

    public function create(): View
    {
        return view('journal.create');
    }

    public function store(JournalEntryRequest $request): RedirectResponse
    {
        $this->authenticatedUser()->journalEntries()->create($request->validated());

        return redirect()->route('journal.index')
            ->with('toast', ['type' => 'success', 'message' => 'Journal entry created successfully.']);
    }

    public function show(JournalEntry $journal): View
    {
        $this->authorize('view', $journal);

        return view('journal.show', ['entry' => $journal]);
    }

    public function edit(JournalEntry $journal): View
    {
        $this->authorize('update', $journal);

        return view('journal.edit', ['entry' => $journal]);
    }

    public function update(JournalEntryRequest $request, JournalEntry $journal): RedirectResponse
    {
        $this->authorize('update', $journal);

        $journal->update($request->validated());

        return redirect()->route('journal.show', $journal)
            ->with('toast', ['type' => 'success', 'message' => 'Journal entry updated successfully.']);
    }

    public function destroy(JournalEntry $journal): RedirectResponse
    {
        $this->authorize('delete', $journal);

        $journal->delete();

        return redirect()->route('journal.index')
            ->with('toast', ['type' => 'success', 'message' => 'Journal entry deleted successfully.']);
    }
}
