@if ($paginator->hasPages())
<div class="paging text-center">
    <ul class="pagination justify-content-center" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true">
                    <span class="d-block d-md-none">&lsaquo;</span>
                    <span class="d-none d-md-block"><i class="icon icon-arrow-left"></i></span>
                </span>
            </li>
        @else
            <li>
                <a wire:click="previousPage" rel="prev" aria-label="@lang('pagination.previous')">
                    <span class="d-block d-md-none">&lsaquo;</span>
                    <span class="d-none d-md-block"><i class="icon icon-arrow-left"></i></span>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled d-none d-md-block" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active d-none d-md-block" aria-current="page"><span>{{ $page }}</span></li>
                    @else
                        <li class="d-none d-md-block"><a wire:click="gotoPage({{ $page }})">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a wire:click="nextPage" rel="next" aria-label="@lang('pagination.next')">
                    <span class="d-none d-md-block"><i class="icon icon-arrow-right"></i></span>
                    <span class="d-block d-md-none">&rsaquo;</span>
                </a>
            </li>
        @else
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true">
                    <span class="d-none d-md-block"><i class="icon icon-arrow-right"></i></span>
                    <span class="d-block d-md-none">&rsaquo;</span>
                </span>
            </li>
        @endif
    </ul>
</div>
@endif