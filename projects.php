<?php
define('IN_SITE', true);
require 'common.php';
require 'header.php';
?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<h2>Project Process</h2>
			<p>ACM follows a three-phase approach to establishing projects. 
			First, there is the <strong>Proposal phase</strong> where a 
			project idea is presented to the project manager for incubation
			approval.  Second, is the <strong>Incubation phase</strong> where
			the project idea is placed under discussion while potential
			developers commit to the project. Finally, the <strong>Active
			phase</strong> is where the project is under development.</p>

			<div class="spanner">
				<img src="images/project_tpa_small.png" title="Project
				Three-Phase Approach" />
			</div>

			<p>Each project has a contact whom can provide further details. If 
			contact information is not provided, please contact the current 
			project manager, Gio Borje for details about the project. If 
			instead, you wish to propose a project for ACM, use the form below 
			or simply contact the project manager, Gio Borje.</p>
		</div>	

		<div class="content-block">
			<div id="projects-incubator">
				<h2>Incubator</h2>
				<div class="project">
					<h3>Duracell Powermat</h3>
					<footer>
						<dl>
							<dt>Contact Name</dt>
							<dd>Frank Williams</dd>
						</dl>
					</footer>
					<p>Develop a mobile application to that marks the nearest 
					wireless charging location in UC Irvine.</p>
					
					<footer><strong>Committed Members:</strong> Kusum 
					Kumar</footer>
				</div>

				<h2>Project Proposal</h2>
				<form id="new-project" action="projects.php" method="POST">
					<p>
						<label for="name">Project Name</label><br />
						<input name="name" type="text"  required/>
					</p>
					<p>
						<label for="contact_name">Contact Name</label><br />
						<input name="contact_name" type="text" required/>
					</p>
					<p>
						<label for="contact_email">Contact Email</label><br />
						<input name="contact_email" type="email" required/>
					</p>
					<p>
						<label for="desc">Description</label><br />
						<textarea name="desc" required></textarea>
					</p>
					<p>
						<input type="submit" name="submit" value="Submit" />
					</p>
				</form>
			</div>

			<div id="projects-active">
				<h2>Active</h2>
				<div class="project">
					<h3>acmuci.com Website</h3>
					<footer>
						<dl>
							<dt>Contact Name</dt>
							<dd>Gio Borje</dd>
							<dt>Contact Email</dt>
							<dd>gborje@uci.edu</dd>
						<dl>
					</footer> 
					<p>Contribute to the development of this website! Each
					year, ACM's UC Irvine Chapter will participate in the ACM
					Student Chapter Excellence Awards to win the Outstanding
					Chapter Website award.</p>
				</div>

				<div class="project">
					<h3>AllUnit</h3>
					<footer>
						<dl>
							<dt>Contact name</dt>
							<dd>Cameron Samak</dt>
						</dl>
					</footer>
					<p>Tailored to university professors and students, the
					project will simplify operations based on examination of
					existing processes. This includes actions such as assigning
					grades and checking for plagiarism across all
					submissions.</p>

					<footer><strong>Committed Members:</strong> Gio Borje, 
					Ivan Check, Huy Vuong</footer>
				</div>
			</div>
		</div>
	</div>
</section>

<?php require 'footer.php'; ?>
