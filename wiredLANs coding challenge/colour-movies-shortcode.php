<?php // shortcode: colour movies

function colour_movies() {
?>
<div class="row">
	<div id="sorter" class="col-12">
	<label>Sort</label>
		<select id="movie-sorter">
			<option value="">---</option>
			<option value="title">By Title</option>
			<option value="year">By Year</option>
			<option value="rating">By Rating</option>
		</select>
	</div> 
		<hr/>
	</div>
<div class="row movies">
<?php
$colors = array(
    'blue',
    'green',
    'red',
    'yellow'
);
// search for each colour
foreach ($colors as $color)
{
    $json = file_get_contents('http://www.omdbapi.com/?s=' . $color . '&apikey=876118b7');
    $movies = json_decode($json, true);

    //print_r($movies['Search']);
    foreach ($movies['Search'] as $movie)
    {
        // movie details pulled from search
        $title = $movie['Title'];
		$title_lc = strtolower($title);
        $poster = $movie['Poster'];
        $year = $movie['Year'];
        $id = $movie['imdbID'];

        // new search based on movie id
        $id_json = file_get_contents('http://www.omdbapi.com/?i=' . $id . '&apikey=876118b7');
        $details = json_decode($id_json, true);

        //print_r($details);
        // details from the movie id search not available in search api
        $plot = $details['Plot'];
        $runtime = $details['Runtime'];
        $tomatoes = $details['Ratings'][1]['Value'];
		$tomatoes_dec = floatval($tomatoes) / 100.00;
	?>  <!-- wrap each movie with the imdbID, class of relevant colour, and data attributes -->
        <div id="<?php echo $id ?>" class="movie col-12 col-sm-6 <?php
        // adds matching colour as class to wrapper
        if (preg_match('/\b' . $color . '\b/', $title_lc))
        {
            echo $color;
        }?>" data-movie-title="<?php echo $title ?>" data-movie-tomato="<?php echo $tomatoes_dec ?>" data-movie-runtime="<?php echo $runtime ?>" data-movie-year="<?php echo $year ?>">
			<div class="wrap-content row">
				<!-- get movie poster -->
				<div class="img-wrap col-12 col-lg-6">
					<img src="<?php echo $poster ?>" alt="<?php echo $title ?>"/>
				</div>
			<div class="details col-12 col-lg-6">
				<!-- show movie title -->
				<h3><?php echo $title ?></h3>
				<!-- show movie year -->
				<p><strong><?php echo $year ?></strong></p>
				<!-- show movie rt ranking (if available) -->
				<p>
				<?php //check to see if rotten tomatoes ranking is not empty
				if ( !empty( $tomatoes ) ){ 
					// show splat if "rotten"		
					if ($tomatoes_dec < "0.60") {
						echo '<i class="fas fa-splotch rotten" title="Rotten Tomatoes Rating"></i> ';	
					} 
					// show tomato if "fresh"		
					elseif ($tomatoes_dec >= "0.60") {	
						echo '<i class="fas fa-circle fresh" title="Rotten Tomatoes Rating"></i> ';	
					}
				echo $tomatoes ;
					}?></p>
				<!-- show movie runtime -->
				<p><i class="far fa-clock"></i> <?php echo $runtime ?></p>
				<!-- show movie plot summary -->
				<p><?php echo $plot ?></p>
				</div>
			</div>
		</div>
	<?php ;

    }

}?>
</div>
<?php
}

add_shortcode('colourmovies', 'colour_movies');

?>