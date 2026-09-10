<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // 1. Halaman Dashboard (Ringkasan, 5 Transaksi Terakhir, & Data Kalender)
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $baseQuery = Transaction::with('user');
        } else {
            $baseQuery = Transaction::where('user_id', $user->id);
        }

        // Ambil semua transaksi untuk dipetakan ke kalender
        $allTransactions = (clone $baseQuery)->get();
        
        // Ambil 5 transaksi terbaru saja untuk ringkasan
        $transactions = (clone $baseQuery)->latest()->take(5)->get();

        // Hitung total finansial
        $totalPemasukan = (clone $baseQuery)->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = (clone $baseQuery)->where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Grouping data transaksi berdasarkan tanggal (YYYY-MM-DD) untuk kalender
        $events = [];
        foreach ($allTransactions as $t) {
            $tgl = date('Y-m-d', strtotime($t->tanggal));
            $events[$tgl][] = [
                'jenis' => $t->jenis,
                'jumlah' => number_format($t->jumlah, 0, ',', '.'),
                'kategori' => $t->kategori,
                'catatan' => $t->catatan ?? '-',
                'user' => $t->user->name ?? ''
            ];
        }

        return view('finora.dashboard', compact('transactions', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'events'));
    }

    // 2. Halaman Form Tambah Transaksi
    public function create()
    {
        return view('finora.create');
    }

    // 3. Halaman Riwayat Transaksi Lengkap
    public function history()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $transactions = Transaction::with('user')->latest()->paginate(10);
        } else {
            $transactions = Transaction::where('user_id', $user->id)->latest()->paginate(10);
        }

        return view('finora.history', compact('transactions'));
    }

    // Proses Simpan Transaksi Baru
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        Transaction::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return redirect()->route('dashboard')->with('success', 'Catatan Finora berhasil ditambah~!');
    }

    // Halaman Edit Transaksi
    public function edit(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        return view('finora.edit', compact('transaction'));
    }

    // Proses Update Transaksi
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $transaction->update($request->validate($this->rules()));

        return redirect()->route('transactions.history')->with('success', 'Catatan Finora berhasil diperbarui~!');
    }

    private function rules(): array
    {
        return [
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric',
            'kategori' => 'required|string',
            'catatan' => 'nullable|string',
            'tanggal' => 'required|date',
        ];
    }

    private function authorizeTransaction(Transaction $transaction): void
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $transaction->user_id !== $user->id) {
            abort(403);
        }
    }
}
