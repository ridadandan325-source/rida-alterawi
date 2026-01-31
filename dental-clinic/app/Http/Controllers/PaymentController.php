<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['invoice.patient'])->latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $invoice_id = $request->get('invoice_id');
        $invoice = null;
        if ($invoice_id) {
            $invoice = Invoice::find($invoice_id);
        }
        $invoices = Invoice::where('status', '!=', 'paid')->get();
        return view('payments.create', compact('invoices', 'invoice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $payment = Payment::create($validated);

        // Update Invoice stats
        $invoice = $payment->invoice;
        $invoice->paid_amount += $payment->amount;
        if ($invoice->paid_amount >= $invoice->total_amount) {
            $invoice->status = 'paid';
        } else {
            $invoice->status = 'partial';
        }
        $invoice->save();

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'تم تسجيل الدفعة بنجاح');
    }
}
