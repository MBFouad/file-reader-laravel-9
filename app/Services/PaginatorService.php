<?php

namespace App\Services;

use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PaginatorService extends AbstractPaginator
{
    /**
     * @var int
     */
    private $totalItems;

    /**
     * @var array
     */
    private $parameters;


    /**
     * Create a new paginator instance.
     *
     * @param  mixed $items
     * @param  int $perPage
     * @param  int|null $currentPage
     * @return void
     */
    public function __construct($items, $perPage, $currentPage = null, $totalItems = 0)
    {
        $this->perPage = $perPage;
        $this->setCurrentPage($currentPage);
        $this->path = $this->path !== '/' ? rtrim($this->path, '/') : $this->path;
        $this->totalItems = $totalItems;

        $this->setItems($items);
    }


    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items instanceof Collection ? $items : Collection::make($items);
        $this->hasMore = $this->totalItems > $this->perPage;

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function links($view = 'bootstrap-links-5')
    {
        return view($view, ['paginator' => $this]);
    }

    /**
     * @param int $currentPage
     * @return $this
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasMorePages(): bool
    {
        return $this->totalItems > ($this->perPage * ($this->currentPage + 1));
    }

    /**
     * Get the URL for the next page.
     *
     * @return string|null
     */
    public function nextPageUrl()
    {
        if ($this->hasMorePages()) {
            return $this->url($this->currentPage() + 1);
        }
    }

    /**
     * Get the URL for the first page.
     *
     * @return string|null
     */
    public function firstPageUrl()
    {
        return $this->url(1);
    }

    /**
     * Get the URL for the last page.
     *
     * @return string|null
     */
    public function lastPageUrl()
    {
        return $this->url(floor($this->totalItems / $this->perPage));
    }
}