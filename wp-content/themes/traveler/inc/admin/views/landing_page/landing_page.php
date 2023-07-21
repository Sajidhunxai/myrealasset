<?php 

	wp_enqueue_style( 'landing_page_css' );

	wp_enqueue_script( 'landing_page_js' );

?>

<?php 

	$page = STInput::request('page') ; 

?>



<div class='st_landing_page'>

	<header>

		<h1><?php echo __("Welcome to Traveler!" , 'traveler')  ;?></h1>

	</header>

	<section>

		<section class='about_text'>

			<?php 

			$video_link = "";

			echo __("Traveler is now installed and ready to use!  Get ready to build something beautiful. Please register your purchase to get support and automatic theme updates. Read below for additional information. We hope you enjoy it!", 'traveler') ; ?> 
		</section>

		<section class='logo'>

			<img height = "" width ="140px" src="

				<?php 

					echo get_template_directory_uri()."/img/logo.png";

				?>

				" alt="<?php echo TravelHelper::get_alt_image(); ?>"/>

				<p class="version">

					<?php 

						$theme = wp_get_theme();

						echo __("Version " , 'traveler') ; 

						echo balancetags($theme->version );

					?>

				</p>

		</section>

		<section>

			<h2 class="nav-tab-wrapper">

				<?php

					

					$menu = (STAdminlandingpage::sub_menu_list());

					if(!empty($menu) and is_array($menu)){

						foreach ($menu as $key => $value) {

							$link = admin_url('/admin.php?page='.$value['menu_slug']);

							$title = $value['page_title'];

							$active = "";

							if($page == $value['menu_slug']){

								$active = "nav-tab-active";

								$link = " # ";

							}

							?>

							<a class ="st-nav-tab nav-tab <?php echo balancetags($active);?> " href="<?php echo balancetags($link);?>"><?php echo balancetags($title);?></a>

							<?php 

						}

					}					

				?>	    		

    		</h2>

		</section>

		<section class='landing_page_content'>

			<?php 

				echo balanceTags( $this->load_view('landing_page/landing_page' , STInput::request('page')));

			?>

			<div class="traveler-thanks">

		        <p class="description">

                    <?php echo __("Thank you for choosing traveler. We are honored and are fully dedicated to making your experience perfect.", 'traveler') ; ?>

                    View <a href="https://travelerwp.com/traveler-changelog/"><?php echo __('Change Log', 'traveler'); ?></a>

                </p>

		    </div>

		</section>

	</section>

	



</div>