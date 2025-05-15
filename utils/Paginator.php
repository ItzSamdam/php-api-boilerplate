<?php

namespace Utils;

class Paginator
{
    private $data;
    private $totalItems;
    private $itemsPerPage;
    private $currentPage;
    private $totalPages;

    public function __construct(array $data, $itemsPerPage = 10, $currentPage = 1)
    {
        $this->data = $data;
        $this->totalItems = count($data);
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = max(1, $currentPage); // Ensure current page is at least 1
        $this->totalPages = ceil($this->totalItems / $this->itemsPerPage);
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function getPageData()
    {
        $start = ($this->currentPage - 1) * $this->itemsPerPage;
        return array_slice($this->data, $start, $this->itemsPerPage);
    }

    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    public function hasNextPage()
    {
        return $this->currentPage < $this->totalPages;
    }

    public function getPreviousPage()
    {
        return $this->hasPreviousPage() ? $this->currentPage - 1 : null;
    }

    public function getNextPage()
    {
        return $this->hasNextPage() ? $this->currentPage + 1 : null;
    }
}
