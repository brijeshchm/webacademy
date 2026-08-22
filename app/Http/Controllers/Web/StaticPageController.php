<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\View\View;

/**
 * Server-rendered marketing/static pages: about, contact, enquiry,
 * scholarship, corporate-training. Data comes from Eloquent models directly
 * (mirroring the API controllers) — no HTTP round-trips.
 */
class StaticPageController extends Controller
{
    public function about(): View
    {
        // Mirrors StatsController@index shape used by the React About page.
        $stats = [
            'careersTransformed' => 65000,
            'expertTrainers'     => 800,
            'workshopsPerMonth'  => 250,
            'countries'          => 100,
            'totalCourses'       => Course::count(),
            'averageRating'      => 4.8,
        ];

        return view('pages.about', compact('stats'));
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function enquiry(): View
    {
        return view('pages.enquiry', $this->courseSelectData());
    }

    public function scholarship(): View
    {
        return view('pages.scholarship', $this->courseSelectData());
    }

    /**
     * Course titles plus a batched original => translated map for the
     * <select> labels (one translations-table query per request).
     *
     * @return array{courses:\Illuminate\Support\Collection<int,string>,courseLabels:array<string,string>}
     */
    private function courseSelectData(): array
    {
        $titles = $this->courseTitles();
        $translated = \App\Services\ServerTranslator::translateMany($titles->all());
        $labels = [];
        foreach (array_values($titles->all()) as $i => $title) {
            $labels[$title] = $translated[$i] ?? $title;
        }

        return ['courses' => $titles, 'courseLabels' => $labels];
    }

    public function corporateTraining(): View
    {
        return view('pages.corporate-training');
    }

    /**
     * Course titles for the enquiry/scholarship <select>. The React forms send
     * the course *title* as the selected value, so we key by title and label by
     * title (translated for non-English locales at render time in the view).
     *
     * @return \Illuminate\Support\Collection<int,string>
     */
    private function courseTitles()
    {
        return Course::orderBy('title')->pluck('title');
    }
}
