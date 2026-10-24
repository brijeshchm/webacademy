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
use DateTime;
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
    public function index()
    {
        $allCourses = Course::select('title','show_front_page','featured','live_project','level','mode','enrolled','duration_hours','professional_trained','course_name','category_name','category_slug','batches_every_month','course_clone_id','slug','description','rating','total_rating')->where('course_type','1')->orderBy('id')->get();
       $categories = Course::select('category_name', 'category_slug')
    ->distinct()
    ->whereNotNull('category_slug')
    ->where('category_slug', '<>', '')
    ->orderByRaw(
        'CASE
            WHEN category_slug = ? THEN 0
            WHEN category_slug = ? THEN 1
            ELSE 2
        END',
        ['workday', 'artificial-intelligence']
    )
    ->orderBy('category_name', 'asc')
    ->get();


        $testimonials = Testimonial::where('status', true)->orderBy('id')->get();

        $whatsappChats = WhatsappChat::orderBy('id')->get();
        $proofs = Proof::orderBy('id')->get();
        $videoStories = VideoStory::orderBy('sort_order')->orderBy('id')->get();
 
        $featuredCourses = $allCourses->where('featured', true)->values();
        $bannerCourses = $allCourses->where('show_front_page', true)->take(8)->values();

        // Stats — mirrors StatsController@index (static marketing numbers).
        $stats = [
            'careersTransformed' => 65000,
            'expertTrainers'     => 800,
            'averageRating'      => 4.8,
        ];

        

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
    // dd($testimonials);
        return view('pages.home', [
            'allCourses'      => $allCourses,
            'blogPageList'      => $blogPageList,
            'categories'      => $categories,
            'testimonials'    => $testimonials,
            'bannerCourses'    => $bannerCourses,
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
 
            $description = strip_tags($blog->blog_defination ?? '');
            $description = Str::limit($description, 220, '...');
 

            $name = $blog->name ?? 'Blog Name';
            $words = explode(' ', $name);
            $avatarBlog = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

         


            $blogPageList[$key] = [
                'slug'         => $blog->slug,
                'img'         => $image,
                'avatarBlog'         => $avatarBlog,
                'alt'         => $blog->title,
                'title'       => $blog->title,
                'name'       => $blog->name,
                'author_name'       => $blog->author_name,
                'created_at' => date('d, M Y', strtotime($blog->created_at)),
                'updated_at'       =>  $this->get_time(strtotime($blog->created_at)),
                'description' => ucfirst($description),
            ];
        }
 
        return $blogPageList;
    }





function get_time($time)
{

	date_default_timezone_set('Asia/Kolkata');

	$start_date = date('Y-m-d H:i:s');

	$diff = abs(strtotime($start_date) - $time);

	$totalyear = floor($diff / (365 * 60 * 60 * 24));
	$totalmonths = floor(($diff - $totalyear * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
	$days = floor(($diff - $totalyear * 365 * 60 * 60 * 24 - $totalmonths * 30 * 60 * 60 * 24) / (60 * 60 * 24));



	$create_time = $time;
	$current_time = time();
	$dtCurrent = DateTime::createFromFormat('U', $current_time);
	$dtCreate = DateTime::createFromFormat('U', $create_time);
	$diff = $dtCurrent->diff($dtCreate);

	if ($days < 1 && $totalmonths == 0) {
		$interval = $diff->format("%h hrs %i minutes");
		$interval = preg_replace('/(^0| 0) (hrs|minutes)/', '', $interval);

	} else if ($days > 0 && $totalmonths == 0) {
		$interval = $diff->format("%d days %h hrs");
		$interval = preg_replace('/(^0| 0) (days|hrs)/', '', $interval);
	} else if ($totalmonths > 0 && $days > 1 && $totalyear == '0') {

		$interval = $diff->format("%m months %d days");
		$interval = preg_replace('/(^0| 0) (months|days)/', '', $interval);

	} else if ($totalmonths >= 12 && $totalyear > 0) {
		$interval = $diff->format("%y years %m months");
		$interval = preg_replace('/(^0| 0) (years|months)/', '', $interval);
	} else {

		$interval = $diff->format("%h hours %i minutes");
		$interval = preg_replace('/(^0| 0) (hours|minutes)/', '', $interval);
	}

	return $interval;



}
   
}
