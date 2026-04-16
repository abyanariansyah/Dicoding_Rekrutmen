<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create job categories
        $categories = [
            ['name' => 'IT & Software', 'slug' => 'it-software'],
            ['name' => 'Marketing & Brand', 'slug' => 'marketing-brand'],
            ['name' => 'Sales', 'slug' => 'sales'],
            ['name' => 'Design', 'slug' => 'design'],
            ['name' => 'Customer Service', 'slug' => 'customer-service'],
            ['name' => 'Human Resources', 'slug' => 'hr'],
        ];

        foreach ($categories as $cat) {
            JobCategory::create($cat);
        }

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin Rekrutmen',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'phone' => '+62812345678',
            'location' => 'Jakarta, Indonesia',
        ]);

        // Create companies
        $company1 = Company::create([
            'user_id' => $admin->id,
            'name' => 'PT Teknologi Indonesia',
            'logo_url' => 'https://via.placeholder.com/150',
            'description' => 'Perusahaan teknologi terkemuka yang fokus pada solusi digital untuk bisnis.',
            'website' => 'https://teknoindo.com',
            'location' => 'Jakarta, Indonesia',
            'industry' => 'Technology',
            'company_size' => '100-500',
        ]);

        $company2 = Company::create([
            'user_id' => $admin->id,
            'name' => 'PT Kreatif Solusi',
            'logo_url' => 'https://via.placeholder.com/150',
            'description' => 'Agensi kreatif yang menyediakan layanan digital marketing dan branding.',
            'website' => 'https://kreatifsolusi.com',
            'location' => 'Bandung, Indonesia',
            'industry' => 'Marketing',
            'company_size' => '50-100',
        ]);

        // Create job postings
        $jobs = [
            [
                'company_id' => $company1->id,
                'category_id' => 1,
                'title' => 'Senior Backend Developer',
                'description' => 'Kami mencari backend developer berpengalaman untuk bergabung dengan tim kami. Anda akan bekerja dengan teknologi terbaru seperti Laravel, Node.js, dan Go.',
                'requirements' => '- Minimal 5 tahun pengalaman\n- Mahir PHP/Laravel atau Node.js\n- Pemahaman mendalam tentang REST API\n- Git & Docker',
                'location' => 'Jakarta, Indonesia',
                'job_type' => 'Full-time',
                'experience_level' => 'Senior',
                'salary_min' => 15000000,
                'salary_max' => 25000000,
                'deadline' => now()->addDays(30),
            ],
            [
                'company_id' => $company1->id,
                'category_id' => 1,
                'title' => 'Frontend Developer React',
                'description' => 'Butuh frontend developer yang handal dalam React dan modern web development untuk project-project menarik.',
                'requirements' => '- 3+ tahun pengalaman React\n- HTML, CSS, JavaScript expert\n- Responsive design\n- Git version control',
                'location' => 'Jakarta, Indonesia',
                'job_type' => 'Full-time',
                'experience_level' => 'Mid Level',
                'salary_min' => 12000000,
                'salary_max' => 18000000,
                'deadline' => now()->addDays(25),
            ],
            [
                'company_id' => $company2->id,
                'category_id' => 2,
                'title' => 'Digital Marketing Specialist',
                'description' => 'Bergabunglah dengan tim marketing kami untuk mengelola kampanye digital yang impactful dan data-driven.',
                'requirements' => '- Pengalaman digital marketing 2-3 tahun\n- Expert di Google Ads & Facebook Ads\n- Analytics dan SEO knowledge\n- Content creation skill',
                'location' => 'Bandung, Indonesia',
                'job_type' => 'Full-time',
                'experience_level' => 'Mid Level',
                'salary_min' => 10000000,
                'salary_max' => 15000000,
                'deadline' => now()->addDays(20),
            ],
            [
                'company_id' => $company2->id,
                'category_id' => 4,
                'title' => 'UI/UX Designer',
                'description' => 'Desainer berbakat diperlukan untuk membuat desain interface yang menarik dan user-friendly.',
                'requirements' => '- Portfolio design yang kuat\n- Figma atau Adobe XD\n- Wireframing & prototyping\n- Understanding of UX principles',
                'location' => 'Bandung, Indonesia',
                'job_type' => 'Full-time',
                'experience_level' => 'Mid Level',
                'salary_min' => 8000000,
                'salary_max' => 13000000,
                'deadline' => now()->addDays(28),
            ],
        ];

        foreach ($jobs as $jobData) {
            Job::create($jobData);
        }

        // Create sample applicant
        $applicant = User::factory()->create([
            'name' => 'Pelamar Contoh',
            'email' => 'pelamar@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'phone' => '+62812345679',
            'location' => 'Jakarta, Indonesia',
            'bio' => 'Backend developer dengan passion pada clean code dan best practices.',
        ]);

        // Create sample applications
        Application::create([
            'user_id' => $applicant->id,
            'job_id' => 1,
            'status' => 'Pending',
            'note' => 'Saya sangat tertarik dengan posisi ini dan yakin dapat berkontribusi pada tim Anda.',
        ]);

        Application::create([
            'user_id' => $applicant->id,
            'job_id' => 2,
            'status' => 'Diterima',
            'note' => 'Pengalaman saya sesuai dengan requirement yang Anda cari.',
        ]);
    }
}
