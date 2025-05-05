<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\User;
use App\Mail\VoucherIssuedMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AdminVoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::query();

        // Get eager loaded relationship with issued to user
        $query->with(['issuedTo' => function($query) {
            $query->select('id', 'first_name', 'last_name', 'email');
        }]);

        // Filter by intern name
        if ($request->filled('user')) {
            $query->whereHas('issuedTo', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->user . '%')
                  ->orWhere('last_name', 'like', '%' . $request->user . '%');
            });
        }

        // Filter by used status
        if ($request->filled('used')) {
            $query->where('used', $request->used == '1');
        }

        // Get interns for dropdowns
        $interns = User::where('role_id', 3)->orderBy('first_name')->get();
        
        // Paginate results
        $vouchers = $query->latest()->paginate(10)->withQueryString();
        
        // Get counts for statistics
        $totalVouchers = $vouchers->total();
        $availableVouchers = Voucher::where('used', false)->count();
        $usedVouchers = Voucher::where('used', true)->count();
        
        return view('admin.vouchers.index', compact('vouchers', 'interns', 'totalVouchers', 'availableVouchers', 'usedVouchers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:vouchers,code',
            'provider' => 'required|string|max:100',
            'issued_to_id' => 'nullable|exists:users,id',
            'issued_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'send_email' => 'nullable|boolean',
        ]);

        // Set default values
        $data['used'] = false;
        $data['used_at'] = null;
        
        // Format issued_at date if provided
        if (!empty($data['issued_at'])) {
            $data['issued_at'] = Carbon::parse($data['issued_at']);
        } else {
            $data['issued_at'] = now();
        }

        // Extract send_email flag and remove from data
        $sendEmail = isset($data['send_email']) ? $data['send_email'] : false;
        unset($data['send_email']);

        // Create the voucher
        $voucher = Voucher::create($data);

        // Send email notification if requested and issued_to_id is set
        if ($sendEmail && $voucher->issued_to_id) {
            $emailSent = $this->sendVoucherEmail($voucher);
            // dd($emailSent);
            // Record that email was sent
            if ($emailSent) {
                
                return redirect()->route('admin.vouchers.index')
                    ->with('success', 'Voucher created successfully and email notification sent to ' . 
                        $voucher->issuedTo->first_name . ' ' . $voucher->issuedTo->last_name . '.');
            }
        }

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher created successfully.');
    }

    public function update(Request $request, Voucher $voucher)
    {
        // Prevent editing used vouchers
        if ($voucher->used) {
            return redirect()->back()->with('error', 'You cannot edit a used voucher.');
        }

        $data = $request->validate([
            'code' => 'required|string|max:255|unique:vouchers,code,' . $voucher->id,
            'provider' => 'required|string|max:100',
            'issued_to_id' => 'nullable|exists:users,id',
            'issued_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'send_email' => 'nullable|boolean',
        ]);

        // Extract send_email flag and remove from data
        $sendEmail = isset($data['send_email']) ? $data['send_email'] : false;
        unset($data['send_email']);

        // Store old issued_to_id to check if it changed
        $oldIssuedToId = $voucher->issued_to_id;

        // Format issued_at date if provided
        if (!empty($data['issued_at'])) {
            $data['issued_at'] = Carbon::parse($data['issued_at']);
        }

        // Update the voucher
        $voucher->update($data);

        // Send email notification if requested and issued_to_id is set 
        // and either the voucher was newly assigned or assigned to a different intern
        if ($sendEmail && $voucher->issued_to_id && ($oldIssuedToId === null || $oldIssuedToId !== $voucher->issued_to_id)) {
            $emailSent = $this->sendVoucherEmail($voucher);
            
            // Record that email was sent
            if ($emailSent) {
                
                return redirect()->route('admin.vouchers.index')
                    ->with('success', 'Voucher updated successfully and email notification sent to ' . 
                        $voucher->issuedTo->first_name . ' ' . $voucher->issuedTo->last_name . '.');
            }
        }

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher updated successfully.');
    }

    public function destroy(Voucher $voucher)
    {
        // Check if voucher is in use
        if ($voucher->used) {
            return redirect()->route('admin.vouchers.index')->with('error', 'Used vouchers cannot be deleted.');
        }
        
        // Check if voucher is assigned to any intern certificate
        $isInUse = $voucher->internCertificates()->exists();
        
        if ($isInUse) {
            return redirect()->route('admin.vouchers.index')->with('error', 'This voucher is currently assigned to an intern certificate and cannot be deleted.');
        }
        
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher deleted successfully.');
    }

    /**
     * Send email notification to intern about issued voucher
     */
    protected function sendVoucherEmail(Voucher $voucher)
    {
        try {
            // Ensure the voucher has an assigned intern with an email
            if ($voucher->issuedTo && $voucher->issuedTo->email) {
                Mail::to($voucher->issuedTo->email)
                    ->send(new VoucherIssuedMail($voucher));
                
                // Log or indicate success
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to send voucher email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Manually send email notification for an existing voucher
     */
    public function sendEmail(Voucher $voucher)
    {
        // Check if voucher is assigned to an intern
        if (!$voucher->issued_to_id) {
            return redirect()->route('admin.vouchers.index')
                ->with('error', 'Cannot send email for voucher that is not assigned to an intern.');
        }

        // Check if voucher is used
        if ($voucher->used) {
            return redirect()->route('admin.vouchers.index')
                ->with('error', 'Cannot send email for a used voucher.');
        }

        $success = $this->sendVoucherEmail($voucher);

        if ($success) {
            
            return redirect()->route('admin.vouchers.index')
                ->with('success', 'Voucher notification email sent successfully to ' . $voucher->issuedTo->first_name . ' ' . $voucher->issuedTo->last_name . '.');
        } else {
            return redirect()->route('admin.vouchers.index')
                ->with('error', 'Failed to send voucher notification email. Please check logs for details.');
        }
    }
    
    /**
     * Display confirmation page before resending email notification
     */
    public function confirmResendEmail(Voucher $voucher)
    {
        // Check if voucher can have email sent
        if (!$voucher->issued_to_id || $voucher->used) {
            return redirect()->route('admin.vouchers.index')
                ->with('error', 'Cannot resend email for this voucher.');
        }
        
        return view('admin.vouchers.confirm-resend', compact('voucher'));
    }
}