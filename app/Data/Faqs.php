<?php

namespace App\Data;

/**
 * Shared FAQ content ported verbatim from
 * artifacts/corporate-academy/src/data/faqs.ts.
 *
 * Framework-free English source arrays consumed by the Blade pages that expose
 * FAQPage structured data (Home, Courses, Scholarship, Corporate, About,
 * Doctorate + per-category / per-university helpers). Render each string
 * through App\Services\ServerTranslator for non-English locales.
 *
 * Each FAQ entry is an associative array: ['question' => ..., 'answer' => ...].
 */
final class Faqs
{
    /** @var list<array{question:string,answer:string}> */
    public const HOME = [
        [
            'question' => 'What courses does Corporate Academy offer?',
            'answer' => 'Corporate Academy offers 490+ professional technology courses across Data Science, AI, Machine Learning, Cloud Computing, DevOps, Cybersecurity, Salesforce, Workday, ServiceNow, Oracle, Microsoft Dynamics, and project management (PMP). Courses run in live online, self-paced, and hybrid formats, so you can learn around a full-time job.',
        ],
        [
            'question' => 'How many professionals has Corporate Academy trained?',
            'answer' => 'Corporate Academy has trained 63,000+ professionals since 2018, with alumni working at companies like Google, Accenture, Infosys, TCS, and SAP. Learner satisfaction averages 4.8 out of 5.',
        ],
        [
            'question' => 'Are Corporate Academy courses live or self-paced?',
            'answer' => 'Both. Most programmes are available as live online classes led by industry experts, and many also have self-paced and hybrid options. You choose the format at enrolment based on your schedule.',
        ],
        [
            'question' => 'Do I get a certification after completing a course?',
            'answer' => 'Yes. Every course leads to a globally recognized certification from Corporate Academy, and many programmes prepare you directly for vendor certifications such as Salesforce, ServiceNow, AWS, and PMP exams.',
        ],
        [
            'question' => 'Does Corporate Academy offer scholarships or discounts?',
            'answer' => 'Yes. Six scholarship types cover up to 50% of your course fee, including merit, financial-aid, women-in-tech, early-enrolment, and referral scholarships. Applications are free and decisions arrive within 48 business hours.',
        ],
        [
            'question' => 'Can I join a course with no IT background?',
            'answer' => 'Yes. Corporate Academy runs beginner-level tracks in every major category, and career counsellors help you pick a starting point. Working professionals from non-technical roles regularly transition into data, cloud, and ERP careers through these programmes.',
        ],
        [
            'question' => 'How do I contact Corporate Academy for course advice?',
            'answer' => 'Call +91-88001-82225 (English and Hindi support) or submit an enquiry on the website. A counsellor responds with course recommendations, batch dates, and fee details, typically within one business day.',
        ],
    ];

    /** @var list<array{question:string,answer:string}> */
    public const COURSES = [
        [
            'question' => 'How many courses does Corporate Academy have?',
            'answer' => "Corporate Academy's catalog has 490+ professional technology courses across Data Science, AI, Machine Learning, Cloud Computing, DevOps, Cybersecurity, Salesforce, Workday, ServiceNow, Oracle, Microsoft Dynamics, and PMP. New Course are added regularly as tools and certifications evolve.",
        ],
        [
            'question' => 'How much does a course at Corporate Academy cost?',
            'answer' => 'Fees vary by programme length and technology, and are quoted in INR when you enquire. Scholarships cover up to 50% of the fee for eligible learners, with decisions in 48 business hours, so most students pay significantly less than the listed price.',
        ],
        [
            'question' => 'How long does a typical course take to complete?',
            'answer' => 'Most courses take 20 to 60 hours of instruction, which works out to 4-10 weeks part-time alongside a job. Each course page lists the exact duration in hours plus the level (beginner, intermediate, or advanced).',
        ],
        [
            'question' => 'Are the courses live online or self-paced?',
            'answer' => 'Both formats are available. Live online courses run with expert instructors on fixed batch schedules, while self-paced courses let you learn on your own timeline; some programmes offer hybrid delivery combining the two.',
        ],
        [
            'question' => 'Which course should I take as a complete beginner?',
            'answer' => "Start with a beginner-level course in the field you want to work in — filter the catalog by category and look for the 'Beginner' level badge. Data Science, Cloud Computing, and Salesforce are the most popular starting points for career changers with no prior IT experience.",
        ],
        [
            'question' => 'Do the courses include a certification?',
            'answer' => 'Yes. Every course ends with a globally recognized Corporate Academy certification, and many prepare you directly for vendor exams such as Salesforce, ServiceNow, Workday, AWS, and PMP. 63,000+ professionals have been certified through these programmes.',
        ],
    ];

