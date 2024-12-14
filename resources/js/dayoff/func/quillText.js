export function quillEditor() {
  // Ensure you import Quill and its CSS correctly
  const BlockEmbed = window.Quill.import('blots/block/embed');

  // Create a custom blot
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

  // Image handler function
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
        }
      }
    };
  }

  // Register the custom blot
  CustomEmbed.blotName = 'customEmbed'; // The name you want to use
  CustomEmbed.tagName = 'div'; // HTML tag
  Quill.register(CustomEmbed);

  // Initialize Quill
  const quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Tulis keterangan...',
    modules: {
      toolbar: [
        [{
          'header': [1, 2, false]
        }],
        ['bold', 'italic', 'underline'],
        ['image', 'code-block'],
        [{
          'list': 'ordered'
        }, {
          'list': 'bullet'
        }]
      ],
    }
  });

  document.querySelector('.ql-toolbar').classList.add('dark:bg-white', 'rounded-t-lg');
  document.querySelector('.ql-picker').classList.add('dark:bg-white');
  document.getElementById('editor').classList.add('!h-96', 'rounded-b-lg');

  // Kirim isi dari konten ke textarea
  $('#store').on('click', function () {
    const content = quill.root.innerHTML;
    $('#keterangan').val(content);
  });

  // Register the image handler
  quill.getModule('toolbar').addHandler('image', imageHandler);
}