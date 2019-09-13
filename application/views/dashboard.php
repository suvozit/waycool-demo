<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('header', ['active_tab' => 'dashboard']); ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Medium', 'Count'],
    	<?php
  		foreach ($login_count as $login) {
  			?>
  			['<?php echo ucfirst($login['medium']); ?>', <?php echo $login['total']; ?>],
  			<?php
  		}
  		?>  
      // ['Work',     11],
      // ['Eat',      2],
      // ['Commute',  2],
      // ['Watch TV', 2],
      // ['Sleep',    7]
    ]);

    var options = {
      title: 'Total logins',
      is3D: true,
    };

    var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
    chart.draw(data, options);
  }
</script>

<div class="container my-4">
	<div class="row">
		<div class="col-lg-5 mb-2">
			<h1>Hello <?php echo $user['name']; ?>!</h1>

			<div id="donutchart" style="width: 500px; height: 500px;"></div>
		</div>

		<div class="col-lg-7">
			<h2>Login history</h2>

			<table class="table table-striped">
			  	<thead>
					<tr>
					  	<th scope="col">Medium</th>
					  	<th scope="col">User Agent</th>
					  	<th scope="col">IP</th>
					  	<th scope="col">Created</th>
					</tr>
			  	</thead>
			  	<tbody>
			  		<?php
			  		foreach ($login_history as $login) {
			  			?>
			  			<tr>
						  	<th scope="row"><?php echo ucfirst($login['medium']); ?></th>
						  	<td><?php echo $login['user_agent']; ?></td>
						  	<td><?php echo $login['ip']; ?></td>
						  	<td><?php echo $login['created']; ?></td>
						</tr>
			  			<?php
			  		}
			  		?>
			  	</tbody>
			</table>

			<?php
			if (!empty($account_history))
			{
				?>
				<br>
				<h2>Account History</h2>

				<table class="table table-striped">
				  	<thead>
						<tr>
						  	<th scope="col">Created</th>
						  	<th scope="col">Deleted</th>
						</tr>
				  	</thead>
				  	<tbody>
				  		<?php
						foreach ($account_history as $account) {
							?>
				  			<tr>
							  	<th scope="row"><?php echo $account['created']; ?></th>
							  	<td><?php echo $account['deleted']; ?></td>
							</tr>
							<?php
						}
						?>
				  	</tbody>
				</table>
				<?php
			}
			?>

		</div>
	</div>
</div>