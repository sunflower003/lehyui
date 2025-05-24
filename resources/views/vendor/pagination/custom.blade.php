@if ($paginator->hasPages())
    <span class="previous">
        @if ($paginator->onFirstPage())
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg> Previous
        @else
            <a href="{{ $paginator->previousPageUrl() }}#allposts" class="prev_button">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg> --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg> Previous
            </a>
        @endif
    </span>

    <ul>
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="dot">{{ $element }}</li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="current">{{ $page }}</li>
                    @else
                        <li><a href="{{ $url }}#allposts" class="number_page_pagination">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
    </ul>

    <span class="after">
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}#allposts" class="next_button">
                Next <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
            </a>
        @else
            Next<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg></i>
        @endif
    </span>
@endif
