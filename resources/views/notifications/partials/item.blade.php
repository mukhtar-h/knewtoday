@php
    use Illuminate\Support\Str;

    $data = $notification->data ?? [];
    $kind = $data['kind'] ?? null;

    $isUnread = is_null($notification->read_at);

    // Defaults (safe fallbacks)
    $title = 'Notification';
    $message = '';
    $url = $data['url'] ?? null;

    // Our CommentReplied notification shape
    if (isset($data['post_title']) && isset($data['replier_name'])) {
        $title = 'New reply to your comment';
        $message = $data['replier_name'] . ' replied on “' . $data['post_title'] . '”';
    }

    $excerpt = $data['excerpt'] ?? null;
@endphp

<article class="kt-card flex flex-col gap-2 text-xs {{ $isUnread ? 'border-kt-accent/60' : 'border-kt-border/80' }}">

    {{-- new format --}}
    <div class="flex-1 space-y-1">
        @if ($kind === 'comment_replied')
            <p class="text-[11px] text-kt-text">
                {{ $data['replier_name'] ?? 'Someone' }} replied to your comment
                on
                <a href="{{ $data['url'] ?? '#' }}" class="text-kt-accent hover:underline">
                    {{ $data['post_title'] ?? 'a post' }}
                </a>
            </p>
        @elseif($kind === 'post_commented')
            <p class="text-[11px] text-kt-text">
                {{ $data['commenter_name'] ?? 'Someone' }} commented on your post
                <a href="{{ $data['url'] ?? '#' }}" class="text-kt-accent hover:underline">
                    {{ $data['post_title'] ?? 'a post' }}
                </a>
            </p>
        @else
            <p class="text-[11px] text-kt-text">
                You have a new notification.
            </p>
        @endif

        @if (!empty($data['excerpt']))
            <p class="text-[11px] text-kt-textMuted line-clamp-2">
                {{ $data['excerpt'] }}
            </p>
        @endif

        <p class="text-[10px] text-kt-muted">
            {{ $notification->created_at->diffForHumans() }}
        </p>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-2 pt-1">
        <div class="flex items-center gap-2">
            @if ($url)
                <a href="{{ route('notifications.go', $notification->id) }}" class="kt-btn-primary text-[11px]">
                    View
                </a>
            @endif

            @if ($isUnread)
                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                    @csrf
                    <button type="submit" class="kt-btn-outline text-[11px]">
                        Mark as read
                    </button>
                </form>
            @endif
        </div>

        <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-[11px] text-kt-textMuted hover:text-red-300"
                onclick="return confirm('Remove this notification?');">
                Remove
            </button>
        </form>
    </div>
</article>