    /** @var list<array{question:string,answer:string}> */
    public const SCHOLARSHIP = [
        ['question' => 'Can I apply for more than one scholarship?', 'answer' => 'You can apply for all scholarships you are eligible for. Only the highest single discount applies. Referral and Early Enrolment can be stacked on top for additional savings.'],
        ['question' => 'Is there an income limit for the Financial Aid Scholarship?', 'answer' => 'No strict income cutoff. We assess applications holistically — your circumstances, motivation, and commitment matter more than a number.'],
        ['question' => 'How long does the process take?', 'answer' => 'You will receive a response within 48 business hours. Doctoral Research Scholarship may take up to 5 business days due to the proposal review.'],
        ['question' => 'Do I need to submit documents now?', 'answer' => 'No. The online form is sufficient for initial review. If shortlisted, we contact you for mark sheets or certificates. No uploads required at this stage.'],
        ['question' => 'Is the scholarship applicable to all courses?', 'answer' => 'Most scholarships apply to all full programmes. The Doctoral Scholarship is exclusive to DBA programmes. Applicability is confirmed in your offer letter.'],
        ['question' => 'Can working professionals apply?', 'answer' => 'Absolutely — all scholarships are open to both freshers and working professionals. The Doctoral Scholarship specifically requires 10+ years of experience.'],
        ['question' => "What if my CGPA doesn't meet the Merit threshold?", 'answer' => 'You may still qualify for Financial Aid, Women in Tech, Early Enrolment, or Referral scholarships. Our committee looks at the full picture.'],
        ['question' => 'How is the discount applied?', 'answer' => 'Once confirmed, you receive a unique scholarship code that applies the discount directly to your programme cost at the time of enrolment.'],
    ];

    /** @var list<array{question:string,answer:string}> */
    public const CORPORATE = [
        [
            'question' => 'Does Corporate Academy provide corporate training for companies?',
            'answer' => 'Yes. Corporate Academy designs customized workforce training programmes for companies, partnering with HR and L&D teams from capability-gap discovery through delivery and impact reporting. Programmes draw on a catalog of 490+ courses and the experience of training 63,000+ professionals.',
        ],
        [
            'question' => 'What topics can corporate training cover?',
            'answer' => 'Three programme families: technology capability (cloud, data, AI, cybersecurity, DevOps, and platforms like Salesforce, Workday, and ServiceNow), leadership in practice for managers and future leaders, and workforce essentials covering high-impact business skills for every function.',
        ],
        [
            'question' => 'Can training be delivered to teams in multiple locations?',
            'answer' => 'Yes. Corporate Academy delivers consistently across multiple locations, regions, and time zones, combining live online sessions, in-person workshops, and self-paced reinforcement under one accountable partner.',
        ],
        [
            'question' => 'How is the impact of corporate training measured?',
            'answer' => 'Every engagement starts with a baseline skills map tied to business priorities, then tracks movement from baseline confidence to applied performance. Leadership teams receive an evidence trail with success measures agreed before delivery begins.',
        ],
        [
            'question' => 'Is there a minimum team size for corporate programmes?',
            'answer' => 'No fixed minimum. Learning paths are role-based and scale from a single team to an enterprise-wide rollout; the discovery phase sizes the programme to your capability gap and budget.',
        ],
        [
            'question' => 'How do we get a corporate training proposal?',
            'answer' => 'Submit the enquiry form on this page with your team size, goals, and timeline, or call +91-88001-82225. A programme consultant follows up with a discovery call and a tailored proposal, typically within two business days.',
        ],
    ];

