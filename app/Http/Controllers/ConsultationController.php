<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    /**
     * Tampilkan halaman konsultasi.
     */
    public function index()
    {
        return view('pages.consultation');
    }

    /**
     * Analisis skin story dan return traits (AJAX endpoint)
     * Route: POST /consultation/analyze
     */
    public function analyze(Request $request)
    {
        try {
            $validated = $request->validate([
                'skin_story' => ['required', 'string', 'min:10', 'max:2000'],
                'tags' => ['required', 'json'],
            ]);

            $traits = $this->inferTraitsFromStory(
                $validated['skin_story'],
                json_decode($validated['tags'], true)
            );

            return response()->json([
                'success' => true,
                'traits' => $traits,
                'message' => 'Analisis berhasil',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Consultation analyze error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menganalisis',
            ], 500);
        }
    }

    /**
     * Proses konsultasi lengkap setelah user confirm di modal
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'skin_story' => ['required', 'string', 'min:10', 'max:2000'],
                'tags' => ['required', 'json'],
                'traits' => ['required', 'json'], // AI-detected traits
                'concern_1' => ['nullable', 'string', 'max:50'],
                'concern_2' => ['nullable', 'string', 'max:50'],
                'preferences' => ['nullable', 'array'],
                'preferences.*' => ['string', 'max:50'],
            ]);

            // Decode JSON fields
            $tags = json_decode($validated['tags'], true);
            $traits = json_decode($validated['traits'], true);
            $preferences = $validated['preferences'] ?? [];

            // Simpan ke database
            $consultation = Consultation::create([
                'user_id' => auth()->id(),
                'skin_story' => $validated['skin_story'],
                'tags' => $tags,
                'detected_traits' => $traits,
                'concern_1' => $validated['concern_1'] ?? null,
                'concern_2' => $validated['concern_2'] ?? null,
                'preferences' => $preferences,
                'status' => 'pending',
            ]);

            Log::info('Consultation created', [
                'consultation_id' => $consultation->id,
                'user_id' => auth()->id(),
                'traits_count' => count($traits),
            ]);

            // TODO: Trigger background job untuk processing
            // Dispatch job untuk rule-based processing

            return redirect()->route('consultation.result', $consultation->id)
                ->with('success', '✨ Konsultasi diterima! Kami sedang menganalisis data Anda...');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Consultation validation failed', $e->errors());
            return back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Consultation store error: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan. Coba lagi.'])
                ->withInput();
        }
    }

    /**
     * Tampilkan hasil konsultasi
     */
    public function result($id)
    {
        $consultation = Consultation::findOrFail($id);

        // Verify user owns this consultation
        if ($consultation->user_id && $consultation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('pages.consultation-result', compact('consultation'));
    }

    /**
     * Lightweight inference engine (rule-based)
     * Ganti dengan API call ke Python/Node backend untuk ML model jika diperlukan
     */
    private function inferTraitsFromStory($text, $tags = [])
    {
        $lower = strtolower($text);
        $detected = [];

        $keywordMap = [
            'oily|t-zone|sebum|shiney' => 'Oily T-Zone',
            'dry|parched|tight|rough' => 'Dry Cheeks',
            'red|redness|inflam|irritat' => 'Redness',
            'sting|s3|irritat|reactive' => 'Sensitive (S3 Stinger)',
            'acne|breakout|pimple|spot' => 'Acne-Prone',
            'dark spot|pigment|hyperpig|melanin' => 'Dark Spots',
            'fine line|wrinkle|age|crease' => 'Fine Lines',
            'pore|enlarged|congested' => 'Enlarged Pores',
            'dehydrat|moisture|tight' => 'Dehydrated',
            'dull|lacklust|gray|uneven' => 'Dull Skin',
        ];

        foreach ($keywordMap as $keywords => $trait) {
            $keywordArray = array_map('trim', explode('|', $keywords));
            foreach ($keywordArray as $kw) {
                if (strpos($lower, $kw) !== false && !in_array($trait, $detected)) {
                    $detected[] = $trait;
                    break;
                }
            }
        }

        // Add manual tags
        foreach ($tags as $tag) {
            if (!in_array($tag, $detected)) {
                $detected[] = $tag;
            }
        }

        // Default if nothing found
        if (empty($detected)) {
            $detected[] = 'General Skin Concern';
        }

        // Return max 4 traits
        return array_slice($detected, 0, 4);
    }
}
