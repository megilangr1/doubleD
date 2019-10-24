@extends('backend.layouts.master')

@section('content')
<div class="col-md-5">
    <div class="card card-dark">
        <div class="card-header">
            <h4 class="card-title">
                Master Kategori
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ isset($edit) ? route('kategori.update', Crypt::encrypt($edit->id)) : route('kategori.store') }}" method="post">
                @csrf
                @if (isset($edit))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" required="" value="{{ isset($edit) ? $edit->name : '' }}" autocomplete="off">
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
                Data Kategori
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($categories as $item)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <form action="{{ route('kategori.destroy', Crypt::encrypt($item->id)) }}" method="post" id="del">
                                        <a href="{{ route('kategori.edit', Crypt::encrypt($item->id)) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @php
                            $no++;
                        @endphp
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum Ada Data Kategori</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

