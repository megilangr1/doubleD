@extends('backend.layouts.master')

@section('content')
<div class="col-md-5">
    <div class="card card-dark">
        <div class="card-header">
            <h4 class="card-title">
                Master Gudang
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ isset($edit) ? route('gudang.update') : route('gudang.store') }}" method="post">
                <div class="form-group">
                    <label for="">Nama Gudang</label>
                    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }} ">
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                </div>
                <div class="form-group">
                    @if (isset($edit))
                        <button class="btn btn-success btn-sm">
                            <i class="fas fa-check"></i> &ensp;
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('gudang.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-times"></i> &ensp;
                            Batal Perubahan
                        </a>
                    @else
                        <button class="btn btn-success btn-sm">
                            <i class="fas fa-paper-plane"></i> &ensp;
                            Tambah Data
                        </button>
                        <button type="reset" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-undo"></i> &ensp;
                            Reset Input
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-7">
    <div class="card card-dark">
        <div class="card-header">
            <h4 class="card-title">
                Data Gudang
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Gudang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($warehouses as $item)
                        tr
                    @empty
                        <tr>
                            <td colspan="3">Belum Ada Data Gudang</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
