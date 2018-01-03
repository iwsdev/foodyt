<?php
/*
  Template Name:TestPayPal
 */
get_header();
?>
<section id="my-account" class="manageplan">
    <div class="container">
    <div id="paypal-button"></div> 
	<script src="https://www.paypalobjects.com/api/checkout.js"></script>
	<script>
		paypal.Button.render({
		
			env: 'sandbox', // Optional: specify 'sandbox' or 'production' environment
		
			client: {
				sandbox:    'weare@laitit.com',
				production: 'xxxxxxxxx'
			},

			payment: function() {
			
				var env    = this.props.env;
				var client = this.props.client;
			
				return paypal.rest.payment.create(env, client, {
					transactions: [
						{
							amount: { total: '100.00', currency: 'USD' }
						}
					]
				});
			},

			commit: true, // Optional: show a 'Pay Now' button in the checkout flow

			onAuthorize: function(data, actions) {
			
				// Optional: display a confirmation page here
			
				return actions.payment.execute().then(function() {
					// Show a success page to the buyer
				});
			}

		}, '#paypal-button');
	</script>
		
    </div>
    <!--
    <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_xclick-subscriptions">
	<input type="hidden" name="business" value="weare@laitit.com">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="no_shipping" value="1">
	<input type="image" src="http://www.paypal.com/en_GB/i/btn/x-click-but20.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
	<input type="hidden" name="a3" value="5.00">
	<input type="hidden" name="p3" value="1">
	<input type="hidden" name="t3" value="M">
	<input type="hidden" name="src" value="1">
	<input type="hidden" name="sra" value="1">
	</form>
	-->
</section>
<?php
get_footer();
?>
