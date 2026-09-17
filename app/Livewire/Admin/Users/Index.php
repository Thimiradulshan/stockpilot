<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $status = '';

    #[Url(history: true)]
    public string $role = '';

    /**
     * Authorize access to user management.
     */
    public function mount(): void
    {
        $this->authorize('viewAny', User::class);
    }

    /**
     * Reset pagination when the search changes.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when the status filter changes.
     */
    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when the role filter changes.
     */
    public function updatingRole(): void
    {
        $this->resetPage();
    }

    /**
     * Clear all user filters.
     */
    public function clearFilters(): void
    {
        $this->search = '';
        $this->status = '';
        $this->role = '';

        $this->resetPage();
    }

    /**
     * Determine whether any filters are active.
     */
    public function hasActiveFilters(): bool
    {
        return trim($this->search) !== ''
            || $this->status !== ''
            || $this->role !== '';
    }

    /**
     * Render the user management page.
     */
    public function render(): View
    {
        $search = trim($this->search);

        $users = User::query()
            ->when(
                $search !== '',
                function ($query) use ($search): void {
                    $query->where(function ($userQuery) use ($search): void {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                },
            )
            ->when(
                $this->status !== '',
                fn ($query) => $query->where('status', $this->status),
            )
            ->when(
                $this->role !== '',
                fn ($query) => $query->where('role', $this->role),
            )
            ->orderBy('name')
            ->paginate(10);

        $totalUsers = User::query()->count();

        $activeUsers = User::query()
            ->where('status', 'active')
            ->count();

        $inactiveUsers = User::query()
            ->where('status', 'inactive')
            ->count();

        $currentUserId = auth()->id();

        return view(
            'livewire.admin.users.index',
            compact(
                'users',
                'totalUsers',
                'activeUsers',
                'inactiveUsers',
                'currentUserId',
            ),
        )->layout(
            'layouts.app',
            [
                'title' => 'Users',
            ],
        );
    }
}
