  @extends('layouts.app')
@section('title')
@if(!empty($coursesdetails->title))	 
 {{$coursesdetails->title}}; 
@else
	Institute- Best IT Training Institute in Noida | Delhi | Gurgaon
@endif
@endsection 
@section('keyword')
@if(!empty($coursesdetails->meta_keyword))
	{{$coursesdetails->meta_keywords}};
@else
	Institute: Best IT Training Institute in Noida | Delhi | Gurgaon
@endif
@endsection
@section('description')
@if(!empty($coursesdetails->meta_description))
{{$coursesdetails->meta_description}};
@else
	Institute Best IT Training Institute in Noida | Delhi | Gurgaon for Industrial Training. We conducts IT Software, Hardware, Network &amp; Security Courses training. Corporate Trainer commands all training program. Week Days, Weekend, 6 Week, 6 Months Industrial Training are available
@endif
@endsection
@section('content')
<div>

    {{-- Top Banner --}}
    <div class="relative bg-gradient-to-br from-[hsl(217_45%_11%)] via-[hsl(220_40%_10%)] to-[hsl(224_50%_8%)] text-white py-10 md:py-14">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <h1 class="text-2xl md:text-3xl font-display font-bold">Terms &amp; Conditions</h1>
            <p class="mt-2 text-sm text-white/60">
                <span>
                    <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    <a href="{{ url('terms-conditions') }}" class="hover:text-primary transition-colors">Terms &amp; Conditions</a>
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    <strong class="text-white font-medium" aria-current="page">Terms &amp; Conditions</strong>
                </span>
            </p>
        </div>
    </div>

    {{-- Content --}}
    <section class="py-10 md:py-14">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

                {{-- Main content --}}
                <div class="md:col-span-9">
                    <div class="space-y-8">

                        <div>
                            <h3 class="text-xl md:text-2xl font-display font-bold text-gray-900 mb-3">Terms &amp; Conditions</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                We are excited to introduce our comprehensive placement support program designed to help you craft exceptional resumes, apply for top job opportunities, and prepare for interviews with expert guidance from professionals in leading industries. Welcome to our platform! By accessing and using this website, you agree to abide by the terms outlined below, as well as our Privacy Policy. The terms "we," "our," or "us" refer to Corporate Academy, located at Badarpur. The term "you" refers to visitors and users of this site.
                            </p>
                        </div>

                        {{-- Conditions for Website Use --}}
                        <div>
                            <h6 class="font-semibold text-gray-900 mb-2">Conditions for Website Use:</h6>
                            <ul class="list-disc list-inside space-y-2 text-sm text-gray-600">
                                <li>Your use of this website is subject to the following terms:</li>
                                <li>General Information: The content on this site is intended for informational purposes only and is subject to change at any time without prior notice.</li>
                                <li>No Guarantees: We and any associated third parties do not guarantee the accuracy, completeness, reliability, or timeliness of the information provided. You accept that such content may have errors, and we disclaim liability for any inaccuracies as permitted by law.</li>
                                <li>User Responsibility: Your use of the materials and information on this site is entirely at your own risk. It is your duty to ensure the services or information meet your personal or professional needs.</li>
                                <li>Content Ownership: All materials, including text, images, and graphics, are either owned by us or used under license. Reproducing or using this content without authorization is strictly prohibited unless it complies with copyright regulations.</li>
                                <li>Trademarks: Any trademarks displayed on this site that are not owned by or licensed to us are fully acknowledged. Prohibited Use: Unauthorized access or use of this website may lead to legal consequences, including claims for damages or criminal charges.</li>
                                <li>Third-Party Links: Our website may include links to external websites for your convenience. We are not responsible for the content, security, or accuracy of these third-party sites.</li>
                                <li>Linking Policy: Users must obtain written permission before creating any links to our site from other websites or documents.</li>
                                <li>Legal Jurisdiction: Any disputes arising from the use of this website will be governed by the laws of India.</li>
                                <li>Referral Benefits: Discounts on courses may be earned through referrals, subject to the terms of our referral program.</li>
                            </ul>
                        </div>

                        {{-- Modifications --}}
                        <div>
                            <h6 class="font-semibold text-gray-900 mb-2">Modifications to Terms</h6>
                            <p class="text-sm text-gray-600">
                                We reserve the right to revise these terms at any time by updating the content on this website. Users are encouraged to review the terms regularly. Continued use of the site implies acceptance of any updates or amendments.
                            </p>
                        </div>

                        {{-- Courses and IP --}}
                        <div>
                            <h6 class="font-semibold text-gray-900 mb-2">Courses and Intellectual Property</h6>
                            <p class="text-sm text-gray-600 mb-2">
                                Training Materials: The courses and resources offered through Corporates Academy may include copyrighted materials from third-party providers. All such content is utilized with appropriate permissions.
                            </p>
                            <p class="text-sm text-gray-600 mb-2">
                                Restrictions: Unauthorized reproduction, sharing, or distribution of training materials is prohibited and may result in legal action.
                            </p>
                            <p class="text-sm text-gray-600">
                                Copyright Concerns: If you believe that any content on this website infringes on copyright laws, please contact us at Corporate Academy. We will investigate and take necessary steps to address the issue.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Sidebar --}}
                
            </div>
        </div>
    </section>

</div>
@endsection