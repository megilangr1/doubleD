@extends('backend.layouts.master')

@section('content')
<div class="col-md-5">
    <div class="card card-dark">
        <div class="card-header">
            <h4 class="card-title">
                Master Rak Penyimpanan
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ isset($edit) ? route('rak.update', $edit->id):route('rak.store') }}" method="post">
                <div class="form-group">
                    <label for="">Lokasi Rak Penyimpanan : </label>
                    <select name="warehouse_id" id="warehouse_id" class="form-control select2" style="width: 100%; height:40px;" data-placeholder="Pilih Lokasi Gudang" required="">
                        <option value=""></option>
                        @foreach ($warehouses as $item)
                            <option value="{{ Crypt::encrypt($item->id) }}"
                                @if (isset($edit))
                                    {{ Crypt::encrypt($edit->warehouse_id) == Crypt::encrypt($item->id) ? 'selected':'' }}
                                @endif
                                >{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-danger">{{ $errors->first('warehouse_id') }}</p>
                </div>
                <div class="form-group">
                    <label for="">Nama Rak Penyimpanan : </label>
                    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" value="{{ isset($edit) ? $edit->name:'' }}" required="">
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
@endsection
