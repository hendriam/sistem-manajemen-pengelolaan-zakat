<div class="row">
	<div class="col-md-6">
		<div class="mb-3">
			<label for="mustahik_id" class="form-label">Muzakki</label>
			<select class="form-control mustahik_id" name="mustahik_id" id="mustahik_id">
				<option value="">-- Cari Mustahik --</option>
				@foreach ($mustahiks as $mustahik)
				<option value="{{ $mustahik->id }}" {{ ($data->mustahik_id ?? '') == $mustahik->id ? "selected" : "" }}>{{ $mustahik->name }}</option>
				@endforeach
			</select>
		</div>

		<div class="mb-3">
			<label for="distribution_date" class="form-label">Tanggal</label>
			<input type="text" id="distributionDate" name="distribution_date" data-target="#distributionDate" data-toggle="datetimepicker" class="form-control datetimepicker-input" value="{{ $data->distribution_date ?? ''}}" placeholder="2025-05-14">
		</div>

		<div class="mb-3">
			<label for="program" class="form-label">Program</label>
			<input type="text" id="program" name="program" class="form-control" value="{{ $data->program ?? ''}}" placeholder="Contoh: Bantuan Bencana Alam">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="amount" class="form-label">Nominal</label>
			<input type="text" name="amount" id="amount" class="form-control" placeholder="Contoh: 500.000" value="{{ $data->amount ?? ''}}">
		</div>

		<div class="mb-3">
			<label for="notes" class="form-label">Keterangan (opsional)</label>
			<textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Contoh : Bantuan bencana alam">{{ $data->notes ?? '' }}</textarea>
		</div>
	</div>
</div>