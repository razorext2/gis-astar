import Quill from "quill";
import "quill/dist/quill.snow.css";

export function quillEditor(data = null, editable = true) {
  const BlockEmbed = Quill.import('blots/block/embed');

  class CustomEmbed extends BlockEmbed {
    static create(value) {
      let node = super.create();
      node.setAttribute('data-value', value);
      return node;
    }

    static format(node) {
      return node.getAttribute('data-value');
    }
  }

  CustomEmbed.blotName = 'customEmbed';
  CustomEmbed.tagName = 'div';
  Quill.register(CustomEmbed);

  // Inisialisasi editor
  const quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Tulis keterangan...',
    readOnly: !editable, // Set readOnly berdasarkan parameter
    modules: {
      toolbar: editable ? [ // Jika editable, tampilkan toolbar
        [{ 'header': [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        ['code-block'],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }]
      ] : false, // Jika tidak editable, sembunyikan toolbar
    }
  });

  // Jika ada data (untuk halaman update), isi editor dengan data tersebut
  if (data) {
    quill.root.innerHTML = data;
  }

  // Kirim data dari editor ke input hidden saat form disubmit
  if (editable) {
    // Penyesuaian tampilan editor
    document.querySelector('.ql-toolbar').classList.add('rounded-t-lg');
    document.getElementById('editor').classList.add('!h-96', 'rounded-b-lg');
    document.getElementById("keterangan").classList.add("mt-2");

    // Sync content instantly on text-change
    quill.on('text-change', function () {
      const rawText = quill.getText().trim();
      const content = rawText === '' ? '' : quill.root.innerHTML;
      $('#keterangan').val(content);

      // Hide alert on text change
      const alertElem = document.getElementById('alert-keterangan');
      if (alertElem && rawText.length >= 3) {
        alertElem.classList.add('hidden');
        alertElem.innerHTML = '';
      }
    });

    $('#store').on('click', function () {
      const rawText = quill.getText().trim();
      const content = rawText === '' ? '' : quill.root.innerHTML;
      $('#keterangan').val(content);
    });
  }

  // Jika editor dalam mode read-only, hapus padding
  if (!editable) {
    document.querySelector('.ql-editor').classList.add('!p-0');
  }
}
