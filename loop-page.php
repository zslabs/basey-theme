<?php

while (have_posts()) : the_post();
	echo basey_single_default();
endwhile;