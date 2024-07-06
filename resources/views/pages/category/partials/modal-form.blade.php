<div class="modal fade" id="modal-form" tabindex="-50" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-form-title"></h5>
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="category-form" method="post">
        @csrf
        <div class="modal-body">
              <input hidden type="text" class="form-control" name="id" id="id">

            <div class="form-group d-flex align-items-center">
              <label for="name" class="me-2 text-sm">Nama</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama kategori">
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="submitForm()" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

