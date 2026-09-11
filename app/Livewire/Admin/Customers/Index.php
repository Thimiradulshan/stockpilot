<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $status = '';

    /**
     * Authorize access to the page.
     */
    public function mount(): void
    {
        $this->authorize('viewAny', Customer::class);
    }

    /**
     * Reset pagination when search changes.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when status changes.
     */
    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Clear all filters.
     */
    public function clearFilters(): void
    {
        $this->reset([
            'search',
            'status',
        ]);

        $this->resetPage();
    }

    /**
     * Determine whether filters are active.
     */
    public function hasActiveFilters(): bool
    {
        return $this->search !== '' || $this->status !== '';
    }

    /**
     * Render the customer management page.
     */
    public function render(): View
    {
        $customers = Customer::query()
            ->withCount('invoices')
            ->when($this->search !== '', function ($query): void {
                $search = trim($this->search);

                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($this->status !== '', function ($query): void {
                $query->where('status', $this->status);
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.customers.index', [
            'customers' => $customers,
            'totalCustomers' => Customer::query()->count(),
            'activeCustomers' => Customer::query()
                ->where('status', 'active')
                ->count(),
            'inactiveCustomers' => Customer::query()
                ->where('status', 'inactive')
                ->count(),
        ])->layout('layouts.app', [
            'title' => 'Customers',
        ]);
    }
}
