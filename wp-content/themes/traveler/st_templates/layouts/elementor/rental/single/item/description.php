<div class="accordion-item">
	<h2 class="st-heading-section" id="headingDescription">
	<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescription" aria-expanded="true" aria-controls="collapseDescription">
		<?php echo esc_html__( 'Description', 'traveler' ) ?>
	</button>
	</h2>
	<div id="collapseDescription" class="accordion-collapse collapse show" aria-labelledby="headingDescription" data-bs-parent="#headingDescription">
		<div class="accordion-body">
			<div class="st-description" data-toggle-section="st-description">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</div>
