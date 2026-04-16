<?php
declare(strict_types=1);

/*
 * This file is part of the package web-tp3/tp3-businessview.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Tp3\Tp3Businessview\Domain\Model\Dto;

/**
 * This file is part of the "tt_address" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class Demand
{

    /** @var array */
    protected array $pages = [];

    /** @var string */
    protected string $sortBy = '';

    /** @var string */
    protected string $sortOrder = '';

    /** @var string */
    protected string $categories = '';

    /** @var bool */
    protected bool $includeSubCategories = false;

    /** @var string */
    protected string $categoryCombination = '';

    /** @var string */
    protected string $singleRecords = '';

    /** @var bool */
    protected bool $ignoreWithoutCoordinates = false;

    /**
     * @return array
     */
    public function getPages(): array
    {
        return $this->pages;
    }

    /**
     * @param array $pages
     */
    public function setPages(array $pages): void
    {
        $this->pages = $pages;
    }

    /**
     * @return string
     */
    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    /**
     * @param string $sortBy
     */
    public function setSortBy(string $sortBy): void
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @return string
     */
    public function getSortOrder(): string
    {
        return $this->sortOrder;
    }

    /**
     * @param string $sortOrder
     */
    public function setSortOrder(string $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return string
     */
    public function getCategories(): string
    {
        return $this->categories;
    }

    /**
     * @param string $categories
     */
    public function setCategories(string $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return bool
     */
    public function getIncludeSubCategories(): bool
    {
        return $this->includeSubCategories;
    }

    /**
     * @param bool $includeSubCategories
     */
    public function setIncludeSubCategories(bool $includeSubCategories): void
    {
        $this->includeSubCategories = $includeSubCategories;
    }

    /**
     * @return string
     */
    public function getCategoryCombination(): string
    {
        return $this->categoryCombination;
    }

    /**
     * @param string $categoryCombination
     */
    public function setCategoryCombination(string $categoryCombination): void
    {
        $this->categoryCombination = $categoryCombination;
    }

    /**
     * @return string
     */
    public function getSingleRecords(): string
    {
        return $this->singleRecords;
    }

    /**
     * @param string $singleRecords
     */
    public function setSingleRecords(string $singleRecords): void
    {
        $this->singleRecords = $singleRecords;
    }

    /**
     * @return bool
     */
    public function getIgnoreWithoutCoordinates(): bool
    {
        return $this->ignoreWithoutCoordinates;
    }

    /**
     * @param bool $ignoreWithoutCoordinates
     */
    public function setIgnoreWithoutCoordinates(bool $ignoreWithoutCoordinates): void
    {
        $this->ignoreWithoutCoordinates = $ignoreWithoutCoordinates;
    }
}
