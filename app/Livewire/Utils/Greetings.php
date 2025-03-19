<?php

namespace App\Livewire\Utils;

use Carbon\Carbon;
use Livewire\Component;

class Greetings extends Component
{
    public $greet;
    public $pesan;

    public function render()
    {
        $hour = Carbon::now()->hour;

        $pesan = [
            "Kamu bisa membatalkan email yang sudah terkirim di Gmail dengan mengaktifkan fitur 'Undo Send' di pengaturan.",
            "Jika ingin cepat mengakses file di Windows, tekan `Win + E` untuk membuka File Explorer secara instan.",
            "Menggunakan teknik Pomodoro (kerja 25 menit, istirahat 5 menit) bisa meningkatkan fokus dan produktivitas.",
            "Tekan `Ctrl + Shift + T` untuk membuka kembali tab yang tidak sengaja tertutup di browser.",
            "Jika ingin membaca pesan di WhatsApp tanpa ketahuan, aktifkan mode pesawat sebelum membukanya, lalu tutup aplikasinya sebelum menonaktifkan mode pesawat.",
            "Gunakan `Ctrl + D` untuk menandai halaman penting di browser agar mudah diakses nanti.",
            "Kamu bisa mencari kata di dokumen atau halaman web dengan cepat menggunakan `Ctrl + F`.",
            "Punya banyak tugas? Gunakan metode Eisenhower Matrix untuk memilah mana yang penting dan mendesak.",
            "Gunakan `Alt + Tab` untuk berpindah cepat antara jendela aplikasi tanpa harus mengklik satu per satu.",
            "Jika ingin mengetik lebih cepat, gunakan fitur 'Text Expansion' di keyboard untuk mengganti singkatan dengan teks yang lebih panjang.",
            "Gunakan aplikasi to-do list seperti Todoist atau Notion untuk mengatur pekerjaan agar lebih terstruktur.",
            "Membalas email dengan cepat? Gunakan template atau fitur 'canned responses' di Gmail.",
            "Kurangi gangguan di tempat kerja dengan mengaktifkan mode 'Do Not Disturb' di komputer dan ponsel.",
            "Jika sering lupa password, gunakan password manager seperti Bitwarden atau 1Password untuk menyimpannya dengan aman.",
            "Saat presentasi, tekan `B` di PowerPoint untuk membuat layar hitam agar audiens fokus pada ucapanmu.",
            "Gunakan dua layar monitor untuk meningkatkan efisiensi kerja, terutama saat multitasking.",
            "Jika ingin lebih produktif, matikan notifikasi media sosial saat jam kerja.",
            "Punya banyak tugas kecil? Kelompokkan dan selesaikan sekaligus dengan teknik 'batching'.",
            "Tekan `Ctrl + L` di browser untuk langsung memilih URL tanpa perlu klik manual.",
            "Ingin terlihat profesional di Zoom? Aktifkan fitur 'Touch Up My Appearance' untuk sedikit memperhalus tampilan wajahmu.",
            "Jika ingin meningkatkan skill kerja, coba gunakan platform seperti Coursera, Udemy, atau LinkedIn Learning.",
            "Gunakan shortcut `Windows + V` untuk melihat riwayat clipboard di Windows 10 ke atas.",
            "Email yang pendek, jelas, dan to the point lebih sering dibalas dibandingkan yang terlalu panjang.",
            "Saat meeting virtual, gunakan headset dengan mikrofon noise-canceling agar suaramu lebih jelas.",
            "Simpan dokumen kerja di cloud seperti Google Drive atau OneDrive agar tidak hilang jika laptop bermasalah.",
            "Gunakan fitur 'Scheduled Send' di Gmail untuk mengirim email pada waktu yang lebih tepat.",
            "Minum kopi sebelum power nap selama 20 menit bisa membuatmu lebih segar setelah bangun.",
            "Gunakan fitur 'Focus Mode' di Windows atau Mac untuk mengurangi distraksi saat bekerja.",
            "Jika ingin lebih nyaman bekerja lama di depan komputer, gunakan layar dengan mode 'Eye Comfort'.",
            "Berjalan sebentar setiap satu jam bisa meningkatkan fokus dan mengurangi stres kerja.",
            "Gunakan keyboard shortcut `Ctrl + Enter` untuk mengirim email lebih cepat di Gmail.",
            "Jika merasa stuck dengan pekerjaan, cobalah pindah tempat untuk menyegarkan pikiran.",
            "Terlalu banyak tab di browser? Gunakan ekstensi seperti OneTab untuk merapikan tab.",
            "Jangan lupa backup data kerja secara rutin, setidaknya seminggu sekali.",
            "Menulis daftar tugas sebelum tidur bisa membantumu lebih produktif keesokan harinya.",
            "Menggunakan standing desk bisa membantu mengurangi risiko nyeri punggung akibat duduk terlalu lama.",
            "Gunakan fitur 'Do Not Disturb' di Slack atau Teams jika butuh waktu kerja tanpa gangguan.",
            "Jika bekerja dengan banyak angka, coba gunakan rumus Excel seperti `VLOOKUP` atau `INDEX MATCH` untuk mempermudah.",
            "Mendengarkan musik instrumental bisa membantu meningkatkan fokus saat bekerja.",
            "Menggunakan dark mode di aplikasi kerja bisa mengurangi kelelahan mata.",
            "Jangan lupa sering membersihkan keyboard dan layar laptop agar tetap nyaman digunakan.",
            "Buat shortcut teks di ponsel untuk mengetik lebih cepat, misalnya 'ty' jadi 'Thank you'.",
            "Gunakan fitur 'Drag & Drop' untuk mengunggah file langsung ke browser tanpa perlu klik 'Upload'.",
            "Menaruh tanaman kecil di meja kerja bisa membantu mengurangi stres dan meningkatkan kreativitas.",
            "Ingin mengingat sesuatu? Coba tulis dengan tangan, karena lebih efektif dibandingkan mengetik.",
            "Jika butuh inspirasi, coba berdiskusi dengan rekan kerja atau istirahat sejenak sebelum lanjut.",
            "Buat signature email yang profesional agar lebih kredibel saat mengirim pesan ke klien.",
            "Menjadwalkan waktu khusus untuk membaca dan membalas email bisa meningkatkan efisiensi kerja.",
            "Jika sering lupa jadwal meeting, gunakan kalender digital seperti Google Calendar dengan notifikasi otomatis.",
            "Menggunakan font yang lebih besar saat membaca dokumen di layar bisa mengurangi kelelahan mata.",
            "Gunakan mode pesawat jika ingin mengisi daya ponsel lebih cepat.",
            "Pakai fitur 'Screen Snip' (`Windows + Shift + S`) untuk mengambil screenshot bagian tertentu di Windows.",
            "Gunakan ekstensi Grammarly atau Hemingway untuk memastikan email dan dokumenmu bebas typo dan lebih profesional.",
            "Gunakan timer atau alarm sebagai pengingat agar tidak duduk terlalu lama di depan komputer.",
            "Jangan lupa logout dari akun kerja saat menggunakan komputer bersama untuk menghindari kebocoran data.",
            "Membawa camilan sehat ke kantor bisa membantumu tetap berenergi sepanjang hari.",
            "Jika sering bekerja dengan kode, gunakan tema monokrom atau dark mode agar lebih nyaman di mata.",
            "Menutup aplikasi yang tidak perlu bisa membantu mempercepat kinerja komputer.",
            "Menggunakan fitur split-screen bisa mempermudah multitasking di laptop atau komputer.",
            "Gunakan mouse ergonomis untuk mengurangi risiko cedera tangan akibat penggunaan jangka panjang.",
            "Menentukan prioritas kerja sejak pagi bisa membuat harimu lebih terorganisir dan produktif.",
            "Sebelum meeting, buat daftar poin yang ingin dibahas agar lebih efisien dan tidak membuang waktu.",
            "Gunakan filter email untuk mengatur inbox agar lebih rapi dan mudah ditemukan.",
            "Jika merasa burnout, ambil jeda sejenak dan lakukan sesuatu yang menyenangkan agar tetap semangat.",
            "Memulai pekerjaan dengan tugas yang lebih mudah bisa membantumu membangun momentum untuk tugas yang lebih sulit.",
            "Hindari multitasking berlebihan karena bisa mengurangi produktivitas dan meningkatkan kesalahan.",
            "Jika bekerja dari rumah, buat jadwal kerja yang jelas agar tetap disiplin dan fokus."
        ];

        $this->pesan = $pesan[array_rand($pesan)];


        if ($hour >= 5 && $hour <= 10) {
            $this->greet = "Selamat pagi,";
        } elseif ($hour >= 11 && $hour <= 15) {
            $this->greet = "Selamat siang,";
        } elseif ($hour >= 16 && $hour <= 19) {
            $this->greet = "Selamat sore,";
        } else {
            $this->greet = "Selamat malam,";
        }

        return view('livewire.utils.greetings');
    }
}
