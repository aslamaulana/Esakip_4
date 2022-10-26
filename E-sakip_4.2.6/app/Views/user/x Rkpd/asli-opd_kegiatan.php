<?= $this->extend('_layout/template'); ?>

<?= $this->section('stylesheet'); ?>
<link rel="stylesheet" href="<?= base_url('/toping/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('tombol'); ?>
<?php if (menu('renja')->kunci == 'tidak') { ?>
	<div>
		<a href="<?= base_url('/user/rkpd/opd_kegiatan/import'); ?>">
			<li class="btn btn-block btn-success btn-sm" active><i class="nav-icon fa fa-file-excel"></i> Import</li>
		</a>
	</div>
<?php } else { ?>
	<div style="width:90px;">
		<a href="#">
			<li class="btn btn-block btn-danger btn-sm" active><i class="nav-icon fa fa-lock"></i></li>
		</a>
	</div>
<?php } ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="card-body">
	<table id="example1" class="table table-bordered display nowrap table-sm">
		<thead>
			<tr>
				<th class="text-center" width="30px">No</th>
				<th>
					<div style="width: 700px;">Program / Kegiatan / Sub Kegiatan Indikator</div>
				</th>
				<th class="text-center">
					<div style="width: 120px; margin:auto;"><?= $_SESSION['tahun']; ?></div>
				</th>
				<th class="text-center">
					<div style="width: 120px; margin:auto;">Pagu <?= $_SESSION['tahun']; ?></div>
				</th>
				<th class="text-center">
					<div style="width: 120px; margin:auto;"><?= $_SESSION['tahun'] + 1; ?></div>
				</th>
				<th class="text-center">
					<div style="width: 120px; margin:auto;">Pagu <?= $_SESSION['tahun'] + 1; ?></div>
				</th>
				<th style="width: 60px; text-align:center;">Aksi</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th class="text-center">No</th>
				<th>Program / Kegiatan / Sub Kegiatan Indikator</th>
				<th class="text-center"><?= $_SESSION['tahun']; ?></th>
				<th class="text-center">Pagu <?= $_SESSION['tahun']; ?></th>
				<th class="text-center"><?= $_SESSION['tahun'] + 1; ?></th>
				<th class="text-center">Pagu <?= $_SESSION['tahun'] + 1; ?></th>
				<th class="text-center">Aksi</th>
			</tr>
		</tfoot>
		<tbody>
			<?php
			$nomor = 1;
			foreach ($rkpd_program as $rol) : ?>
				<tr class="font-weight-bold" style="background-color: blanchedalmond;">
					<td class="text-center"><?= $nomor++; ?></td>
					<td class="text-wrap align-top"><?= $rol['rkpd_program_n']; ?> </td>
					<td></td>
					<td class="text-right">
						<?php $pagu0 = $db->table('vw_pagu_rkpd_program')
							->selectsum('rp_tahun')
							->getWhere(['vw_pagu_rkpd_program.rkpd_program_n' => $rol['rkpd_program_n'], 'vw_pagu_rkpd_program.opd_id' => user()->opd_id, 'vw_pagu_rkpd_program.tahun' => $_SESSION['tahun']])->getRowArray();
						echo number_format($pagu0['rp_tahun'], 2, ',', '.');
						?>
					</td>
					<td></td>
					<td class="text-right">
						<?php $pagu01 = $db->table('vw_pagun_rkpd_program')
							->selectsum('rp_tahun+n')
							->getWhere(['vw_pagun_rkpd_program.rkpd_program_n' => $rol['rkpd_program_n'], 'vw_pagun_rkpd_program.opd_id' => user()->opd_id, 'vw_pagun_rkpd_program.tahun' => $_SESSION['tahun']])->getRowArray();
						echo number_format($pagu01['rp_tahun+n'], 2, ',', '.');
						?>
					</td>
					<td style="text-align: center;"> </td>
				</tr>
				<?php $query = $db->table('tb_rkpd_kegiatan')
					->select('set_kegiatan_90.id_kegiatan, tb_rkpd_kegiatan.rkpd_kegiatan_n')
					->distinct('set_kegiatan_90.id_kegiatan, tb_rkpd_kegiatan.rkpd_kegiatan_n')
					->join('set_kegiatan_90', 'tb_rkpd_kegiatan.rkpd_kegiatan_n = set_kegiatan_90.kegiatan', 'left')
					->getWhere(['tb_rkpd_kegiatan.rkpd_program_n' => $rol['rkpd_program_n'], 'tb_rkpd_kegiatan.opd_id' => user()->opd_id, 'tb_rkpd_kegiatan.tahun' => $_SESSION['tahun']])->getResultArray();
				foreach ($query as $ros) : ?>
					<tr class="font-weight-bold" style="background: azure;">
						<td><?= $ros['id_kegiatan']; ?></td>
						<td class="text-wrap align-top"><?= $ros['rkpd_kegiatan_n']; ?> </td>
						<td></td>
						<td class="text-right">
							<?php $pagu1 = $db->table('tb_rkpd_kegiatan_sub')->selectsum('rp_tahun')->getWhere(['tb_rkpd_kegiatan_sub.rkpd_kegiatan_n' => $ros['rkpd_kegiatan_n'], 'tb_rkpd_kegiatan_sub.opd_id' => user()->opd_id, 'tb_rkpd_kegiatan_sub.tahun' => $_SESSION['tahun']])->getRowArray();
							echo number_format($pagu1['rp_tahun'], 2, ',', '.');
							?>
						</td>
						<td></td>
						<td class="text-right">
							<?php $pagu2 = $db->table('tb_rkpd_kegiatan_sub')->selectsum('rp_tahun+n')->getWhere(['tb_rkpd_kegiatan_sub.rkpd_kegiatan_n' => $ros['rkpd_kegiatan_n'], 'tb_rkpd_kegiatan_sub.opd_id' => user()->opd_id, 'tb_rkpd_kegiatan_sub.tahun' => $_SESSION['tahun']])->getRowArray();
							echo number_format($pagu2['rp_tahun+n'], 2, ',', '.');
							?>
						</td>
						<td style="text-align: center;"> </td>
					</tr>
					<?php
					$tahun = $_SESSION['tahun'];
					$querz = $db->table('tb_rkpd_kegiatan')->getWhere(['rkpd_kegiatan_n' => $ros['rkpd_kegiatan_n'], 'tahun' => $_SESSION['tahun'], 'opd_id' => user()->opd_id])->getResultArray();
					foreach ($querz as $rom) : ?>
						<tr>
							<td></td>
							<td class="text-wrap align-top">
								<div style="padding-left: 40px;"><?= $rom['rkpd_indikator_kegiatan']; ?></div>
							</td>
							<td class="align-top text-wrap text-center"><?= $rom['t_tahun'] . ' ' . $rom['satuan']; ?></td>
							<td class="align-top text-wrap text-right"><?= $rom['rp_tahun']; ?></td>
							<td class="align-top text-wrap text-center"><?= $rom['t_tahun+n'] . ' ' . $rom['satuan']; ?></td>
							<td class="align-top text-wrap text-right"><?= $rom['rp_tahun+n']; ?></td>
							<td style="text-align: center;">
								<?php if (menu('renja')->kunci == 'tidak') { ?>
									<a class="btn btn-info btn-circle btn-xs" href="<?= base_url() . '/user/rkpd/opd_kegiatan/opd_kegiatan_indik_edit/' . $rom['id_rkpd_kegiatan']; ?>">
										<i class="nav-icon fas fa-pen-alt"></i>
									</a>
									<a class="btn btn-danger btn-circle btn-xs" onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){location.href='<?= base_url() . '/user/rkpd/opd_kegiatan/opd_kegiatan_indik_hapus/' . $rom['id_rkpd_kegiatan']; ?>'}" href="#">
										<i class="nav-icon fas fa-trash-alt"></i>
									</a>
								<?php } else { ?>
									<a class="btn btn-danger btn-circle btn-xs">
										<i class="nav-icon fas fa-lock"></i>
									</a>
								<?php } ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?= $this->endSection(); ?>

<?= $this->section('Javascript'); ?>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('/toping/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('/toping/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script>
	$(function() {
		bsCustomFileInput.init();
	});
	$(function() {
		$("#example1").DataTable({
			"scrollX": true,
			"scrollY": '65vh',
			"scrollCollapse": true,
			"paging": true,
			"responsive": true,
			"autoWidth": false,
			"ordering": false,
			"lengthMenu": [
				[20, 40, 60, 100, -1],
				[20, 40, 60, 100, 'All']
			]
		});
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
		});
	});
</script>
<?= $this->endSection(); ?>