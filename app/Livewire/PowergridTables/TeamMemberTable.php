<?php

/** Goal: Manage team members and track their finger logs/points, Caller: routes/web.php (teams.edit), Deps: TeamMember, User */

namespace App\Livewire\PowergridTables;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class TeamMemberTable extends PowerGridComponent
{
    public string $tableName = 'TeamMemberTable';

    public ?string $teamCode = null;

    public function setUp(): array
    {
        return [
            PowerGrid::header(),
        ];
    }

    public function datasource(): Builder
    {
        return TeamMember::query()
            ->where('team_code', $this->teamCode)
            ->with('userId');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('kode_pegawai')
            ->add('nama_pegawai', function ($query) {
                $statusSuffix = ($query->userId && !$query->userId->is_active) ? ' (Nonaktif)' : '';
                return '['.$query->kode_pegawai.'] '.$query->userId->name . $statusSuffix;
            })
            ->add('role', fn ($query) => ucfirst($query->role))
            ->add('total_poin', fn ($query) => $query->userId->technicianPoint->sum('point').' Total poin')
            ->add('progress', function ($query) {
                $progress = [];
                $progress[$query->kode_pegawai] = $this->getApi($query->kode_pegawai);

                $html = '';

                foreach ($progress[$query->kode_pegawai] as $month => $items) {
                    $total = $items[0]['TotalKunjungan'] ?? 0;
                    $filled = $items[0]['SudahTerisi'] ?? 0;

                    $percentage = $total > 0 ? ($filled / $total) * 100 : 0;
                    $label = "{$filled}/{$total}";

                    if ($percentage <= 50) {
                        $colorClass = 'bg-red-600 text-gray-600 dark:text-red-100';
                    } elseif ($percentage <= 80) {
                        $colorClass = 'bg-yellow-600 text-gray-600 dark:text-yellow-100';
                    } else {
                        $colorClass = 'bg-green-600 text-green-100';
                    }

                    $html .= '
                        <p class="mb-1 text-sm text-gray-800 dark:text-white">'
                        .\Carbon\Carbon::parse($month)->locale('id')->isoFormat('MMMM Y').
                        '</p>
                        <div class="w-full rounded-full bg-gray-200 dark:bg-gray-600">
                            <div class="'.$colorClass.' rounded-full p-0.5 text-center text-xs font-medium leading-none"
                                style="width: '.$percentage.'%">
                                '.$label.'
                            </div>
                        </div>
                    ';
                }

                return $html;
            });
    }

    public function columns(): array
    {
        return [
            Column::action('#'),

            Column::make('Nama Teknisi', 'nama_pegawai'),

            Column::make('Role', 'role'),

            Column::make('Total Poin (DB)', 'total_poin')
                ->contentClasses('text-center'),

            Column::make('Progress Laporan (API)', 'progress'),
        ];
    }

    public function actions(TeamMember $row): array
    {
        return [
            Button::add('removeMember')
                ->slot('<svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                    </svg>')
                ->class('dark:bg-red-800 dark:hover:bg-red-900 dark:text-white dark:border-zinc-800 rounded-lg bg-red-400 p-2 font-bold text-white border border-zinc-200 hover:bg-red-700')
                ->dispatch('removeMemberModal', ['kode_pegawai' => $row->kode_pegawai, 'team_code' => $row->team_code]),
        ];
    }

    public function getApi($kode_pegawai)
    {
        return Cache::remember('team_progress_api_'.$kode_pegawai, now()->addHours(2), function () use ($kode_pegawai) {
            try {
                $api = Http::timeout(5)->get(
                    'https://indodacin.nusa.net.id/web/finger/secureapi.php',
                    [
                        'tipe' => 'fetchCountPoint',
                        'NomorIdentitasTeknisi' => $kode_pegawai,
                    ]
                )->json();
            } catch (\Exception $e) {
                return [];
            }

            $months = collect(range(0, 2))
                ->map(fn ($i) => now()->subMonths($i)->format('Y-m'));

            $data = collect($api['data'] ?? []);

            return $months->mapWithKeys(fn ($bulan) => [
                $bulan => $data->filter(fn ($item) => ($item['Bulan'] ?? null) === $bulan)->values(),
            ])->toArray();
        });
    }

    public function actionRules()
    {
        return [
            Rule::button('removeMember')
                ->when(fn () => Auth::user()->cannot('team-member-delete'))
                ->hide(),
        ];
    }
}

