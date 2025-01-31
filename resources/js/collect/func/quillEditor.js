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

  const quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Tulis keterangan...',
    readOnly: !editable,
    modules: {
      toolbar: editable ? [
        [{ 'header': [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        ['code-block'],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }]
      ] : false,
    }
  });

  if (data) {
    quill.root.innerHTML = data;
  }

  if (editable) {
    $('.ql-toolbar').addClass('dark:bg-white rounded-t-lg');
    $('.ql-picker').addClass('dark:bg-white');
    $('#editor').addClass('!h-96 rounded-b-lg');
    $("#keterangan").addClass("mt-2");

    $('#store').on('click', function () {
      const content = quill.root.innerHTML;
      $('#keterangan').val(content);
    });
  }

  if (!editable) {
    $('.ql-editor').addClass('!p-0');
  }
}
