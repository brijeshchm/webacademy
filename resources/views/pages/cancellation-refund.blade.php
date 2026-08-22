@extends('layouts.app')
@section('title')
Cancellation & Refund
@endsection 
@section('keyword')
Cancellation & Refund
@endsection
@section('description')
 Cancellation & Refund
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
                    <a href="{{ url('refund-cancellation-policy') }}" class="hover:text-primary transition-colors">Refund/Cancellation Policy</a>
                    <i class="fa fa-angle-double-right mx-2" aria-hidden="true"></i>
                    <strong class="text-white font-medium" aria-current="page">Refund/Cancellation Policy</strong>
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
                            <h3 class="text-xl md:text-2xl font-display font-bold text-gray-900 mb-3">Cancellation and Refund Policy</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Discover the success stories of our alumni through our placement platform! Many have secured prestigious roles in global organizations and achieved remarkable career milestones. Now, it's your chance to step into their shoes and build a rewarding future.
                            </p>
                        </div>

                        {{-- Refund Guidelines --}}
                        <div>
                            <h6 class="font-semibold text-gray-900 mb-2">Refund Guidelines</h6>
                            <ul class="list-disc list-outside pl-5 space-y-2 text-sm text-gray-600">
                                <li>Refunds will not be approved once the first session of the enrolled program has been attended.</li>
                                <li>Sharing course materials with others will void any eligibility for a refund.</li>
                                <li>No refunds will be issued after the training schedule has been confirmed and sessions have begun.</li>
                                <li>Requests for refunds submitted beyond the specified time frame will be automatically rejected.</li>
                            </ul>
                        </div>

                        {{-- Exceptions --}}
                        <div>
                            <h6 class="font-semibold text-gray-900 mb-2">Exceptions to Refunds</h6>
                            <ul class="list-disc list-outside pl-5 space-y-2 text-sm text-gray-600">
                                <li>The "5-Day Flexible Refund Policy" will not apply under these circumstances:</li>
                                <li>Course content has been accessed or downloaded from our platform.</li>
                                <li>Refunds for official course materials, including books and documents, are not permissible.</li>
                                <li>Self-paced learning packages are non-refundable.</li>
                                <li>Examination fees, once paid, are non-refundable. Any misuse of the refund policy may result in restrictions on current and future services without prior notice.</li>
                            </ul>
                        </div>

                        {{-- Policy Updates --}}
                        <div>
                            <h6 class="font-semibold text-gray-900 mb-2">Policy Updates</h6>
                            <ul class="list-disc list-outside pl-5 space-y-2 text-sm text-gray-600">
                                <li>We reserve the right to amend these terms at any time. Updates will be published on our website without prior notification. By continuing to use our services, you accept any revised policies.</li>
                            </ul>
                        </div>

                        {{-- Request Submission --}}
                        <div>
                            <h6 class="font-semibold text-gray-900 mb-2">Request Submission</h6>
                            <ul class="list-disc list-outside pl-5 space-y-2 text-sm text-gray-600">
                                <li>Refund or cancellation requests must be made within 7 days of payment. Requests submitted after this period will not be entertained.</li>
                                <li>For assistance, please email us at <a href="mailto:{{ config('app.support_email', 'support@corporatesacademy.com') }}" class="text-primary hover:underline">{{ config('app.support_email', 'support@corporatesacademy.com') }}</a>.</li>
                                <li>Refunds will be processed within 30 days after validating the request.</li>
                            </ul>
                        </div>

                        {{-- Rescheduling --}}
                        <div>
                            <h6 class="font-semibold text-gray-900 mb-2">Rescheduling or Course Changes</h6>
                            <ul class="list-disc list-outside pl-5 space-y-2 text-sm text-gray-600">
                                <li>Changes to your program schedule or selected course depend on resource availability and may take up to 3 weeks to implement. While we strive to accommodate all requests, there may be instances where modifications are not possible due to limitations. In such cases, an administrative fee of 10% will be applied.</li>
                            </ul>
                        </div>

                    </div>
                </div>

                {{-- Sidebar --}}
                 
            </div>
        </div>
    </section>

</div>
	

@endsection