<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRequest;
use App\Models\Request as RequestRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function __construct()
    {
        // This pulls in the `middleware()` helper from the base Controller
        $this->middleware('auth');
    }

    /** List: all if admin, else own requests */
    public function index(): View
    {
        $query = Auth::user()->hasRole('administrator')
            ? RequestRecord::query()
            : RequestRecord::mine();

        return view('requests.index', [
            'requests' => $query->latest()->paginate(10),
        ]);
    }

    /** Show a single request */
    public function show(RequestRecord $request): View
    {
        $this->authorizeAccess($request);
        return view('requests.show', compact('request'));
    }

    /** Form to create */
    public function create(): View
    {
        return view('requests.create');
    }

    /** Persist new request */
    public function store(StoreRequestRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['requested_by'] = Auth::id();
        RequestRecord::create($data);

        return redirect()->route('requests.index')
            ->with('success', 'Request submitted!');
    }

    /** Form to edit */
    public function edit(RequestRecord $request): View
    {
        $this->authorizeAccess($request);
        return view('requests.edit', compact('request'));
    }

    /** Persist updates */
    public function update(StoreRequestRequest $req, RequestRecord $request): RedirectResponse
    {
        $this->authorizeAccess($request);
        $request->update($req->validated());

        return redirect()->route('requests.show', $request)
            ->with('success', 'Request updated.');
    }

    /** Only admins or the original requester may view/edit */
    private function authorizeAccess(RequestRecord $request): void
    {
        if (
            ! Auth::user()->hasRole('administrator')
            && $request->requested_by !== Auth::id()
        ) {
            abort(403);
        }
    }
}
