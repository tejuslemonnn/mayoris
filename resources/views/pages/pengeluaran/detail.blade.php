@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Detail Pengeluaran'])
    <div class="container-fluid py-4">
        <div class="row" style="height: 80vh">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Detail Pengeluaran</h6>
                    </div>
                    <div class="card-body px-5 pt-2 pb-2">
                        <form action="{{ route('pengeluaran.update', ['id' => $pengeluaran->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date" class="form-label">Date</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="date" name="date"
                                                value="{{ $pengeluaran->date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total" class="form-label">Total</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input value="{{ $pengeluaran->total }}" type="number" min="0"
                                                class="form-control" name="total" id="total" readonly>
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 justify-content-end d-flex">
                                    <button type="button" class="btn btn-info font-weight-bold text-xs "
                                        id="tambahDetail">Tambah Detail</button>
                                </div>

                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Nama</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Kategori</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Jumlah</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Satuan</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Harga</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action</th>
                                                <th class="text-secondary opacity-7"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailTableBody">

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('pengeluaran') }}" class="btn btn-danger me-2">Cancel</a>
                                <button type="submit" class="btn btn-info">Edit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script>
        $(document).ready(function() {
            var pengeluaranDetail = {!! json_encode($pengeluaran->pengeluaranDetails) !!};

            pengeluaranDetail.forEach(element => {
                var newRow = '<tr>' +
                    '<td class="align-middle text-center">' +
                    '   <div class="input-group">' +
                    `       <input value="${element.nama}" type="text" class="form-control" name="nama[]" id="nama" required>` +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="input-group">' +
                    '       <select class="form-select" aria-label="Default select example kategori" name="kategori[]" id="kategori">' +
                    `           <option value="Pengambilan Uang" ${element.kategori == "Pengambilan Uang" ? "Selected" : ""}>Pengambilan Uang</option>` +
                    `           <option value="Beli Bahan" ${element.kategori == "Beli Bahan" ? "Selected" : ""}>Beli Bahan</option>` +
                    `           <option value="lainnya" ${element.kategori == "lainnya" ? "Selected" : ""}>lainnya</option>` +
                    '       </select>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="input-group">' +
                    `       <input value="${element.jumlah}" type="number" min="0" class="form-control" name="jumlah[]" id="jumlah" ${element.kategori != "Beli Bahan" ? "disabled" : ""}>` +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="input-group">' +
                    `       <select class="form-select" aria-label="Default select example" name="satuan[]" ${element.kategori != "Beli Bahan" ? "disabled" : ""}>` +
                    `           <option value="pcs"  ${element.satuan == "pcs" ? "Selected" : ""}>Pcs</option>` +
                    `           <option value="kg" ${element.satuan == "kg" ? "Selected" : ""}>Kg</option>` +
                    `           <option value="liter" ${element.satuan == "liter" ? "Selected" : ""}>Liter</option>` +
                    `           <option value="mililiter" ${element.satuan == "mililiter" ? "Selected" : ""}>Mililiter</option>` +
                    '       </select>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="input-group">' +
                    '       <span class="input-group-text">Rp.</span>' +
                    `       <input value="${element.harga}" type="number" min="0" class="form-control harga" name="harga[]" id="harga" required>` +
                    '       <span class="input-group-text">.00</span>' +
                    '   </div>' +
                    '</td>' +
                    '<td class="align-middle text-center d-flex gap-2 justify-content-center">' +
                    '   <button type="button" class="btn btn-danger font-weight-bold text-xs deleteRow">Delete</button>' +
                    '</td>' +
                    '</tr>';

                $("#detailTableBody").append(newRow);
            });

            $("#tambahDetail").click(function() {
                var newRow = '<tr>' +
                    '<td class="align-middle text-center">' +
                    '   <div class="input-group">' +
                    '       <input type="text" class="form-control" name="nama[]" id="nama" required>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="input-group">' +
                    '       <select class="form-select" aria-label="Default select example kategori" name="kategori[]" id="kategori">' +
                    '           <option value="Pengambilan Uang">Pengambilan Uang</option>' +
                    '           <option value="Beli Bahan">Beli Bahan</option>' +
                    '           <option value="lainnya">lainnya</option>' +
                    '       </select>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="input-group">' +
                    '       <input type="number" min="0" class="form-control" name="jumlah[]" id="jumlah" disabled>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="input-group">' +
                    '       <select class="form-select" aria-label="Default select example" name="satuan[]" disabled>' +
                    '           <option value="pcs">Pcs</option>' +
                    '           <option value="kg">Kg</option>' +
                    '           <option value="liter">Liter</option>' +
                    '           <option value="mililiter">Mililiter</option>' +
                    '       </select>' +
                    '   </div>' +
                    '</td>' +
                    '<td>' +
                    '   <div class="input-group">' +
                    '       <span class="input-group-text">Rp.</span>' +
                    '       <input type="number" min="0" class="form-control harga" name="harga[]" id="harga" required>' +
                    '       <span class="input-group-text">.00</span>' +
                    '   </div>' +
                    '</td>' +
                    '<td class="align-middle text-center d-flex gap-2 justify-content-center">' +
                    '   <button type="button" class="btn btn-danger font-weight-bold text-xs deleteRow">Delete</button>' +
                    '</td>' +
                    '</tr>';

                $("#detailTableBody").append(newRow);
            });

            $(document).on("change", "select[name='kategori[]']", function() {
                var isBeliBahan = $(this).val() === 'Beli Bahan';
                var row = $(this).closest("tr");
                var jumlahInput = row.find("input[name='jumlah[]']");
                var satuanSelect = row.find("select[name='satuan[]']");

                if (isBeliBahan) {
                    jumlahInput.prop("required", true);
                    satuanSelect.prop("required", true);
                } else {
                    jumlahInput.prop("required", false);
                    satuanSelect.prop("required", false);
                }

                jumlahInput.prop("disabled", !isBeliBahan);
                satuanSelect.prop("disabled", !isBeliBahan);
            });

            $(document).on("change", "input[name='harga[]']", function() {
                var totalInput = $("#total");
                var total = 0;

                $("input[name='harga[]']").each(function() {
                    var harga = parseFloat($(this).val()) || 0;
                    total += harga;
                });

                totalInput.val(total);
            });




            $(document).on("click", ".deleteRow", function() {
                var hargaInput = $(this).closest("tr").find("input[name='harga[]']");
                if (hargaInput.length > 0) {
                    var deletedValue = parseFloat(hargaInput.val()) || 0;
                    var totalInput = $("#total");
                    var total = parseFloat(totalInput.val()) || 0;
                    total -= deletedValue;
                    totalInput.val(total);
                }
                $(this).closest("tr").remove();
            });
        });
    </script>
@endsection
