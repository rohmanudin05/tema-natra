<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if($tipe==1){?>
	<script type="text/javascript">
		$(function ()
		{
			var chart;
			$(document).ready(function ()
			{
				chart = new Highcharts.Chart(
				{
					chart:
					{
						renderTo: 'container'
					},
					title:0,
					xAxis:
					{
						categories: [
						<?php $i=0;foreach($stat as $data){$i++;?>
							<?php if($data['jumlah'] != "-" AND $data['nama']!= "TOTAL" AND $data['nama']!= "JUMLAH"){echo "'$i',";}?>
						<?php }?>
						]
					},
					plotOptions:
					{
						series:
						{
							colorByPoint: true
						},
						column:
						{
							pointPadding: -0.1,
							borderWidth: 0
						}
					},
					legend:
					{
						enabled:false
					},
					series: [
					{
						type: 'column',
						name: 'Jumlah Populasi',
						shadow:1,
						border:1,
						data: [
						<?php foreach($stat as $data){?>
							<?php if($data['jumlah'] != "-" AND $data['nama']!= "TOTAL" AND $data['nama']!= "JUMLAH"){?>
								['<?php echo $data['nama']?>',<?php echo $data['jumlah']?>],
							<?php }?>
						<?php }?>
						]
					}]
				});
			});

		});
	</script>
<?php }else{?>
	<script type="text/javascript">
		$(function ()
		{
			var chart;
			$(document).ready(function ()
			{

			// Build the chart
			chart = new Highcharts.Chart(
			{
				chart:
				{
					renderTo: 'container'
				},
				title:0,
				plotOptions:
				{
					pie:
					{
						allowPointSelect: true,
						cursor: 'pointer',
						showInLegend: true
					}
				},
				series: [
				{
					type: 'pie',
					name: 'Jumlah Populasi',
					shadow:1,
					border:1,
					data: [
					<?php foreach($stat as $data){?>
						<?php if($data['jumlah'] != "-" AND $data['nama']!= "TOTAL" AND $data['nama']!= "JUMLAH" AND $data['nama']!= "PENERIMA"){?>
							['<?php echo $data['nama']?>',<?php echo $data['jumlah']?>],
						<?php }?>
					<?php }?>
					]
				}]
			});
		});

		});
	</script>
	<script type="text/javascript">
		function tampilkan_nol(tampilkan=false)
		{
			if (tampilkan)
			{
				$(".nol").parent().show();
			}
			else
			{
				$(".nol").parent().hide();
			}
		}
		function toggle_tampilkan()
		{
			$('#showData').click();
			tampilkan_nol(status_tampilkan);
			status_tampilkan = !status_tampilkan;
			if (status_tampilkan) $('#tampilkan').text('Tampilkan Nol');
			else $('#tampilkan').text('Sembunyikan Nol');
		}
		var status_tampilkan = true;
		$(document).ready(function ()
		{
			tampilkan_nol(false);
		});
	</script>
<?php }?>
<style>
	tr.lebih
	{
		display:none;
	}
</style>
<script>
	$(function(){
		$('#showData').click(function()
		{
			$('tr.lebih').show();
			$('#showData').hide();
			tampilkan_nol(false);
		});
	});
</script>
<style>
	.input-sm
	{
		padding: 4px 4px;
	}
	@media (max-width:780px)
	{
		.btn-group-vertical
		{
			display: block;
		}
	}
	.table-responsive
	{
		min-height:275px;
	}
	}
</style>
<div class="single_page_area">
	<h2 class="post_titile">Grafik Data Demografi Berdasar <?= $heading ?></h2>
	<div class="box-tools pull-right">
		<div class="btn-group-xs">
			<?php $strC = ($tipe==1)? "btn-primary":"btn-default"; ?>
			<a href="<?= site_url("first/statistik/$st/1") ?>" class="btn <?= $strC ?> btn-xs">Bar Graph</a>
			<?php $strC = ($tipe==0)? "btn-primary":"btn-default";?>
			<a href="<?= site_url("first/statistik/$st/0") ?>" class="btn <?= $strC ?> btn-xs">Pie Cart</a>
		</div>
	</div>
</div>
<div class="box-body">
	<div id="container"></div>
	<div id="contentpane">
		<div class="ui-layout-north panel top"></div>
	</div>
