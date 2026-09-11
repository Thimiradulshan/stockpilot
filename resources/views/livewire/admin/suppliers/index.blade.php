<div
    class="sp-page min-h-[calc(100vh-4rem)] bg-sp-background"
    x-data="{
        createOpen: false,
        editOpen: false,
        editingSupplier: null,

        openCreate() {
            this.editOpen = false;
            this.editingSupplier = null;
            this.createOpen = true;
        },

        openEdit(supplier) {
            this.createOpen = false;
            this.editingSupplier = supplier;
            this.editOpen = true;
        },

        closeModals() {
            this.createOpen = false;
            this.editOpen = false;
            this.editingSupplier = null;
        }
    }"
    x-on:keydown.escape.window="closeModals()"
>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-sp-primary">
                    <x-stockpilot.icon name="suppliers" class="h-4 w-4" />
                    {{ __('Master data') }}
                </div>

                <h1 class="mt-1 text-2xl font-bold tracking-tight text-sp-brand-dark dark:text-white">
                    {{ __('Suppliers') }}
                </h1>

                <p class="mt-1 text-sm text-sp-text-muted">
                    {{ __('Manage supplier contacts and purchasing relationships.') }}
                </p>
            </div>

            @can('create', \App\Models\Supplier::class)
                <button
                    type="button"
                    x-on:click="openCreate()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-sp-primary px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sp-brand-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-primary/40"
                >
                    <x-stockpilot.icon name="plus" class="h-4 w-4" />
                    {{ __('Add supplier') }}
                </button>
            @endcan
        </div>

        <div class="mb-6">
            <x-stockpilot.tabs
                :items="[
                    [
                        'label' => 'Products',
                        'route' => route('admin.products.index'),
                        'active' => request()->routeIs('admin.products.*'),
                    ],
                    [
                        'label' => 'Categories',
                        'route' => route('admin.categories.index'),
                        'active' => request()->routeIs('admin.categories.*'),
                    ],
                    [
                        'label' => 'Suppliers',
                        'route' => route('admin.suppliers.index'),
                        'active' => request()->routeIs('admin.suppliers.*'),
                    ],
                ]"
            />
        </div>

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

        <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-[0.12em] text-sp-text-muted">
                    {{ __('Total suppliers') }}
                </p>

                <p class="mt-2 text-3xl font-bold text-sp-brand-dark dark:text-white">
                    {{ number_format($totalSuppliers) }}
                </p>
            </div>

            <div class="rounded-2xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-[0.12em] text-sp-text-muted">
                    {{ __('Active') }}
                </p>

                <p class="mt-2 text-3xl font-bold text-sp-success">
                    {{ number_format($activeSuppliers) }}
                </p>
            </div>

            <div class="rounded-2xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-[0.12em] text-sp-text-muted">
                    {{ __('Inactive') }}
                </p>

                <p class="mt-2 text-3xl font-bold text-sp-warning">
                    {{ number_format($inactiveSuppliers) }}
                </p>
            </div>
        </div>

        <div class="mb-6 rounded-2xl border border-sp-border bg-sp-surface p-4 shadow-sm sm:p-5">
            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px_auto] lg:items-end">
                <div>
                    <label
                        for="supplier-search"
                        class="mb-2 block text-sm font-semibold text-sp-text"
                    >
                        {{ __('Search suppliers') }}
                    </label>

                    <input
                        id="supplier-search"
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Name, company, phone or email...') }}"
                        class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none placeholder:text-sp-text-muted focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                    />
                </div>

                <div>
                    <label
                        for="supplier-status"
                        class="mb-2 block text-sm font-semibold text-sp-text"
                    >
                        {{ __('Status') }}
                    </label>

                    <select
                        id="supplier-status"
                        wire:model.live="status"
                        class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                    >
                        <option value="">{{ __('All statuses') }}</option>
                        <option value="active">{{ __('Active') }}</option>
                        <option value="inactive">{{ __('Inactive') }}</option>
                    </select>
                </div>

                <div>
                    @if ($this->hasActiveFilters())
                        <button
                            type="button"
                            wire:click="clearFilters"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-sp-border bg-sp-surface px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted lg:w-auto"
                        >
                            {{ __('Clear') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="hidden overflow-hidden rounded-2xl border border-sp-border bg-sp-surface shadow-sm lg:block">
            <div class="border-b border-sp-border px-5 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-bold text-sp-brand-dark dark:text-white">
                            {{ __('Supplier catalog') }}
                        </h2>

                        <p class="mt-1 text-xs text-sp-text-muted">
                            {{ __('Supplier contacts and connected purchasing activity.') }}
                        </p>
                    </div>

                    <span class="text-sm font-medium text-sp-text-muted">
                        {{ $suppliers->total() }} {{ __('results') }}
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-sp-border">
                    <thead class="bg-sp-surface-muted">
                        <tr>
                            <th class="px-5 py-3 text-start text-xs font-bold uppercase tracking-[0.08em] text-sp-text-muted">
                                {{ __('Supplier') }}
                            </th>

                            <th class="px-5 py-3 text-start text-xs font-bold uppercase tracking-[0.08em] text-sp-text-muted">
                                {{ __('Contact') }}
                            </th>

                            <th class="px-5 py-3 text-start text-xs font-bold uppercase tracking-[0.08em] text-sp-text-muted">
                                {{ __('Products') }}
                            </th>

                            <th class="px-5 py-3 text-start text-xs font-bold uppercase tracking-[0.08em] text-sp-text-muted">
                                {{ __('Purchases') }}
                            </th>

                            <th class="px-5 py-3 text-start text-xs font-bold uppercase tracking-[0.08em] text-sp-text-muted">
                                {{ __('Status') }}
                            </th>

                            <th class="px-5 py-3 text-end text-xs font-bold uppercase tracking-[0.08em] text-sp-text-muted">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-sp-border">
                        @forelse ($suppliers as $supplier)
                            <tr class="transition hover:bg-sp-surface-muted/60">
                                <td class="px-5 py-4 align-top">
                                    <p class="font-semibold text-sp-text">
                                        {{ $supplier->name }}
                                    </p>

                                    @if ($supplier->company)
                                        <p class="mt-1 text-sm text-sp-text-muted">
                                            {{ $supplier->company }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-5 py-4 align-top">
                                    @if ($supplier->phone)
                                        <p class="text-sm font-medium text-sp-text">
                                            {{ $supplier->phone }}
                                        </p>
                                    @endif

                                    @if ($supplier->email)
                                        <p class="mt-1 text-sm text-sp-text-muted">
                                            {{ $supplier->email }}
                                        </p>
                                    @endif

                                    @if (! $supplier->phone && ! $supplier->email)
                                        <span class="text-sm text-sp-text-muted">
                                            {{ __('No contact details') }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-sm font-medium text-sp-text">
                                    {{ number_format($supplier->products_count) }}
                                </td>

                                <td class="px-5 py-4 text-sm font-medium text-sp-text">
                                    {{ number_format($supplier->purchases_count) }}
                                </td>

                                <td class="px-5 py-4">
                                    @if ($supplier->status === 'active')
                                        <span class="inline-flex rounded-full bg-sp-success/10 px-2.5 py-1 text-xs font-bold text-sp-success">
                                            {{ __('Active') }}
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-sp-warning/10 px-2.5 py-1 text-xs font-bold text-sp-warning">
                                            {{ __('Inactive') }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-end">
                                    @can('update', $supplier)
                                        <button
                                            type="button"
                                            @click="openEdit(@js(['id' => $supplier->id, 'name' => $supplier->name, 'company' => $supplier->company, 'phone' => $supplier->phone, 'email' => $supplier->email, 'address' => $supplier->address, 'status' => $supplier->status]))"
                                            class="inline-flex items-center gap-2 rounded-lg border border-sp-border px-3 py-2 text-xs font-bold text-sp-text transition hover:bg-sp-surface-muted"
                                        >
                                            <x-stockpilot.icon name="edit" class="h-4 w-4" />
                                            {{ __('Edit') }}
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center">
                                    <p class="font-bold text-sp-text">
                                        {{ __('No suppliers found') }}
                                    </p>

                                    <p class="mt-1 text-sm text-sp-text-muted">
                                        {{ __('Try changing your search or create a new supplier.') }}
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($suppliers->hasPages())
                <div class="border-t border-sp-border px-5 py-4">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>

        <div class="space-y-4 lg:hidden">
            @forelse ($suppliers as $supplier)
                <article class="rounded-2xl border border-sp-border bg-sp-surface p-4 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="font-bold text-sp-text">
                                {{ $supplier->name }}
                            </h3>

                            @if ($supplier->company)
                                <p class="mt-1 text-sm text-sp-text-muted">
                                    {{ $supplier->company }}
                                </p>
                            @endif
                        </div>

                        @if ($supplier->status === 'active')
                            <span class="shrink-0 rounded-full bg-sp-success/10 px-2.5 py-1 text-xs font-bold text-sp-success">
                                {{ __('Active') }}
                            </span>
                        @else
                            <span class="shrink-0 rounded-full bg-sp-warning/10 px-2.5 py-1 text-xs font-bold text-sp-warning">
                                {{ __('Inactive') }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-4 space-y-2 text-sm">
                        @if ($supplier->phone)
                            <p class="text-sp-text">
                                <span class="font-semibold">{{ __('Phone') }}:</span>
                                {{ $supplier->phone }}
                            </p>
                        @endif

                        @if ($supplier->email)
                            <p class="break-all text-sp-text">
                                <span class="font-semibold">{{ __('Email') }}:</span>
                                {{ $supplier->email }}
                            </p>
                        @endif

                        @if ($supplier->address)
                            <p class="text-sp-text">
                                <span class="font-semibold">{{ __('Address') }}:</span>
                                {{ $supplier->address }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-sp-surface-muted px-3 py-3">
                            <p class="text-xs font-bold uppercase tracking-[0.08em] text-sp-text-muted">
                                {{ __('Products') }}
                            </p>

                            <p class="mt-1 text-lg font-bold text-sp-text">
                                {{ number_format($supplier->products_count) }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-sp-surface-muted px-3 py-3">
                            <p class="text-xs font-bold uppercase tracking-[0.08em] text-sp-text-muted">
                                {{ __('Purchases') }}
                            </p>

                            <p class="mt-1 text-lg font-bold text-sp-text">
                                {{ number_format($supplier->purchases_count) }}
                            </p>
                        </div>
                    </div>

                    @can('update', $supplier)
                        <button
                            type="button"
                            @click="openEdit(@js(['id' => $supplier->id, 'name' => $supplier->name, 'company' => $supplier->company, 'phone' => $supplier->phone, 'email' => $supplier->email, 'address' => $supplier->address, 'status' => $supplier->status]))"
                            class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-sp-border px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted"
                        >
                            <x-stockpilot.icon name="edit" class="h-4 w-4" />
                            {{ __('Edit supplier') }}
                        </button>
                    @endcan
                </article>
            @empty
                <div class="rounded-2xl border border-sp-border bg-sp-surface px-5 py-12 text-center shadow-sm">
                    <p class="font-bold text-sp-text">
                        {{ __('No suppliers found') }}
                    </p>

                    <p class="mt-1 text-sm text-sp-text-muted">
                        {{ __('Try changing your search or create a new supplier.') }}
                    </p>
                </div>
            @endforelse

            @if ($suppliers->hasPages())
                <div>
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>
    </div>

    @can('create', \App\Models\Supplier::class)
        <div
            x-cloak
            x-show="createOpen"
            x-transition.opacity
            class="fixed inset-0 z-[70] flex items-center justify-center bg-sp-brand-dark/50 p-4 backdrop-blur-sm"
            x-on:click.self="closeModals()"
        >
            <div
                x-show="createOpen"
                x-transition.scale.origin.center
                class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl border border-sp-border bg-sp-surface shadow-2xl"
            >
                <div class="flex items-start justify-between border-b border-sp-border px-5 py-4">
                    <div>
                        <h2 class="text-lg font-bold text-sp-brand-dark dark:text-white">
                            {{ __('Add supplier') }}
                        </h2>

                        <p class="mt-1 text-sm text-sp-text-muted">
                            {{ __('Create a supplier master record.') }}
                        </p>
                    </div>

                    <button
                        type="button"
                        x-on:click="closeModals()"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text"
                        aria-label="{{ __('Close') }}"
                    >
                        <x-stockpilot.icon name="x" class="h-5 w-5" />
                    </button>
                </div>

                <form
                    method="POST"
                    action="{{ route('admin.suppliers.store') }}"
                    class="space-y-5 p-5"
                >
                    @csrf

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="supplier-create-name" class="mb-2 block text-sm font-semibold text-sp-text">
                                {{ __('Supplier name') }}
                            </label>

                            <input
                                id="supplier-create-name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                maxlength="150"
                                required
                                class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                            >
                        </div>

                        <div>
                            <label for="supplier-create-company" class="mb-2 block text-sm font-semibold text-sp-text">
                                {{ __('Company') }}
                            </label>

                            <input
                                id="supplier-create-company"
                                name="company"
                                type="text"
                                value="{{ old('company') }}"
                                maxlength="150"
                                class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                            >
                        </div>

                        <div>
                            <label for="supplier-create-phone" class="mb-2 block text-sm font-semibold text-sp-text">
                                {{ __('Phone') }}
                            </label>

                            <input
                                id="supplier-create-phone"
                                name="phone"
                                type="text"
                                value="{{ old('phone') }}"
                                maxlength="30"
                                class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                            >
                        </div>

                        <div>
                            <label for="supplier-create-email" class="mb-2 block text-sm font-semibold text-sp-text">
                                {{ __('Email') }}
                            </label>

                            <input
                                id="supplier-create-email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                maxlength="150"
                                class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label for="supplier-create-address" class="mb-2 block text-sm font-semibold text-sp-text">
                                {{ __('Address') }}
                            </label>

                            <textarea
                                id="supplier-create-address"
                                name="address"
                                rows="3"
                                maxlength="5000"
                                class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                            >{{ old('address') }}</textarea>
                        </div>

                        <div>
                            <label for="supplier-create-status" class="mb-2 block text-sm font-semibold text-sp-text">
                                {{ __('Status') }}
                            </label>

                            <select
                                id="supplier-create-status"
                                name="status"
                                required
                                class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                            >
                                <option value="active" @selected(old('status', 'active') === 'active')>
                                    {{ __('Active') }}
                                </option>

                                <option value="inactive" @selected(old('status') === 'inactive')>
                                    {{ __('Inactive') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            x-on:click="closeModals()"
                            class="rounded-xl border border-sp-border px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted"
                        >
                            {{ __('Cancel') }}
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-sp-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-sp-brand-dark"
                        >
                            {{ __('Create supplier') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    <div
        x-cloak
        x-show="editOpen"
        x-transition.opacity
        class="fixed inset-0 z-[70] flex items-center justify-center bg-sp-brand-dark/50 p-4 backdrop-blur-sm"
        x-on:click.self="closeModals()"
    >
        <div
            x-show="editOpen"
            x-transition.scale.origin.center
            class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl border border-sp-border bg-sp-surface shadow-2xl"
        >
            <div class="flex items-start justify-between border-b border-sp-border px-5 py-4">
                <div>
                    <h2 class="text-lg font-bold text-sp-brand-dark dark:text-white">
                        {{ __('Edit supplier') }}
                    </h2>

                    <p class="mt-1 text-sm text-sp-text-muted">
                        {{ __('Update supplier master data.') }}
                    </p>
                </div>

                <button
                    type="button"
                    x-on:click="closeModals()"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text"
                    aria-label="{{ __('Close') }}"
                >
                    <x-stockpilot.icon name="x" class="h-5 w-5" />
                </button>
            </div>

            <form
                method="POST"
                x-bind:action="editingSupplier ? `{{ url('/admin/suppliers') }}/${editingSupplier.id}` : '#'"
                class="space-y-5 p-5"
            >
                @csrf
                @method('PATCH')

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="supplier-edit-name" class="mb-2 block text-sm font-semibold text-sp-text">
                            {{ __('Supplier name') }}
                        </label>

                        <input
                            id="supplier-edit-name"
                            name="name"
                            type="text"
                            required
                            maxlength="150"
                            x-model="editingSupplier.name"
                            class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                        >
                    </div>

                    <div>
                        <label for="supplier-edit-company" class="mb-2 block text-sm font-semibold text-sp-text">
                            {{ __('Company') }}
                        </label>

                        <input
                            id="supplier-edit-company"
                            name="company"
                            type="text"
                            maxlength="150"
                            x-model="editingSupplier.company"
                            class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                        >
                    </div>

                    <div>
                        <label for="supplier-edit-phone" class="mb-2 block text-sm font-semibold text-sp-text">
                            {{ __('Phone') }}
                        </label>

                        <input
                            id="supplier-edit-phone"
                            name="phone"
                            type="text"
                            maxlength="30"
                            x-model="editingSupplier.phone"
                            class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                        >
                    </div>

                    <div>
                        <label for="supplier-edit-email" class="mb-2 block text-sm font-semibold text-sp-text">
                            {{ __('Email') }}
                        </label>

                        <input
                            id="supplier-edit-email"
                            name="email"
                            type="email"
                            maxlength="150"
                            x-model="editingSupplier.email"
                            class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label for="supplier-edit-address" class="mb-2 block text-sm font-semibold text-sp-text">
                            {{ __('Address') }}
                        </label>

                        <textarea
                            id="supplier-edit-address"
                            name="address"
                            rows="3"
                            maxlength="5000"
                            x-model="editingSupplier.address"
                            class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                        ></textarea>
                    </div>

                    <div>
                        <label for="supplier-edit-status" class="mb-2 block text-sm font-semibold text-sp-text">
                            {{ __('Status') }}
                        </label>

                        <select
                            id="supplier-edit-status"
                            name="status"
                            required
                            x-model="editingSupplier.status"
                            class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
                        >
                            <option value="active">{{ __('Active') }}</option>
                            <option value="inactive">{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        x-on:click="closeModals()"
                        class="rounded-xl border border-sp-border px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted"
                    >
                        {{ __('Cancel') }}
                    </button>

                    <button
                        type="submit"
                        class="rounded-xl bg-sp-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-sp-brand-dark"
                    >
                        {{ __('Save changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>