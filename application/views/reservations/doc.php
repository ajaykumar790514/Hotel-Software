<?php 
// echo "<pre>";
// print_r($row);
// print_r($property);
// echo "</pre>";
?>

<section>
	<div class="row">
		<div class="col-md-12">
			<table>
				<tr>
					<th>Remark</th>
					<td> : </td>
					<td><?=@$doc[0]->remark?></td>
				</tr>
				<tr>
					<th>In time</th>
					<td> : </td>
					<td><?php if(!empty(@$doc2->intime)){ echo date('D, M d ,Y h:i a',strtotime($doc2->intime)) ;}?></td>
				</tr>
			</table>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th colspan="7" class="text-center">
							Booking Document
						</th>
					</tr>
					<tr>
						<th class="text-center">
							Guest Name
						</th>
						<th class="text-center">
							Nationality
						</th>
						<th class="text-center">
							Proof Type
						</th>
						<th class="text-center">
							Proof No.
						</th>
						<th class="text-center">
							Proof Front
						</th>
						<th class="text-center">
							Proof Back
						</th>
						<th class="text-center">
							Agrement Doc.
						</th>
					</tr>
				</thead>
				<tbody class="doc">
					<?php foreach ($doc as $row) { ?>
					<tr>
						<td class="text-center"><?=$row->name?></td>
						<td class="text-center"><?=$row->nationality?></td>
						<td class="text-center"><?=$row->id_proof_type?></td>
						<td class="text-center"><?=$row->id_proof_no?></td>
						<td class="text-center">
							<img src="<?=IMGS_URL;?><?=$row->id_proof_pic_front?>" class="image-sm zoom-img">
						</td>
						<td class="text-center">
							<img src="<?=IMGS_URL;?><?=$row->id_proof_pic_back?>" class="image-sm zoom-img">
						</td>
						<td class="text-center">
							<img src="<?=IMGS_URL;?><?=$row->agreement_doc?>" class="image-sm zoom-img">
						</td>
						
					</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
	</div>
</section>