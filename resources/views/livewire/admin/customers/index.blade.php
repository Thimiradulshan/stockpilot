<div class="space-y-6">
    {{-- Flash success message --}}
    @if (session('success'))
        <div class="sp-alert sp-alert-success">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 shrink-0">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <div class="text-sm font-medium">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="sp-alert sp-alert-danger">
            <div>
                <div class="font-semibold">
                    Please correct the following errors:
                </div>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Page header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <a
                    href="{{ route('admin.products.index') }}"
                    class="transition-colors hover:text-[#118AB2]"
                >
                    Master Data
                </a>

                <span>/</span>

                <span class="font-medium text-slate-700">
                    Customers
                </span>
            </div>

            <div class="mt-2">
                <h1 class="text-2xl font-bold tracking-tight text-[#166088]">
                    Customers
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage customer records used by StockPilot sales and invoices.
                </p>
            </div>
        </div>

        @can('create', App\Models\Customer::class)
            <button
                type="button"
                onclick="openCreateCustomerModal()"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#118AB2] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#166088] focus:outline-none focus:ring-2 focus:ring-[#118AB2] focus:ring-offset-2"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                </svg>

                New Customer
            </button>
        @endcan
    </div>

    {{-- Master data tabs --}}
    <div class="border-b border-[#BEE9E8]">
        <nav class="flex flex-wrap gap-6" aria-label="Master data navigation">
            <a
                href="{{ route('admin.products.index') }}"
                class="border-b-2 border-transparent pb-3 text-sm font-semibold text-slate-500 transition hover:border-[#5FA8D3] hover:text-[#166088]"
            >
                Products
            </a>

            @can('viewAny', App\Models\Category::class)
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="border-b-2 border-transparent pb-3 text-sm font-semibold text-slate-500 transition hover:border-[#5FA8D3] hover:text-[#166088]"
                >
                    Categories
                </a>
            @endcan

            @can('viewAny', App\Models\Supplier::class)
                <a
                    href="{{ route('admin.suppliers.index') }}"
                    class="border-b-2 border-transparent pb-3 text-sm font-semibold text-slate-500 transition hover:border-[#5FA8D3] hover:text-[#166088]"
                >
                    Suppliers
                </a>
            @endcan

            @can('viewAny', App\Models\Customer::class)
                <a
                    href="{{ route('admin.customers.index') }}"
                    class="border-b-2 border-[#118AB2] pb-3 text-sm font-bold text-[#118AB2]"
                >
                    Customers
                </a>
            @endcan
        </nav>
    </div>

    {{-- KPI cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-[#BEE9E8] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Customers
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#166088]">
                        {{ number_format($totalCustomers) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E3F2FD] text-[#118AB2]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-[#BEE9E8] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Active
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#06A77D]">
                        {{ number_format($activeCustomers) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E9FFF7] text-[#06A77D]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-[#BEE9E8] bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Inactive
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#EF476F]">
                        {{ number_format($inactiveCustomers) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FFF0F3] text-[#EF476F]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="rounded-2xl border border-[#BEE9E8] bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end">
            <div class="flex-1">
                <label
                    for="customer-search"
                    class="mb-2 block text-sm font-semibold text-[#166088]"
                >
                    Search
                </label>

                <div class="relative">
                    <svg
                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="11" cy="11" r="8" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
                    </svg>

                    <input
                        id="customer-search"
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by name, phone, email or address..."
                        class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                    />
                </div>
            </div>

            <div class="w-full lg:w-52">
                <label
                    for="customer-status"
                    class="mb-2 block text-sm font-semibold text-[#166088]"
                >
                    Status
                </label>

                <select
                    id="customer-status"
                    wire:model.live="status"
                    class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                >
                    <option value="">All statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            @if ($this->hasActiveFilters())
                <button
                    type="button"
                    wire:click="clearFilters"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#BEE9E8] bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-[#5FA8D3] hover:text-[#166088]"
                >
                    Clear
                </button>
            @endif
        </div>
    </div>

    {{-- Desktop table --}}
    <div class="hidden overflow-hidden rounded-2xl border border-[#BEE9E8] bg-white shadow-sm lg:block">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#E3F2FD]">
                <thead class="bg-[#E3F2FD]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#166088]">
                            Customer
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#166088]">
                            Phone
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#166088]">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#166088]">
                            Invoices
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-[#166088]">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wide text-[#166088]">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E3F2FD]">
                    @forelse ($customers as $customer)
                        <tr class="transition hover:bg-[#F8FDFF]">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $customer->name }}
                                </div>

                                @if ($customer->address)
                                    <div class="mt-1 max-w-xs truncate text-sm text-slate-500">
                                        {{ $customer->address }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $customer->phone ?: '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $customer->email ?: '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm font-semibold text-[#166088]">
                                {{ number_format($customer->invoices_count) }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($customer->status === 'active')
                                    <span class="inline-flex rounded-full bg-[#E9FFF7] px-3 py-1 text-xs font-bold text-[#06A77D]">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-[#FFF0F3] px-3 py-1 text-xs font-bold text-[#EF476F]">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                @can('update', $customer)
                                    <button
                                        type="button"
                                        onclick="openEditCustomerModal(
                                            {{ $customer->id }},
                                            @js($customer->name),
                                            @js($customer->phone),
                                            @js($customer->email),
                                            @js($customer->address),
                                            @js($customer->status)
                                        )"
                                        class="inline-flex items-center gap-2 rounded-lg border border-[#BEE9E8] px-3 py-2 text-sm font-semibold text-[#166088] transition hover:border-[#5FA8D3] hover:bg-[#E3F2FD]"
                                    >
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>

                                        Edit
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#E3F2FD] text-[#118AB2]">
                                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                                    </svg>
                                </div>

                                <h3 class="mt-4 text-sm font-bold text-[#166088]">
                                    No customers found
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Try changing your search or status filter.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($customers->hasPages())
            <div class="border-t border-[#E3F2FD] px-6 py-4">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    {{-- Mobile cards --}}
    <div class="space-y-4 lg:hidden">
        @forelse ($customers as $customer)
            <div class="rounded-2xl border border-[#BEE9E8] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <h3 class="font-bold text-[#166088]">
                            {{ $customer->name }}
                        </h3>

                        @if ($customer->phone)
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $customer->phone }}
                            </p>
                        @endif
                    </div>

                    @if ($customer->status === 'active')
                        <span class="shrink-0 inline-flex rounded-full bg-[#E9FFF7] px-3 py-1 text-xs font-bold text-[#06A77D]">
                            Active
                        </span>
                    @else
                        <span class="shrink-0 inline-flex rounded-full bg-[#FFF0F3] px-3 py-1 text-xs font-bold text-[#EF476F]">
                            Inactive
                        </span>
                    @endif
                </div>

                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Email</span>

                        <span class="text-right text-slate-700">
                            {{ $customer->email ?: '—' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Invoices</span>

                        <span class="font-semibold text-[#166088]">
                            {{ number_format($customer->invoices_count) }}
                        </span>
                    </div>

                    @if ($customer->address)
                        <div class="pt-2 text-slate-600">
                            {{ $customer->address }}
                        </div>
                    @endif
                </div>

                @can('update', $customer)
                    <div class="mt-4 border-t border-[#E3F2FD] pt-4">
                        <button
                            type="button"
                            onclick="openEditCustomerModal(
                                {{ $customer->id }},
                                @js($customer->name),
                                @js($customer->phone),
                                @js($customer->email),
                                @js($customer->address),
                                @js($customer->status)
                            )"
                            class="w-full rounded-xl border border-[#BEE9E8] px-4 py-2.5 text-sm font-semibold text-[#166088] transition hover:border-[#5FA8D3] hover:bg-[#E3F2FD]"
                        >
                            Edit Customer
                        </button>
                    </div>
                @endcan
            </div>
        @empty
            <div class="rounded-2xl border border-[#BEE9E8] bg-white px-6 py-14 text-center shadow-sm">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#E3F2FD] text-[#118AB2]">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg>
                </div>

                <h3 class="mt-4 text-sm font-bold text-[#166088]">
                    No customers found
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Try changing your search or status filter.
                </p>
            </div>
        @endforelse

        @if ($customers->hasPages())
            <div>
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    {{-- Create modal --}}
    @can('create', App\Models\Customer::class)
        <div
            id="createCustomerModal"
            class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/40 px-4 py-8"
        >
            <div class="mx-auto flex min-h-full max-w-2xl items-center justify-center">
                <div class="w-full rounded-2xl bg-white shadow-2xl">
                    <div class="flex items-center justify-between border-b border-[#E3F2FD] px-6 py-5">
                        <div>
                            <h2 class="text-lg font-bold text-[#166088]">
                                New Customer
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Add a customer record to StockPilot.
                            </p>
                        </div>

                        <button
                            type="button"
                            onclick="closeCreateCustomerModal()"
                            class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('admin.customers.store') }}"
                        class="space-y-5 px-6 py-6"
                    >
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[#166088]">
                                Customer Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                maxlength="150"
                                class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                            />
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-[#166088]">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    maxlength="30"
                                    class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                                />
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-[#166088]">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    maxlength="150"
                                    class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[#166088]">
                                Address
                            </label>

                            <textarea
                                name="address"
                                rows="4"
                                maxlength="5000"
                                class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                            >{{ old('address') }}</textarea>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[#166088]">
                                Status
                            </label>

                            <select
                                name="status"
                                required
                                class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                            >
                                <option value="active" @selected(old('status', 'active') === 'active')>
                                    Active
                                </option>

                                <option value="inactive" @selected(old('status') === 'inactive')>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="flex justify-end gap-3 border-t border-[#E3F2FD] pt-5">
                            <button
                                type="button"
                                onclick="closeCreateCustomerModal()"
                                class="rounded-xl border border-[#BEE9E8] px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="rounded-xl bg-[#118AB2] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#166088]"
                            >
                                Create Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    {{-- Edit modal --}}
    <div
        id="editCustomerModal"
        class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/40 px-4 py-8"
    >
        <div class="mx-auto flex min-h-full max-w-2xl items-center justify-center">
            <div class="w-full rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-[#E3F2FD] px-6 py-5">
                    <div>
                        <h2 class="text-lg font-bold text-[#166088]">
                            Edit Customer
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Update customer information and status.
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="closeEditCustomerModal()"
                        class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form
                    id="editCustomerForm"
                    method="POST"
                    class="space-y-5 px-6 py-6"
                >
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[#166088]">
                            Customer Name
                        </label>

                        <input
                            id="editCustomerName"
                            type="text"
                            name="name"
                            required
                            maxlength="150"
                            class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                        />
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[#166088]">
                                Phone
                            </label>

                            <input
                                id="editCustomerPhone"
                                type="text"
                                name="phone"
                                maxlength="30"
                                class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                            />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[#166088]">
                                Email
                            </label>

                            <input
                                id="editCustomerEmail"
                                type="email"
                                name="email"
                                maxlength="150"
                                class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[#166088]">
                            Address
                        </label>

                        <textarea
                            id="editCustomerAddress"
                            name="address"
                            rows="4"
                            maxlength="5000"
                            class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                        ></textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[#166088]">
                            Status
                        </label>

                        <select
                            id="editCustomerStatus"
                            name="status"
                            required
                            class="w-full rounded-xl border border-[#BEE9E8] bg-[#F8FDFF] px-4 py-2.5 text-sm outline-none focus:border-[#118AB2] focus:ring-2 focus:ring-[#118AB2]/10"
                        >
                            <option value="active">
                                Active
                            </option>

                            <option value="inactive">
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-[#E3F2FD] pt-5">
                        <button
                            type="button"
                            onclick="closeEditCustomerModal()"
                            class="rounded-xl border border-[#BEE9E8] px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-[#118AB2] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#166088]"
                        >
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openCreateCustomerModal() {
        const modal = document.getElementById('createCustomerModal');

        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeCreateCustomerModal() {
        const modal = document.getElementById('createCustomerModal');

        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function openEditCustomerModal(
        id,
        name,
        phone,
        email,
        address,
        status
    ) {
        document.getElementById('editCustomerName').value = name ?? '';
        document.getElementById('editCustomerPhone').value = phone ?? '';
        document.getElementById('editCustomerEmail').value = email ?? '';
        document.getElementById('editCustomerAddress').value = address ?? '';
        document.getElementById('editCustomerStatus').value = status ?? 'active';

        document.getElementById('editCustomerForm').action =
            `/admin/customers/${id}`;

        document.getElementById('editCustomerModal').classList.remove('hidden');
    }

    function closeEditCustomerModal() {
        document.getElementById('editCustomerModal').classList.add('hidden');
    }
</script>
