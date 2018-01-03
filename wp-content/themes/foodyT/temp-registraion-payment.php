<?php
/*
Template Name:registration payment page
*/
get_header();?>





<section id="digital_menu_form2" class="digital_menu_form2">
	<div class="container">
		<form method="post" action="">
			<div class="row">
				<div class="col-md-6 left">
					<div class="account_information">
							<h3>Account Information</h3>
							<div class="form-group">
								<label for="email">Email:</label>
								<input type="email" name="email" class="form-control" id="email">
							</div>
						  <div class="form-group">
							<label for="m_number">Mobile Number</label>
							<input type="text" name="mobileNumber" class="form-control" id="m_number">
						  </div>
					  </div>
					  
					  <div class="payment_method">
							<h3>Payment Method</h3>
							<div class="form-group">
								<label for="card_number">Card Number</label>
								<input type="text"  name="cardNumber" class="form-control" id="c_number">
							</div>
						  <div class="form-group">
							<label for="c_h_name">Cardholder Name</label>
							<input type="text" name="cardHolderName" class="form-control" id="c_h_name">
						  </div>
						  
						  <div class="form-group expiry">
							<label for="expiry">Expiry</label>
							<div class="row">
								<div class="col-md-12">
									<select name="month">
										<option>Month</option>
										<option>Jan</option>
										<option>Feb</option>
										<option>Mar</option>
										<option>Apr</option>
										<option>May</option>
										<option>Jun</option>
										<option>July</option>
										<option>Aug</option>
										<option>Sep</option>
										<option>Oct</option>
										<option>Nov</option>
										<option>Dec</option>
									</select>
									
									<select class="year" name="year">
										<option>Year</option>		
									</select>
									
									<input type="text" name="cvv" class="cvv" placeholder="CVV">
								</div>
							</div>
						  </div>
					  </div>
					  
					  
					  <div class="billing_address">
							<h3>Billing Address</h3>
							<div class="form-group">
								<label for="billingAddressbillingAddress">Address:</label>
								<input type="text" name="billingAddress" class="form-control" id="billingAddress">
							</div>
						  <div class="form-group">
							<label for="city">City</label>
							<input type="text" name="city" class="form-control" id="city">
						  </div>
						  <div class="form-group">
							<label for="state">State</label>
							<input type="text" name="state" class="form-control" id="state">
						  </div>
						  <div class="form-group">
							<label for="postal_code">Postal Code</label>
							<input type="text" name="postalCode" class="form-control" id="country">
						  </div>
					  </div>
					  
					  
				</div>
				
				<div class="col-md-6 right">
					<div class="order-summary">
						<h4>Order Summary</h4>
						<ul>
							<li>Basic <span>19,90 €</span></li>
							<li>Photograph <span>5 €</span></li>
							<li>1 add language <span>5 €</span></li>
							<li>Monthly Report<span>5 €</span></li>
							<li>Total<span>34,90 € / month</span></li>
						</ul>
					</div>
					<div class="row">
						 <div class="col-sm-12 recieve-form1">
							<div class="wrap">
							<p>First month for free. In case you do not want to continue using it, cancel your subscription.</p>
							</div>
							<div class="place_order">
								<input type="submit" value="Place Order">
							</div>
						</div>
						
						
					</div>
				</div>
			</div>
		</form>
	</div>
</section>




<?php get_footer();
?>