<div
    x-cloak
    x-show="createProductOpen"
    x-transition.opacity
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="create-product-title"
    role="dialog"
    aria-modal="true"
>
    <div
        class="flex min-h-full items-end justify-center bg-slate-950/50 px-4 py-6 sm:items-center sm:p-6"
        x-on:click.self="closeCreateProduct()"
    >
        <div
            x-show="createProductOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="translate-y-3 opacity-0 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave-end="translate-y-3 opacity-0 sm:translate-y-0 sm:scale-95"
            class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <div class="flex items-start justify-between gap-4 border-b border-sp-border px-5 py-4 sm:px-6">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-sp-primary">
                        <x-stockpilot.icon
                            name="products"
                            class="h-4 w-4"
                        />

                        <span>{{ __('Product catalog') }}</span>
                    </div>

                    <h2
                        id="create-product-title"
                        class="mt-1 text-xl font-bold tracking-tight text-sp-text"
                    >
                        {{ __('Add product') }}
                    </h2>

                    <p class="mt-1 text-sm leading-5 text-sp-text-muted">
                        {{ __('Create a product before recording your first purchase.') }}
                    </p>
                </div>

                <button
                    type="button"
                    class="rounded-lg p-2 text-sp-text-muted transition hover:bg-sp-surface hover:text-sp-text focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                    x-on:click="closeCreateProduct()"
                    aria-label="{{ __('Close add product dialog') }}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="h-5 w-5"
                        aria-hidden="true"
                    >
                        <path d="M6 6l12 12"/>
                        <path d="M18 6 6 18"/>
                    </svg>
                </button>
            </div>

            @if ($errors->any())
                <div class="border-b border-rose-200 bg-rose-50 px-5 py-4 sm:px-6">
                    <div class="flex gap-3">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="mt-0.5 h-5 w-5 shrink-0 text-rose-600"
                            aria-hidden="true"
                        >
                            <circle cx="12" cy="12" r="9"/>
                            <path d="m9 9 6 6"/>
                            <path d="m15 9-6 6"/>
                        </svg>

                        <div>
                            <p class="text-sm font-semibold text-rose-900">
                                {{ __('Please correct the following errors.') }}
                            </p>

                            <ul class="mt-1 space-y-1 text-sm text-rose-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('admin.products.store') }}"
            >
                @csrf

                <div class="max-h-[calc(100vh-12rem)] overflow-y-auto">
                    <div class="space-y-5 px-5 py-5 sm:px-6">
                        <section class="rounded-2xl border border-sp-border bg-sp-surface p-4 sm:p-5">
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-sp-text">
                                    {{ __('Product information') }}
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-sp-text-muted">
                                    {{ __('Enter the product details used throughout inventory and sales operations.') }}
                                </p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label
                                        for="create_product_name"
                                        class="mb-1.5 block text-xs font-medium text-sp-text-muted"
                                    >
                                        {{ __('Product name') }}
                                    </label>

                                    <input
                                        id="create_product_name"
                                        name="name"
                                        type="text"
                                        value="{{ old('name') }}"
                                        maxlength="200"
                                        required
                                        autocomplete="off"
                                        placeholder="e.g. Coca-Cola 500ml"
                                        class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm text-sp-text outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="create_product_sku"
                                        class="mb-1.5 block text-xs font-medium text-sp-text-muted"
                                    >
                                        {{ __('SKU') }}
                                    </label>

                                    <input
                                        id="create_product_sku"
                                        name="sku"
                                        type="text"
                                        value="{{ old('sku') }}"
                                        maxlength="100"
                                        required
                                        autocomplete="off"
                                        placeholder="e.g. COKE-500"
                                        class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm uppercase text-sp-text outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                    >
                                </div>

                                <div>
                                    <label
                                        for="create_product_category"
                                        class="mb-1.5 block text-xs font-medium text-sp-text-muted"
                                    >
                                        {{ __('Category') }}
                                    </label>

                                    <select
                                        id="create_product_category"
                                        name="category_id"
                                        required
                                        class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm text-sp-text outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                    >
                                        <option value="">
                                            {{ __('Select category') }}
                                        </option>

                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @selected((string) old('category_id') === (string) $category->id)
                                            >
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($categories->isEmpty())
                                        <p class="mt-2 text-xs font-medium text-amber-700">
                                            {{ __('No active categories are available. Create an active category first.') }}
                                        </p>
                                    @endif
                                </div>

                                <div>
                                    <label
                                        for="create_product_cost_price"
                                        class="mb-1.5 block text-xs font-medium text-sp-text-muted"
                                    >
                                        {{ __('Cost price') }}
                                    </label>

                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5 text-xs font-semibold text-sp-text-muted">
                                            Rs.
                                        </span>

                                        <input
                                            id="create_product_cost_price"
                                            name="cost_price"
                                            type="number"
                                            value="{{ old('cost_price') }}"
                                            min="0"
                                            step="0.01"
                                            required
                                            inputmode="decimal"
                                            placeholder="0.00"
                                            class="block w-full rounded-xl border border-sp-border bg-white py-2.5 pe-3.5 ps-11 text-sm tabular-nums text-sp-text outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label
                                        for="create_product_selling_price"
                                        class="mb-1.5 block text-xs font-medium text-sp-text-muted"
                                    >
                                        {{ __('Selling price') }}
                                    </label>

                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5 text-xs font-semibold text-sp-text-muted">
                                            Rs.
                                        </span>

                                        <input
                                            id="create_product_selling_price"
                                            name="selling_price"
                                            type="number"
                                            value="{{ old('selling_price') }}"
                                            min="0"
                                            step="0.01"
                                            required
                                            inputmode="decimal"
                                            placeholder="0.00"
                                            class="block w-full rounded-xl border border-sp-border bg-white py-2.5 pe-3.5 ps-11 text-sm tabular-nums text-sp-text outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label
                                        for="create_product_reorder_level"
                                        class="mb-1.5 block text-xs font-medium text-sp-text-muted"
                                    >
                                        {{ __('Reorder level') }}
                                    </label>

                                    <input
                                        id="create_product_reorder_level"
                                        name="reorder_level"
                                        type="number"
                                        value="{{ old('reorder_level', '0') }}"
                                        min="0"
                                        step="0.001"
                                        required
                                        inputmode="decimal"
                                        placeholder="0.000"
                                        class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm tabular-nums text-sp-text outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                    >
                                </div>

                                <div class="sm:col-span-2">
                                    <label
                                        for="create_product_description"
                                        class="mb-1.5 block text-xs font-medium text-sp-text-muted"
                                    >
                                        {{ __('Description') }}
                                    </label>

                                    <textarea
                                        id="create_product_description"
                                        name="description"
                                        rows="4"
                                        placeholder="Optional product description..."
                                        class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm leading-6 text-sp-text outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                    >{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-2xl border border-sp-info/20 bg-sp-info/[0.045] p-4 sm:p-5">
                            <div class="flex gap-3">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="mt-0.5 h-5 w-5 shrink-0 text-sp-info"
                                    aria-hidden="true"
                                >
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 8v4"/>
                                    <path d="M12 16h.01"/>
                                </svg>

                                <div class="text-sm leading-6 text-sp-text-muted">
                                    <p class="font-semibold text-sp-text">
                                        {{ __('Initial stock') }}
                                    </p>

                                    <p class="mt-1">
                                        {{ __('New products start with zero stock. Use a purchase or stock adjustment to add inventory.') }}
                                    </p>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-sp-border bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-end sm:px-6">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border border-sp-border bg-white px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                        x-on:click="closeCreateProduct()"
                    >
                        {{ __('Cancel') }}
                    </button>

                    <button
                        type="submit"
                        @disabled($categories->isEmpty())
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-sp-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-sp-primary/90 focus:outline-none focus:ring-2 focus:ring-sp-primary/30 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-4 w-4"
                            aria-hidden="true"
                        >
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>

                        {{ __('Save product') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
