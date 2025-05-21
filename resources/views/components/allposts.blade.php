<div class="container all_container" id="allposts">
    <h2 class="title_head">All blog posts</h2>
    <div class="grid_posts">
        @foreach($posts as $post)
            <a href="{{ route('posts.show', $post->id) }}" class="grid_card">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                <div class="card_details">
                    <p class="author_time">
                        {{ $post->user->username ?? 'Unknown' }} 
                        <i class="ri-checkbox-blank-circle-fill"></i> 
                        {{ $post->created_at->format('d M Y') }}
                    </p>
                    <h2 class="title_card">{{ $post->title }} <i class="ri-arrow-right-up-line"></i></h2>
                    <p class="subtitle">{{ $post->sub_title }}</p>
                    <div class="tags">
                        <span class="tag">{{ $post->category->name ?? 'Uncategorized' }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>

{{-- PHÂN TRANG --}}
<div class="container pagination">
    {{ $posts->onEachSide(1)->links('vendor.pagination.custom') }}
</div>
