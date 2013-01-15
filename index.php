<?php
define('IN_SITE', true); 
require_once 'common.php';
require_once 'header.php'; 
?>

<section id="content" class="home">
	<div class="inner">
		<div id="events-stream">
			<?php include 'mod/events/events.php'; ?>
		</div>

		<div id="main-stream">
			<h2>Competitions</h2>
			<p>Our active competition participants train rigorously to compete
			in nationally renown competitions such as those listed below.
			Contact Kenny Baldauf, the current Competitions Coordinator, to get
			involved in competitions.</p>
			<div class="collection">
				<article>
					<footer>October 20</footer>
					<h3><a
					href="http://www.ieee.org/membership_services/membership/students/competitions/xtreme/index.html"
					title="IEEEXtreme" target="_blank">IEEEXtreme</a></h3>
					<p>The longest programming competition with a 24-hour
					duration.</p>
				</article>

				<article>
					<footer>November 10</footer>
					<h3><a href="http://icpc.baylor.edu/"
					title="ICPC" target="_blank">ICPC</a></h3>
					<p>The Intercollegiate Programming Competition is a
					team-based programming competition for five hours.</p>
				</article>
				
				<article>
					<footer>February</footer>
					<h3><a href="https://www.hackerrank.com/backtoschool"
					title="HackerRank Back to School Competition" target="_blank">HackerRank</a></h3>
					<p>Web-based AI challenge. Cash prizes are up to $2k and the top 10 hackers win an all expenses paid-trip to Silicon Valley.</p>
				</article>
			</div>

			<h2>Projects</h2>
			<p>We support the development of ambitious students by providing
			tools necessary to establish projects and find other students to
			collaborate with.</p>

			<img class="left c4" src="images/flask_128.png" />
			<p class="left c4">Have an idea that you need help with? Pitch your
			idea to Gio Borje and we'll throw it into our incubator.</p>

			<img class="left c4" src="images/blueprint_128.png" />
			<p class="left c4">Looking to contribute to other projects?  See <a
			href="http://redmine.acmuci.com/">our projects group</a> for a list
			of ongoing projects by our members.</p>
		</div>
	</div>
</section>

<?php require_once 'footer.php'; ?>
