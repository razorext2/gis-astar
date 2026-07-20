<?php

/** Goal: Display various summary cards across different views, Caller: Blade dashboard or other list pages, Deps: Attendance, Collector, Sales, LeaveRequest */

namespace App\Livewire\Components;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\CollectIdyPpn;
use App\Models\Collector;
use App\Models\CollectTask;
use App\Models\CollectTaskPpn;
use App\Models\Sales;
use App\Services\Attendance\AttendanceCardService;
use App\Services\Collector\CollectorCardService;
use App\Services\DailyReport\DailyReportCardService;
use App\Services\Driver\DriverCardService;
use App\Services\Sales\SalesCardService;
use App\Services\Spk\SpkCardService;
use App\Services\System\ServerCardService;
use App\Services\Technician\TechnicianCardService;
use Livewire\Component;

class Card extends Component
{
    public string $type = 'dashboard';

    public array $cards = [];

    public function render()
    {
        $datas = $this->resolveCards();

        $totalData = collect($datas)->filter(function ($card) {
            $permission = $card['permission'] ?? 'all';

            return $permission === 'all' || auth()->user()->hasPermissionTo($permission);
        })->count();

        return view('livewire.components.card', ['data' => $datas, 'totalData' => $totalData]);
    }

    protected function resolveCards(): array
    {
        if (! empty($this->cards)) {
            return $this->cards;
        }

        return match ($this->type) {
            'dashboard' => $this->getDashboardCards(),
            'attendancetoday' => $this->getAttendanceTodayCards(),
            'attendancein' => $this->getAttendanceCards(Attendance::class),
            'attendanceout' => $this->getAttendanceCards(AttendanceOut::class),
            'collectorreport' => $this->getCOllectorReportCards(),
            'collectoridcnonppn' => $this->getCollectorCards(CollectTask::class),
            'collectoridcppn' => $this->getCollectorCards(CollectTaskPpn::class),
            'collectoridyppn' => $this->getCollectorCards(CollectIdyPpn::class),
            'spk' => $this->getSpkCards(),
            'spkpurchasingrequest' => $this->getSpkPurchasingRequestCards(),
            'spkproduction' => $this->getSpkProductionCards(),
            'spkdelivery' => $this->getSpkDeliveryCards(),
            'spkbilling' => $this->getSpkBillingCards(),
            'spkdailyreport' => $this->getSpkDailyReportCards(),
            'dailyreport' => $this->getDailyReportCards(),
            'technicianreport' => $this->getTechnicianReportCards(),
            'technicianteam' => $this->getTechnicianTeamCards(),
            'driverreport' => $this->getDriverReportCards(),
            'salesreport' => $this->getSalesReportCards(),
            'servermonitor' => $this->getServerMonitorCards(),
            default => [],
        };
    }

    protected function getSalesReportCards()
    {
        return app(SalesCardService::class)->getSalesReportCards();
    }

    protected function getDriverReportCards()
    {
        return app(DriverCardService::class)->getDriverReportCards();
    }

    protected function getTechnicianTeamCards()
    {
        return app(TechnicianCardService::class)->getTechnicianTeamCards();
    }

    protected function getTechnicianReportCards()
    {
        return app(TechnicianCardService::class)->getTechnicianReportCards();
    }

    protected function getCollectorReportCards()
    {
        return app(CollectorCardService::class)->getCollectorReportCards();
    }

    protected function getDailyReportCards()
    {
        return app(DailyReportCardService::class)->getDailyReportCards();
    }

    protected function getSpkDailyReportCards()
    {
        return app(SpkCardService::class)->getSpkDailyReportCards();
    }

    protected function getSpkBillingCards()
    {
        return app(SpkCardService::class)->getSpkBillingCards();
    }

    protected function getSpkDeliveryCards()
    {
        return app(SpkCardService::class)->getSpkDeliveryCards();
    }

    protected function getSpkProductionCards()
    {
        return app(SpkCardService::class)->getSpkProductionCards();
    }

    protected function getDashboardCards(): array
    {
        return [
            [
                'permission' => 'users-create',
                'label' => 'Pengguna',
                'count' => \App\Models\User::count(),
                'indicator' => 'Pegawai',
                'icon' => 'icons.users',
                'color' => 'red',
            ],
            [
                'permission' => 'pegawai-list',
                'label' => 'Absen hari ini',
                'count' => Attendance::whereDate('created_at', \Carbon\Carbon::today())
                    ->count(),
                'indicator' => 'Orang',
                'icon' => 'icons.check',
                'color' => 'red',
            ],
            [
                'permission' => 'collect-edit',
                'label' => 'Kolektor',
                'count' => auth()->user()->cannot('collect-approve')
                    ? Collector::needApprove()
                        ->where('kode_pegawai', auth()->user()->kode_pegawai)
                        ->count()
                    : Collector::needApprove()
                        ->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.wallet',
                'color' => 'red',
            ],
            [
                'permission' => 'sales-edit',
                'label' => 'Sales',
                'count' => auth()->user()->cannot('sales-approve')
                    ? Sales::needApprove()
                        ->where('kode_pegawai', auth()->user()->kode_pegawai)
                        ->count()
                    : Sales::needApprove()
                        ->count(),
                'indicator' => 'Laporan',
                'icon' => 'icons.cash-register',
                'color' => 'red',
            ],
        ];
    }

    protected function getSpkCards(): array
    {
        return app(SpkCardService::class)->getSpkCards();
    }

    protected function getAttendanceCards($model)
    {
        return app(AttendanceCardService::class)->getAttendanceCards($model);
    }

    protected function getAttendanceTodayCards()
    {
        return app(AttendanceCardService::class)->getAttendanceTodayCards();
    }

    protected function getCollectorCards($model)
    {
        return app(CollectorCardService::class)->getCollectorCards($model);
    }

    protected function getSpkPurchasingRequestCards(): array
    {
        return app(SpkCardService::class)->getSpkPurchasingRequestCards();
    }

    protected function getServerMonitorCards(): array
    {
        return app(ServerCardService::class)->getServerMonitorCards();
    }
}
