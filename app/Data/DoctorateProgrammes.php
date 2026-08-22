<?php

    namespace App\Data;

    /**
    * All 16 DBA programme detail records — ported verbatim from
    * artifacts/corporate-academy/src/data/doctorateProgrammes.ts (English source).
    * Free-text display fields are run through App\Services\ServerTranslator at
    * render time for non-English locales. Proper names stay English.
    */
    class DoctorateProgrammes
    {
      /**
       * @return array<string, array<string, mixed>>
       */
      public static function all(): array
      {
          return [
            'dba-general-management' => [
                'slug' => 'dba-general-management',
                'title' => 'Doctor of Business Administration (DBA)',
                'university' => 'Golden Gate University, San Francisco (USA)',
                'duration' => '3 Years',
                'mode' => 'Online + Residency',
                'rating' => 4.8,
                'reviewCount' => 642,
                'enrolled' => 1240,
                'badge' => 'Most Popular',
                'badgeColor' => 'bg-amber-500',
                'tag' => 'General Management',
                'tagline' => 'Earn the \'Dr.\' title while remaining a full-time executive leader',
                'description' => [
                    'The Corporate Academy Doctor of Business Administration is a Ph.D.-equivalent professional doctorate designed for senior executives who wish to advance their organisations through rigorous applied research. Unlike a traditional Ph.D., every module is immediately applicable — you will solve a real business challenge your organisation faces today.',
                    'Over three years you will move through doctoral foundations, specialist electives co-designed with PwC, KPMG, and Deloitte faculty, and a fully supervised dissertation that results in original, publishable knowledge. Residencies in London, Singapore, and Dubai place you inside global boardrooms and peer networks.',
                    'Graduates earn the internationally recognised \'Dr.\' title and join a community of 5,000+ DBA alumni who lead at the C-suite and board levels across 25+ countries.',
                ],
                'outcomes' => [
                    'Design and defend original doctoral-level research',
                    'Lead strategic change at organisation-wide scale',
                    'Apply advanced quantitative and qualitative research methods',
                    'Publish board-ready insights in peer-reviewed journals',
                    'Negotiate global partnerships and cross-border alliances',
                    'Build sustainable competitive advantage through innovation',
                    'Lead diverse, multicultural executive teams',
                    'Influence public policy and regulatory frameworks',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Doctoral Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Philosophy of Management Research',
                            'Advanced Quantitative Methods',
                            'Qualitative & Mixed-Methods Research',
                            'Academic Writing & Publication Ethics',
                            'Doctoral Mindset & Research Agility',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Strategic Leadership in the Digital Age',
                            'Global Financial Management',
                            'Innovation & Entrepreneurial Ecosystems',
                            'Organisational Behaviour & Change',
                            'PwC-Certified Corporate Governance Module',
                            'KPMG Risk & Assurance Elective',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Research',
                        'duration' => 'Months 19–36',
                        'topics' => [
                            'Research Proposal & Ethics Review',
                            'Field Data Collection & Analysis',
                            'Dissertation Drafting & Supervision',
                            'International Residency & Peer Review',
                            'Viva Voce & Public Defence',
                            'Post-Defence Publication Support',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Executive Officer',
                        'salary' => '₹ 80L – 3Cr PA',
                        'companies' => [
                            'Fortune 500',
                            'Tata Group',
                            'Mahindra',
                        ],
                    ],
                    [
                        'role' => 'Board Director',
                        'salary' => '₹ 40L – 1.5Cr PA',
                        'companies' => [
                            'SEBI-listed Cos.',
                            'Global MNCs',
                            'PSUs',
                        ],
                    ],
                    [
                        'role' => 'Distinguished Professor',
                        'salary' => '₹ 25–60L PA',
                        'companies' => [
                            'IIMs',
                            'ISB',
                            'Global B-Schools',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Prof. Arjun Mehta',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD Harvard · Ex-McKinsey Partner · IIM-A Faculty',
                        'tags' => [
                            'Strategy Research',
                            'Global Leadership',
                            'Organisational Design',
                        ],
                    ],
                    [
                        'name' => 'Dr. Claire Fontaine',
                        'title' => 'Dissertation Supervisor',
                        'credentials' => 'DBA London Business School · Ex-Deloitte EMEA',
                        'tags' => [
                            'Doctoral Methods',
                            'Change Management',
                            'Executive Coaching',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Is a DBA equivalent to a PhD?',
                        'a' => 'Yes. A DBA is a professional doctorate equivalent in academic standing to a PhD, but focused on applied management practice rather than pure theory. Graduates earn the \'Dr.\' title and are eligible for academic positions.',
                    ],
                    [
                        'q' => 'Can I study while working full-time?',
                        'a' => 'Absolutely. The programme is specifically designed for working executives. Live sessions are held on weekends; residencies are intensive week-long modules held twice per year.',
                    ],
                    [
                        'q' => 'What is the minimum work experience required?',
                        'a' => 'Applicants must have at least 10 years of professional experience, with a minimum of 5 years in senior management or leadership roles.',
                    ],
                    [
                        'q' => 'Will I get a supervisor for my dissertation?',
                        'a' => 'Yes. Each candidate is assigned a senior academic supervisor and an industry practice mentor from day one, ensuring both scholarly rigour and real-world relevance.',
                    ],
                    [
                        'q' => 'How are residencies conducted?',
                        'a' => 'Residencies are held in London, Singapore, and Dubai. They include masterclasses with global thought leaders, peer-to-peer workshops, and site visits to partner organisations.',
                    ],
                    [
                        'q' => 'What happens if I need to pause my studies?',
                        'a' => 'We offer a formal deferral policy allowing candidates to pause for up to 12 months due to professional or personal commitments, with no loss of academic standing.',
                    ],
                ],
                'eligibility' => [
                    'Masters or MBA from a recognised university',
                    '10+ years of professional experience',
                    '5+ years in senior management / leadership',
                    'Strong command of English (written & spoken)',
                    'Research interest statement (500 words)',
                    'Interview with admissions panel',
                ],
                'nextIntake' => 'September 2026',
                'cohortSize' => 25,
            ],
            'dba-digital-transformation' => [
                'slug' => 'dba-digital-transformation',
                'title' => 'Executive DBA in Digital Transformation',
                'university' => 'Golden Gate University, San Francisco (USA)',
                'duration' => '2.5 Years',
                'mode' => 'Online',
                'rating' => 4.7,
                'reviewCount' => 418,
                'enrolled' => 860,
                'badge' => 'New Batch',
                'badgeColor' => 'bg-green-500',
                'tag' => 'Technology',
                'tagline' => 'Lead enterprise-wide digital change with doctoral-level authority',
                'description' => [
                    'The Executive DBA in Digital Transformation is built for technology leaders, CDOs, and CIOs who need the academic depth to guide their organisations through AI, cloud, and platform-era disruption. You will produce doctoral-quality research on a live digital transformation initiative inside your own organisation.',
                    'The programme integrates AI strategy, data governance, and platform economics with rigorous research methods. Your dissertation will be a board-ready transformation playbook grounded in original evidence — not a textbook framework.',
                    'Delivered entirely online with asynchronous content and live weekend cohort sessions, the programme respects your calendar while connecting you with a global cohort of technology executives from 20+ industries.',
                ],
                'outcomes' => [
                    'Design and govern enterprise-scale digital transformation strategies',
                    'Apply AI and data analytics at the executive decision-making level',
                    'Conduct original research on technology-driven organisational change',
                    'Architect cloud-native operating models and platform ecosystems',
                    'Manage cyber risk and digital governance at board level',
                    'Lead cultural transformation alongside technology adoption',
                    'Publish technology leadership insights in peer-reviewed venues',
                    'Build C-suite credibility backed by doctoral-level evidence',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Research & Technology Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Design for Technology Leaders',
                            'Digital Transformation Frameworks & Evidence',
                            'AI, ML & Data Strategy for Executives',
                            'Platform Economics & Ecosystem Thinking',
                            'Academic Writing for Practitioners',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Deep Dives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Cloud Architecture & Operating Model Design',
                            'Cyber Risk & Digital Governance',
                            'Change Management in Digital Organisations',
                            'Emerging Tech: Blockchain, IoT, Quantum',
                            'C-Suite Mentoring & Case Clinics',
                            'Capstone Industry Research Sprint',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–30',
                        'topics' => [
                            'Research Proposal & Ethics Clearance',
                            'Primary Data Collection',
                            'Dissertation Writing & Supervision',
                            'Peer Reviewer Feedback Cycles',
                            'Viva Voce Defence',
                            'Publication & Knowledge Dissemination',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Digital Officer',
                        'salary' => '₹ 60L – 2Cr PA',
                        'companies' => [
                            'Infosys',
                            'Wipro',
                            'HDFC Bank',
                        ],
                    ],
                    [
                        'role' => 'Chief Information Officer',
                        'salary' => '₹ 50L – 1.5Cr PA',
                        'companies' => [
                            'TCS',
                            'Reliance',
                            'Airtel',
                        ],
                    ],
                    [
                        'role' => 'VP / Director – Digital',
                        'salary' => '₹ 40L – 1Cr PA',
                        'companies' => [
                            'Accenture',
                            'Deloitte',
                            'IBM',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Dr. Rohan Kapoor',
                        'title' => 'Programme Lead',
                        'credentials' => 'DBA MIT Sloan · Ex-Google Cloud Strategy Lead',
                        'tags' => [
                            'AI Strategy',
                            'Platform Economics',
                            'Digital Governance',
                        ],
                    ],
                    [
                        'name' => 'Prof. Sandra Walsh',
                        'title' => 'Research Supervisor',
                        'credentials' => 'PhD Oxford · 20 yrs digital transformation consulting',
                        'tags' => [
                            'Change Research',
                            'Organisational Behaviour',
                            'Tech Ethics',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need a technology background to apply?',
                        'a' => 'Yes — applicants should have at least 5 years of experience in technology leadership, product management, or digital strategy roles. Prior coding skills are not required.',
                    ],
                    [
                        'q' => 'Is the programme fully online?',
                        'a' => 'Yes. All taught content is delivered online with live cohort sessions on weekends. There are no mandatory in-person residencies, though optional networking intensives are offered.',
                    ],
                    [
                        'q' => 'Will my dissertation be based on my own organisation?',
                        'a' => 'Where possible, yes. The programme encourages candidates to use their own organisation as the research site, producing actionable insights with immediate business value.',
                    ],
                    [
                        'q' => 'How are live sessions structured?',
                        'a' => 'Live sessions run on Saturday mornings (3–4 hours) and are recorded for asynchronous viewing. Dissertation supervision is conducted via 1:1 video calls with your assigned supervisor.',
                    ],
                    [
                        'q' => 'What is the time commitment per week?',
                        'a' => 'Expect 10–15 hours per week during taught phases, reducing to 8–10 hours during the dissertation phase as your research becomes self-directed.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, or equivalent from a recognised institution',
                    '10+ years professional experience',
                    '5+ years in technology leadership, product, or digital strategy',
                    'Research interest statement on a digital transformation topic',
                    'Interview with programme director',
                ],
                'nextIntake' => 'October 2026',
                'cohortSize' => 20,
            ],
            'dba-finance-global-markets' => [
                'slug' => 'dba-finance-global-markets',
                'title' => 'DBA in Finance & Global Markets',
                'university' => 'Edgewood University (USA)',
                'duration' => '3 Years',
                'mode' => 'Blended',
                'rating' => 4.6,
                'reviewCount' => 327,
                'enrolled' => 680,
                'badge' => null,
                'badgeColor' => '',
                'tag' => 'Finance',
                'tagline' => 'Doctoral-level mastery of global finance, capital markets, and financial strategy',
                'description' => [
                    'The DBA in Finance & Global Markets prepares senior finance leaders to produce doctoral-quality research on capital markets, financial strategy, and cross-border investment. The programme integrates CFA-pathway electives, quantitative modelling, and global market fieldwork to create finance executives who lead with evidence.',
                    'You will explore derivative pricing, fixed-income strategy, ESG investing, and emerging-market dynamics through a research lens — culminating in a dissertation that contributes original insight to the financial services industry.',
                    'Delivered in blended format with live weekend cohort sessions and two international finance intensives (London and Singapore), the programme is designed for CFOs, treasury heads, investment bankers, and fund managers.',
                ],
                'outcomes' => [
                    'Conduct original research on global capital markets and financial instruments',
                    'Design and evaluate advanced financial models and risk frameworks',
                    'Integrate ESG and sustainable finance into investment strategy',
                    'Lead cross-border M&A, treasury, and capital-raising at executive level',
                    'Publish peer-reviewed research in leading finance journals',
                    'Advise boards on financial risk, regulatory capital, and governance',
                    'Apply behavioural finance insights to investment decision-making',
                    'Manage quantitative research with Python, R, and Bloomberg data',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Financial Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Advanced Research Methods in Finance',
                            'Econometrics & Quantitative Finance',
                            'Global Capital Markets & Derivatives',
                            'Corporate Finance & Valuation Theory',
                            'Academic Writing & Journal Standards',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Finance Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'CFA-Aligned Investment Strategy',
                            'ESG & Sustainable Finance',
                            'Fixed Income & Credit Markets',
                            'Behavioural Finance & Market Anomalies',
                            'Emerging Market Dynamics',
                            'Financial Regulation & Compliance',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–36',
                        'topics' => [
                            'Research Proposal & IRB Clearance',
                            'Market Data Collection & Cleaning',
                            'Quantitative Analysis & Modelling',
                            'Draft Dissertation & Supervisor Review',
                            'Viva Voce Defence',
                            'Publication in a Finance Journal',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Financial Officer',
                        'salary' => '₹ 70L – 2.5Cr PA',
                        'companies' => [
                            'HDFC',
                            'ICICI',
                            'Bajaj Finance',
                        ],
                    ],
                    [
                        'role' => 'Managing Director – Investment Banking',
                        'salary' => '₹ 1Cr – 4Cr PA',
                        'companies' => [
                            'Goldman Sachs',
                            'JP Morgan',
                            'Kotak',
                        ],
                    ],
                    [
                        'role' => 'Finance Professor / Researcher',
                        'salary' => '₹ 30–70L PA',
                        'companies' => [
                            'IIM',
                            'ISB',
                            'IIT Business Schools',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Prof. Vikram Sinha',
                        'title' => 'Programme Chair',
                        'credentials' => 'PhD Chicago Booth · Ex-Goldman Sachs · CFA Charterholder',
                        'tags' => [
                            'Capital Markets',
                            'Quantitative Finance',
                            'ESG Investing',
                        ],
                    ],
                    [
                        'name' => 'Dr. Priya Venkatesan',
                        'title' => 'Dissertation Supervisor',
                        'credentials' => 'DBA London School of Economics · Ex-RBI Deputy Director',
                        'tags' => [
                            'Monetary Policy',
                            'Banking Research',
                            'Risk Management',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need the CFA qualification to apply?',
                        'a' => 'No, CFA is not required, but candidates with CFA Level 1 or above will find the elective modules highly complementary. CFA-pathway electives are available as optional modules.',
                    ],
                    [
                        'q' => 'What software and data tools will I use?',
                        'a' => 'The programme uses Python, R, Stata, and Bloomberg Terminal access for quantitative research.',
                    ],
                    [
                        'q' => 'Are the residencies mandatory?',
                        'a' => 'Two international finance intensives (London and Singapore) are strongly recommended. They include guest sessions with central bank governors and asset management executives.',
                    ],
                    [
                        'q' => 'Can I write my dissertation on a topic from my current organisation?',
                        'a' => 'Yes, and it is encouraged. Many candidates use proprietary market data from their employer, producing research with immediate commercial value.',
                    ],
                ],
                'eligibility' => [
                    'MBA / Masters in Finance or Economics',
                    '10+ years in finance, investment, or banking',
                    '5+ years in a senior financial leadership role',
                    'Research interest statement on a finance topic',
                    'Quantitative aptitude assessment',
                    'Interview with admissions panel',
                ],
                'nextIntake' => 'September 2026',
                'cohortSize' => 20,
            ],
            'dba-human-capital' => [
                'slug' => 'dba-human-capital',
                'title' => 'DBA in Human Capital & Organisational Design',
                'university' => 'Rushford Business School (Switzerland)',
                'duration' => '2.5 Years',
                'mode' => 'Online',
                'rating' => 4.5,
                'reviewCount' => 289,
                'enrolled' => 540,
                'badge' => null,
                'badgeColor' => '',
                'tag' => 'HR & Leadership',
                'tagline' => 'Reshape how organisations attract, develop, and retain their greatest asset — people',
                'description' => [
                    'The DBA in Human Capital & Organisational Design is built for CHROs, people analytics leaders, and talent strategists who want to elevate HR from a support function to a value-creating research discipline. You will investigate employee experience, workforce analytics, and organisational design through rigorous doctoral methods.',
                    'The programme blends behavioural science, systems thinking, and advanced HR analytics. Your dissertation will produce original evidence on a workforce challenge your organisation faces — from hybrid work effectiveness to succession planning at scale.',
                ],
                'outcomes' => [
                    'Design research-backed talent strategies for complex organisations',
                    'Apply people analytics to strategic workforce planning',
                    'Lead organisational redesign and culture transformation at scale',
                    'Develop executive coaching and leadership development frameworks',
                    'Produce doctoral-quality research on employee engagement and retention',
                    'Influence board-level decisions on human capital investment',
                    'Build evidence-based DEI frameworks grounded in research',
                    'Publish in leading HR, OB, and management journals',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Research & HR Science Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods for People Scientists',
                            'Organisational Behaviour Theory',
                            'People Analytics & HR Data Science',
                            'Advanced Psychometrics & Survey Design',
                            'Academic Writing for HR Leaders',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist People Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Strategic Talent Acquisition & Employer Brand',
                            'Learning & Development Science',
                            'Organisational Design & Job Architecture',
                            'Executive Coaching Methodologies',
                            'DEI Research & Inclusive Leadership',
                            'Change Management & Culture Research',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–30',
                        'topics' => [
                            'Research Proposal on a Live HR Challenge',
                            'Qualitative Interviews & Focus Groups',
                            'Data Analysis with R / NVivo',
                            'Dissertation Drafting & Supervision',
                            'Viva Voce Defence',
                            'HR Journal Publication Support',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Human Resources Officer',
                        'salary' => '₹ 50L – 1.8Cr PA',
                        'companies' => [
                            'Infosys',
                            'HUL',
                            'Reliance',
                        ],
                    ],
                    [
                        'role' => 'VP – People & Culture',
                        'salary' => '₹ 35L – 80L PA',
                        'companies' => [
                            'Swiggy',
                            'Flipkart',
                            'Razorpay',
                        ],
                    ],
                    [
                        'role' => 'Organisational Development Consultant',
                        'salary' => '₹ 25L – 60L PA',
                        'companies' => [
                            'Deloitte',
                            'Mercer',
                            'Korn Ferry',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Dr. Ananya Sharma',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD Cambridge · Ex-Unilever Global HR Director',
                        'tags' => [
                            'People Analytics',
                            'Culture Transformation',
                            'Executive Coaching',
                        ],
                    ],
                    [
                        'name' => 'Prof. David O\'Brien',
                        'title' => 'Organisational Design Lead',
                        'credentials' => 'DBA INSEAD · McKinsey OD Practice · Author of \'Designing Work\'',
                        'tags' => [
                            'OD Research',
                            'Job Architecture',
                            'Hybrid Work',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Is this programme only for HR professionals?',
                        'a' => 'No. The programme welcomes business leaders, organisational psychologists, L&D directors, and anyone with a senior role involving people and culture, even if their job title is not in HR.',
                    ],
                    [
                        'q' => 'Will I need to conduct interviews with employees?',
                        'a' => 'Many dissertations involve primary qualitative research — interviews, surveys, or focus groups. We guide you through ethics approval, consent processes, and confidentiality frameworks.',
                    ],
                    [
                        'q' => 'What analytics tools are covered?',
                        'a' => 'The programme covers R for statistical analysis, NVivo for qualitative coding, Power BI for HR dashboards, and survey platforms including Qualtrics.',
                    ],
                ],
                'eligibility' => [
                    'Masters or MBA from a recognised institution',
                    '10+ years professional experience',
                    '5+ years in HR, OD, L&D, or people leadership',
                    'Research interest statement on a people/culture topic',
                    'Interview with programme director',
                ],
                'nextIntake' => 'October 2026',
                'cohortSize' => 22,
            ],
            'dba-supply-chain' => [
                'slug' => 'dba-supply-chain',
                'title' => 'DBA in Supply Chain & Operations',
                'university' => 'Liverpool Business School – LJMU (UK)',
                'duration' => '3 Years',
                'mode' => 'Online + Residency',
                'rating' => 4.6,
                'reviewCount' => 302,
                'enrolled' => 610,
                'badge' => 'Trending',
                'badgeColor' => 'bg-blue-500',
                'tag' => 'Operations',
                'tagline' => 'Build supply chains that are resilient, sustainable, and digitally intelligent',
                'description' => [
                    'The DBA in Supply Chain & Operations is designed for COOs, supply chain directors, and operations leaders who wish to transform their expertise into doctoral-level research. You will investigate global supply chain resilience, lean operations, Industry 4.0 integration, and sustainability through applied research.',
                    'Graduates design evidence-based operations strategies that can withstand disruption — geopolitical shocks, climate risk, and digital transformation. The Six Sigma Black Belt elective is integrated into Phase 2, providing an internationally recognised quality credential alongside your doctorate.',
                ],
                'outcomes' => [
                    'Design resilient, sustainable global supply chain architectures',
                    'Conduct doctoral research on operations management challenges',
                    'Apply Industry 4.0 and IoT technologies to operations strategy',
                    'Lead lean and Six Sigma transformations at enterprise scale',
                    'Model supply chain risk using quantitative simulation tools',
                    'Publish in leading operations management journals',
                    'Influence procurement, logistics, and sustainability strategy at board level',
                    'Manage cross-border supplier networks across emerging markets',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Operations Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods in Operations Management',
                            'Supply Chain Strategy & Network Design',
                            'Lean & Six Sigma for Researchers',
                            'Quantitative Modelling & Simulation',
                            'Sustainability & Circular Economy Basics',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Six Sigma Black Belt Certification Track',
                            'Global Procurement & Supplier Relations',
                            'Industry 4.0: Smart Factories & IoT',
                            'Supply Chain Risk & Resilience',
                            'Sustainable Logistics & ESG Reporting',
                            'Operations Leadership Residency (London/Dubai)',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–36',
                        'topics' => [
                            'Research Proposal on a Live Operations Problem',
                            'Data Collection from Supply Chain Systems',
                            'Statistical & Simulation Analysis',
                            'Dissertation Writing & Supervision',
                            'Viva Voce Defence',
                            'Journal Submission Support',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Operating Officer',
                        'salary' => '₹ 60L – 2Cr PA',
                        'companies' => [
                            'Amazon India',
                            'Mahindra Logistics',
                            'Reliance Retail',
                        ],
                    ],
                    [
                        'role' => 'VP – Global Supply Chain',
                        'salary' => '₹ 40L – 1Cr PA',
                        'companies' => [
                            'Unilever',
                            '3M',
                            'Bosch India',
                        ],
                    ],
                    [
                        'role' => 'Operations Research Consultant',
                        'salary' => '₹ 25L – 60L PA',
                        'companies' => [
                            'McKinsey',
                            'BCG',
                            'Accenture',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Prof. Rajesh Nair',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD Michigan Ross · Ex-Amazon Supply Chain VP · Six Sigma MBB',
                        'tags' => [
                            'Supply Chain Resilience',
                            'Lean Research',
                            'Industry 4.0',
                        ],
                    ],
                    [
                        'name' => 'Dr. Fatima Al-Rashid',
                        'title' => 'Dissertation Lead',
                        'credentials' => 'DBA Cranfield · Ex-Unilever COO MEA Region',
                        'tags' => [
                            'Sustainable Logistics',
                            'Procurement Research',
                            'Risk Modelling',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Is the Six Sigma Black Belt certification included?',
                        'a' => 'Yes. The Six Sigma Black Belt certification track is fully integrated into Phase 2. Candidates who complete the project and exam receive the Black Belt certificate from our accredited partner.',
                    ],
                    [
                        'q' => 'Are residencies mandatory for this programme?',
                        'a' => 'Two residencies are strongly recommended — one in London (operations strategy) and one in Dubai (logistics & trade). They include factory visits, port authority tours, and global supply chain executive panels.',
                    ],
                    [
                        'q' => 'What simulation tools does the programme use?',
                        'a' => 'The programme covers Arena Simulation, AnyLogic, and Python-based supply chain models. Training in these tools is provided as part of the quantitative methods module.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, or Engineering degree',
                    '10+ years in supply chain, operations, or manufacturing',
                    '5+ years in a senior operations leadership role',
                    'Research interest statement on an operations topic',
                    'Interview with admissions panel',
                ],
                'nextIntake' => 'September 2026',
                'cohortSize' => 20,
            ],
            'dba-entrepreneurship' => [
                'slug' => 'dba-entrepreneurship',
                'title' => 'DBA in Entrepreneurship & Innovation',
                'university' => 'ESGCI, Paris (France)',
                'duration' => '2 Years',
                'mode' => 'Online',
                'rating' => 4.7,
                'reviewCount' => 395,
                'enrolled' => 820,
                'badge' => null,
                'badgeColor' => '',
                'tag' => 'Entrepreneurship',
                'tagline' => 'Produce the research that helps the next generation of startups and corporate innovators thrive',
                'description' => [
                    'The DBA in Entrepreneurship & Innovation is designed for founders, innovation directors, venture capitalists, and corporate entrepreneurs who want to ground their practice in doctoral-level research. The programme is shorter than traditional DBA routes — two years — because the dissertation is embedded in live startup or innovation lab activity.',
                    'You will study venture ecosystems, disruptive innovation theory, IP commercialisation, and startup financing — then apply rigorous research methods to a real entrepreneurial challenge. Graduates use the \'Dr.\' title and their evidence-base to raise capital, influence policy, and lead corporate innovation at the highest level.',
                ],
                'outcomes' => [
                    'Design research-backed innovation and venture development frameworks',
                    'Apply entrepreneurship theory to live startup and corporate innovation contexts',
                    'Evaluate venture financing structures using rigorous financial research',
                    'Develop IP commercialisation and technology transfer strategies',
                    'Lead corporate entrepreneurship and intrapreneurship programmes',
                    'Publish original research on entrepreneurial ecosystems',
                    'Advise boards and investors using doctoral-level evidence',
                    'Build and sustain innovation culture in established organisations',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Innovation Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Design for Entrepreneurs',
                            'Innovation & Disruption Theory',
                            'Venture Finance & Startup Economics',
                            'IP Law, Patents & Commercialisation',
                            'Entrepreneurial Ecosystems Research',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Electives & Lab',
                        'duration' => 'Months 7–15',
                        'topics' => [
                            'Corporate Entrepreneurship & Intrapreneurship',
                            'Growth Marketing & Customer Discovery Research',
                            'Board Governance for Founder-Led Companies',
                            'Impact Investing & Social Entrepreneurship',
                            'Startup Lab Immersion (4-week sprint)',
                            'Venture Funding Masterclass with VCs',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 16–24',
                        'topics' => [
                            'Research Proposal on Live Entrepreneurial Problem',
                            'Primary Research: Interviews, Surveys, Experiments',
                            'Analysis & Frameworks Development',
                            'Dissertation Writing & Supervision',
                            'Viva Voce Defence',
                            'Practitioner Publication & Media Outreach',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Founder / CEO',
                        'salary' => 'Equity + ₹ 30L – 1Cr+ PA',
                        'companies' => [
                            'Own Ventures',
                            'YC-backed Startups',
                            'VC-funded Scale-ups',
                        ],
                    ],
                    [
                        'role' => 'Chief Innovation Officer',
                        'salary' => '₹ 50L – 1.5Cr PA',
                        'companies' => [
                            'Tata',
                            'Godrej',
                            'Nasscom',
                        ],
                    ],
                    [
                        'role' => 'Venture Partner / Investor',
                        'salary' => '₹ 40L – 2Cr PA',
                        'companies' => [
                            'Sequoia India',
                            'Accel',
                            'Blume Ventures',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Dr. Mihir Desai',
                        'title' => 'Programme Director',
                        'credentials' => 'DBA Stanford GSB · Serial Entrepreneur · Forbes 30 Under 30 Mentor',
                        'tags' => [
                            'Startup Ecosystems',
                            'Venture Finance',
                            'Disruptive Innovation',
                        ],
                    ],
                    [
                        'name' => 'Prof. Karen O\'Sullivan',
                        'title' => 'Innovation Research Lead',
                        'credentials' => 'PhD Trinity College Dublin · Ex-Google X Innovation Lead',
                        'tags' => [
                            'Corporate Entrepreneurship',
                            'Design Thinking Research',
                            'IP Commercialisation',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need to have founded a company to apply?',
                        'a' => 'No. The programme welcomes founders, intrapreneurs, innovation managers, and investors. What matters is a clear research interest in entrepreneurship or innovation — not a current startup.',
                    ],
                    [
                        'q' => 'Why is this DBA shorter than others (2 years)?',
                        'a' => 'The dissertation is embedded within a live startup or innovation project, accelerating the research cycle. Candidates who have an existing venture or innovation initiative progress faster.',
                    ],
                    [
                        'q' => 'Can my startup be the research site for my dissertation?',
                        'a' => 'Yes — this is actively encouraged. Your own venture provides a real-world laboratory for doctoral research, making the dissertation immediately actionable.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, or equivalent from a recognised institution',
                    '10+ years professional experience',
                    '5+ years in entrepreneurship, innovation, or venture roles',
                    'Research interest statement on an entrepreneurship topic',
                    'Pitch or innovation brief (instead of traditional statement)',
                ],
                'nextIntake' => 'November 2026',
                'cohortSize' => 18,
            ],
            'dba-healthcare' => [
                'slug' => 'dba-healthcare',
                'title' => 'DBA in Healthcare & Hospital Management',
                'university' => 'Rushford Business School (Switzerland)',
                'duration' => '3 Years',
                'mode' => 'Online + Residency',
                'rating' => 4.7,
                'reviewCount' => 372,
                'enrolled' => 740,
                'badge' => 'High Demand',
                'badgeColor' => 'bg-purple-500',
                'tag' => 'Healthcare',
                'tagline' => 'Drive evidence-based transformation in healthcare systems and hospital networks',
                'description' => [
                    'The DBA in Healthcare & Hospital Management is designed for medical directors, hospital CEOs, health ministry officials, and health-tech founders who need the academic authority to reform healthcare delivery. You will produce doctoral research on clinical operations, health economics, and policy — research that can be directly implemented.',
                    'The programme combines health management theory, clinical operations research, and health-tech strategy. Residencies are held at leading hospital networks in India and the UK, providing direct access to clinical leadership and healthcare policy environments.',
                ],
                'outcomes' => [
                    'Design and evaluate healthcare delivery models using doctoral research',
                    'Apply health economics and financing analysis to hospital strategy',
                    'Lead clinical operations research and quality improvement programmes',
                    'Develop health technology assessment frameworks for digital health tools',
                    'Influence national and regional health policy through evidence',
                    'Manage hospital networks and integrated care systems',
                    'Publish in leading health management and health policy journals',
                    'Govern health organisations through a research-literate board lens',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Health Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods in Health Management',
                            'Health Economics & Financing',
                            'Clinical Operations & Quality Improvement',
                            'Health Systems & Policy Analysis',
                            'Academic Writing for Health Leaders',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Health Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Digital Health & Telemedicine Strategy',
                            'Hospital Management & Governance',
                            'Epidemiology for Healthcare Executives',
                            'Health Technology Assessment',
                            'Patient Experience & Service Design',
                            'Health Leadership Residency (UK / India)',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–36',
                        'topics' => [
                            'Research Proposal on a Live Health Challenge',
                            'Clinical Data Collection & Ethics Approval',
                            'Quantitative and Qualitative Analysis',
                            'Dissertation Drafting & Clinical Supervisor Review',
                            'Viva Voce Defence',
                            'Health Journal Publication Support',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Hospital CEO / Medical Director',
                        'salary' => '₹ 50L – 1.5Cr PA',
                        'companies' => [
                            'Apollo',
                            'Fortis',
                            'Max Healthcare',
                        ],
                    ],
                    [
                        'role' => 'Health Ministry / Policy Advisor',
                        'salary' => '₹ 30L – 80L PA',
                        'companies' => [
                            'AIIMS',
                            'WHO',
                            'Ministry of Health',
                        ],
                    ],
                    [
                        'role' => 'Health-Tech Founder / Executive',
                        'salary' => '₹ 40L – 1Cr+',
                        'companies' => [
                            'Practo',
                            'PharmEasy',
                            '1mg',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Dr. Priya Krishnamurthy',
                        'title' => 'Programme Director',
                        'credentials' => 'MD + PhD Johns Hopkins · Ex-Apollo Hospitals COO',
                        'tags' => [
                            'Clinical Operations',
                            'Health Economics',
                            'Patient Safety Research',
                        ],
                    ],
                    [
                        'name' => 'Prof. James Okonkwo',
                        'title' => 'Health Policy Lead',
                        'credentials' => 'DBA LSE · Ex-WHO Geneva Policy Director',
                        'tags' => [
                            'Health Policy Research',
                            'Global Health Systems',
                            'Digital Health',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need a medical degree (MBBS/MD) to apply?',
                        'a' => 'No. The programme welcomes healthcare administrators, hospital managers, health-tech entrepreneurs, and public health officials regardless of whether they hold a medical degree.',
                    ],
                    [
                        'q' => 'Will my research require access to patient data?',
                        'a' => 'Some dissertations use anonymised clinical datasets. We guide you through ICMR ethics approval, data anonymisation protocols, and research governance frameworks.',
                    ],
                    [
                        'q' => 'Are residencies at actual hospitals?',
                        'a' => 'Yes — residencies include embedded visits at Apollo Hospitals (India) and an NHS Trust (UK), giving you access to clinical operations, quality improvement programmes, and executive leadership panels.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, MPH, or equivalent',
                    '10+ years in healthcare, hospital management, or health policy',
                    '5+ years in a senior clinical or health management role',
                    'Research interest statement on a healthcare topic',
                    'Interview with admissions panel',
                ],
                'nextIntake' => 'September 2026',
                'cohortSize' => 20,
            ],
            'dba-marketing' => [
                'slug' => 'dba-marketing',
                'title' => 'DBA in Marketing & Brand Strategy',
                'university' => 'ESGCI, Paris (France)',
                'duration' => '2.5 Years',
                'mode' => 'Online',
                'rating' => 4.6,
                'reviewCount' => 334,
                'enrolled' => 690,
                'badge' => null,
                'badgeColor' => '',
                'tag' => 'Marketing',
                'tagline' => 'Research-backed brand leadership for the attention economy',
                'description' => [
                    'The DBA in Marketing & Brand Strategy transforms CMOs, brand directors, and marketing strategists into doctoral-level researchers who produce original insights on consumer behaviour, brand equity, and digital marketing effectiveness. The programme combines neuroscience-informed consumer research with global brand management theory.',
                    'Your dissertation will investigate a real marketing challenge — from luxury brand positioning in emerging markets to AI-driven personalisation at scale — producing evidence that advances both your organisation\'s strategy and the broader marketing science canon.',
                ],
                'outcomes' => [
                    'Design and defend original research on consumer behaviour and brand equity',
                    'Apply neuroscience and behavioural science to marketing strategy',
                    'Lead global brand management across multicultural markets',
                    'Evaluate digital marketing effectiveness using rigorous research methods',
                    'Build evidence-based content, SEO, and performance marketing frameworks',
                    'Advise boards on brand valuation and reputation management',
                    'Publish in top-ranked marketing journals',
                    'Lead marketing transformation using AI and data-driven personalisation',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Marketing Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Consumer Behaviour Research Methods',
                            'Brand Equity & Valuation Theory',
                            'Quantitative & Qualitative Marketing Research',
                            'Neuromarketing & Behavioural Economics',
                            'Academic Writing for Marketing Practitioners',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Marketing Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Global Brand Management & Architecture',
                            'Digital Marketing Analytics & Attribution',
                            'Luxury & Premium Brand Strategy',
                            'AI-Driven Personalisation Research',
                            'Content Strategy & Media Effectiveness',
                            'Marketing Leadership & Agency Management',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–30',
                        'topics' => [
                            'Research Proposal on a Live Marketing Challenge',
                            'Consumer Survey Design & Sampling',
                            'Statistical Analysis with SPSS / R',
                            'Dissertation Drafting & Supervision',
                            'Viva Voce Defence',
                            'Marketing Journal Submission',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Marketing Officer',
                        'salary' => '₹ 50L – 1.5Cr PA',
                        'companies' => [
                            'HUL',
                            'P&G',
                            'Nestlé India',
                        ],
                    ],
                    [
                        'role' => 'VP / Director – Brand Strategy',
                        'salary' => '₹ 35L – 80L PA',
                        'companies' => [
                            'L\'Oréal',
                            'Tanishq',
                            'Myntra',
                        ],
                    ],
                    [
                        'role' => 'Marketing Researcher / Consultant',
                        'salary' => '₹ 25L – 60L PA',
                        'companies' => [
                            'Kantar',
                            'Nielsen',
                            'Bain & Company',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Prof. Kavitha Reddy',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD Yale · Ex-Unilever Global CMO · Author of \'Brand Mind\'',
                        'tags' => [
                            'Brand Equity Research',
                            'Consumer Neuroscience',
                            'Global Marketing',
                        ],
                    ],
                    [
                        'name' => 'Dr. Marcus Chen',
                        'title' => 'Digital Marketing Lead',
                        'credentials' => 'DBA Wharton · Ex-Google APAC Marketing Director',
                        'tags' => [
                            'Digital Attribution Research',
                            'AI Marketing',
                            'Performance Measurement',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Is prior marketing experience required?',
                        'a' => 'Yes — applicants should have significant experience in brand management, marketing strategy, or a related commercial role, typically at a senior manager level or above.',
                    ],
                    [
                        'q' => 'Will I need to run consumer research studies?',
                        'a' => 'Yes. Most dissertations involve primary consumer research — surveys, ethnographies, or experiments. We provide full training in ethical research design and consumer panel access.',
                    ],
                    [
                        'q' => 'Can I focus on digital marketing rather than traditional brand management?',
                        'a' => 'Absolutely. Dissertation topics can focus on digital marketing effectiveness, social media research, influencer marketing, or AI-driven personalisation.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, or equivalent from a recognised institution',
                    '10+ years professional experience',
                    '5+ years in marketing, brand management, or commercial strategy',
                    'Research interest statement on a marketing topic',
                    'Portfolio of brand work (optional but valued)',
                ],
                'nextIntake' => 'October 2026',
                'cohortSize' => 20,
            ],
            'dba-sustainability' => [
                'slug' => 'dba-sustainability',
                'title' => 'DBA in Sustainability & ESG Leadership',
                'university' => 'Liverpool Business School – LJMU (UK)',
                'duration' => '3 Years',
                'mode' => 'Blended',
                'rating' => 4.8,
                'reviewCount' => 287,
                'enrolled' => 560,
                'badge' => 'Trending',
                'badgeColor' => 'bg-green-600',
                'tag' => 'Sustainability',
                'tagline' => 'Lead the net-zero transition with doctoral rigour and board-level authority',
                'description' => [
                    'The DBA in Sustainability & ESG Leadership is built for sustainability directors, impact investors, and corporate responsibility leaders who need doctoral-level research capability to influence the net-zero agenda. The programme covers ESG reporting, climate risk governance, circular economy research, and green finance.',
                    'Your dissertation will produce original research on a live sustainability challenge — from Scope 3 emissions measurement to nature-based capital accounting — publishable in sustainability and management journals and actionable inside your organisation.',
                ],
                'outcomes' => [
                    'Design doctoral research on corporate sustainability and ESG strategy',
                    'Apply climate risk frameworks to board-level governance decisions',
                    'Develop ESG reporting systems aligned with GRI, TCFD, and IFRS S1/S2',
                    'Lead net-zero transformation programmes across complex value chains',
                    'Evaluate green finance instruments and sustainable investment strategies',
                    'Influence sustainability regulation through evidence-based advocacy',
                    'Publish in top sustainability management and environmental economics journals',
                    'Build circular economy models that create value and reduce waste',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Sustainability Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods for Sustainability Scientists',
                            'ESG Frameworks & Standards (GRI, TCFD, IFRS)',
                            'Climate Risk & Carbon Accounting',
                            'Circular Economy & Industrial Ecology',
                            'Academic Writing for Sustainability Leaders',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist ESG Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Green Finance & Sustainable Investment',
                            'Supply Chain Sustainability & Scope 3',
                            'Biodiversity & Nature-Based Capital',
                            'Social Impact Measurement & Reporting',
                            'Net-Zero Strategy & Science-Based Targets',
                            'ESG Residency (Geneva / London)',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–36',
                        'topics' => [
                            'Research Proposal on a Live ESG Problem',
                            'Corporate Data Collection & Stakeholder Research',
                            'Environmental Economics Analysis',
                            'Dissertation Drafting & Supervision',
                            'Viva Voce Defence',
                            'Sustainability Journal Submission',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Sustainability Officer',
                        'salary' => '₹ 50L – 1.5Cr PA',
                        'companies' => [
                            'Tata Steel',
                            'Infosys',
                            'ITC',
                        ],
                    ],
                    [
                        'role' => 'ESG Director / Head of Impact',
                        'salary' => '₹ 35L – 80L PA',
                        'companies' => [
                            'BlackRock India',
                            'HSBC ESG',
                            'CLP India',
                        ],
                    ],
                    [
                        'role' => 'Sustainability Researcher / Consultant',
                        'salary' => '₹ 25L – 60L PA',
                        'companies' => [
                            'EY Sustainability',
                            'KPMG ESG',
                            'WRI India',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Dr. Sophie Laurent',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD Cambridge · Ex-UNEP Senior Advisor · TCFD Task Force Member',
                        'tags' => [
                            'Climate Risk Research',
                            'ESG Governance',
                            'Green Finance',
                        ],
                    ],
                    [
                        'name' => 'Prof. Anand Krishnan',
                        'title' => 'Circular Economy Lead',
                        'credentials' => 'DBA IESE · Ex-Unilever Sustainability VP Asia',
                        'tags' => [
                            'Circular Economy',
                            'Scope 3 Research',
                            'Net-Zero Strategy',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need a science or engineering background?',
                        'a' => 'No. The programme is designed for business leaders. Scientific concepts are introduced in context, and the research focus is on management and strategy rather than physical science.',
                    ],
                    [
                        'q' => 'Is the programme aligned with TCFD, GRI, and IFRS S1/S2?',
                        'a' => 'Yes. The ESG reporting module fully covers these frameworks, and candidates can write dissertations specifically on implementation challenges within these standards.',
                    ],
                    [
                        'q' => 'Are there corporate partnerships for research fieldwork?',
                        'a' => 'We have partnerships with leading sustainability-reporting companies across manufacturing, financial services, and FMCG for candidates who need organisational access.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, or equivalent from a recognised institution',
                    '10+ years professional experience',
                    '5+ years in sustainability, ESG, environment, or impact roles',
                    'Research interest statement on a sustainability topic',
                    'Interview with programme director',
                ],
                'nextIntake' => 'September 2026',
                'cohortSize' => 20,
            ],
            'dba-international-business' => [
                'slug' => 'dba-international-business',
                'title' => 'DBA in International Business & Trade',
                'university' => 'ESGCI, Paris (France)',
                'duration' => '3 Years',
                'mode' => 'Online + Residency',
                'rating' => 4.5,
                'reviewCount' => 256,
                'enrolled' => 510,
                'badge' => null,
                'badgeColor' => '',
                'tag' => 'International Business',
                'tagline' => 'Master the research skills to lead cross-border business at the highest level',
                'description' => [
                    'The DBA in International Business & Trade is designed for senior executives who operate across borders — trade directors, M&A leaders, regional presidents, and global business development heads. You will produce doctoral research on topics including cross-border M&A integration, emerging market entry strategy, trade law, and global value chains.',
                    'Residencies in Singapore, Dubai, and London place you inside the world\'s key trading corridors, with access to trade ministers, multinational CEOs, and investment authority executives.',
                ],
                'outcomes' => [
                    'Design doctoral research on international business and global trade',
                    'Lead cross-border M&A strategy, due diligence, and post-merger integration',
                    'Analyse trade policy, tariffs, and WTO regulations through a research lens',
                    'Develop emerging market entry strategies backed by evidence',
                    'Build and govern global value chains using operations research',
                    'Negotiate cross-cultural business partnerships and joint ventures',
                    'Publish in leading international business and trade journals',
                    'Advise boards on geopolitical risk and global market positioning',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'International Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods in International Business',
                            'Global Trade Theory & WTO Frameworks',
                            'Cross-Cultural Management Research',
                            'Foreign Direct Investment & Market Entry',
                            'Academic Writing for Global Leaders',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Trade Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Cross-Border M&A Strategy & Integration',
                            'Emerging Market Dynamics (India, SEA, Africa)',
                            'Trade Finance & FX Risk Management',
                            'Global Value Chains & Supply Networks',
                            'International Law & Trade Compliance',
                            'Global Residency Intensives (Singapore / Dubai / London)',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–36',
                        'topics' => [
                            'Research Proposal on an International Business Challenge',
                            'Multi-Country Data Collection',
                            'Comparative Case Study Analysis',
                            'Dissertation Drafting & Supervision',
                            'Viva Voce Defence',
                            'International Business Journal Submission',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Regional President / MD',
                        'salary' => '₹ 80L – 2.5Cr PA',
                        'companies' => [
                            'Unilever APAC',
                            'HSBC India',
                            'Siemens India',
                        ],
                    ],
                    [
                        'role' => 'Head of M&A / Business Development',
                        'salary' => '₹ 50L – 1.5Cr PA',
                        'companies' => [
                            'Tata',
                            'Mahindra Global',
                            'Adani International',
                        ],
                    ],
                    [
                        'role' => 'International Trade Advisor',
                        'salary' => '₹ 30L – 80L PA',
                        'companies' => [
                            'WTO',
                            'EXIM Bank',
                            'CII',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Prof. Sanjay Malhotra',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD Columbia · Ex-McKinsey Global Emerging Markets Lead',
                        'tags' => [
                            'Emerging Market Entry',
                            'Cross-border M&A',
                            'Trade Policy',
                        ],
                    ],
                    [
                        'name' => 'Dr. Elena Petrov',
                        'title' => 'Global Trade Research Lead',
                        'credentials' => 'DBA HEC Paris · Ex-WTO Policy Analyst · INSEAD Visiting Faculty',
                        'tags' => [
                            'Trade Law',
                            'International Business Research',
                            'EU-Asia Trade',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need experience working outside India?',
                        'a' => 'It is strongly preferred, but not mandatory. Candidates with significant exposure to international business — even from a domestic role at a multinational — are competitive.',
                    ],
                    [
                        'q' => 'Are residencies in different countries?',
                        'a' => 'Yes — residencies rotate across Singapore, Dubai, and London, providing direct access to three of the world\'s key trade corridors and investment communities.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, or equivalent from a recognised institution',
                    '10+ years professional experience',
                    '5+ years in international business, trade, or cross-border roles',
                    'Research interest statement on international business',
                    'Language proficiency in English (IELTS 7+ if non-native)',
                ],
                'nextIntake' => 'September 2026',
                'cohortSize' => 18,
            ],
            'dba-data-science' => [
                'slug' => 'dba-data-science',
                'title' => 'DBA in Data Science & Business Analytics',
                'university' => 'Golden Gate University, San Francisco (USA)',
                'duration' => '2.5 Years',
                'mode' => 'Online',
                'rating' => 4.9,
                'reviewCount' => 512,
                'enrolled' => 1050,
                'badge' => 'New Batch',
                'badgeColor' => 'bg-blue-600',
                'tag' => 'Data & Analytics',
                'tagline' => 'Lead the data revolution with doctoral-level research authority',
                'description' => [
                    'The DBA in Data Science & Business Analytics is designed for Chief Data Officers, analytics directors, and data product leaders who want doctoral credentials to match their technical depth. The programme combines advanced ML research, causal inference, and executive data storytelling — producing leaders who can both build and govern data-driven organisations.',
                    'Your dissertation will investigate a live analytics challenge using primary data from your organisation — from algorithmic bias in credit scoring to predictive modelling in supply chain disruption. The outcome is publishable research with immediate commercial value.',
                ],
                'outcomes' => [
                    'Design and defend doctoral research using advanced statistical and ML methods',
                    'Apply causal inference and experimental design to business decisions',
                    'Lead AI and data governance programmes at board and regulatory level',
                    'Build predictive and prescriptive analytics architectures for large organisations',
                    'Communicate complex data insights to C-suite and board audiences',
                    'Evaluate algorithmic fairness, bias, and ethics in ML systems',
                    'Publish in leading data science, management, and IS journals',
                    'Govern data strategy, data products, and data platforms at scale',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Data Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods for Data Scientists',
                            'Advanced Statistics & Causal Inference',
                            'Machine Learning Theory & Evaluation',
                            'Data Governance & Ethics',
                            'Academic Writing for Technical Leaders',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Analytics Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Deep Learning & NLP Research Applications',
                            'Predictive Modelling Lab (Python / R)',
                            'Executive Data Storytelling & Visualisation',
                            'AI Strategy & Data Product Management',
                            'Algorithmic Fairness & Responsible AI',
                            'Data Platform Architecture (Cloud/Lakehouse)',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–30',
                        'topics' => [
                            'Research Proposal on a Live Analytics Problem',
                            'Data Collection, Cleaning & Feature Engineering',
                            'Model Development & Validation',
                            'Dissertation Drafting & Supervision',
                            'Viva Voce Defence',
                            'IS / Data Science Journal Submission',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Data / Analytics Officer',
                        'salary' => '₹ 60L – 2Cr PA',
                        'companies' => [
                            'Google India',
                            'PhonePe',
                            'HDFC Bank',
                        ],
                    ],
                    [
                        'role' => 'Director – AI / ML',
                        'salary' => '₹ 40L – 1.2Cr PA',
                        'companies' => [
                            'Microsoft India',
                            'Flipkart',
                            'Razorpay',
                        ],
                    ],
                    [
                        'role' => 'Data Science Researcher / Professor',
                        'salary' => '₹ 30L – 80L PA',
                        'companies' => [
                            'IITs',
                            'IIMs',
                            'IISc',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Dr. Sunita Patel',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD MIT CSAIL · Ex-Google Brain Research Scientist · IIT-B Adjunct',
                        'tags' => [
                            'ML Research',
                            'Causal Inference',
                            'AI Governance',
                        ],
                    ],
                    [
                        'name' => 'Prof. Laurent Dupont',
                        'title' => 'Analytics Research Lead',
                        'credentials' => 'DBA Insead · Ex-McKinsey Analytics Practice Lead',
                        'tags' => [
                            'Predictive Modelling',
                            'Data Strategy',
                            'Executive Analytics',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need a computer science or mathematics degree?',
                        'a' => 'Not necessarily. The programme is designed for experienced data practitioners. Strong Python/R skills and working knowledge of ML are required, but a formal CS degree is not.',
                    ],
                    [
                        'q' => 'What level of Python/R proficiency is expected?',
                        'a' => 'Intermediate proficiency — you should be comfortable with pandas, scikit-learn, and ggplot2. A refresher bootcamp is offered before programme start for candidates who need it.',
                    ],
                    [
                        'q' => 'Can my dissertation use proprietary company data?',
                        'a' => 'Yes — and this is encouraged. All data governance and confidentiality protocols are agreed in advance. Many candidates produce commercially sensitive research that is embargoed for 2 years.',
                    ],
                ],
                'eligibility' => [
                    'Masters in Data Science, Statistics, CS, or MBA with analytics focus',
                    '10+ years professional experience',
                    '5+ years in data science, analytics, or AI leadership',
                    'Python/R proficiency assessment',
                    'Research interest statement on a data/analytics problem',
                ],
                'nextIntake' => 'October 2026',
                'cohortSize' => 20,
            ],
            'dba-risk-management' => [
                'slug' => 'dba-risk-management',
                'title' => 'DBA in Risk Management & Compliance',
                'university' => 'Edgewood University (USA)',
                'duration' => '2.5 Years',
                'mode' => 'Online',
                'rating' => 4.5,
                'reviewCount' => 243,
                'enrolled' => 480,
                'badge' => null,
                'badgeColor' => '',
                'tag' => 'Risk & Compliance',
                'tagline' => 'Build the evidence base for enterprise risk, governance, and regulatory excellence',
                'description' => [
                    'The DBA in Risk Management & Compliance is designed for CROs, compliance directors, internal audit heads, and governance professionals who want doctoral credentials to elevate their advisory impact at board level. You will produce original research on enterprise risk frameworks, regulatory compliance, and corporate governance.',
                    'The programme integrates forensic accounting, regulatory strategy, and risk modelling — culminating in a dissertation that advances the risk management canon and provides actionable governance insights for your organisation.',
                ],
                'outcomes' => [
                    'Design and defend doctoral research on enterprise risk and governance',
                    'Build enterprise risk frameworks using quantitative and qualitative methods',
                    'Advise boards on regulatory risk, compliance strategy, and audit oversight',
                    'Apply forensic accounting and financial investigation techniques',
                    'Evaluate regulatory frameworks across banking, insurance, and capital markets',
                    'Lead GRC (Governance, Risk & Compliance) programme design and implementation',
                    'Publish in leading governance, risk, and accounting journals',
                    'Influence regulatory policy through evidence-based research submissions',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Risk Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods in Risk Management',
                            'Enterprise Risk Frameworks (ISO 31000, COSO)',
                            'Regulatory Environment & Compliance Architecture',
                            'Quantitative Risk Modelling (VaR, Monte Carlo)',
                            'Academic Writing for Governance Practitioners',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Risk Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Banking & Financial Services Regulation (Basel IV, RBI)',
                            'Forensic Accounting & Fraud Investigation',
                            'Operational Risk & Business Continuity',
                            'Regulatory Strategy & Government Relations',
                            'Board Governance & Audit Committee Effectiveness',
                            'GRC Technology & Compliance Automation',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–30',
                        'topics' => [
                            'Research Proposal on a Governance or Risk Challenge',
                            'Regulatory Document & Case Study Analysis',
                            'Risk Data Modelling & Scenario Analysis',
                            'Dissertation Writing & Supervision',
                            'Viva Voce Defence',
                            'Governance Journal Submission',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Risk Officer',
                        'salary' => '₹ 50L – 1.5Cr PA',
                        'companies' => [
                            'ICICI Bank',
                            'HDFC',
                            'Bajaj Allianz',
                        ],
                    ],
                    [
                        'role' => 'Head of Compliance',
                        'salary' => '₹ 30L – 80L PA',
                        'companies' => [
                            'Deloitte',
                            'PwC',
                            'KPMG Risk',
                        ],
                    ],
                    [
                        'role' => 'Regulatory Affairs Director',
                        'salary' => '₹ 25L – 60L PA',
                        'companies' => [
                            'RBI',
                            'SEBI',
                            'IRDAI',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Dr. Ravi Kulkarni',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD NYU Stern · Ex-RBI Executive Director · FRM Certified',
                        'tags' => [
                            'Regulatory Research',
                            'Banking Risk',
                            'Enterprise Risk Frameworks',
                        ],
                    ],
                    [
                        'name' => 'Prof. Monica Bauer',
                        'title' => 'Governance Research Lead',
                        'credentials' => 'DBA Cranfield · Ex-PwC Risk Assurance Partner · IIA Board Member',
                        'tags' => [
                            'Board Governance',
                            'Internal Audit Research',
                            'Forensic Accounting',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need professional certifications (FRM, ACCA, CIA) to apply?',
                        'a' => 'Not mandatory. Professional certifications are valued in applications but not required. The programme provides significant value for certified professionals seeking to add doctoral credentials.',
                    ],
                    [
                        'q' => 'Can I research a regulatory challenge in my own industry?',
                        'a' => 'Yes — this is strongly encouraged. Regulatory research is most valuable when grounded in sector-specific context, whether banking, insurance, capital markets, or corporate governance.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, CA, CPA, or equivalent professional qualification',
                    '10+ years professional experience',
                    '5+ years in risk, compliance, audit, or governance leadership',
                    'Research interest statement on a risk/governance topic',
                    'Professional reference from current board or senior leadership',
                ],
                'nextIntake' => 'November 2026',
                'cohortSize' => 18,
            ],
            'dba-project-management' => [
                'slug' => 'dba-project-management',
                'title' => 'DBA in Project Management & Infrastructure',
                'university' => 'Rushford Business School (Switzerland)',
                'duration' => '2 Years',
                'mode' => 'Blended',
                'rating' => 4.6,
                'reviewCount' => 278,
                'enrolled' => 560,
                'badge' => null,
                'badgeColor' => '',
                'tag' => 'Project Management',
                'tagline' => 'Deliver mega-projects and infrastructure programmes with doctoral-level leadership',
                'description' => [
                    'The DBA in Project Management & Infrastructure is designed for programme directors, infrastructure CEOs, government project heads, and senior project managers who wish to elevate their discipline through doctoral research. The programme integrates PMP/PRINCE2 frameworks with doctoral-level research methods — producing leaders who govern large infrastructure portfolios with evidence-based authority.',
                ],
                'outcomes' => [
                    'Design doctoral research on project complexity, governance, and performance',
                    'Lead mega-project delivery across engineering, infrastructure, and technology sectors',
                    'Integrate PMP and PRINCE2 governance with advanced research methods',
                    'Evaluate project risk, stakeholder management, and benefit realisation',
                    'Build evidence-based project portfolio management frameworks',
                    'Publish in leading project management and infrastructure journals',
                    'Advise government and multilateral bodies on infrastructure policy',
                    'Lead cultural and organisational change in project-driven organisations',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Project Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods for Project Managers',
                            'Project Complexity & Systems Thinking',
                            'Advanced Risk Management in Projects',
                            'PMP / PRINCE2 Research Integration',
                            'Academic Writing for Infrastructure Leaders',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist PM Electives',
                        'duration' => 'Months 7–14',
                        'topics' => [
                            'Mega-Project Governance & Portfolio Management',
                            'Infrastructure Finance & PPP Models',
                            'Stakeholder Management Research',
                            'Digital Project Management & BIM',
                            'Agile at Scale (SAFe) Research Applications',
                            'PM Leadership Residency (London / Singapore)',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 15–24',
                        'topics' => [
                            'Research Proposal on a Live Project Challenge',
                            'Primary Research: Stakeholder Interviews & Document Analysis',
                            'Project Data Analysis & Benchmarking',
                            'Dissertation Writing & Supervision',
                            'Viva Voce Defence',
                            'PM Journal Submission',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Programme Director / SVP – Projects',
                        'salary' => '₹ 40L – 1.2Cr PA',
                        'companies' => [
                            'L&T',
                            'NHAI',
                            'Adani Infra',
                        ],
                    ],
                    [
                        'role' => 'Infrastructure CEO / Commissioner',
                        'salary' => '₹ 50L – 1.5Cr PA',
                        'companies' => [
                            'RITES',
                            'PWD',
                            'CPWD',
                        ],
                    ],
                    [
                        'role' => 'PM Researcher / Consultant',
                        'salary' => '₹ 25L – 60L PA',
                        'companies' => [
                            'PwC Capital Projects',
                            'KPMG Infra',
                            'World Bank',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Prof. Suresh Menon',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD UCL · PMP + PRINCE2 Master · Ex-L&T Infrastructure Director',
                        'tags' => [
                            'Mega-Project Research',
                            'Infrastructure Governance',
                            'PPP Models',
                        ],
                    ],
                    [
                        'name' => 'Dr. Helen Carter',
                        'title' => 'Dissertation Supervisor',
                        'credentials' => 'DBA University of Bath · Ex-Crossrail Programme Director',
                        'tags' => [
                            'Complex Project Delivery',
                            'Stakeholder Research',
                            'Benefit Realisation',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Will I earn PMP or PRINCE2 credentials within this programme?',
                        'a' => 'The programme integrates PMP and PRINCE2 frameworks deeply into the curriculum. Candidates can sit the PMP exam as part of their studies; exam fees are not included but preparation is provided.',
                    ],
                    [
                        'q' => 'Is this suitable for public sector project leaders?',
                        'a' => 'Yes — the programme is specifically designed to serve both private sector programme directors and public sector infrastructure commissioners and government project heads.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, or equivalent (Engineering degrees valued)',
                    '10+ years professional experience',
                    '5+ years in project management, infrastructure, or programme leadership',
                    'PMP, PRINCE2, or equivalent certification preferred',
                    'Research interest statement on a project management topic',
                ],
                'nextIntake' => 'October 2026',
                'cohortSize' => 18,
            ],
            'dba-public-policy' => [
                'slug' => 'dba-public-policy',
                'title' => 'DBA in Public Policy & Governance',
                'university' => 'Liverpool Business School – LJMU (UK)',
                'duration' => '3 Years',
                'mode' => 'Online + Residency',
                'rating' => 4.4,
                'reviewCount' => 218,
                'enrolled' => 430,
                'badge' => null,
                'badgeColor' => '',
                'tag' => 'Public Policy',
                'tagline' => 'Design evidence-based policy that shapes economies and transforms institutions',
                'description' => [
                    'The DBA in Public Policy & Governance is built for senior civil servants, policy advisors, multilateral organisation executives, and business leaders who operate at the intersection of government and industry. You will produce doctoral research on policy design, regulatory reform, and institutional governance — research that can directly influence national and international policy.',
                    'Residencies in New Delhi, Geneva, and Brussels place you inside the world\'s most influential policy environments, with access to ministry officials, WHO and WTO advisors, and European Commission policy teams.',
                ],
                'outcomes' => [
                    'Design doctoral research on public policy design and implementation',
                    'Evaluate regulatory reform using rigorous policy analysis methods',
                    'Lead government-industry partnerships and public-private dialogue',
                    'Apply programme evaluation frameworks to assess policy effectiveness',
                    'Influence national and international policy through evidence submissions',
                    'Build public sector leadership capability at ministerial level',
                    'Publish in leading public policy and public administration journals',
                    'Govern public institutions through research-informed board leadership',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Policy Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods in Public Policy',
                            'Policy Design & Analysis Frameworks',
                            'Regulatory Economics & Institutional Theory',
                            'Political Economy & Governance Systems',
                            'Academic Writing for Policy Practitioners',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Policy Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Programme Evaluation & Impact Assessment',
                            'Government-Industry Relations & Lobbying',
                            'Fiscal Policy & Public Finance Management',
                            'Digital Government & GovTech Strategy',
                            'International Law & Multilateral Governance',
                            'Policy Residency (New Delhi / Geneva / Brussels)',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–36',
                        'topics' => [
                            'Research Proposal on a Live Policy Challenge',
                            'Policy Document Analysis & Stakeholder Research',
                            'Quantitative Policy Impact Modelling',
                            'Dissertation Drafting & Supervision',
                            'Viva Voce Defence',
                            'Public Policy Journal Submission',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Secretary / Additional Secretary (IAS)',
                        'salary' => 'Government Pay + Benefits',
                        'companies' => [
                            'Government of India',
                            'State Governments',
                            'PSUs',
                        ],
                    ],
                    [
                        'role' => 'Policy Director – Multilateral',
                        'salary' => '₹ 40L – 1Cr PA + Perks',
                        'companies' => [
                            'World Bank',
                            'ADB',
                            'UN Agencies',
                        ],
                    ],
                    [
                        'role' => 'Government Affairs Director',
                        'salary' => '₹ 30L – 80L PA',
                        'companies' => [
                            'Reliance',
                            'Tata Government Affairs',
                            'FICCI',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Prof. Meera Krishnan',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD Princeton · Ex-Planning Commission Advisor · UNDP Consultant',
                        'tags' => [
                            'Public Policy Research',
                            'Regulatory Reform',
                            'Fiscal Policy',
                        ],
                    ],
                    [
                        'name' => 'Dr. Thomas Eriksson',
                        'title' => 'Governance Research Lead',
                        'credentials' => 'DBA LSE · Ex-European Commission Policy Director · WEF Fellow',
                        'tags' => [
                            'EU Policy Research',
                            'Institutional Governance',
                            'International Law',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Is this programme only for civil servants?',
                        'a' => 'No. The programme is designed for anyone who operates at the government-business interface: senior civil servants, NGO directors, multilateral executives, and business leaders in government affairs.',
                    ],
                    [
                        'q' => 'Are the residencies at actual government institutions?',
                        'a' => 'Yes — residencies include embedded sessions at NITI Aayog (New Delhi), WHO headquarters (Geneva), and the European Commission (Brussels), with access to serving policymakers.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, MPA, or LLB from a recognised institution',
                    '10+ years professional experience',
                    '5+ years in government, policy, regulatory, or public affairs roles',
                    'Research interest statement on a policy topic',
                    'Two professional references from public sector or academic figures',
                ],
                'nextIntake' => 'September 2026',
                'cohortSize' => 15,
            ],
            'dba-hospitality' => [
                'slug' => 'dba-hospitality',
                'title' => 'DBA in Hospitality & Tourism Management',
                'university' => 'Rushford Business School (Switzerland)',
                'duration' => '2.5 Years',
                'mode' => 'Online',
                'rating' => 4.5,
                'reviewCount' => 198,
                'enrolled' => 390,
                'badge' => null,
                'badgeColor' => '',
                'tag' => 'Hospitality',
                'tagline' => 'Lead the hospitality and tourism industry with doctoral-level research and global vision',
                'description' => [
                    'The DBA in Hospitality & Tourism Management is designed for hotel group CEOs, tourism board directors, luxury brand leaders, and hospitality entrepreneurs who want doctoral credentials to drive evidence-based transformation in their industry. The programme combines revenue management science, sustainable tourism research, and luxury brand leadership.',
                ],
                'outcomes' => [
                    'Produce doctoral research on hospitality operations and tourism economics',
                    'Lead revenue management and yield optimisation at group or national level',
                    'Design and evaluate sustainable tourism strategies using research evidence',
                    'Build luxury hospitality brand equity through consumer-led research',
                    'Govern hotel groups and tourism boards through data-informed decision-making',
                    'Publish in leading hospitality and tourism management journals',
                    'Advise governments on destination management and tourism policy',
                    'Lead digital transformation in hospitality: AI concierge, dynamic pricing, CRM',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Hospitality Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods in Hospitality & Tourism',
                            'Revenue Management Science',
                            'Luxury Brand Management Theory',
                            'Sustainable Tourism & Destination Research',
                            'Academic Writing for Hospitality Leaders',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Hospitality Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Hotel Group Strategy & Asset Management',
                            'Tourist Behaviour & Experience Design Research',
                            'Digital Hospitality & AI-Driven Guest Experience',
                            'F&B Management & Culinary Tourism Research',
                            'Crisis Management in Tourism (Post-pandemic Lessons)',
                            'Luxury Leadership Immersion (Dubai / Paris)',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–30',
                        'topics' => [
                            'Research Proposal on a Live Hospitality Challenge',
                            'Guest Survey Design & Satisfaction Measurement',
                            'Operational Data & Revenue Analysis',
                            'Dissertation Drafting & Supervision',
                            'Viva Voce Defence',
                            'Hospitality Journal Submission',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'CEO / MD – Hotel Group',
                        'salary' => '₹ 40L – 1.5Cr PA',
                        'companies' => [
                            'Taj Hotels',
                            'ITC Hotels',
                            'Marriott India',
                        ],
                    ],
                    [
                        'role' => 'Director General – Tourism Board',
                        'salary' => '₹ 30L – 80L PA',
                        'companies' => [
                            'Ministry of Tourism',
                            'State Tourism Corporations',
                            'UNWTO',
                        ],
                    ],
                    [
                        'role' => 'Hospitality Researcher / Consultant',
                        'salary' => '₹ 20L – 50L PA',
                        'companies' => [
                            'Deloitte Hospitality',
                            'JLL Hotels',
                            'HVS India',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Prof. Natalia Ivanova',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD Ecole hôtelière de Lausanne (EHL) · Ex-Accor Global VP Revenue',
                        'tags' => [
                            'Revenue Management',
                            'Luxury Brand Research',
                            'Sustainable Tourism',
                        ],
                    ],
                    [
                        'name' => 'Dr. Rahul Menon',
                        'title' => 'Tourism Research Lead',
                        'credentials' => 'DBA Oxford Brookes · Ex-Kerala Tourism Director · UNWTO Advisor',
                        'tags' => [
                            'Destination Management',
                            'Tourism Policy',
                            'Guest Experience Research',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need hotel management experience?',
                        'a' => 'Yes — applicants should have significant senior experience in hospitality, hotels, tourism, travel, or F&B industries. Allied sectors (events, aviation, cruise) are also welcomed.',
                    ],
                    [
                        'q' => 'Can I research my own hotel group or tourism destination?',
                        'a' => 'Yes, and most candidates do. Using your own organisation as the research site produces the most commercially relevant dissertations.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, or Hospitality Management degree from a recognised institution',
                    '10+ years professional experience',
                    '5+ years in senior hospitality, tourism, or luxury brand leadership',
                    'Research interest statement on a hospitality topic',
                    'Interview with programme director',
                ],
                'nextIntake' => 'October 2026',
                'cohortSize' => 15,
            ],
            'dba-cybersecurity' => [
                'slug' => 'dba-cybersecurity',
                'title' => 'DBA in Cybersecurity & Digital Governance',
                'university' => 'Golden Gate University, San Francisco (USA)',
                'duration' => '2.5 Years',
                'mode' => 'Online',
                'rating' => 4.7,
                'reviewCount' => 356,
                'enrolled' => 720,
                'badge' => 'New Batch',
                'badgeColor' => 'bg-red-600',
                'tag' => 'Technology',
                'tagline' => 'Command the boardroom on cyber risk with doctoral-level research authority',
                'description' => [
                    'The DBA in Cybersecurity & Digital Governance is built for CISOs, cyber risk directors, and technology governance leaders who want doctoral-level research credentials to elevate their board-level influence. You will produce original research on AI-driven threat modelling, cyber risk quantification, and digital governance frameworks.',
                    'The programme combines technical cyber risk science with executive governance and research methods — producing leaders who can advise boards, regulators, and government agencies using evidence, not instinct.',
                ],
                'outcomes' => [
                    'Design doctoral research on cyber risk, threat intelligence, and digital governance',
                    'Apply AI and ML to threat detection and cyber risk quantification',
                    'Advise boards on cybersecurity governance, CISO strategy, and regulation',
                    'Develop cyber incident response and business continuity research frameworks',
                    'Evaluate national cybersecurity policy and critical infrastructure protection',
                    'Lead security culture transformation across large, complex organisations',
                    'Publish in leading cybersecurity, information systems, and governance journals',
                    'Govern third-party and supply chain cyber risk at enterprise level',
                ],
                'curriculum' => [
                    [
                        'phase' => 'Phase 1',
                        'title' => 'Cyber Research Foundations',
                        'duration' => 'Months 1–6',
                        'topics' => [
                            'Research Methods in Cybersecurity',
                            'Cyber Risk Frameworks (NIST, ISO 27001, DORA)',
                            'AI-Driven Threat Intelligence Research',
                            'Digital Governance & Board Cyber Strategy',
                            'Academic Writing for Cyber Leaders',
                        ],
                    ],
                    [
                        'phase' => 'Phase 2',
                        'title' => 'Specialist Cyber Electives',
                        'duration' => 'Months 7–18',
                        'topics' => [
                            'Cyber Risk Quantification (FAIR Model)',
                            'Zero Trust Architecture Research',
                            'Regulatory Compliance (GDPR, CERT-In, NIS2)',
                            'Cyber Incident Response & Crisis Research',
                            'Supply Chain Cyber Risk Management',
                            'Cyber Governance Boardroom Simulation',
                        ],
                    ],
                    [
                        'phase' => 'Phase 3',
                        'title' => 'Doctoral Dissertation',
                        'duration' => 'Months 19–30',
                        'topics' => [
                            'Research Proposal on a Live Cyber Governance Challenge',
                            'Threat Data Collection & Analysis',
                            'Quantitative Risk Modelling',
                            'Dissertation Drafting & Supervision',
                            'Viva Voce Defence',
                            'IS / Cybersecurity Journal Submission',
                        ],
                    ],
                ],
                'careerRoles' => [
                    [
                        'role' => 'Chief Information Security Officer',
                        'salary' => '₹ 60L – 2Cr PA',
                        'companies' => [
                            'HDFC Bank',
                            'TCS Cyber',
                            'Infosys Security',
                        ],
                    ],
                    [
                        'role' => 'Cyber Risk Director',
                        'salary' => '₹ 40L – 1Cr PA',
                        'companies' => [
                            'Deloitte Cyber',
                            'PwC Risk',
                            'KPMG Cyber',
                        ],
                    ],
                    [
                        'role' => 'Cybersecurity Policy Researcher',
                        'salary' => '₹ 30L – 70L PA',
                        'companies' => [
                            'CERT-In',
                            'DSCI',
                            'IITs/IISc',
                        ],
                    ],
                ],
                'faculty' => [
                    [
                        'name' => 'Dr. Aditya Kumar',
                        'title' => 'Programme Director',
                        'credentials' => 'PhD MIT CSAIL · Ex-ISRO Cyber Security Head · CERT-In Advisor',
                        'tags' => [
                            'AI Threat Modelling',
                            'Cyber Risk Quantification',
                            'Board Cyber Governance',
                        ],
                    ],
                    [
                        'name' => 'Prof. Sarah Mitchell',
                        'title' => 'Digital Governance Lead',
                        'credentials' => 'DBA Warwick · Ex-GCHQ Cyber Strategy · NIS2 Implementation Advisor',
                        'tags' => [
                            'Digital Governance',
                            'Regulatory Research',
                            'Incident Response',
                        ],
                    ],
                ],
                'faq' => [
                    [
                        'q' => 'Do I need a computer science or cybersecurity background?',
                        'a' => 'Yes — applicants should have hands-on experience in cybersecurity, information security, or digital risk. A formal CS degree is not required but 5+ years of technical/leadership cyber experience is essential.',
                    ],
                    [
                        'q' => 'Will my research require access to threat data?',
                        'a' => 'Many dissertations use industry threat intelligence feeds, organisational incident data, or publicly available breach datasets. We guide you through data access agreements and anonymisation protocols.',
                    ],
                    [
                        'q' => 'Is this programme aligned with CISO career development frameworks?',
                        'a' => 'Yes — the programme maps to NCSC\'s Cyber Essentials, ISACA CISM, and NIST CSF, and is recognised by leading cybersecurity professional bodies.',
                    ],
                ],
                'eligibility' => [
                    'Masters, MBA, MSc in Cybersecurity / IS / Engineering, or equivalent',
                    '10+ years professional experience',
                    '5+ years in cybersecurity, information security, or digital risk leadership',
                    'CISSP, CISM, or CISA certification preferred',
                    'Research interest statement on a cyber governance topic',
                ],
                'nextIntake' => 'October 2026',
                'cohortSize' => 18,
            ],
        ];
      }

      /**
       * Sample alumni reviews shown on every /doctorate/{slug} page (ported
       * from DoctorateDetail.tsx). The `review` strings are translated at
       * render time via ServerTranslator, so they MUST stay in the protected
       * live-text set (scripts/generate-static-texts-snapshot.mjs extracts
       * them via laravel-backend/scripts/dump-server-translated-texts.php).
       *
       * @var list<array{name:string,rating:int,date:string,review:string}>
       */
      public const SAMPLE_REVIEWS = [
          ['name' => 'Venkat Rao', 'rating' => 5, 'date' => 'Jun 2026', 'review' => 'The DBA transformed how I engage with my board. I now bring evidence, not just intuition, to every strategic discussion. The dissertation process was challenging but incredibly rewarding.'],
          ['name' => 'Patricia Walsh', 'rating' => 5, 'date' => 'May 2026', 'review' => 'Worth every rupee. The faculty are genuinely at the top of their field. My supervisor pushed me in ways that made the research genuinely original. Got promoted to Group CEO three months after defending.'],
          ['name' => 'Anand Gupta', 'rating' => 4, 'date' => 'Apr 2026', 'review' => "Demanding programme — but that's the point. The cohort of fellow executives is itself worth the investment. The network I've built across 18 countries is invaluable."],
      ];

      /**
       * @return array<string, mixed>|null
       */
      public static function find(string $slug): ?array
      {
          return self::all()[$slug] ?? null;
      }
    }
    