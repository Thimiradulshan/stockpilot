<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Product;
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
    public string $category = '';

    #[Url(history: true)]
    public string $status = 'active';

    public function mount(): void
    {
        $this->authorize('viewAny', Product::class);
    }

    /**
     * Reset pagination when the search term changes.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when the category changes.
     */
    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when the status changes.
     */
    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Reset all product filters.
     */
    public function clearFilters(): void
    {
        $this->search = '';
        $this->category = '';
        $this->status = 'active';

        $this->resetPage();
    }

    /**
     * Determine whether any optional filter is active.
     */
    public function hasActiveFilters(): bool
    {
        return $this->search !== ''
            || $this->category !== ''
            || $this->status !== 'active';
    }

    /**
     * Render the product management screen.
     */
    public function render(): View
    {
        $products = Product::query()
            ->with('category')
            ->when(
                $this->search !== '',
                function ($query): void {
                    $search = trim($this->search);

                    $query->where(function ($productQuery) use ($search): void {
                        $productQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('sku', 'like', "%{$search}%");
                    });
                }
            )
            ->when(
                $this->category !== '',
                fn ($query) => $query->where(
                    'category_id',
                    (int) $this->category
                )
            )
            ->when(
                $this->status !== '',
                fn ($query) => $query->where(
                    'status',
                    $this->status
                )
            )
            ->orderBy('name')
            ->paginate(10);

        $categories = Category::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);

        $totalProducts = Product::query()->count();

        $activeProducts = Product::query()
            ->where('status', 'active')
            ->count();

        $lowStockProducts = Product::query()
            ->where('status', 'active')
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->where('quantity', '>', 0)
            ->count();

        $outOfStockProducts = Product::query()
            ->where('status', 'active')
            ->where('quantity', '<=', 0)
            ->count();

        return view('livewire.admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts,
            'lowStockProducts' => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
        ])->layout('layouts.app', [
            'title' => 'Products',
        ]);
    }
}
