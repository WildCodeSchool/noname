<?php

namespace App\Utils;

/**
 * Helper class who represent a search input for products.
 */
class ProductSearchTerms
{
    private int $page = 1;
    private ?string $search = null;
    private ?int $categoryId = null;

    /**
     * Will use a template `%page%` during the export of URL parameters
     *
     * @var boolean
     */
    private bool $usedForURLTemplate = false;

    /**
     * Convert the terms to parameters for the URL
     *
     * @return string
     */
    public function toURLParameters(): string
    {
        $params = [];

        if ($this->usedForURLTemplate) {
            $params[] = "page=%page%";
        } elseif ($this->page !== 1) {
            $page = max(1, $this->page);
            $params[] = "page=$page";
        }

        if (!is_null($this->search)) {
            $search = urlencode($this->search);
            $params[] = "search=$search";
        }

        if (!is_null($this->categoryId)) {
            $params[] = "category=$this->categoryId";
        }

        return join("&", $params);
    }

    /**
     * Convert the terms to a SQL `WHERE` clause.
     *
     * @return string
     */
    public function toSQLWhereClause(): string
    {
        $query = "";

        if ($this->search || $this->categoryId) {
            $whereClause = [];

            if ($this->search) {
                $whereClause[] = "(title LIKE :search OR description LIKE :search)";
            }

            if ($this->categoryId) {
                $whereClause[] = "category_item_id = :category_item_id";
            }

            $query .= join(" AND ", $whereClause);
        }

        return $query;
    }

    /**
     * Create a `ProductSearchTerms` with the parameters passed in the URL.
     *
     * @return self
     */
    public static function fromURLParameters(): self
    {
        $terms = new self();

        if (isset($_GET["page"]) && filter_var($_GET["page"], FILTER_VALIDATE_INT)) {
            $terms->setPage(max(1, $_GET["page"]));
        }
        $terms->setSearch($_GET["search"] ?? null);
        if (isset($_GET["category"]) && filter_var($_GET["category"], FILTER_VALIDATE_INT)) {
            $terms->setCategoryId($_GET["category"]);
        }

        return $terms;
    }

    /*
     *  GETTERS AND SETTERS
     */
    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): self
    {
        if (is_null($search)) {
            $search = null;
        } else {
            $search = trim($search);
        }

        if ($search !== "") {
            $this->search = $search;
        } else {
            $this->search = null;
        }

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function isUsedForURLTemplate(): bool
    {
        return $this->usedForURLTemplate;
    }

    public function setUsedForURLTemplate(bool $usedForURLTemplate): self
    {
        $this->usedForURLTemplate = $usedForURLTemplate;

        return $this;
    }
}