    /** @var list<array{question:string,answer:string}> */
    public const ABOUT = [
        [
            'question' => 'What is Corporate Academy?',
            'answer' => 'Corporate Academy is a technology training institute headquartered in Noida, India, that has trained over 63,000 professionals worldwide. It offers online certification courses in data science, AI, cloud, cybersecurity, software engineering and more, plus doctorate (DBA) programmes with accredited international partner universities.',
        ],
        [
            'question' => "Who are Corporate Academy's courses for?",
            'answer' => 'Working professionals at every stage — from individual contributors upskilling into tech roles to senior executives pursuing a doctorate. Enterprise teams can also access tailored corporate training programmes.',
        ],
        [
            'question' => "Are Corporate Academy certifications recognised by employers?",
            'answer' => 'Yes. Courses end with industry-recognised certifications, are taught by industry-expert trainers, and are backed by career support — Corporate Academy reports a 92% placement rate across its programmes.',
        ],
        [
            'question' => 'Where is Corporate Academy located, and can I study remotely?',
            'answer' => 'Corporate Academy is based in Noida and New Delhi, India, with offices in Essen (Germany) and Dubai (UAE). All courses are delivered fully online, so you can study from anywhere in the world.',
        ],
    ];

    /** @var list<array{question:string,answer:string}> */
    public const DOCTORATE = [
        ['question' => 'Who is the DBA programme designed for?', 'answer' => 'The DBA is designed for senior professionals with 10+ years of work experience who want to earn a research-based doctoral credential while continuing to work.'],
        ['question' => 'Is the DBA equivalent to a PhD?', 'answer' => 'The Doctor of Business Administration (DBA) is a doctoral-level qualification equivalent in academic standing to a PhD, but with a practitioner research focus rather than theoretical.'],
        ['question' => 'Can I study the DBA online?', 'answer' => 'Yes. All Corporate Academy DBA programmes are delivered fully online with live virtual sessions, allowing you to study without interrupting your career.'],
        ['question' => 'How long does the DBA programme take?', 'answer' => 'DBA programmes typically take 2–4 years depending on the stream and your pace of study. Part-time options are available for working professionals.'],
    ];

    /**
     * Category slugs → display names (union of every catalog category).
     * Ported verbatim from faqs.ts CATEGORY_NAMES.
     *
     * @var array<string,string>
     */
    public const CATEGORY_NAMES = [
        'data-science' => 'Data Science',
        'ai' => 'Artificial Intelligence',
        'machine-learning' => 'Machine Learning',
        'workday' => 'Workday',
        'servicenow' => 'ServiceNow',
        'salesforce' => 'Salesforce',
        'microsoft-dynamics' => 'Microsoft Dynamics 365',
        'oracle' => 'Oracle Cloud',
        'six-sigma' => 'Six Sigma & Lean',
        'pmp' => 'PMP & Project Management',
        'cloud-computing' => 'Cloud Computing & DevOps',
        'agile' => 'Agile & Scrum',
        'big-data' => 'Big Data',
        'blockchain' => 'Blockchain',
        'business-management' => 'Business Management',
        'comptia' => 'CompTIA',
        'database' => 'Database',
        'devops' => 'DevOps',
        'digital-marketing' => 'Digital Marketing',
        'finance' => 'Finance',
        'it-security' => 'IT Security',
        'itsm' => 'IT Service Management',
        'medical-coding' => 'Medical Coding',
        'mobile-app-development' => 'Mobile App Development',
        'other' => 'Other Professional Skills',
        'programming' => 'Programming',
        'quality-management' => 'Quality Management',
        'risk-management' => 'Risk Management',
        'soft-skills' => 'Soft Skills Training',
        'software-development' => 'Software Development',
        'software-testing' => 'Software Testing',
        'web-development' => 'Web Development',
        'bi-visualization' => 'BI & Visualization',
    ];

