<?php

namespace App\Utils;

class ProductSearchTerms
{
    private int $page = 1;
    private ?string $search = null;
    private ?array $categoryIds = null;
    private ?array $materials = null;

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

        if (!is_null($this->categoryIds)) {
            $ids = join(",", $this->categoryIds);
            $params[] = "categories=$ids";
        }

        if (!is_null($this->materials)) {
            $materials = join(",", $this->materials);
            $params[] = "materials=$materials";
        }

        return join("&", $params);
    }

    public static function fromURLParameters(): self
    {
        $terms = new self();

        $terms->setPage($_GET["page"] ?? 1);
        $terms->setSearch($_GET["search"] ?? null);
        $terms->setCategoryIds($_GET["categories"] ?? null);
        $terms->setMaterials($_GET["materials"] ?? null);

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
        $this->search = $search;

        return $this;
    }

    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }

    public function setCategoryIds(?array $categoryIds): self
    {
        $this->categoryIds = $categoryIds;

        return $this;
    }

    public function getMaterials(): ?array
    {
        return $this->materials;
    }

    public function setMaterials(?array $materials): self
    {
        $this->materials = $materials;

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
