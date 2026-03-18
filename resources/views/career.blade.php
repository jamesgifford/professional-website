<x-layouts::public title="Career" metaDescription="The career history and professional experience of James Gifford, a software engineer with 20 years of experience." canonicalUrl="{{ route('career') }}">
    <article class="px-6 py-16 sm:py-24">
        <div class="mx-auto max-w-3xl">
            {{-- Header --}}
            <header class="mb-12">
                <p class="font-mono text-xs text-emerald-600 dark:text-emerald-400 mb-2 tracking-wide bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">// career</p>
                <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight leading-tight bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit">Career</h1>
            </header>

            {{-- Content --}}
            <div class="space-y-6 text-zinc-600 dark:text-zinc-400 leading-relaxed">
                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">I've been building web applications professionally for over 20 years. Most of that time has been spent at startups and small companies, working remotely, shipping software that real people depend on. Here's the arc.</p>

                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit !mt-12">The Early Years</h2>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">I graduated from Western Oregon University in 2003 with a degree in Computer Science and went straight into the Portland tech scene. My first major role was at <strong><a href="https://cdbaby.com/" target="_blank" rel="noopener noreferrer" class="text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4">CD Baby</a></strong>, where I spent six years working with a website-building platform for independent musicians. CD Baby was one of the original online music distributors, a company that existed to help independent artists sell their music before that was easy to do. I built tools that let musicians manage their catalogs, track their sales and revenue, and promote their events. It was my first real experience building software that served a large, passionate user base, and it shaped how I think about product development to this day.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">After CD Baby, I went to work at <strong>Staffing Robot</strong>, a smaller company building job board software for medical staffing agencies. The work was client-facing where each agency needed their own branded job board tailored to their specific workflows and preferences. It was less glamorous than the music industry, but it taught me something valuable about building software for niche markets: the problems are real, the users are demanding, and getting the details right matters more than being flashy.</p>

                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit !mt-12">Going Deep on SaaS</h2>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">In 2017 I joined <strong>OptinMonster</strong>, a lead generation platform, as a Senior Software Engineer. This was a year-long engagement focused on a single mission: a ground-up rewrite of their core platform. I rebuilt integration layers connecting to dozens of third-party mailing list providers and marketing analytics APIs, redesigned a legacy database schema serving millions of customer records, and worked across the full stack to unify how the frontend and backend communicated. It was intense, focused work, the kind of project where you touch every part of the system and come out the other side understanding it completely.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">That experience set the stage for the next chapter.</p>

                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit !mt-12">Leading at Discogs</h2>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">By joining <strong><a href="https://discogs.com/" target="_blank" rel="noopener noreferrer" class="text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4">Discogs</a></strong> I was joining a team targeting a larger audience. Discogs is a music database and marketplace with over 8 million artists and more than 100 million users worldwide. If you've ever looked up a vinyl pressing, tracked down a rare release, or bought a used record online, there's a good chance Discogs was involved.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">I led a cross-functional engineering team that served the rest of the organization by building internal tooling, providing project support for other engineering teams, and maintaining documentation standards across the company. It was a player-coach role: I was still writing code daily, but I was also mentoring engineers, establishing team processes for code review and collaboration, and making technical decisions that affected the broader organization.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">The biggest technical effort during my time at Discogs was a major platform modernization. The codebase was over a decade old, monolithic, and showing its age. I guided the technical strategy and execution of that effort, coordinating schema changes and performance tuning across a 500-million-record MySQL dataset while keeping the site running for millions of users. I also modernized the e-commerce integrations and inventory management systems that powered the marketplace side of the business.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">Four years at Discogs gave me confidence that I could lead a team, drive technical strategy, and operate at the intersection of engineering and product.</p>

                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit !mt-12">Building at Scale with AddEvent</h2>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">In 2022 I joined <strong><a href="https://www.addevent.com" target="_blank" rel="noopener noreferrer" class="text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4">AddEvent</a></strong>, an established startup with a major customer base. AddEvent is the most widely used add-to-calendar service on the internet. If you've ever clicked an "Add to Calendar" button on a website or in an email, there's a good chance it was powered by AddEvent. The platform is trusted by over 300,000 companies and handles calendar operations across Google Calendar, Apple Calendar, Outlook, Office 365, and Yahoo.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">I spent nearly four years there, working across almost every part of the platform. I served as a key architect in a platform-wide v2.0 rebuild, driving decisions around system composition, data modeling, and API structure. I stabilized the recurring events and event series features which are a deceptively complex problem involving recurrence rules that need to behave consistently across every major calendar provider, each of which interprets the spec slightly differently. I integrated Stripe's billing portal into a multi-tier subscription system. And I maintained and optimized a production database approaching one billion records.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">AddEvent reinforced my belief that the most valuable engineering work is often invisible. When the platform works, when an event lands on the right calendar in the right timezone on the right day, nobody notices. When it doesn't, thousands of companies notice immediately. That kind of pressure shapes how you think about reliability, testing, and defensive engineering.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">I wrote more about my time at AddEvent in my <a href="{{ route('projects.show', 'addevent') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4">project writeup</a>.</p>

                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit !mt-12">Going Independent</h2>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">In late 2025 I founded <strong><a href="https://progravity.com" target="_blank" rel="noopener noreferrer" class="text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4">Progravity</a></strong>, a software company where I'm building and operating my own SaaS products. After 20 years of building software for other companies, I wanted to apply everything I've learned to something that's mine.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">The first product is <strong><a href="https://mentioned.app" target="_blank" rel="noopener noreferrer" class="text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4">Mentioned</a></strong>, a brand monitoring tool that tracks where businesses appear online via web mentions, search engine rankings, backlinks, and increasingly, appearances in AI-generated search results. It's built with Laravel, integrates with multiple data APIs, and runs on a background job pipeline I designed to handle tiered usage across multiple subscription plans.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">I've been leaning into AI-assisted development throughout this process with tools like Claude for architecture planning, schema design, and test scaffolding. I don't believe AI works as a replacement for engineering judgment, but as a way to move faster on the mechanical parts and spend more time on the decisions that matter. I wrote about the distinction between AI-as-driver and AI-as-copilot in my project posts about <a href="{{ route('projects.show', 'tank-tracts') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4">Tank Tracts</a> and <a href="{{ route('projects.show', 'mentioned') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4">Mentioned</a>.</p>

                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5 w-fit !mt-12">What I'm Looking For</h2>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">I'm currently open to remote senior engineering and technical leadership roles, particularly at early-stage startups where I can contribute broadly. I'm at my best when I'm close to the product, working on systems that matter, with a team small enough that everyone's work is visible.</p>

                <p class="bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-md rounded-lg px-3 py-1.5">If that sounds like your team, I'd love to <a href="#contact" class="text-emerald-600 dark:text-emerald-400 hover:underline underline-offset-4">hear from you</a>.</p>
            </div>
        </div>
    </article>

    @include('partials.contact')
</x-layouts::public>
