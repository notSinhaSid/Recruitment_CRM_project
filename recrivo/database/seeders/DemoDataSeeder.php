<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Realistic recruiting agencies (tenants) — each is an independent
     * agency using Recrivo to manage its own clients and pipelines.
     */
    private array $agencies = [
        'Northbridge Talent Partners',
        'Solstice Recruiting Group',
        'Vantage Point Staffing',
        'Harborline Executive Search',
        'Meridian Workforce Solutions',
        'Crestwell Talent Advisors',
        'Ashgrove Recruitment Co.',
        'Beacon & Birch Staffing',
        'Ironwood Career Partners',
        'Fieldstone HR Consulting',
        'Silverline Talent Group',
        'Oakmere Recruiting Studio',
    ];

    /** Client companies each agency recruits for. */
    private array $companyPool = [
        ['name' => 'Ferrowave Manufacturing', 'industry' => 'Manufacturing'],
        ['name' => 'Brightlane Logistics', 'industry' => 'Logistics'],
        ['name' => 'Cobalt Ridge Analytics', 'industry' => 'Technology'],
        ['name' => 'Hearthstone Retail Group', 'industry' => 'Retail'],
        ['name' => 'Windermere Financial Services', 'industry' => 'Finance'],
        ['name' => 'Pinehaven Healthcare Systems', 'industry' => 'Healthcare'],
        ['name' => 'Latticework Software', 'industry' => 'Technology'],
        ['name' => 'Coastal Grove Hospitality', 'industry' => 'Hospitality'],
        ['name' => 'Redstone Construction Co.', 'industry' => 'Construction'],
        ['name' => 'Amberfield Media Group', 'industry' => 'Media'],
        ['name' => 'Thornfield Insurance Group', 'industry' => 'Insurance'],
        ['name' => 'Glasswater Energy Partners', 'industry' => 'Energy'],
        ['name' => 'Millbrook Consumer Goods', 'industry' => 'Retail'],
        ['name' => 'Stonebridge Legal Services', 'industry' => 'Legal'],
        ['name' => 'Palisade Biotech', 'industry' => 'Healthcare'],
        ['name' => 'Oakridge Property Group', 'industry' => 'Real Estate'],
        ['name' => 'Emberline Telecom', 'industry' => 'Telecommunications'],
        ['name' => 'Northgate Automotive', 'industry' => 'Automotive'],
        ['name' => 'Wrenfield Publishing House', 'industry' => 'Media'],
        ['name' => 'Cedarpoint Agricultural Co.', 'industry' => 'Agriculture'],
        ['name' => 'Marrow Creative Agency', 'industry' => 'Marketing'],
        ['name' => 'Blackfield Mining Corp', 'industry' => 'Mining'],
        ['name' => 'Tidewell Pharmaceuticals', 'industry' => 'Healthcare'],
        ['name' => 'Granville Freight Systems', 'industry' => 'Logistics'],
        ['name' => 'Ashcombe Data Solutions', 'industry' => 'Technology'],
        ['name' => 'Fairmount Textiles', 'industry' => 'Manufacturing'],
        ['name' => 'Hollowbrook Capital', 'industry' => 'Finance'],
        ['name' => 'Silverpeak Aerospace', 'industry' => 'Aerospace'],
        ['name' => 'Copperfield Utilities', 'industry' => 'Utilities'],
        ['name' => 'Brookline Educational Services', 'industry' => 'Education'],
        ['name' => 'Ridgeway Security Solutions', 'industry' => 'Security'],
        ['name' => 'Elmsworth Food & Beverage', 'industry' => 'Food & Beverage'],
        ['name' => 'Kestrel Aviation Group', 'industry' => 'Aviation'],
        ['name' => 'Duskwood Environmental Services', 'industry' => 'Environmental'],
        ['name' => 'Pemberton Wealth Advisors', 'industry' => 'Finance'],
        ['name' => 'Ironvale Steel Works', 'industry' => 'Manufacturing'],
        ['name' => 'Willowmere Wellness Group', 'industry' => 'Healthcare'],
        ['name' => 'Quarrystone Architecture', 'industry' => 'Architecture'],
        ['name' => 'Larkspur Digital Media', 'industry' => 'Media'],
        ['name' => 'Underhill Import Export', 'industry' => 'Trade'],
    ];

    /** Tracks which companies from the pool have already been used, since companies.name is globally unique. */
    private array $usedCompanyNames = [];

    private array $jobTitles = [
        'Senior Backend Engineer', 'Product Marketing Manager', 'Financial Analyst',
        'Warehouse Operations Lead', 'Customer Success Manager', 'UX Designer',
        'Sales Development Representative', 'Registered Nurse', 'Site Supervisor',
        'Data Analyst', 'HR Business Partner', 'Account Executive',
        'DevOps Engineer', 'Executive Assistant', 'Content Strategist',
    ];

    private array $firstNames = [
        'Olivia', 'Liam', 'Emma', 'Noah', 'Ava', 'Ethan', 'Sophia', 'Mason',
        'Isabella', 'Lucas', 'Mia', 'James', 'Amelia', 'Benjamin', 'Harper',
        'Elijah', 'Evelyn', 'Alexander', 'Abigail', 'Henry', 'Grace', 'Sebastian',
        'Chloe', 'Jack', 'Zoey', 'Owen', 'Layla', 'Daniel', 'Riley', 'Matthew',
    ];

    private array $lastNames = [
        'Bennett', 'Carter', 'Reyes', 'Mitchell', 'Foster', 'Hayes', 'Coleman',
        'Barnes', 'Griffin', 'Reid', 'Sanders', 'Wallace', 'Fleming', 'Pierce',
        'Whitfield', 'Sullivan', 'Bradley', 'Nash', 'Doyle', 'Marsh',
    ];

    public function run(): void
    {
        $this->command->warn('Wiping existing tenant-scoped data...');

        Application::query()->delete();
        JobPosting::query()->delete();
        Candidate::query()->delete();
        Company::query()->delete();
        User::whereHas('role', fn ($q) => $q->where('name', '!=', 'Super Admin'))->delete();
        // Exclude the Recrivo Platform tenant (holds the Super Admin account) —
        // deleting it would cascade-delete the Super Admin user via the
        // users.tenant_id cascadeOnDelete constraint, regardless of role.
        Tenant::where('slug', '!=', 'recrivo-platform')->delete();

        $roles = Role::pluck('id', 'name');

        foreach ($this->agencies as $index => $agencyName) {
            // Spread tenant creation across the last 8 weeks so the
            // dashboard growth chart has real movement to show.
            $weeksAgo = intdiv($index, 2); // ~2 tenants land in each week bucket
            $createdAt = Carbon::now()->subWeeks($weeksAgo)->subDays(rand(0, 6));

            $tenant = Tenant::create([
                'name' => $agencyName,
                'is_active' => $index !== 3, // one suspended tenant for demo purposes
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $this->seedUsersFor($tenant, $roles, $createdAt);
            $companies = $this->seedCompaniesFor($tenant, $createdAt);
            $candidates = $this->seedCandidatesFor($tenant, $createdAt);
            $this->seedJobPostingsAndApplications($tenant, $companies, $candidates, $createdAt);
        }

        $this->command->info('Demo data seeded: '.count($this->agencies).' tenants with users, companies, candidates, job postings, and applications.');
    }

    private function seedUsersFor(Tenant $tenant, $roles, Carbon $createdAt): void
    {
        $admin = $this->randomName();
        $adminUser = User::create([
            'tenant_id' => $tenant->id,
            'role_id' => $roles['Admin'] ?? $roles->first(),
            'first_name' => $admin[0],
            'last_name' => $admin[1],
            'email' => strtolower($admin[0].'.'.$admin[1]).'@'.$this->slugDomain($tenant->name),
            'password' => bcrypt('password'),
        ]);
        // email_verified_at is intentionally excluded from #[Fillable] on User,
        // so it must be set via forceFill (bypasses mass-assignment protection —
        // safe here since this is trusted seeder code, not user input).
        $adminUser->forceFill([
            'email_verified_at' => $createdAt,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ])->save();

        foreach (range(1, rand(2, 4)) as $i) {
            $name = $this->randomName();
            $roleName = $roles->has('Recruiter') && $i % 2 === 0 ? 'Hiring Manager' : 'Recruiter';
            $userCreatedAt = $createdAt->copy()->addDays(rand(0, 5));

            $user = User::create([
                'tenant_id' => $tenant->id,
                'role_id' => $roles[$roleName] ?? $roles->first(),
                'first_name' => $name[0],
                'last_name' => $name[1],
                'email' => strtolower($name[0].'.'.$name[1]).$i.'@'.$this->slugDomain($tenant->name),
                'password' => bcrypt('password'),
            ]);
            $user->forceFill([
                'email_verified_at' => $userCreatedAt,
                'created_at' => $userCreatedAt,
                'updated_at' => $userCreatedAt,
            ])->save();
        }
    }

    private function seedCompaniesFor(Tenant $tenant, Carbon $createdAt): \Illuminate\Support\Collection
    {
        $available = collect($this->companyPool)
            ->reject(fn ($company) => in_array($company['name'], $this->usedCompanyNames))
            ->shuffle();

        $picks = $available->take(rand(2, 4));

        // Mark these as used so no other tenant gets the same company name.
        foreach ($picks as $pick) {
            $this->usedCompanyNames[] = $pick['name'];
        }

        return $picks->map(function ($company) use ($tenant, $createdAt) {
            return Company::create([
                'tenant_id' => $tenant->id,
                'name' => $company['name'],
                'industry' => $company['industry'],
                'website' => 'https://www.'.$this->slugDomain($company['name']),
                'contact_number' => $this->randomPhone(),
                'location' => $this->randomCity(),
                'notes' => null,
                'created_at' => $createdAt->copy()->addDays(rand(0, 3)),
                'updated_at' => $createdAt,
            ]);
        });
    }

    private function seedCandidatesFor(Tenant $tenant, Carbon $createdAt): \Illuminate\Support\Collection
    {
        return collect(range(1, rand(8, 15)))->map(function ($i) use ($tenant, $createdAt) {
            $name = $this->randomName();
            $candidateCreatedAt = $createdAt->copy()->addDays(rand(0, 20));

            return Candidate::create([
                'tenant_id' => $tenant->id,
                'first_name' => $name[0],
                'last_name' => $name[1],
                'email' => strtolower($name[0].'.'.$name[1].$i).'@gmail.com',
                'phone' => $this->randomPhone(),
                'resume_path' => null,
                'linkedin_url' => 'https://linkedin.com/in/'.strtolower($name[0].'-'.$name[1]),
                'years_of_experience' => rand(0, 15),
                'source' => collect(['LinkedIn', 'Referral', 'Job Board', 'Agency Website', 'Career Fair'])->random(),
                'notes' => null,
                'created_at' => $candidateCreatedAt,
                'updated_at' => $candidateCreatedAt,
            ]);
        });
    }

    private function seedJobPostingsAndApplications(
        Tenant $tenant,
        \Illuminate\Support\Collection $companies,
        \Illuminate\Support\Collection $candidates,
        Carbon $createdAt
    ): void {
        $stages = ['applied', 'screening', 'interview', 'offer', 'hired', 'rejected', 'on hold'];

        foreach ($companies as $company) {
            foreach (range(1, rand(1, 3)) as $j) {
                $postingCreatedAt = $createdAt->copy()->addDays(rand(1, 25));

                $posting = JobPosting::create([
                    'tenant_id' => $tenant->id,
                    'company_id' => $company->id,
                    'title' => collect($this->jobTitles)->random(),
                    'description' => 'We are looking for a qualified professional to join our team and contribute to ongoing projects.',
                    'status' => rand(1, 10) > 2 ? 'open' : 'closed',
                    'location' => $this->randomCity(),
                    'employment_type' => collect(['full_time', 'part_time', 'contract'])->random(),
                    'open_spots' => rand(1, 3),
                    'created_at' => $postingCreatedAt,
                    'updated_at' => $postingCreatedAt,
                ]);

                // Attach a handful of candidates from this tenant to this posting
                $applicants = $candidates->random(min(rand(2, 6), $candidates->count()));

                foreach ($applicants as $candidate) {
                    $appliedAt = $postingCreatedAt->copy()->addDays(rand(1, 10));
                    $stage = collect($stages)->random();

                    try {
                        Application::create([
                            'tenant_id' => $tenant->id,
                            'candidate_id' => $candidate->id,
                            'job_posting_id' => $posting->id,
                            'stage' => $stage,
                            'previous_stage' => $stage === 'applied' ? null : 'applied',
                            'applied_at' => $appliedAt,
                            'created_at' => $appliedAt,
                            'updated_at' => $appliedAt,
                        ]);
                    } catch (\Illuminate\Database\QueryException $e) {
                        // Skip if this candidate/job_posting pair already exists
                        // (unique constraint) — expected occasionally given random sampling.
                        continue;
                    }
                }
            }
        }
    }

    private function randomName(): array
    {
        return [
            collect($this->firstNames)->random(),
            collect($this->lastNames)->random(),
        ];
    }

    private function randomPhone(): string
    {
        return '+1 '.rand(200, 999).'-'.rand(200, 999).'-'.rand(1000, 9999);
    }

    private function randomCity(): string
    {
        return collect([
            'Austin, TX', 'Denver, CO', 'Raleigh, NC', 'Columbus, OH',
            'Portland, OR', 'Nashville, TN', 'Minneapolis, MN', 'Salt Lake City, UT',
            'Charlotte, NC', 'Boise, ID',
        ])->random();
    }

    private function slugDomain(string $name): string
    {
        return \Illuminate\Support\Str::slug($name).'.com';
    }
}
