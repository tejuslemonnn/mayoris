@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tables Pengeluaran Management'])
    <div class="container-fluid py-4">
        <div class="row" style="height: 80vh">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Pengeluaran Management</h6>
                        <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary">Add</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if (Session::has('success'))
                            <div class="alert alert-success mx-4 text-white">
                                {{ Session::get('success') }}
                                @php
                                    Session::forget('success');
                                @endphp
                            </div>
                        @endif

                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            No.</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Tanggal</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Total</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengeluarans as $pengeluaran)
                                        <tr>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ ($pengeluarans->currentPage() - 1) * $pengeluarans->perPage() + $loop->iteration }}
                                                </span>
                                            </td>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $pengeluaran->date }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-danger text-sm font-weight-bolder">-Rp.{{ $pengeluaran->total }}</span>
                                            </td>
                                            <td class="align-middle text-center d-flex gap-2 justify-content-center">
                                                <a href="{{ route('pengeluaran.edit', ['id' => $pengeluaran->id]) }}"
                                                    class="btn btn-info font-weight-bold text-xs" data-toggle="tooltip"
                                                    data-original-title="Edit user">
                                                    Edit
                                                </a>
                                                <form action="{{ route('pengeluaran.delete', ['id' => $pengeluaran->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger font-weight-bold text-xs">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $pengeluarans->links() }}
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
