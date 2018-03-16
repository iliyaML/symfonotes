const notes = document.getElementById('notes');

if (notes) {
  notes.addEventListener('click', e => {
    if (e.target.className === 'btn btn-danger delete-note') {
      if (confirm('Are you sure?')) {
        const id = e.target.getAttribute('data-id');

        fetch(`/note/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}