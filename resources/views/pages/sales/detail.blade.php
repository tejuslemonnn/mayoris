@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tables'])
    <div class="container-fluid py-4">
        <div class="row" style="height: 80vh">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Add Sales</h6>
                    </div>
                    <div class="card-body px-5 pt-2 pb-2">
                        <form action="{{ route('sales.update', ['id' => $sale->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date" class="form-label">Date</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="date" name="date"
                                                value="{{ $sale->date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="omset" class="form-label">Omset</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input type="number" min="0" class="form-control" name="omset"
                                                id="omset" value="{{ $sale->omset }}">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sold" class="form-label">Sold</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control" name="sold"
                                                id="sold" value="{{ $sale->sold }}">
                                            <span class="input-group-text">pcs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('sales') }}" class="btn btn-danger me-2">Cancel</a>
                                <button type="submit" class="btn btn-info">Edit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