    /**
     * Build the category-page FAQ list. `$stats` mirrors CategoryFaqStats in
     * faqs.ts (courseCount, topTitles, minHours, maxHours, beginnerCount).
     * Missing values fall back to the generic phrasing.
     *
     * @param  array{courseCount?:int,topTitles?:list<string>,minHours?:int,maxHours?:int,beginnerCount?:int}  $stats
     * @return list<array{question:string,answer:string}>
     */
    public static function buildCategoryFaqs(string $name, array $stats = []): array
    {
        $courseCount = $stats['courseCount'] ?? 0;
        $topTitles = $stats['topTitles'] ?? [];
        $minHours = $stats['minHours'] ?? 0;
        $maxHours = $stats['maxHours'] ?? 0;
        $beginnerCount = $stats['beginnerCount'] ?? 0;

        $coursePhrase = $courseCount > 0
            ? $courseCount . ' ' . $name . ' course' . ($courseCount === 1 ? '' : 's')
            : 'a growing range of ' . $name . ' courses';
        $titlesPhrase = count($topTitles) ? ', including ' . implode(', ', $topTitles) : '';

        return [
            [
                'question' => "What {$name} courses does Corporate Academy offer?",
                'answer' => "Corporate Academy offers {$coursePhrase}{$titlesPhrase}. All are taught by industry experts and lead to a globally recognized certification.",
            ],
            [
                'question' => "How long does {$name} training take?",
                'answer' => $minHours > 0
                    ? "{$name} courses at Corporate Academy run from {$minHours} to {$maxHours} hours of instruction, which most working professionals complete in a few weeks to a few months part-time. Each course page lists its exact duration and level."
                    : "Most {$name} courses take a few weeks to a few months to complete part-time. Each course page lists its exact duration in hours and its level.",
            ],
            [
                'question' => "Can I learn {$name} online?",
                'answer' => "Yes. Corporate Academy delivers {$name} training in live online, self-paced, and hybrid formats, so you can study from anywhere and fit classes around a full-time job.",
            ],
            [
                'question' => "Is {$name} training suitable for beginners?",
                'answer' => $beginnerCount > 0
                    ? "Yes. {$beginnerCount} of the {$name} course" . ($beginnerCount === 1 ? ' is' : 's are') . " beginner-level and assume no prior experience, with intermediate and advanced tracks to progress into. Career counsellors can help you pick the right starting point."
                    : "Courses in this path list their level (beginner, intermediate, or advanced) on each course page, and career counsellors on +91-88001-82225 can help you pick the right starting point for your background.",
            ],
            [
                'question' => "Do I get a certificate after completing a {$name} course?",
                'answer' => "Yes. Every {$name} course ends with a globally recognized Corporate Academy certification, and many prepare you for related vendor certification exams. Over 63,000 professionals have been certified through Corporate Academy programmes.",
            ],
            [
                'question' => "How much does {$name} training cost?",
                'answer' => "Fees vary by course length and are quoted in INR when you enquire. Scholarships cover up to 50% of the fee for eligible learners, with decisions within 48 business hours.",
            ],
        ];
    }

    /**
     * Build a partner-university FAQ list. `$uni` mirrors PartnerUniversity
     * (name, type, location, country, founded, accreditations, programs where
     * each program has title, duration, mode).
     *
     * @param  array{name:string,type:string,location:string,country:string,founded:int|string,accreditations:list<string>,programs:list<array{title:string,duration:string,mode:string}>}  $uni
     * @return list<array{question:string,answer:string}>
     */
    public static function buildUniversityFaqs(array $uni): array
    {
        $name = $uni['name'];
        $programsList = implode('; ', array_map(
            static fn (array $p) => "{$p['title']} ({$p['duration']}, {$p['mode']})",
            $uni['programs'],
        ));

        $residency = array_values(array_filter(
            $uni['programs'],
            static fn (array $p) => (bool) preg_match('/residency/i', $p['mode']),
        ));
        $base = "Yes. {$name} doctoral programmes offered through Corporate Academy are structured for working professionals, with coursework delivered online.";
        if (count($residency)) {
            $residencyPhrase = implode(' and ', array_map(
                static fn (array $p) => "{$p['title']} ({$p['mode']})",
                $residency,
            ));
            $workAnswer = "{$base} Note that {$residencyPhrase} include" . (count($residency) === 1 ? 's' : '') . ' an in-person residency component.';
        } else {
            $workAnswer = "{$base} All listed programmes are fully online, with no travel required.";
        }

        return [
            [
                'question' => "Is {$name} accredited?",
                'answer' => "Yes. {$name} holds the following accreditations and recognitions: " . implode('; ', $uni['accreditations']) . '.',
            ],
            [
                'question' => "What doctoral programmes does {$name} offer through Corporate Academy?",
                'answer' => "{$name} awards: {$programsList}.",
            ],
            [
                'question' => "Where is {$name} located?",
                'answer' => "{$name} is a " . strtolower($uni['type']) . " based in {$uni['location']}, {$uni['country']}, established in {$uni['founded']}. Coursework is designed for working executives and delivered in the mode listed for each programme.",
            ],
            [
                'question' => "Can I complete a {$name} doctorate while working full-time?",
                'answer' => $workAnswer,
            ],
        ];
    }
}
