@extends('template.master')

@section('accounts-active', 'active')

@section('content')
<div class="container-fluid py-0 px-0">
    <h1 class="h3 mb-3"><strong>Edit Akun</strong></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('accounts.update', $account->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="code" class="form-label">Kode</label>
                    <input type="text" name="code" id="code"
                           class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code', $account->code) }}" required>
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $account->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Keterangan</label>
                    <textarea name="description" id="description" rows="3"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $account->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select name="category" id="category" class="form-select select2 @error('category') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="asset" {{ old('category', $account->category) == 'asset' ? 'selected' : '' }}>Aset</option>
                        <option value="liability" {{ old('category', $account->category) == 'liability' ? 'selected' : '' }}>Kewajiban</option>
                        <option value="equity" {{ old('category', $account->category) == 'equity' ? 'selected' : '' }}>Modal</option>
                        <option value="cogs" {{ old('category', $account->category) == 'cogs' ? 'selected' : '' }}>Harga Pokok</option>
                        <option value="revenue" {{ old('category', $account->category) == 'revenue' ? 'selected' : '' }}>Pendapatan</option>
                        <option value="expense" {{ old('category', $account->category) == 'expense' ? 'selected' : '' }}>Beban</option>
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="normal_balance" class="form-label">Saldo Normal</label>
                    <select name="normal_balance" id="normal_balance" class="form-select select2 @error('normal_balance') is-invalid @enderror" required>
                        <option value="">-- Pilih Saldo Normal --</option>
                        <option value="debit" {{ old('normal_balance', $account->normal_balance) == 'debit' ? 'selected' : '' }}>Debit</option>
                        <option value="credit" {{ old('normal_balance', $account->normal_balance) == 'credit' ? 'selected' : '' }}>Credit</option>
                    </select>
                    @error('normal_balance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_payment_gateway" id="is_payment_gateway"
                        class="form-check-input" value="1"
                        {{ old('is_payment_gateway', $account->is_payment_gateway) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_payment_gateway">Apakah akun ini digunakan sebagai Payment Gateway?</label>
                    @error('is_payment_gateway')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-warning">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
