<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = auth()->user()->categories()->latest()->get();

        if (config('is_mobile')) {
            return view('mobile.categories', compact('categories'));
        }

        return view('categories.index', compact('categories'));
    }

    public function create(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->isFree() && $user->categories()->count() >= \App\Models\User::FREE_MAX_CATEGORIES) {
            return redirect()->route('categories.index')
                ->with('upgrade_required', 'Batas kategori tercapai. Upgrade ke Premium untuk kategori tidak terbatas.');
        }

        if (config('is_mobile')) {
            return view('mobile.category-form');
        }
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user->isFree()) {
            if ($user->categories()->count() >= \App\Models\User::FREE_MAX_CATEGORIES) {
                return redirect()->route('categories.index')
                    ->with('upgrade_required', 'Akun gratis hanya bisa membuat ' . \App\Models\User::FREE_MAX_CATEGORIES . ' kategori. Upgrade ke Premium untuk kategori tidak terbatas.');
            }
        }

        $user->categories()->create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        $this->authorize('update', $category);

        if (config('is_mobile')) {
            return view('mobile.category-form', compact('category'));
        }

        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);

        $category->update($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}