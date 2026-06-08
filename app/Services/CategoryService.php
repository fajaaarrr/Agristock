<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    /**
     * Get paginated and filtered list of categories.
     */
    public function getPaginated(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        $query = Category::query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Create a new category.
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update an existing category.
     */
    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    /**
     * Delete a category.
     */
    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
