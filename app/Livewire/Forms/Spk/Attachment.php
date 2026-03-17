<?php

namespace App\Livewire\Forms\Spk;

use App\Livewire\Concerns\HandlesErrors;
use Illuminate\Support\Facades\Storage;
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
                'min:5', // 5kb
                'max:2048', // 2MB
            ],
        ];
    }

    protected $messages = [
        'attachment.file' => 'File harus berformat jpg, jpeg, png, pdf, doc, docx, xls, xlsx.',
        'attachment.mimes' => 'File harus berformat jpg, jpeg, png, pdf, doc, docx, xls, xlsx.',
        'attachment.min' => 'Ukuran file minimal 5KB.',
        'attachment.max' => 'Ukuran maksimal file 2MB',
        'attachment_type.required' => 'Tipe dokumen wajib dipilih',
        'new_attachments.*.nama_file.required' => 'Nama file tidak valid',
    ];

    public function addAttachment(): void
    {
        // validasi input yang berhubungan saja
        $this->validateOnly('attachment');
        $this->validateOnly('attachment_type');

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
        $stored = [];

        foreach ($this->new_attachments as $index => $attachment) {
            if (! isset($attachment['file'])) {
                continue;
            }

            $path = 'spk/'.$attachment['tipe_dokumen'].'/';
            $name = Str::uuid().'.'.$attachment['file']->extension();

            try {
                $attachment['file']->storeAs(
                    path: $path,
                    name: $name,
                    options: 'local'
                );

                // update array asli
                $this->new_attachments[$index]['url'] = $path.$name;

                // hapus object file agar tidak ikut diserialisasi
                unset($this->new_attachments[$index]['file']);

                // update array
                $stored[] = $path.$name;
            } catch (\Exception $e) {
                foreach ($stored as $file) {
                    Storage::delete($file);
                }

                throw $e ?? new \Exception('Terjadi kesalahan saat menyimpan file.');
            }
        }

        return $this->new_attachments;
    }
}
