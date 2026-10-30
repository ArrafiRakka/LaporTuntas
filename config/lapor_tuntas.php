<?php

return [
    'categories' => [
        'jalan-rusak' => ['label' => 'Jalan rusak', 'icon' => 'construction', 'agency' => 'Dinas Pekerjaan Umum'],
        'lampu-jalan' => ['label' => 'Lampu jalan', 'icon' => 'lightbulb', 'agency' => 'Dinas Perhubungan'],
        'sampah' => ['label' => 'Sampah menumpuk', 'icon' => 'delete_outline', 'agency' => 'Dinas Lingkungan Hidup'],
        'drainase' => ['label' => 'Drainase / banjir', 'icon' => 'water_damage', 'agency' => 'Dinas Pekerjaan Umum'],
        'rambu' => ['label' => 'Rambu dan marka', 'icon' => 'traffic', 'agency' => 'Dinas Perhubungan'],
        'fasilitas-umum' => ['label' => 'Fasilitas umum', 'icon' => 'build', 'agency' => 'Dinas Pekerjaan Umum'],
        'lainnya' => ['label' => 'Lainnya', 'icon' => 'location_on', 'agency' => 'Pemerintah Kota Malang'],
    ],
    'reports' => [
        'LT-8F3K-92QX' => [
            'ticket_id' => 'LT-8F3K-92QX', 'title' => 'Lubang jalan aspal cukup dalam (~15cm)', 'category' => 'Jalan rusak', 'category_key' => 'jalan-rusak',
            'description' => 'Lubang jalan cukup dalam dan membahayakan pengendara motor, terutama saat hujan.', 'location' => 'Jl. Veteran (depan Gerbang FIA UB)',
            'latitude' => -7.9545, 'longitude' => 112.6145, 'status' => 'Diproses', 'reported_at' => '12 Okt 2025, 14:32 WIB', 'reported_ago' => '2 jam lalu',
            'agency' => 'Dinas Pekerjaan Umum', 'photos' => [], 'distance_km' => 0.4, 'map' => ['top' => '50%', 'left' => '34%'], 'is_demo' => true,
            'timeline' => [
                ['status' => 'Baru', 'description' => 'Laporan diterima oleh sistem.', 'time' => '12 Okt 2025, 14:32 WIB'],
                ['status' => 'Ditugaskan', 'description' => 'Diteruskan ke Dinas Pekerjaan Umum Kota Malang.', 'time' => '12 Okt 2025, 15:10 WIB'],
                ['status' => 'Diproses', 'description' => 'Petugas lapangan sedang meninjau lokasi.', 'time' => '12 Okt 2025, 16:05 WIB'],
            ],
            'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBBfALXMP2XG2NsYfeha8huOcpmFhRSW7XCp7YW4jC0bqyhvBxO-mPCAnjDjIlZ9CySb77jD4bbg82uEXgEZpWRy2KO7UZJdc4yCJe5VajbbW4st6_u0axh3hGOjkEDlaf2EFmKIvHcD1Y-aBeUJHws8R1kuZB9n9ocFE4RqXYhKx_e792awGPhQBOxzBMfrB_-VcmtBV3TV4GbHs3A5XJx6OWUYgiMh61NSGkrLbtx',
        ],
        'LT-4B1N-77XZ' => [
            'ticket_id' => 'LT-4B1N-77XZ', 'title' => 'Penerangan jalan umum padam sepanjang 200m', 'category' => 'Lampu jalan', 'category_key' => 'lampu-jalan',
            'description' => 'Beberapa lampu jalan tidak menyala sehingga ruas jalan gelap pada malam hari.', 'location' => 'Jl. Soekarno-Hatta No. 42', 'latitude' => -7.9412, 'longitude' => 112.621,
            'status' => 'Baru', 'reported_at' => '12 Okt 2025, 12:20 WIB', 'reported_ago' => '4 jam lalu', 'agency' => 'Dinas Perhubungan', 'photos' => [], 'distance_km' => 0.8, 'map' => ['top' => '16%', 'left' => '18%'], 'is_demo' => true,
            'timeline' => [['status' => 'Baru', 'description' => 'Laporan diterima dan menunggu penugasan.', 'time' => '12 Okt 2025, 12:20 WIB']],
        ],
        'LT-3M7Q-19PL' => [
            'ticket_id' => 'LT-3M7Q-19PL', 'title' => 'Tumpukan sampah ranting pohon belum diangkut', 'category' => 'Sampah menumpuk', 'category_key' => 'sampah',
            'description' => 'Tumpukan ranting dan sampah menutup sebagian bahu jalan.', 'location' => 'Jl. Besar Ijen', 'latitude' => -7.9682, 'longitude' => 112.6171,
            'status' => 'Ditugaskan', 'reported_at' => '11 Okt 2025, 09:15 WIB', 'reported_ago' => 'Kemarin', 'agency' => 'Dinas Lingkungan Hidup', 'photos' => [], 'distance_km' => 1.4, 'map' => ['top' => '70%', 'left' => '48%'], 'is_demo' => true,
            'timeline' => [['status' => 'Baru', 'description' => 'Laporan diterima.', 'time' => '11 Okt 2025, 09:15 WIB'], ['status' => 'Ditugaskan', 'description' => 'Petugas kebersihan wilayah telah ditugaskan.', 'time' => '11 Okt 2025, 10:00 WIB']],
        ],
        'LT-9Y4W-88VK' => [
            'ticket_id' => 'LT-9Y4W-88VK', 'title' => 'Saluran drainase tersumbat lumpur padat', 'category' => 'Drainase / banjir', 'category_key' => 'drainase',
            'description' => 'Saluran drainase tersumbat dan air meluap saat hujan deras.', 'location' => 'Jl. MT Haryono Gg. 9', 'latitude' => -7.949, 'longitude' => 112.626,
            'status' => 'Selesai', 'reported_at' => '10 Okt 2025, 08:12 WIB', 'reported_ago' => '2 hari lalu', 'agency' => 'Dinas Pekerjaan Umum', 'photos' => [], 'distance_km' => 0.9, 'map' => ['top' => '32%', 'left' => '52%'], 'is_demo' => true,
            'timeline' => [['status' => 'Baru', 'description' => 'Laporan diterima.', 'time' => '10 Okt 2025, 08:12 WIB'], ['status' => 'Diproses', 'description' => 'Pembersihan saluran dimulai.', 'time' => '10 Okt 2025, 12:30 WIB'], ['status' => 'Selesai', 'description' => 'Saluran dibersihkan oleh petugas.', 'time' => '11 Okt 2025, 13:45 WIB']],
        ],
        'LT-5K1R-33TQ' => [
            'ticket_id' => 'LT-5K1R-33TQ', 'title' => 'Paving trotoar amblas membahayakan pejalan', 'category' => 'Fasilitas umum', 'category_key' => 'fasilitas-umum',
            'description' => 'Paving trotoar amblas dan perlu diperiksa agar aman dilalui.', 'location' => 'Jl. Bandung', 'latitude' => -7.9621, 'longitude' => 112.609,
            'status' => 'Ditolak', 'reported_at' => '9 Okt 2025, 16:05 WIB', 'reported_ago' => '3 hari lalu', 'agency' => 'Dinas Pekerjaan Umum', 'photos' => [], 'distance_km' => 2.2, 'map' => ['top' => '22%', 'left' => '72%'], 'is_demo' => true,
            'rejection_reason' => 'Laporan duplikat dari tiket LT-7J2P-64MZ.', 'timeline' => [['status' => 'Baru', 'description' => 'Laporan diterima.', 'time' => '9 Okt 2025, 16:05 WIB'], ['status' => 'Ditolak', 'description' => 'Laporan duplikat dari tiket LT-7J2P-64MZ.', 'time' => '9 Okt 2025, 17:20 WIB']],
        ],
        'LT-7J2P-64MZ' => [
            'ticket_id' => 'LT-7J2P-64MZ', 'title' => 'Tutup gorong-gorong hilang terbuka', 'category' => 'Fasilitas umum', 'category_key' => 'fasilitas-umum',
            'description' => 'Tutup gorong-gorong hilang dan membahayakan pengguna jalan.', 'location' => 'Jl. Semeru', 'latitude' => -7.971, 'longitude' => 112.612,
            'status' => 'Selesai', 'reported_at' => '8 Okt 2025, 10:25 WIB', 'reported_ago' => '4 hari lalu', 'agency' => 'Dinas Pekerjaan Umum', 'photos' => [], 'distance_km' => 0.7, 'map' => ['top' => '82%', 'left' => '32%'], 'is_demo' => true,
            'timeline' => [['status' => 'Baru', 'description' => 'Laporan diterima.', 'time' => '8 Okt 2025, 10:25 WIB'], ['status' => 'Selesai', 'description' => 'Tutup gorong-gorong telah diganti.', 'time' => '10 Okt 2025, 09:00 WIB']],
        ],
        'LT-6A2D-51HX' => [
            'ticket_id' => 'LT-6A2D-51HX', 'title' => 'Lampu jalan padam di dekat halte', 'category' => 'Lampu jalan', 'category_key' => 'lampu-jalan',
            'description' => 'Lampu jalan padam di dekat halte dan area penyeberangan.', 'location' => 'Jl. Semeru, dekat halte', 'latitude' => -7.974, 'longitude' => 112.616,
            'status' => 'Diproses', 'reported_at' => '12 Okt 2025, 11:40 WIB', 'reported_ago' => '5 jam lalu', 'agency' => 'Dinas Perhubungan', 'photos' => [], 'distance_km' => 0.6, 'map' => ['top' => '64%', 'left' => '22%'], 'is_demo' => true,
            'timeline' => [['status' => 'Baru', 'description' => 'Laporan diterima.', 'time' => '12 Okt 2025, 11:40 WIB'], ['status' => 'Diproses', 'description' => 'Pemeriksaan jaringan listrik dijadwalkan.', 'time' => '12 Okt 2025, 13:00 WIB']],
        ],
        'LT-2Q8N-40DC' => [
            'ticket_id' => 'LT-2Q8N-40DC', 'title' => 'Rambu penyeberangan rusak', 'category' => 'Rambu dan marka', 'category_key' => 'rambu',
            'description' => 'Rambu penyeberangan miring dan sulit terlihat pengendara.', 'location' => 'Jl. Ijen', 'latitude' => -7.963, 'longitude' => 112.621,
            'status' => 'Ditugaskan', 'reported_at' => '12 Okt 2025, 10:50 WIB', 'reported_ago' => '6 jam lalu', 'agency' => 'Dinas Perhubungan', 'photos' => [], 'distance_km' => 1.8, 'map' => ['top' => '76%', 'left' => '64%'], 'is_demo' => true,
            'timeline' => [['status' => 'Baru', 'description' => 'Laporan diterima.', 'time' => '12 Okt 2025, 10:50 WIB'], ['status' => 'Ditugaskan', 'description' => 'Petugas sarana jalan ditugaskan.', 'time' => '12 Okt 2025, 11:30 WIB']],
        ],
    ],
];
