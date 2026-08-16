<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        {{ $activeTab === 'rujukan' ? 'Laporan Riwayat Rujukan' : 'Laporan Data Pasien' }}
        — {{ now()->translatedFormat('d F Y') }}
    </title>
    @vite('resources/css/app.css')
    <style>
        @page { size: A4 landscape; margin: 1.5cm; }
        body { font-family: 'Poppins', Arial, sans-serif; font-size: 11px; background: #fff; color: #111; }
        table { width: 100%; border-collapse: collapse; page-break-inside: auto; }
        thead { background: #f1f5f9; }
        th, td { border: 1px solid #cbd5e1; padding: 5px 8px; text-align: left; vertical-align: top; }
        th { font-weight: 700; font-size: 10px; text-transform: uppercase; letter-spacing: 0.03em; color: #475569; }
        tr { page-break-inside: avoid; page-break-after: auto; }
        .badge { display: inline-block; padding: 1px 7px; border-radius: 99px; font-size: 10px; font-weight: 600; }
        .badge-pending  { background:#fef3c7; color:#92400e; }
        .badge-disetujui{ background:#d1fae5; color:#065f46; }
        .badge-ditolak  { background:#fee2e2; color:#991b1b; }
        .badge-selesai  { background:#dbeafe; color:#1e40af; }
        .badge-laki     { background:#e0f2fe; color:#0369a1; }
        .badge-perempuan{ background:#fce7f3; color:#9d174d; }
        .kop { border-bottom: 2px solid #1e293b; margin-bottom: 16px; padding-bottom: 12px; }
        .kop h1 { font-size: 16px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 2px; }
        .kop p  { font-size: 10px; color: #64748b; margin: 0; }
        .kop-meta { text-align: right; font-size: 10px; color: #64748b; }
        .metrics { display: grid; gap: 8px; margin-bottom: 16px; }
        .metrics.rujukan-grid { grid-template-columns: repeat(6, 1fr); }
        .metrics.pasien-grid  { grid-template-columns: repeat(5, 1fr); }
        .metric-card { border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 10px; background: #f8fafc; }
        .metric-card .label { font-size: 9px; color: #64748b; font-weight: 600; text-transform: uppercase; }
        .metric-card .value { font-size: 15px; font-weight: 800; margin-top: 2px; }
        .filter-info { border: 1px dashed #cbd5e1; border-radius: 6px; padding: 6px 12px; margin-bottom: 12px; font-size: 10px; color: #475569; }
        .filter-info span { margin-right: 14px; }
        .filter-info strong { color: #1e293b; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .no-border-cell { border: none; background: transparent; }
        .footer { margin-top: 20px; font-size: 9px; color: #94a3b8; text-align: right; border-top: 1px solid #e2e8f0; padding-top: 8px; }
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    {{-- KOP --}}
    <div class="kop">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <h1>SISTEM RUJUKAN MEDIS GIS-ASTAR</h1>
                <p>
                    {{ $activeTab === 'rujukan' ? 'Laporan Riwayat Rujukan Medis' : 'Laporan Data Pasien' }}
                    &nbsp;—&nbsp; Dokumen Resmi & Rekapitulasi
                </p>
            </div>
            <div class="kop-meta">
                <p>Dicetak pada: <strong>{{ now()->translatedFormat('d F Y H:i') }}</strong></p>
                <p>Periode:
                    <strong>
                        {{ $filters['date_from'] ? \Carbon\Carbon::parse($filters['date_from'])->translatedFormat('d M Y') : 'Semua' }}
                        @if($filters['date_from'] || $filters['date_to'])
                            s/d
                            {{ $filters['date_to'] ? \Carbon\Carbon::parse($filters['date_to'])->translatedFormat('d M Y') : 'Sekarang' }}
                        @endif
                    </strong>
                </p>
            </div>
        </div>
    </div>

    {{-- FILTER SUMMARY --}}
    @php
        $hasFilter = array_filter(array_values($filters));
    @endphp
    @if($hasFilter)
    <div class="filter-info">
        <strong>Filter Aktif:</strong>
        @if($filters['search']) <span>Pencarian: <strong>{{ $filters['search'] }}</strong></span> @endif
        @if($filters['status']) <span>Status: <strong>{{ collect($statusOptions)->firstWhere('value', $filters['status'])?->label() ?? $filters['status'] }}</strong></span> @endif
        @if($filters['rs_id'])  <span>RS: <strong>{{ $rumahSakitList->firstWhere('id_rumah_sakit', $filters['rs_id'])?->nama_rumah_sakit ?? $filters['rs_id'] }}</strong></span> @endif
        @if($filters['gender']) <span>Gender: <strong>{{ collect($genderOptions)->firstWhere('value', $filters['gender'])?->label() ?? $filters['gender'] }}</strong></span> @endif
        @if($filters['coord_status']) <span>GPS: <strong>{{ $filters['coord_status'] === 'with' ? 'Sudah Ada GPS' : 'Belum Ada GPS' }}</strong></span> @endif
    </div>
    @endif

    {{-- ===================== LAPORAN RUJUKAN ===================== --}}
    @if ($activeTab === 'rujukan')

        {{-- METRICS --}}
        <div class="metrics rujukan-grid">
            <div class="metric-card">
                <div class="label">Total Rujukan</div>
                <div class="value">{{ number_format($rujukanMetrics['total'] ?? 0) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Disetujui</div>
                <div class="value" style="color:#059669">{{ number_format($rujukanMetrics['disetujui'] ?? 0) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Selesai</div>
                <div class="value" style="color:#0d9488">{{ number_format($rujukanMetrics['selesai'] ?? 0) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Pending</div>
                <div class="value" style="color:#d97706">{{ number_format($rujukanMetrics['pending'] ?? 0) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Ditolak</div>
                <div class="value" style="color:#dc2626">{{ number_format($rujukanMetrics['ditolak'] ?? 0) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Total Jarak</div>
                <div class="value" style="color:#7c3aed">{{ $rujukanMetrics['total_jarak'] ?? 0 }} <span style="font-size:10px;font-weight:400">km</span></div>
            </div>
        </div>

        {{-- TABLE --}}
        <table>
            <thead>
                <tr>
                    <th style="width:30px">No</th>
                    <th>No. Rujukan</th>
                    <th>Tgl Rujukan</th>
                    <th>Nama Pasien / NIK / No. RM</th>
                    <th>Rumah Sakit Tujuan</th>
                    <th class="text-right">Jarak (km)</th>
                    <th class="text-right">Est. Biaya</th>
                    <th>Status</th>
                    <th>Dokter Perujuk</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rujukanData as $i => $row)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td style="font-weight:600;color:#2563eb">{{ $row->no_rujukan }}</td>
                    <td>{{ $row->tanggal_rujukan ? $row->tanggal_rujukan->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                        <div style="font-weight:600">{{ $row->pasien?->nama ?? '-' }}</div>
                        <div style="font-size:9px;color:#64748b">
                            NIK: {{ $row->pasien?->nik ?? '-' }} | RM: {{ $row->pasien?->no_rm ?? '-' }}
                        </div>
                    </td>
                    <td>{{ $row->rumahSakit?->nama_rumah_sakit ?? '-' }}</td>
                    <td class="text-right">
                        {{ $row->detailRujukan?->jarak ? number_format($row->detailRujukan->jarak, 2) : '-' }}
                    </td>
                    <td class="text-right">
                        {{ $row->detailRujukan?->estimasi_biaya ? 'Rp '.number_format($row->detailRujukan->estimasi_biaya, 0, ',', '.') : '-' }}
                    </td>
                    <td>
                        @php
                            $statusVal = $row->status?->value ?? 'pending';
                            $badgeClass = match($statusVal) {
                                'disetujui' => 'badge-disetujui',
                                'ditolak'   => 'badge-ditolak',
                                'selesai'   => 'badge-selesai',
                                default     => 'badge-pending',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $row->status?->label() ?? '-' }}</span>
                    </td>
                    <td>{{ $row->user?->name ?? '-' }}</td>
                    <td style="font-size:9px;color:#64748b">{{ $row->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center" style="padding:20px;color:#94a3b8">
                        Tidak ada data rujukan sesuai filter yang dipilih.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Total {{ number_format($rujukanData->count()) }} data rujukan | Dicetak oleh {{ auth()->user()?->name ?? '-' }} pada {{ now()->translatedFormat('d F Y H:i') }}
        </div>

    {{-- ===================== LAPORAN PASIEN ===================== --}}
    @elseif ($activeTab === 'pasien')

        {{-- METRICS --}}
        <div class="metrics pasien-grid">
            <div class="metric-card">
                <div class="label">Total Pasien</div>
                <div class="value">{{ number_format($pasienMetrics['total'] ?? 0) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Laki-laki</div>
                <div class="value" style="color:#0284c7">{{ number_format($pasienMetrics['laki_laki'] ?? 0) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Perempuan</div>
                <div class="value" style="color:#db2777">{{ number_format($pasienMetrics['perempuan'] ?? 0) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Titik GPS Ada</div>
                <div class="value" style="color:#059669">{{ number_format($pasienMetrics['berkoordinat'] ?? 0) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Tanpa GPS</div>
                <div class="value" style="color:#d97706">{{ number_format($pasienMetrics['tanpa_koordinat'] ?? 0) }}</div>
            </div>
        </div>

        {{-- TABLE --}}
        <table>
            <thead>
                <tr>
                    <th style="width:30px">No</th>
                    <th>No. RM</th>
                    <th>NIK</th>
                    <th>Nama Pasien</th>
                    <th>Gender</th>
                    <th>Tgl Lahir</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Koordinat GPS</th>
                    <th class="text-center">Jml Rujukan</th>
                    <th>Tgl Terdaftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pasienData as $i => $p)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td style="font-weight:600;color:#059669">{{ $p->no_rm ?? '-' }}</td>
                    <td>{{ $p->nik ?? '-' }}</td>
                    <td style="font-weight:600">{{ $p->nama }}</td>
                    <td>
                        @php $gender = $p->jenis_kelamin?->value ?? ''; @endphp
                        <span class="badge {{ $gender === 'laki_laki' ? 'badge-laki' : 'badge-perempuan' }}">
                            {{ $p->jenis_kelamin?->label() ?? '-' }}
                        </span>
                    </td>
                    <td>{{ $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                    <td>{{ $p->no_telepon ?? '-' }}</td>
                    <td style="font-size:9px;max-width:120px">{{ $p->alamat ?? '-' }}</td>
                    <td style="font-size:9px;font-family:monospace">
                        @if($p->hasCoordinates())
                            {{ round($p->latitude, 5) }}, {{ round($p->longitude, 5) }}
                        @else
                            <span style="color:#94a3b8">—</span>
                        @endif
                    </td>
                    <td class="text-center" style="font-weight:700;color:#2563eb">{{ $p->rujukan_count ?? 0 }}</td>
                    <td>{{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center" style="padding:20px;color:#94a3b8">
                        Tidak ada data pasien sesuai filter yang dipilih.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Total {{ number_format($pasienData->count()) }} data pasien | Dicetak oleh {{ auth()->user()?->name ?? '-' }} pada {{ now()->translatedFormat('d F Y H:i') }}
        </div>

    @endif

    <script>
        // Auto-print when page loads
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
</body>
</html>
