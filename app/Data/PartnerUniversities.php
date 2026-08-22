<?php

    namespace App\Data;

    /**
    * Tied-up partner universities — ported verbatim from
    * artifacts/corporate-academy/src/lib/universities.ts (English source).
    */
    class PartnerUniversities
    {
      /**
       * @return array<int, array<string, mixed>>
       */
      public static function all(): array
      {
          return [
            [
                'slug' => 'golden-gate-university',
                'initials' => 'GGU',
                'name' => 'Golden Gate University',
                'shortName' => 'Golden Gate University, San Francisco (USA)',
                'location' => 'San Francisco, California',
                'country' => 'USA',
                'founded' => '1901',
                'type' => 'Private, non-profit university',
                'color' => 'from-blue-600 to-indigo-700',
                'blurb' => '#1 US university for working professionals. DBA, Doctor of Technology, MBA + DBA pathway, and DBA in Emerging Technologies (Generative & Agentic AI).',
                'about' => [
                    'Founded in 1901 in the heart of San Francisco, Golden Gate University has spent more than a century educating professionals who study while they work. It is consistently ranked the #1 university for working adults in the United States.',
                    'GGU\'s doctoral programmes are built around applied research — candidates investigate real business problems from their own organisations under the supervision of senior academic and industry mentors, with optional on-campus immersions in San Francisco.',
                ],
                'accreditations' => [
                    'WASC Senior College and University Commission (WSCUC)',
                    'Recognised by the US Department of Education',
                ],
                'highlights' => [
                    '#1 university for working professionals in the U.S.',
                    '120+ years of professional education heritage',
                    'On-campus immersion in San Francisco',
                    'Faculty of senior industry practitioners',
                ],
                'programs' => [
                    [
                        'title' => 'Doctor of Business Administration (DBA)',
                        'duration' => '3 Years',
                        'mode' => 'Online + Residency',
                    ],
                    [
                        'title' => 'Doctor of Technology',
                        'duration' => '3 Years',
                        'mode' => 'Online',
                    ],
                    [
                        'title' => 'Master + Doctor of Business Administration (MBA + DBA)',
                        'duration' => '4 Years',
                        'mode' => 'Online',
                    ],
                    [
                        'title' => 'DBA in Emerging Technologies (Generative & Agentic AI)',
                        'duration' => '3 Years',
                        'mode' => 'Online',
                    ],
                ],
                'stats' => [
                    [
                        'label' => 'Founded',
                        'value' => '1901',
                    ],
                    [
                        'label' => 'Alumni Network',
                        'value' => '68,000+',
                    ],
                    [
                        'label' => 'US Ranking',
                        'value' => '#1 for working adults',
                    ],
                ],
                'website' => 'https://www.ggu.edu',
            ],
            [
                'slug' => 'edgewood-university',
                'initials' => 'EU',
                'name' => 'Edgewood University',
                'shortName' => 'Edgewood University (USA)',
                'location' => 'Madison, Wisconsin',
                'country' => 'USA',
                'founded' => '1927',
                'type' => 'Private liberal-arts university',
                'color' => 'from-red-600 to-rose-700',
                'blurb' => 'US-accredited Doctorate in Business Administration and dual-degree MBA + DBA with lifetime Edgewood alumni status.',
                'about' => [
                    'Edgewood University is a US-accredited institution based in Madison, Wisconsin, known for personalised education and strong professional outcomes across business disciplines.',
                    'Its online Doctorate in Business Administration is designed for executives who want a rigorous, research-driven credential — including a dual-degree MBA + DBA pathway — while earning lifetime Edgewood alumni status.',
                ],
                'accreditations' => [
                    'Higher Learning Commission (HLC), USA',
                    'Recognised by the US Department of Education',
                ],
                'highlights' => [
                    'Lifetime Edgewood alumni status',
                    'Dual-degree MBA + DBA pathway',
                    'Personalised doctoral supervision',
                    'Flexible, fully online delivery',
                ],
                'programs' => [
                    [
                        'title' => 'Doctorate in Business Administration',
                        'duration' => '3 Years',
                        'mode' => 'Online',
                    ],
                    [
                        'title' => 'Dual Degree MBA + DBA',
                        'duration' => '4 Years',
                        'mode' => 'Online',
                    ],
                ],
                'stats' => [
                    [
                        'label' => 'Founded',
                        'value' => '1927',
                    ],
                    [
                        'label' => 'Student-Faculty Ratio',
                        'value' => '10:1',
                    ],
                    [
                        'label' => 'Location',
                        'value' => 'Madison, WI',
                    ],
                ],
                'website' => 'https://www.edgewood.edu',
            ],
            [
                'slug' => 'esgci-paris',
                'initials' => 'ESGCI',
                'name' => 'ESGCI, Paris',
                'shortName' => 'ESGCI, Paris (France)',
                'location' => 'Paris',
                'country' => 'France',
                'founded' => '1986',
                'type' => 'Grande-école business school',
                'color' => 'from-violet-600 to-purple-700',
                'blurb' => 'One of France\'s leading grande-école business schools, offering an internationally recognised Doctorate of Business Administration.',
                'about' => [
                    'ESGCI is one of Paris\'s leading business schools, part of the renowned French grande-école tradition, with a strong focus on international business, marketing, and entrepreneurship.',
                    'Its Doctorate of Business Administration attracts executives from across Europe, Africa, and Asia who want a doctoral credential from a Paris-based institution with a truly global cohort.',
                ],
                'accreditations' => [
                    'Recognised by the French Ministry of Higher Education',
                    'Member of the Conférence des Grandes Écoles ecosystem',
                ],
                'highlights' => [
                    'Paris-based grande-école heritage',
                    'Truly international doctoral cohorts',
                    'Strengths in marketing, trade & entrepreneurship',
                    'European doctoral research standards',
                ],
                'programs' => [
                    [
                        'title' => 'Doctorate of Business Administration',
                        'duration' => '3 Years',
                        'mode' => 'Online + Paris Residency',
                    ],
                ],
                'stats' => [
                    [
                        'label' => 'Founded',
                        'value' => '1986',
                    ],
                    [
                        'label' => 'Students',
                        'value' => '3,000+',
                    ],
                    [
                        'label' => 'Campus',
                        'value' => 'Paris, France',
                    ],
                ],
                'website' => 'https://www.esgci.com',
            ],
            [
                'slug' => 'rushford-business-school',
                'initials' => 'RBS',
                'name' => 'Rushford Business School',
                'shortName' => 'Rushford Business School (Switzerland)',
                'location' => 'Geneva',
                'country' => 'Switzerland',
                'founded' => '2020',
                'type' => 'Swiss online business school',
                'color' => 'from-emerald-600 to-teal-700',
                'blurb' => 'Swiss quality-certified Doctor of Business Administration designed for senior executives across the globe.',
                'about' => [
                    'Rushford Business School is the business school of the James Lind Institute, Geneva — a Swiss institution focused on flexible, high-quality online education for working professionals worldwide.',
                    'Its Doctor of Business Administration combines Swiss quality certification with a fully online, executive-friendly format, making it a popular choice for leaders in healthcare, operations, hospitality, and project-intensive industries.',
                ],
                'accreditations' => [
                    'EduQua — Swiss quality certification for education providers',
                    'Institutional membership of international business-education bodies',
                ],
                'highlights' => [
                    'Swiss quality-certified doctorate',
                    '100% online, executive-friendly format',
                    'Strong healthcare & operations focus',
                    'Global faculty and cohort',
                ],
                'programs' => [
                    [
                        'title' => 'Doctor of Business Administration',
                        'duration' => '3 Years',
                        'mode' => 'Online',
                    ],
                ],
                'stats' => [
                    [
                        'label' => 'Base',
                        'value' => 'Geneva, Switzerland',
                    ],
                    [
                        'label' => 'Delivery',
                        'value' => '100% Online',
                    ],
                    [
                        'label' => 'Cohort',
                        'value' => '40+ nationalities',
                    ],
                ],
                'website' => 'https://www.rushford.ch',
            ],
            [
                'slug' => 'liverpool-business-school',
                'initials' => 'LJMU',
                'name' => 'Liverpool Business School (LJMU)',
                'shortName' => 'Liverpool Business School – LJMU (UK)',
                'location' => 'Liverpool',
                'country' => 'United Kingdom',
                'founded' => '1823',
                'type' => 'Public university business school',
                'color' => 'from-amber-500 to-orange-600',
                'blurb' => 'Part of Liverpool John Moores University — a top UK institution powering globally respected doctoral and executive programmes.',
                'about' => [
                    'Liverpool Business School is the business faculty of Liverpool John Moores University (LJMU), whose roots reach back to 1823. LJMU is one of the UK\'s largest and most respected modern universities.',
                    'Its executive and doctoral-level programmes carry the weight of a UK public university credential, with a strong emphasis on leadership, public policy, sustainability, and applied management research.',
                ],
                'accreditations' => [
                    'UK degree-awarding powers (Office for Students registered)',
                    'AACSB member business school',
                ],
                'highlights' => [
                    'Heritage dating back to 1823',
                    'Top-tier modern UK university',
                    'Strengths in policy, ESG & leadership',
                    'Globally recognised UK credential',
                ],
                'programs' => [
                    [
                        'title' => 'Executive & Doctoral-level Business Programmes',
                        'duration' => '2–3 Years',
                        'mode' => 'Online + UK Residency',
                    ],
                ],
                'stats' => [
                    [
                        'label' => 'Founded',
                        'value' => '1823',
                    ],
                    [
                        'label' => 'Students',
                        'value' => '25,000+',
                    ],
                    [
                        'label' => 'Location',
                        'value' => 'Liverpool, UK',
                    ],
                ],
                'website' => 'https://www.ljmu.ac.uk',
            ],
        ];
      }

      /**
       * @return array<string, mixed>|null
       */
      public static function findBySlug(string $slug): ?array
      {
          foreach (self::all() as $u) {
              if ($u['slug'] === $slug) {
                  return $u;
              }
          }

          return null;
      }

      /**
       * @return array<string, mixed>|null
       */
      public static function findByShortName(string $shortName): ?array
      {
          foreach (self::all() as $u) {
              if ($u['shortName'] === $shortName) {
                  return $u;
              }
          }

          return null;
      }
    }
    