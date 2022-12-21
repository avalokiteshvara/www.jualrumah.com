<!-------------- member/dashboard.php ------------------>
<?php
    if (! defined('BASEPATH'))
        exit('No direct script access allowed');
?>

<?php 
    if ($this->session->userdata('sudah_login') == 0)
    {
        redirect(base_url() . 'member/login/', 'refresh');
    }
?>        
<div class="row">
	<div class="span4">
		<div class="row">
			<h4 class="span3 well">Change location and criteria</h4>
			<div class="span3 well">

				<form class="form-inline mini" style="margin-bottom: 0px;" />
				<fieldset>
					<div class="row">
						<div class="span3">
							<div class="control-group">
								<label for="focusedInput" class="control-label">Location</label>
								<div class="controls">
									<input type="text" value="London"
										placeholder="Where do you want to live?" id="focusedInput"
										class="span2" />
								</div>
							</div>

							<div class="row">
								<div class="span3">
									<div class="control-group">
										<label for="focusedInput" class="control-label">Radius</label>
										<div class="controls">
											<select class="span2">
												<option />This area only
												<option />Within 1/4 mile
												<option />Within 1/2 mile
												<option />Within 1 mile
												<option />Within 3 miles
												<option />Within 5 miles
												<option />Within 10 miles
												<option />Within 15 miles
												<option />Within 20 miles
												<option />Within 30 miles
												<option />Within 40 miles
											</select>
										</div>
									</div>
								</div>
								<div class="span2 ">
									<div class="control-group">
										<label for="focusedInput" class="control-label">Property</label>
										<div class="controls">
											<select class="span2">
												<option />Any
												<option />Houses
												<option />Flats/ Apartments
												<option />Bungalows
												<option />Land
												<option />Commercial property
												<option />Other
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="span3">
									<div class="control-group">
										<label for="focusedInput" class="control-label">Bedrooms</label>
										<div class="controls">
											<select class="span2">
												<option />Any
												<option />1
												<option />2
												<option />3
												<option />4
												<option />5+
											</select>
										</div>
									</div>
								</div>
								<div class="span3">
									<div class="control-group">
										<label for="focusedInput" class="control-label">Rent/Buy</label>
										<div class="controls">
											<select class="span2">
												<option />Any
												<option />Rent
												<option />Buy
											</select>
										</div>
									</div>
								</div>

								<div class="span3">
									<div class="control-group">
										<label for="focusedInput" class="control-label">Price</label>
										<div class="controls">
											<select class="span1" style="width: 68px;">
												<option selected="selected" value="" />Min
												<option value="50000" />50,000
												<option value="60000" />60,000
												<option value="70000" />70,000
												<option value="80000" />80,000
												<option value="90000" />90,000
												<option value="100000" />100,000
												<option value="110000" />110,000
												<option value="120000" />120,000
												<option value="125000" />125,000
												<option value="130000" />130,000
												<option value="140000" />140,000
												<option value="150000" />150,000
												<option value="160000" />160,000
												<option value="170000" />170,000
												<option value="175000" />175,000
												<option value="180000" />180,000
												<option value="190000" />190,000
												<option value="200000" />200,000
												<option value="210000" />210,000
												<option value="220000" />220,000
												<option value="230000" />230,000
												<option value="240000" />240,000
												<option value="250000" />250,000
												<option value="260000" />260,000
												<option value="270000" />270,000
												<option value="280000" />280,000
												<option value="290000" />290,000
												<option value="300000" />300,000
												<option value="325000" />325,000
												<option value="350000" />350,000
												<option value="375000" />375,000
												<option value="400000" />400,000
												<option value="425000" />425,000
												<option value="450000" />450,000
												<option value="475000" />475,000
												<option value="500000" />500,000
												<option value="550000" />550,000
												<option value="600000" />600,000
												<option value="650000" />650,000
												<option value="700000" />700,000
												<option value="800000" />800,000
												<option value="900000" />900,000
												<option value="1000000" />1,000,000
												<option value="1500000" />1,500,000
												<option value="2000000" />2,000,000
												<option value="3000000" />3,000,000
												<option value="" />Min
											</select> <select class="span1 pull-right"
												style="width: 68px;">
												<option selected="selected" value="" />Max
												<option value="50000" />50,000
												<option value="60000" />60,000
												<option value="70000" />70,000
												<option value="80000" />80,000
												<option value="90000" />90,000
												<option value="100000" />100,000
												<option value="110000" />110,000
												<option value="120000" />120,000
												<option value="125000" />125,000
												<option value="130000" />130,000
												<option value="140000" />140,000
												<option value="150000" />150,000
												<option value="160000" />160,000
												<option value="170000" />170,000
												<option value="175000" />175,000
												<option value="180000" />180,000
												<option value="190000" />190,000
												<option value="200000" />200,000
												<option value="210000" />210,000
												<option value="220000" />220,000
												<option value="230000" />230,000
												<option value="240000" />240,000
												<option value="250000" />250,000
												<option value="260000" />260,000
												<option value="270000" />270,000
												<option value="280000" />280,000
												<option value="290000" />290,000
												<option value="300000" />300,000
												<option value="325000" />325,000
												<option value="350000" />350,000
												<option value="375000" />375,000
												<option value="400000" />400,000
												<option value="425000" />425,000
												<option value="450000" />450,000
												<option value="475000" />475,000
												<option value="500000" />500,000
												<option value="550000" />550,000
												<option value="600000" />600,000
												<option value="650000" />650,000
												<option value="700000" />700,000
												<option value="800000" />800,000
												<option value="900000" />900,000
												<option value="1000000" />1,000,000
												<option value="1500000" />1,500,000
												<option value="2000000" />2,000,000
												<option value="3000000" />3,000,000
												<option value="" />Max
											</select>
										</div>
									</div>
								</div>


							</div>

						</div>
						<div class="row">

							<div class="span2 pull-right" style="margin-top: 10px;">
								<button class="btn btn-primary pull-right" type="submit">Search</button>

							</div>
						</div>

					</div>

				</fieldset>
				</form>
			</div>
		</div>
	</div>

	<div class="span8">


		<div class="row">
			<h4 class="span7 well" style="width: 580px">Premium properties</h4>
			<div class="span8 premium_properties">
				<ul class="thumbnails">
					
					<li class="span2 premium_property" data-text="Featured">
						<div class="thumbnail">
							<a href="property.html"><img width="192"
								src="css/images/premium/premium_1.jpg" alt="" /></a>
							<h3>Price : &pound;3,350,000</h3>
							<p>
								<a href="property.html">7 bedroom house</a><br />The Vineyard,
								Richmond, TW10
							</p>
						</div>

						<div id="Badger" class="badger-outter">
							<div class="badger-inner">
								<p id="Badge" class="badger-badge badger-text">special offer</p>
							</div>
						</div>
					</li>

					<li class="span2 premium_property" data-text="Featured">
						<div class="thumbnail">
							<a href="property.html"><img width="192"
								src="css/images/premium/premium_1.jpg" alt="" /></a>
							<h3>Price : &pound;3,350,000</h3>
							<p>
								<a href="property.html">7 bedroom house</a><br />The Vineyard,
								Richmond, TW10
							</p>
						</div>
					</li>

					<li class="span2 premium_property" data-text="Premium">
						<div class="thumbnail">
							<a href="property.html"><img width="192"
								src="css/images/premium/premium_2.jpg" alt="" /></a>
							<h3>Price : &pound;229,950</h3>
							<p>
								<a href="property.html">1 bedroom flat</a><br />Lower Mortlake
								Road, North Sheen
							</p>
						</div>
					</li>

					<li class="span2 premium_property" data-text="Offers availiable">
						<div class="thumbnail">
							<a href="property.html"><img width="192"
								src="css/images/premium/premium_3.jpg" alt="" />
							</a>
							<h3>Price : &pound;520,000</h3>
							<p>
								<a href="property.html">2 bedroom apartment</a><br />Mount
								Ararat Road, Richmond
							</p>
						</div>
						<a href="property.html">
						<div id="Badger" class="badger-outter">
							<div class="badger-inner">
								
									<p id="Badge" class="badger-badge badger-text">special offer</p>
								
							</div>
						</div>
						</a>

					</li>

				</ul>
			</div>
		</div>

		<div class="row">
			<div class="span4 select_height">Showing 1 - 10 of 255 results</div>
			<div class="pull-right">
				Sort by : <select id="sort" name="sort" class="span2">
					<option value="pmrank" />Popularity
					<option value="price" />Price: Low to High
					<option value="-price" />Price: High to Low
				</select>
			</div>
		</div>

		<div class="row premium">
			<div class="span2">
				<a href="property.html" class="thumbnail "><img alt=""
					src="assets/web/images/houses/house_1.jpg" /></a>
				<h5>Guide price: &pound;3,350,000</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			
			<div class="span6">
				<a href="property.html"><h3>7 bedroom house for sale The Vineyard,
						Richmond, TW10</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
			
		</div>
		<hr />
		<div class="row ">
			<div class="span2">
				<a href="property.html" class="thumbnail <br  /> <b>Notice</b>:
				Undefined index: type in <b>C:\wamp\www\templates\real_estate\body\listings.php</b>
				on line <b>126</b><br /> "><img alt=""
					src="css/images/houses/house_2.jpg" /></a>
				<h5>Guide price: &pound;229,950</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			<div class="span6">
				<a href="property.html"><h3>1 bedroom flat for sale Lower Mortlake
						Road, North Sheen</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
		</div>
		<hr />
		<div class="row ">
			<div class="span2">
				<a href="property.html" class="thumbnail property_sold"
					style="position: relative;"><img alt=""
					src="<?php echo base_url()?>assets/web/images/houses/house_3.jpg" /></a>
				<h5>Guide price: &pound;520,000</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			<div class="span6">
				<a href="property.html"><h3>2 bedroom apartment for sale Mount
						Ararat Road, Richmond</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
		</div>
		<hr />
		<div class="row ">
			<div class="span2">
				<a href="property.html" class="thumbnail <br  /> <b>Notice</b>:
				Undefined index: type in <b>C:\wamp\www\templates\real_estate\body\listings.php</b>
				on line <b>126</b><br /> "><img alt=""
					src="css/images/houses/house_4.jpg" /></a>
				<h5>Guide price: &pound;550,000</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			<div class="span6">
				<a href="property.html"><h3>2 bedroom house for sale The Shakespeare</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
		</div>
		<hr />
		<div class="row ">
			<div class="span2">
				<a href="property.html" class="thumbnail <br  /> <b>Notice</b>:
				Undefined index: type in <b>C:\wamp\www\templates\real_estate\body\listings.php</b>
				on line <b>126</b><br /> "><img alt=""
					src="css/images/houses/house_5.jpg" /></a>
				<h5>Guide price: &pound;615,000</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			<div class="span6">
				<a href="property.html"><h3>3 bedroom terraced house for sale
						London, TW9</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
		</div>
		<hr />
		<div class="row ">
			<div class="span2">
				<a href="property.html" class="thumbnail property_sold"
					style="position: relative;"><img alt=""
					src="css/images/houses/house_6.jpg" /></a>
				<h5>Guide price: &pound;1,100,000</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			<div class="span6">
				<a href="property.html"><h3>3 bedroom semi-detached house for sale
						Beaumont Avenue, Richmond, Surrey TW9 2HE</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
		</div>
		<hr />
		<div class="row ">
			<div class="span2">
				<a href="property.html" class="thumbnail <br  /> <b>Notice</b>:
				Undefined index: type in <b>C:\wamp\www\templates\real_estate\body\listings.php</b>
				on line <b>126</b><br /> "><img alt=""
					src="css/images/houses/house_7.jpg" /></a>
				<h5>Guide price: &pound;399,950</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			<div class="span6">
				<a href="property.html"><h3>2 bedroom flat for sale The Lodge,
						Courtlands, Sheen Road, Richmond</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
		</div>
		<hr />
		<div class="row ">
			<div class="span2">
				<a href="property.html" class="thumbnail <br  /> <b>Notice</b>:
				Undefined index: type in <b>C:\wamp\www\templates\real_estate\body\listings.php</b>
				on line <b>126</b><br /> "><img alt=""
					src="css/images/houses/house_8.jpg" /></a>
				<h5>Guide price: &pound;219,950</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			<div class="span6">
				<a href="property.html"><h3>1 bedroom flat for sale Sheen Road,
						Richmond, Surrey, TW9</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
		</div>
		<hr />
		<div class="row ">
			<div class="span2">
				<a href="property.html" class="thumbnail <br  /> <b>Notice</b>:
				Undefined index: type in <b>C:\wamp\www\templates\real_estate\body\listings.php</b>
				on line <b>126</b><br /> "><img alt=""
					src="css/images/houses/house_9.jpg" /></a>
				<h5>Guide price: &pound;1,250,000</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			<div class="span6">
				<a href="property.html"><h3>5 bedroom flat for sale Chelwood Gardens</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
		</div>
		<hr />
		<div class="row ">
			<div class="span2">
				<a href="property.html" class="thumbnail <br  /> <b>Notice</b>:
				Undefined index: type in <b>C:\wamp\www\templates\real_estate\body\listings.php</b>
				on line <b>126</b><br /> "><img alt=""
					src="css/images/houses/house_10.jpg" /></a>
				<h5>Guide price: &pound;435,000</h5>
				<h6>Bedrooms: 6</h6>
				<h6>Days on site: 4</h6>
				<h6>Sqft: 2,325</h6>
			</div>

			<div class="span6">
				<a href="property.html"><h3>4 bedroom house for sale Lower Mortlake
						Road, Richmond, TW9</h3></a>
				<p>One of the finest and most elegant houses in South West London -
					This exceptional example of William and Mary architecture
					positioned centrally in Richmond has been extended at various times
					over the last 300 years and now provides the perfect cohesion of
					traditional and contemporary design.</p>
				<p>
					<a href="#">More details, 14 photos, floorplan and brochure</a> | <a
						href="#">Save property</a> | <a href="#">Contact agent</a> | <a
						href="#">Upgrade listing</a>
				</p>
				<p>
					Marketed by Knight Frank, Richmond. Telephone: 0843 314 8224 <a
						href="#">BT 4p/min</a>
				</p>
			</div>
		</div>
		<hr />



		<div class="pagination">
			<ul>
				<li><a href="#">Prev</a></li>
				<li class="active"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">6</a></li>
				<li><a href="#">7</a></li>
				<li><a href="#">8</a></li>
				<li><a href="#">9</a></li>
				<li><a href="#">10</a></li>
				<li><a href="#">Next</a></li>
			</ul>
		</div>

	</div>

</div>