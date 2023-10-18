@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tambah Pengeluaran'])
    <div class="container-fluid py-4">
        <div class="row" style="height: 80vh">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Tambah Pengeluaran</h6>
                    </div>
                    <div class="card-body px-5 pt-2 pb-2">
                        @if ($errors->any())
                            <div class="alert alert-danger mx-4 text-white">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pengeluaran.store') }}" method="POST">
                            @csrf
                            <div class="row align-items-end">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date" class="form-label">Date</label>
                                        <div class="input-group">
                                            <input value="{{ old('date') }}" type="date" class="form-control"
                                                id="date" name="date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total" class="form-label">Total</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input value="{{ old('total') }}" type="number" min="0"
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
                                <button type="submit" class="btn btn-info">Submit</button>
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
            $("#tambahDetail").click(function() {
                var newRow = '<tr>' +
                    '<td class="align-middle text-center">' +
                    '   <div class="input-group">' +
                    '       <input value="{{ old('nama') }}" type="text" class="form-control" name="nama[]" id="nama" required>' +
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
                    '       <input value="{{ old('jumlah') != null ? old('jumlah') : 0 }}" type="number" min="0" class="form-control" name="jumlah[]" id="jumlah" disabled>' +
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
                    '       <input value="{{ old('harga') }}" type="number" min="0" class="form-control harga" name="harga[]" id="harga" required>' +
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




            // Delete a row when the "Delete" button is clicked
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
