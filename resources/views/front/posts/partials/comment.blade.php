@php
/** @var \App\Models\Comment $comment */
$hasReplies = $comment->replies && $comment->replies->isNotEmpty();
@endphp

<article class="kt-card text-xs space-y-2" id="comment-{{ $comment->id }}">
    <div class="flex items-start gap-3">
        {{-- Simple avatar circle (initial) --}}
        @php
        $authorName = $comment->user->name ?? $comment->guest_name ?? 'Guest';
        $initial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($authorName, 0, 1));
        @endphp
        <div class="flex-shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-full border border-kt-border/80 bg-kt-bg text-[11px] font-semibold">
            {{ $initial }}
        </div>

        <div class="flex-1 space-y-1 ">
            <div class="flex items-center justify-between gap-2 ">
                {{-- Author Name and Date --}}
                <div class="space-y-0.5">
                    <p class="text-[11px] font-semibold text-kt-text">
                        {{ $authorName }}
                    </p>
                    <p class="text-[10px] text-kt-muted">
                        {{ $comment->created_at->diffForHumans() }}
                    </p>
                </div>         
                {{-- in case any thing happened to CSS, Reply toggle goes here --}}       
            </div>
            

            {{-- Comment body --}}
            <div class="prose prose-invert prose-xs max-w-none text-kt-text">
                {!! nl2br(e($comment->body)) !!}
            </div>

            {{-- Reply toggle --}}
            <details class="text-[11px] text-kt-accent pt-2.5">
                <summary class="cursor-pointer list-none  hover:cursor-pointer">
                    Reply
                </summary>

                <div class="mt-2 pt-2 border-t border-kt-border/60">
                    <form method="POST" action="{{ route('front.comment.store', $post) }}" class="space-y-2">
                        @csrf

                        @guest
                        <div class="grid gap-2 sm:grid-cols-2">
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                                    Name
                                </label>
                                <input type="text"
                                    name="guest_name"
                                    value="{{ old('guest_name') }}"
                                    required
                                    class="w-full px-2 py-1.5 rounded-lg bg-kt-bg border border-kt-border text-[11px] text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                                    Email
                                </label>
                                <input type="email"
                                    name="guest_email"
                                    value="{{ old('guest_email') }}"
                                    required
                                    class="w-full px-2 py-1.5 rounded-lg bg-kt-bg border border-kt-border text-[11px] text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent">
                            </div>
                        </div>
                        @endguest

                        <div class="space-y-1">
                            <label class="text-[10px] uppercase tracking-[0.18em] text-kt-muted">
                                Reply
                            </label>
                            <textarea name="body"
                                rows="3"
                                required
                                class="w-full px-2 py-1.5 rounded-lg bg-kt-bg border border-kt-border text-[11px] text-kt-text placeholder:text-kt-muted focus:outline-none focus:border-kt-accent focus:ring-1 focus:ring-kt-accent"></textarea>
                        </div>

                        {{-- Parent comment --}}
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                        <div class="flex items-center justify-end ">
                            <button type="submit" class="kt-btn-primary text-[11px]">
                                Post reply
                            </button>
                        </div>
                    </form>
                </div>
            </details>
        </div>
    </div>

    {{-- Replies: single level only --}}
    @if($hasReplies)
    <div class="mt-3 pl-6 border-l border-kt-border/60 space-y-2">
        @foreach($comment->replies as $reply)
        <article class="kt-card text-xs space-y-1" id="comment-{{ $reply->id }}">
            <div class="flex items-start gap-3">
                @php
                $replyAuthor = $reply->user->name ?? $reply->guest_name ?? 'Guest';
                $replyInitial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($replyAuthor, 0, 1));
                @endphp

                <div class="flex-shrink-0 inline-flex items-center justify-center w-7 h-7 rounded-full border border-kt-border/80 bg-kt-bg text-[10px] font-semibold">
                    {{ $replyInitial }}
                </div>

                <div class="flex-1 space-y-1">
                    <div class="flex items-center justify-between gap-2">
                        <div class="space-y-0.5">
                            <p class="text-[11px] font-semibold text-kt-text">
                                {{ $replyAuthor }}
                            </p>
                            <p class="text-[10px] text-kt-muted">
                                {{ $reply->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="prose prose-invert prose-xs max-w-none text-kt-text">
                        {!! nl2br(e($reply->body)) !!}
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    @endif

</article>