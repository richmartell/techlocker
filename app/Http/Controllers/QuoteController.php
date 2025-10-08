<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function downloadPdf(Quote $quote)
    {
        // Load relationships
        $quote->load(['customer', 'vehicle', 'items', 'account']);
        
        // Check authorization - user must own this quote
        if ($quote->account_id !== auth()->user()->account_id) {
            abort(403);
        }
        
        // Generate PDF
        $pdf = Pdf::loadView('quotes.pdf', [
            'quote' => $quote,
        ]);
        
        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');
        
        // Download with a nice filename
        $filename = 'quote-' . $quote->quote_number . '.pdf';
        
        return $pdf->download($filename);
    }
}
