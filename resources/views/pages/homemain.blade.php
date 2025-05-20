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
            @foreach($recentPosts as $index => $post)
                <a href="{{ url('/posts/' . $post->id) }}" class="card_head {{ $index === 0 ? 'ontop' : '' }}">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                    <div class="card_details">
                        <p class="author_time">
                            {{ $post->user->username ?? 'Unknown' }}
                            <i class="ri-checkbox-blank-circle-fill"></i>
                            {{ $post->created_at->format('d M Y') }}
                        </p>
                        <h2 class="title_card">
                            {{ $post->title }}
                            <i class="ri-arrow-right-up-line"></i>
                        </h2>
                        <p class="subtitle">{{ $post->sub_title }}</p>
                        <div class="tags">
                            <span class="tag">{{ $post->category->name ?? 'Uncategorized' }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    @include('components.banner')
    @include('components.allposts')
  
