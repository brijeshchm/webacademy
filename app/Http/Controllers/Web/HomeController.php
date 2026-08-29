<?php

namespace App\Http\Controllers\Web;

use App\Data\Faqs;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Proof;
use App\Models\Testimonial;
use App\Models\VideoStory;
use App\Models\WhatsappChat;
use App\Services\ServerTranslator;
use App\Models\ToolsCovered;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Home page (/) — server-rendered port of
 * artifacts/corporate-academy/src/pages/Home.tsx and every section component it
 * renders (hero, stats, global impact, learning paths, alumni marquee, featured
 * courses, why section, course globe, career journey, social proof, video
 * stories, reviews, associations, CTA/newsletter, FAQ).
 *
 * Data access mirrors the API controllers' query shapes:
 *   - Course::orderBy('id')             (CourseController@index, no filters)
 *   - Category::orderBy('id')           (CategoryController@index / Express categories route)
 *   - Testimonial::where('visible',true)->orderBy('id')  (TestimonialController@index)
 *   - Proof / WhatsappChat / VideoStory (SocialProof + VideoStories sections)
 *   - StatsController@index static numbers
 */
class HomeController extends Controller
{
    public function __invoke(): View
    {
        $allCourses = Course::orderBy('id')->get();
      $categories = Course::select('category_name', 'category_slug')
    ->distinct()
    ->whereNotNull('category_slug')
    ->orderBy('category_name', 'asc')
    ->get();
        $testimonials = Testimonial::where('status', true)->orderBy('id')->get();

        $whatsappChats = WhatsappChat::orderBy('id')->get();
        $proofs = Proof::orderBy('id')->get();
        $videoStories = VideoStory::orderBy('sort_order')->orderBy('id')->get();
 
        $featuredCourses = $allCourses->where('featured', true)->values();

        // Stats — mirrors StatsController@index (static marketing numbers).
        $stats = [
            'careersTransformed' => 65000,
            'expertTrainers'     => 800,
            'averageRating'      => 4.8,
        ];

        // ── Batch-translate ALL dynamic DB strings up front ─────────────
        // Instead of calling ServerTranslator::translate() inside the view
        // loops (which fired one query per course card / course chip / review
        // field), we collect EVERY dynamic string once, dedupe it, and resolve
        // the whole set through a single translateMany() call — that call is
        // exactly ONE whereIn query. The views then do plain array lookups
        // against the resulting "original => translated" map.

        $faqSource = Faqs::HOME;

        $allStrings = array_merge(
            $allCourses->pluck('title')->all(),        // learning-paths grid, featured, chips
            $featuredCourses->pluck('summary')->all(), // featured cards
            $testimonials->pluck('status')->all(),      // reviews partial
            $testimonials->pluck('designation')->all(),
            $testimonials->pluck('company')->all(),
            array_map(static fn ($f) => $f['question'], $faqSource),
            array_map(static fn ($f) => $f['answer'], $faqSource),
        );

        // One query resolves the full deduped set into a single lookup map.
        $translations = self::lookupMap(
            $allStrings,
            ServerTranslator::translateMany($allStrings)
        );

        $tr = static fn (?string $v): ?string => ($v !== null && isset($translations[$v])) ? $translations[$v] : $v;

        // FAQ — HOME set, translated via the shared map.
        $faqs = array_map(static fn ($f) => [
            'question' => $tr($f['question']),
            'answer'   => $tr($f['answer']),
        ], $faqSource);

        // English JSON-LD (SEO) uses the untranslated FAQ source.
        $faqsEn = Faqs::HOME;
          $blogPageList       = $this->getBlogList();
    
        return view('pages.home', [
            'allCourses'      => $allCourses,
            'blogPageList'      => $blogPageList,
            'categories'      => $categories,
            'testimonials'    => $testimonials,
            'featuredCourses' => $featuredCourses,
            'whatsappChats'   => $whatsappChats,
            'proofs'          => $proofs,
            'videoStories'    => $videoStories,
            'stats'           => $stats,
            'faqs'            => $faqs,
            'faqsEn'          => $faqsEn,
          
            // Single shared translation lookup map used by every view/partial.
            'translations'    => $translations,
        ]);
    }

    /**
     * Build an "original => translated" lookup map from two parallel arrays.
     * Empty/blank originals are skipped; the view falls back to the original
     * string when a key is absent.
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
 private function getBlogList(): array
    {
        $blogPageList = [];
 
        $blogDetails = Blog::where('status', '1')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
 
        foreach ($blogDetails as $key => $blog) {
            $image = '';
            $alt   = '';
 
            if (!empty($blog->image)) {
                $imageData = @unserialize($blog->image);
                if (is_array($imageData) && !empty($imageData['large']['src'])) {
                    $image = config('app.website') . $imageData['large']['src'];
                    $alt   = $blog->name;
                }
            }
 
            $description = strip_tags($blog->description ?? '');
            $description = Str::limit($description, 220, '...');
 
            $blogPageList[$key] = [
                'url'         => $blog->slug,
                'img'         => $image,
                'alt'         => $alt,
                'title'       => $blog->name,
                'description' => ucfirst($description),
            ];
        }
 
        return $blogPageList;
    }



   
}