</div>

<div class="box-header with-border">
	<h2 class="post_titile">Tabel <?= $heading ?></h2>
</div>
<div class="box-body">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th rowspan="2">Kode</th>
					<th rowspan="2" style='text-align:left;'>Kelompok</th>
					<th colspan="2">Jumlah</th>
					<?php if ($jenis_laporan == 'penduduk'):?>
						<th colspan="2">Laki-laki</th>
						<th colspan="2">Perempuan</th>
					<?php endif;?>
				</tr>
				<tr>
					<th style='text-align:right'>n</th><th style='text-align:right'>%</th>
					<?php if ($jenis_laporan == 'penduduk'):?>
						<th style='text-align:right'>n</th><th style='text-align:right'>%</th>
						<th style='text-align:right'>n</th><th style='text-align:right'>%</th>
					<?php endif;?>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; $l=0; $p=0; $hide=""; $h=0; $jm1=1; $jm = count($stat);?>
				<?php foreach ($stat as $data):?>
					<?php $jm1++; if (1):?>
					<?php $h++; if ($h > 12 AND $jm > 10): $hide="lebih"; ?>
				<?php endif;?>
				<tr class="<?=$hide?>">
					<td class="angka">
						<?php if ($jm1 > $jm - 2):?>
							<?=$data['no']?>
							<?php else:?>
								<?=$h?>
							<?php endif;?>
						</td>
						<td><?=$data['nama']?></td>
						<td class="angka <?php ($jm1 <= $jm - 2) and ($data['jumlah'] == 0) and print('nol')?>"><?=$data['jumlah']?></td>
						<td class="angka"><?=$data['persen']?></td>
						<?php if ($jenis_laporan == 'penduduk'):?>
							<td class="angka"><?=$data['laki']?></td>
							<td class="angka"><?=$data['persen1']?></td>
							<td class="angka"><?=$data['perempuan']?></td>
							<td class="angka"><?=$data['persen2']?></td>
						<?php endif;?>
					</tr>
					<?php $i += $data['jumlah'];?>
					<?php $l += $data['laki']; $p += $data['perempuan'];?>
				<?php endif;?>
			<?php endforeach;?>
		</tbody>
	</table>
	<?php if($hide=="lebih"):?>
		<div style='float: left;'>
			<button class='uibutton special' id='showData'>Selengkapnya...</button>
		</div>
	<?php endif;?>
	<div style="float: right;">
		<button id='tampilkan' onclick="toggle_tampilkan();" class="uibutton special">Tampilkan Nol</button>
	</div>
</div>
</div>

<?php if (in_array($st, array('bantuan_keluarga', 'bantuan_penduduk'))):?>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-12">
				<input id="stat" type="hidden" value="<?=$st?>">
				<div class="box box-info">
					<div class="box-header with-border" style="margin-bottom: 15px;">
						<h2 class="post_titile">Daftar <?= $heading ?></h2>
					</div>
						<div class="table-responsive">
							<table class="table table-striped table-bordered" id="peserta_program">
								<thead>
									<tr>
				      		  <th>No</th>
										<th>Program</th>
				      		  <th>Nama Peserta</th>
				      		  <th>Alamat</th>
									</tr>
								</thead>
					      <tfoot>
					      </tfoot>
							</table>
						</div>
				</div>
			</div>
		</div>
	</section>

	<script type="text/javascript">
		$(document).ready(function() {

		  var url = "<?= site_url('first/ajax_peserta_program_bantuan')?>";
		    table = $('#peserta_program').DataTable({
		      'processing': true,
		      'serverSide': true,
		      "pageLength": 10,
		      'order': [],
		      "ajax": {
		        "url": url,
		        "type": "POST",
		        "data": {stat: $('#stat').val()}
		      },
		      //Set column definition initialisation properties.
		      "columnDefs": [
		        {
		          "targets": [ 0, 3 ], //first column / numbering column
		          "orderable": false, //set not orderable
		        },
		      ],
		      'language': {
		        'url': BASE_URL + '/assets/bootstrap/js/dataTables.indonesian.lang'
		      },
		      'drawCallback': function (){
		          $('.dataTables_paginate > .pagination').addClass('pagination-sm no-margin');
		      }
		    });

		} );
	</script>
<?php endif;?>
