<?php

namespace App\Utils;

class ProductSearchTerms
{
    private int $page = 1;
    private ?string $search = null;
    private ?int $categoryId = null;

    private bool $usedForURLTemplate = false;

    public function toURLParameters(): string
    {
        $params = [];

        if ($this->usedForURLTemplate) {
            $params[] = "page=%page%";
        } elseif ($this->page !== 1) {
            $params[] = "page=$this->page";
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

    public static function fromURLParameters(): self
    {
        $terms = new self();

        if (isset($_GET["page"]) && filter_var($_GET["page"], FILTER_VALIDATE_INT)) {
            $terms->setPage($_GET["page"]);
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
        if (trim($search) !== "") {
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
