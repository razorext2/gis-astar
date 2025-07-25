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

        $this->apiData = $api['data'][0];
        $this->dbData = Technician::where('no_vt', $this->id)->first();

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

        $data_api = [
            'customer_name' => $api['CustomerContact'],
            'customer_address' => $api['AlamatLengkapKunjungan'],
            'job_detail' => $api['RincianPekerjaan'],
        ];

        $data_db = [
            'customer_name' => $db->customer_contact,
            'customer_address' => $db->customer_address,
            'job_detail' => $db->job_detail,
        ];

        $htmlRenderer = RendererFactory::make($rendererName, $rendererOptions);
        $combinedDiffResult = '';

        foreach ($data_api as $key => $apiValue) {
            $dbValue = $data_db[$key] ?? '';

            $jsonResult = DiffHelper::calculate($apiValue, $dbValue, 'Json');
            $result = $htmlRenderer->renderArray(json_decode($jsonResult, true));

            if ($result)
                $combinedDiffResult .= "<span class='font-semibold text-gray-800 dark:text-white text-left'>" . ucfirst(str_replace('_', ' ', $key)) . "</span>" . $result;
        }

        $this->diffResult = $combinedDiffResult;
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
                'job_detail' => $this->apiData['RincianPekerjaan'],
                'customer_contact' => $this->apiData['CustomerContact'],
                'customer_address' => $this->apiData['AlamatLengkapKunjungan'],
            ]);

            DB::commit();

            return redirect()->route('technician.show', $this->id)->with('status', 'Data berhasil diperbarui');
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
