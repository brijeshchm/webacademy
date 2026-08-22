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
            <h1 class="text-2xl md:text-3xl font-display font-bold">Privacy Policy</h1>
            <p class="mt-2 text-sm text-white/60">
                <span>
                    <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    <a href="{{ url('privacy-policy') }}" class="hover:text-primary transition-colors">Privacy Policy</a>
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    <strong class="text-white font-medium" aria-current="page">Privacy Policy</strong>
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
                            <h3 class="text-xl md:text-2xl font-display font-bold text-gray-900 mb-3">Privacy Policy</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                At Corporates Academy, we are committed to respecting your privacy and safeguarding your personal information. This policy explains how we collect, use, and protect your data when you interact with our website. Our mission is to provide a secure and transparent experience while ensuring compliance with legal privacy standards.
                            </p>
                        </div>

                        <div class="space-y-6">

                            {{-- Information We Gather --}}
                            <div>
                                <h6 class="font-semibold text-gray-900 mb-2">Information We Gather</h6>
                                <p class="text-sm text-gray-600 mb-2">We may collect and store the following types of information:</p>
                                <ul class="list-disc list-inside space-y-1 text-sm text-gray-600 mb-3">
                                    <li>Personal details like your name, job title, and contact information (e.g., email address).</li>
                                    <li>Demographic data such as location, preferences, and interests.</li>
                                    <li>Information about your inquiries, feedback, or participation in surveys and offers.</li>
                                </ul>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    We implement advanced security measures to ensure your information remains confidential and is only accessed by authorized personnel. Rest assured, we are committed to maintaining the integrity and safety of your data.
                                </p>
                            </div>

                            {{-- Cookies --}}
                            <div>
                                <h6 class="font-semibold text-gray-900 mb-2">Cookies and Their Purpose</h6>
                                <p class="text-sm text-gray-600 mb-2">Cookies are small files placed on your device to improve your browsing experience. They allow our website to recognize returning visitors, tailor content to your preferences, and enhance functionality.</p>
                                <p class="text-sm text-gray-600 mb-2">We use cookies to analyze user behavior, monitor website performance, and identify popular sections of our site. This helps us continually optimize your experience. The data collected is used for analysis purposes and is not stored long-term.</p>
                                <p class="text-sm text-gray-600">You have the option to disable cookies through your browser settings. Please note that turning off cookies may affect certain features and functionalities of the website.</p>
                            </div>

                            {{-- Third-Party Links --}}
                            <div>
                                <h6 class="font-semibold text-gray-900 mb-2">Third-Party Links</h6>
                                <p class="text-sm text-gray-600 mb-2">Our website may include links to external websites for your convenience. However, once you leave our platform, we are not responsible for the content, privacy practices, or data security of those sites.</p>
                                <p class="text-sm text-gray-600">We recommend reviewing the privacy policies of any third-party sites you visit, as our policy does not apply to external platforms.</p>
                            </div>

                            {{-- Your Control --}}
                            <div>
                                <h6 class="font-semibold text-gray-900 mb-2">Your Control Over Personal Information</h6>
                                <p class="text-sm text-gray-600 mb-2">You can manage how your personal data is collected and used by taking the following actions:</p>
                                <p class="text-sm text-gray-600 mb-2">When filling out forms on our website, check the appropriate boxes to control how your data will be used.</p>
                                <ul class="list-disc list-inside space-y-1 text-sm text-gray-600">
                                    <li>
                                        If you have previously agreed to receive marketing communications, you can opt-out at any time by emailing us at
                                        <a href="mailto:corporate@gmail.com" class="text-primary hover:underline">corporate@gmail.com</a>.
                                        We do not share, sell, or rent your personal information to third parties without your consent, except when required by law. If you suspect any inaccuracies in your data, please contact us, and we will correct or update it promptly.
                                    </li>
                                </ul>
                            </div>

                            {{-- Scope --}}
                            <div>
                                <h6 class="font-semibold text-gray-900 mb-2">Scope of This Privacy Policy</h6>
                                <p class="text-sm text-gray-600">This policy exclusively applies to the data collected through our website and does not cover any information obtained offline or through other channels.</p>
                            </div>

                        </div>

                        {{-- Agreement --}}
                        <div>
                            <h6 class="font-semibold text-gray-900 mb-2">Your Agreement</h6>
                            <p class="text-sm text-gray-600">By using our website, you agree to the terms outlined in this Privacy Policy. Any updates or changes to the policy will be reflected on this page to keep you informed.</p>
                        </div>

                    </div>
                </div>

         

            </div>
        </div>
    </section>

</div>
	

@endsection