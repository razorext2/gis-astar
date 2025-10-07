<?php

namespace App\Livewire\Chart;

use App\Models\BigEventParticipant;
use App\Models\BigEventParticipantVisitor;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class ParticipantVisitorGraph extends Component
{
    public bool $isDark = false;

    public function makePalette(int $n = 10): array
    {
        $set = [];
        while (count($set) < $n) {
            // 3 bytes acak → hex
            $hex = '#' . bin2hex(random_bytes(3));
            $set[$hex] = true; // key memastikan unik
        }
        return array_keys($set);
    }

    public function render()
    {
        $visitorChart = (new ColumnChartModel())
            ->setTitle('Total Visitor')
            ->setAnimated(true)
            ->setColumnWidth(100)
            ->setDarkMode($this->isDark)
            ->setVertical()
            ->withoutLegend();

        $data = BigEventParticipant::where('big_event_id', '01k6w7ajs264rd3rf11pvmnsxe')->get();

        foreach ($data as $i => $item) {
            $totalVisitor = $item->bigEventVisitor->count();

            $visitorChart->addColumn(
                $item->userId->pegawai->nick_name ?? 'Unknown',       // nama user dari relasi
                $totalVisitor,      // hasil withCount()
                $this->makePalette($data->count())[$i],                // pakai index, bukan $loop->last
            );
        }

        return view('livewire.chart.participant-visitor-graph', compact('visitorChart'));
    }
}
