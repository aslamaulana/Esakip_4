<?= $this->extend('_layout/template'); ?>

<?= $this->section('tombol'); ?>
<div>
	<a href="#" onclick="history.back(-1)">
		<li class="btn btn-block btn-info btn-sm" active><i class="nav-icon fa fa-chevron-left"></i> Kembali</li>
	</a>
</div>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="card-body">
	<form action="<?= base_url('/user/ropk/ropk_fisik/simpanExcel_rkpd') ?>" method="POST" enctype="multipart/form-data">
		<?= csrf_field() ?>
		<table class="table table-bordered">
			<tr>
				<td colspan="3">Import Data Dari RKPD Sub Kegiatan</td>
			</tr>
			<tr>
				<td style="width:120px;">Tahap 1 -> </td>
				<td style="width:220px;">Download Format Excel</td>
				<td>
					<div class="input-group">
						<a href="<?= base_url('/user/ropk/ropk_fisik/export_rkpd'); ?>">
							<li class="btn btn-block btn-success btn-sm" active><i class="nav-icon fa fa-file-excel"></i> Format</li>
						</a>
					</div>
				</td>
			</tr>
			<tr>
				<td>Tahap 2 -> </td>
				<td>Upload File Excel</td>
				<td>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" name="fileexcel" class="custom-file-input" id="file" required accept=".xls, .xlsx, .Xlsx, .Xls" /></p>
							<label class="custom-file-label">Pilih dokumen [xls, xlsx]</label>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Upload</button>
		</div>
	</form>
</div>

<?= $this->endSection(); ?>
<?= $this->section('Javascript'); ?>
<script>
	$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
	$(".file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".file-label").addClass("selected").html(fileName);
	});
</script>
<?= $this->endSection(); ?>