<div class="container header_container">
    <header>
        <h1>Inside Design: Stories and interviews</h1>
        <p>Subscribe to learn about new product features, the latest in technology, and updates.</p>
        <form action="">
            <input type="email" placeholder="Enter your email" required>
            <button>Subscribe</button>
        </form>
    </header>
</div>
<div class="container recent_container">
    <h2 class="title_head">Recent blog posts</h2>
    <div class="grid_head">
        @foreach($recentPosts as $post)
            <a href="{{ route('post.show', $post->id) }}" class="card_head" style="text-decoration:none;color:inherit;">
                <img src="{{ $post->thumbnail ? asset($post->thumbnail) : asset('img/img2.jpg') }}" alt="picture">
                <div class="card_details">
                    <p class="author_time">
                        {{ $post->user->username ?? 'Unknown' }} <i class="ri-checkbox-blank-circle-fill"></i> {{ $post->created_at->format('d M Y') }}
                    </p>
                    <h2 class="title_card">{{ $post->title }}<i class="ri-arrow-right-up-line"></i></h2>
                    <p class="subtitle">{{ $post->sub_title ?? Str::limit(strip_tags($post->body), 80) }}</p>
                    <div class="tags">
                        <span class="tag">{{ $post->category->name ?? 'Uncategorized' }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
<div class="container all_container">
    <h2 class="title_head">All blog posts</h2>
    <div class="grid_posts">
        @foreach($posts as $post)
            <a href="{{ route('post.show', $post->id) }}" class="grid_card">
                <img src="{{ $post->thumbnail ? asset($post->thumbnail) : asset('img/img2.jpg') }}" alt="image">
                <div class="card_details">
                    <p class="author_time">
                        {{ $post->user->username ?? 'Unknown' }} <i class="ri-checkbox-blank-circle-fill"></i> {{ $post->created_at->format('d M Y') }}
                    </p>
                    <h2 class="title_card">{{ $post->title }}<i class="ri-arrow-right-up-line"></i></h2>
                    <p class="subtitle">{{ $post->sub_title ?? Str::limit(strip_tags($post->body), 80) }}</p>
                    <div class="tags">
                        <span class="tag">{{ $post->category->name ?? 'Uncategorized' }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="container pagination">
        <span class="previous" @if($posts->onFirstPage()) style="opacity:0.5;pointer-events:none;" @endif>
            <a href="{{ $posts->previousPageUrl() ?? '#' }}" style="display:flex;align-items:center;color:inherit;text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg> Previous
            </a>
        </span>
        <ul>
            @php
                $start = max($posts->currentPage() - 2, 1);
                $end = min($posts->lastPage(), $posts->currentPage() + 2);
                if($start > 1) {
                    echo '<li>1</li>';
                    if($start > 2) echo '<li class="dot">...</li>';
                }
            @endphp
            @for($i = $start; $i <= $end; $i++)
                @if($i == $posts->currentPage())
                    <li class="current">{{ $i }}</li>
                @else
                    <li><a href="{{ $posts->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor
            @php
                if($end < $posts->lastPage()) {
                    if($end < $posts->lastPage() - 1) echo '<li class="dot">...</li>';
                    echo '<li><a href="'.$posts->url($posts->lastPage()).'">'.$posts->lastPage().'</a></li>';
                }
            @endphp
        </ul>
        <span class="after" @if(!$posts->hasMorePages()) style="opacity:0.5;pointer-events:none;" @endif>
            <a href="{{ $posts->nextPageUrl() ?? '#' }}" style="display:flex;align-items:center;color:inherit;text-decoration:none;">
                Next<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
            </a>
        </span>
    </div>
</div>
