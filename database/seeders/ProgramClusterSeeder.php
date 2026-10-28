<?php

namespace Database\Seeders;

use App\Models\ProgramCluster;
use Illuminate\Database\Seeder;

class ProgramClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clusters = [
            [
                'name' => 'Rumpun Keagamaan',
                'quota' => 72,
                'description' => 'Fokus pendalaman Ilmu Agama Islam, Bahasa Arab, Dirasah Islamiyah, dan persiapan studi ke Timur Tengah / PTKIN.',
                'is_active' => true,
            ],
            [
                'name' => 'MIPA / STEM',
                'quota' => 72,
                'description' => 'Fokus penguatan Sains, Teknologi, Rekayasa, dan Matematika untuk persiapan perguruan tinggi saintek dan kedokteran.',
                'is_active' => true,
            ],
            [
                'name' => 'Sosial Humaniora (Soshum)',
                'quota' => 72,
                'description' => 'Fokus pada Ilmu Sosial, Ekonomi, Hukum, Sosiologi, dan Komunikasi untuk persiapan studi sosial humaniora.',
                'is_active' => true,
            ],
            [
                'name' => 'Vokasi & Keterampilan Digital',
                'quota' => 72,
                'description' => 'Fokus pada keahlian terapan, Desain Grafis, IT, dan Kewirausahaan mandiri santri.',
                'is_active' => true,
            ],
        ];

        foreach ($clusters as $clusterData) {
            ProgramCluster::updateOrCreate(
                ['name' => $clusterData['name']],
                $clusterData
            );
        }
    }
}
