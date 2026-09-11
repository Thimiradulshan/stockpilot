<div class="mb-6 rounded-2xl border border-sp-border bg-sp-surface p-4 shadow-sm sm:p-5">
    <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px_auto] lg:items-end">
        <div>
            <label
                for="purchase-search"
                class="mb-2 block text-sm font-semibold text-sp-text"
            >
                {{ __('Search purchases') }}
            </label>

            <input
                id="purchase-search"
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="{{ __('Purchase number, supplier name...') }}"
                class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none placeholder:text-sp-text-muted focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
            />
        </div>

        <div>
            <label
                for="purchase-status"
                class="mb-2 block text-sm font-semibold text-sp-text"
            >
                {{ __('Status') }}
            </label>

            <select
                id="purchase-status"
                wire:model.live="status"
                class="w-full rounded-xl border border-sp-border bg-sp-surface-muted px-3 py-2.5 text-sm text-sp-text outline-none focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/10"
            >
                <option value="">
                    {{ __('All statuses') }}
                </option>

                <option value="completed">
                    {{ __('Completed') }}
                </option>

                <option value="cancelled">
                    {{ __('Cancelled') }}
                </option>
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
