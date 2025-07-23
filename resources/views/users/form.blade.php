<div class="row">
	<div class="col-md-6">
		<div class="mb-2">
			<label for="name" class="form-label">Nama</label>
			<input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Admin 1" value="{{ $data->name ?? ''}}">
		</div>
		<div class="mb-2">
			<label for="username" class="form-label">Username</label>
			<input type="text" name="username" id="username" class="form-control" placeholder="Contoh: admin123" value="{{ $data->username ?? ''}}">
		</div>
		<div class="mb-2">
			<label for="role" class="form-label">Role</label>
			<select class="form-control" name="role" id="role">
				<option value="">-- Select role --</option>
				<option value="admin" {{ ($data->role ?? '') == "admin" ? "selected" : "" }}>Admin</option>
				<option value="kasir" {{ ($data->role ?? '') == "kasir" ? "selected" : "" }}>Kasir</option>
				<option value="supervisor" {{ ($data->role ?? '') == "supervisor" ? "selected" : "" }}>Supervisor</option>
			</select>
		</div>
	</div>
</div>