<?php

namespace App\Livewire;

use \App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

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
                return '[' . $query->kode_pegawai . '] ' . $query->userId->name;
            })
            ->add('role', fn($query) => ucfirst($query->role))
            ->add('total_poin', fn($query) => $query->userId->technicianPoint->sum('point') . ' Total poin')
            ->add('progress', function ($query) {
                $progress = [];
                $progress[$query->kode_pegawai] = $this->getApi($query->kode_pegawai);

                foreach ($progress[$query->kode_pegawai] as $month => $items) {
                    if (count($items) > 0 && $items[0]['TotalKunjungan'] > 0) {
                        $percentage = ($items[0]['SudahTerisi'] / $items[0]['TotalKunjungan']) * 100;
                        $label = $items[0]['SudahTerisi'] . '/' . $items[0]['TotalKunjungan'];
                    } else {
                        $percentage = 0;
                        $label = '0/0';
                    }

                    if ($percentage <= 50) {
                        $colorClass = "bg-red-600 text-gray-600 dark:text-red-100";
                    } elseif ($percentage <= 80) {
                        $colorClass = "bg-yellow-600 text-gray-600 dark:text-yellow-100";
                    } else {
                        $colorClass = 'bg-green-600 text-green-100';
                    }

                    return '<p class="mb-1 text-sm text-gray-800 dark:text-white">
								' . \Carbon\Carbon::parse($month)->locale('id')->format('F Y') . '
							</p>
							<div class="w-full rounded-full bg-gray-200 dark:bg-gray-600">
								<div class="' . $colorClass . ' rounded-full p-0.5 text-center text-xs font-medium leading-none"
									style="width: ' . $percentage . '%">
									' . $label . '
								</div>
							</div>';
                }
            });
    }

    public function columns(): array
    {
        return [
            Column::action('#'),

            Column::make('Nama Teknisi', 'nama_pegawai'),

            Column::make('Role', 'role'),

            Column::make('Total Poin', 'total_poin')
                ->contentClasses('text-center'),

            Column::make('Progress Laporan', 'progress'),
        ];
    }

    public function actions(TeamMember $row): array
    {
        return [
            Button::add('removeMember')
                ->slot('<svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                    </svg>')
                ->class('dark:bg-red-800 dark:hover:bg-red-900 dark:text-white dark:border-gray-700 rounded-lg bg-red-400 p-2 font-bold text-white border border-gray-200 hover:bg-red-700')
                ->dispatch('removeMemberModal', ['kode_pegawai' => $row->kode_pegawai, 'team_code' => $row->team_code])
        ];
    }

    public function getApi($kode_pegawai)
    {
        $api = Http::get('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchCountPoint&NomorIdentitasTeknisi=' . $kode_pegawai)->json();

        // Ambil semua bulan (format 'YYYY-MM') dari getMonth()
        $months = [];
        for ($i = 0; $i < 1; $i++) {
            $months[] = now()->subMonths($i)->format('Y-m');
        }


        $result = [];
        foreach ($months as $bulan) {
            $result[$bulan] = array_values(array_filter($api['data'] ?? [], function ($item) use ($bulan) {
                return isset($item['Bulan']) && $item['Bulan'] === $bulan;
            }));
        }

        return $result;
    }

    public function actionRules()
    {
        return [
            Rule::button('removeMember')
                ->when(fn() => Auth::user()->cannot('team-member-remove'))
                ->hide()
        ];
    }
}
