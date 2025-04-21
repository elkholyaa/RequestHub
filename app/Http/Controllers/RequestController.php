<?php
/**
 * Request Management Controller
 *
 * This controller handles all request-related operations including listing, creating,
 * updating, and viewing individual requests. It enforces access controls based on user roles
 * and provides advanced filtering and sorting capabilities for request management.
 */

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRequest;
use App\Models\Request as RequestRecord;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function __construct()
    {
        // This pulls in the `middleware()` helper from the base Controller
        $this->middleware('auth');
    }

    /**
     * Display a listing of requests with filtering and sorting
     * For administrators, show all requests; for regular users, show only their own
     */
    public function index(Request $request): View
    {
        // Start with appropriate base query based on role
        $query = Auth::user()->hasRole('administrator')
            ? RequestRecord::query()
            : RequestRecord::mine();

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', $search)
                  ->orWhere('description', 'like', $search);
            });
        }

        // Apply sorting (default: latest created)
        $sortField = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        // Validate sort field to prevent SQL injection
        $allowedSortFields = ['id', 'title', 'type', 'status', 'priority', 'created_at', 'due_date'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
        }
        
        $query->orderBy($sortField, $direction);

        // Get assignee data for admin users
        $assignees = [];
        if (Auth::user()->hasRole('administrator')) {
            $assignees = User::all()->pluck('name', 'id')->toArray();
        }

        // Count request stats for filter summary - fixed the cloning issue
        $stats = [
            'total' => RequestRecord::count(),
            'pending' => RequestRecord::where('status', 'pending')->count(),
            'in_progress' => RequestRecord::where('status', 'in_progress')->count(),
            'completed' => RequestRecord::where('status', 'completed')->count(),
        ];

        // Get paginated results after all filters have been applied
        $requests = $query->paginate(10);

        return view('requests.index', [
            'requests' => $requests,
            'assignees' => $assignees,
            'stats' => $stats,
            'filters' => $request->only(['status', 'priority', 'type', 'search']),
        ]);
    }

    /**
     * Display the specified request
     */
    public function show(RequestRecord $request): View
    {
        $this->authorizeAccess($request);
        return view('requests.show', compact('request'));
    }

    /**
     * Show the form for creating a new request
     */
    public function create(): View
    {
        // Get assignee list for admin users
        $assignees = [];
        if (Auth::user()->hasRole('administrator')) {
            $assignees = User::all()->pluck('name', 'id')->toArray();
        }
        
        return view('requests.create', compact('assignees'));
    }

    /**
     * Store a newly created request
     */
    public function store(StoreRequestRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['requested_by'] = Auth::id();
        
        // Only administrators can assign requests
        if (!Auth::user()->hasRole('administrator')) {
            unset($data['assigned_to']);
        }
        
        RequestRecord::create($data);

        return redirect()->route('requests.index')
            ->with('success', 'Request submitted successfully!');
    }

    /**
     * Show the form for editing the specified request
     */
    public function edit(RequestRecord $request): View
    {
        $this->authorizeAccess($request);
        
        // Get assignee list for admin users
        $assignees = [];
        if (Auth::user()->hasRole('administrator')) {
            $assignees = User::all()->pluck('name', 'id')->toArray();
        }
        
        return view('requests.edit', compact('request', 'assignees'));
    }

    /**
     * Update the specified request
     */
    public function update(StoreRequestRequest $req, RequestRecord $request): RedirectResponse
    {
        $this->authorizeAccess($request);
        
        $data = $req->validated();
        
        // Only administrators can assign requests
        if (!Auth::user()->hasRole('administrator')) {
            unset($data['assigned_to']);
        }
        
        $request->update($data);

        return redirect()->route('requests.show', $request)
            ->with('success', 'Request updated successfully.');
    }

    /**
     * Authorization check: only admins or the original requester may view/edit
     */
    private function authorizeAccess(RequestRecord $request): void
    {
        if (
            !Auth::user()->hasRole('administrator')
            && $request->requested_by !== Auth::id()
        ) {
            abort(403, 'You are not authorized to access this request.');
        }
    }
}
