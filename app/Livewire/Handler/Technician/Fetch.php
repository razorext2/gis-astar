<?php

namespace App\Livewire\Handler\Technician;

use App\Models\Technician;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Factory\RendererFactory;
use Jfcherng\Diff\Renderer\RendererConstant;
use Livewire\Component;

class Fetch extends Component
{
    public $apiData;
    public $dbData;
    public $diffResult;
    public string $id;

    public function mount()
    {
        $api = Http::get("https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchKunjungan&NomorKunjungan=$this->id")->json();

        $this->apiData = $api['data'][0]['RincianPekerjaan'];

        $this->dbData = Technician::where('no_vt', $this->id)
            ->first()
            ->job_detail;

        $this->renderDiff($this->apiData, $this->dbData);
    }

    public function renderDiff($api, $db)
    {
        $rendererName = 'SideBySide';

        $rendererOptions = [
            'detailLevel' => 'word',
            'language' => 'eng',
            'lineNumbers' => true,
            'separateBlock' => true,
            'showHeader' => true,
            'spacesToNbsp' => false,
            'tabSize' => 4,
            'mergeThreshold' => 0.8,
            'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
            'outputTagAsString' => false,
            'jsonEncodeFlags' => \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE,
            'wordGlues' => [' ', '-'],
            'resultForIdenticals' => null,
            'wrapperClasses' => ['diff-wrapper'],
        ];

        $jsonResult = DiffHelper::calculate($api, $db, 'Json');
        $htmlRenderer = RendererFactory::make($rendererName, $rendererOptions);
        $result = $htmlRenderer->renderArray(json_decode($jsonResult, true));

        $this->diffResult = $result;
    }

    public function update()
    {
        $query = Technician::where('no_vt', $this->id);

        if (!$query) {
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Data tidak ditemukan.');
        }

        try {
            DB::beginTransaction();

            $query->update([
                'job_detail' => $this->apiData,
            ]);

            DB::commit();
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil diperbarui');
            return $this->dispatch('redirectRoute', 'technician.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.handler.technician.fetch');
    }
}
