<?php

namespace App\Http\Controllers\Web;

use App\Data\Faqs;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LeadController;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseAbout;
use App\Models\Placement;
use App\Models\ToolsCovered;
use App\Models\CourseCurriculumExcel;
                   


use App\Services\ServerTranslator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Server-rendered /courses and /courses/{slug} pages. Data comes from the
 * Course / Category Eloquent models directly, mirroring the query behaviour
 * of the JSON API (CourseController@index / @show).
 */
class CoursesController extends Controller
{
    public function index(Request $request): View
    {
        $category = (string) $request->query('category', '');
        $search   = (string) $request->query('search', '');

        // Mirror CourseController@index LIKE filters.
        $query = Course::query();

        if ($category !== '') {
            $query->where('category_slug', $category);
        }

        if ($search !== '') {
            $term = '%' . $search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                  ->orWhere('summary', 'like', $term)
                  ->orWhere('category_name', 'like', $term)
                  ->orWhere('skills', 'like', $term);
            });
        }

        $courses = $query->orderBy('id')->get();

        // Match the API/React ordering (categories by insertion id, not name).
        $categories = Category::orderBy('id')->get();

        // ── Batch-translate ALL dynamic strings in ONE query ────────────
        // Collect course titles + Courses-FAQ questions/answers, resolve the
        // whole deduped set via a single translateMany() (one whereIn), and
        // hand the view a lookup map (+ derived arrays). The Blade template
        // does array lookups only — no ServerTranslator calls.
        $faqSource = Faqs::COURSES;

        $allStrings = array_merge(
            $courses->pluck('title')->all(),
            array_map(static fn ($f) => $f['question'], $faqSource),
            array_map(static fn ($f) => $f['answer'], $faqSource),
        );

        $translations = self::lookupMap(
            $allStrings,
            ServerTranslator::translateMany($allStrings)
        );

        $tDyn = static fn (?string $v): ?string => ($v !== null && isset($translations[$v])) ? $translations[$v] : $v;

        $translatedTitles = [];
        foreach ($courses as $course) {
            $translatedTitles[$course->id] = $tDyn($course->title);
        }


        $tools_list = ToolsCovered::get();

        // Courses FAQ — translated via the shared map.
        $coursesFaqs = array_map(static fn ($f) => [
            'question' => $tDyn($f['question']),
            'answer'   => $tDyn($f['answer']),
        ], $faqSource);

        return view('pages.courses', [
            'courses'          => $courses,
            'categories'       => $categories,
            'category'         => $category,
            'search'           => $search,
            'tools_list'       => $tools_list,
            'translatedTitles' => $translatedTitles,
            'coursesFaqs'      => $coursesFaqs,
        ]);
    }

    /**
     * Build an "original => translated" lookup map from two parallel arrays.
     * Blank originals are skipped; callers fall back to the original string.
     *
     * @param  array<int,?string>  $originals
     * @param  array<int,?string>  $translated
     * @return array<string,string>
     */
    private static function lookupMap(array $originals, array $translated): array
    {
        $map = [];
        foreach ($originals as $i => $original) {
            if (is_string($original) && $original !== '') {
                $map[$original] = $translated[$i] ?? $original;
            }
        }

        return $map;
    }

    public function coursesDetails(string $slug)
    {
      
        $slug = trim(urldecode($slug));
 
        $course = Course::where('slug',$slug)->firstOrFail();

        if (!$course) {
            abort(410);
        }


        $curriculum = [];
        $faq        = is_array($course->faq) ? $course->faq : [];
        $skills     = $course->skills ? json_decode($course->skills) : [];
        $whyLearns     = $course->why_learn ? json_decode($course->why_learn) : [];
        $related_courses     = $course->related_courses ? json_decode($course->related_courses) : [];
        $reviews     = $course->reviews ? json_decode($course->reviews) : [];
        $FAQs     = $course->FAQs ? json_decode($course->FAQs) : [];
    
        $aboutHeading =[];
        if($course){
        $aboutHeading     = CourseAbout::where('course_id',$course->id)->first();
        }
        
        $placementStories="";
        
        if($course){
        $placementStories     = Placement::where('course',$course->id)->get();
        }
     

        // ── Batch-translate ALL dynamic strings in ONE query ────────────
        // Collect every dynamic string on the page (summary, description,
        // skills, curriculum titles + topics, FAQ q/a), resolve the whole
        // deduped set through a single translateMany() call (one whereIn),
        // then build the per-field arrays via an "original => translated"
        // lookup map. The Blade template does array lookups only.
        $curriculumTitleSources = array_map(fn ($m) => $m['title'] ?? '', $curriculum);
       

 
$rows = CourseCurriculumExcel::where('course_id', $course->id)
    ->orderBy('id', 'asc')
    ->get();

// Group children by their parent FK — done once, in memory, no extra queries
$byHeadingId    = $rows->groupBy('heading_id');
$byContentId    = $rows->groupBy('content_id');
$bySubcontentId = $rows->groupBy('subcontent_id');
$byEndcontentId = $rows->groupBy('endcontent_id');

// Root-level rows: real headings, no parent
$headings = $rows->filter(function ($row) {
    return empty($row->heading_id) && !empty($row->heading);
});

$coursecurriculum = $headings->map(function ($heading) use ($byHeadingId, $byContentId, $bySubcontentId, $byEndcontentId) {

    $topics = $byHeadingId->get($heading->id, collect());

    return [
        'title'  => $heading->heading,
        'topics' => $topics->map(function ($topic) use ($byContentId, $bySubcontentId, $byEndcontentId) {

            $subcontents = $byContentId->get($topic->id, collect());

            return [
                'content'     => $topic->coursescontent,
                'subcontents' => $subcontents->map(function ($sub) use ($bySubcontentId, $byEndcontentId) {

                    $lastcontents = $bySubcontentId->get($sub->id, collect());

                    return [
                        'subcontent'   => $sub->subcontent,
                        'lastcontents' => $lastcontents->map(function ($last) use ($byEndcontentId) {

                            $endcontents = $byEndcontentId->get($last->id, collect());

                            return [
                                'lastcontent' => $last->lastcontent,
                                'endcontents' => $endcontents->map(function ($end) {
                                    return ['endcontent' => $end->endcontent];
                                })->values()->toArray(),
                            ];
                        })->values()->toArray(),
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray(),
    ];
})->values()->toArray();
 


 
        $allTopics = [];
        $moduleTopicCount = [];
        foreach ($coursecurriculum as $m) {       
            $topics = is_array($m['topics'] ?? null) ? $m['topics'] : [];
            $moduleTopicCount[] = count($topics);
            foreach ($topics as $tp) {
                $allTopics[] = $tp;
            }
        }


     
        $faqQuestionSources = array_map(fn ($f) => $f['question'] ?? '', $faq);
        $faqAnswerSources   = array_map(fn ($f) => $f['answer'] ?? '', $faq);

        $allStrings = array_merge(
            [$course->summary, $course->description],
            $skills,
            $curriculumTitleSources,
            $allTopics,
            $faqQuestionSources,
            $faqAnswerSources,
        );

        $translations = self::lookupMap(
            $allStrings,
            ServerTranslator::translateMany($allStrings)
        );

       //$tDyn = static fn (?string $v): ?string => (is_string($v) && $v !== '' && isset($translations[$v])) ? $translations[$v] : $v;

        $summary     = $course->summary;
        $description = $course->description;
        $skillsT     = $skills;
        $curriculumTitles = $curriculumTitleSources;

        // Re-slice translated topics per module (preserving original order).
        $curriculumTopics = [];
        $offset = 0;
        foreach ($moduleTopicCount as $mi => $count) {
            $slice = array_slice($allTopics, $offset, $count);
            $curriculumTopics[$mi] = $slice;
            $offset += $count;
        }

        $faqQuestions = $faqQuestionSources;
        $faqAnswers   = $faqAnswerSources;
//dd($reviews);
        if($course->course_type =='2'){             

            $courses_module = $course->courses_module
                ? json_decode($course->courses_module, true)
                : [];
            $courseModules = Course::whereIn('slug', $courses_module)->get();
     
            return view('pages.master-detail', [
            'course'            => $course,
            'placementStories'            => $placementStories,
            'curriculum'        => $coursecurriculum,
            'courseModules'        => $courseModules,
            'aboutHeading'        => $aboutHeading,
            'faqs'               => $FAQs,
            'skills'            => $skills,
            'whyLearns'         => $whyLearns,
            'related_courses'   => $related_courses,
            'reviews'            => $reviews,
            'summaryT'          => $summary,
            'descriptionT'      => $description,
            'skillsT'           => $skillsT,
            'curriculumTitles'  => $curriculumTitles,
            'curriculumTopics'  => $curriculumTopics,
            'faqQuestions'      => $faqQuestions,
            'faqAnswers'        => $faqAnswers,
        ]);


        }elseif($course->course_type =='3'){

 return view('pages.seo-course-detail', [
            'course'            => $course,
            'curriculum'        => $coursecurriculum,
            'placementStories'        => $placementStories,
            'aboutHeading'        => $aboutHeading,
            'faqs'               => $FAQs,
            'skills'            => $skills,
            'whyLearns'         => $whyLearns,
            'related_courses'   => $related_courses,
            'reviews'            => $reviews,
            'summaryT'          => $summary,
            'descriptionT'      => $description,
            'skillsT'           => $skillsT,
            'curriculumTitles'  => $curriculumTitles,
            'curriculumTopics'  => $curriculumTopics,
            'faqQuestions'      => $faqQuestions,
            'faqAnswers'        => $faqAnswers,
        ]);


        }else{
        return view('pages.course-detail', [
            'course'            => $course,
            'curriculum'        => $coursecurriculum,
            'placementStories'        => $placementStories,
            'aboutHeading'        => $aboutHeading,
            'faqs'               => $FAQs,
            'skills'            => $skills,
            'whyLearns'         => $whyLearns,
            'related_courses'   => $related_courses,
            'reviews'            => $reviews,
            'summaryT'          => $summary,
            'descriptionT'      => $description,
            'skillsT'           => $skillsT,
            'curriculumTitles'  => $curriculumTitles,
            'curriculumTopics'  => $curriculumTopics,
            'faqQuestions'      => $faqQuestions,
            'faqAnswers'        => $faqAnswers,
        ]);
        }


    }   



    public function masterShow(string $slug): View
    {
        $course = Course::where('slug', $slug)->first();

        if (!$course) {
            abort(404);
        }

        $curriculum = [];
        $faq        = is_array($course->faq) ? $course->faq : [];
        $skills     = $course->skills ? json_decode($course->skills) : [];
        $whyLearns     = $course->why_learn ? json_decode($course->why_learn) : [];
        $related_courses     = $course->related_courses ? json_decode($course->related_courses) : [];
        $reviews     = $course->reviews ? json_decode($course->reviews) : [];
        $FAQs     = $course->FAQs ? json_decode($course->FAQs) : [];
        
        $aboutHeading =[];
        if($course){
        $aboutHeading     = CourseAbout::where('course_id',$course->id)->first();
        }

        // ── Batch-translate ALL dynamic strings in ONE query ────────────
        // Collect every dynamic string on the page (summary, description,
        // skills, curriculum titles + topics, FAQ q/a), resolve the whole
        // deduped set through a single translateMany() call (one whereIn),
        // then build the per-field arrays via an "original => translated"
        // lookup map. The Blade template does array lookups only.
        $curriculumTitleSources = array_map(fn ($m) => $m['title'] ?? '', $curriculum);
       

 
$rows = CourseCurriculumExcel::where('course_id', $course->id)
    ->orderBy('id', 'asc')
    ->get();

// Group children by their parent FK — done once, in memory, no extra queries
$byHeadingId    = $rows->groupBy('heading_id');
$byContentId    = $rows->groupBy('content_id');
$bySubcontentId = $rows->groupBy('subcontent_id');
$byEndcontentId = $rows->groupBy('endcontent_id');

// Root-level rows: real headings, no parent
$headings = $rows->filter(function ($row) {
    return empty($row->heading_id) && !empty($row->heading);
});

$coursecurriculum = $headings->map(function ($heading) use ($byHeadingId, $byContentId, $bySubcontentId, $byEndcontentId) {

    $topics = $byHeadingId->get($heading->id, collect());

    return [
        'title'  => $heading->heading,
        'topics' => $topics->map(function ($topic) use ($byContentId, $bySubcontentId, $byEndcontentId) {

            $subcontents = $byContentId->get($topic->id, collect());

            return [
                'content'     => $topic->coursescontent,
                'subcontents' => $subcontents->map(function ($sub) use ($bySubcontentId, $byEndcontentId) {

                    $lastcontents = $bySubcontentId->get($sub->id, collect());

                    return [
                        'subcontent'   => $sub->subcontent,
                        'lastcontents' => $lastcontents->map(function ($last) use ($byEndcontentId) {

                            $endcontents = $byEndcontentId->get($last->id, collect());

                            return [
                                'lastcontent' => $last->lastcontent,
                                'endcontents' => $endcontents->map(function ($end) {
                                    return ['endcontent' => $end->endcontent];
                                })->values()->toArray(),
                            ];
                        })->values()->toArray(),
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray(),
    ];
})->values()->toArray();
 


 
        $allTopics = [];
        $moduleTopicCount = [];
        foreach ($coursecurriculum as $m) {       
            $topics = is_array($m['topics'] ?? null) ? $m['topics'] : [];
            $moduleTopicCount[] = count($topics);
            foreach ($topics as $tp) {
                $allTopics[] = $tp;
            }
        }


     
        $faqQuestionSources = array_map(fn ($f) => $f['question'] ?? '', $faq);
        $faqAnswerSources   = array_map(fn ($f) => $f['answer'] ?? '', $faq);

        $allStrings = array_merge(
            [$course->summary, $course->description],
            $skills,
            $curriculumTitleSources,
            $allTopics,
            $faqQuestionSources,
            $faqAnswerSources,
        );

        $translations = self::lookupMap(
            $allStrings,
            ServerTranslator::translateMany($allStrings)
        );

       //$tDyn = static fn (?string $v): ?string => (is_string($v) && $v !== '' && isset($translations[$v])) ? $translations[$v] : $v;

        $summary     = $course->summary;
        $description = $course->description;
        $skillsT     = $skills;
        $curriculumTitles = $curriculumTitleSources;

        // Re-slice translated topics per module (preserving original order).
        $curriculumTopics = [];
        $offset = 0;
        foreach ($moduleTopicCount as $mi => $count) {
            $slice = array_slice($allTopics, $offset, $count);
            $curriculumTopics[$mi] = $slice;
            $offset += $count;
        }

        $faqQuestions = $faqQuestionSources;
        $faqAnswers   = $faqAnswerSources;

        return view('pages.master-detail', [
            'course'            => $course,
            'curriculum'        => $coursecurriculum,
            'aboutHeading'        => $aboutHeading,
            'faqs'               => $FAQs,
            'skills'            => $skills,
            'whyLearns'         => $whyLearns,
            'related_courses'   => $related_courses,
            'reviews'            => $reviews,
            'summaryT'          => $summary,
            'descriptionT'      => $description,
            'skillsT'           => $skillsT,
            'curriculumTitles'  => $curriculumTitles,
            'curriculumTopics'  => $curriculumTopics,
            'faqQuestions'      => $faqQuestions,
            'faqAnswers'        => $faqAnswers,
        ]);
    }

    /**
     * Handle the course-detail enquiry lead form (plain POST). Reuses the same
     * persistence + notification logic as the JSON LeadController@store.
     */
    public function enquiry(Request $request, string $slug): RedirectResponse
    {
        $course = Course::where('slug', $slug)->first();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        app(LeadController::class)->persistAndNotify([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'] ?? null,
            'course_slug' => $slug,
            'message'     => 'Course enquiry: ' . ($course->title ?? $slug),
        ]);

        return redirect()
            ->back()
            ->with('success', t('courseDetailX.callYouWithin'));
    }




     public function blog(Request $request): View
    {
        $category = (string) $request->query('category', '');
        $search   = (string) $request->query('search', '');

        // Mirror CourseController@index LIKE filters.
        $query = Course::query();

        if ($category !== '') {
            $query->where('category_slug', $category);
        }

        if ($search !== '') {
            $term = '%' . $search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                  ->orWhere('summary', 'like', $term)
                  ->orWhere('category_name', 'like', $term)
                  ->orWhere('skills', 'like', $term);
            });
        }

        $courses = $query->orderBy('id')->get();

        // Match the API/React ordering (categories by insertion id, not name).
        $categories = Category::orderBy('id')->get();

        // ── Batch-translate ALL dynamic strings in ONE query ────────────
        // Collect course titles + Courses-FAQ questions/answers, resolve the
        // whole deduped set via a single translateMany() (one whereIn), and
        // hand the view a lookup map (+ derived arrays). The Blade template
        // does array lookups only — no ServerTranslator calls.
        $faqSource = Faqs::COURSES;

        $allStrings = array_merge(
            $courses->pluck('title')->all(),
            array_map(static fn ($f) => $f['question'], $faqSource),
            array_map(static fn ($f) => $f['answer'], $faqSource),
        );

        $translations = self::lookupMap(
            $allStrings,
            ServerTranslator::translateMany($allStrings)
        );

        $tDyn = static fn (?string $v): ?string => ($v !== null && isset($translations[$v])) ? $translations[$v] : $v;

        $translatedTitles = [];
        foreach ($courses as $course) {
            $translatedTitles[$course->id] = $tDyn($course->title);
        }


        $tools_list = ToolsCovered::get();

        // Courses FAQ — translated via the shared map.
        $coursesFaqs = array_map(static fn ($f) => [
            'question' => $tDyn($f['question']),
            'answer'   => $tDyn($f['answer']),
        ], $faqSource);

        return view('pages.blog', [
            'courses'          => $courses,
            'categories'       => $categories,
            'category'         => $category,
            'search'           => $search,
            'tools_list'       => $tools_list,
            'translatedTitles' => $translatedTitles,
            'coursesFaqs'      => $coursesFaqs,
        ]);
    }

}
