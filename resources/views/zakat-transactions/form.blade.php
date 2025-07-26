<div class="row">
	<div class="col-md-6">
		<div class="mb-3">
			<label for="muzakki_id" class="form-label">Muzakki</label>
			<select class="form-control muzakki_id" name="muzakki_id" id="muzakki_id">
				<option value="">-- Cari Muzakki --</option>
				@foreach ($muzakkis as $muzakki)
				<option value="{{ $muzakki->id }}" {{ ($data->muzakki_id ?? '') == $muzakki->id ? "selected" : "" }}>{{ $muzakki->name }}</option>
				@endforeach
			</select>
		</div>

		<div class="mb-3">
			<label for="zakat_transaction_date" class="form-label">Tanggal</label>
			<input type="text" id="zakatTransactionDate" name="zakat_transaction_date" data-target="#zakatTransactionDate" data-toggle="datetimepicker" class="form-control datetimepicker-input" value="{{ $data->zakat_transaction_date ?? ''}}" placeholder="2025-05-14">
		</div>

		<div class="mb-3">
			<label for="types_of_zakat" class="form-label">Jenis Zakat</label>
			<select class="form-control types_of_zakat" name="types_of_zakat" id="types_of_zakat">
				<option value="">-- Pilih --</option>
				<option value="fitrah" {{ ($data->types_of_zakat ?? '') == "fitrah" ? "selected" : "" }}>Fitrah</option>
				<option value="mal" {{ ($data->types_of_zakat ?? '') == "mal" ? "selected" : "" }}>Mal</option>
				<option value="profesi" {{ ($data->types_of_zakat ?? '') == "profesi" ? "selected" : "" }}>Profesi</option>
				<option value="lainnya" {{ ($data->types_of_zakat ?? '') == "lainnya" ? "selected" : "" }}>Lainnya</option>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="amount" class="form-label">Nominal</label>
			<input type="text" name="amount" id="amount" class="form-control" placeholder="Contoh: 500.000" value="{{ $data->amount ?? ''}}">
		</div>

		<div class="mb-3">
			<label for="notes" class="form-label">Keterangan (opsional)</label>
			<textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Contoh : John Wick membayar zakat profesi">{{ $data->notes ?? '' }}</textarea>
		</div>
	</div>
</div>