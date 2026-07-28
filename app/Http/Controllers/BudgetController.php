<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (auth()->user()->isFree()) {
            return redirect()->route('premium.upgrade')
                ->with('upgrade_required', 'Fitur Budget hanya tersedia untuk pengguna Premium.');
        }

        $user    = auth()->user();
        $budgets = $user->budgets()->with('category')->get()->map(function ($budget) {
            $budget->spent   = $budget->spentThisMonth();
            $budget->percent = $budget->spentPercent();
            $budget->status  = $budget->status();
            return $budget;
        });

        $usedCategoryIds     = $budgets->pluck('category_id')->toArray();
        $availableCategories = $user->categories()
            ->where('type', 'expense')
            ->whereNotIn('id', $usedCategoryIds)
            ->get();

        if (config('is_mobile')) {
            return view('mobile.budgets', compact('budgets', 'availableCategories'));
        }

        return view('budgets.index', compact('budgets', 'availableCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->isFree()) {
            return redirect()->route('premium.upgrade')
                ->with('upgrade_required', 'Fitur Budget hanya tersedia untuk pengguna Premium.');
        }

        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'amount'      => ['required', 'numeric', 'min:1000'],
            'period'      => ['required', 'in:monthly,yearly'],
        ]);

        // Pastikan kategori milik user & tipe expense
        $category = auth()->user()->categories()
            ->where('id', $request->category_id)
            ->where('type', 'expense')
            ->firstOrFail();

        Budget::updateOrCreate(
            [
                'user_id'     => auth()->id(),
                'category_id' => $category->id,
                'period'      => $request->period,
            ],
            ['amount' => $request->amount]
        );

        return redirect()->route('budgets.index')
            ->with('success', 'Budget berhasil disimpan.');
    }

    public function destroy(Budget $budget): RedirectResponse
    {
        $this->authorize('delete', $budget);
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget berhasil dihapus.');
    }
}