<?php

namespace App\Livewire\Forms\Spk;

use App\Livewire\Concerns\HandlesErrors;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;
use Livewire\WithFileUploads;

class Attachment extends Form
{
    use HandlesErrors, WithFileUploads;

    public ?array $new_attachments = [];

    public $attachment;

    public ?string $attachment_type = null;

    /** @var TemporaryUploadedFile|null */
    protected function rules(): array
    {
        return [
            'attachment_type' => ['required', 'string'],

            'new_attachments' => ['array'],
            'new_attachments.*._key' => ['required', 'string'],
            'new_attachments.*.url' => ['nullable', 'string'],
            'new_attachments.*.nama_file' => ['nullable', 'string'],
            'new_attachments.*.tipe_dokumen' => ['required', 'string'],
            'new_attachments.*.ext' => ['required', 'string'],

            // upload validation
            'attachment' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'min:10', // 10KB
                'max:5120', // 5MB
            ],
        ];
    }

    protected $messages = [
        'attachment_type.required' => 'Tipe dokumen wajib dipilih',
        'attachment.mimes' => 'Format file harus JPG / PNG',
        'attachment.max' => 'Ukuran maksimal file 2MB',
        'new_attachments.*.nama_file.required' => 'Nama file tidak valid',
    ];

    public function addAttachment(): void
    {
        // validasi input yang berhubungan saja
        $this->validateOnly('attachment_type');
        $this->validateOnly('attachment');

        if (! $this->attachment) {
            return;
        }

        $this->new_attachments[] = [
            '_key' => (string) Str::uuid(),
            'file' => $this->attachment,
            'url' => null,
            'nama_file' => $this->attachment->getClientOriginalName(),
            'ext' => $this->attachment->getClientOriginalExtension(),
            'tipe_dokumen' => $this->attachment_type,
        ];

        // reset input
        $this->reset('attachment', 'attachment_type');

    }

    public function removeAttachment(int $index)
    {
        // hapus dari folder temporary livewire
        if (isset($this->new_attachments[$index]['file'])) {
            $this->new_attachments[$index]['file']->delete();
        }

        unset($this->new_attachments[$index]);

        return $this->new_attachments = array_values($this->new_attachments);
    }

    public function storeAttachment()
    {
        foreach ($this->new_attachments as $index => $attachment) {
            $path = 'spk/'.$attachment['tipe_dokumen'].'/';
            $name = Str::uuid().'.'.$attachment['ext'];

            if (isset($attachment['file'])) {
                $attachment['file']->storeAs(
                    path: $path,
                    name: $name,
                    options: 'local'
                );
            }

            // update array asli
            $this->new_attachments[$index]['url'] = $path.$name;

            // hapus object file agar tidak ikut diserialisasi
            unset($this->new_attachments[$index]['file']);
        }

        return $this->new_attachments;
    }
}
