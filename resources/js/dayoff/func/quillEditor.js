export function quillEditor(data = null, editable = true) {
  const BlockEmbed = Quill.import('blots/block/embed');

  class CustomEmbed extends BlockEmbed {
    static create(value) {
      let node = super.create();
      node.setAttribute('data-value', value);
      return node;
    }

    static formats(node) {
      return node.getAttribute('data-value');
    }
  }

  function imageHandler() {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.click();

    input.onchange = async () => {
      const file = input.files[0];

      if (file) {
        const formData = new FormData();
        formData.append('image', file);

        try {
          // Use Axios to upload the image
          const response = await axios.post(uploadUrl, formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          });

          const range = quill.getSelection();
          if (range) {
            quill.insertEmbed(range.index, 'image', response.data.url); // Insert the image into Quill
          } else {
            console.error('No selection in Quill to insert image');
          }
        } catch (error) {
          console.error('Failed to upload image', error);

          const alertElement = document.getElementById('alert-image');
          alertElement.classList.add('block');
          alertElement.innerHTML = error.response.data.errors.image[0]; // Display the first error message
        }
      }
    };
  }

  // Inisialisasi editor
  CustomEmbed.blotName = 'customEmbed'; // The name you want to use
  CustomEmbed.tagName = 'div'; // HTML tag
  Quill.register(CustomEmbed);

  // Initialize Quill
  const quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Tulis keterangan...',
    readOnly: !editable, // Set readOnly berdasarkan parameter
    modules: {
      toolbar: editable ? [ // Jika editable, tampilkan toolbar
        [{ 'header': [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        ['image', 'code-block'],
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
    // Penyesuaian tampilan editors
    document.querySelector('.ql-toolbar').classList.add('dark:bg-white', 'rounded-t-lg');
    document.querySelector('.ql-picker').classList.add('dark:bg-white');
    document.getElementById('editor').classList.add('!h-96', 'rounded-b-lg');
    document.getElementById("keterangan").classList.add("mt-2");

    $('#store').on('click', function () {
      const content = quill.root.innerHTML;
      $('#keterangan').val(content);
    });

    quill.getModule('toolbar').addHandler('image', imageHandler);
  }

  // Jika editor dalam mode read-only, hapus padding
  if (!editable) {
    document.querySelector('.ql-editor').classList.add('!p-0');
  }
}