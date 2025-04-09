<?php

namespace App\Http\Controllers;

use App\Models\GamesPackage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only([
            'create',
            'store',
            'checkout',
            'history',
            'success',
        ]);
    }


    public function create($id)
    {
        $package = GamesPackage::findOrFail($id);
        $transactions = Transaction::where('user_id', auth()->id())
                                 ->with(['gamesPackage.game'])
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(10);

        return view('transactions.create', compact('package', 'transactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:games_packages,id',
            'game_username' => 'required|string',
            'game_user_id' => 'nullable|string',
            'game_server' => 'nullable|string',
        ]);

        $package = GamesPackage::findOrFail($validated['package_id']);
        $user = auth()->user();

        // Calculate discount if user has active membership
        $discount = 0;
        $activeMembership = $user->memberships()->wherePivot('is_active', true)->first();
        if ($activeMembership) {
            $discount = $package->price * ($activeMembership->discount_percentage / 100);
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'games_package_id' => $package->id,
            'transaction_id' => 'TRX-' . Str::random(10),
            'game_username' => $validated['game_username'],
            'game_user_id' => $validated['game_user_id'],
            'game_server' => $validated['game_server'],
            'amount' => $package->price,
            'discount_amount' => $discount,
            'total_amount' => $package->price - $discount,
            'status' => 'pending',
        ]);

        // Integration with Midtrans will be added later
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaction->transaction_id, // Gunakan ini!
                'gross_amount' => $transaction->total_amount,
            ),
            'customer_details' => array(
                'first_name' => $user->name,
                'email' => $user->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction->snap_token = $snapToken;
        $transaction->save();

        // Get transactions for view
        $transactions = Transaction::where('user_id', auth()->id())
                                 ->with(['gamesPackage.game'])
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(10);

        // Redirect ke halaman checkout setelah transaksi dibuat
        return redirect()->route('transactions.checkout')->with('transaction', $transaction);
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();
        $transactions = Transaction::where('user_id', $user->id)
                                 ->where('status', 'pending')
                                 ->with(['gamesPackage.game'])
                                 ->get();

        if ($transactions->isEmpty()) {
            return redirect()->route('home')->with('error', 'Tidak ada transaksi yang perlu dibayar');
        }

        return view('transactions.checkout', compact('transactions'));
    }

    public function history()
    {
        // Hanya menampilkan transaksi untuk user yang sedang login
        $transactions = Transaction::where('user_id', auth()->id())
                                 ->with(['gamesPackage.game'])
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(10);

        return view('transactions.history', compact('transactions'));
    }

    public function success(Request $request)
    {
        // Update status transaksi berdasarkan response dari Midtrans
        $transaction = Transaction::where('snap_token', $request->snap_token)
                                ->where('user_id', auth()->id())
                                ->first();

        if ($transaction) {
            if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture' || $request->transaction_status == 'pending') {
                // Update status transaksi dari pending ke success jika pembayaran berhasil
                // Jika status masih pending tapi sudah dibayar, tetap update ke success
                Transaction::where('id', $transaction->id)
                          ->update(['status' => 'success', 'payment_status' => 'success']);
                          
                return redirect()->route('transactions.history')->with('success', 'Pembayaran berhasil!');
            } else if ($request->transaction_status == 'deny' || $request->transaction_status == 'expire' || $request->transaction_status == 'cancel') {
                $transaction->status = 'failed';
                $transaction->payment_status = 'failed'; 
                $transaction->save();
                return redirect()->route('transactions.history')->with('error', 'Pembayaran gagal!');
            }
        }

        return redirect()->route('transactions.history')->with('error', 'Transaksi tidak ditemukan!');
    }

    public function callback(Request $request)
    {
        $payload = $request->all();
        \Log::info('🔁 Callback Payload:', $payload);

        $serverKey = config('midtrans.serverKey');

        $expectedSignature = hash('sha512',
            $payload['order_id'] .
            $payload['status_code'] .
            $payload['gross_amount'] .
            $serverKey
        );

        if ($payload['signature_key'] !== $expectedSignature) {
            \Log::warning('❌ Invalid Signature');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::where('transaction_id', $payload['order_id'])->first();

        if (!$transaction) {
            \Log::warning('🚫 Transaction Not Found');
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if (in_array($payload['transaction_status'], ['settlement', 'capture'])) {
            $transaction->update([
                'status' => 'success',
                'payment_status' => 'success'
            ]);
            \Log::info('✅ Transaksi sukses diupdate');
        } elseif (in_array($payload['transaction_status'], ['deny', 'expire', 'cancel'])) {
            $transaction->update([
                'status' => 'failed',
                'payment_status' => 'failed'
            ]);
            \Log::info('❌ Transaksi gagal diupdate');
        }

        return response()->json(['message' => 'Callback handled'], 200);
    }
}
