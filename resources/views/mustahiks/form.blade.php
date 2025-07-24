<div class="row">
	<div class="col-md-6">
		<div class="mb-3">
			<label for="name" class="form-label">Nama</label>
			<input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Budi Doremi" value="{{ $data->name ?? ''}}">
		</div>

		<div class="mb-3">
			<label for="phone" class="form-label">No. HP</label>
			<input type="text" name="phone" id="phone" class="form-control" placeholder="Contoh: 081234567891" value="{{ $data->phone ?? ''}}">
		</div>

		<div class="mb-3">
			<label for="asnaf_category" class="form-label">Kategori Asnaf</label>
			<select class="form-control asnaf_category" name="asnaf_category" id="asnaf_category">
				<option value="">-- Pilih kategori asnaf --</option>
				<option value="fakir" {{ ($data->asnaf_category ?? '') == "fakir" ? "selected" : "" }}>Fakir</option>
				<option value="miskin" {{ ($data->asnaf_category ?? '') == "miskin" ? "selected" : "" }}>Miskin</option>
				<option value="amil" {{ ($data->asnaf_category ?? '') == "amil" ? "selected" : "" }}>Amil</option>
				<option value="gharim" {{ ($data->asnaf_category ?? '') == "gharim" ? "selected" : "" }}>Gharim</option>
				<option value="fisabilillah" {{ ($data->asnaf_category ?? '') == "fisabilillah" ? "selected" : "" }}>Fisabilillah</option>
				<option value="ibnu_sabil" {{ ($data->asnaf_category ?? '') == "ibnu_sabil" ? "selected" : "" }}>Ibnu Sabil</option>
				<option value="riqab" {{ ($data->asnaf_category ?? '') == "riqab" ? "selected" : "" }}>Riqab</option>
				<option value="mualaf" {{ ($data->asnaf_category ?? '') == "mualaf" ? "selected" : "" }}>Mualaf</option>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="mb-3">
			<label for="address" class="form-label">Alamat</label>
			<textarea name="address" id="address" class="form-control" rows="3" placeholder="Contoh : Jl. Periok No. 86">{{ $data->address ?? '' }}</textarea>
		</div>
	</div>
</div>