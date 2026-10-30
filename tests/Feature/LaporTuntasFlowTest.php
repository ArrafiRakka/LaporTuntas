<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class LaporTuntasFlowTest extends TestCase
{
    public function test_public_landing_and_main_pages_render(): void
    {
        $this->get('/')->assertOk()->assertSee('Aktifkan lokasi');
        $this->get('/peta')->assertOk()->assertSee('Laporan di sekitarmu')->assertSee('Data simulasi');
        $this->get('/laporan/buat')->assertOk()->assertSee('Buat laporan');
        $this->get('/lacak-tiket')->assertOk()->assertSee('Lacak tiket');
        $this->get('/petugas/login')->assertOk()->assertSee('Masuk sebagai Petugas Demo');
    }

    public function test_a_public_ticket_can_be_searched_and_opened(): void
    {
        $this->get('/lacak-tiket?ticket_id=LT-8F3K-92QX')
            ->assertOk()
            ->assertSee('Lubang jalan aspal cukup dalam');

        $this->get('/laporan/LT-8F3K-92QX')
            ->assertOk()
            ->assertSee('Linimasa laporan');

        $this->get('/lacak-tiket?ticket_id=LT-0000-0000')
            ->assertOk()
            ->assertSee('ID tiket belum ditemukan');
    }

    public function test_a_resident_can_submit_a_demo_report_and_receive_a_ticket(): void
    {
        $response = $this->post('/laporan', [
            'category' => 'jalan-rusak',
            'description' => 'Lubang jalan besar dekat halte dan berbahaya bagi pengendara.',
            'location_label' => 'Jl. Veteran dekat halte',
            'latitude' => '-7.954500',
            'longitude' => '112.614500',
            'photos' => [UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg')],
        ]);

        $response->assertRedirect();
        $demoReports = $response->getSession()->get('demo_reports', []);
        $ticketId = array_key_first($demoReports);
        $this->assertNotNull($ticketId);
        $this->assertStringStartsWith('LT-', $ticketId);

        $this->get($response->headers->get('Location'))
            ->assertOk()
            ->assertSee('Laporan berhasil dikirim');
    }

    public function test_staff_can_update_a_report_status_for_the_demo_session(): void
    {
        $response = $this->withSession(['demo_staff_role' => 'petugas'])
            ->patch('/petugas/laporan/LT-8F3K-92QX', [
                'status' => 'Selesai',
                'note' => 'Perbaikan contoh selesai.',
                'agency' => '',
            ]);

        $response->assertRedirect()->assertSessionHas('demo_statuses.LT-8F3K-92QX.status', 'Selesai');
        $this->get('/peta')->assertOk()->assertDontSee('data-ticket="LT-8F3K-92QX"');
        $this->get('/laporan/LT-8F3K-92QX')->assertOk()->assertSee('Selesai');
    }

    public function test_staff_demo_login_is_required_for_the_dashboard(): void
    {
        $this->get('/petugas')->assertRedirect('/petugas/login');

        $this->post('/petugas/login', ['role' => 'admin'])
            ->assertRedirect('/petugas');

        $this->get('/petugas')->assertOk()->assertSee('Antrean laporan masuk');
    }
}
