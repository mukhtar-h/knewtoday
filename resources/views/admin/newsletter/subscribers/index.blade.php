@extends('layouts.admin')

@section('title', 'Newsletter Subscribers')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="kt-section-title text-base">
                    Newsletter Subscribers
                </h1>
                <p class="text-xs text-kt-textMuted">
                    View and export subscribers who signed up for KNEWTODAY updates.
                </p>
                <p class="text-[11px] text-kt-muted mt-1">
                    Total: <span class="text-kt-text">{{ $stats['total'] }}</span> •
                    Subscribed: <span class="text-emerald-300">{{ $stats['subscribed'] }}</span> •
                    Unsubscribed: <span class="text-kt-textMuted">{{ $stats['unsubscribed'] }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.newsletter.subscribers.export', request()->query()) }}"
                    class="kt-btn-outline text-[11px]">
                    Export CSV
                </a>
            </div>
        </div>

        {{-- Filters --}}
        <section class="kt-card text-xs">
            <form method="GET" action="{{ route('admin.newsletter.subscribers.index') }}"
                class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">

                <div class="flex-1 space-y-1">
                    <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Search
                    </label>
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search by email or name..."
                        class="w-full px-3 py-2 rounded-lg bg-kt-bg border border-kt-border text-xs text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                        Status
                    </label>
                    <select name="status"
                        class="bg-kt-bg border border-kt-border rounded-lg px-3 py-2 text-xs text-kt-textMuted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                        <option value="">All</option>
                        <option value="subscribed" @selected(request('status') === 'subscribed')>Subscribed</option>
                        <option value="unsubscribed" @selected(request('status') === 'unsubscribed')>Unsubscribed</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 pt-2 md:pt-0">
                    <a href="{{ route('admin.newsletter.subscribers.index') }}" class="kt-btn-outline text-[11px]">
                        Reset
                    </a>
                    <button type="submit" class="kt-btn-primary text-[11px]">
                        Apply
                    </button>
                </div>
            </form>
        </section>

        {{-- Table --}}
        <section class="kt-card overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse">
                <thead class="border-b border-kt-border text-[10px] uppercase tracking-[0.16em] text-kt-muted">
                    <tr>
                        <th class="py-2 pr-4">Email</th>
                        <th class="py-2 px-4">Name</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Subscribed At</th>
                        <th class="py-2 px-4">Unsubscribed At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-kt-border/60">
                    @forelse($subscribers as $subscriber)
                        <tr>
                            <td class="py-2 pr-4 align-top">
                                <span class="text-kt-text">{{ $subscriber->email }}</span>
                            </td>
                            <td class="py-2 px-4 align-top">
                                <span class="text-kt-textMuted">
                                    {{ $subscriber->name ?: '—' }}
                                </span>
                            </td>
                            <td class="py-2 px-4 align-top">
                                @if (trim($subscriber->status->value) === 'subscribed')
                                    <span
                                        class="inline-flex items-center rounded-full border border-emerald-400/60 bg-emerald-500/10 px-2 py-0.5 text-[10px] text-emerald-100">
                                        Subscribed
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full border border-kt-border bg-kt-bg px-2 py-0.5 text-[10px] text-kt-textMuted">
                                        Unsubscribed
                                    </span>
                                @endif
                            </td>
                            <td class="py-2 px-4 align-top text-kt-textMuted">
                                {{ optional($subscriber->subscribed_at)->format('Y-m-d H:i') ?: '—' }}
                            </td>
                            <td class="py-2 px-4 align-top text-kt-textMuted">
                                {{ optional($subscriber->unsubscribed_at)->format('Y-m-d H:i') ?: '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-kt-textMuted">
                                No subscribers found for the current filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($subscribers->hasPages())
                <div class="mt-4 flex items-center justify-between text-[11px] text-kt-textMuted">
                    <p>
                        Showing
                        <span class="text-kt-text">{{ $subscribers->firstItem() }}–{{ $subscribers->lastItem() }}</span>
                        of
                        <span class="text-kt-text">{{ $subscribers->total() }}</span>
                        subscribers
                    </p>
                    <div>
                        {{ $subscribers->links() }}
                    </div>
                </div>
            @endif
        </section>

    </div>
@endsection
