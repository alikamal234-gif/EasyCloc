<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRaquest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function market(PaymentRaquest $request)
    {
        $data = $request->validated();
        $data['paid_at'] = now();
        Payment::create($data);
        return redirect()->back();
    }

    
    
}
