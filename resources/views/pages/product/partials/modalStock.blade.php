<div class="modal fade" id="modal-stock" tabindex="-50" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-form-title">Stok produk</h5>
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="table-responsive p-0" id="table-list-check-product">
            <table class="table align-items-center mb-0">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 5%">
                            No </th>
                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 20%">
                            Nama Produk </th>
                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7" style="width: 20%">
                            Stok</th>
                    </tr>
                </thead>
                <tbody id="product-table-body">
                    <!-- Table rows will be dynamically added here -->
                </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>