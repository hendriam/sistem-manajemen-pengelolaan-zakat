<div class="row">
	<div class="col-md-6">
		<div class="mb-3">
			<label for="name" class="form-label">Nama</label>
			<input type="text" name="name" id="name" class="form-control" placeholder="Contoh: John Wick" value="{{ $data->name ?? ''}}">
		</div>

		<div class="mb-3">
			<label for="phone" class="form-label">No. HP</label>
			<input type="text" name="phone" id="phone" class="form-control" placeholder="Contoh: 081234567891" value="{{ $data->phone ?? ''}}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="address" class="form-label">Alamat</label>
			<textarea name="address" id="address" class="form-control" rows="3" placeholder="Contoh : Jl. Periok No. 86">{{ $data->address ?? '' }}</textarea>
		</div>
	</div>
</div>