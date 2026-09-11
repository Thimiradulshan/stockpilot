<div
    class="sp-page min-h-[calc(100vh-4rem)] bg-sp-background"
    x-data="purchaseManager(@js($products->map(fn ($product) => [
        'id' => $product->id,
        'name' => $product->name,
        'sku' => $product->sku,
        'cost_price' => (string) $product->cost_price,
        'quantity' => (string) $product->quantity,
    ])->values()))"
    x-on:keydown.escape.window="closeModals()"
>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        @include('livewire.admin.purchases.partials.header')

        @include('livewire.admin.purchases.partials.kpis')

        @if (session('success'))
            <div class="mb-5 rounded-xl border border-sp-success/20 bg-sp-success/10 px-4 py-3 text-sm font-medium text-sp-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-sp-danger/20 bg-sp-danger/10 px-4 py-3">
                <p class="text-sm font-semibold text-sp-danger">
                    {{ __('Please correct the following errors.') }}
                </p>

                <ul class="mt-2 space-y-1 text-sm text-sp-danger/90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @include('livewire.admin.purchases.partials.filters')

        @include('livewire.admin.purchases.partials.desktop-table')

        @include('livewire.admin.purchases.partials.mobile-cards')
    </div>

    @can('create', \App\Models\Purchase::class)
        @include('livewire.admin.purchases.partials.create-modal')
    @endcan

    @include('livewire.admin.purchases.partials.details-modal')

    @include('livewire.admin.purchases.partials.cancel-modal')

    @include('livewire.admin.purchases.partials.purchase-manager-script')
</div>
