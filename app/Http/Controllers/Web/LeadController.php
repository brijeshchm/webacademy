<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeadController as ApiLeadController;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Server-rendered lead intake for the public Blade forms (contact, enquiry,
 * scholarship, corporate-training).
 *
 * Mirrors the API LeadController@store validation, persists the lead, reuses
 * the same email notification pipeline, then redirects back with a success
 * flash so the page can render its success state without JS.
 *
 * The message body is composed server-side to be byte-for-byte identical to
 * what the React pages built client-side (so source detection + notifications
 * behave the same), using a hidden `form_type` discriminator.
 */
class LeadController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'courseSlug'     => 'nullable|string|max:255',
            'course_slug'    => 'nullable|string|max:255',
            'message'        => 'nullable|string|max:5000',
            // Optional per-form fields folded into the message body.
            'form_type'      => 'nullable|string|max:32',
            'courseInterest' => 'nullable|string|max:255',
            'lastEducation'  => 'nullable|string|max:255',
            'percentage'     => 'nullable|string|max:20',
            'cgpa'           => 'nullable|string|max:20',
            'company'        => 'nullable|string|max:255',
            'teamSize'       => 'nullable|string|max:255',
            'goals'          => 'nullable|string|max:5000',
            'timeline'       => 'nullable|string|max:255',
            'program'        => 'nullable|string|max:255',
        ]);

        $courseSlug = $validated['courseSlug'] ?? $validated['course_slug'] ?? null;
        $message = $this->composeMessage($validated);

        $lead = Lead::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'] ?? null,
            'course_slug' => $courseSlug,
            'message'     => $message,
        ]);

        // Reuse the API controller's source detection + notification pipeline.
        app(ApiLeadController::class)->notifyForLead($lead);

        $fragment = $request->input('form_type') === 'scholarship' ? 'apply' : null;

        $redirect = redirect()->back()->with('success', true);

        return $fragment ? $redirect->withFragment($fragment) : $redirect;
    }

    /**
     * Build the stored message body identically to the React pages.
     *
     * @param  array<string,mixed>  $data
     */
    private function composeMessage(array $data): ?string
    {
        $type = $data['form_type'] ?? null;
        $trim = static fn ($v) => is_string($v) ? trim($v) : '';

        if ($type === 'enquiry') {
            $parts = array_filter([
                $trim($data['courseInterest'] ?? '') !== '' ? 'Course interest: ' . $trim($data['courseInterest']) : '',
                $trim($data['message'] ?? ''),
            ], fn ($p) => $p !== '');

            return $parts ? implode("\n\n", $parts) : null;
        }

        if ($type === 'scholarship') {
            $parts = array_filter([
                'Scholarship Application',
                'Last Highest Education: ' . $trim($data['lastEducation'] ?? ''),
                $trim($data['percentage'] ?? '') !== '' ? 'Percentage: ' . $trim($data['percentage']) . '%' : '',
                $trim($data['cgpa'] ?? '') !== '' ? 'CGPA: ' . $trim($data['cgpa']) : '',
                $trim($data['courseInterest'] ?? '') !== '' ? 'Course Interest: ' . $trim($data['courseInterest']) : '',
                $trim($data['message'] ?? '') !== '' ? 'Statement: ' . $trim($data['message']) : '',
            ], fn ($p) => $p !== '');

            return implode(' | ', $parts);
        }

        if ($type === 'corporate') {
            return implode("\n", [
                'Company: ' . ($data['company'] ?? ''),
                'Team size: ' . ($data['teamSize'] ?? ''),
                'Goals: ' . ($data['goals'] ?? ''),
                'Timeline: ' . ($data['timeline'] ?? ''),
                'Program context: ' . ($data['program'] ?? ''),
            ]);
        }

        // Default (contact): plain message.
        $msg = $trim($data['message'] ?? '');

        return $msg !== '' ? $msg : null;
    }
}
