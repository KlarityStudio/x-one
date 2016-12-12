<?php get_header(); ?>

<!-----start-wrap--------->
	<div class="wrap">
		<!-----start-content--------->
		<div class="content">
			<!-----start-logo--------->
			<div class="page-logo">
				<h1><a href="#"><img src="/wp-content/themes/kommerce/_build/icons/404logo.png"/></a></h1>
				<span><img src="/wp-content/themes/kommerce/_build/images/signal.png"/>Oops! The Page you requested was not found!</span>
			</div>
			<!-----end-logo--------->
			<!-----start-search-bar-section--------->
			<div class="buttom">
				<div class="seach_bar">
					<p>you can go to <span><a href="<?php echo site_url(); ?>">home</a></span> page or search here</p>
					<!-----start-sear-box--------->
					<div class="search_box">
					<form>
					   <input type="text" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}"><input type="submit" value="">
				    </form>
					 </div>
				</div>
			</div>
			<!-----end-sear-bar--------->
		</div>
		<!----copy-right-------------->
	</div>

	<!---------end-wrap---------->
<?php get_footer(); ?>
