<div class="modal fade" id="modal-import-excel" tabindex="-50" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-form-title">Stok produk</h5>
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="import-product-form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group d-flex align-items-center">
                <label for="name" class="me-2 text-sm">File</label>
                <input type="file" class="form-control" name="file_excel" id="file-excel" placeholder="Masukkan file">
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" onclick="submitFormImport()" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>