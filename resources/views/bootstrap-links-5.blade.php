@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill">
            <ul class="pagination">
                {{-- First Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">First Page</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link ajax-pagination-link" href="{{ $paginator->firstPageUrl() }}"
                           rel="prev">First Page</a>
                    </li>
                @endif


                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link ajax-pagination-link" href="{{ $paginator->previousPageUrl() }}"
                           rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link ajax-pagination-link" href="{{ $paginator->nextPageUrl() }}"
                           rel="next">@lang('pagination.next')</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link ajax-pagination-link" href="{{ $paginator->lastPageUrl() }}"
                           rel="next">Last Page</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Last Page</span>
                    </li>
                @endif

            </ul>
        </div>
    </nav>
@endif
