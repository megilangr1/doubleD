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
                            <option value="{{ Crypt::encrypt($item->id) }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-danger">{{ $errors->first('warehouse_id') }}</p>
                </div>
                <div class="form-group">
                    <label for="">Nama Rak Penyimpanan : </label>
                    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}"  required="">
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
