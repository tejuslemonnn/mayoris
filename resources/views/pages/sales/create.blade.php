@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Create Sales'])
    <div class="container-fluid py-4">
        <div class="row" style="height: 80vh">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Add Sales</h6>
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

                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date" class="form-label">Date</label>
                                        <div class="input-group">
                                            <input value="{{old('date')}}" type="date" class="form-control" id="date" name="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="omset" class="form-label">Omset</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input value="{{old('omset')}}" type="number" min="0" class="form-control" name="omset"
                                                id="omset">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sold" class="form-label">Sold</label>
                                        <div class="input-group">
                                            <input value="{{old('sold')}}" type="number" min="0" class="form-control" name="sold"
                                                id="sold">
                                            <span class="input-group-text">pcs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('sales') }}" class="btn btn-danger me-2">Cancel</a>
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
