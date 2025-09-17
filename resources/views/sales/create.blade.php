@extends('template.master')

@section('sales-active', 'active')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-3"><strong>Tambah Penjualan</strong></h1>

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <div class="row mb-2">
                <div class="col-md-2">
                    <label>Kode</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $code) }}" readonly>
                </div>
                <div class="col-md-2">
                    <label>Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}"
                        required>
                </div>
                <div class="col-md-2">
                    <label>Cabang</label>
                    <select name="branch_id" class="form-select select2" required>
                        <option value="">-- Pilih Cabang --</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Gudang</label>
                    <select name="warehouse_id" class="form-select select2" required>
                        <option value="">-- Pilih Gudang --</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Customer</label>
                    <select name="contact_id" class="form-select select2" required>
                        <option value="">-- Pilih Customer --</option>
                        @foreach ($contacts as $contact)
                            <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Diskon %</th>
                            <th>Diskon (Rp)</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="salesDetails">
                        <tr>
                            <td style="width: 35%;">
                                <select name="item_id[]" class="form-select select2 item-select" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}" data-satuan="{{ $item->mainUnit->name }}"
                                            data-harga="{{ $item->selling_price_main }}">{{ $item->code }} -
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="qty[]" class="form-control form-control-sm currency-input">
                                <small class="text-muted unit-label text-end"></small>
                            </td>
                            <td><input type="text" name="price[]" class="form-control form-control-sm currency-input">
                            </td>
                            <td><input type="text" name="discount_percent[]"
                                    class="form-control form-control-sm currency-input"></td>
                            <td><input type="text" name="discount[]" class="form-control form-control-sm currency-input"
                                    readonly></td>
                            <td><input type="text" name="total[]" class="form-control form-control-sm currency-input"
                                    readonly></td>
                            <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" id="addRow" class="btn btn-secondary btn-sm">Tambah Baris</button>
            <hr>

            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <tr>
                        <td>
                            <label class="form-label">Subtotal</label>
                            <input type="text" name="subtotal" id="subtotal" class="form-control currency-input"
                                readonly>
                        </td>
                        <td>
                            <label class="form-label">Pajak (%)</label>
                            <input type="text" name="tax_percent" id="tax_percent" class="form-control currency-input">
                        </td>
                        <td>
                            <label class="form-label">Pajak (Rp)</label>
                            <input type="text" name="tax" id="tax" class="form-control currency-input"
                                readonly>
                        </td>
                        <td>
                            <label class="form-label">Ongkir</label>
                            <input type="text" name="freight" id="freight" class="form-control currency-input">
                        </td>
                        <td>
                            <label class="form-label">Biaya Lain</label>
                            <input type="text" name="expense" id="expense" class="form-control currency-input">
                        </td>
                        <td style="display: none;">
                            <label class="form-label">Diskon Faktur</label>
                            <input type="text" name="discount_header" id="discount_header"
                                class="form-control currency-input">
                        </td>
                        <td>
                            <label class="form-label">Grand Total</label>
                            <input type="text" name="grand_total" id="grand_total" class="form-control currency-input"
                                readonly>
                        </td>
                    </tr>
                </table>
            </div>

            <hr>
            <h4>Pembayaran</h4>
            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <tr>
                        <td>
                            <label class="form-label">Akun Kas/Bank</label>
                            <select name="account_id" class="form-select select2">
                                <option value="">-- Pilih Akun --</option>
                                @foreach ($payment_gateways as $account)
                                    <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <label class="form-label">Jumlah Dibayar</label>
                            <input type="text" name="payment_amount" id="payment_amount"
                                class="form-control currency-input">
                        </td>
                    </tr>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        // Formatter angka Indonesia
        const formatter = new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });

        function parseNumber(value) {
            return parseFloat((value || '').toString().replace(/\./g, '').replace(/,/g, '.')) || 0;
        }

        function formatCurrency(input) {
            let value = parseNumber(input.value);
            input.value = value ? formatter.format(value) : '';
        }

        function hitungTotalRow(row) {
            let qty = parseNumber(row.querySelector('[name="qty[]"]').value);
            let price = parseNumber(row.querySelector('[name="price[]"]').value);
            let discPercent = parseNumber(row.querySelector('[name="discount_percent[]"]').value);
            if (!discPercent || discPercent < 0) discPercent = 0;

            let bruto = qty * price;
            let discFromPercent = bruto * discPercent / 100;
            let total = bruto - discFromPercent;

            row.querySelector('[name="discount[]"]').value = formatter.format(discFromPercent);
            row.querySelector('[name="total[]"]').value = formatter.format(total);
            return total;
        }

        function hitungGrandTotal() {
            let subtotal = 0;
            document.querySelectorAll('#salesDetails tr').forEach(row => {
                subtotal += hitungTotalRow(row);
            });

            let discountHeader = parseNumber(document.getElementById('discount_header')?.value);
            if (!discountHeader || discountHeader < 0) discountHeader = 0;

            let dpp = subtotal - discountHeader;
            if (dpp < 0) dpp = 0;

            let taxPercent = parseNumber(document.getElementById('tax_percent')?.value);
            if (!taxPercent || taxPercent < 0) taxPercent = 0;

            let tax = dpp * taxPercent / 100;
            let freight = parseNumber(document.getElementById('freight')?.value);
            let expense = parseNumber(document.getElementById('expense')?.value);

            let grandTotal = dpp + tax + freight + expense;

            document.getElementById('subtotal').value = formatter.format(subtotal);
            document.getElementById('tax').value = formatter.format(tax);
            document.getElementById('grand_total').value = formatter.format(grandTotal);
        }

        // Add Row
        document.getElementById('addRow').addEventListener('click', function() {
            let row = document.querySelector('#salesDetails tr').cloneNode(true);

            row.querySelectorAll('input').forEach(input => input.value = '');
            row.querySelectorAll('.unit-label').forEach(span => span.textContent = '');
            row.querySelector('select').selectedIndex = 0;
            row.querySelector('select').classList.add('item-select');

            document.getElementById('salesDetails').appendChild(row);

            // Reinit select2
            $(row).find('.select2').removeClass('select2-hidden-accessible').next(".select2").remove();
            $(row).find('.select2').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih --',
                width: '100%'
            });
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeRow')) {
                e.target.closest('tr').remove();
                hitungGrandTotal();
            }
        });

        // Format currency & hitung total
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('currency-input')) {
                formatCurrency(e.target);
                hitungGrandTotal();
            }
        });

        // Item dipilih → harga & satuan + console log debug
        $(document).on('change', '.item-select', function() {
            const row = $(this).closest('tr');
            const selected = $(this).find('option:selected');

            const harga = parseFloat(selected.data('harga')) || 0;
            const satuan = selected.data('satuan') || '';

            // Set harga
            row.find('[name="price[]"]').val(harga ? formatter.format(harga) : '');

            // Set satuan
            row.find('.unit-label').text(satuan);

            // Debug output ke console
            // console.log('Item dipilih:', selected.text());
            // console.log('Harga:', harga);
            // console.log('Satuan:', satuan);

            hitungTotalRow(row[0]);
            hitungGrandTotal();
        });

        // Submit → ubah semua currency input ke number
        document.querySelector('form').addEventListener('submit', function() {
            document.querySelectorAll('.currency-input').forEach(input => {
                input.value = parseNumber(input.value);
            });
        });

        // Hitung awal
        hitungGrandTotal();
    </script>
@endsection
