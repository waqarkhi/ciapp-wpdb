<div class="container">
	
<table class="table">
	<tr>
		<th>ID</th>
		<th>Titlte</th>
		<th>Status</th>
	</tr>
	<?php foreach ($products as $p): ?>
		<tr>
			<td><?= $p['ID'] ?></td>
			<td><?= $p['post_title'] ?></td>
			<td><?= $p['post_status'] ?></td>
		</tr>
	<?php endforeach ?>
</table>
</div>
<pre>
	<?php print_r($products); ?>
</pre>