<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    protected function resolveRange(Request $request): array
    {
        $periodType = $request->get('period_type', 'monthly');

        if ($periodType === 'yearly') {
            $year = $request->get('year', now()->year);
            $start = Carbon::create($year, 1, 1)->startOfDay();
            $end = Carbon::create($year, 12, 31)->endOfDay();
            $label = "Tahun {$year}";
        } elseif ($periodType === 'custom') {
            $start = Carbon::parse($request->get('from_date', now()->startOfMonth()))->startOfDay();
            $end = Carbon::parse($request->get('to_date', now()->endOfMonth()))->endOfDay();
            $label = $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y');
        } else {
            $month = $request->get('month', now()->month);
            $year = $request->get('year', now()->year);
            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end = Carbon::create($year, $month, 1)->endOfMonth();
            $label = $start->translatedFormat('F Y');
        }

        return [$periodType, $start, $end, $label];
    }

    protected function getReportData(Request $request): array
    {
        [$periodType, $start, $end, $label] = $this->resolveRange($request);

        $transactions = auth()->user()->transactions()
            ->with(['account', 'category'])
            ->whereBetween('transaction_date', [$start, $end])
            ->orderBy('transaction_date')
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        return [
            'transactions' => $transactions,
            'summary' => [
                'total_income' => $totalIncome,
                'total_expense' => $totalExpense,
                'net' => $totalIncome - $totalExpense,
            ],
            'periodType' => $periodType,
            'periodLabel' => $label,
            'start' => $start,
            'end' => $end,
        ];
    }

    public function index(Request $request): View
    {
        $data = $this->getReportData($request);

        return view('reports.index', $data);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);

        $pdf = Pdf::loadView('reports.pdf', $data);

        return $pdf->download('laporan-' . str($data['periodLabel'])->slug() . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getReportData($request);

        $filename = 'laporan-' . str($data['periodLabel'])->slug() . '.xlsx';

        return Excel::download(new TransactionsExport($data['transactions'], $data['summary']), $filename);
    }
}