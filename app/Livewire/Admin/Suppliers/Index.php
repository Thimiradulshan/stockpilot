<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
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

    /**
     * Authorize access to supplier management.
     */
    public function mount(): void
    {
        $this->authorize('viewAny', Supplier::class);
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
     * Clear all supplier filters.
     */
    public function clearFilters(): void
    {
        $this->search = '';
        $this->status = '';

        $this->resetPage();
    }

    /**
     * Determine whether any filters are active.
     */
    public function hasActiveFilters(): bool
    {
        return trim($this->search) !== ''
            || $this->status !== '';
    }

    /**
     * Render the supplier management page.
     */
    public function render(): View
    {
        $search = trim($this->search);

        $suppliers = Supplier::query()
            ->withCount([
                'products',
                'purchases',
            ])
            ->when(
                $search !== '',
                function ($query) use ($search): void {
                    $query->where(function ($supplierQuery) use ($search): void {
                        $supplierQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('company', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('address', 'like', "%{$search}%");
                    });
                },
            )
            ->when(
                $this->status !== '',
                fn ($query) => $query->where('status', $this->status),
            )
            ->orderBy('name')
            ->paginate(10);

        $totalSuppliers = Supplier::query()->count();

        $activeSuppliers = Supplier::query()
            ->where('status', 'active')
            ->count();

        $inactiveSuppliers = Supplier::query()
            ->where('status', 'inactive')
            ->count();

        return view(
            'livewire.admin.suppliers.index',
            compact(
                'suppliers',
                'totalSuppliers',
                'activeSuppliers',
                'inactiveSuppliers',
            ),
        )->layout(
            'layouts.app',
            [
                'title' => 'Suppliers',
            ],
        );
    }
}
