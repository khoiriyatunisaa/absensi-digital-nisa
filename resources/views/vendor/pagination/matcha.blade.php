@if ($paginator->hasPages())
    <nav class="pager" role="navigation" aria-label="Pagination">
        <p class="pager-info">
            Menampilkan {{ $paginator->firstItem() }}&ndash;{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </p>

        <ul class="pager-list">
            @if ($paginator->onFirstPage())
                <li><span class="pager-link is-disabled" aria-disabled="true" aria-label="Sebelumnya">&lsaquo;</span></li>
            @else
                <li><a class="pager-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">&lsaquo;</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="pager-gap">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="pager-link is-current" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a class="pager-link" href="{{ $url }}" aria-label="Halaman {{ $page }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a class="pager-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya">&rsaquo;</a></li>
            @else
                <li><span class="pager-link is-disabled" aria-disabled="true" aria-label="Berikutnya">&rsaquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
