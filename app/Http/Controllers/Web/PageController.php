<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Placeholder page controller for the Blade port foundation.
 *
 * Every public route returns a minimal 200 page (heading only) so the site is
 * navigable now; other agents replace these with real page views/controllers.
 */
class PageController extends Controller
{
    public function home(): View
    {
        return $this->page('home', 'home.heroTitle');
    }

    public function courses(): View
    {
        return $this->page('courses', 'nav.courses');
    }

    public function courseShow(string $slug): View
    {
        return $this->page('course-detail', 'nav.courses', ['slug' => $slug]);
    }

    public function categories(): View
    {
        return $this->page('categories', 'nav.categories');
    }

    public function categoryShow(string $slug): View
    {
        return $this->page('category-detail', 'nav.categories', ['slug' => $slug]);
    }

    public function about(): View
    {
        return $this->page('about', 'nav.about');
    }

    public function contact(): View
    {
        return $this->page('contact', 'nav.contact');
    }

    public function enquiry(): View
    {
        return $this->page('enquiry', 'nav.enquire');
    }

    public function scholarship(): View
    {
        return $this->page('scholarship', 'navX.scholarship');
    }

    public function corporateTraining(): View
    {
        return $this->page('corporate-training', 'navX.corporateTraining');
    }

    public function doctorate(): View
    {
        return $this->page('doctorate', 'navX.doctorateDba');
    }

    public function doctorateShow(string $slug): View
    {
        return $this->page('doctorate-detail', 'navX.doctorateDba', ['slug' => $slug]);
    }

    public function universityShow(string $slug): View
    {
        return $this->page('university-detail', 'nav.about', ['slug' => $slug]);
    }

    public function admin(): View
    {
        return $this->page('admin', 'nav.about');
    }

     public function refundCancellationPolicy(){
        return view('pages.cancellation-refund');

    }
    public function privacyPolicy(){
        return view('pages.privacy-policy');

    }
    public function termsConditions(){
        return view('pages.terms-conditions');

    }

    /**
     * @param  array<string,mixed>  $extra
     */
    private function page(string $view, string $titleKey, array $extra = []): View
    {
        return view("pages.{$view}", array_merge([
            'titleKey' => $titleKey,
        ], $extra));
    }




}
