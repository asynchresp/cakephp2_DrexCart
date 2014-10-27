<h1>Order #<?php echo $order['DrexCartOrder']['id']; ?></h1>

<div class="row">
	<div class="col-md-6">
		<h3>Billing Address</h3>
		<?php 
		if ($order['DrexCartOrder']['billing_address1']) {
			$billing_address = array('DrexCartAddress'=>array('firstname'=>$order['DrexCartOrder']['billing_firstname'],
													'lastname'=>$order['DrexCartOrder']['billing_lastname'],
													'address1'=>$order['DrexCartOrder']['billing_address1'],
													'address2'=>$order['DrexCartOrder']['billing_address2'],
													'city'=>$order['DrexCartOrder']['billing_city'],
													'state'=>$order['DrexCartOrder']['billing_state'],
													'zip'=>$order['DrexCartOrder']['billing_zip']));
			echo $DCFunctions->formatAddress($billing_address);
		}
		?>
	</div>
	<div class="col-md-6">
		<h3>Shipping Address</h3>
		<?php 
		if ($order['DrexCartOrder']['shipping_address1']) {
			$shipping_address = array('DrexCartAddress'=>array('firstname'=>$order['DrexCartOrder']['shipping_firstname'],
					'lastname'=>$order['DrexCartOrder']['shipping_lastname'],
					'address1'=>$order['DrexCartOrder']['shipping_address1'],
					'address2'=>$order['DrexCartOrder']['shipping_address2'],
					'city'=>$order['DrexCartOrder']['shipping_city'],
					'state'=>$order['DrexCartOrder']['shipping_state'],
					'zip'=>$order['DrexCartOrder']['shipping_zip']));
			echo $DCFunctions->formatAddress($shipping_address);
		}
		?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-hover">
			<tr>
				<th>Product</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Total</th>
			</tr>
			<?php 
			if (isset($order_products)) {
				foreach($order_products as $product) {
					?>
					<tr>
						<td><?php echo $product['DrexCartProduct']['name']; ?></td>
						<td align="right"><?php echo number_format($product['DrexCartOrderProduct']['rate'],2); ?></td>
						<td align="center"><?php echo $product['DrexCartOrderProduct']['quantity']; ?></td>
						<td align="right"><?php echo number_format($product['DrexCartOrderProduct']['rate']*$product['DrexCartOrderProduct']['quantity'], 2); ?></td>
					</tr>
					<?php 
				}
			}
			?>
			<tr>
				<td colspan="4" style="border-top:2px solid #000000;"></td>
			</tr>
			<?php 
			// subtotal
			if (isset($order_totals)) {
				foreach($order_totals as $ot) {
					if ($ot['DrexCartOrderTotal']['code']=='subtotal') {
					?>
					<tr>
						<td></td>
						<td></td>
						<td align="right"><b>Sub Total:</b></td>
						<td align="right"><?php echo number_format($ot['DrexCartOrderTotal']['amount'], 2); ?></td>
					</tr>
					<?php 
					}
				}
			}
			
			?>
			<?php 
			// total
			if (isset($order_totals)) {
				foreach($order_totals as $ot) {
					if ($ot['DrexCartOrderTotal']['code']=='subtotal') {
					?>
					<tr>
						<td></td>
						<td></td>
						<td align="right"><b>Total:</b></td>
						<td align="right"><?php echo number_format($ot['DrexCartOrderTotal']['amount'], 2); ?></td>
					</tr>
					<?php 
					}
				}
			}
			
			?>
		</table>
	</div>
</div>

<?php //pr($order); ?>